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
    $enunciado = $_POST['enunciado'];
    $res_op = $_POST['res_op'];
    $tipo_select = $_POST['tipo_select'];
    $subtipo_select = $_POST['subtipo_select'];
    
    $eliminar = $_POST['eliminar'];
    $borrar = $_POST['borrar'];

    $user="root";
    $password="";
    $database="encuesta";

     $mysqli = mysqli_connect("localhost", $user, $password, $database)
     or die ("Error al acceder a la base de datos");

  ?>
  <!--Navbar-->
  <nav class="navbar navbar-dark bg-dark">
    <img src="Logo_UCA.png" class="img-responsive img-rounded" style="display:inline;width: 40px;" alt="uca">
      <a class="navbar-brand" href="#">Añadir/Eliminar Pregunta(s) profesorado</a>
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
          <li class="nav-item active">
            <a class="nav-link" href="./pregunta_profesor.php">Añadir/Eliminar Pregunta(s) profesorado<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./profesor.php">Añadir/Eliminar Profesor/a(es/as)</a>
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
                    //Ver si es el subtipo elegido pertenece al tipo correspondiente
                     $instruccion ="SELECT * FROM tiposubtipo where cod_tip =\"$tipo_select\" and cod_sub_tip = \"$subtipo_select\"";
                     $res = mysqli_query($mysqli, $instruccion)
                     or die("Error al tomar cod del subtipo");
                     if(($aceptado= mysqli_fetch_assoc($res) || $subtipo_select=="")||($aceptado= mysqli_fetch_assoc($res) && $subtipo_select!="") )
                     {
                         $query="INSERT INTO preguntasprof (id_preg_prof, enunciado, op_respuesta) VALUES (NULL, '$enunciado', '$res_op');";
                           mysqli_query($mysqli, utf8_decode($query))
                           or die ("Fallo en añadir preguntas us");


                          
                           //Tomar el id de la pregunta añadida
                           $instruccion ="SELECT id_preg_prof FROM preguntasprof where enunciado =\"".utf8_decode($enunciado)."\"";
                           $res = mysqli_query($mysqli, $instruccion)
                           or die("Error al tomar cod de la preg a añadir");
                           $id_preg_prof= mysqli_fetch_assoc($res);

                           
                           if($subtipo_select != ""){
                              $instruccion ="INSERT INTO tiposubtipopregprof (id_preg_prof, cod_tip, cod_sub_tip) VALUES ('".$id_preg_prof['id_preg_prof']."', '$tipo_select', '$subtipo_select');";
                              mysqli_query($mysqli, $instruccion)
                              or die ("Fallo en añadir tiposubtipopregprof, sin ser null el subtipo");

                               //Tomar el nom del subtipo elegido
                               $instruccion ="SELECT nombre_subtipo FROM subtipopreguntaprof where cod_sub_tip =\"$subtipo_select\"";
                               $res = mysqli_query($mysqli, $instruccion)
                               or die("Error al tomar el nom del subtipo");
                               $nombre_subtipo= mysqli_fetch_assoc($res);
                           }else{
                            
                              $instruccion ="INSERT INTO tiposubtipopregprof (id_preg_prof, cod_tip, cod_sub_tip) VALUES ('".$id_preg_prof['id_preg_prof']."', '$tipo_select', NULL);";
                              mysqli_query($mysqli, $instruccion)
                              or die ("Fallo en añadir tiposubtipopregprof, siendo null el subtipo");
                              $nombre_subtipo="";
                           }

                          //Tomar el nombre del tipo elegido
                           $instruccion ="SELECT nombre_tipo FROM tipopreguntaprof where cod_tip =\"$tipo_select\"";
                           $res = mysqli_query($mysqli, $instruccion)
                           or die("Error al tomar el nom del tipo");
                           $nombre_tipo= mysqli_fetch_assoc($res);
                           
                           print ("Pregunta añadida:\n");
                           print ("<UL>\n");
                           print ("   <LI>Enunciado: " . $enunciado);
                           print ("   <LI>Respuestas posibles: " . $res_op);
                           print ("   <LI>Pertenece al tipo: " . utf8_encode($nombre_tipo['nombre_tipo']));
                           if($nombre_subtipo != "")
                              print ("   <LI>Y al Subtipo: " . utf8_encode($nombre_subtipo['nombre_subtipo']));
                           else
                              print ("   <LI>Y al Subtipo: " . "NULL");
                           print ("<BR>");
                           print ("</UL>\n");

                          
                     }else{
                        print ("No es posible realizar esa asignación de Tipos. Inténtelo de nuevo por favor.\n");
                     }
              
                      mysqli_close ($mysqli);
                  }else{
                      if(isset($eliminar)){

                          if(!empty($borrar))
                            $nfilas = count($borrar);
                          else
                            $nfilas = 0;

                          for ($i=0; $i<$nfilas; $i++){
          
                          $instruccion ="SELECT * FROM preguntasprof where id_preg_prof =\"$borrar[$i]\"";
                          $res = mysqli_query($mysqli, $instruccion)
                          or die("Error consulta");
                          $resultado= mysqli_fetch_assoc($res);


                          /// Mostrar datos de la preg i-esima
                          print ("Pregunta eliminada:\n");
                          print ("<UL>\n");
                          print ("   <LI>Enunciado: " . utf8_encode($resultado['enunciado']));
                          print ("   <LI>Respuestas posibles: " . utf8_encode($resultado['op_respuesta']));
                          print ("<BR>");
                          print ("</UL>\n");

                          // Eliminar preg
                          $instruccion = "DELETE FROM preguntasprof where id_preg_prof =\"$borrar[$i]\"";
                          $consulta = mysqli_query ( $mysqli, $instruccion)
                          or die ("Fallo en la Eliminación");
                          

                          // Eliminar también el tipo relacionado que tenía dicha pregunta
                          $instruccion = "DELETE FROM tiposubtipopregprof where id_preg_prof =\"$borrar[$i]\"";
                          $consulta = mysqli_query ( $mysqli, $instruccion)
                          or die ("Fallo en la Eliminación");
                          }

                          print ("<P>Número total de preguntas eliminadas: " . $nfilas . "</P>\n");
                          
                          }
                      }
              ?>
             <P>[ <A HREF='pregunta_profesor.php'>Añadir/Eliminar más Pregunta(s) profesorado</A> ]</P>
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