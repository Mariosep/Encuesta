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
      max-height: 180px;
      overflow-y: auto;
      -ms-overflow-style: -ms-autohiding-scrollbar;
    }
    .table2{
      display: block;
      max-height: 263px;
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
            <a class="nav-link" href="./resultados.php">Ver Resultados</a>
          </li>
        </ul>
        </ul>
      </div>
    </nav>
    <!--End Navbar-->
    <div class="container-fluid bg-1 ">
    <div class="row">
      <div class="col-sm-5" >
        
        <form action="./tipo_subtipo_POST.php" method=post>
          <div class="card" style="background-color:#394a66;border:0px;"> 

              <div class="card-body" >
                  <h2 class="card-title text-center">Añadir Tipo</h2>
                  <div class="form-group">
                      <label for="tipo" class="col-form-label">Típo</label>
                      <textarea class="form-control" rows="4" id="tipo" placeholder="Escriba el nombre del Tipo a añadir" name="tipo" required></textarea> 
                      
                      
                  </div>                  
                  <div class="form-group">                         
                  <button type="submit" name="añadir_tipo" class="btn btn-primary mb-2">Añadir</button>
                  </div>
                  
              </div>
          </div>
        </form>
       
          
      </div>
      <div class="col-sm-7">
        <div class="card" style="background-color:#394a66;border:0px;"> 
          <div class="card-body" >
          <?php
              
             
              $query="SELECT * from tipopreguntaprof";
              $query_res = mysqli_query($mysqli,$query);
              if($res = mysqli_fetch_assoc($query_res)){
                ?>
                <form action='./tipo_subtipo_POST.php' method='post'>
                <div class="table-responsive table-wrapper-scroll-y ">               
                <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th scope="col">Nombre del Tipo</th>
                  <th scope="col">Seleccionar</th>
                </tr>
                </thead>
                <tbody>
                <?php

                print ("<TR>\n");
                
                print ("<TD>" .  utf8_encode($res['nombre_tipo']) . "</TD>\n");
                print ("<TD><INPUT TYPE='CHECKBOX' NAME='borrar_tipo[]' VALUE='" .
                $res['cod_tip'] . "'></TD>\n");
                print ("</TR>\n");

                while($res = mysqli_fetch_assoc($query_res)){
                  print ("<TR>\n");
                  
                  print ("<TD>" .  utf8_encode($res['nombre_tipo']) . "</TD>\n");
                  print ("<TD><INPUT TYPE='CHECKBOX' NAME='borrar_tipo[]' VALUE='" .
                  $res['cod_tip'] . "'></TD>\n");
                  print ("</TR>\n");
                }
                print("</tbody>");
                print("</table>");
                print ("<BR>\n");
                ?>
                
                </div><br>
                <div class="form-group">                         
                    <button type="submit" name="eliminar_tipo" class="btn btn-primary mb-2">Eliminar</button>
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
  <div class="container-fluid bg-1 ">
    <div class="row">
      <div class="col-sm-5" >
        
        <form action="./tipo_subtipo_POST.php" method=post>
          <div class="card" style="background-color:#394a66;border:0px;"> 

              <div class="card-body" >
                  <h2 class="card-title text-center">Añadir Subtipo</h2>
                  <div class="form-group">
                      <label for="subtipo" class="col-form-label">Subtipo</label>
                      <textarea class="form-control" rows="4" id="subtipo" placeholder="Escriba el nombre del Subtipo a añadir" name="subtipo" required></textarea> 
                      
                      
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
                  <button type="submit" name="añadir_subtipo" class="btn btn-primary mb-2">Añadir</button>
                  </div>
                  
              </div>
        </form>
       
          
      </div>
      <div class="col-sm-7">
        <div class="card" style="background-color:#394a66;border:0px;"> 
          <div class="card-body" >
          <?php
              $query="SELECT * from subtipopreguntaprof";
              $query_res = mysqli_query($mysqli,$query);
              if($res = mysqli_fetch_assoc($query_res)){
                ?>
                <form action='./tipo_subtipo_POST.php' method='post'>
                <div class="table-responsive table-wrapper-scroll-y table2">               
                <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th scope="col">Nombre del Subtipo</th>
                  <th scope="col">Seleccionar</th>
                </tr>
                </thead>
                <tbody>
                <?php

                print ("<TR>\n");
                
                print ("<TD>" .  utf8_encode($res['nombre_subtipo']) . "</TD>\n");
                print ("<TD><INPUT TYPE='CHECKBOX' NAME='borrar_subtipo[]' VALUE='" .
                $res['cod_sub_tip'] . "'></TD>\n");
                print ("</TR>\n");

                while($res = mysqli_fetch_assoc($query_res)){
                  print ("<TR>\n");
                  
                  print ("<TD>" .  utf8_encode($res['nombre_subtipo']) . "</TD>\n");
                  print ("<TD><INPUT TYPE='CHECKBOX' NAME='borrar_subtipo[]' VALUE='" .
                  $res['cod_sub_tip'] . "'></TD>\n");
                  print ("</TR>\n");
                }
                print("</tbody>");
                print("</table>");
                print ("<BR>\n");
                ?>
                
                </div><br>
                <div class="form-group">                         
                    <button type="submit" name="eliminar_subtipo" class="btn btn-primary mb-2">Eliminar</button>
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