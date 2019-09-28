<?php $this->layout->block('headhtml'); ?>
	<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>includes/css/style_folding.css">
	<script src="<?php echo $this->config->base_url(); ?>includes/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
	<script type="text/javascript">
		var archivos_ver = 0;
		var mover = 0;
		var seleccionados_mover = new Array();
		var usuario_id = "<?php echo $sesion['id'];?>";

		function ModificarUsuario(){
			var error = false;
			var mensaje = '';
			var nombres = jQuery('#txt_nombres').val();
			var apellidos = jQuery('#txt_apellidos').val();
			var direccion = jQuery('#txt_direccion').val();
			var telefono = jQuery('#txt_telefono').val();
			var dpi = jQuery('#txt_dpi').val();
			var licencia = jQuery('#txt_licencia').val();
			var oficio = jQuery('#txt_oficio').val();
			var correo = jQuery('#txt_correo').val();
			var clave1 = jQuery('#txt_clave1').val();
			var clave2 = jQuery('#txt_clave2').val();
			var id = jQuery('#hdd_id').val();
			if(nombres == ''){
				mensaje += '<div>Ingrese su nombre.</div>';
				error = true;
			}
			if(apellidos == ''){
				mensaje += '<div>Ingrese sus apellidos.</div>';
				error = true;
			}
			if(direccion == ''){
				mensaje += '<div>Ingrese su direccion.</div>';
				error = true;
			}
			if(telefono == ''){
				mensaje += '<div>Ingrese su telefono.</div>';
				error = true;
			}
			if(dpi == ''){
				mensaje += '<div>Ingrese su DPI.</div>';
				error = true;
			}
			if(oficio == ''){
				mensaje += '<div>Ingrese su Profesion/Oficio.</div>';
				error = true;
			}
			if(correo == '' || validateEmail(correo) == false){
				mensaje += '<div>Ingrese un correo valido.</div>';
				error = true;
			}
			if(clave1 == '' && clave2 != ''){
				mensaje += '<div>Ingrese su contraseña.</div>';
				error = true;
			}
			if(clave1.length < 6 && clave1 != ''){
				mensaje += '<div>La contraseña debe tener al menos 6 caracteres.</div>';
				error = true;
			}
			if(clave2 == '' && clave1 != ''){
				mensaje += '<div>Confirme su contraseña.</div>';
				error = true;
			}
			if(clave1 != '' && clave2 != '' && clave1 != clave2){
				mensaje += '<div>Las contraseñas no coinciden.</div>';
				error = true;
			}
			if(id == ''){
				mensaje += '<div>El usuario ingresado no existe en el sistema actualmente.</div>';
				error = true;
			}
			if(error == true){
				AbrirAlerta(mensaje, 'auto', 'auto');
			}
			else{
				var genero = jQuery('#slc_genero').val();
				var pais = jQuery('#slc_pais').val();
				var licencia = jQuery('#txt_licencia').val();
				var dia = jQuery('#slc_dia').val();
				var mes = jQuery('#slc_mes').val();
				var anio = jQuery('#slc_anio').val();
				var nacimiento = anio+'-'+mes+'-'+dia;
				if(licencia == ''){
					licencia = '0';
				}
				if(clave1 == ''){
					clave1 = '0';
				}
				jQuery.ajax({
			        url: "../inicio/usuario_modificar",
			        type: 'post',
			        data: {
			            nombres:encode(nombres),
			            apellidos:encode(apellidos),
			            direccion:encode(direccion),
			            telefono:encode(telefono),
			            nacimiento:encode(nacimiento),
			            dpi:encode(dpi),
			            licencia:encode(licencia),
			            oficio:encode(oficio),
			            genero:encode(genero),
			            pais:encode(pais),
			            correo:encode(correo),
			            clave:encode(clave1),
			            id:encode(id),
			        },
			        dataType: 'json',
			        success: function(respuesta) {
			        	jQuery('.div_loader').hide();
			        	switch(parseInt(respuesta.res)){
			        		case 1:
			        			var mensaje = 'Informaci&oacute;n Modificada Exitosamente.';
								setTimeout(function(){
			                        window.location.reload(true);
			                    }, 8000);
			        			break;
			        		case 2:
			        			var mensaje = 'El correo ingresado ya existe. Ingrese uno distinto.';
			        			break;
			        		case 3:
			        			var mensaje = 'El usuario ingresado no existe. Debe iniciar el registro.';
			        			break;
			        		default:
			        			var mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
			        			break;
			        	}
			        	AbrirAlerta(mensaje, 'auto', 'auto');
			        },
			        error: function (error){
			            //alert(error);
			        }
			    }); 
			}
		}

		function validar_archivo(){
			var file = document.getElementById('fil_archivo_1');
			if(file.value.indexOf('.') < 0 || !file){
	            file.value='';
	            mensaje = '<div>Archivo no soportado. Los archivos admitidos son "jpg", "png", "gif" o "pdf".</div>';
	            AbrirAlerta(mensaje,'auto','auto');
	            return false;
	        }
		    var ext = file.value.match(/\.([^\.]+)$/)[1];
		    ext = ext.toLowerCase();
		    var mensaje = '';
		    switch(ext)
		    {
		        case 'jpg':
		        case 'jpeg':
		        case 'png':
		        case 'gif':
		        case 'pdf':
		        	jQuery('#btn_documento').prop('disabled', false);
		        	jQuery('#hdd_carpeta').val(ruta_actual);
		            break;
		        default:
		            file.value='';
		            mensaje = '<div>Archivo no soportado. Los archivos admitidos son "jpg", "png", "gif" o "pdf".</div>';
        			AbrirAlerta(mensaje,'auto','auto');
		            break;
		    }
		}

		function PDFAbrir(ruta){
		    window.open(ruta,"_blank");
		}

		function DocumentoVer(url){
			var imagen = '<img src="'+url+'">';
			AbrirAlerta(imagen,'auto','auto');
		}

		function Redir(ruta){
	        window.location.href = ruta;
	    }

	    function DocumentoSubirVer(){
	    	var formulario_subir = '<label>Subir un Documento</label>'+
	    							'</br>'+
	    							'<div id="contentupload-photo">'+
	                                    '<input type="file" id="fil_archivo_1" name="fil_archivo_1" onchange="validar_archivo();"/>'+
	                                    '<br>'+
	                                    '<input type="button" id="btn_documento" value="Subir Documento" onclick="DocumentoSubirConfirmar();">'+
	                                    '<input type="hidden" id="hdd_carpeta" name="hdd_carpeta" value="">'+
	                                    '<input type="hidden" id="hdd_usuario_id" name="hdd_usuario_id" value="'+usuario_id+'">'+
		                            '</div>';
		    AbrirAlerta(formulario_subir,'auto','auto');
			/*
	    	var formulario_subir = '<label>Subir un Documento</label>'+
	    							'</br>'+
	    							'<div id="contentupload-photo">'+
		                                '<form id="frm_foto" name="frm_foto" action="../inicio/documento_subir" method="post" enctype="multipart/form-data">'+
		                                    '<input type="file" id="fil_archivo_1" name="fil_archivo_1" onchange="validar_archivo();" style="color:white;"/>'+
		                                    '<br>'+
		                                    '<input type="submit" id="btn_documento" value="Subir Documento" disabled>'+
		                                    '<input type="hidden" id="hdd_carpeta" name="hdd_carpeta" value="">'+
		                                    '<input type="hidden" id="hdd_usuario_id" name="hdd_usuario_id" value="'+usuario_id+'">'+
		                                '</form>'+
		                            '</div>';
		    AbrirAlerta(formulario_subir,'auto','auto');*/
	    }

	    function DocumentoSubirConfirmar(){
	    	var archivo = jQuery('#fil_archivo_1').val();
	    	if(archivo != ''){
	    		var usuario_id = jQuery('#hdd_usuario_id').val();
	    		var carpeta = jQuery('#hdd_carpeta').val();
	    		var formData = new FormData();
		    	formData.append('fil_archivo_1',jQuery('#fil_archivo_1')[0].files[0]);
		    	formData.append('usuario_id',usuario_id);
				formData.append('carpeta',encode(carpeta));
		    	$.ajax({
		            url: 'documento_subir',
		            type: 'POST',
		            data: formData,
		            contentType: false,
		            processData: false,
		            dataType : 'json',
		            success: function(respuesta){
		            	var mensaje;
						switch (parseInt(respuesta.res)){
							case 1:
								mensaje = 'Documento guardado exitosamente.';
								PreviosVer();
								break;
							case 2:
								mensaje = 'Ya existe un documento con ese nombre, ingrese uno distinto.';
								break;
							default:
								mensaje = 'Error de conexi&oacute;n. Intente nuevamente.';
								break;
						}
						AbrirAlerta(mensaje,'auto','auto');
					}
				});
	    	}
	    }

	    function CarpetaCrearVer(){
	    	var carpeta_nueva = '<div>'+
	    							'<label>Crear Carpeta</label>'+
	    							'</br>'+
	    							'</br>'+
	    							'<div id="div_mensaje" style="color:red;"></div>'+
	    							'<label>Nombre:</label>'+
	    							'<input type="text" id="txt_carpeta_nombre"/>'+
	    							'</br>'+
	    							'<input type="button" value="Crear" onclick="CarpetaCrear();">'+
	    						'</div>';
	    	AbrirAlerta(carpeta_nueva,'auto','auto');
	    	jQuery('#txt_carpeta_nombre').focus();
	    }

	    function CarpetaCrear(){
	    	var carpeta_nombre = jQuery('#txt_carpeta_nombre').val();
	    	if(carpeta_nombre == ''){
	    		jQuery('#div_mensaje').html('Ingrese el nombre de la carpeta.');
	    	}
	    	else{
	    		jQuery('.div_loader').show();
    			jQuery.ajax({
    		        url: "carpeta_crear",
    		        type: 'post',
    		        data: {
    		            carpeta_nombre:carpeta_nombre,
    		            usuario_id:usuario_id,
    		            ruta_actual:ruta_actual
    		        },
    		        dataType: 'json',
    		        success: function(respuesta) {
    		        	jQuery('.div_loader').hide();
    		        	switch(parseInt(respuesta.res)){
    		        		case 1:
    		        			var mensaje = 'Carpeta creada exitosamente.';
    							PreviosVer();
    		        			break;
    		        		default:
    		        			var mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
    		        			break;
    		        	}
    		        	AbrirAlerta(mensaje, 'auto', 'auto');
    		        },
    		        error: function (error){
    		            //alert(error);
    		        }
    		    }); 
	    	}
	    }

	    function CarpetaBorrarVer(){
	    	var carpeta_nueva = '<div>'+
	    							'<label>Eliminar Carpeta</label>'+
	    							'</br>'+
	    							'</br>'+
	    							'<div id="div_mensaje" style="color:red;"></div>'+
	    							'<label>Esta seguro de eliminar la carpeta actual?</label>'+
	    							'</br>'+
	    							'<input type="button" value="Eliminar" onclick="CarpetaBorrar();">'+
	    						'</div>';
	    	AbrirAlerta(carpeta_nueva,'auto','auto');
	    	jQuery('#txt_carpeta_nombre').focus();
	    }

	    function CarpetaBorrar(){
	    	jQuery('.div_loader').show();
	    	jQuery.ajax({
		        url: "carpeta_borrar",
		        type: 'post',
		        data: {
		            usuario_id:usuario_id,
		            ruta_actual:ruta_actual
		        },
		        dataType: 'json',
		        success: function(respuesta) {
		        	jQuery('.div_loader').hide();
		        	switch(parseInt(respuesta.res)){
		        		case 1:
		        			var mensaje = 'Carpeta borrada exitosamente.';
							setTimeout(function(){
		                        window.location.href = 'archivos';
		                    }, 3000);
		        			break;
		        		default:
		        			var mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
		        			break;
		        	}
		        	AbrirAlerta(mensaje, 'auto', 'auto');
		        },
		        error: function (error){
		            //alert(error);
		        }
		    }); 
	    }

	    function PDFVer(ruta){
	    	jQuery('.pdf').prop('href', ruta);
			$(".pdf").fancybox({
			    width  : '100%',
			    height : '100%',
			    type   :'iframe'
			});
		}

		function ArchivosBorrarVer(){
			var seleccionados_todos = new Array();
			$('.seleccionado').each(function() {
				seleccionados_todos.push($(this).find('a').attr('title'));
				console.log(seleccionados_todos);
			});
			if(seleccionados_todos != null){
				var formulario_borrar = '<div>'+
			    							'<label>Eliminar Archivos</label>'+
			    							'</br>'+
			    							'</br>'+
			    							'<div id="div_mensaje" style="color:red;"></div>'+
			    							'<label>Esta seguro de eliminar los elementos seleccionados?</label>'+
			    							'</br>'+
			    							'<input type="button" value="Eliminar" onclick="ArchivosBorrarConfirmar();">'+
			    						'</div>';
				AbrirAlerta(formulario_borrar, 'auto', 'auto');
			}
		}

		function ArchivosBorrarConfirmar(){
			var seleccionados_todos = new Array();
			$('.seleccionado').each(function() {
				seleccionados_todos.push($(this).find('a').attr('title'));
				console.log(seleccionados_todos);
			});
			jQuery('.div_loader').show();
			jQuery.ajax({
		        url: "archivos_borrar",
		        type: 'post',
		        data: {
		            usuario_id:usuario_id,
		            seleccionados_todos:seleccionados_todos,
		            carpeta:carpeta
		        },
		        dataType: 'json',
		        success: function(respuesta) {
		        	jQuery('.div_loader').hide();
		        	switch(parseInt(respuesta.res)){
		        		case 1:
		        			var mensaje = 'Archivos borrados exitosamente.';
		        			PreviosVer();
		        			break;
		        		case 2:
		        			var mensaje = '<div>Error al borrar. Intente nuevamente.</div>';
		        			break;
		        		default:
		        			var mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
		        			break;
		        	}
		        	AbrirAlerta(mensaje, 'auto', 'auto');
		        },
		        error: function (error){
		            //alert(error);
		        }
		    });
		}

		function ArchivosMoverVer(){
			seleccionados_mover = new Array();
			$('.seleccionado').each(function() {
				seleccionados_mover.push($(this).find('a').attr('title'));
				console.log($(this).find('a').attr('title'));
				console.log(seleccionados_mover);
			});
			if(seleccionados_mover != null){
				var formulario_mover = '<div>'+
			    							'<label>Mover Archivos</label>'+
			    							'<div id="div_mensaje" style="color:red;"></div>'+
			    							'<br>'+
			    							'<label>Debe desplazarse hasta la carpeta donde los desea pegar.</label>'+
			    							'<br>'+
			    							'<label>Si en la nueva carpeta existen archivos o carpetas iguales seran reemplazados.</label>'+
			    							'</br>'+
			    						'</div>';
				AbrirAlerta(formulario_mover, 'auto', 'auto');
				mover = 1;
			}
		}

		function ArchivosMoverConfirmar(){
			jQuery('.div_loader').show();
			jQuery.ajax({
		        url: "archivos_mover",
		        type: 'post',
		        data: {
		            usuario_id:usuario_id,
		            seleccionados_mover:seleccionados_mover,
		            carpeta_nueva:ruta_actual
		        },
		        dataType: 'json',
		        success: function(respuesta) {
		        	jQuery('.div_loader').hide();
		        	jQuery('#btn_pegar').prop('disabled', true);
		        	switch(parseInt(respuesta.res)){
		        		case 1:
		        			var mensaje = 'Archivos movidos exitosamente.';
		        			mover = 0;
							PreviosVer();
		        			break;
		        		default:
		        			var mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
		        			break;
		        	}
		        	AbrirAlerta(mensaje, 'auto', 'auto');
		        },
		        error: function (error){
		            //alert(error);
		        }
		    });
		}

		function DocumentoDescargar(url, titulo){
		    /*var link = document.createElement("a");
		    link.href = url;
		    var nombre = titulo.split('/');
		    link.download = nombre.slice(-1)[0];
		    link.target = '_blank';
		    link.click();
		    console.log(link);*/
		    window.location.href=url;
		}

		function ListaVer(){
			$.getScript("../../includes/filesmanager/assets/js/script.js", function( data, textStatus, jqxhr ) {
			  console.log( textStatus ); // Success
			  console.log( jqxhr.status ); // 200
			  console.log( "Load was performed." );
			});
		}
		function PreviosVer(){
			$.getScript("../../includes/filesmanager/assets/js/script.js", function( data, textStatus, jqxhr ) {
			  console.log( textStatus ); // Success
			  console.log( jqxhr.status ); // 200
			  console.log( "Load was performed." );
			});
		}
	</script>
	<style type="text/css">
		#tbl_botones tr td{
			height: 27px; 
			padding: 2px;
			width: 250px;
		}

		.filesize
			{
			display:inline-block;
			vertical-align:top;
			color:#30693D;
			width:100px;
			margin-left:10px;
			margin-right:5px;
		}
	</style>
