<!DOCTYPE html>

<html>

<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
	<script src="encuestaBD.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="encuesta.css">
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

		<div class="col-5">
			<h5>ENCUESTA DE OPINIÓN DE LOS/AS ESTUDIANTES<br>
			SOBRE LA LABOR DOCENTE DEL PROFESORADO</h5>
		</div>

		<div class="col-4">
			<h4 id="login"> 
				<a href="Login/index.html">Iniciar sesión</a> 
			</h4>
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


$query = "SELECT * FROM tiposubtipo"; 
$tiposubtipo = mysqli_query($mysqli, $query) or die("Fallo al seleccionar tiposubtipo");

$query = "SELECT * FROM preguntasprof"; 
$preguntasprof = mysqli_query($mysqli, $query) or die("Fallo al seleccionar preguntasprof");

$query = "SELECT * FROM tiposubtipopregprof"; 
$tiposubtipopregprof = mysqli_query($mysqli, $query) or die("Fallo al seleccionar tiposubtipopregprof");

$query = "SELECT * FROM respuestasprof"; 
$respuestasprof = mysqli_query($mysqli, $query) or die("Fallo al seleccionar respuestasprof");

date_default_timezone_set('Europe/Madrid');
session_start();
$_SESSION['date'] = date('Y-m-d H:i:s');
$_SESSION['isset'] = false;
?>


