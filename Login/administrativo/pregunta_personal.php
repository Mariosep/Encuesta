<!DOCTYPE html>
<html lang="en">
<head>

	<title>Congreso 2019</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body id="myPage">
 
	<!--Navbar-->
	<nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Insertar/Eliminar Pregunta(s) personal(es)</a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="navbarsExample01" >
        <ul class="navbar-nav mr-auto">
          <li class="nav-item ">
            <a class="nav-link" href="./index.php">Inicio </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#">Añadir/Eliminar Pregunta(s) personal(es)<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Añadir/Eliminar Pregunta(s) profesorado</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Añadir/Eliminar Profesor</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Añadir/Eliminar Asignatura</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Ver Resultados</a>
          </li>
        </ul>
        </ul>
      </div>
    </nav>
  	<!--End Navbar-->
  	<div class="container-fluid bg-1 ">
		<div class="row">
			<div class="col-sm-5" >
        
        <form action="./pregunta_personal_POST.php" method=post>
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
              $user="root";
              $password="";
              $database="encuesta";


              $mysqli = mysqli_connect("localhost", $user, $password, $database)
              or die ("Error al acceder a la base de datos");
              $query="SELECT * from preguntasus";
              $query_res = mysqli_query($mysqli,$query);
              if($res = mysqli_fetch_assoc($query_res)){
                ?>
                <form action='./pregunta_personal_POST.php' method='post'>
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
                $res['id_preg_us'] . "'></TD>\n");
                print ("</TR>\n");

                while($res = mysqli_fetch_assoc($query_res)){
                  print ("<TR>\n");
                  
                  print ("<TD>" .  utf8_encode($res['enunciado']) . "</TD>\n");
                  print ("<TD>" .  utf8_encode($res['op_respuesta']). "</TD>\n");
                  print ("<TD><INPUT TYPE='CHECKBOX' NAME='borrar[]' VALUE='" .
                  $res['id_preg_us'] . "'></TD>\n");
                  print ("</TR>\n");
                }
                print("</tbody>");
                print("</table>");
                print ("<BR>\n");
                ?>
                
                </div><br>
                <div class="form-group">                         
                    <button type="submit" name="eliminar" class="btn btn-primary mb-2">Eliminar</button>
                    <?php
                        if (isset($eliminar))
                        {
                          echo("<label>¡Pregunta(s) borradas!</label>");
                          unset ($eliminar);
                        }
                    ?>
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