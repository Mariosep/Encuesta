<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="encuesta.css">
</head>

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
		<div class="row">
			<div class="col-3">
				<h6>ASIGNATURA</h6>
				<select>
			    	<option value="1">Matemática Discreta</option>
				    <option value="2">Introducción a la Programación</option>
				    <option value="3">Álgebra</option>
				</select>

			</div>
			<div class="col-6">
				<h6 id="txt-pregUs">INFORMACIÓN PERSONAL Y ACADÉMICA DE LOS ESTUDIANTES</h6>
				<div class="preguntas-us">
					<form action="">
					  <table>
					  	<div class="pregunta">
						  	<tr>
						  		<th>
						  			Edad (años)	
						  		</th>
							  	<th>	
								  <input type="radio" name="1" value="1"> <=19
								</th>
								<th>
								  <input type="radio" name="1" value="2"> 20-21
							    </th>
								<th>
								  <input type="radio" name="1" value="3"> 22-23
								</th>
								<th> 
								  <input type="radio" name="1" value="4"> 24-25
								</th>
								<th>
								  <input type="radio" name="1" value="5"> >25
								</th>
							</tr>
						</div>

						<div class="pregunta">
						  	<tr>
						  		<th>
						  			Edad (años)	
						  		</th>
							  	<th>	
								  <input type="radio" name="1" value="1"> Hombre
								</th>
								<th>
								  <input type="radio" name="1" value="2"> Mujer
							    </th>
							</tr>
						</div>
					</table>
				</div>
			</div


		<div class="row">
			<table class="valoraciones-prof">
			  	<tr>
			  		<th class="enunciado-prof">
				  		<h6 class="title-topic">PLANIFICACIÓN DE LA ENSEÑANZA Y APRENDIZAJE</h6> <br>
				  	  	<span>1. El/la profesor/a informa sobre los distintos aspectos de la guía docente o programa de la asignatura (objetivos, actividades, contenidos del temario, metodología, bibliografía, sistemas de evaluación,...)</span>		
					</th>
					<div class="valoracion">
						<th>
						NS <br> <input type="radio" name="1" value="1"> 
						</th>
						<th>  
						1 <br> <input type="radio" name="1" value="2"> 
					    </th>
						<th>  
						2 <br>  <input type="radio" name="1" value="3">
						</th>
						<th>  
						3 <br>  <input type="radio" name="1" value="4">
						</th>
						<th>  
						4 <br>  <input type="radio" name="1" value="5">
						</th>
						<th>  
						5 <br>  <input type="radio" name="1" value="5">
						</th>
					</div>
				</tr>
				<tr>
				  	<th class="enunciado-prof">
				  		<h6 class="title-topic">DESARROLLO DE LA DOCENCIA</h6>
		  				<h7 class="title-subtopic">Cumplimiento de las obligaciones docentes (del encargo docente)</h7> <br>
				  	  	<span>2. Imparte las clases en el horario fijado</span>		
					</th>
					<div class="valoracion">
						<th>
						NS <br> <input type="radio" name="1" value="1"> 
						</th>
						<th>  
						1 <br> <input type="radio" name="1" value="2"> 
					    </th>
						<th>  
						2 <br>  <input type="radio" name="1" value="3">
						</th>
						<th>  
						3 <br>  <input type="radio" name="1" value="4">
						</th>
						<th>  
						4 <br>  <input type="radio" name="1" value="5">
						</th>
						<th>  
						5 <br>  <input type="radio" name="1" value="5">
						</th>
					</div>
				</tr>
				<tr>
				  	<th class="enunciado-prof">
				  	  	<span>3. Asiste regularmente a clase</span>		
					</th>
					<div class="valoracion">
						<th>
						NS <br> <input type="radio" name="1" value="1"> 
						</th>
						<th>  
						1 <br> <input type="radio" name="1" value="2"> 
					    </th>
						<th>  
						2 <br>  <input type="radio" name="1" value="3">
						</th>
						<th>  
						3 <br>  <input type="radio" name="1" value="4">
						</th>
						<th>  
						4 <br>  <input type="radio" name="1" value="5">
						</th>
						<th>  
						5 <br>  <input type="radio" name="1" value="5">
						</th>
					</div>
				</tr>
				<tr>
				  	<th class="enunciado-prof">
				  	  	<span>4. Cumple adecuadamente su labor de tutoría (presencial o virtual)</span>		
					</th>
					<div class="valoracion">
						<th>
						NS <br> <input type="radio" name="1" value="1"> 
						</th>
						<th>  
						1 <br> <input type="radio" name="1" value="2"> 
					    </th>
						<th>  
						2 <br>  <input type="radio" name="1" value="3">
						</th>
						<th>  
						3 <br>  <input type="radio" name="1" value="4">
						</th>
						<th>  
						4 <br>  <input type="radio" name="1" value="5">
						</th>
						<th>  
						5 <br>  <input type="radio" name="1" value="5">
						</th>
					</div>
				</tr>
			</table>
		</div>
	</section>

</body>

</html>

