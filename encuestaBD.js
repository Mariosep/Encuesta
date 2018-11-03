$(document).ready(function() {

	$( "form" ).submit(function( event ) {
	  if ($("#select-asignatura").val() == 0 ) {
		alert("Debe seleccionar una asignatura.");
		event.preventDefault();
	  }

	  if($("select[name=prof-1]").val() == 0){
	  	alert("Debe seleccionar un profesor.");
	  	event.preventDefault();
	  }

	   /*if($("select[name=prof-1]").val() == 0){
	  	alert("El profesor debe impartir la asignatura seleccionada.");
	  	event.preventDefault();*/
	  //}
	})

	$("select[name=prof-1]").change(function() {
		if($("select[name=prof-1]").val() != 0)
			$(".resp-prof-1").prop('required', true);	
		else
			$(".resp-prof-1").prop('required', false);	
	});

	$("select[name=prof-2]").change(function() {
		if($("select[name=prof-2]").val() != 0)
			$(".resp-prof-2").prop('required', true);
		else
			$(".resp-prof-2").prop('required', false);	
	});

	$("select[name=prof-3]").change(function() {
		if($("select[name=prof-3]").val() != 0)
			$(".resp-prof-3").prop('required', true);
		else
			$(".resp-prof-3").prop('required', false);	
	});

	
});