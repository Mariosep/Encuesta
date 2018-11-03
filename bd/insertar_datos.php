<!DOCTYPE html >
<html>
<head>
<meta  charset="utf-8" />
<title>Trabajando con MySQL</title>
</head>

<body>


<?php

	$user="root";
	$password="";
	$database="encuesta";


	$mysqli = mysqli_connect("localhost", $user, $password, $database)
	or die ("Error al acceder a la base de datos");



	$query="INSERT INTO profesor (id_profesor, nombre, apellidos) VALUES ('1', 'Antonio Jorge', 'Tomeu Hardasmal'), ('2', 'Elisa', 'Guerrero'), ('3', 'Pedro', 'Delgado Pérez'), ('4', 'Alberto', 'Salguero Hidalgo'), ('5', 'Andrés', 'Yañez'), ('6', 'Pedro', 'Fernández Fernández'), ('7', 'Pablo', 'García Sánchez'), ('8', 'Manuel', 'Palomo Duarte'), ('9', 'María De La Paz', 'Guerrero Lebrero'), ('10', 'Bernabé', 'Dorronsoro'), ('11', 'Francisco Jose', 'González Gutierrez'), ('12', 'María Eloisa', 'Yrayzoz Díaz De Liaño'), ('13', 'María Del Carmen', 'De Castro Cabrera'), ('14', 'Antonio', 'Sala Perez'), ('15', 'Esther Lidia', 'Silva Ramírez'), ('16', 'Nuria', 'Hurtado Rodriguez'), ('17', 'Elena', 'Orta Cuevas'), ('18', 'Antonio', 'Baldera Alberico'), ('19', 'Raquel', 'Ureña Pérez'), ('20', 'Pedro Luis', 'Galindo Riaño'), ('21', 'Ignacio Javier', 'Pérez Gálvez');
			";
	mysqli_query($mysqli, utf8_decode($query))
	or die("Fallo en añadir profesores");



	$query="INSERT INTO asignatura (id_asignatura, nombre) VALUES ('1', 'Matemática Discreta'), ('2', 'Introducción a la Programación'), ('3', 'Metodología de la Programación'), ('4', 'Cálculo'), ('5', 'Diseño de Algoritmos'), ('6', 'Programación Concurrente y de Tiempo Real'), ('7', 'Modelos de computación'), ('8', 'Informática General'), ('9', 'Percepción'), ('10', 'Programación en Internet'), ('11', 'Teoría de Autómatas y Lenguajes Formales'), ('12', 'Procesadores de Lenguajes'), ('13', 'Bases de Datos');
			";
	mysqli_query($mysqli,  utf8_decode($query))
	or die("Fallo en añadir asigs");

	

	$query="INSERT INTO asignaturaprofesor (id_asignatura, id_profesor) VALUES ('1', '11'), ('2', '12'), ('2', '16'), ('3', '15'), ('4', '14'), ('5', '4'), ('5', '6'), ('6', '1'), ('6', '4'), ('6', '21'), ('7', '1'), ('8', '13'), ('9', '5'), ('10', '3'), ('11', '10'), ('12', '9'), ('13', '8'), ('13', '18'), ('13', '19');
			";
	mysqli_query($mysqli, utf8_decode($query))
	or die ("Fallo en añadir asig-prof");

	$query="INSERT INTO preguntasus (id_preg_us, enunciado, op_respuesta) VALUES ('1', 'Edad(años)', '<=19&20-21&22-23&24-25&>25'), ('2', 'Sexo', 'Hombre&Mujer'), ('3', 'Curso más alto en el que estás matriculado', '1º&2º&3º&4º'), ('4', 'Curso más bajo en el que estás matriculado', '1º&2º&3º&4º'), ('5', 'Veces que te has matriculado en esta asignatura', '1&2&3&>3'), ('6', 'Veces que te has examinado en esta asignatura', '1&2&3&>3'), ('7', 'La asignatura me interesa', 'Nada&Algo&Bastante&Mucho'), ('8', 'Hago uso de las Tutorías', 'Nada&Algo&Bastante&Mucho'), ('9', 'Dificultad de esta Asignatura', 'Baja&Media&Alta&Muy Alta'), ('10', 'Calificación esperada', 'NP&Sus.&Apro.&Not.&Sobr.&Mat. Hon.'), ('11', 'Asistencia clase(% de horas lectivas)', 'Menos 50%&Entre 50% y 80%&Más de 80%');
			";
	mysqli_query($mysqli, utf8_decode($query))
	or die ("Fallo en añadir preguntas us");

	$query="INSERT INTO tipopreguntaprof(cod_tip,nombre_tipo) VALUES ('1','PLANIFICACIÓN DE LA ENSEÑANZA Y APRENDIZAJE'), ('2','DESARROLLO DE LA DOCENCIA'), ('3','RESULTADOS');
			";
	mysqli_query($mysqli, utf8_decode($query))
	or die ("Fallo en añadir tipopreguntaprof");


	$query="INSERT INTO subtipopreguntaprof(cod_sub_tip,nombre_subtipo) VALUES ('1','Cumplimiento de las obligaciones docentes (del encargo docente)'), ('2','Cumplimiento de la Planificación'), ('3','Metodología docente'), ('4','Competencias docentes desarrollada por el/la profesor/a'), ('5','Sistemas de evaluación');
			";
	mysqli_query($mysqli, utf8_decode($query))
	or die ("Fallo en añadir subtipopregprof");

	$query="INSERT INTO tiposubtipo(cod_tip,cod_sub_tip) VALUES ('2','1'), ('2','2'), ('2','3'), ('2','4'), ('2','5');
			";
	mysqli_query($mysqli, utf8_decode($query))
	or die ("Fallo en añadir tiposubtipo");

	$query="INSERT INTO preguntasprof(id_preg_prof,enunciado,op_respuesta) VALUES('1','El/la profesor/a informa sobre los distintos aspectos de la guía docente o programa de la asignatura (objetivos, actividades, contenidos del temario, metodología, bibliografía, sistemas de evaluación, ...)','NS&1&2&3&4&5'),('2','Imparte las clases en el horario fijado','NS&1&2&3&4&5'),('3','Asiste regularmente a clase','NS&1&2&3&4&5'),('4','Cumple adecuadamente su labor de tutoría (presencial o virtual)','NS&1&2&3&4&5'),('5','Se ajusta a la planificación de la asignatura','NS&1&2&3&4&5'),('6','Se han coordinado las actividades teóricas y prácticas previstas','NS&1&2&3&4&5'),('7','Se ajusta a los sistemas de evalucación especificados en la guía docente/programa de la asignatura','NS&1&2&3&4&5'),('8','La bibliografía y otras fuentes de información recomendadas en el programa son útiles para el aprendizaje de la asignatura','NS&1&2&3&4&5'),('9','El/la profesor/a organiza bien las actividades que se realizan en clase','NS&1&2&3&4&5'),('10','Utiliza recursos didácticos (pizarra, trasparencias, medios audiovisuales, material de apoyo en red virtual...) que facilitan el aprendizaje','NS&1&2&3&4&5'),('11','Explica con claridad y resalta los contenidos importantes','NS&1&2&3&4&5'),('12','Se interesa por el grado de compresión de sus explicaciones','NS&1&2&3&4&5'),('13','Expone ejemplo en los que se ponen en práctica los contenidos de la asignatura','NS&1&2&3&4&5'),('14','Explica los contenidos con seguridad','NS&1&2&3&4&5'),('15','Resuelve las dudas que se plantean','NS&1&2&3&4&5'),('16','Fomenta un clima de trabajo y participación','NS&1&2&3&4&5'),('17','Propicia una comunicación fluida y espontánea','NS&1&2&3&4&5'),('18','Motiva a los/as estudiantes para que se interesen por la asignatura','NS&1&2&3&4&5'),('19','Es respetuoso/a en el trato con los/as estudiantes','NS&1&2&3&4&5'),('20','Tengo claro lo que se me va a exigir para superar esta asignatura','NS&1&2&3&4&5'),('21','Los criterios y sistemas de evaluación me parecen adecuados, en el contexto de la asignatura','NS&1&2&3&4&5'),('22','Las actividades desarrolladas (teóricas, prácticas, de trabajo individual, en grupo, ...) contribuyen a alzanzar los objetivos de la asignatura','NS&1&2&3&4&5'),('23','Estoy satisfecho/a con la labor docente de este/a profesor/a','NS&1&2&3&4&5');

			";
	mysqli_query($mysqli, utf8_decode($query))
	or die ("Fallo en añadir preguntas para el profesorado");

	$query="INSERT INTO tiposubtipopregprof(id_preg_prof,cod_tip,cod_sub_tip) VALUES('1','1',NULL),('2','2','1'),('3','2','1'),('4','2','1'),('5','2','2'),('6','2','2'),('7','2','2'),('8','2','2'),('9','2','3'),('10','2','3'),('11','2','4'),('12','2','4'),('13','2','4'),('14','2','4'),('15','2','4'),('16','2','4'),('17','2','4'),('18','2','4'),('19','2','4'),('20','2','5'),('21','2','5'),('22','3',NULL),('23','3',NULL);

			";
	mysqli_query($mysqli, utf8_decode($query))
	or die ("Fallo al añadir tiposubtipopregprof");


	
?>


</body>
</html>
