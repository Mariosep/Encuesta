<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<script src="guardaRespuestas.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="guardaRespuestas.css">
</head>

<?php
/*$arr = get_defined_vars();
print_r($arr["_POST"]);*/

session_start();

$user="root";
$password="";
$database="encuesta";

$mysqli = mysqli_connect("localhost", $user, $password, $database)
or die ("Error al acceder a la base de datos");

if(isset($_POST['select-asignatura']) && !$_SESSION['es_terminada']){

$coincide = Comprueba_AsigProf($mysqli);

if ($coincide){

	$date = $_SESSION['date'];
	$query = "UPDATE encuesta SET fecha_fin = CURRENT_TIME(), es_terminada = 1 WHERE fecha_init = '$date'";
	mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al actualizar la encuesta");
	$_SESSION['es_terminada'] = 1;

	$query = "SELECT max(id_encuesta) 'id_encuesta' FROM encuesta";
	$id_encuesta = mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al seleccionar id_encuesta");
	$id_encuesta = mysqli_fetch_row($id_encuesta);

	$query = "SELECT id_preg_us FROM preguntasus";
	$id_preg_us = mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al seleccionar total de pregUs");
	
	$asignatura = $_POST['select-asignatura'];
	foreach ($id_preg_us as $key) {
		$resp = $_POST[$key['id_preg_us']."-us"];
		/*echo "<br>";
		echo $id_encuesta[0]." ";
		echo $i." ";
		echo $resp." ";*/
		$query = "INSERT INTO respuestasus (id_encuesta, id_asignatura, id_preg_us, respuesta) VALUES (".$id_encuesta[0].", ".$asignatura.", ".$key['id_preg_us'].", ".$resp.")";
		mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al insertar respuestasus");
	}

		$query = "SELECT id_preg_prof FROM preguntasprof";
		$id_preg_prof= mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al seleccionar total de pregProf");

		
		for($nprof=1; $nprof<=3; $nprof++){
			if ($_POST['prof-'.$nprof] != 0){
				foreach ($id_preg_prof as $key) {
					$id_prof = $_POST['prof-'.$nprof];
					$resp = $_POST[$key['id_preg_prof']."-prof-".$nprof];
					/*echo "<br>";
					echo $id_encuesta[0]." ";
					echo $id_prof." ";
					echo $i." ";
					echo $resp." ";*/
					$query = "INSERT INTO respuestasprof (id_encuesta, id_asignatura, id_profesor, id_preg_prof, respuesta) VALUES (".$id_encuesta[0].", ".$asignatura.", ".$id_prof.", ".$key['id_preg_prof'].", ".$resp.")";
					mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al insertar respuestasprof");
				}
			}
		}
	}
	else{
		echo "El profesor no pertenece a la asignatura";
	}
}


BorrarEncuestasNulas($mysqli);
BorrarEncuestasNoValidas($mysqli);


function Comprueba_AsigProf($mysqli){
	$asignatura = $_POST['select-asignatura'];
	for($i=1; $i<=3; $i++){
		$id_prof = $_POST['prof-'.$i];
		if ($id_prof != 0){
			$query =  "SELECT 'count(*)' FROM asignaturaprofesor WHERE id_asignatura = ".$asignatura." and id_profesor = ".$id_prof;
			$pertenece = mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al buscar coincidencias asignaturaprofesor");
			if(!isset($pertenece)){
				return 0;
			}
		}	
	}
	return 1;
}

function BorrarEncuestasNulas($mysqli){

	$query = "SELECT * FROM encuesta WHERE es_terminada = 0";
	$encuestas = mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al seleccionar encuestas nulas");
	foreach ($encuestas as $key) {
		date_default_timezone_set('Europe/Madrid');
		$f_init = date_create($key['fecha_init']);
		$f_actual = date_create(date('Y-m-d H:i:s'));
		
		$f_max = date_add( $f_init, date_interval_create_from_date_string('15 minutes'));

		if ($f_actual > $f_max){
			$query = "DELETE FROM encuesta WHERE id_encuesta = ".$key['id_encuesta'];
			$encuestas = mysqli_query($mysqli, $query) or die("Fallo al eliminar encuestas nulas");
		}
	}
}

function BorrarEncuestasNoValidas($mysqli){

	$query = "SELECT * FROM encuesta WHERE es_terminada = 1";
	$encuestas = mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al seleccionar encuestas nulas");
	foreach ($encuestas as $key) {
		date_default_timezone_set('Europe/Madrid');
		$f_init = date_create($key['fecha_init']);
		$f_fin = date_create($key['fecha_fin']);
		
		$f_min = date_add( $f_init, date_interval_create_from_date_string('1 minutes'));

		if ($f_fin < $f_min){
			$query = "DELETE FROM encuesta WHERE id_encuesta = ".$key['id_encuesta'];
			$encuestas = mysqli_query($mysqli, $query) or die("Fallo al eliminar encuestas nulas");
		}
	}
}

?>


<body onload="nobackbutton();">
	<section>
		<h3>Encuesta registrada con éxito</h3>
	</section>
</body>

</html>