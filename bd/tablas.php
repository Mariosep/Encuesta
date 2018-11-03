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

	$query="CREATE TABLE Profesor(
		id_profesor int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		nombre tinytext NOT NULL,
		apellidos tinytext NOT NULL
		)";
	mysqli_query($mysqli, $query) or die("Fallo al crear Profesor");

	$query="CREATE TABLE Asignatura(
		id_asignatura int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		nombre tinytext NOT NULL
		)";
	mysqli_query($mysqli, $query) or die("Fallo al crear Asignatura");

	$query="CREATE TABLE AsignaturaProfesor(
		id_asignatura int NOT NULL,
		id_profesor int NOT NULL,
		PRIMARY KEY(id_asignatura,id_profesor),
		FOREIGN KEY (id_asignatura) REFERENCES Asignatura(id_asignatura),
		FOREIGN KEY (id_profesor) REFERENCES Profesor(id_profesor)
		)";
	mysqli_query($mysqli, $query) or die("Fallo al crear AsignaturaProfesor");

	$query="CREATE TABLE Encuesta(
		id_encuesta int NOT NULL AUTO_INCREMENT  PRIMARY KEY,
		fecha_init datetime NOT NULL,
		fecha_fin datetime NOT NULL,
		es_terminada boolean NOT NULL
		)";
	mysqli_query($mysqli, $query) or die("Fallo al crear Encuesta");

	$query="CREATE TABLE PreguntasUs(
		id_preg_us int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		enunciado TEXT NOT NULL,
		op_respuesta TEXT NOT NULL
		)";
	mysqli_query($mysqli, $query) or die("Fallo al crear PreguntasUs");

	$query="CREATE TABLE RespuestasUs(
		id_encuesta int NOT NULL,
		id_preg_us int NOT NULL ,
		respuesta int NOT NULL,
		PRIMARY KEY(id_encuesta,id_preg_us),
		FOREIGN KEY (id_encuesta) REFERENCES Encuesta(id_encuesta),
		FOREIGN KEY (id_preg_us) REFERENCES PreguntasUs(id_preg_us)
		)";
	mysqli_query($mysqli, $query) or die("Fallo al crear RespuestasUs");


	$query="CREATE TABLE TipoPreguntaProf(
		cod_tip int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		nombre_tipo TEXT NOT NULL
		)";
	mysqli_query($mysqli, $query) or die("Fallo al crear TipoPreguntaProf");

	$query="CREATE TABLE SubTipoPreguntaProf(
		cod_sub_tip int NOT NULL AUTO_INCREMENT PRIMARY KEY,	
		nombre_subtipo TEXT NOT NULL
		)";
	mysqli_query($mysqli, $query) or die("Fallo al crear SubTipoPreguntaProf");

	$query="CREATE TABLE TipoSubTipo(
		cod_tip int NOT NULL,
		cod_sub_tip int NOT NULL,
		PRIMARY KEY(cod_tip,cod_sub_tip),
		FOREIGN KEY (cod_tip) REFERENCES TipoPreguntaProf(cod_tip),
		FOREIGN KEY (cod_sub_tip) REFERENCES SubTipoPreguntaProf(cod_sub_tip)
		)";
	mysqli_query($mysqli, $query) or die("Fallo al crear TipoSubTipo");

	$query="CREATE TABLE PreguntasProf(
		id_preg_prof int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		enunciado TEXT NOT NULL,
		op_respuesta TEXT NOT NULL
		)";
	mysqli_query($mysqli, $query) or die("Fallo al crear PreguntasProf");

	$query="CREATE TABLE TipoSubTipoPregProf(
		id_preg_prof int NOT NULL PRIMARY KEY,
		cod_tip int NOT NULL,
		cod_sub_tip int ,
		FOREIGN KEY (id_preg_prof) REFERENCES PreguntasProf(id_preg_prof),
		FOREIGN KEY (cod_tip) REFERENCES TipoPreguntaProf(cod_tip),
		FOREIGN KEY (cod_sub_tip) REFERENCES SubTipoPreguntaProf(cod_sub_tip)
		)";
	mysqli_query($mysqli, $query) or die("Fallo al crear TipoSubTipoPregProf");

	$query="CREATE TABLE RespuestasProf(
		id_encuesta int NOT NULL,
		id_asignatura int NOT NULL,
		id_profesor int NOT NULL,
		id_preg_prof int NOT NULL,
		respuesta int NOT NULL,
		PRIMARY KEY(id_encuesta,id_profesor,id_preg_prof),
		FOREIGN KEY (id_encuesta) REFERENCES Encuesta(id_encuesta),
		FOREIGN KEY (id_profesor) REFERENCES Profesor(id_profesor)
		)";
	mysqli_query($mysqli, $query) or die("Fallo al crear RespuestasProf");

	
?>


</body>
</html>
