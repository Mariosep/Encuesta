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
      max-height: 550px;
      overflow-y: auto;
      -ms-overflow-style: -ms-autohiding-scrollbar;
    }
  </style>
</head>
<body id="myPage">
  <?php
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
            <a class="nav-link" href="#">Añadir/Eliminar Pregunta(s) profesorado<span class="sr-only">(current)</span></a>
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
          <li class="nav-item">
            <a class="nav-link" href="./resultados_personal.php">Ver Resultado(s) de Pregunta(s) personal(es)</a>
          </li>
        </ul>
        </ul>
      </div>
    </nav>
  	<!--End Navbar-->
  	<div class="container-fluid bg-1 ">
		<div class="row">
			<div class="col-sm-5" >
        
        <form action="./pregunta_profesor_POST.php" method=post>
          <div class="card" style="background-color:#394a66;border:0px;"> 

              <div class="card-body" >
                  <h2 class="card-title text-center">Añadir Pregunta</h2>
                  <div class="form-group">
                      <label for="enunciado" class="col-form-label">Enunciado</label>
                      <textarea class="form-control" rows="2" id="enunciado" placeholder="Escriba el enunciado" name="enunciado" required></textarea> 
                      
                      
                  </div>
                  
                  <div class="form-group">
                      <label for="resp_op" class="col-form-label">Respuestas posibles</label> 
                      <textarea class="form-control" rows="6" id="resp_op" placeholder="Añada las respuestas posibles separadas por &" name="res_op" required></textarea>                     
                      
                  </div>
                  <div class="form-group"> 
                      <label for="exampleFormControlSelect1">Tipo al que pertenece</label>
                      <select class="form-control" id="exampleFormControlSelect1" name="tipo_select">
                         <?php

                              $query="SELECT * from tipopreguntaprof";
                              $query_res = mysqli_query($mysqli,$query);
                              while($res =  mysqli_fetch_assoc($query_res)){
                                print("<option value=".$res['cod_tip'].">".utf8_encode($res['nombre_tipo'])."</option>");
                              }
                         ?>
                      </select>
                  </div> 
                  <div class="form-group"> 
                      <label for="exampleFormControlSelect1">Subtipo al que pertenece</label>
                      <select class="form-control" id="exampleFormControlSelect1" name="subtipo_select">
                         <?php

                              $query="SELECT * from subtipopreguntaprof";
                              $query_res = mysqli_query($mysqli,$query);
                              print("<option value=".NULL.">"."No pertenece a ningún Subtipo"."</option>");
                              while($res =  mysqli_fetch_assoc($query_res)){
                                print("<option value=".$res['cod_sub_tip'].">".utf8_encode($res['nombre_subtipo'])."</option>");
                              }
                         ?>
                      </select>
                  </div> 
                  <div class="form-group">                         
                  <button type="submit" name="añadir" class="btn btn-primary mb-2">Añadir</button>
                  </div>
                  
              </div>
          </div>
        </form>
       
				  
			</div>
      <div class="col-sm-7">
        <div class="card" style="background-color:#394a66;border:0px;"> 
          <div class="card-body" >
          <?php
             
              $query="SELECT * from preguntasprof";
              $query_res = mysqli_query($mysqli,$query);
              if($res = mysqli_fetch_assoc($query_res)){
                ?>
                <form action='./pregunta_profesor_POST.php' method='post'>
                <div class="table-responsive table-wrapper-scroll-y">               
                <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th scope="col">Enunciado</th>
                  <th scope="col">Posibles Respuestas</th>
                  <th scope="col">Seleccionar</th>
                </tr>
                </thead>
                <tbody>
                <?php

                print ("<TR>\n");
                
                print ("<TD>" .  utf8_encode($res['enunciado']) . "</TD>\n");
                print ("<TD>" .  utf8_encode($res['op_respuesta']). "</TD>\n");
                print ("<TD><INPUT TYPE='CHECKBOX' NAME='borrar[]' VALUE='" .
                $res['id_preg_prof'] . "'></TD>\n");
                print ("</TR>\n");

                while($res = mysqli_fetch_assoc($query_res)){
                  print ("<TR>\n");
                  
                  print ("<TD>" .  utf8_encode($res['enunciado']) . "</TD>\n");
                  print ("<TD>" .  utf8_encode($res['op_respuesta']). "</TD>\n");
                  print ("<TD><INPUT TYPE='CHECKBOX' NAME='borrar[]' VALUE='" .
                  $res['id_preg_prof'] . "'></TD>\n");
                  print ("</TR>\n");
                }
                print("</tbody>");
                print("</table>");
                print ("<BR>\n");
                ?>
                
                </div><br>
                <div class="form-group">                         
                    <button type="submit" name="eliminar" class="btn btn-primary mb-2">Eliminar</button>
                </div>
                </form>
                
                <?php
              }
            ?>
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