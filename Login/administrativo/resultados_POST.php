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
    $filtrar = $_POST['filtrar'];
    $profesor= $_POST['profesor'];
    $asignatura = $_POST['asignatura'];
    

    $user="root";
    $password="";
    $database="encuesta";

     $mysqli = mysqli_connect("localhost", $user, $password, $database)
     or die ("Error al acceder a la base de datos");

  ?>
  <!--Navbar-->
  <nav class="navbar navbar-dark bg-dark">
    <img src="Logo_UCA.png" class="img-responsive img-rounded" style="display:inline;width: 40px;" alt="uca">
      <a class="navbar-brand" href="#">Ver resultados</a>
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
          <li class="nav-item ">
            <a class="nav-link" href="./pregunta_profesor.php">Añadir/Eliminar Pregunta(s) profesorado</a>
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
          <li class="nav-item active">
            <a class="nav-link" href="./resultados.php">Ver Resultados<span class="sr-only">(current)</span></a>
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
                  if (isset($filtrar))
                  {
                     if($profesor != "" || $asignatura != "" )
                     {
                        if($asignatura != ""){

                          $instruccion ="SELECT id_preg_prof,respuesta FROM respuestasprof where id_asignatura =\"$asignatura\";";
                          $res = mysqli_query($mysqli, $instruccion)
                          or die("Error al tomar las respuestas");

                          $query ="SELECT * FROM preguntasprof;";
                          $select = mysqli_query($mysqli, $query)
                          or die("Error al tomar el numero de rows de preguntasprof");
                          $n_preguntas = mysqli_num_rows ($select);

                          $v_counter = 0;
                          while($resultado = mysqli_fetch_assoc($res)){
                            $temp = $resultado['id_preg_prof'];
                            $v_counter[$temp] += $resultado['respuesta'];
                          }

                          foreach($select as $row){
                            $temp = $row['id_preg_prof'];
                            $v_counter[$temp] = $v_counter[$temp]/$n_preguntas;
                            print($v_counter[$temp]);
                          }
                          


                        }else{

                        }
                        
                     }else{
                        print ("No es posible realizar el filtrado, no se ha seleccionado ningun filtro.\n");
                     }
              
                      mysqli_close ($mysqli);
                  }
              ?>
             <P>[ <A HREF='resultados.php'>Seleccionar otro filtro</A> ]</P>
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