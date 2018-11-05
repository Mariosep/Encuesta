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
      <a class="navbar-brand" href="#">Ver Resultado(s) de Pregunta(s) personal(es)</a>
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
          <li class="nav-item active">
            <a class="nav-link" href="./resultados_personal.php">Ver Resultado(s) de Pregunta(s) personal(es)<span class="sr-only">(current)</span></a>
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
              <script type="text/javascript">
                var nChart = 1;
              </script>

              <?php
                  if (isset($filtrar))
                  {
                     if($asignatura != "" )
                     {
                        //Filtrado por asignatura
                        //Tomar el nombre de la asignatura
                        $instruccion ="SELECT nombre FROM asignatura where id_asignatura =\"$asignatura\";";
                        $res = mysqli_query($mysqli, $instruccion)
                        or die("Error al tomar las respuestas");
                        $asignatura = mysqli_fetch_assoc($res);
                        $nombre_asig = utf8_encode($asignatura['nombre']);

                        $query ="SELECT * FROM preguntasus;";
                        $preguntasprof= mysqli_query($mysqli, $query)or die("Error al tomar las preguntasprof");

                        

                        foreach ($preguntasprof as $key) {
                            $dates = "";
                            $values ="";

                            $id_preg_prof = utf8_encode($key['id_preg_prof']);
                            $enunciado = utf8_encode($key['enunciado']);
                            $op_respuesta = explode("&",utf8_encode($key["op_respuesta"])); 

                            $query = "SELECT count(*) FROM respuestasus WHERE id_asignatura = ".utf8_encode($asignatura['id_asignatura']);
                            $numRespTotal =  mysqli_query($mysqli, $query)or die("Error al contar total de veces");
                            $numRespTotal = utf8_encode(mysqli_fetch_row($numRespTotal));

                            for ($z = 0; $z < count($op_respuesta); $z++) {
                                $query = "SELECT count(*) FROM respuestasus WHERE id_asignatura = ".utf8_encode($asignatura['id_asignatura']).", id_preg_us = ".$id_preg_prof.", respuesta = ".$z;
                                $numResp = mysqli_query($mysqli, $query)or die("Error al contar veces");
                                $numResp = utf8_encode(mysqli_fetch_row($num));

                                $porcentaje[$z] = $numResp/$numRespTotal;

                                $dates = $dates."\"".$op_respuesta[$z]."\",";
                                $values = $values.$porcentaje[$z].",";
                            }

                            $dates = trim($dates,",");
                            $values = trim($values,",");

                          ?>

                        <canvas id="myChart"></canvas>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
                        <script type="text/javascript">
                          var chartName = "Chart " + nChart;
                          var ctx = document.getElementById(chartName).getContext('2d');
                          nChart++;
                          var myData = [<?php  echo $values;?>];
                          var colorPallete = [];
                          var dynamicColors = function() {
                            var r = Math.floor(Math.random() * 255);
                            var g = Math.floor(Math.random() * 255);
                            var b = Math.floor(Math.random() * 255);
                            return "rgb(" + r + "," + g + "," + b + ")";
                          };
                          for (var i in myData) {
                            colorPallete.push(dynamicColors());
                         }
                          var chart = new Chart(ctx, {
                              // The type of chart we want to create
                              type: 'doughnut',

                              // The data for our dataset
                              data: {
                                  labels: [<?php  echo $dates;?>],
                                  datasets: [{
                                      
                                      borderColor: 'rgb(100, 113, 135)',
                                      data: myData,
                                      backgroundColor: colorPallete
                                  }]
                              },

                              // Configuration options go here
                              options:  {
                              responsive: true,
                              legend: {
                                  position: 'bottom',
                              },
                              hover: {
                                  mode: 'label'
                              },
                              title: {
                                  display: true,
                                  text: '<?php  echo $nombre_asig;?>'
                              }
                            }
                          });
                        </script>
                           


                        }

                       /*$instruccion ="SELECT id_preg_prof,respuesta FROM respuestasus where id_asignatura =\"$asignatura\";";
                        $res = mysqli_query($mysqli, $instruccion)
                        or die("Error al tomar las respuestas");

                        $query ="SELECT * FROM preguntasus;";
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
                        */
                        

                        

                        <?php                  
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