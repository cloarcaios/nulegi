<?php 
	$data['pagina'] = 'pagina4';
	$data['id'] = $id;
	$this->load->view('header', $data); 
?>
			</div>
		</div>
		<script type="text/javascript">
			function PreRegistroCliente(){
				var error = false;
				var mensaje = '';
				var correo = jQuery('#txt_correo').val();
				var clave1 = jQuery('#txt_clave1').val();
				var clave2 = jQuery('#txt_clave2').val();
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
					AbrirAlerta(mensaje, 'auto', 'auto');
				}
				else{
					jQuery.ajax({
				        url: "../inicio/pre_registro_usuario",
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
									setTimeout(function(){
				                        window.location.reload(true);
				                    }, 8000);
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
				        	AbrirAlerta(mensaje, 'auto', 'auto');
				        },
				        error: function (error){
				            //alert(error);
				        }
				    }); 
				}
			}
		</script>
		<!-- Main -->
		<div id="main-wrapper">
			<div class="container">						
				<!-- Content -->
				<article class="box post">
					<a href="#" class="image featured"><img src="../../includes/images/pic01.jpg" alt="" /></a>
					<header>
						<h2>Registro</h2>
						<p>Ingrese los siguientes datos</p>
					</header>
					<p>
						<form style="width:350px;">
							<label>Correo</label>
							<input type="email" id="txt_correo"/>
							<label>Contraseña</label>
							<input type="password" id="txt_clave1"/>
							<input type="button" value="Registrarme" onclick="PreRegistroCliente();">
						</form>
					</p>
				</article>
			</div>
		</div>
<?php $this->load->view('footer'); ?>