<form name="encuesta"  action = "guardaRespuestas.php" method="POST">
	<div class="row">
		<div class="col-3">
			<h6 id="title-asignatura">ASIGNATURA</h6>
			<select name="select-asignatura" id="select-asignatura">
				<?php
				echo "<option value='0'> --- </option>";
				foreach ($asignatura as $key) {
					$id_asignatura = utf8_encode($key["id_asignatura"]);
					$nombre = utf8_encode($key["nombre"]);
					echo "<option value=".$id_asignatura.">".$nombre."</option>";
				}
				?>
			</select>

			<p id= "descripción">A continuación se presentan una serie de cuestiones relativas a la docencia en esta asignatura. Tu colaboración es necesaria y consiste en señalar en la escala de respuesta tu grado de acuerdo con cada una de las afirmaciones, teniendo en cuenta que <b>"1"</b> significa <b>"totalmente en desacuerdo"</b> y <b>"5" "totalmente de acuerdo"</b>. Si el enunciado no procede o no tienes suficiente información, marca la opcion NS. <b>En nombre de la Universidad de Cádiz, GRACIAS POR TU PARTICIPACIÓN</b>.</p>

		</div>
		<div class="col-8">
			<h6 id="title-pregUs">INFORMACIÓN PERSONAL Y ACADÉMICA DE LOS ESTUDIANTES</h6>
			<div class="preguntas-us">
				<table>
					<?php
					foreach ($preguntasus as $key) {
						$enunciado = utf8_encode($key["enunciado"]);
						$op_respuesta = explode("&",utf8_encode($key["op_respuesta"]));


						echo "<div class='pregunta'>
						<tr>
						<th class='enunciado-us'>
						".$enunciado."	
						</th>";

						for ($i = 0; $i < count($op_respuesta); $i++) {
							echo   "<th class='respuesta-us'>
							<input type='radio' name=".utf8_encode($key["id_preg_us"])."-us value=".$i." > ".$op_respuesta[$i]."
							</th>";
						}

						echo "	</tr>
						</div>";							
					}
					?>
				</table>
			</div>
			</div>

			<div  id="select-prof">
				<h6 id="title-profesores">PROFESORES</h6>
				<?php
				for ($i=1; $i <= 3; $i++) { 
					echo "<select name='prof-".$i."'>";
					echo "<option value='0'> --- </option>";
					foreach ($profesor as $prof) {
						$id_profesor = utf8_encode($prof["id_profesor"]);
						$nombre = utf8_encode($prof["nombre"]);
						$apellidos = utf8_encode($prof["apellidos"]);

						echo "<option value=".$id_profesor.">".$nombre." ".$apellidos."</option>";
					}
					echo "</select>";
				}		


				?>
			</div>

			<div class="row">
				<table class="valoraciones-prof">
					<?php

					for ($x=0; $x<mysqli_num_rows($tipopreguntaprof); $x++) {
						$key = mysqli_fetch_assoc($tipopreguntaprof);
						$cod_tip = utf8_encode($key["cod_tip"]);
						$nombre_tipo = utf8_encode($key["nombre_tipo"]);

						$query = "SELECT cod_sub_tip FROM tiposubtipo WHERE cod_tip = ".$cod_tip;
						$cod_sub_tip = mysqli_query($mysqli, $query) or die("Fallo al buscar código subtipo");

						echo "<tr>
						<th>
						<h6 class='title-topic'>".$nombre_tipo."</h6>";
						if(mysqli_num_rows($cod_sub_tip) > 0){
							for($i = 0; $i < mysqli_num_rows($cod_sub_tip); $i++){

								$res = mysqli_fetch_row($cod_sub_tip);

								$query = "SELECT * FROM subtipopreguntaprof WHERE cod_sub_tip = ".utf8_encode($res[0]);
								$subtipopreguntaprof = mysqli_query($mysqli, $query) or die("Fallo al buscar subtipo");

								$subtipo = mysqli_fetch_assoc($subtipopreguntaprof);

								if ($i == 0)
									echo "<h7 class='title-subtopic'>".utf8_encode($subtipo["nombre_subtipo"])."</h7> <br>";
								else{
									echo "<tr>
									<th>
									<h7 class='title-subtopic'>".utf8_encode($subtipo["nombre_subtipo"])."</h7> <br>";	
								}

								$query = "SELECT id_preg_prof FROM tiposubtipopregprof WHERE cod_sub_tip = ".utf8_encode($res[0]);
								$cod_preguntas = mysqli_query($mysqli, $query) or die("Fallo al buscar código pregunta");

								for($j = 0; $j < mysqli_num_rows($cod_preguntas); $j++){
									$cod_pregunta = mysqli_fetch_row($cod_preguntas);

									$query = "SELECT * FROM preguntasprof WHERE id_preg_prof =".utf8_encode($cod_pregunta[0]);
									$pregunta = mysqli_query($mysqli, $query) or die("Fallo al buscar pregunta");

									$pregunta = mysqli_fetch_assoc($pregunta);

									if ($j == 0){
										echo "
										<span class='enunciado-prof'>".utf8_encode($pregunta["id_preg_prof"]).". ".utf8_encode($pregunta["enunciado"])."</span>
										</th>";
									}
									else{

										echo "<tr>
										<th>
										<span class='enunciado-prof'>".utf8_encode($pregunta["id_preg_prof"]).". ".utf8_encode($pregunta["enunciado"])."</span>
										</th>";
									}
									$op_respuesta = explode("&",utf8_encode($pregunta["op_respuesta"])); 
									for($nprof = 1; $nprof <= 3; $nprof++){
										for ($z = 0; $z < count($op_respuesta); $z++) {
											echo "<th class='respuesta-prof'>
													<input class='resp-prof-".$nprof."' type='radio' name=".utf8_encode($pregunta["id_preg_prof"])."-prof-".$nprof." value=".$z."> ".$op_respuesta[$z].
												"</th>";
										}
									}

									echo "</tr>";

								}	
							}
						}
						else{
							$query = "SELECT id_preg_prof FROM tiposubtipopregprof WHERE cod_sub_tip is NULL and cod_tip = ".$cod_tip;
							$cod_preguntas = mysqli_query($mysqli, $query) or die("Fallo al buscar código pregunta");
							for($j = 0; $j < mysqli_num_rows($cod_preguntas); $j++){
								$cod_pregunta = mysqli_fetch_row($cod_preguntas);

								$query = "SELECT * FROM preguntasprof WHERE id_preg_prof =".utf8_encode($cod_pregunta[0]);
								$pregunta = mysqli_query($mysqli, $query) or die("Fallo al buscar pregunta");

								$pregunta = mysqli_fetch_assoc($pregunta);
								if($j == 0){
									echo "	<span class='enunciado-prof'>".utf8_encode($pregunta["id_preg_prof"]).". ".utf8_encode($pregunta["enunciado"])."</span>
									  	 </th>";
								}else{
									echo "<tr>
											<th>
										  	<span class='enunciado-prof'>".utf8_encode($pregunta["id_preg_prof"]).". ".utf8_encode($pregunta["enunciado"])."</span>
										  	</th>";
								}
								
								$op_respuesta = explode("&",utf8_encode($pregunta["op_respuesta"])); 
								for($nprof = 1; $nprof <= 3; $nprof++){
									for ($i = 0; $i < count($op_respuesta); $i++) {
										echo "<th class='respuesta-prof'>
													<input class='resp-prof-".$nprof."' type='radio' name=".utf8_encode($pregunta["id_preg_prof"])."-prof-".$nprof." value=".$i."> ".$op_respuesta[$i].
												"</th>";
										echo "</th>";
									}
								}
								echo "</tr>";
							}
						}	
					}
					?>
				</table>
			</div>

				<input type="submit" name="submit" value="Enviar" id="enviar">
		</form>

	</section>

</body>

</html>


<?php
	
?>




