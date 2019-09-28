<?php 
	$data['pagina'] = 'pagina2';
	$data['id'] = $sesion['id'];
	$this->load->view('header', $data);
?>
			</div>
		</div>
		<script type="text/javascript">
			function GenerarContrato(){
				var usuario_id = '<?php echo $sesion["id"];?>';
				if(!usuario_id){
					var iniciar_sesion_form = '<div id="div_inicio_sesion">'+
												'<header>'+
													'<h2>Iniciar Sesión</h2>'+
													'<p>Ingrese los siguientes datos</p>'+
												'</header>'+
												'<p>'+
													'<form style="width:350px;" action="#">'+
														'<label>Correo</label>'+
														'<input type="email" id="txt_correo_inicio"/>'+
														'<label>Contraseña</label>'+
														'<input type="password" id="txt_clave_inicio"/>'+
														'<input type="button" value="Iniciar Sesion" onclick="IniciarSesion(\'../../index.php/inicio/iniciar_sesion\', true);">'+
													'</form> '+
												'</p>'+
											'</div>';
					AbrirAlerta(iniciar_sesion_form, 'auto', 'auto');
				}
				else{
					window.location.href='contrato1#hed_contrato';
				}
			}
		</script>
		<div id="main-wrapper">
			<div class="container">						
				<!-- Content -->
				<article class="box post" style="height:1200px;">
					<a href="#" class="image featured"><img src="../../includes/images/pic01.jpg" alt="" /></a>
					<header>
						<h2>Tipo de Contrato 1</h2>
						<p>Ingrese la información solicitada</p>
					</header>
					<p>
						Informacion general del contrato Ipso Lupern osum as ljoei Sllask 
					</p>
					<input type="button" onclick="GenerarContrato();" value="Generar">
				</article>
			</div>
		</div>
<?php $this->load->view('footer'); ?>