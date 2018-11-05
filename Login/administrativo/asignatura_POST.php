<!DOCTYPE html>
<html lang="en">
<head>

	<title>Encuesta</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body id="myPage">
  <?php
  // Obtener valores introducidos en el formulario
    error_reporting(E_ALL & ~E_NOTICE);
    $añadir = $_POST['añadir'];
    $nombre = $_POST['nombre'];
    $eliminar = $_POST['eliminar'];

    $user="root";
    $password="";
    $database="encuesta";

  ?>
	<!--Navbar-->
	<nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Insertar/Eliminar Asignatura(s)</a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="navbarsExample01" >
        <ul class="navbar-nav mr-auto">
          <li class="nav-item ">
            <a class="nav-link" href="./index.php">Inicio </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pregunta_personal.php">Añadir/Eliminar Pregunta(s) personal(es)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pregunta_profesor.php">Añadir/Eliminar Pregunta(s) profesorado</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./profesor.php">Añadir/Eliminar Profesor/a(es/as)</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="./asignatura.php">Añadir/Eliminar Asignatura(s)<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./tipo_subtipo.php">Añadir/Eliminar Tipo(s)/Subtipo(s)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./resultados.php">Ver Resultado(s) de Pregunta(s) profesorado</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./resultados_personal.php">Ver Resultado(s) de Pregunta(s) personal(es)</a>
          </li>
        </ul>
      </div>
    </nav>
  	<!--End Navbar-->
  	<div class="container-fluid bg-1 ">
		<div class="row">
			<div class="col-sm-6" >
        <div class="card" style="background-color:#394a66;border:0px;"> 
          <div class="card-body">
              <?php
                  if (isset($añadir))
                  {
                    $user="root";
                    $password="";
                    $database="encuesta";


                    $mysqli = mysqli_connect("localhost", $user, $password, $database)
                    or die ("Error al acceder a la base de datos");
                    $query="INSERT INTO asignatura (id_asignatura, nombre) VALUES (NULL, '$nombre');
                      ";
                     mysqli_query($mysqli, utf8_decode($query))
                     or die ("Fallo en añadir asignatura");
                     
                     //Tomamos su id
                     $instruccion ="SELECT id_asignatura FROM asignatura where nombre =\"".utf8_decode($nombre)."\"";
                     $res = mysqli_query($mysqli, $instruccion)
                     or die("Error al tomar id de la asignatura");
                     $id_asig= mysqli_fetch_assoc($res);

                     print ("Asignatura añadida:\n");
                     print ("<UL>\n");
                     print ("   <LI>Nombre: " . $nombre);

                     // Obtener número de noticias a borrar
                     $imparte = $_POST['imparte'];

                    if(!empty($imparte))
                      $nfilas = count($imparte);
                    else
                      $nfilas = 0;
                    print ("   <LI>Impartida por: \n");
                    print("<br>");
                     for ($i=0; $i<$nfilas; $i++){
                     
                        $instruccion ="INSERT INTO asignaturaprofesor (id_asignatura, id_profesor) VALUES ('".$id_asig['id_asignatura']."', '$imparte[$i]');";
                        mysqli_query($mysqli, $instruccion)
                        or die("Error al añadir asignatura profesor");

                        $instruccion ="SELECT * FROM profesor where id_profesor =\"$imparte[$i]\"";
                        $res = mysqli_query($mysqli, $instruccion)
                        or die("Error consulta");
                        $resultado= mysqli_fetch_assoc($res);
                        print(utf8_encode($resultado['nombre'])." ".utf8_encode($resultado['apellidos']));
                        print("<br>");
                      }
                      print ("<BR>");
                      print ("</UL>\n");
                      mysqli_close ($mysqli);
                  }else{
                      if(isset($eliminar)){
                          $mysqli = mysqli_connect("localhost", $user, $password, $database)
                          or die ("Error al acceder a la base de datos");

                           // Obtener número de noticias a borrar
                          $borrar = $_POST['borrar'];

                          if(!empty($borrar))
                            $nfilas = count($borrar);
                          else
                            $nfilas = 0;

                          for ($i=0; $i<$nfilas; $i++){
          
                            $instruccion ="SELECT * FROM asignatura where id_asignatura =\"$borrar[$i]\"";
                            $res = mysqli_query($mysqli, $instruccion)
                            or die("Error consulta");
                            $resultado= mysqli_fetch_assoc($res);

                            /// Mostrar datos de la asignatura
                            print ("Asignatura eliminada:\n");
                            print ("<UL>\n");
                            print ("   <LI>Nombre: " . utf8_encode($resultado['nombre']));
                            print ("   <LI>Era impartida por: ");
                            print("<br>");
                            
                            $instruccion ="SELECT id_profesor FROM asignaturaprofesor where id_asignatura =\"$borrar[$i]\"";
                            $res = mysqli_query($mysqli, $instruccion)
                            or die("Error consulta");
                            while($resultado= mysqli_fetch_assoc($res)){
                              $id = $resultado['id_profesor'];
                              $instruccion="SELECT * FROM profesor where id_profesor =\"$id\";";
                              $asig = mysqli_query($mysqli, $instruccion)
                              or die("Fallo al imprimir los prof que impartían la asig a eliminar");
                              $nombre_ape= mysqli_fetch_assoc($asig);
                              print(utf8_encode($nombre_ape['nombre'])." ".utf8_encode($nombre_ape['apellidos']));
                              print("<br>");
                            }
                            print ("<BR>");
                            print ("</UL>\n");
                            // Eliminar profesor
                            $instruccion = "DELETE FROM asignatura where id_asignatura =\"$borrar[$i]\"";
                            mysqli_query ( $mysqli, $instruccion)
                            or die ("Fallo en la Eliminación");

                            // Eliminamos imparte
                            $instruccion = "DELETE FROM asignaturaprofesor where id_asignatura =\"$borrar[$i]\"";
                            mysqli_query ( $mysqli, $instruccion)
                            or die ("Fallo en la Eliminación de asignaturaprofesor");
                          }
                          print ("<P>Número total de Asignaturas eliminadas: " . $nfilas . "</P>\n");
                          
                          }
                      }
              ?>
             <P>[ <A HREF='./asignatura.php'>Añadir/Eliminar más Asignaturas</A> ]</P>
          </div>
        </div>
      </div>
		</div>

	</div>
	 <!-- Footer -->
	<footer class="container-fluid bg-4 text-center">
		<a href="#myPage" title="To Top">
    		<span class="glyphicon glyphicon-chevron-up"></span>
  		</a>
		<p>Realizado por Adrián Quirós Martín y Mario Sepúlveda Cornejo</p> 
	</footer>
	<!-- Footer -->
  	 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>