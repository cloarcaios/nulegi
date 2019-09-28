jQuery(document).ready(function($){
	var gallery = $('.cd-gallery'),
		foldingPanel = $('.cd-folding-panel'),
		mainContent = $('.cd-main');
	/* open folding content */
	gallery.on('click', 'a', function(event){
		event.preventDefault();
		openItemInfo($(this).attr('href'));
	});

	/* close folding content */
	foldingPanel.on('click', '.cd-close', function(event){
		event.preventDefault();
		toggleContent('', false);
	});
	gallery.on('click', function(event){
		/* detect click on .cd-gallery::before when the .cd-folding-panel is open */
		if($(event.target).is('.cd-gallery') && $('.fold-is-open').length > 0 ) toggleContent('', false);
	})

	function openItemInfo(url) {
		var mq = viewportSize();
		if( gallery.offset().top > $(window).scrollTop() && mq != 'mobile') {
			/* if content is visible above the .cd-gallery - scroll before opening the folding panel */
			$('body,html').animate({
				'scrollTop': gallery.offset().top
			}, 100, function(){ 
	           	toggleContent(url, true);
	        }); 
	    } else if( gallery.offset().top + gallery.height() < $(window).scrollTop() + $(window).height()  && mq != 'mobile' ) {
			/* if content is visible below the .cd-gallery - scroll before opening the folding panel */
			$('body,html').animate({
				'scrollTop': gallery.offset().top + gallery.height() - $(window).height()
			}, 100, function(){ 
	           	toggleContent(url, true);
	        });
		} else {
			toggleContent(url, true);
		}
	}

	function toggleContent(url, bool) {
		if( bool ) {
			/* load and show new content */
			/*
				CARLOS LOARCA: 13/10/15
				MODIFICACION: Cambio de la forma de insertar el contenido.
			*/
			//var foldingContent = foldingPanel.find('.cd-fold-content');
			/*
			foldingContent.load(url+' .cd-fold-content > *', function(event){
				setTimeout(function(){
					$('body').addClass('overflow-hidden');
					foldingPanel.addClass('is-open');
					mainContent.addClass('fold-is-open');
				}, 100);
				
			});*/
			var contenido = '';
			switch(url){
				case 'item-1.html':
					contenido = jQuery('#art_contratos').html();
					break;
				case 'item-2.html':
					contenido = jQuery('#art_documentos').html();
					archivos_ver = 1;
					var hash = location.hash.replace('#','');
				    if(hash != ''){
				        // Show the hash if it's set
				        //alert(hash);
				        // Clear the hash in the URL
				        location.hash = carpeta;
				    }
					break;
				case 'item-3.html':
					contenido = jQuery('#art_perfil').html();
					var acor = setInterval(function(){
						$('#tabs').tabs({
				    		active:0
				    	});	
					}, 300);
					setInterval(function(){
						clearInterval(acor);
					}, 800);
					break;
				case 'item-4.html':
					contenido = jQuery('#art_contratos').html();
					break;
			}
			jQuery('.cd-fold-content').html(contenido);
			setTimeout(function(){
				$('body').addClass('overflow-hidden');
				foldingPanel.addClass('is-open');
				mainContent.addClass('fold-is-open');
			}, 100);
		} else {
			/* close the folding panel */
			var mq = viewportSize();
			foldingPanel.removeClass('is-open');
			mainContent.removeClass('fold-is-open');
			
			(mq == 'mobile' || $('.no-csstransitions').length > 0 ) 
				/* according to the mq, immediately remove the .overflow-hidden or wait for the end of the animation */
				? $('body').removeClass('overflow-hidden')
				
				: mainContent.find('.cd-item').eq(0).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
					$('body').removeClass('overflow-hidden');
					mainContent.find('.cd-item').eq(0).off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend');
				});
		}
		
	}

	function viewportSize() {
		/* retrieve the content value of .cd-main::before to check the actua mq */
		return window.getComputedStyle(document.querySelector('.cd-main'), '::before').getPropertyValue('content').replace(/"/g, "").replace(/'/g, "");
	}
});