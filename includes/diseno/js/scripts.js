	        $(document).ready(function(){
				$(".check").uniform();      
	            // $(".contentScroll").mCustomScrollbar();
	            // $(".contentScroll2").mCustomScrollbar();
	            // $(".contentCondition").mCustomScrollbar();

	            // $(".scrollDoc").mCustomScrollbar();

				$('.sliderContract').owlCarousel({
				    navigation:true,
		 			autoplayHoverPause:true,
		 		    loop:true,
				    responsiveClass:true,
				    responsive:{
				        0:{
				            items:1,
				            nav:true
				        },
				        600:{
				            items:3,
				            nav:true
				        },
				        1366:{
				            items:4,
				            nav:true,
				            loop:false
				        }
				    }
				})


				$("#select-category").click(function(){
					$(".toggle-category").toggle();
				});		

	        	$(".listOrder").click(function(){
	        		$(".contentScroll").show(900);
	        		$(".contentScroll2").hide("fast");
	        		$(".previewOrder").css("opacity", "0.5");
	        		$(".listOrder").css("opacity", "1");
	        	});
	        	$(".previewOrder").click(function(){
	        		$(".contentScroll").hide("fast");
			  		$(".contentScroll2").show(1000);
  	        		$(".previewOrder").css("opacity", "1");
	        		$(".listOrder").css("opacity", "0.5");

	        	});

	        	$(".menuBar").click(function(){
	        		$(".toggleBar").slideToggle();
	        	});

	        	$(".plus").click(function(){
	        		$(".togglePlus").slideToggle();
	        	});


	        });


