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
          <li class="nav-item">
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
        </ul>
      </div>
    </nav>
    <!--End Navbar-->
    <div class="container-fluid bg-1 ">
    <div class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4" >
        
        <form action="./resultados_personal_POST.php" method=post>
          <div class="card" style="background-color:#394a66;border:0px;margin-bottom: 190px;"> 
              <div class="card-body" >
                   <div class="row">
                    <div class="col-sm-12" >
                      <h2 class="card-title text-center">Filtrado por asignatura</h2>
                      <div class="form-group">
                          <select class="form-control" id="exampleFormControlSelect1" name="asignatura">
                             <?php

                                  $query="SELECT * from asignatura";
                                  $query_res = mysqli_query($mysqli,$query);
                                  print("<option value=".NULL.">"."Sin seleccionar"."</option>");
                                  while($res =  mysqli_fetch_assoc($query_res)){
                                    print("<option value=".$res['id_asignatura'].">".utf8_encode($res['nombre'])."</option>");
                                  }
                             ?>
                          </select>
                      </div> 
                    </div>
                    
                </div>
                <div class="form-group">                         
                      <button type="submit" name="filtrar" class="btn btn-primary">Filtrar</button>
                </div>
                  
              </div>
          </div>
        </form>
       
          
      </div>
      <div class="col-sm-4"></div>
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