$(window).load(function(){
    $(".descriptionCourse").mCustomScrollbar();
});

	$(document).ready(function(){

	var boton = document.getElementById("video");

	 var v = document.getElementsByTagName("video")[0];
	var video = false;

	boton.addEventListener("click", function(){
	  if (!video) {
	    v.play();
	    video = true;
	    $("#playVideo").hide("slow");
	  } else {
	    v.pause();
	    video = false;
	    $("#playVideo").show(1000);
	  }
	});

  $("#owl-description").owlCarousel({
    autoPlay : 3000,
 navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
          autoHeight : true
    });
 

  $("#owl-reservation").owlCarousel({
 	  navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
          autoHeight : true
   });
 
});

