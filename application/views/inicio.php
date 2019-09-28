<!DOCTYPE html>
<html>
	<head>
	  	<!-- title and meta -->
	  	<meta charset="utf-8">
	  	<meta content="width=device-width,initial-scale=1.0" name="viewport">
	  	<title>Nulegi</title>
  		<!-- css -->
  		<link rel="stylesheet" href="includes/diseno/css/bootstrap.css">
  		<link rel="stylesheet" href="includes/diseno/css/style_login.css">
  		<link rel="stylesheet" href="includes/diseno/css/style2.css">
  		<link rel="stylesheet" href="includes/diseno/css/awesome.min.css">
  		<link rel="stylesheet" href="includes/diseno/css/nulegi.css">
  		<link rel="stylesheet" href="includes/diseno/css/owl.carousel.min.css">
  		<link rel="stylesheet" href="includes/js/fancybox/source/jquery.fancybox.css">
  		<style>
  			.name-contract{
  				font-size: 15px;
  				top: 100px;
  				width: 300px;
  			}

  			#spn_nombre{
  				font-weight: bold;
  			}

  			#div_mensaje div, #div_mensaje1 div, #div_mensaje2 div{
  				color:red;
  				font-size: 12px;
  			}
  		</style>
  		<!-- js -->
  		<script src="includes/diseno/js/jquery.min.js"></script>
  		<script src="includes/diseno/js/bootstrap.js"></script>
  		<script src="includes/diseno/js/owl.carousel.min.js"></script>
  		<script src="includes/js/fancybox/source/jquery.fancybox.js"></script>
  		<script src="includes/js/funciones.js"></script>
  		<script type="text/javascript">
		    document.write('<meta name="viewport" content="width=device-width,height='+ window.innerHeight +', initial-scale=1.0">');
			function PreRegistroUsuario(){
				var error = false;
				var mensaje = '';
				var correo = jQuery('#txt_correo_registro').val();
				var clave1 = jQuery('#txt_clave_registro').val();
				jQuery('#div_mensaje2').html('');
				if(correo == '' || validateEmail(correo) == false){
					mensaje += '<div>Ingrese un correo valido.</div>';
					error = true;
				}
				if(clave1 == ''){
					mensaje += '<div>Ingrese su contraseña.</div>';
					error = true;
				}
				if(clave1.length < 6 && clave1 != ''){
					mensaje += '<div>La contraseña debe tener al menos 6 caracteres.</div>';
					error = true;
				}
				if(error == true){
					jQuery('#div_mensaje2').html(mensaje);
				}
				else{
					jQuery.ajax({
				        url: "index.php/inicio/pre_registro_usuario",
				        type: 'post',
				        data: {
				            correo:encode(correo),
				            clave:encode(clave1)
				        },
				        dataType: 'json',
				        success: function(respuesta) {
				        	jQuery('.div_loader').hide();
				        	switch(parseInt(respuesta.res)){
				        		case 1:
				        			var mensaje = 'Usuario registrado exitosamente. </br>Se envi&oacute; un mensaje al correo <strong>'+correo+'</strong> con sus datos de acceso.';
				        			break;
				        		case 2:
				        			var mensaje = 'Ya existe un usuario registrado con ese correo. Ingrese uno distinto.';
				        			break;
				        		case 3:
				        			var mensaje = 'Error al enviar el correo. Intente nuevamente.';
				        			break;
				        		default:
				        			var mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
				        			break;
				        	}
				        	jQuery('#div_mensaje2').html(mensaje);
				        },
				        error: function (error){
				            //alert(error);
				        }
				    }); 
				}
			}

			function ReestablecerVer(){
				jQuery('.cancelar').click();
				jQuery('#btn_reestablecer').click();
			}

			function Reestablecer(url){
		        var correo = jQuery('#txt_correo_recuperar').val();
		        jQuery('#div_mensaje1').html('');
		        if(correo == '' || validateEmail(correo) == false){
		            jQuery('#div_mensaje1').html('Ingrese un correo valido.');
		        }
		        else{
		            jQuery('#btn_recuperar').val('Espere...');
		            jQuery('#btn_recuperar').prop('disabled', true);
		            jQuery.ajax({
		                url: 'index.php/inicio/ReestablecerClave',
		                type: 'post',
		                data: {
		                    correo:encode(correo)
		                },
		                dataType: 'json',
		                success: function(respuesta) {
		                    var mensaje;
		                    switch(parseInt(respuesta.res)){
		                        case 1:
		                            mensaje = '<div>Se envi&oacute; un correo a <strong>'+correo+'</strong>.</br> con instrucciones para reestablecer su contraseña.</div>';
		                            break;
		                        case 2:
		                            mensaje = '<div>El correo ingresado no est&aacute; registrado.</div>';
		                            break;
		                        default:
		                            mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
		                            break;
		                    }
		                    AbrirAlerta(mensaje, 'auto','auto');
		                },
		                error: function (error){
		                    //alert(error);
		                }
		            }); 
		        }
		    }

			function ReestablecerConfirmar(){
		        var clave = jQuery('#txt_clave_res').val();
		        jQuery('#div_mensaje2').html('');
		        var error = false;
		        var mensaje;
		        if(clave.length < 6){
		            mensaje = 'La contraseña debe tener</br> al menos 6 caracteres';
		            error = true;
		        }
		        if(error == true){
		            jQuery('#div_mensaje2').html(mensaje);
		        }
		        else{
		            var correo = atob(getURLParameter('c'));
		            var hash = getURLParameter('h');
		            jQuery('#btn_enviar2').val('Espere...');
		            jQuery('#btn_enviar2').prop('disabled', true);
		            jQuery.ajax({
		                url: 'index.php/inicio/ReestablecerClaveConfirmar',
		                type: 'post',
		                data: {
		                    hash:hash,
		                    correo:encode(correo),
		                    clave:encode(clave)
		                },
		                dataType: 'json',
		                success: function(respuesta) {
		                	jQuery('.div_loader').hide();
		                    var mensaje;
		                    switch(parseInt(respuesta.res)){
		                        case 1:
		                            mensaje = '<div>Contraseña reemplazada exitosamente.</div>';
		                            break;
		                        case 2:
		                            mensaje = '<div>Se excedi&oacute; el tiempo de solicitud.</br>Solicite nuevamente reestablecer su contraseña.</div>';
		                            break;
		                        case 3:
		                            mensaje = '<div>Informaci&oacute;n incorrecta. </br>Solicite nuevamente reestablecer su contraseña.</div>';
		                            break;
		                        case 4:
		                            mensaje = '<div>Debe solicitar reestablecer su contraseña </br> antes de confirmar una nueva.</div>';
		                            break;
		                        default:
		                            mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
		                            break;
		                    }
		                    AbrirAlerta(mensaje, 'auto', 'auto');
		                    setTimeout(function(){
		                        window.location.href = 'index.php';
		                    }, 5000);
		                },
		                error: function (error){
		                    //alert(error);
		                }
		            }); 
		        }
		    }

			function ReestablecerClaveForm(correo){
	            formRestPassVerificacion = ''
	            	+'<h2>Reestablecer contraseña</h2>'
	            	+'</br>'
	                +'Correo: '+atob(correo)+'</br></br>'
	                +'Ingrese su nueva contraseña:'
	            	+'<div id="div_mensaje2" style="color:red;"></div>'
                	+'<input type="password" id="txt_clave_res"/>'
                	+'</br>'
                	+'</br>'
                    +'<input id="btn_enviar2"type="button" onclick="ReestablecerConfirmar();" value="Aceptar" />';
	            return formRestPassVerificacion;
	        }

	        function IniciarSesion(){
		        var correo = jQuery('#txt_correo').val();
		        var clave = jQuery('#txt_clave').val();
		        var error = false;
		        jQuery('#div_mensaje').html('');
		        var mensaje = '';
		        if(correo == '' || validateEmail(correo) == false){
		            mensaje += '<div>Ingrese un correo v&aacute;lido.</div>';
		            error = true;
		        }
		        if(clave == ''){
		            mensaje += '<div>Ingrese su contrase&ntilde;a.</div>';
		            error = true;
		        }
		        if(error == true){
		            jQuery('#div_mensaje').html(mensaje);
		        }
		        else{
		            var tipo_usuario = '1';
		            jQuery.ajax({
		                url: 'index.php/inicio/iniciar_sesion',
		                type: 'post',
		                data: {
		                    tipo_usuario:encode(tipo_usuario),
		                    correo:encode(correo),
		                    clave:encode(clave)
		                },
		                dataType: 'json',
		                success: function(respuesta) {
		                    var mensaje;
		                    switch(parseInt(respuesta.res)){
		                        case 1:
	                                if(respuesta.nombres == '0' || respuesta.apellidos == '0' || respuesta.direccion == '0' || respuesta.telefono == '0' || respuesta.nacimiento == '0000-00-00' || respuesta.dpi == '0' || respuesta.licencia == '0' || respuesta.oficio == '0'){
	                                    var mensaje = '<div>Termine de llenar sus datos de perfil </br>para mejorar la utilizacion de la plataforma de NULEGI.</div>';
	                                    jQuery('#div_mensaje').html(mensaje);
	                                    setInterval(function(){
	                                        //window.top.location.href = 'index.php/inicio/perfil/#'+respuesta.id;
	                                        window.top.location.href = 'index.php/inicio/contratos';
	                                    }, 5000);
	                                }
	                                else{
	                                    //window.top.location.href = 'index.php/inicio/perfil/#'+respuesta.id;
	                                    window.top.location.href = 'index.php/inicio/contratos';
	                                }
		                            break;
		                        case 2:
		                            mensaje = '<div>Accesos incorrectos. Intente nuevamente.</div>';
		                            jQuery('#div_mensaje').html(mensaje);
		                            break;
		                        default:
		                            mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
		                            jQuery('#div_mensaje').html(mensaje);
		                            break;
		                    }
		                },
		                error: function (error){
		                    //alert(error);
		                }
		            }); 
		        }
		    }
		</script>
	</head>
	<body>
		<nav class="navbar navbar-default">
		  	<div class="container-fluid">
		    	<!-- Brand and toggle get grouped for better mobile display -->
		    	<div class="navbar-header">
		      		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
		      		</button>
		      		<a class="navbar-brand" href="#"><img src="includes/diseno/images/logo.png"></a>
		    	</div>
		    	<!-- Collect the nav links, forms, and other content for toggling -->
		    	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      	<ul class="nav navbar-nav navbar-right">
				        <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a></li>
				        <li><a data-toggle="modal" href="#mdl_registro">Regístrate</a></li>
				        <li><a data-toggle="modal" href="#mdl_login">Iniciar Sesión</a></li>
				        <li><a href="#">Contacto</a></li>
			      	</ul>
		    	</div><!-- /.navbar-collapse -->
		  	</div><!-- /.container-fluid -->
		</nav>
	  	<div class="wrapper">
		    <section>
		        <section class="module parallax parallax-1">
		          	<div class="box-color"> 
		            	<b>Generador de Contratos</b>
		              	<div>en línea para Guatemala</div>
		          	</div>
		          	<button class="view_contract">Ver contratos</button>
		        </section>
		        <section class="module content limit">
		          	<div class="container">
		            	<p class="title-parallax-2"> Tan fácil como ingresar tus datos</p>            
		            	<p class="title-parallax-3"> Para generar el contrato</p>
		          	</div>
		          	<div class="box-flex">
		            	<div class="form">
			              	<p class="paso">Paso 1</p>
				            <p class="subtitle"><b>Nombre Revelador</b></p>
				            <p class="description">Ingresa tu Nombre para iniciar el generador de contratos y personalizar tu contrato.</p>
				            <input type="name" name="nombre" class="textField" id="nameRevelator">
				            <input type="submit" name="Ingresa" class="send" onclick="eventName()">
		              		<div class="sequence">
		                		<div class="circle circle-1 active">1</div>
		                		<div class="circle circle-2">2<p class="description-circle">Edad <br> Revelador</p></div>
		                		<div class="circle circle-3">3<p class="description-circle">Nacionalidad<br> Revelador</p></div>
		              		</div>
		            	</div>
		            	<div class="contract-paper"> 
		              		<img src="includes/diseno/images/contract.png">
		              		<div class="name-contract">Este es el texto de un contrato en el cual se ingresará el nombre del campo de texto de la izquierda. Nombre: <span id="spn_nombre"></span>. Y Esa es la forma en la que se generan los contratos según la información ingresada.</div>
		            	</div>
		          	</div>
		          	<div class="place-contract"> 
		              	<div class="column first">
		                	<img src=" includes/diseno/images/screen.png">
		              	</div>
		              	<div class="column">
		                	<p class="title-parallax-2">
		                  		Mantén todos tus <br>  contratos en un <br> solo lugar
		                	</p>
		                	<p class="title-parallax-3">
		                  		archiva, imprime y comparte <br>  tus contratos con nuestra <br>   nueva plataforma
		                	</p>
		              	</div>
		          	</div>
		        </section>
		        <section class="module parallax parallax-2">
		          	<div class="container">
		                <p class="title-parallax-2">
		                  	Diferentes categorías de Contratos
		                </p>
		                <p class="title-parallax-3">
		                  	Explora contratos y paga por contrato generado
		                </p>
		                <div class="list-icon">
		                    <div class="flex-icon"> 
		                        <img src="includes/diseno/images/laborales.png">
		                        <p>Laborales</p>
		                        <div class="hover laborales-bg">
		                          	<p>TITULO</p>
		                          	<p>Inicio de ONGs, protección de bienes, impuestos y todo relacionado con empresas ONGs</p>
		                        </div>
		                    </div>
		                    <div class="flex-icon"> 
		                        <img src="includes/diseno/images/maritales.png">
		                        <p>Maritales</p>
		                        <div class="hover maritales-bg">
		                          	<p>TITULO</p>
		                          	<p>Inicio de ONGs, protección de bienes, impuestos y todo relacionado con empresas ONGs</p>
		                        </div>
		                    </div>
		                    <div class="flex-icon"> 
		                        <img src="includes/diseno/images/divorcio.png">
		                        <p>Divorcio y custodia</p>
		                        <div class="hover divorcios-bg">
		                          	<p>TITULO</p>
		                          	<p>Inicio de ONGs, protección de bienes, impuestos y todo relacionado con empresas ONGs</p>
		                        </div>
		                    </div>
		                    <div class="flex-icon"> 
		                        <img src="includes/diseno/images/negocios.png">
		                        <p>Formación de negocios</p>
		                        <div class="hover negocios-bg">
		                          	<p>TITULO</p>
		                          	<p>Inicio de ONGs, protección de bienes, impuestos y todo relacionado con empresas ONGs</p>
		                        </div>
		                    </div>
		                    <div class="flex-icon"> 
		                        <img src="includes/diseno/images/bienesRaices.png">
		                        <p>Bienes y Raíces</p>
		                        <div class="hover bienes-bg">
		                          	<p>TITULO</p>
		                          	<p>Inicio de ONGs, protección de bienes, impuestos y todo relacionado con empresas ONGs</p>
		                        </div>
		                    </div>
		                    <div class="flex-icon"> 
		                        <img src="includes/diseno/images/intelectual.png">
		                        <p>Propiedad Intelectual</p>
		                        <div class="hover intelectual-bg">
		                          	<p>TITULO</p>
		                          	<p>Inicio de ONGs, protección de bienes, impuestos y todo relacionado con empresas ONGs</p>
		                        </div>
		                    </div>
		                    <div class="flex-icon"> 
		                        <img src="includes/diseno/images/escolares.png">
		                        <p>Escolar</p>
		                        <div class="hover escolares-bg">
		                          	<p>TITULO</p>
		                          	<p>Inicio de ONGs, protección de bienes, impuestos y todo relacionado con empresas ONGs</p>
		                        </div>
		                    </div>
		                    <div class="flex-icon"> 
		                        <img src="includes/diseno/images/ongs.png">
		                        <p>ONG'S</p>
		                        <div class="hover ongs-bg">
		                          	<p>TITULO</p>
		                          	<p>Inicio de ONGs, protección de bienes, impuestos y todo relacionado con empresas ONGs</p>
		                        </div>
		                    </div>
		                </div>
		          	</div>
		        </section>
		        <section class="module content contact">
		          	<div class="box-contact map"> 
		            	<img src=" includes/diseno/images/hand.png">
		          	</div>
		          	<div class="box-contact form"> 
		            	<p class="title-parallax-2"> LA IMPORTANCIA DE UN <br>  CONTRATO</p>            
		            	<div class="raw"> 
		                	<div class="circle"> </div>
		                	<div> 
		                    	<p>BENEFICIO 1</p>
		                    	<p>Descripción del beneficio</p>
		                	</div>
		            	</div>  
		            	<div class="raw"> 
		                	<div class="circle"> </div>
		                	<div> 
		                    	<p>BENEFICIO 1</p>
		                    	<p>Descripción del beneficio</p>
		                	</div>
		            	</div>  
		            	<div class="raw"> 
		                	<div class="circle"> </div>
		                	<div> 
		                    	<p>BENEFICIO 1</p>
		                    	<p>Descripción del beneficio</p>
		                	</div>
		            	</div>  
		          	</div>
		    	</section><!-- /main -->
	    		<footer class="bg-blue">
	      			<div class="flex-box">
				        <div class="box-item"> 
				            <img src="includes/diseno/images/btnContact.png">
				        </div>
	        			<div class="box-item end"> 
				            <input name="correo" placeholder="Correo"> 
				            <input name="nombre" placeholder="Nombre">
				            <textarea name="Mensaje" placeholder="Mensaje"></textarea>
				            <input type="submit" name="send_contact" value="Enviar" class="send_contact">
	        			</div>
	      			</div>
	    		</footer><!-- /footer -->
	    	</section>
		</div><!-- /#wrapper -->
		<div class="toggle-menu bg-orange" style="display: none">
		  	<div>Inicio</div>
		  	<div>Quienes Somos</div>
		  	<div>Unete</div>
		  	<div>Contactanos</div>
		</div>
	</body>
	<a data-toggle="modal" id="btn_reestablecer" href="#mdl_reestablecer" style="display:none;">Reestablecer</a>
	<div class="modal fade" id="mdl_reestablecer" role="dialog">
	    <div class="modal-dialog">
	      <!-- Modal content-->
	      	<div class="modal-content">
	        	<div class="modal-body">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<div style="background:white; padding:10px;">
	          			<label>Restablecer contraseña</label>
	          			</br>
	          			</br>
	          			<div id="div_mensaje1" style="color:red;"></div>
	          			<div>
	          				<label class="description">Ingrese su correo</label>
					        <input type="email" class="textField" id="txt_correo_recuperar">
	          			</div>
	         		</div>
	         		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge button-generator">
		          		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			          		<input type="submit" value="Cancelar" class="buttonLightbox" data-dismiss="modal">
		          		</div>
		          		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		          			<input type="button" value="Aceptar" id="btn_recuperar" class="buttonLightbox" onclick="Reestablecer();">
		          		</div>
	      			</div>
	        	</div>
	      </div>
	    </div>
	</div>
	<div class="modal fade" id="previewContract" role="dialog">
	    <div class="modal-dialog">
	      <!-- Modal content-->
	      	<div class="modal-content">
	        	<div class="modal-body">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<p style="background:white;" class="contentCondition">
	          			Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. 
	         		</p>
	         		<p class="marginLarge legend-Contract">
	         			Esta es la vista previa de su contrato, haga click en guardar despues de leerlo 
	         			y para poder editarlo mas tarde haga click en guardar como borrador si ya es un contrato 
	         			ﬁnal haga click en guardar
	         		</p>
	      			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge button-generator">
		          		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		          			<a href="borrador.html">
			          			<input type="submit" value="Cancelar" class="buttonLightbox" data-dismiss="modal">
		          			</a>
		          		</div>
		          		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		          			<input type="submit" value="Generar" class="buttonLightbox" onclick="GenerarContrato(<?php echo $contrato_disponible['contrato_disponible']['contrato_id']?>);">
		          		</div>
	      			</div>
	        	</div>
	      </div>
	    </div>
	</div>
	<div class="modal fade" id="mdl_login" role="dialog">
	    <div class="modal-dialog">
	      <!-- Modal content-->
	      	<div class="modal-content">
	        	<div class="modal-body">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<div style="background:white; padding:10px;">
	          			<label>Iniciar Sesión</label>
	          			</br>
	          			</br>
	          			<div id="div_mensaje" style="color:red;"></div>
	          			<div>
	          				<label class="description">Correo</label>
					        <input type="email" class="textField" id="txt_correo">
		         			</br>
		         			<label class="description">Contraseña</label>
					        <input type="password" class="textField" id="txt_clave">
	          			</div>
	         		</div>
	         		<p class="marginLarge legend-Contract">
	          			<a href="#" onclick="ReestablecerVer();">Olvidaste tu contraseña?</a>
	         		</p>
	         		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge button-generator">
		          		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			          		<input type="submit" value="Cancelar" class="buttonLightbox cancelar" data-dismiss="modal">
		          		</div>
		          		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		          			<input type="button" value="Aceptar" class="buttonLightbox" onclick="IniciarSesion();">
		          		</div>
	      			</div>
	        	</div>
	      </div>
	    </div>
	</div>
	<div class="modal fade" id="mdl_registro" role="dialog">
	    <div class="modal-dialog">
	      <!-- Modal content-->
	      	<div class="modal-content">
	        	<div class="modal-body">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<div style="background:white; padding:10px;">
	          			<label>Registro</label>
	          			</br>
	          			</br>
	          			<div id="div_mensaje2" style="color:red;"></div>
	          			<div>
	          				<label class="description">Correo</label>
					        <input type="email" class="textField" id="txt_correo_registro">
		         			</br>
		         			<label class="description">Contraseña</label>
					        <input type="password" class="textField" id="txt_clave_registro">
	          			</div>
	         		</div>
	         		<p class="marginLarge legend-Contract">
	          			<a href="#" onclick="ReestablecerVer();">Olvidaste tu contraseña?</a>
	         		</p>
	         		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge button-generator">
		          		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			          		<input type="submit" value="Cancelar" class="buttonLightbox cancelar" data-dismiss="modal">
		          		</div>
		          		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		          			<input type="button" value="Registrarme" class="buttonLightbox" onclick="PreRegistroUsuario();">
		          		</div>
	      			</div>
	        	</div>
	      </div>
	    </div>
	</div>
	<script type="text/javascript">
	    $(document).ready(function(){
	      	$(".list-icon").find(".flex-icon").each(function(){
	        	$(this).mouseenter(function(){
	            	$(this).find(".hover").css("display", "flex");
	        	});
	        	$(this).mouseleave(function(){
	            	$(this).find(".hover").css("display", "none");
	        	});
	      	});

	      	$(".menu").click(function(){
	        	if ($(".toggle-menu").is(":visible")) {
	          		$(".overlay").css("opacity", "0");
	          		$(".menu i").css("color", "blue");
	        	}
	        	else {
	          		$(".menu i").css("color", "white");
	          		$(".overlay").css("opacity", "0.5");
	          		$(".overlay").css("transition", "0.5 s");
	        	}
	        	$(".toggle-menu").toggle();
	      	});

	      	if(getURLParameter('c') && getURLParameter('h')){
                var correo = getURLParameter('c');
                var formulario = ReestablecerClaveForm(correo);
                AbrirAlerta(formulario, 'auto', 'auto');
            }
	    });

	  	function eventName(){
	    	var name = $("#nameRevelator").val();
	    	$("#spn_nombre").html(name);
  		}
	</script>
</html>