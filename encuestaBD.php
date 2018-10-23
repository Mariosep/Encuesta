<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="encuesta-style.css">
</head>

<?php

	$user="root";
	$password="";
	$database="encuesta";

	$mysqli = mysqli_connect("localhost", $user, $password, $database)
	or die ("Error al acceder a la base de datos");
?>

<body>

<header>
	<div class="row">
		<div class="col-3" id="logo">
			<img src="UcaLogo.png">
		</div>

		<div class="col-4">
			<h5>ENCUESTA DE OPINIÓN DE LOS/AS ESTUDIANTES<br>
			 SOBRE LA LABOR DOCENTE DEL PROFESORADO</h5>
		</div>
	</div>
</header>

<section>

	<?php

		$query = "SELECT * FROM profesor"; 
		$profesor = mysqli_query($mysqli, $query) or die("Fallo al seleccionar profesor");
		
		$query = "SELECT * FROM asignatura"; 
		$asignatura  = mysqli_query($mysqli, $query) or die("Fallo al seleccionar asignaturas");

		$query = "SELECT * FROM asignaturaprofesor";
		$asignaturaprofesor = mysqli_query($mysqli, $query) or die("Fallo al seleccionar asignaturaprofesor");

		$query = "SELECT * FROM encuesta";
		$encuesta = mysqli_query($mysqli, $query) or die("Fallo al seleccionar encuesta");

		$query = "SELECT * FROM preguntasus";
		$preguntasus = mysqli_query($mysqli, $query) or die("Fallo al seleccionar preguntasus");

		$query = "SELECT * FROM respuestasus";
		$respuestasus = mysqli_query($mysqli, $query) or die("Fallo al seleccionar respuestasus");

		$query = "SELECT * FROM tipopreguntaprof"; 
		$tipopreguntaprof = mysqli_query($mysqli, $query) or die("Fallo al seleccionar tipopreguntaprof");

		$query = "SELECT * FROM subtipopreguntaprof"; 
		$subtipopreguntaprof = mysqli_query($mysqli, $query) or die("Fallo al seleccionar subtipopreguntaprof");

		$query = "SELECT * FROM tiposubtipo"; 
		$tiposubtipo = mysqli_query($mysqli, $query) or die("Fallo al seleccionar tiposubtipo");

		$query = "SELECT * FROM preguntasprof"; 
		$preguntasprof = mysqli_query($mysqli, $query) or die("Fallo al seleccionar preguntasprof");

		$query = "SELECT * FROM tiposubtipopregprof"; 
		$tiposubtipopregprof = mysqli_query($mysqli, $query) or die("Fallo al seleccionar tiposubtipopregprof");

		$query = "SELECT * FROM respuestasprof"; 
		$respuestasprof = mysqli_query($mysqli, $query) or die("Fallo al seleccionar respuestasprof");

	/*	foreach ($asignatura as $key) {
			echo utf8_encode($key["nombre"]);
		}*/
		
	?>


	<div class="row">
		<div class="col-4">
			<h6 id="title-asignatura">ASIGNATURA</h6>
			<select>
				<?php
					foreach ($asignatura as $key) {
						$id_asignatura = utf8_encode($key["id_asignatura"]);
						$nombre = utf8_encode($key["nombre"]);
						echo "<option value=".$id_asignatura.">".$nombre."</option>";
					}
			    ?>
			</select>

		</div>
		<div class="col-6">
			<h6 id="title-pregUs">INFORMACIÓN PERSONAL Y ACADÉMICA DE LOS ESTUDIANTES</h6>
			<div class="preguntas-us">
				<form action="">
				  <table>
				  	<?php
					  	foreach ($preguntasus as $key) {
							$enunciado = utf8_encode($key["enunciado"]);
							$op_respuesta = split(utf8_encode($key["op_respuesta"]));


							echo "<div class='pregunta'>
					  				<tr>
					  					<th>
					  						".$enunciado."	
					  					</th>";
					  			
					  		for ($i = 1; $i <= count($op_respuesta); $i++) {
					  			echo   "<th>
					  						<input type='radio' name=".$i." value=".$i.">".$op_respuesta[$i-1]."
					  					</th>";
					  		}

					  		echo "</div>";


							
						}
					?>
				</table>
			</div>
		</div
			
	<div class="row">
		<table class="valoraciones-prof">
		  	<tr>
		  		<th class="enunciado-prof">
			  		<h6 class="title-topic">PLANIFICACIÓN DE LA ENSEÑANZA Y APRENDIZAJE</h6>
			  	  	<span class="enunciado">1. El/la profesor/a informa sobre los distintos aspectos de la guía docente o programa de la asignatura (objetivos, actividades, contenidos del temario, metodología, bibliografía, sistemas de evaluación,...)</span>		
				</th>
				<th>
					NS <input type="radio" name="1" value="1"> 
				</th>
				<th>  
					1 <input type="radio" name="1" value="2"> 
			    </th>
				<th>  
					2  <input type="radio" name="1" value="3">
				</th>
				<th>  
					3  <input type="radio" name="1" value="4">
				</th>
				<th>  
					4  <input type="radio" name="1" value="5">
				</th>
				<th>  
					5  <input type="radio" name="1" value="5">
				</th>
			</tr>
			<tr>
			  	<th class="enunciado-prof">
			  		<h6 class="title-topic">DESARROLLO DE LA DOCENCIA</h6>
	  				<h7 class="title-subtopic">Cumplimiento de las obligaciones docentes (del encargo docente)</h7> <br>
			  	  	<span class="enunciado">2. Imparte las clases en el horario fijado</span>		
				</th>
				<th>
					NS <input type="radio" name="1" value="1"> 
				</th>
				<th>  
					1 <input type="radio" name="1" value="2"> 
			    </th>
				<th>  
					2  <input type="radio" name="1" value="3">
				</th>
				<th>  
					3  <input type="radio" name="1" value="4">
				</th>
				<th>  
					4  <input type="radio" name="1" value="5">
				</th>
				<th>  
					5  <input type="radio" name="1" value="5">
				</th>
			</tr>
		</table>
	</div>
</section>

</body>

</html>

