<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="guardaRespuestas.css">
</head>

<?php
$arr = get_defined_vars();
print_r($arr["_POST"]);

session_start();

$user="root";
$password="";
$database="encuesta";

$mysqli = mysqli_connect("localhost", $user, $password, $database)
or die ("Error al acceder a la base de datos");

if(isset($_POST['select-asignatura']) && !$_SESSION['isset']){
		$date = $_SESSION['date'];
		$query = "INSERT INTO encuesta (fecha_init, fecha_fin, es_terminada) VALUES('$date', CURRENT_TIME(), 1)";
		mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al actualizar la encuesta");

		$query = "SELECT max(id_encuesta) 'id_encuesta' FROM encuesta";
		$id_encuesta = mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al seleccionar id_encuesta");
		$id_encuesta = mysqli_fetch_row($id_encuesta);

		$query = "SELECT count(id_preg_us) 'n_pregUs' FROM preguntasus";
		$n_pregUs = mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al seleccionar total de pregUs");
		$n_pregUs = mysqli_fetch_assoc($n_pregUs);

		for($i=1; $i<=(int)$n_pregUs['n_pregUs']; $i++){
			$resp = $_POST[$i."-us"];
			/*echo "<br>";
			echo $id_encuesta[0]." ";
			echo $i." ";
			echo $resp." ";*/
			$query = "INSERT INTO respuestasus (id_encuesta, id_preg_us, respuesta) VALUES (".$id_encuesta[0].", ".$i.", ".$resp.")";
			mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al insertar respuestasus");
		}

		$query = "SELECT count(id_preg_prof) 'n_pregProf' FROM preguntasprof";
		$n_pregProf = mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al seleccionar total de pregProf");
		$n_pregProf = mysqli_fetch_assoc($n_pregProf);

		$asignatura = $_POST['select-asignatura'];
		for($nprof=1; $nprof<=3; $nprof++){
			if ($_POST['prof-'.$nprof] != 0){
				for($i=1; $i<=(int)$n_pregProf['n_pregProf']; $i++){
					$id_prof = $_POST['prof-'.$nprof];
					$resp = $_POST[$i."-prof-".$nprof];
					/*echo "<br>";
					echo $id_encuesta[0]." ";
					echo $id_prof." ";
					echo $i." ";
					echo $resp." ";*/
					$query = "INSERT INTO respuestasprof (id_encuesta, id_asignatura, id_profesor, id_preg_prof, respuesta) VALUES (".$id_encuesta[0].", ".$asignatura.", ".$id_prof.", ".$i.", ".$resp.")";
					mysqli_query($mysqli,  utf8_decode($query))or die("Fallo al insertar respuestasprof");
				}
			}
		}

		$_SESSION['isset'] = true;
	}

?>


<body>
<section>
	<h3>Encuesta registrada con éxito</h3>
</section>
</body>

</html>