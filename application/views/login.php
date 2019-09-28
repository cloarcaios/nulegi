<?php 
	$data['pagina'] = 'pagina3';
	$data['id'] = $id;
	$this->load->view('header', $data); 
?>
			</div>
		</div>
		<!-- Main -->
		<script type="text/javascript">
			function IniciarSesion(){
				var correo = jQuery('#txt_correo').val();
				var clave = jQuery('#txt_clave').val();
				var error = false;
				var mensaje = '';
				if(correo == '' || validateEmail(correo) == false){
					mensaje += '<div>Ingrese un correo v&aacute;lido.</div>';
					error = true;
				}
				if(clave == ''){
					mensaje += '<div>Ingrese su contrase&ntilde;a.</div>';
					error = true;
				}
				if(clave.length < 6 && clave != ''){
					mensaje += '<div>La contraseña debe tener al menos 6 caracteres.</div>';
					error = true;
				}
				if(error == true){
					AbrirAlerta(mensaje, 'auto', 'auto');
				}
				else{
					var tipo_usuario = '1';
					jQuery.ajax({
				        url: "iniciar_sesion",
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
				        			window.top.location.href = 'contratos';
				        			break;
				        		case 2:
				        			mensaje = '<div>Accesos incorrectos. Intente nuevamente.</div>';
	                                AbrirAlerta(mensaje, 'auto', 'auto');
				        			break;
				        		default:
				        			mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
	                                AbrirAlerta(mensaje, 'auto', 'auto');
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
		<div id="main-wrapper">
			<div class="container">						
				<!-- Content -->
				<article class="box post">
					<a href="#" class="image featured"><img src="../../includes/images/pic01.jpg" alt="" /></a>
					<header>
						<h2>Inicio de Sesión</h2>
						<p>Ingrese los siguientes datos</p>
					</header>
					<p>
						<form style="width:350px;">
							<label>Correo</label>
							<input type="email" id="txt_correo"/>
							<label>Contraseña</label>
							<input type="password" id="txt_clave"/>
							<input type="button" value="Registrarme" onclick="IniciarSesion();">
						</form> 
					</p>
				</article>
			</div>
		</div>
<?php $this->load->view('footer'); ?>