<?php $this->layout->block(); ?>

<?php $this->layout->block('section-page'); ?>
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap ">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 iconOrder">
		<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/list.png" class="listOrder">
		<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/preview.png" class="previewOrder">
	</div>
	<div class="contentScroll2 marginLarge">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="titleGeneral">Mis archivos y mis contratos</h2>
			<div>Utiliza nuestra app para manejar tus archivos, mantener un record, editar en linea tus contratos y organizar tu carpeta legal. </div>
			<!--div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
				<div class="col-lg-6 col-md-8 col-sm-6 col-xs-12 nonePadding marginLarge">
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 nonePadding">
						<input type="text" placeholder="Buscar entre mis archivos">
					</div>
				</div>
			</div-->
		</div>
		<hr class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		<link href="<?php echo $this->config->base_url();?>includes/filesmanager/assets/css/styles.css" rel="stylesheet"/>
		<div class="filemanager">
			<table id="tbl_botones">
				<tr>
					<td>
						<div id="div_documento_subir">
							<input type="button" onclick="DocumentoSubirVer();" value="Subir Documento">
						</div>
					</td>
					<td>
						<div id="div_carpeta_crear">
							<input type="button" onclick="CarpetaCrearVer();" value="Crear carpeta"/>
						</div>
					</td>
					<td>
						<div id="div_carpeta_borrar" style="display:none;">
							<input type="button" onclick="CarpetaBorrarVer();" value="Eliminar carpeta"/>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div id="div_archivos_borrar" style="display:none;">
							<input type="button" onclick="ArchivosBorrarVer();" value="Eliminar seleccionados"/>
						</div>
					</td>
					<td>
						<div id="div_archivos_mover" style="display:none;">
							<input type="button" onclick="ArchivosMoverVer();" value="Cortar"/>
						</div>
					</td>
					<td>
						<div id="div_archivos_pegar" style="display:none;">
							<input id="btn_pegar" type="button" value="Pegar" onclick="ArchivosMoverConfirmar();">
						</div>
					</td>
				</tr>
			</table>
			<div class="search">
				<input type="search" placeholder="Buscar archivo" />
			</div>
			<div class="breadcrumbs"></div>
			<ul class="data"></ul>
			<div class="nothingfound">
				<div class="nofiles"></div>
				<span>Carpeta vac&iacute;a.</span>
			</div>
		</div>
		<script type="text/javascript">
			var carpeta = '<?php echo $sesion['id'];?>';
		</script>
		<script src="<?php echo $this->config->base_url(); ?>includes/filesmanager/assets/js/script.js"></script>
		<!--div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowIcon">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/file.png">
				</div>
				<div class="legendIcon">Los más usados</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/file.png">
				</div>
				<div class="legendIcon">Contratos casa</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/file.png">
				</div>
				<div class="legendIcon">
					Empleados
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/docWord.png">
				</div>
				<div class="legendIcon">
					Los más usados
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<a href="previewPdf.html">
					<div>
						<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/docPdf.png">
					</div>
					<div class="legendIcon">
						Los más usados
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowIcon">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/pluma.png">
				</div>
				<div class="legendIcon">
					Los más usados
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/pluma2.png">
				</div>
				<div class="legendIcon">Los más usados</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/docImage.png">
				</div>
				<div class="legendIcon">Los más usados</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/docWord.png">
				</div>
				<div class="legendIcon">
					Los más usados
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<a href="previewPdf.html">
					<div>
						<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/docPdf.png">
					</div>
					<div class="legendIcon">Los más usados</div>
				</a>
			</div>
		</div-->
	</div>
	<div class="contentScroll marginLarge">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="titleGeneral">Mis archivos y mis contratos</h2>
			<div>Utiliza nuestra app para manejar tus archivos, mantener un record, editar en linea tus contratos y organizar tu carpeta legal. </div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
				<div class="col-lg-6 col-md-8 col-sm-6 col-xs-12 nonePadding marginLarge">
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 nonePadding">
						<input type="text" placeholder="Buscar entre mis archivos">
					</div>
				</div>
			</div>
		</div>
		<div class="filemanager2">
			<table id="tbl_botones2">
				<tr>
					<td>
						<div id="div_documento_subir2">
							<input type="button" onclick="DocumentoSubirVer();" value="Subir Documento">
						</div>
					</td>
					<td>
						<div id="div_carpeta_crear">
							<input type="button" onclick="CarpetaCrearVer();" value="Crear carpeta"/>
						</div>
					</td>
					<td>
						<div id="div_carpeta_borrar" style="display:none;">
							<input type="button" onclick="CarpetaBorrarVer();" value="Eliminar carpeta"/>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div id="div_archivos_borrar" style="display:none;">
							<input type="button" onclick="ArchivosBorrarVer();" value="Eliminar seleccionados"/>
						</div>
					</td>
					<td>
						<div id="div_archivos_mover" style="display:none;">
							<input type="button" onclick="ArchivosMoverVer();" value="Cortar"/>
						</div>
					</td>
					<td>
						<div id="div_archivos_pegar" style="display:none;">
							<input id="btn_pegar" type="button" value="Pegar" onclick="ArchivosMoverConfirmar();">
						</div>
					</td>
				</tr>
			</table>
			<div class="search2">
				<input type="search" placeholder="Buscar archivo" />
			</div>
			<div class="breadcrumbs2"></div>
			<div class="data2"></div>
			<div class="nothingfound2">
				<div class="nofiles2"></div>
				<span>Carpeta vac&iacute;a.</span>
			</div>
		</div>
		<!--script src="<?php //echo $this->config->base_url(); ?>includes/filesmanager/assets/js/jquery-1.11.3.min.js"></script-->
		<!--div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile marginLarge">
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">
				<input type="checkbox" class="check">
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/file.png">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile">
				Los más usados
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile">
				10/05/2016 9:30 PM
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile">
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">
				<input type="checkbox" class="check">
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/pluma.png">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile">
				Archivo contrato no editable
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile">
				10/05/2016 9:30 PM
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile">
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">
				<input type="checkbox" class="check">
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/docImage.png">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile">
				Archivo jpg
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile">
				10/05/2016 9:30 PM
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile">
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">
				<input type="checkbox" class="check">
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/docWord.png">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile">
				Archivo word
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile">
				10/05/2016 9:30 PM
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile">
			<a href="previewPdf.html">
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">
					<input type="checkbox" class="check">
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/docPdf.png">
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile">
					Archivo PDF
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile">
					10/05/2016 9:30 PM
				</div>
			</a>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile">
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">
				<input type="checkbox" class="check">
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/pluma2.png">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile">
				Archivo contrato editable
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile">
				10/05/2016 9:30 PM
			</div>
		</div-->
		<script type="text/javascript">
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
		</script>
	</div>
</div>
<?php $this->layout->block(); ?>