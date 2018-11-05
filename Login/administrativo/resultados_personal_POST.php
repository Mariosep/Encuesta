<!DOCTYPE html>
<html lang="en">
<head>

  <title>Encuesta</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
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
    .canvas-container{

      width:300px ;
      height:300px ;
      margin-bottom: 50px;

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
          <li class="nav-item">
            <a class="nav-link" href="./resultados.php">Ver Resultado(s) de Pregunta(s) profesorado</a>
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
      <div class="col-sm-12" >
        <div class="card" style="background-color:#d0daea;border:0px;"> 
          <div class="card-body">
              <script type="text/javascript">
                var nChart = 1;
              </script>
              <?php
                $instruccion ="SELECT * FROM asignatura where id_asignatura =\"$asignatura\";";
                $res = mysqli_query($mysqli, $instruccion)
                or die("Error al tomar las respuestas");
                $asignatura = mysqli_fetch_assoc($res);
                $nombre_asig = utf8_encode($asignatura['nombre']);
                echo "<h1 class='text-center' style='color:black;margin-bottom:50px;'>$nombre_asig</h1>";
              ?>
              
              <div class="row">
              <?php
                  $nChart = 1;
                  if (isset($filtrar))
                  {
                     if($asignatura != "" )
                     {
                        //Filtrado por asignatura
                        //Tomar el nombre de la asignatura

                        $query ="SELECT * FROM preguntasus;";
                        $preguntasus= mysqli_query($mysqli, $query)or die("Error al tomar las preguntasus");

                        
                        foreach ($preguntasus as $key) {
                            $dates = "";
                            $values ="";

                            $id_asignatura = $asignatura['id_asignatura'];
                            $id_preg_us = utf8_encode($key['id_preg_us']);
                            $enunciado = utf8_encode($key['enunciado']);
                            $op_respuesta = explode("&",utf8_encode($key["op_respuesta"])); 

                            $query = "SELECT count(id_asignatura) FROM respuestasus WHERE id_asignatura = ".$id_asignatura." and id_preg_us = 1";
                            $numRespTotal =  mysqli_query($mysqli, $query)or die("Error al contar total de veces");
                            $numRespTotal = mysqli_fetch_row($numRespTotal);

                            for ($z = 0; $z < count($op_respuesta); $z++) {
                                $query = "SELECT count(*) FROM respuestasus WHERE id_asignatura = ".$id_asignatura." and id_preg_us = ".$id_preg_us." and respuesta = ".$z;
                                $numResp = mysqli_query($mysqli, $query)or die("Error al contar veces");
                                $numResp = mysqli_fetch_row($numResp);

                                if($numRespTotal[0] == 0){
                                  $porcentaje[$z] = 0;
                                }
                                else{
                                  $porcentaje[$z] = ($numResp[0]/$numRespTotal[0])*100;
                                }

                                $dates = $dates."\"".$op_respuesta[$z]."\",";
                                $values = $values.$porcentaje[$z].",";
                            }

                            $dates = trim($dates,",");
                            $values = trim($values,",");

                           
                          
                            $chartName = "Chart".$nChart;
                            ?><div class = 'canvas-container'><?php
                            echo "<canvas id=".$chartName."></canvas>";
                            echo "</div>";
                        
                        $nChart++;
                        ?>
                        
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
                        <script type="text/javascript">
                          
                         
                            var ctx = document.getElementById('Chart'+nChart);
                            nChart++;
                            
                            var myData = [<?php  echo $values;?>];
                            var colorPallete = [];
                            var dynamicColors = function(i) {
                              switch(i){
                                case 1:
                                  return "rgb(" + 226 + "," + 27 + "," + 27 + ")";
                                case 2:
                                  return "rgb(" + 0 + "," + 0 + "," + 255 + ")";
                                case 3:
                                  return "rgb(" + 45 + "," + 226 + "," + 45 + ")";
                                case 4:
                                  return "rgb(" + 247 + "," + 243 + "," + 17 + ")";
                                  break;
                                case 5:
                                  return "rgb(" + 255 + "," + 128 + "," + 0 + ")";
                                case 6:
                                  return "rgb(" + 255 + "," + 0 + "," + 191 + ")";

                                default:
                                   var r = Math.floor(Math.random() * 255);
                                    var g = Math.floor(Math.random() * 255);
                                    var b = Math.floor(Math.random() * 255);
                                    return "rgb(" + r + "," + g + "," + b + ")";

                              }
                             
                            };
                            var cont = 1;
                            for (var i in myData) {
                              colorPallete.push(dynamicColors(cont));
                              cont++;
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
                                responsize : true,
                                legend: {
                                    position: 'bottom',
                                },
                                hover: {
                                    mode: 'label'
                                },
                                title: {
                                    display: true,
                                    text: '<?php  echo $enunciado;?>'
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
             
           </div>
           <br>
           <P>[ <A HREF='resultados_personal.php' style="color:#4d668e;">Seleccionar otro filtro</A> ]</P>
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
     
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>