<!DOCTYPE html>
<html lang="en">
<head>

  <title>Encuesta</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   

  <link rel="stylesheet" type="text/css" href="estilo.css">
  <style type="text/css">
    .table-wrapper-scroll-y {
      display: block;
      max-height: 350px;
      overflow-y: auto;
      -ms-overflow-style: -ms-autohiding-scrollbar;
    }
  </style>
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
      <a class="navbar-brand" href="#">Ver Resultado(s) de Pregunta(s) profesorado</a>
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
            <a class="nav-link" href="./resultados.php">Ver Resultado(s) de Pregunta(s) profesorado<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./resultados_personal.php">Ver Resultado(s) de Pregunta(s) personal(es)</a>
          </li>
        </ul>
      </div>
    </nav>
    <!--End Navbar-->
    <div class="container-fluid bg-1 " style="padding-top: 35px;padding-bottom: 70px;">
    <div class="row">
      <div class="col-sm-6" >
        <div class="card" style="background-color:#d0daea;border:0px;"> 
          <div class="card-body">
              <?php
                  if (isset($filtrar))
                  {
                     if($profesor != "" || $asignatura != "" )
                     {
                        if($asignatura != ""){

                          if($profesor != ""){

                             //Filtrado por asignatura y profesor
                            //Tomar el nombre de la asignatura
                            $instruccion ="SELECT nombre FROM asignatura where id_asignatura =\"$asignatura\";";
                            $res = mysqli_query($mysqli, $instruccion)
                            or die("Error al tomar las respuestas");
                            $nombre = mysqli_fetch_assoc($res);
                            $nombre_asig = utf8_encode($nombre['nombre']);

                            //Tomar nombre del profesor
                            $instruccion ="SELECT nombre,apellidos FROM profesor where id_profesor =\"$profesor\";";
                            $res = mysqli_query($mysqli, $instruccion)
                            or die("Error al tomar las respuestas");
                            $nombre = mysqli_fetch_assoc($res);
                            $nombre_apell = utf8_encode($nombre['nombre'])." ".utf8_encode($nombre['apellidos']);

                            $instruccion ="SELECT id_preg_prof,respuesta FROM respuestasprof where id_asignatura =\"$asignatura\" and id_profesor =\"$profesor\";";
                            $res = mysqli_query($mysqli, $instruccion)
                            or die("Error al tomar las respuestas");

                            $query ="SELECT * FROM preguntasprof;";
                            $select = mysqli_query($mysqli, $query)
                            or die("Error al tomar el numero de rows de preguntasprof");
                            

                            $v_counter = array();
                            $n_counter = array();
                            while($resultado = mysqli_fetch_assoc($res)){
                              //Ignoramos la respuestas NS/NC
                              if($resultado['respuesta'] != 0){  
                                $temp = $resultado['id_preg_prof'];
                                $v_counter[$temp] += $resultado['respuesta'];
                                $n_counter[$temp] += 1;
                              }
                            }
                            $dates = "";
                            $values ="";
                            while($resultado = mysqli_fetch_assoc($select)){
                              $temp =  $resultado['id_preg_prof'];
                              if($n_counter[$temp]!=0){
                                $v_counter[$temp] = $v_counter[$temp]/$n_counter[$temp];
                              }else{
                                $v_counter[$temp] = 0;
                              }

                              $dates = $dates."\"".$resultado['id_preg_prof']."\",";
                              $values = $values.$v_counter[$temp].",";
                              
                            }
                            $dates = trim($dates,",");
                            $values = trim($values,",");
                            ?>

                            <canvas id="myChart"></canvas>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
                            <script type="text/javascript">
                              var ctx = document.getElementById('myChart').getContext('2d');
                              var chart = new Chart(ctx, {
                                  // The type of chart we want to create
                                  type: 'bar',

                                  // The data for our dataset
                                  data: {
                                      labels: [<?php  echo $dates;?>],
                                      datasets: [{
                                          label: "Media (<?php  echo $nombre_asig;?>, <?php  echo $nombre_apell;?>)",
                                          backgroundColor: 'rgb(57, 74, 102)',
                                          borderColor: 'rgb(100, 113, 135)',
                                          data: [<?php  echo $values;?>],
                                      }]
                                  },

                                  // Configuration options go here
                                  options:  {
                                    responsive: true,
                                    legend: {
                                        position: 'top',
                                    },
                                    scales: {
                                        yAxes: [{
                                                display: true,
                                                ticks: {
                                                    beginAtZero: true,
                                                    steps: 5,
                                                    stepValue: 1,
                                                    max: 5
                                                }
                                            }]
                                    }
                                }
                              });
                            </script>

                            <?php

                          }else{

                            //Filtrado por asignatura
                            //Tomar el nombre de la asignatura
                            $instruccion ="SELECT nombre FROM asignatura where id_asignatura =\"$asignatura\";";
                            $res = mysqli_query($mysqli, $instruccion)
                            or die("Error al tomar las respuestas");
                            $nombre = mysqli_fetch_assoc($res);
                            $nombre_asig = utf8_encode($nombre['nombre']);

                            $instruccion ="SELECT id_preg_prof,respuesta FROM respuestasprof where id_asignatura =\"$asignatura\";";
                            $res = mysqli_query($mysqli, $instruccion)
                            or die("Error al tomar las respuestas");

                            $query ="SELECT * FROM preguntasprof;";
                            $select = mysqli_query($mysqli, $query)
                            or die("Error al tomar el numero de rows de preguntasprof");
                            

                            $v_counter = array();
                            $n_counter = array();
                            while($resultado = mysqli_fetch_assoc($res)){
                              //Ignoramos la respuestas NS/NC
                              if($resultado['respuesta'] != 0){  
                                $temp = $resultado['id_preg_prof'];
                                $v_counter[$temp] += $resultado['respuesta'];
                                $n_counter[$temp] += 1;
                              }
                            }
                            $dates = "";
                            $values ="";
                            while($resultado = mysqli_fetch_assoc($select)){
                              $temp =  $resultado['id_preg_prof'];
                              if($n_counter[$temp]!=0){
                                $v_counter[$temp] = $v_counter[$temp]/$n_counter[$temp];
                              }else{
                                $v_counter[$temp] = 0;
                              }

                              $dates = $dates."\"".$resultado['id_preg_prof']."\",";
                              $values = $values.$v_counter[$temp].",";
                              
                            }
                            $dates = trim($dates,",");
                            $values = trim($values,",");
                            ?>

                            <canvas id="myChart"></canvas>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
                            <script type="text/javascript">
                              var ctx = document.getElementById('myChart').getContext('2d');
                              var chart = new Chart(ctx, {
                                  // The type of chart we want to create
                                  type: 'bar',

                                  // The data for our dataset
                                  data: {
                                      labels: [<?php  echo $dates;?>],
                                      datasets: [{
                                          label: "Media (<?php  echo $nombre_asig;?>)",
                                          backgroundColor: 'rgb(57, 74, 102)',
                                          borderColor: 'rgb(100, 113, 135)',
                                          data: [<?php  echo $values;?>],
                                      }]
                                  },

                                  // Configuration options go here
                                  options:  {
                                    responsive: true,
                                    legend: {
                                        position: 'top',
                                    },
                                    scales: {
                                        yAxes: [{
                                                display: true,
                                                ticks: {
                                                    beginAtZero: true,
                                                    steps: 5,
                                                    stepValue: 1,
                                                    max: 5
                                                }
                                            }]
                                    }
                                }
                              });
                            </script>

                            <?php

                          }
                          
                        }else{

                          //Filtrado por profesor
                          $instruccion ="SELECT nombre,apellidos FROM profesor where id_profesor =\"$profesor\";";
                          $res = mysqli_query($mysqli, $instruccion)
                          or die("Error al tomar las respuestas");
                          $nombre = mysqli_fetch_assoc($res);
                          $nombre_apell = utf8_encode($nombre['nombre'])." ".utf8_encode($nombre['apellidos']);

                          $instruccion ="SELECT id_preg_prof,respuesta FROM respuestasprof where id_profesor =\"$profesor\";";
                          $res = mysqli_query($mysqli, $instruccion)
                          or die("Error al tomar las respuestas");

                          $query ="SELECT * FROM preguntasprof;";
                          $select = mysqli_query($mysqli, $query)
                          or die("Error al tomar el numero de rows de preguntasprof");
                          

                          $v_counter = array();
                          $n_counter = array();
                          while($resultado = mysqli_fetch_assoc($res)){
                            //Ignoramos la respuestas NS/NC
                            if($resultado['respuesta'] != 0){  
                              $temp = $resultado['id_preg_prof'];
                              $v_counter[$temp] += $resultado['respuesta'];
                              $n_counter[$temp] += 1;
                            }
                          }
                          $dates = "";
                          $values ="";
                          while($resultado = mysqli_fetch_assoc($select)){
                            $temp =  $resultado['id_preg_prof'];
                            if($n_counter[$temp]!=0){
                              $v_counter[$temp] = $v_counter[$temp]/$n_counter[$temp];
                            }else{
                              $v_counter[$temp] = 0;
                            }

                            $dates = $dates."\"".$resultado['id_preg_prof']."\",";
                            $values = $values.$v_counter[$temp].",";
                            
                          }
                          $dates = trim($dates,",");
                          $values = trim($values,",");
                          ?>

                          <canvas id="myChart"></canvas>
                          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
                          <script type="text/javascript">
                            var ctx = document.getElementById('myChart').getContext('2d');
                            var chart = new Chart(ctx, {
                                // The type of chart we want to create
                                type: 'bar',

                                // The data for our dataset
                                data: {
                                    labels: [<?php  echo $dates;?>],
                                    datasets: [{
                                        label: "Media (<?php  echo $nombre_apell;?>)",
                                        backgroundColor: 'rgb(57, 74, 102)',
                                        borderColor: 'rgb(100, 113, 135)',
                                        data: [<?php  echo $values;?>],
                                    }]
                                },

                                // Configuration options go here
                                options:  {
                                  responsive: true,
                                  legend: {
                                      position: 'top',
                                  },
                                  scales: {
                                      yAxes: [{
                                              display: true,
                                              ticks: {
                                                  beginAtZero: true,
                                                  steps: 5,
                                                  stepValue: 1,
                                                  max: 5
                                              }
                                          }]
                                  }
                              }
                            });
                          </script>

                          <?php
                        }
                        
                     }else{
                        print ("No es posible realizar el filtrado, no se ha seleccionado ningun filtro.\n");
                     }
              
                     
                  }
              ?>
             <P>[ <A HREF='resultados.php' style="color:#4d668e;">Seleccionar otro filtro</A> ]</P>
          </div>
        </div>
      </div>
      <div class="col-sm-6" >
        <div class="card" style="background-color:#394a66;border:0px;"> 
          <div class="card-body">
             <?php
             
              $query="SELECT * from preguntasprof";
              $query_res = mysqli_query($mysqli,$query);
              if($res = mysqli_fetch_assoc($query_res)){
                ?>
                
                <div class="table-responsive table-wrapper-scroll-y">               
                <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th scope="col">Enunciado</th>
                  <th scope="col">Posibles Respuestas</th>
                </tr>
                </thead>
                <tbody>
                <?php

                print ("<TR>\n");
                
                print ("<TD>" .  utf8_encode($res['id_preg_prof']) . "</TD>\n");
                print ("<TD>" .  utf8_encode($res['enunciado']) . "</TD>\n");
                print ("</TR>\n");

                while($res = mysqli_fetch_assoc($query_res)){
                  print ("<TR>\n");
                  print ("<TD>" .  utf8_encode($res['id_preg_prof']) . "</TD>\n");
                  print ("<TD>" .  utf8_encode($res['enunciado']) . "</TD>\n");
                  print ("</TR>\n");
                }
                print("</tbody>");
                print("</table>");
                print ("<BR>\n");
              }
              ?>
             </div>
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