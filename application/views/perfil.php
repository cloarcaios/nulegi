<?php 
	$data['pagina'] = 'pagina3';
	$data['id'] = $sesion['id'];
	$this->load->view('header', $data); 
?>			
			</div>
		</div>
		<meta http-equiv="Cache-control" content="no-cache">
		<meta http-equiv="Expires" content="-1">
		<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>includes/css/style_folding.css">
		<script src="<?php echo $this->config->base_url(); ?>includes/js/modernizr.js"></script>
		<script src="<?php echo $this->config->base_url(); ?>includes/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
		<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>includes/js/jquery-ui-1.11.4.custom/jquery-ui.css">
		<style type="text/css">
			#tbl_botones tr td{
				height: 27px; 
				padding: 2px;
				width: 250px;
			}

			.cd-fold-content h2{
				z-index: 20;
			}

			.cd-fold-content p{
				z-index: 20;
			}

			.progressBar {
			    width: 200px;
			    height: 22px;
			    border: 1px solid #ddd;
			    border-radius: 5px; 
			    overflow: hidden;
			    display:inline-block;
			    margin:0px 10px 5px 5px;
			    vertical-align:top;
			}
			 
			.progressBar div {
			    height: 100%;
			    color: #fff;
			    text-align: right;
			    line-height: 22px; /* same as #progressBar height if we want text middle aligned */
			    width: 0;
			    background-color: #0ba1b5; border-radius: 3px; 
			}
			.statusbar
			{
			    border-top:1px solid #A9CCD1;
			    min-height:25px;
			    width:700px;
			    padding:10px 10px 0px 10px;
			    vertical-align:top;
			}
			.statusbar:nth-child(odd){
			    background:#EBEFF0;
			}
			.filename
			{
			display:inline-block;
			vertical-align:top;
			width:250px;
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
			.abort{
			    background-color:#A8352F;
			    -moz-border-radius:4px;
			    -webkit-border-radius:4px;
			    border-radius:4px;display:inline-block;
			    color:#fff;
			    font-family:arial;font-size:13px;font-weight:normal;
			    padding:4px 15px;
			    cursor:pointer;
			    vertical-align:top
			    }
		</style>
		<script type="text/javascript">
			$(document).ready(function() {
				if(getURLParameter('e') == '0' || getURLParameter('e') == '1' || getURLParameter('e') == '2'){
					var mensaje;
					if(getURLParameter('e') == '0'){
						mensaje = 'Error de conexi&oacute;n. Intente nuevamente.';
						AbrirAlerta(mensaje,'auto','auto');
					}
					if(getURLParameter('e') == '1'){
						mensaje = 'Documento guardado exitosamente.';
						AbrirAlerta(mensaje,'auto','auto');
					}
					if(getURLParameter('e') == '2'){
						mensaje = 'Ya existe un documento con ese nombre, ingrese uno distinto.';
						AbrirAlerta(mensaje,'auto','auto');
					}
					setInterval(function(){
						window.location.href = 'perfil/#'+carpeta;	
					}, 3000);
				}
			});
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
			                                '<form id="frm_foto" name="frm_foto" action="../../inicio/documento_subir" method="post" enctype="multipart/form-data">'+
			                                    '<input type="file" id="fil_archivo_1" name="fil_archivo_1" onchange="validar_archivo();" style="color:white;"/>'+
			                                    '<br>'+
			                                    '<input type="submit" id="btn_documento" value="Subir Documento" disabled>'+
			                                    '<input type="hidden" id="hdd_carpeta" name="hdd_carpeta" value="">'+
			                                    '<input type="hidden" id="hdd_usuario_id" name="hdd_usuario_id" value="'+usuario_id+'">'+
			                                '</form>'+
			                            '</div>';
			    AbrirAlerta(formulario_subir,'auto','auto');
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
	    		        url: "../carpeta_crear",
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
	    		        			contenido = jQuery('#art_documentos').html();
	    		        			jQuery('.cd-fold-content').html(contenido);
	    							/*setTimeout(function(){
	    		                        window.location.reload(true);
	    		                    }, 5000);*/
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
    		        url: "../carpeta_borrar",
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
    		        			contenido = jQuery('#art_documentos').html();
    		        			jQuery('.cd-fold-content').html(contenido);
    							/*setTimeout(function(){
    		                        window.location.href = '../perfil/#'+usuario_id;
    		                    }, 5000);*/
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
    		        url: "../archivos_borrar",
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
    		        			contenido = jQuery('#art_documentos').html();
    		        			jQuery('.cd-fold-content').html(contenido);
    							/*setTimeout(function(){
    		                        window.location.href = '../perfil/#'+usuario_id;
    		                    }, 5000);*/
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
    		        url: "../archivos_mover",
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
    		        			contenido = jQuery('#art_documentos').html();
    		        			jQuery('.cd-fold-content').html(contenido);
    							/*setTimeout(function(){
    		                        window.location.href = '../perfil/#'+usuario_id;
    		                    }, 5000);*/
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

			function DocumentoDescargar(url, titulo) 
			{
			    /*var link = document.createElement("a");
			    link.href = url;
			    var nombre = titulo.split('/');
			    link.download = nombre.slice(-1)[0];
			    link.target = '_blank';
			    link.click();
			    console.log(link);*/
			    window.location.href=url;
			}
		</script>
		<!-- Main -->
		<div id="main-wrapper">
			<main class="cd-main">
				<header>
					<h1>Dashboard</h1>
				</header>

				<ul class="cd-gallery">
					<li class="cd-item">
						<a href="item-1.html">
							<div>
								<h2>Contratos</h2>
								<p>Generar y listar contratos.</p>
								<b>Ver</b>
							</div>
						</a>
					</li>

					<li class="cd-item">
						<a href="item-2.html">
							<div>
								<h2>Documentos</h2>
								<p>Lista de documentos.</p>
								<b>Ver</b>
							</div>
						</a>
					</li>

					<li class="cd-item">
						<a class="dark-text" href="item-3.html">
							<div>
								<h2>Perfil</h2>
								<p>Modifique o actualice su perfil.</p>
								<b>Ver</b>
							</div>
						</a>
					</li>

					<li class="cd-item">
						<a href="item-4.html">
							<div>
								<h2>Pregunta</h2>
								<p>Realice una pregunta a un abogado.</p>
								<b>Ver</b>
							</div>
						</a>
					</li>
				</ul> <!-- .cd-gallery -->
			</main> <!-- .cd-main -->

			<div class="cd-folding-panel">
				
				<div class="fold-left"></div> <!-- this is the left fold -->
				
				<div class="fold-right"></div> <!-- this is the right fold -->
				
				<div class="cd-fold-content">
					<!-- content will be loaded using javascript -->
				</div>

				<a class="cd-close" href="#"></a>
			</div>
			<div class="container">
				<div class="row">
					<div class="8u">
					<!-- Content -->
						<article id="art_contratos" class="box post" style="display:none;">
							<h2>Contratos</h2>
							<p>Generar y listar contratos</p>
							<input type="button" Value="Generar Contrato" onclick="Redir('../contratos');">
							</br>
							</br>
							<input type="button" Value="Contratos Generados" onclick="Redir('../contratos_lista');">							
						</article>
						<article id="art_documentos" class="box post" style="display:none;">
							<div id="div_documentos">
								<h2>Documentos</h2>
								<p>Administrador de documentos</p>
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
									<div class="breadcrumbs"></div>
									<ul class="data"></ul>
									<div class="nothingfound">
										<div class="nofiles"></div>
										<span>Carpeta vac&iacute;a.</span>
									</div>
								</div>
								<!-- Include our script files -->
								<script type="text/javascript">
									var carpeta = '<?php echo $sesion['id'];?>';
								</script>
								<!--script src="<?php //echo $this->config->base_url(); ?>includes/filesmanager/assets/js/jquery-1.11.3.min.js"></script-->
								<script src="<?php echo $this->config->base_url(); ?>includes/filesmanager/assets/js/script.js"></script>
								<!--h2>Documentos</h2>
								<p>Listado general de documentos</p>
								<p>
									<?php
									/*
										if($documentos['res'] == 1){
								        	$html_documentos = '<table>
								        						<tr>
									        						<th>No.</th>
									        						<th>Nombre</th>
									        						<th>Fecha Hora de creacion</th>
									        						<th>Operaciones</th>
									        					</tr>';
									        $i = 1;
								        	foreach ($documentos['documentos'] as $key => $value) {
								        		$ruta = $this->config->base_url().$value['ruta'].'/'.$value['nombre'];
								        		$ver = (strpos($value['nombre'],'.pdf')>0)?'<a class="pdf" href="'.$ruta.'"><input type="button" value="Ver"></a>':'<input type="button" value="Ver" onclick="VerDocumento(\''.$ruta.'\');">';
								        		$html_documentos .= '<tr>
								        								<td>'.$i.'</td>
								        								<td>'.$value['nombre'].'</td>
								        								<td>'.$value['fecha_hora'].'</td>
								        								<td><a href="'.$ruta.'" download><input type="button" value="Descargar"/></a>'.$ver.'</td>
								        							</tr>'; 
								        		$i++;
								        	}
								        	$html_documentos .= '</table>';
								        	echo $html_documentos; 
								        }
								        else{
								        	echo 'No ha guardado ningun documento.';
								        }
								        */
									?>
									<div id="contentupload-photo">
		                                <form id="frm_foto" name="frm_foto" action="../inicio/subir_documento" method="post" enctype="multipart/form-data">
		                                    <label class="fileinput-new" for="fil_archivo_1">Seleccione un documento</label>
		                                    <input type="file" id="fil_archivo_1" name="fil_archivo_1" onchange="validar_archivo();" />
		                                    <input type="submit" id="btn_documento" value="Subir Documento" disabled>
		                                    <input type="hidden" id="hdd_usuario_id" name="hdd_usuario_id" value="<?php //echo $sesion['id'];?>">
		                                </form>
		                            </div>	
								</p-->
							</div>
						</article>
					</div>
					<div class="4u">
						<!-- Sidebar -->
						<article id="art_perfil" class="box post" style="display:none;">
							<h2>Perfil</h2>
							<p>Informacion personal</p>
								<div id="tabs">
									<ul>
								    	<li><a href="#tabs-1">Datos Personales</a></li>
								    	<li id="tab2"><a href="#tabs-2">Datos Generales</a></li>
								  	</ul>
								  	<div id="tabs-1">
								  		<form style="width:auto;">
									    	<label>Nombres</label>
											<input type="text" id="txt_nombres" onkeypress="return validar_caracter(event, 0);" value="<?php echo $perfil[0]['nombres']?>"/>
											<label>Apellidos</label>
											<input type="text" id="txt_apellidos" onkeypress="return validar_caracter(event, 0);" value="<?php echo $perfil[0]['apellidos']?>"/>
											<label>Direccion</label>
											<input type="text" id="txt_direccion" value="<?php echo $perfil[0]['direccion']?>"/>
											<label>Telefono</label>
											<input type="text" id="txt_telefono" onkeypress="return validar_caracter(event, 1);" maxlength="12" value="<?php echo $perfil[0]['telefono']?>"/> 
											<label>Genero</label>
											<?php
												$seleccionado1 = ($perfil[0]['genero'] == '1')?'selected="selected"':'';
												$seleccionado2 = ($perfil[0]['genero'] == '0')?'selected="selected"':'';
												$html_genero = '<select id="slc_genero">
																	<option value="1" '.$seleccionado1.'>Masculino</option>
																	<option value="0" '.$seleccionado2.'>Femenino</option>
																</select>';
												echo $html_genero;
											?>
											<label>Fecha de nacimiento</label>
											<?php
												$html_dia = '<select id="slc_dia">';
												for ($i = 1; $i <= 31; $i++) { 
													$seleccionado = (substr($perfil[0]['nacimiento'],8,2) == $i)?'selected="selected"':'';
													$html_dia .= '<option value="'.$i.'" '.$seleccionado.'>'.$i.'</option>';
												}
												$html_dia .= '</select>';
												echo $html_dia;
												$html_mes = '<select id="slc_mes">';
												$meses = array('01' =>'Enero',
															   '02' =>'Febrero',
															   '03' =>'Marzo',
															   '04' =>'Abril',
															   '05' =>'Mayo',
															   '06' =>'Junio',
															   '07' =>'Julio',
															   '08' =>'Agosto',
															   '09' =>'Septiembre',
															   '10' =>'Octubre',
															   '11' =>'Noviembre',
															   '12' =>'Diciembre',
															    );
												foreach($meses as $key => $value) { 
													$seleccionado = (substr($perfil[0]['nacimiento'],5,2) == $key)?'selected="selected"':'';
													$html_mes .= '<option value="'.$key.'" '.$seleccionado.'>'.$value.'</option>';
												}
												$html_mes .= '</select>';
												echo $html_mes;
												$html_anio = '<select id="slc_anio">';
												for ($i = 1940; $i <= 2015; $i++) { 
													$seleccionado = (substr($perfil[0]['nacimiento'],0,4) == $i)?'selected="selected"':'';
													$html_anio .= '<option value="'.$i.'" '.$seleccionado.'>'.$i.'</option>';
												}
												$html_anio .= '</select>';
												echo $html_anio;
											?>
										</form>	
								  	</div>
								  	<div id="tabs-2">
								  		<form style="width:auto;">
									    	<label>Pais</label>
											<?php
												$select_paises = '<select id="slc_pais">';
												foreach ($paises as $key => $value) {
													$seleccionado = ($perfil[0]['pais_pais_id'] == $value['pais_id'])?'selected="selected"':'';
													$select_paises .= '<option value="'.$value['pais_id'].'" '.$seleccionado.'>'.$value['nombre'].'</option>';
												}
												echo $select_paises.'</select>';
											?>
											<label>DPI</label>
											<input type="text" id="txt_dpi" onkeypress="return validar_caracter(event, 1);" value="<?php echo $perfil[0]['dpi']?>"/>
											<label>Licencia</label>
											<input type="text" id="txt_licencia" value="<?php echo $perfil[0]['licencia']?>"/>
											<label>Oficio/Profesion</label>
											<input type="text" id="txt_oficio" value="<?php echo $perfil[0]['oficio']?>"/>
											<label>Correo</label>
											<input type="email" id="txt_correo" value="<?php echo $perfil[0]['correo']?>"/>
											<label>Contraseña</label>
											<input type="password" id="txt_clave1"/>
											<label>Confirme su contraseña</label>
											<input type="password" id="txt_clave2"/>
										</form>
								  	</div>
								</div>
								<input type="hidden" id="hdd_id" value="<?php echo $perfil[0]['usuario_id']?>"/>
								<input type="button" id="btn_registro" value="Modificar Datos" onclick="ModificarUsuario();">
							</form>
						</article>
					</div>
				</div>
			</div>
		</div>
		<div class="div_loader" style="display: none;">
			<img class="load-image" alt="" src="<?php echo $this->config->base_url(); ?>includes/images/loader.gif">
			<h5>Espere...</h5>
		</div>
		<script src="<?php echo $this->config->base_url(); ?>includes/js/main.js"></script>
<?php $this->load->view('footer'); ?>