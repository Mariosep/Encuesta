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
    $apellidos = $_POST['apellidos'];
    $eliminar = $_POST['eliminar'];

    $user="root";
    $password="";
    $database="encuesta";

  ?>
	<!--Navbar-->
	<nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Añadir/Eliminar Profesor/a(es/as)</a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="navbarsExample01" >
        <ul class="navbar-nav mr-auto">
          <li class="nav-item ">
            <a class="nav-link" href="./index.php">Inicio </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./pregunta_personal.php">Añadir/Eliminar Pregunta(s) personal(es)</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./pregunta_profesor.php">Añadir/Eliminar Pregunta(s) profesorado</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="./profesor.php">Añadir/Eliminar Profesor/a(es/as)<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./asignatura.php">Añadir/Eliminar Asignatura(s)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./tipo_subtipo.php">Añadir/Eliminar Tipo(s)/Subtipo(s)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./resultados.php">Ver Resultados</a>
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
                    $query="INSERT INTO profesor (id_profesor, nombre, apellidos) VALUES (NULL, '$nombre', '$apellidos');
                      ";
                     mysqli_query($mysqli, utf8_decode($query))
                     or die ("Fallo en añadir profesor");
                     
                     //Tomamos su id
                     $instruccion ="SELECT id_profesor FROM profesor where nombre =\"".utf8_decode($nombre)."\" and apellidos =\"".utf8_decode($apellidos)."\"";
                     $res = mysqli_query($mysqli, $instruccion)
                     or die("Error al tomar id del profesor");
                     $id_prof= mysqli_fetch_assoc($res);

                     print ("Profesor/a añadido/a:\n");
                     print ("<UL>\n");
                     print ("   <LI>Nombre: " . $nombre);
                     print ("   <LI>Apellidos: " . $apellidos);

                     // Obtener número de noticias a borrar
                     $imparte = $_POST['imparte'];

                    if(!empty($imparte))
                      $nfilas = count($imparte);
                    else
                      $nfilas = 0;
                    print ("   <LI>Imparte: \n");
                    print("<br>");
                     for ($i=0; $i<$nfilas; $i++){
                     
                        $instruccion ="INSERT INTO asignaturaprofesor (id_asignatura, id_profesor) VALUES ('$imparte[$i]', '".$id_prof['id_profesor']."');";
                        mysqli_query($mysqli, $instruccion)
                        or die("Error al añadir asignatura profesor");

                        $instruccion ="SELECT * FROM asignatura where id_asignatura =\"$imparte[$i]\"";
                        $res = mysqli_query($mysqli, $instruccion)
                        or die("Error consulta");
                        $resultado= mysqli_fetch_assoc($res);
                        print(utf8_encode($resultado['nombre']));
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
          
                            $instruccion ="SELECT * FROM profesor where id_profesor =\"$borrar[$i]\"";
                            $res = mysqli_query($mysqli, $instruccion)
                            or die("Error consulta");
                            $resultado= mysqli_fetch_assoc($res);

                            /// Mostrar datos del profesor
                            print ("Profesor/a eliminado/a:\n");
                            print ("<UL>\n");
                            print ("   <LI>Nombre: " . $resultado['nombre']);
                            print ("   <LI>Apellidos: " . $resultado['apellidos']);
                            print ("   <LI>Impartía: ");
                            print("<br>");
                            
                            $instruccion ="SELECT id_asignatura FROM asignaturaprofesor where id_profesor =\"$borrar[$i]\"";
                            $res = mysqli_query($mysqli, $instruccion)
                            or die("Error consulta");
                            while($resultado= mysqli_fetch_assoc($res)){
                              $id = $resultado['id_asignatura'];
                              $instruccion="SELECT nombre FROM asignatura where id_asignatura =\"$id\";";
                              $nombre_asig = mysqli_query($mysqli, $instruccion)
                              or die("Fallo al imprimir las asigs que impartía el profesor a eliminar");
                              $nombre= mysqli_fetch_assoc($nombre_asig);
                              print(utf8_encode($nombre['nombre']));
                              print("<br>");
                            }
                            print ("<BR>");
                            print ("</UL>\n");
                            // Eliminar profesor
                            $instruccion = "DELETE FROM profesor where id_profesor =\"$borrar[$i]\"";
                            mysqli_query ( $mysqli, $instruccion)
                            or die ("Fallo en la Eliminación");

                            // Eliminamos imparte
                            $instruccion = "DELETE FROM asignaturaprofesor where id_profesor =\"$borrar[$i]\"";
                            mysqli_query ( $mysqli, $instruccion)
                            or die ("Fallo en la Eliminación de asignaturaprofesor");
                          }
                          print ("<P>Número total de profesores/as eliminados/as: " . $nfilas . "</P>\n");
                          
                          }
                      }
              ?>
             <P>[ <A HREF='profesor.php'>Añadir/Eliminar más Profesores/as</A> ]</P>
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