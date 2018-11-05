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
    $añadir_tipo = $_POST['añadir_tipo'];
    $añadir_subtipo = $_POST['añadir_subtipo'];
    $nombre_tipo = $_POST['tipo'];
    $nombre_subtipo = $_POST['subtipo'];
    $eliminar_tipo = $_POST['eliminar_tipo'];
    $eliminar_subtipo = $_POST['eliminar_subtipo'];
    $tipo_select = $_POST['tipo_select'];

    $user="root";
    $password="";
    $database="encuesta";

    $mysqli = mysqli_connect("localhost", $user, $password, $database)
    or die ("Error al acceder a la base de datos");

  ?>
	<!--Navbar-->
	<nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Añadir/Eliminar Tipo(s)/Subtipo(s)</a>
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
          <li class="nav-item">
            <a class="nav-link" href="./pregunta_profesor.php">Añadir/Eliminar Pregunta(s) profesorado</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./profesor.php">Añadir/Eliminar Profesor/a(es/as)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./asignatura.php">Añadir/Eliminar Asignatura(s)</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="./tipo_subtipo.php">Añadir/Eliminar Tipo(s)/Subtipo(s)<span class="sr-only">(current)</span></a>
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
                  if (isset($añadir_tipo))
                  {
                    
                    $query="INSERT INTO tipopreguntaprof (cod_tip, nombre_tipo) VALUES (NULL, '$nombre_tipo');
                      ";
                     mysqli_query($mysqli, utf8_decode($query))
                     or die ("Fallo en añadir tipo");
                     
                     print ("Tipo añadido:\n");
                     print ("<UL>\n");
                     print ("   <LI>Nombre del Tipo: " . $nombre_tipo);
                     print ("<BR>");
                     print ("</UL>\n");

                     mysqli_close ($mysqli);
                  }else{
                      if(isset($eliminar_tipo)){
                          $mysqli = mysqli_connect("localhost", $user, $password, $database)
                          or die ("Error al acceder a la base de datos");

                           // Obtener número de noticias a borrar
                          $borrar_tipo = $_POST['borrar_tipo'];

                          if(!empty($borrar_tipo))
                            $nfilas = count($borrar_tipo);
                          else
                            $nfilas = 0;

                          for ($i=0; $i<$nfilas; $i++){
          
                          $instruccion ="SELECT * FROM tipopreguntaprof where cod_tip =\"$borrar_tipo[$i]\"";
                          $res = mysqli_query($mysqli, $instruccion)
                          or die("Error consulta");
                          $resultado= mysqli_fetch_assoc($res);

                          /// Mostrar datos de la tipo i-esimo
                          print ("Tipo eliminado:\n");
                          print ("<UL>\n");
                          print ("   <LI>Nombre del Tipo: " . $resultado['nombre_tipo']);
                          print ("   <LI>Le pertenecía los Subtipos (también eliminados): ");
                          print("<br>");

                          
                           $instruccion ="SELECT cod_sub_tip FROM tiposubtipo where cod_tip =\"$borrar_tipo[$i]\"";
                           $res = mysqli_query($mysqli, $instruccion)
                           or die("Error al tomar cod del subtipos");
                           while($cod_sub_tip= mysqli_fetch_assoc($res)){
                              $cod_sub_tip = $cod_sub_tip['cod_sub_tip'];
                              $instruccion ="SELECT * FROM subtipopreguntaprof where cod_sub_tip =\"$cod_sub_tip\"";
                              $resultado = mysqli_query($mysqli, $instruccion)
                              or die("Error al escribir nombres de subtipos");
                              $nombre_subtipo= mysqli_fetch_assoc($resultado);
                              print($nombre_subtipo['nombre_subtipo']);
                              print("<br>");
                              
                              $instruccion ="DELETE FROM subtipopreguntaprof where cod_sub_tip =\"$cod_sub_tip\"";
                              mysqli_query($mysqli, $instruccion);
                           }
                           print ("   <LI>Además se eliminaron las preguntas siguientes: ");
                           print("<br>");
                          $instruccion ="SELECT * FROM tiposubtipopregprof where cod_tip =\"$borrar_tipo[$i]\"";
                           $res = mysqli_query($mysqli, $instruccion)
                           or die("Error al tomar las preg asociadas al tipo eliminar");
                           while($resultado= mysqli_fetch_assoc($res)){
                              
                              $instruccion ="SELECT * FROM preguntasprof where id_preg_prof =\"".$resultado['id_preg_prof']."\"";
                              $n_preg = mysqli_query($mysqli, $instruccion)
                              or die("Error al escribir el nombre de las preg que se eliminarán");
                              $enunciado_preg= mysqli_fetch_assoc($n_preg);
                              print("- ".utf8_encode($enunciado_preg['enunciado']));
                              print("<br>");
                              
                              //Eliminamos la pregunta
                              $instruccion ="DELETE FROM preguntasprof where id_preg_prof =\"".$resultado['id_preg_prof']."\"";
                              mysqli_query($mysqli, $instruccion);
                           }

                          //Eliminamos todas las relaciones preg con tipo y subtipo
                          $instruccion ="DELETE FROM tiposubtipopregprof where cod_tip =\"$borrar_tipo[$i]\"";
                          mysqli_query($mysqli, $instruccion);

                          print ("<BR>");
                          print ("</UL>\n");

                          // Eliminar tiposubtipo
                          $instruccion = "DELETE FROM tiposubtipo where cod_tip =\"$borrar_tipo[$i]\"";
                          $consulta = mysqli_query ( $mysqli, $instruccion)
                          or die ("Fallo en la Eliminación");

                          // Eliminar tipo
                          $instruccion = "DELETE FROM tipopreguntaprof where cod_tip =\"$borrar_tipo[$i]\"";
                          $consulta = mysqli_query ( $mysqli, $instruccion)
                          or die ("Fallo en la Eliminación");
                          }

                          print ("<P>Número total de tipos eliminados: " . $nfilas . "</P>\n");
                          
                          }
                  }
                  if (isset($añadir_subtipo))
                  {
                    
                    $query="INSERT INTO subtipopreguntaprof (cod_sub_tip, nombre_subtipo) VALUES (NULL, '$nombre_subtipo');
                      ";
                     mysqli_query($mysqli, utf8_decode($query))
                     or die ("Fallo en añadir subtipo");
                     
                     //Tomamos el codigo del subtipo
                     $instruccion ="SELECT cod_sub_tip FROM subtipopreguntaprof where nombre_subtipo =\"".utf8_decode($nombre_subtipo)."\"";
                     $res = mysqli_query($mysqli, $instruccion)
                     or die("Error al tomar cod del subtipo");
                     $cod_sub_tip= mysqli_fetch_assoc($res);


                     print ("Subtipo añadido:\n");
                     print ("<UL>\n");
                     print ("   <LI>Nombre del Subtipo: " . $nombre_subtipo);
                     print ("   <LI>Pertenece al Tipo: " );
                     print("<br>");
                     $instruccion ="INSERT INTO tiposubtipo (cod_tip, cod_sub_tip) VALUES ('$tipo_select', '".$cod_sub_tip['cod_sub_tip']."');";
                      mysqli_query($mysqli, $instruccion)
                      or die("Error al añadir tiposubtipo");

                      $instruccion ="SELECT nombre_tipo FROM tipopreguntaprof where cod_tip =\"$tipo_select\"";
                      $res=mysqli_query($mysqli, $instruccion)
                      or die("Error al tomar nombre del tipo");
                      $nombre_tip= mysqli_fetch_assoc($res);
                      print(utf8_encode($nombre_tip['nombre_tipo']));
                     print ("<BR>");
                     print ("</UL>\n");

                     mysqli_close ($mysqli);
                  }else{
                      if(isset($eliminar_subtipo)){
                          $mysqli = mysqli_connect("localhost", $user, $password, $database)
                          or die ("Error al acceder a la base de datos");

                           // Obtener número de noticias a borrar
                          $borrar_subtipo = $_POST['borrar_subtipo'];

                          if(!empty($borrar_subtipo))
                            $nfilas = count($borrar_subtipo);
                          else
                            $nfilas = 0;

                          for ($i=0; $i<$nfilas; $i++){
          
                          $instruccion ="SELECT * FROM subtipopreguntaprof where cod_sub_tip =\"$borrar_subtipo[$i]\"";
                          $res = mysqli_query($mysqli, $instruccion)
                          or die("Error consulta");
                          $resultado= mysqli_fetch_assoc($res);

                          /// Mostrar datos de la tipo i-esimo
                          print ("SubTipo eliminado:\n");
                          print ("<UL>\n");
                          print ("   <LI>Nombre del Subtipo: " . utf8_encode($resultado['nombre_subtipo']));
                          print ("   <LI>Pertenecía al Tipo: " );
                          print("<br>");

                          $instruccion = "SELECT cod_tip FROM tiposubtipo where cod_sub_tip =\"$borrar_subtipo[$i]\"";
                          $res = mysqli_query ( $mysqli, $instruccion)
                          or die ("Fallo en la Eliminación");
                          $cod_tip= mysqli_fetch_assoc($res);

                          $cod_tip = $cod_tip['cod_tip'];
                          $instruccion = "SELECT nombre_tipo FROM tipopreguntaprof where cod_tip =\"$cod_tip\"";
                          $res = mysqli_query ( $mysqli, $instruccion)
                          or die ("Fallo en la Eliminación");
                          $nombre_tip= mysqli_fetch_assoc($res);

                          print(utf8_encode($nombre_tip['nombre_tipo']));

                          print ("   <LI>Además se eliminaron las preguntas siguientes: ");
                           print("<br>");
                          $instruccion ="SELECT * FROM tiposubtipopregprof where cod_sub_tip =\"$borrar_subtipo[$i]\"";
                           $res = mysqli_query($mysqli, $instruccion)
                           or die("Error al tomar la preg asiciadas al subtipo");
                           while($resultado= mysqli_fetch_assoc($res)){
                              
                              $instruccion ="SELECT * FROM preguntasprof where id_preg_prof =\"".$resultado['id_preg_prof']."\"";
                              $n_preg = mysqli_query($mysqli, $instruccion)
                              or die("Error al escribir el enunciado de las preg que se eliminarán");
                              $enunciado_preg= mysqli_fetch_assoc($n_preg);
                              print("- ".utf8_encode($enunciado_preg['enunciado']));
                              print("<br>");
                              
                              //Eliminamos la pregunta
                              $instruccion ="DELETE FROM preguntasprof where id_preg_prof =\"".$resultado['id_preg_prof']."\"";
                              mysqli_query($mysqli, $instruccion);
                           }

                          //Eliminamos todas las relaciones preg con tipo y subtipo
                          $instruccion ="DELETE FROM tiposubtipopregprof where cod_sub_tip =\"$borrar_subtipo[$i]\"";
                          mysqli_query($mysqli, $instruccion);
                          print ("<BR>");
                          print ("</UL>\n");

                          // Eliminar tiposubtipo
                          $instruccion = "DELETE FROM tiposubtipo where cod_sub_tip =\"$borrar_subtipo[$i]\"";
                          mysqli_query ( $mysqli, $instruccion)
                          or die ("Fallo en la Eliminación tiposubtipo");
                          

                          // Eliminar tipo
                          $instruccion = "DELETE FROM subtipopreguntaprof where cod_sub_tip =\"$borrar_subtipo[$i]\"";
                          mysqli_query ( $mysqli, $instruccion)
                          or die ("Fallo en la Eliminación tiposubtipo");
                          }

                          print ("<P>Número total de subtipos eliminados: " . $nfilas . "</P>\n");
                          
                         } 
                      }
              ?>
             <P>[ <A HREF='./tipo_subtipo.php'>Añadir/Eliminar Tipo(s)/Subtipo(s)</A> ]</P>
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