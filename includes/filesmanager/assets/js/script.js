	var ruta_actual = carpeta;
	var seleccionados = new Array();
	var seleccionados_cantidad = 0;
	var filemanager = $('.filemanager'),
		filemanager2 = $('.filemanager2'),
		breadcrumbs = $('.breadcrumbs'),
		breadcrumbs2 = $('.breadcrumbs2'),
		fileList = filemanager.find('.data'),
		fileList2 = filemanager2.find('.data2');

	// Start by fetching the file data from scan.php with an AJAX request
	jQuery('.div_loader').show();
	$.get('../../includes/filesmanager/files/scan.php', { carpeta: carpeta}, function(data) {
		jQuery('.div_loader').hide();
		var response = [data],
			currentPath = '',
			breadcrumbsUrls = [];

		var folders = [],
			files = [];

		// This event listener monitors changes on the URL. We use it to
		// capture back/forward navigation in the browser.

		$(window).on('hashchange', function(){

			goto(window.location.hash);

			// We are triggering the event. This will execute 
			// this function on page load, so that we show the correct folder:

		}).trigger('hashchange');


		// Hiding and showing the search box

		filemanager.find('.search').click(function(){

			var search = $(this);

			//search.find('span').hide();
			search.find('input[type=search]').show().focus();

		});


		filemanager2.find('.search').click(function(){

			var search = $(this);

			//search.find('span').hide();
			search.find('input[type=search]').show().focus();

		});


		// Listening for keyboard input on the search field.
		// We are using the "input" event which detects cut and paste
		// in addition to keyboard input.

		filemanager.find('input').on('input', function(e){

			folders = [];
			files = [];

			var value = this.value.trim();

			if(value.length) {

				filemanager.addClass('searching');

				// Update the hash on every key stroke
				window.location.hash = 'search=' + value.trim();

			}

			else {

				filemanager.removeClass('searching');
				window.location.hash = encodeURIComponent(currentPath);

			}

		}).on('keyup', function(e){

			// Clicking 'ESC' button triggers focusout and cancels the search

			var search = $(this);

			if(e.keyCode == 27) {

				search.trigger('focusout');

			}

		}).focusout(function(e){

			// Cancel the search

			var search = $(this);

			if(!search.val().trim().length) {

				window.location.hash = encodeURIComponent(currentPath);
				//search.hide();
				//search.parent().find('span').show();

			}

		});

		filemanager2.find('input').on('input', function(e){

			folders = [];
			files = [];

			var value = this.value.trim();

			if(value.length) {

				filemanager2.addClass('searching');

				// Update the hash on every key stroke
				window.location.hash = 'search=' + value.trim();

			}

			else {

				filemanager2.removeClass('searching');
				window.location.hash = encodeURIComponent(currentPath);

			}

		}).on('keyup', function(e){

			// Clicking 'ESC' button triggers focusout and cancels the search

			var search = $(this);

			if(e.keyCode == 27) {

				search.trigger('focusout');

			}

		}).focusout(function(e){

			// Cancel the search

			var search = $(this);

			if(!search.val().trim().length) {

				window.location.hash = encodeURIComponent(currentPath);
				//search.hide();
				//search.parent().find('span').show();

			}

		});



		// Clicking on folders

		fileList.on('dblclick', 'li.folders', function(e){
			e.preventDefault();

			var nextDir = $(this).find('a.folders').attr('title');
			ruta_actual = nextDir;
			if(filemanager.hasClass('searching')) {

				// Building the breadcrumbs

				breadcrumbsUrls = generateBreadcrumbs(nextDir);

				filemanager.removeClass('searching');
				//filemanager.find('input[type=search]').val('').hide();
				filemanager.find('input[type=search]').val('');
				filemanager.find('span').show();
			}
			else {
				breadcrumbsUrls.push(nextDir);
			}
			if(ruta_actual != carpeta){
				jQuery('#div_carpeta_borrar').css('display','block');
			}
			else{
				jQuery('#div_carpeta_borrar').css('display','none');
			}
			seleccionados_cantidad = 0;
			window.location.hash = encodeURIComponent(nextDir);
			currentPath = nextDir;
			$(".draggable").draggable();
		    $(".droppable").droppable({
		    	drop: function( event, ui ) {
		    		$(this).css('border', '2px dotted #0B85A1');
		    		ruta_actual = $(this).find("a").attr('title');
		    		var titulo = ui.draggable.find("a").attr('title');
		    		seleccionados_mover = new Array();
		    		seleccionados_mover.push(titulo);
		    		console.log('Ruta actual:'+ruta_actual);
		    		console.log('Seleccionados:'+seleccionados_mover);
		    		console.log('Titulo:'+titulo);
		    		ArchivosMoverConfirmar();
		      	},
		      	over: function(event, ui){
		      		$(this).css('background-color', '#00becd');
		      	},
		      	out: function(event, ui){
		      		$(this).css('background-color', '#043245');
		      	}
		    });
		});

		fileList.on('click', 'li.folders', function(e){
			if(mover == 1){
				jQuery('#div_archivos_pegar').css('display','block');
				jQuery('#div_archivos_mover').css('display','none');
			}
			else{
				jQuery('#div_archivos_pegar').css('display','none');	
			}
			if(jQuery(this).hasClass('seleccionado')){
				jQuery(this).removeClass('seleccionado');
				seleccionados_cantidad--;
				if(seleccionados_cantidad <= 0){
					jQuery('#div_archivos_borrar').css('display', 'none');
					jQuery('#div_archivos_mover').css('display', 'none');
				}
				console.log('Carpeta desseleccionada');
			}
			else{
				seleccionados_cantidad++;
				jQuery('#div_archivos_borrar').css('display', 'block');
				jQuery('#div_archivos_mover').css('display', 'block');
				jQuery(this).addClass('seleccionado');
				var ruta = $(this).find('a.folders').attr('title');
				console.log('Carpeta seleccionada:');
				console.log(ruta);
			}
			$(".draggable").draggable();
		    $(".droppable").droppable({
		    	drop: function( event, ui ) {
		    		$(this).css('border', '2px dotted #0B85A1');
		    		ruta_actual = $(this).find("a").attr('title');
		    		var titulo = ui.draggable.find("a").attr('title');
		    		seleccionados_mover = new Array();
		    		seleccionados_mover.push(titulo);
		    		console.log('Ruta actual:'+ruta_actual);
		    		console.log('Seleccionados:'+seleccionados_mover);
		    		console.log('Titulo:'+titulo);
		    		ArchivosMoverConfirmar();
		      	},
		      	over: function(event, ui){
		      		$(this).css('background-color', '#00becd');
		      	},
		      	out: function(event, ui){
		      		$(this).css('background-color', '#043245');
		      	}
		    });
		});

		fileList.on('click', 'li.files', function(e){
			if(jQuery(this).hasClass('seleccionado')){
				jQuery(this).removeClass('seleccionado');
				seleccionados_cantidad--;
				if(seleccionados_cantidad <= 0){
					jQuery('#div_archivos_borrar').css('display', 'none');
					jQuery('#div_archivos_mover').css('display', 'none');
				}
				console.log('Archivo desseleccionado');
			}
			else{
				seleccionados_cantidad++;
				jQuery('#div_archivos_borrar').css('display', 'block');
				jQuery('#div_archivos_mover').css('display', 'block');
				jQuery(this).addClass('seleccionado');
				var ruta = $(this).find('a.files').attr('title');
				console.log('Archivo seleccionado:');
				console.log(ruta);
			}
			$(".draggable").draggable();
		    $(".droppable").droppable({
		    	drop: function( event, ui ) {
		    		$(this).css('border', '2px dotted #0B85A1');
		    		ruta_actual = $(this).find("a").attr('title');
		    		var titulo = ui.draggable.find("a").attr('title');
		    		seleccionados_mover = new Array();
		    		seleccionados_mover.push(titulo);
		    		console.log('Ruta actual:'+ruta_actual);
		    		console.log('Seleccionados:'+seleccionados_mover);
		    		console.log('Titulo:'+titulo);
		    		ArchivosMoverConfirmar();
		      	},
		      	over: function(event, ui){
		      		$(this).css('background-color', '#00becd');
		      	},
		      	out: function(event, ui){
		      		$(this).css('background-color', '#043245');
		      	}
		    });
		});

		fileList2.on('dblclick', 'div.folders', function(e){
			e.preventDefault();

			var nextDir = $(this).find('a.folders').attr('title');
			ruta_actual = nextDir;
			if(filemanager2.hasClass('searching')) {

				// Building the breadcrumbs

				breadcrumbsUrls = generateBreadcrumbs(nextDir);

				filemanager2.removeClass('searching');
				//filemanager.find('input[type=search]').val('').hide();
				filemanager2.find('input[type=search]').val('');
				filemanager2.find('span').show();
			}
			else {
				breadcrumbsUrls.push(nextDir);
			}
			if(ruta_actual != carpeta){
				jQuery('#div_carpeta_borrar').css('display','block');
			}
			else{
				jQuery('#div_carpeta_borrar').css('display','none');
			}
			seleccionados_cantidad = 0;
			window.location.hash = encodeURIComponent(nextDir);
			currentPath = nextDir;
			$(".draggable").draggable();
		    $(".droppable").droppable({
		    	drop: function( event, ui ) {
		    		$(this).css('border', '2px dotted #0B85A1');
		    		ruta_actual = $(this).find("a").attr('title');
		    		var titulo = ui.draggable.find("a").attr('title');
		    		seleccionados_mover = new Array();
		    		seleccionados_mover.push(titulo);
		    		console.log('Ruta actual:'+ruta_actual);
		    		console.log('Seleccionados:'+seleccionados_mover);
		    		console.log('Titulo:'+titulo);
		    		ArchivosMoverConfirmar();
		      	},
		      	over: function(event, ui){
		      		$(this).css('background-color', '#00becd');
		      	},
		      	out: function(event, ui){
		      		$(this).css('background-color', '#043245');
		      	}
		    });
		});
		
		fileList2.on('click', 'div.folders', function(e){
			if(mover == 1){
				jQuery('#div_archivos_pegar').css('display','block');
				jQuery('#div_archivos_mover').css('display','none');
			}
			else{
				jQuery('#div_archivos_pegar').css('display','none');	
			}
			if(jQuery(this).hasClass('seleccionado')){
				jQuery(this).removeClass('seleccionado');
				seleccionados_cantidad--;
				if(seleccionados_cantidad <= 0){
					jQuery('#div_archivos_borrar').css('display', 'none');
					jQuery('#div_archivos_mover').css('display', 'none');
				}
				console.log('Carpeta desseleccionada');
			}
			else{
				seleccionados_cantidad++;
				jQuery('#div_archivos_borrar').css('display', 'block');
				jQuery('#div_archivos_mover').css('display', 'block');
				jQuery(this).addClass('seleccionado');
				var ruta = $(this).find('a.folders').attr('title');
				console.log('Carpeta seleccionada:');
				console.log(ruta);
			}
		});

		fileList2.on('click', 'div.files', function(e){
			if(jQuery(this).hasClass('seleccionado')){
				jQuery(this).removeClass('seleccionado');
				seleccionados_cantidad--;
				if(seleccionados_cantidad <= 0){
					jQuery('#div_archivos_borrar').css('display', 'none');
					jQuery('#div_archivos_mover').css('display', 'none');
				}
				console.log('Archivo desseleccionado');
			}
			else{
				seleccionados_cantidad++;
				jQuery('#div_archivos_borrar').css('display', 'block');
				jQuery('#div_archivos_mover').css('display', 'block');
				jQuery(this).addClass('seleccionado');
				var ruta = $(this).find('a.files').attr('title');
				console.log('Archivo seleccionado:');
				console.log(ruta);
			}
		});



		// Clicking on breadcrumbs

		breadcrumbs.on('click', 'a', function(e){
			e.preventDefault();

			var index = breadcrumbs.find('a').index($(this)),
				nextDir = breadcrumbsUrls[index];
			ruta_actual = nextDir;
			seleccionados_cantidad = 0;
			jQuery('#div_archivos_borrar').css('display', 'none');
			jQuery('#div_archivos_mover').css('display', 'none');
			if(index != 0){
				jQuery('#div_carpeta_borrar').css('display','block');
			}
			else{
				jQuery('#div_carpeta_borrar').css('display','none');
			}
			breadcrumbsUrls.length = Number(index);
			window.location.hash = encodeURIComponent(nextDir);
			$(".draggable").draggable();
		    $(".droppable").droppable({
		    	drop: function( event, ui ) {
		    		$(this).css('border', '2px dotted #0B85A1');
		    		ruta_actual = $(this).find("a").attr('title');
		    		var titulo = ui.draggable.find("a").attr('title');
		    		seleccionados_mover = new Array();
		    		seleccionados_mover.push(titulo);
		    		console.log('Ruta actual:'+ruta_actual);
		    		console.log('Seleccionados:'+seleccionados_mover);
		    		console.log('Titulo:'+titulo);
		    		ArchivosMoverConfirmar();
		      	},
		      	over: function(event, ui){
		      		$(this).css('background-color', '#00becd');
		      	},
		      	out: function(event, ui){
		      		$(this).css('background-color', '#043245');
		      	}
		    });
		});

		breadcrumbs2.on('click', 'a', function(e){
			e.preventDefault();

			var index = breadcrumbs2.find('a').index($(this)),
				nextDir = breadcrumbsUrls[index];
			ruta_actual = nextDir;
			seleccionados_cantidad = 0;
			jQuery('#div_archivos_borrar').css('display', 'none');
			jQuery('#div_archivos_mover').css('display', 'none');
			if(index != 0){
				jQuery('#div_carpeta_borrar').css('display','block');
			}
			else{
				jQuery('#div_carpeta_borrar').css('display','none');
			}
			breadcrumbsUrls.length = Number(index);
			window.location.hash = encodeURIComponent(nextDir);
		});


		// Navigates to the given hash (path)

		function goto(hash) {

			hash = decodeURIComponent(hash).slice(1).split('=');
			if (hash.length) {
				var rendered = '';

				// if hash has search in it

				if (hash[0] === 'search') {

					//filemanager.addClass('searching');
					filemanager2.addClass('searching');
					rendered = searchData(response, hash[1].toLowerCase());

					if (rendered.length) {
						currentPath = hash[0];
						render(rendered);
					}
					else {
						render(rendered);
					}

				}

				// if hash is some path

				else if (hash[0].trim().length) {

					rendered = searchByPath(hash[0]);
					if (rendered.length) {

						currentPath = hash[0];
						breadcrumbsUrls = generateBreadcrumbs(hash[0]);
						render(rendered);

					}
					else {
						currentPath = hash[0];
						breadcrumbsUrls = generateBreadcrumbs(hash[0]);
						render(rendered);
					}

				}

				// if there is no hash

				else {
					currentPath = data.path;
					breadcrumbsUrls.push(data.path);
					render(searchByPath(data.path));
				}
			}
			$(".draggable").draggable();
		    $(".droppable").droppable({
		    	drop: function( event, ui ) {
		    		$(this).css('border', '2px dotted #0B85A1');
		    		ruta_actual = $(this).find("a").attr('title');
		    		var titulo = ui.draggable.find("a").attr('title');
		    		seleccionados_mover = new Array();
		    		seleccionados_mover.push(titulo);
		    		console.log('Ruta actual:'+ruta_actual);
		    		console.log('Seleccionados:'+seleccionados_mover);
		    		console.log('Titulo:'+titulo);
		    		ArchivosMoverConfirmar();
		      	},
		      	over: function(event, ui){
		      		$(this).css('background-color', '#00becd');
		      	},
		      	out: function(event, ui){
		      		$(this).css('background-color', '#043245');
		      	}
		    });
		}

		// Splits a file path and turns it into clickable breadcrumbs

		function generateBreadcrumbs(nextDir){
			var path = nextDir.split('/').slice(0);
			for(var i=1;i<path.length;i++){
				path[i] = path[i-1]+ '/' +path[i];
			}
			return path;
		}


		// Locates a file by path

		function searchByPath(dir) {
			var path = dir.split('/'),
				demo = response,
				flag = 0;

			for(var i=0;i<path.length;i++){
				for(var j=0;j<demo.length;j++){
					if(demo[j].name === path[i]){
						flag = 1;
						demo = demo[j].items;
						break;
					}
				}
			}

			demo = flag ? demo : [];
			return demo;
		}


		// Recursively search through the file tree

		function searchData(data, searchTerms) {

			data.forEach(function(d){
				if(d.type === 'folder') {

					searchData(d.items,searchTerms);

					if(d.name.toLowerCase().match(searchTerms)) {
						folders.push(d);
					}
				}
				else if(d.type === 'file') {
					if(d.name.toLowerCase().match(searchTerms)) {
						files.push(d);
					}
				}
			});
			return {folders: folders, files: files};
		}


		// Render the HTML for the file manager

		function render(data) {

			var scannedFolders = [],
				scannedFiles = [];
			if(Array.isArray(data)) {

				data.forEach(function (d) {

					if (d.type === 'folder') {
						scannedFolders.push(d);
					}
					else if (d.type === 'file') {
						scannedFiles.push(d);
					}

				});

			}
			else if(typeof data === 'object') {

				scannedFolders = data.folders;
				scannedFiles = data.files;

			}


			// Empty the old result and make the new one

			fileList.empty().hide();
			fileList2.empty().hide();

			if(!scannedFolders.length && !scannedFiles.length) {
				//filemanager.find('.nothingfound').show();
				filemanager2.find('.nothingfound2').show();
			}
			else {
				//filemanager.find('.nothingfound').hide();
				filemanager2.find('.nothingfound2').hide();
			}

			if(scannedFolders.length) {

				scannedFolders.forEach(function(f) {

					var itemsLength = f.items.length,
						name = escapeHTML(f.name),
						icon = '<span class="icon folder"></span>';

					if(itemsLength) {
						icon = '<span class="icon folder full"></span>';
					}

					if(itemsLength == 1) {
						itemsLength += ' elemento';
					}
					else if(itemsLength > 1) {
						itemsLength += ' elementos';
					}
					else {
						itemsLength = 'Vacio';
					}

					var folder = $('<li class="folders draggable droppable"><a title="'+ f.path +'" class="folders">'+icon+'<span class="name">' + name + '</span> <span class="details">' + itemsLength + '</span></a></li>');
					folder.appendTo(fileList);

					var itemsLength = f.items.length,
						name = escapeHTML(f.name),
						icon = '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">'+
									'<input type="checkbox" class="check">'+
								'</div>'+
								'<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">'+
									'<img src="../../includes/diseno/images/file.png">'+
								'</div>';
					if(itemsLength == 1) {
						itemsLength += ' elemento';
					}
					else if(itemsLength > 1) {
						itemsLength += ' elementos';
					}
					else {
						itemsLength = 'Vacio';
					}
					var folder = $('<div class="folders col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile marginLarge">'+
										'<a title="'+ f.path +'" class="folders">'+
												icon+
											'<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile">'+
												name +
											'</div>'+
											'<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile">'+
												itemsLength+
											'</div>'+
										'</a>'+
									'</div>');
					folder.appendTo(fileList2);
				});

			}

			if(scannedFiles.length) {

				scannedFiles.forEach(function(f) {

					var fileSize = bytesToSize(f.size),
						name = escapeHTML(f.name),
						fileType = name.split('.'),
						icon = '<span class="icon file"></span>';

					fileType = fileType[fileType.length-1];

					icon = '<span class="icon file f-'+fileType+'">.'+fileType+'</span>';
					/*CARLOS LOARCA
						MODIFICACION 10-11-2015
						Se modifica la forma en que se muestran los archivos
					*/
					//var file = $('<li class="files"><a href="'+ f.path+'" title="'+ f.path +'" class="files">'+icon+'<span class="name">'+ name +'</span> <span class="details">'+fileSize+'</span></a></li>');
					var ruta = 'http://'+window.location.host+'/carlos/nulegi/includes/filesmanager/files/'+f.path;
					switch(fileType.toLowerCase()){
						case 'pdf':
							var file = $('<li class="files draggable" ondblclick="PDFAbrir(\''+ruta+'\');"><a title="'+ f.path +'" class="files pdf">'+icon+'<span class="name">'+ name +'</span> <span class="details">'+fileSize+'</span></a></li>');
							break;
						case 'jpg':
						case 'jpeg':
						case 'png':
						case 'gif':
							var file = $('<li class="files draggable" ondblclick="DocumentoVer(\''+ruta+'\');"><a title="'+ f.path +'" class="files">'+icon+'<span class="name">'+ name +'</span> <span class="details">'+fileSize+'</span></a></li>');
							break;
						default:
							var file = $('<li class="files draggable" ondblclick="DocumentoDescargar(\''+ruta+'\',\''+f.path+'\');"><a title="'+ f.path +'" class="files">'+icon+'<span class="name">'+ name +'</span> <span class="details">'+fileSize+'</span></a></li>');
							break;
					}
					file.appendTo(fileList);

					var fileSize = bytesToSize(f.size),
						name = escapeHTML(f.name),
						fileType = name.split('.'),
						icon = '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">'+
									'<input type="checkbox" class="check">'+
								'</div>'+
								'<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">'+
									'<img src="../../includes/diseno/images/file.png">'+
								'</div>';

					fileType = fileType[fileType.length-1];

					icon = '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">'+
								'<input type="checkbox" class="check">'+
							'</div>'+
							'<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 icon file f-'+fileType+'">'+
								'<span class="f-'+fileType+'" style="color:white;">.'+fileType+'</span>'+
								'<!--img src="../../includes/diseno/images/file.png"-->'+
							'</div>';
					/*CARLOS LOARCA
						MODIFICACION 10-11-2015
						Se modifica la forma en que se muestran los archivos
					*/
					//var file = $('<li class="files"><a href="'+ f.path+'" title="'+ f.path +'" class="files">'+icon+'<span class="name">'+ name +'</span> <span class="details">'+fileSize+'</span></a></li>');
					var ruta = 'http://'+window.location.host+'/carlos/nulegi/includes/filesmanager/files/'+f.path;
					switch(fileType.toLowerCase()){
						case 'pdf':
							var file = $('<div class="files" ondblclick="PDFAbrir(\''+ruta+'\');">'+
											'<a title="'+ f.path +'" class="files pdf" style="border-bottom: 1px solid black;padding: 10px 0;">'+icon+
												'<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile name">'+
													name +
												'</div>'+
												'<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile details">'+
													fileSize+
												'</div>'+
											'</a>'+
										'</div>');
							break;
						case 'jpg':
						case 'jpeg':
						case 'png':
						case 'gif':
							var file = $('<div class="files" ondblclick="DocumentoVer(\''+ruta+'\');">'+
											'<a title="'+ f.path +'" class="files" style="border-bottom: 1px solid black;padding: 10px 0;">'+icon+
												'<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile name">'+
													name +
												'</div>'+
												'<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile details">'+
													fileSize+
												'</div>'+
											'</a>'+
										'</div>');
							break;
						default:
							var file = $('<div class="files" ondblclick="DocumentoDescargar(\''+ruta+'\',\''+f.path+'\');">'+
											'<a title="'+ f.path +'" class="files" style="border-bottom: 1px solid black;padding: 10px 0;">'+icon+
												'<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile name">'+
													name +
												'</div>'+
												'<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile details">'+
													fileSize+
												'</div>'+
											'</a>'+
										'</div>');
							break;
					}
					file.appendTo(fileList2);
				});
			}


			// Generate the breadcrumbs

			var url = '';

			if(filemanager.hasClass('searching')){

				url = '<span>Resultados de la búsqueda: </span>';
				fileList.removeClass('animated');

			}
			else {

				fileList.addClass('animated');

				breadcrumbsUrls.forEach(function (u, i) {

					var name = u.split('/');

					if (i !== breadcrumbsUrls.length - 1) {
						url += '<a href="'+u+'"><span class="folderName">' + name[name.length-1] + '</span></a> <span class="arrow-breadcum">→</span> ';
					}
					else {
						url += '<span class="folderName">' + name[name.length-1] + '</span>';
					}

				});

			}

			breadcrumbs.text('').append(url);


			// Show the generated elements

			fileList.animate({'display':'inline-block'});

			// Generate the breadcrumbs

			var url = '';

			if(filemanager2.hasClass('searching')){

				url = '<span>Resultados de la búsqueda: </span>';
				fileList2.removeClass('animated');

			}
			else {

				fileList2.addClass('animated');

				breadcrumbsUrls.forEach(function (u, i) {

					var name = u.split('/');

					if (i !== breadcrumbsUrls.length - 1) {
						url += '<a href="'+u+'"><span class="folderName">' + name[name.length-1] + '</span></a> <span class="arrow-breadcum">→</span> ';
					}
					else {
						url += '<span class="folderName">' + name[name.length-1] + '</span>';
					}

				});

			}

			breadcrumbs2.text('').append(url);


			// Show the generated elements

			fileList2.animate({'display':'inline-block'});
		}


		// This function escapes special html characters in names

		function escapeHTML(text) {
			return text.replace(/\&/g,'&amp;').replace(/\</g,'&lt;').replace(/\>/g,'&gt;');
		}


		// Convert file sizes from bytes to human readable units

		function bytesToSize(bytes) {
			var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
			if (bytes == 0) return '0 Bytes';
			var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
			return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
		}

		/*
		CARLOS LOARCA - 04/12/2015
		DRAG AND DROP
		*/
		/*
		var obj = $(".filemanager");
		obj.on('dragenter', function (e) 
		{
		    e.stopPropagation();
		    e.preventDefault();
		    $(this).css('border', '2px solid #0B85A1');
		});
		obj.on('dragover', function (e) 
		{
		     e.stopPropagation();
		     e.preventDefault();
		});
		obj.on('drop', function (e) {
		 
		    $(this).css('border', '2px dotted #0B85A1');
		    e.preventDefault();
		    var files = e.originalEvent.dataTransfer.files;
		 
		    //We need to send dropped files to Server
		    handleFileUpload(files,obj);
		});

		$(document).on('dragenter', function (e) 
		{
		    e.stopPropagation();
		    e.preventDefault();
		});
		$(document).on('dragover', function (e) 
		{
		  e.stopPropagation();
		  e.preventDefault();
		  obj.css('border', '2px dotted #0B85A1');
		});
		$(document).on('drop', function (e) 
		{
		    e.stopPropagation();
		    e.preventDefault();
		});

		function handleFileUpload(files,obj)
		{
		   for (var i = 0; i < files.length; i++) 
		   {
		        var fd = new FormData();
		        fd.append('fil_archivo_1', files[i]);
		 
		        var status = new createStatusbar(obj); //Using this we can set progress.
		        status.setFileNameSize(files[i].name,files[i].size);
		        sendFileToServer(fd,status);
		 
		   }
		}

		function sendFileToServer(formData,status){
		    var uploadURL ="../../index.php/inicio/documento_dragdrop"; //Upload URL
		    //var extraData ={}; //Extra Data.
		    formData.append('hdd_carpeta',ruta_actual);
		    formData.append('hdd_usuario_id',usuario_id);
		    jQuery('.div_loader').show();
		    var jqXHR=$.ajax({
		            xhr: function() {
		            var xhrobj = $.ajaxSettings.xhr();
		            if (xhrobj.upload) {
		                    xhrobj.upload.addEventListener('progress', function(event) {
		                        var percent = 0;
		                        var position = event.loaded || event.position;
		                        var total = event.total;
		                        if (event.lengthComputable) {
		                            percent = Math.ceil(position / total * 100);
		                        }
		                        //Set progress
		                        status.setProgress(percent);
		                    }, false);
		                }
		            return xhrobj;
		        },
		        url: uploadURL,
		        type: "POST",
		        contentType:false,
		        processData: false,
		        cache: false,
		        data: formData,
		        success: function(data){
		        	jQuery('.div_loader').hide();
		            //status.setProgress(100);
		            switch(data){
		            	case '1':
		            		mensaje = 'Documento guardado exitosamente.';
							AbrirAlerta(mensaje,'auto','auto');
							setTimeout(function(){
		                        window.location.reload(true);
		                    }, 3000);
							//$("#status1").append("File upload Done<br>");
		            		break;
		            	case '2':
		            		mensaje = 'Ya existe un documento con ese nombre.';
							AbrirAlerta(mensaje,'auto','auto');
							break;
						default:
							mensaje = 'Error de conexi&oacute;n. Intente nuevamente.';
							AbrirAlerta(mensaje,'auto','auto');
							break;
		            }           
		        }
		    }); 
		 
		    status.setAbort(jqXHR);
		}

		var rowCount=0;
		function createStatusbar(obj)
		{
		     rowCount++;
		     var row="odd";
		     if(rowCount %2 ==0) row ="even";
		     this.statusbar = $("<div class='statusbar "+row+"'></div>");
		     this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
		     this.size = $("<div class='filesize'></div>").appendTo(this.statusbar);
		     this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
		     this.abort = $("<div class='abort'>Abort</div>").appendTo(this.statusbar);
		     //obj.after(this.statusbar);
		 	
		    this.setFileNameSize = function(name,size)
		    {
		        var sizeStr="";
		        var sizeKB = size/1024;
		        if(parseInt(sizeKB) > 1024)
		        {
		            var sizeMB = sizeKB/1024;
		            sizeStr = sizeMB.toFixed(2)+" MB";
		        }
		        else
		        {
		            sizeStr = sizeKB.toFixed(2)+" KB";
		        }
		 
		        this.filename.html(name);
		        this.size.html(sizeStr);
		    }
		    this.setProgress = function(progress)
		    {       
		        var progressBarWidth =progress*this.progressBar.width()/ 100;  
		        this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
		        if(parseInt(progress) >= 100)
		        {
		            this.abort.hide();
		        }
		    }
		    this.setAbort = function(jqxhr)
		    {
		        var sb = this.statusbar;
		        this.abort.click(function()
		        {
		            jqxhr.abort();
		            sb.hide();
		        });
		    }
		}
*/
		$(".draggable").draggable();
	    $(".droppable").droppable({
	    	drop: function( event, ui ) {
	    		$(this).css('border', '2px dotted #0B85A1');
	    		ruta_actual = $(this).find("a").attr('title');
	    		var titulo = ui.draggable.find("a").attr('title');
	    		seleccionados_mover = new Array();
	    		seleccionados_mover.push(titulo);
	    		console.log('Ruta actual:'+ruta_actual);
	    		console.log('Seleccionados:'+seleccionados_mover);
	    		console.log('Titulo:'+titulo);
	    		ArchivosMoverConfirmar();
	      	},
	      	over: function(event, ui){
	      		$(this).css('background-color', '#00becd');
	      	},
	      	out: function(event, ui){
	      		$(this).css('background-color', '#043245');
	      	}
	    });

	});
