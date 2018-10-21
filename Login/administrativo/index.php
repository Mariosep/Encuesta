<!DOCTYPE html>
<html lang="en">
<head>
  <title>Congreso 2019</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <link rel="stylesheet" type="text/css" href="estilo.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <style>
	.navbar {
		padding-top: 15px;
		padding-bottom: 15px;
		border: 0;
		border-radius: 0;
		margin-bottom: 0;
		font-size: 12px;
		letter-spacing: 5px;
		background-color: #213b5b;

	}
	.navbar-nav  li a:hover {
		color: #1abc9c !important;
	}

	.navbar-nav li a{
		color: #ffffff !important;
	}

	.navbar-header a{
		color: #ffffff !important;
	}
	.carousel-control.right, .carousel-control.left {
    background-image: none;
    color: #2e4166;
	}

	.carousel-indicators li {
	    border-color: #2e4166;
	}

	.carousel-indicators li.active {
	    background-color: #2e4166;
	}

	.item h4 {
	    font-size: 19px;
	    color: #283544;
	    line-height: 1.375em;
	    font-weight: 400;
	    font-style: italic;
	    margin: 70px 0;
	}

	.item span {
	    font-style: normal;

	}
	div h2{
		color: #283544;
	}
  </style>
</head>
<body id="myPage">
	<nav class="navbar navbar-default">
	  <div class="container">
	    <div class="navbar-header">
	    		     <a class="navbar-brand" href="#myPage"> <img src="UcaLogo.png" class="img-responsive" 
	      style="width:200px;" alt="congreso"></a>
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>                        
	      </button>

	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="#">Inicio</a></li>
	        <li><a href="#">Insertar Pregunta Personal</a></li>
	        <li><a href="#">Insertar Pregunta Profesorado</a></li>
	        <li><a href="#">Insertar Profesor</a></li>
	        <li><a href="#">Eliminar Preguntas Personales</a></li>
	        <li><a href="#">Eliminar Preguntas Personales</a></li>
	        <li><a href="#">Eliminar Profesores</a></li>
	        <li><a href="#">Ver Respuestas</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	


	<footer class="container-fluid bg-4 text-center">
		<a href="#myPage" title="To Top">
    		<span class="glyphicon glyphicon-chevron-up"></span>
  		</a>
		<p>Realizado por Adrián Quirós Martín y Mario Sepúlveda Cornejo</p> 
	</footer>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	
	<script>
	$(document).ready(function(){
	  // Add smooth scrolling to all links in navbar + footer link
	  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
	    // Make sure this.hash has a value before overriding default behavior
	    if (this.hash !== ""){
	      // Prevent default anchor click behavior
	      event.preventDefault();

	      // Store hash
	      var hash = this.hash;

	      // Using jQuery's animate() method to add smooth page scroll
	      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
	      $('html, body').animate({
	        scrollTop: $(hash).offset().top
	      }, 900, function(){
	   
	        // Add hash (#) to URL when done scrolling (default click behavior)
	        window.location.hash = hash;
	      });
	    } // End if
	  });
	})
	</script>

  	
</body>
</html>