<?php 
	$data['pagina'] = 'pagina6';
	$data['id'] = $sesion['id'];
	$this->load->view('header', $data); 
?>
			</div>
		</div>
		<script type="text/javascript">
			function RegistroCliente(){
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
				if(clave1 == ''){
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
					var pais = jQuery('#slc_paises').val();
					var licencia = jQuery('#txt_licencia').val();
					var dia = jQuery('#slc_dia').val();
					var mes = jQuery('#slc_mes').val();
					var anio = jQuery('#slc_anio').val();
					var nacimiento = anio+'-'+mes+'-'+dia;
					if(licencia == ''){
						licencia = '0';
					}
					jQuery.ajax({
				        url: "../inicio/registro_usuario",
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
				        			var mensaje = 'Usuario registrado exitosamente.';
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
		</script>
		<!-- Main -->
		<div id="main-wrapper">
			<div class="container">						
				<!-- Content -->
				<article class="box post">
					<a href="#" class="image featured"><img src="../../includes/images/pic01.jpg" alt="" /></a>
					<header>
						<h2>Completar Registro</h2>
						<p>Ingrese los siguientes datos</p>
					</header>
					<p>
						<form style="width:350px;">
							<label>Nombres</label>
							<input type="text" id="txt_nombres" onkeypress="return validar_caracter(event, 0);" />
							<label>Apellidos</label>
							<input type="text" id="txt_apellidos" onkeypress="return validar_caracter(event, 0);"/>
							<label>Direccion</label>
							<input type="text" id="txt_direccion"/>
							<label>Telefono</label>
							<input type="text" id="txt_telefono" onkeypress="return validar_caracter(event, 1);" maxlength="12" />
							<label>Genero</label>
							<select id="slc_genero">
								<option value="1">Masculino</option>
								<option value="0">Femenino</option>
							</select>
							<label>Fecha de nacimiento</label>
							<select id="slc_dia" style="width:90px; float:left;">
								<?php
									for($i = 1; $i <= 31; $i++) {
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								?>
							</select>
							<select id="slc_mes" style="width:155px; float:left;">
								<option value="01">Enero</option>
								<option value="02">Febrero</option>
								<option value="03">Marzo</option>
								<option value="04">Abril</option>
								<option value="05">Mayo</option>
								<option value="06">Junio</option>
								<option value="07">Julio</option>
								<option value="08">Agosto</option>
								<option value="09">Septiembre</option>
								<option value="10">Octubre</option>
								<option value="11">Noviembre</option>
								<option value="12">Diciembre</option>
							</select>
							<select id="slc_anio" style="width:105px; float:left;">
								<?php
									for($i = 1940; $i <= 2015; $i++) {
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								?>
							</select>
							<label>Pais</label>
							<?php
								$select_paises = '<select id="slc_paises">';
								foreach ($paises as $key => $value) {
									$select_paises .= '<option value="'.$value['pais_id'].'">'.$value['nombre'].'</option>';
								}
								echo $select_paises.'</select>';
							?>
							<label>DPI</label>
							<input type="text" id="txt_dpi" onkeypress="return validar_caracter(event, 1);"/>
							<label>Licencia</label>
							<input type="text" id="txt_licencia"/>
							<label>Oficio/Profesion</label>
							<input type="text" id="txt_oficio"/>
							<label>Correo</label>
							<input type="email" id="txt_correo"/>
							<label>Contraseña</label>
							<input type="password" id="txt_clave1"/>
							<label>Confirme su contraseña</label>
							<input type="password" id="txt_clave2"/>
							<input type="hidden" id="hdd_id" value=""/>
							<input type="button" id="btn_registro" value="Registrarme" onclick="RegistroCliente();">
						</form>
					</p>
				</article>
			</div>
		</div>
		<script>
			if(getURLParameter('c') && getURLParameter('i')){
                var correo = getURLParameter('c');
                var id = getURLParameter('i');
                jQuery('#txt_correo').val(atob(correo));
                jQuery('#hdd_id').val(atob(id));
            }
            else{
            	jQuery('#txt_nombres').prop('disabled', true);
            	jQuery('#txt_apellidos').prop('disabled', true);
            	jQuery('#txt_direccion').prop('disabled', true);
            	jQuery('#txt_telefono').prop('disabled', true);
            	jQuery('#slc_genero').prop('disabled', true);
            	jQuery('#datepicker').prop('disabled', true);
            	jQuery('#slc_paises').prop('disabled', true);
            	jQuery('#txt_dpi').prop('disabled', true);
            	jQuery('#txt_correo').prop('disabled', true);
            	jQuery('#txt_clave1').prop('disabled', true);
            	jQuery('#txt_clave2').prop('disabled', true);
            	jQuery('#txt_oficio').prop('disabled', true);
            	jQuery('#txt_licencia').prop('disabled', true);
            	jQuery('#btn_registro').prop('disabled', true);
            	AbrirAlerta('Para concluir el registro debe estar previamente registrado.', 'auto', 'auto');
            }
		</script>
<?php $this->load->view('footer'); ?>