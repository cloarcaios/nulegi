<?php 
	$data['pagina'] = 'pagina2';
	$data['id'] = $sesion['id'];
	$this->load->view('header', $data);
?>
			</div>
		</div>
		<!-- Main -->
		<style type="text/css">
			/*custom font*/
			@import url(http://fonts.googleapis.com/css?family=Montserrat);

			/*basic reset*/
			* {margin: 0; padding: 0;}

			html {
				height: 100%;
				/*Image only BG fallback*/
				background: url('http://thecodeplayer.com/uploads/media/gs.png');
				/*background = gradient + image pattern combo*/
				background: 
					linear-gradient(rgba(196, 102, 0, 0.2), rgba(155, 89, 182, 0.2)), 
					url('http://thecodeplayer.com/uploads/media/gs.png');
			}

			body {
				font-family: montserrat, arial, verdana;
			}
			/*form styles*/
			#msform {
				width: 100%;
				margin: 50px auto;
				text-align: center;
				position: relative;
				z-index: 100;
			}
			#msform fieldset {
				background: white;
				border: 0 none;
				border-radius: 3px;
				box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
				padding: 20px 30px;
				
				box-sizing: border-box;
				width: 80%;
				margin: 0 10%;
				
				/*stacking fieldsets above each other*/
				position: absolute;
			}
			/*Hide all except first fieldset*/
			#msform fieldset:not(:first-of-type) {
				display: none;
			}
			/*inputs*/
			#msform input, #msform textarea {
				padding: 15px;
				border: 1px solid #ccc;
				border-radius: 3px;
				margin-bottom: 10px;
				width: 100%;
				box-sizing: border-box;
				font-family: montserrat;
				color: #2C3E50;
				font-size: 13px;
			}
			/*buttons*/
			#msform .action-button {
				width: 100px;
				background: #27AE60;
				font-weight: bold;
				color: white;
				border: 0 none;
				border-radius: 1px;
				cursor: pointer;
				padding: 10px 5px;
				margin: 10px 5px;
			}
			#msform .action-button:hover, #msform .action-button:focus {
				box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;
			}
			/*headings*/
			.fs-title {
				font-size: 15px;
				text-transform: uppercase;
				color: #2C3E50;
				margin-bottom: 10px;
			}
			.fs-subtitle {
				font-weight: normal;
				font-size: 13px;
				color: #666;
				margin-bottom: 20px;
			}
			/*progressbar*/
			#progressbar {
				margin-bottom: 30px;
				overflow: hidden;
				/*CSS counters to number the steps*/
				counter-reset: step;
			}
			#progressbar li {
				list-style-type: none;
				color: black;
				text-transform: uppercase;
				font-size: 9px;
				width: 7%;
				float: left;
				position: relative;
			}
			#progressbar li:before {
				content: counter(step);
				counter-increment: step;
				width: 20px;
				line-height: 20px;
				display: block;
				font-size: 10px;
				color: #333;
				background: white;
				border-radius: 3px;
				margin: 0 auto 5px auto;
			}
			/*progressbar connectors*/
			#progressbar li:after {
				content: '';
				width: 100%;
				height: 2px;
				background: #E1DFDF	;
				position: absolute;
				left: -50%;
				top: 9px;
				z-index: -1; /*put it behind the numbers*/
			}
			#progressbar li:first-child:after {
				/*connector not needed before the first step*/
				content: none; 
			}
			/*marking active/completed steps green*/
			/*The number of the step and the connector before it = green*/
			#progressbar li.active:before,  #progressbar li.active:after{
				background: #27AE60;
				color: white;
			}
		</style>
		<script type="text/javascript">
			var paso_actual = 1;
			$( document ).ready(function() {
			    var condiciones = '<h3>Terminos y condiciones</h3>'+
			    					'</br>'+
			    					'</br>'+
			    					'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin euismod, metus et ultrices cursus, diam mauris faucibus mi, malesuada tempor neque diam ut libero. Nunc non pellentesque diam. Quisque mattis cursus velit quis placerat. Integer nec blandit urna, at pellentesque urna. Curabitur facilisis ligula accumsan dui facilisis aliquam. Aenean ultrices risus vitae augue vestibulum, ut luctus felis dapibus. Nullam lobortis malesuada quam et elementum. Nunc dapibus, nisl vel faucibus convallis, eros lorem placerat nibh, sit amet dignissim felis risus sed augue. Nulla nec tortor feugiat, efficitur massa eget, interdum lectus. Integer finibus fermentum auctor. Nam eget velit a purus maximus ullamcorper eget sed dolor. Vivamus fringilla egestas erat condimentum vulputate. Mauris pretium ex ut arcu pellentesque, a auctor diam vestibulum. Pellentesque eget erat eget ante dignissim eleifend interdum sit amet turpis. Ut pharetra, arcu nec venenatis semper, leo eros placerat arcu, ac congue felis nibh sed magna. Nulla rhoncus arcu ac ex aliquet, a aliquam eros euismod.'+
									'Aliquam massa eros, dapibus scelerisque nisi quis, lacinia auctor eros. Sed aliquet pharetra massa, non hendrerit nisl elementum ut. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed orci lacus, pretium eget aliquet a, rutrum a nulla. Integer ullamcorper purus sed mauris egestas, vel elementum quam faucibus. Integer tincidunt enim feugiat, euismod enim sed, malesuada felis. Suspendisse suscipit, eros eget bibendum semper, diam diam varius enim, in ullamcorper nulla dolor sit amet elit. Morbi pulvinar rutrum risus, vel sodales sapien fringilla in. Nam accumsan eros ut eros porttitor elementum vitae nec mi. Integer id mi tortor. Ut nec eros vel ipsum sagittis congue. Nullam vestibulum lectus quis arcu imperdiet, ut feugiat ante iaculis. Nam vestibulum convallis massa ac iaculis. Phasellus convallis dolor eget nisi interdum suscipit.'+
									'Aliquam erat volutpat. Sed ullamcorper velit et ligula vulputate elementum. Nulla iaculis enim ligula. Nam eu turpis ornare, rutrum enim quis, porta augue. Sed consectetur ornare ligula at finibus. Nulla id dolor non magna luctus ultrices. Aenean suscipit lacus in lorem tempor, at convallis mauris efficitur. Aliquam non volutpat nibh. Maecenas at augue sollicitudin elit molestie aliquam. Donec imperdiet lacus in ullamcorper blandit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin lacus et libero luctus tristique.'+
									'Sed semper et neque vitae facilisis. Nullam nulla turpis, pellentesque eu arcu vel, gravida rutrum felis. Ut luctus, libero non auctor lacinia, lorem nisl consectetur lacus, et aliquet odio lectus in elit. Vivamus ac rutrum libero, vitae mattis felis. Suspendisse tincidunt leo eget mattis egestas. Donec accumsan sodales enim, ut malesuada lacus pellentesque at. Nunc lacinia odio nulla, vitae vulputate magna tincidunt eu.'+
									'</br>'+
									'</br>'+
									'<input type="button" id="btn_cancelar" onclick="Redir(\'contratos\');" value="Cancelar"/>'+
									'<input type="button" id="btn_aceptar" onclick="$.fancybox.close();" value="Acepto"/>';
			    AbrirAlerta(condiciones, '40%', '40%', true);
			    var nombres = '<?php echo $sesion["nombres"];?>';
			    var apellidos = '<?php echo $sesion["apellidos"];?>';
			    var direccion = '<?php echo $sesion["direccion"];?>';
			    var telefono = '<?php echo $sesion["telefono"];?>';
			    var nacimiento = '<?php echo $sesion["nacimiento"];?>';
			    var dpi = '<?php echo $sesion["dpi"];?>';
			    var licencia = '<?php echo $sesion["licencia"];?>';
			    var oficio = '<?php echo $sesion["oficio"];?>';
			    if(nombres != '0' && apellidos != '0'){
			    	jQuery('#txt_nombre').val(nombres+' '+apellidos);
			    }
			    if(nacimiento != '0000-00-00'){
			    	var anio_actual = (new Date).getFullYear();
			    	var nacimiento_anio = nacimiento.substring(0, 4);
			    	var edad = parseInt(anio_actual) - parseInt(nacimiento_anio);
			    	jQuery('#txt_edad').val(edad);
			    }
			    if(dpi != '0'){
			    	jQuery('#txt_dpi').val(dpi);
			    }
			});
		</script>
		<div id="main-wrapper">
			<div class="container">						
				<!-- Content -->
				<article class="box post" style="height:1200px;">
					<a href="#" class="image featured"><img src="../../includes/images/pic01.jpg" alt="" /></a>
					<header id="hed_contrato">
						<h2>Tipo de Contrato 1</h2>
						<p>Ingrese la información solicitada</p>
					</header>
					<p>
						<!-- multistep form -->
						<form id="msform">
							<!-- progressbar -->
							<ul id="progressbar">
								<li class="active" onclick="VerPaso(1);">Nombre Revelador</li>
								<li onclick="VerPaso(2);">Edad Revelador</li>
								<li onclick="VerPaso(3);">Nacionalidad Revelador</li>
								<li onclick="VerPaso(4);">Estado civil Revelador</li>
								<li onclick="VerPaso(5);">DPI Revelador</li>
								<li onclick="VerPaso(6);">Nombre Recibidor</li>
								<li onclick="VerPaso(7);">Edad Recibidor</li>
								<li onclick="VerPaso(8);">Nacionalidad Recibidor</li>
								<li onclick="VerPaso(9);">Estado civil Recibidor</li>
								<li onclick="VerPaso(10);">DPI Recibidor</li>
								<li onclick="VerPaso(11);">Motivo Firma</li>
								<li onclick="VerPaso(12);">Nombre</li>
								<li onclick="VerPaso(13);">Descripcion</li>
							</ul>
							<!-- fieldsets -->
							<fieldset id="fls_paso1">
								<h2 class="fs-title">Paso 1</h2>
								<h3 class="fs-subtitle">Nombre Revelador</h3>
								<input type="text" id="txt_nombre" name="txt_nombre" placeholder="Nombre Revelador" onkeypress="return validar_caracter(event, 0);" />
								<input type="button" name="next" class="next action-button" value="Siguiente" />
							</fieldset>
							<fieldset id="fls_paso2">
								<h2 class="fs-title">Paso 2</h2>
								<h3 class="fs-subtitle">Edad Revelador</h3>
								<input type="text" id="txt_edad" name="txt_edad" placeholder="Edad"  onkeypress="return validar_caracter(event, 1);" maxlength="3"/>
								<input type="button" name="previous" class="previous action-button" value="Anterior" />
								<input type="button" name="next" class="next action-button" value="Siguiente" />
							</fieldset>
							<fieldset id="fls_paso3">
								<h2 class="fs-title">Paso 3</h2>
								<h3 class="fs-subtitle">Nacionalidad Revelador</h3>
								<select id="slc_nacionalidad">
									<option value="Guatemalteco">Guatemalteco</option>
									<option value="Salvadoreño">Salvadoreño</option>
									<option value="Hondureño">Hondureño</option>
									<option value="Nicaraguense">Nicaraguense</option>
									<option value="Costarricense">Costarricense</option>
									<option value="Panameño">Panameño</option>
								</select>
								<!--input type="text" id="txt_nacionalidad" name="txt_nacionalidad" placeholder="Nacionalidad" onkeypress="return validar_caracter(event, 0);"/-->
								<input type="button" name="previous" class="previous action-button" value="Anterior" />
								<input type="button" name="next" class="next action-button" value="Siguiente" />
							</fieldset>
							<fieldset id="fls_paso4">
								<h2 class="fs-title">Paso 4</h2>
								<h3 class="fs-subtitle">Estado Civil Revelador</h3>
								<select id="slc_civil">
									<option value="Casado">Casado</option>
									<option value="Soltero">Soltero</option>
								</select>
								<!--input type="text" id="txt_civil" name="txt_civil" placeholder="Estado civil" onkeypress="return validar_caracter(event, 0);"/-->
								<input type="button" name="previous" class="previous action-button" value="Anterior" />
								<input type="button" name="next" class="next action-button" value="Siguiente" />
							</fieldset>
							<fieldset id="fls_paso5">
								<h2 class="fs-title">Paso 5</h2>
								<h3 class="fs-subtitle">DPI Revelador</h3>
								<input type="text" id="txt_dpi" name="txt_dpi" placeholder="DPI" onkeypress="return validar_caracter(event, 1);" maxlength="15"/>
								<input type="button" name="previous" class="previous action-button btn_dpi" value="Anterior" />
								<input type="button" name="next" class="next action-button btn_dpi" value="Siguiente" />
							</fieldset>
							<fieldset id="fls_paso6">
								<h2 class="fs-title">Paso 6</h2>
								<h3 class="fs-subtitle">Nombre Recibidor</h3>
								<input type="text" id="txt_nombre_recibidor" name="txt_nombre_recibidor" placeholder="Nombre Recibidor" onkeypress="return validar_caracter(event, 0);"/>
								<input type="button" name="previous" class="previous action-button" value="Anterior" />
								<input type="button" name="next" class="next action-button" value="Siguiente" />
							</fieldset>
							<fieldset id="fls_paso7">
								<h2 class="fs-title">Paso 7</h2>
								<h3 class="fs-subtitle">Edad Recibidor</h3>
								<input type="text" id="txt_edad_recibidor" name="txt_edad_recibidor" placeholder="Edad Recibidor" onkeypress="return validar_caracter(event, 1);" maxlength="3"/>
								<input type="button" name="previous" class="previous action-button" value="Anterior" />
								<input type="button" name="next" class="next action-button" value="Siguiente" />
							</fieldset>
							<fieldset id="fls_paso8">
								<h2 class="fs-title">Paso 8</h2>
								<h3 class="fs-subtitle">Nacionalidad Recibidor</h3>
								<select id="slc_nacionalidad_recibidor">
									<option value="Guatemalteco">Guatemalteco</option>
									<option value="Salvadoreño">Salvadoreño</option>
									<option value="Hondureño">Hondureño</option>
									<option value="Nicaraguense">Nicaraguense</option>
									<option value="Costarricense">Costarricense</option>
									<option value="Panameño">Panameño</option>
								</select>
								<!--input type="text" id="txt_nacionalidad_recibidor" name="txt_nacionalidad_recibidor" placeholder="Nacionalidad Recibidor" onkeypress="return validar_caracter(event, 0);"/-->
								<input type="button" name="previous" class="previous action-button" value="Anterior" />
								<input type="button" name="next" class="next action-button" value="Siguiente" />
							</fieldset>
							<fieldset id="fls_paso9">
								<h2 class="fs-title">Paso 9</h2>
								<h3 class="fs-subtitle">Estado Civil Recibidor</h3>
								<select id="slc_civil_recibidor">
									<option value="Casado">Casado</option>
									<option value="Soltero">Soltero</option>
								</select>
								<!--input type="text" id="txt_civil_recibidor" name="txt_civil_recibidor" placeholder="Estado civil recibidor" onkeypress="return validar_caracter(event, 0);"/-->
								<input type="button" name="previous" class="previous action-button" value="Anterior" />
								<input type="button" name="next" class="next action-button" value="Siguiente" />
							</fieldset>
							<fieldset id="fls_paso10">
								<h2 class="fs-title">Paso 10</h2>
								<h3 class="fs-subtitle">DPI Recibidor</h3>
								<input type="text" id="txt_dpi_recibidor" name="txt_dpi_recibidor" placeholder="DPI Rebicidor" onkeypress="return validar_caracter(event, 1);" maxlength="15"/>
								<input type="button" name="previous" class="previous action-button" value="Anterior" />
								<input type="button" name="next" class="next action-button" value="Siguiente" />
							</fieldset>
							<fieldset id="fls_paso11">
								<h2 class="fs-title">Paso 11</h2>
								<h3 class="fs-subtitle">Motivo firma</h3>
								<label>Motivos predefinidos</label>
								<?php 
									if($motivos['res'] == 1){
							        	$slc_motivos = '<select id="slc_motivo" onclick="MotivoVer();">';
							        	foreach ($motivos['motivos'] as $key => $value) {
							        		$slc_motivos .= '<option value="'.$value['contenido'].'">'.$value['nombre'].'</option>';
							        	}
							        	$slc_motivos .= '</select>';
							        	$motivos_html = $slc_motivos;
							        }
							        else{
							        	$motivos_html = '<select id="slc_motivos"><option>No existe ningun motivo predefinido</option></select>';
							        }
							        echo $motivos_html;
								?>
								<textarea id="txt_motivo_firma" name="address" placeholder="Motivo Firma" /></textarea>
								<input type="button" name="previous" class="previous action-button" value="Anterior" />
								<input type="button" name="next" class="next action-button" value="Siguiente" />
							</fieldset>
							<fieldset id="fls_paso12">
								<h2 class="fs-title">Paso 12</h2>
								<h3 class="fs-subtitle">Nombre del contrato</h3>
								<input type="text" id="txt_contrato_nombre" name="txt_contrato_nombre" placeholder="Nombre del contrato"/>
								<input type="button" name="previous" class="previous action-button" value="Anterior" />
								<input type="button" name="next" class="next action-button" value="Siguiente" />
							</fieldset>
							<fieldset id="fls_paso13">
								<h2 class="fs-title">Paso 13</h2>
								<h3 class="fs-subtitle">Descripcion del contrato</h3>
								<textarea id="txt_contrato_descripcion" name="txt_contrato_descripcion" placeholder="Descripcion del contrato" /></textarea>
								<input type="button" name="previous" class="previous action-button" value="Anterior" />
								<input type="button" name="submit" class="submit" value="Revisar" onclick="Revisar();" />
							</fieldset>
						</form>
					</p>
				</article>
			</div>
		</div>
		<script src="../../includes/js/jquery.easing.1.3.js" type="text/javascript"></script>
		<script type="text/javascript">
			//jQuery time
			var current_fs, next_fs, previous_fs; //fieldsets
			var left, opacity, scale; //fieldset properties which we will animate
			var animating; //flag to prevent quick multi-click glitches

			$(".next").click(function(){
				switch (paso_actual){
					case 1:
						if(jQuery('#txt_nombre').val() == ''){
							return false;
						}
						break;
					case 2:
						if(jQuery('#txt_edad').val() == ''){
							return false;
						}
						break;
					case 3:
						if(jQuery('#slc_nacionalidad').val() == ''){
							return false;
						}
						break;
					case 4:
						if(jQuery('#slc_civil').val() == ''){
							return false;
						}
						break;
					case 5:
						if(jQuery('#txt_dpi').val() == ''){
							return false;
						}
						break;
					case 6:
						if(jQuery('#txt_nombre_recibidor').val() == ''){
							return false;
						}
						break;
					case 7:
						if(jQuery('#txt_edad_recibidor').val() == ''){
							return false;
						}
						break;
					case 8:
						if(jQuery('#slc_nacionalidad_recibidor').val() == ''){
							return false;
						}
						break;
					case 9:
						if(jQuery('#slc_civil_recibidor').val() == ''){
							return false;
						}
						break;
					case 10:
						if(jQuery('#txt_dpi_recibidor').val() == ''){
							return false;
						}
						break;
					case 11:
						if(jQuery('#txt_motivo_firma').val() == ''){
							return false;
						}
						break;
					case 12:
						if(jQuery('#txt_contrato_nombre').val() == ''){
							return false;
						}
						break;
					case 13:
						if(jQuery('#txt_contrato_descripcion').val() == ''){
							return false;
						}
						break;
				}
				if(animating) return false;
				animating = true;
				
				current_fs = $(this).parent();
				next_fs = $(this).parent().next();
				
				//activate next step on progressbar using the index of next_fs
				$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
				
				//show the next fieldset
				next_fs.show();
				//console.log(next_fs[0]);
				paso_actual++;
				//hide the current fieldset with style
				current_fs.animate({opacity: 0}, {
					step: function(now, mx) {
						//as the opacity of current_fs reduces to 0 - stored in "now"
						//1. scale current_fs down to 80%
						scale = 1 - (1 - now) * 0.2;
						//2. bring next_fs from the right(50%)
						left = (now * 50)+"%";
						//3. increase opacity of next_fs to 1 as it moves in
						opacity = 1 - now;
						current_fs.css({'transform': 'scale('+scale+')'});
						next_fs.css({'left': left, 'opacity': opacity});
					}, 
					duration: 800, 
					complete: function(){
						current_fs.hide();
						animating = false;
					}, 
					//this comes from the custom easing plugin
					easing: 'easeInOutBack'
				});
			});

			$(".previous").click(function(){
				if(animating) return false;
				animating = true;
				
				current_fs = $(this).parent();
				previous_fs = $(this).parent().prev();
				
				//de-activate current step on progressbar
				$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
				
				//show the previous fieldset
				previous_fs.show(); 
				//console.log(previous_fs[0]);
				paso_actual--;
				//hide the current fieldset with style
				current_fs.animate({opacity: 0}, {
					step: function(now, mx) {
						//as the opacity of current_fs reduces to 0 - stored in "now"
						//1. scale previous_fs from 80% to 100%
						scale = 0.8 + (1 - now) * 0.2;
						//2. take current_fs to the right(50%) - from 0%
						left = ((1-now) * 50)+"%";
						//3. increase opacity of previous_fs to 1 as it moves in
						opacity = 1 - now;
						current_fs.css({'left': left});
						previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
					}, 
					duration: 800, 
					complete: function(){
						current_fs.hide();
						animating = false;
					}, 
					//this comes from the custom easing plugin
					easing: 'easeInOutBack'
				});
			});

			$(".submit").click(function(){
				return false;
			})

			function LetrasANumeros(numero){
				if(isNaN(numero) == false){
					var letra = [];
						letra[0] = "cero";
						letra[1] = "uno";
						letra[2] = "dos";
						letra[3] = "tres";
						letra[4] = "cuatro";
						letra[5] = "cinco";
						letra[6] = "seis";
						letra[7] = "siete";
						letra[8] = "ocho";
						letra[9] = "nueve";
					var enletras = '';
					var numeroenletra = numero.toString();
					for(var i = 0; i < numeroenletra.length; i++){
						var caracter = numeroenletra.charAt(i);
						enletras += letra[caracter] + ' ';
					}
					return enletras.trim();
				}
				else{
					return 'error';
				}
			}

			function ValidarDatos(){
				var nombre = jQuery('#txt_nombre').val();
				var edad = jQuery('#txt_edad').val();
				var nacionalidad = jQuery('#slc_nacionalidad').val();
				var civil = jQuery('#slc_civil').val();
				var dpi = jQuery('#txt_dpi').val();
				var nombre_recibidor = jQuery('#txt_nombre_recibidor').val();
				var edad_recibidor = jQuery('#txt_edad_recibidor').val();
				var nacionalidad_recibidor = jQuery('#slc_nacionalidad_recibidor').val();
				var civil_recibidor = jQuery('#slc_civil_recibidor').val();
				var dpi_recibidor = jQuery('#txt_dpi_recibidor').val();
				var motivo_firma = jQuery('#txt_motivo_firma').val();
				var contrato_nombre = jQuery('#txt_contrato_nombre').val();
				var contrato_descripcion = jQuery('#txt_contrato_descripcion').val();
				var mensaje = '';
				var error = false;
				if(nombre == ''){
					mensaje += '<div>Ingrese el nombre.</div>';
					error = true;
				}
				if(edad == ''){
					mensaje += '<div>Ingrese la edad.</div>';
					error = true;
				}
				if(nacionalidad == ''){
					mensaje += '<div>Ingrese la nacionalidad.</div>';
					error = true;
				}
				if(civil == ''){
					mensaje += '<div>Ingrese el estado civil.</div>';
					error = true;
				}
				if(dpi == ''){
					mensaje += '<div>Ingrese el DPI.</div>';
					error = true;
				}
				if(nombre_recibidor == ''){
					mensaje += '<div>Ingrese el nombre del recibidor.</div>';
					error = true;
				}
				if(edad_recibidor == ''){
					mensaje += '<div>Ingrese la edad del recibidor.</div>';
					error = true;
				}
				if(nacionalidad_recibidor == ''){
					mensaje += '<div>Ingrese la nacionalidad del recibidor.</div>';
					error = true;
				}
				if(civil_recibidor == ''){
					mensaje += '<div>Ingrese el estado civil del recibidor.</div>';
					error = true;
				}
				if(dpi_recibidor == ''){
					mensaje += '<div>Ingrese el DPI del recibidor.</div>';
					error = true;
				}
				if(motivo_firma == ''){
					mensaje += '<div>Ingrese el Motivo/Firma.</div>';
					error = true;
				}
				if(contrato_nombre == ''){
					mensaje += '<div>Ingrese el nombre del contrato.</div>';
					error = true;
				}
				if(contrato_descripcion == ''){
					mensaje += '<div>Ingrese la descripcion del contrato.</div>';
					error = true;
				}
				if(error == true){
					AbrirAlerta(mensaje, 'auto', 'auto');
				}
				else{
					var tipo_contrato = '1';
					var dpi_letras = LetrasANumeros(dpi);
					var dpi_letras_recibidor = LetrasANumeros(dpi_recibidor);
					jQuery.ajax({
				        url: "contrato_guardar",
				        type: 'post',
				        data: {
				        	nombre:encode(nombre),
				            edad:encode(edad),
				            nacionalidad:encode(nacionalidad),
				            civil:encode(civil),
				            dpi:encode(dpi),
				            dpi_letras:encode(dpi_letras),
				            nombre_recibidor:encode(nombre_recibidor),
				            edad_recibidor:encode(edad_recibidor),
				            nacionalidad_recibidor:encode(nacionalidad_recibidor),
				            civil_recibidor:encode(civil_recibidor),
				            dpi_recibidor:encode(dpi_recibidor),
				            dpi_letras_recibidor:encode(dpi_letras_recibidor),
				            tipo_contrato:encode(tipo_contrato),
				            motivo_firma:encode(motivo_firma),
				            contrato_nombre:encode(contrato_nombre),
				            contrato_descripcion:encode(contrato_descripcion)
				        },
				        dataType: 'json',
				        success: function(respuesta) {
				        	var mensaje;
				        	switch(parseInt(respuesta.res)){
				        		case 1:
				        			mensaje = '<div>Contrato guardado exitosamente. Puede visualizarlo en su perfil.</div>';
				        			setInterval(function(){
	                                    window.top.location.href = 'contrato_ver?id='+respuesta.ultimo_id;
	                                }, 5000);
				        			break;
				        		default:
				        			mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
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

			function MotivoVer(){
				var motivo = jQuery('#slc_motivo').val();
				jQuery('#txt_motivo_firma').html(motivo);
			}

			MotivoVer();

			function VerPaso(paso){
				switch (paso_actual){
					case 1:
						if(jQuery('#txt_nombre').val() == ''){
							return false;
						}
						break;
					case 2:
						if(jQuery('#txt_edad').val() == ''){
							return false;
						}
						break;
					case 3:
						if(jQuery('#slc_nacionalidad').val() == ''){
							return false;
						}
						break;
					case 4:
						if(jQuery('#slc_civil').val() == ''){
							return false;
						}
						break;
					case 5:
						if(jQuery('#txt_dpi').val() == ''){
							return false;
						}
						break;
					case 6:
						if(jQuery('#txt_nombre_recibidor').val() == ''){
							return false;
						}
						break;
					case 7:
						if(jQuery('#txt_edad_recibidor').val() == ''){
							return false;
						}
						break;
					case 8:
						if(jQuery('#slc_nacionalidad_recibidor').val() == ''){
							return false;
						}
						break;
					case 9:
						if(jQuery('#slc_civil_recibidor').val() == ''){
							return false;
						}
						break;
					case 10:
						if(jQuery('#txt_dpi_recibidor').val() == ''){
							return false;
						}
						break;
					case 11:
						if(jQuery('#txt_motivo_firma').val() == ''){
							return false;
						}
						break;
					case 12:
						if(jQuery('#txt_contrato_nombre').val() == ''){
							return false;
						}
						break;
					case 13:
						if(jQuery('#txt_contrato_descripcion').val() == ''){
							return false;
						}
						break;
				}
				if(animating) return false;
				animating = true;

				current_fs = $('#fls_paso'+paso);
				next_fs = $('#fls_paso'+paso).next();
				previous_fs = $('#fls_paso'+paso).prev();
				for (var i = 1; i <= 13; i++) {
					current_fs2 = $('#fls_paso'+i);
					$("#progressbar li").eq($("fieldset").index(current_fs2)).removeClass("active");
					current_fs2.hide();
				}

				//activate next step on progressbar using the index of next_fs
				for (var i = 1; i <= paso; i++) {
					current_fs2 = $('#fls_paso'+i);
					$("#progressbar li").eq($("fieldset").index(current_fs2)).addClass("active");
				}
				current_fs.animate({opacity: 1}, {
					step: function(now, mx) {
						//as the opacity of current_fs reduces to 0 - stored in "now"
						//1. scale current_fs down to 80%
						scale = 1 - (1 - now) * 0.2;
						//2. bring next_fs from the right(50%)
						left = (now * 50)+"%";
						//3. increase opacity of next_fs to 1 as it moves in
						opacity = 1 - now;
						current_fs.css({'transform': 'scale('+scale+')'});
						//next_fs.css({'left': left, 'opacity': opacity});
					}, 
					duration: 800, 
					complete: function(){
						current_fs.show();
						animating = false;
					}, 
					//this comes from the custom easing plugin
					easing: 'easeInOutBack'
				});
				current_fs.show();
				//console.log(current_fs[0]);
				paso_actual = paso;
			}

			function Revisar(){
				var nombre = jQuery('#txt_nombre').val();
				var edad = jQuery('#txt_edad').val();
				var nacionalidad = jQuery('#slc_nacionalidad').val();
				var civil = jQuery('#slc_civil').val();
				var dpi = jQuery('#txt_dpi').val();
				var nombre_recibidor = jQuery('#txt_nombre_recibidor').val();
				var edad_recibidor = jQuery('#txt_edad_recibidor').val();
				var nacionalidad_recibidor = jQuery('#slc_nacionalidad_recibidor').val();
				var civil_recibidor = jQuery('#slc_civil_recibidor').val();
				var dpi_recibidor = jQuery('#txt_dpi_recibidor').val();
				var motivo_firma = jQuery('#txt_motivo_firma').val();
				var contrato_nombre = jQuery('#txt_contrato_nombre').val();
				var contrato_descripcion = jQuery('#txt_contrato_descripcion').val();
				var mensaje = '';
				var error = false;
				if(nombre == ''){
					mensaje += '<div>Ingrese el nombre.</div>';
					error = true;
				}
				if(edad == ''){
					mensaje += '<div>Ingrese la edad.</div>';
					error = true;
				}
				if(nacionalidad == ''){
					mensaje += '<div>Ingrese la nacionalidad.</div>';
					error = true;
				}
				if(civil == ''){
					mensaje += '<div>Ingrese el estado civil.</div>';
					error = true;
				}
				if(dpi == ''){
					mensaje += '<div>Ingrese el DPI.</div>';
					error = true;
				}
				if(nombre_recibidor == ''){
					mensaje += '<div>Ingrese el nombre del recibidor.</div>';
					error = true;
				}
				if(edad_recibidor == ''){
					mensaje += '<div>Ingrese la edad del recibidor.</div>';
					error = true;
				}
				if(nacionalidad_recibidor == ''){
					mensaje += '<div>Ingrese la nacionalidad del recibidor.</div>';
					error = true;
				}
				if(civil_recibidor == ''){
					mensaje += '<div>Ingrese el estado civil del recibidor.</div>';
					error = true;
				}
				if(dpi_recibidor == ''){
					mensaje += '<div>Ingrese el DPI del recibidor.</div>';
					error = true;
				}
				if(motivo_firma == ''){
					mensaje += '<div>Ingrese el Motivo/Firma.</div>';
					error = true;
				}
				if(contrato_nombre == ''){
					mensaje += '<div>Ingrese el nombre del contrato.</div>';
					error = true;
				}
				if(contrato_descripcion == ''){
					mensaje += '<div>Ingrese la descripcion del contrato.</div>';
					error = true;
				}
				if(error == true){
					AbrirAlerta(mensaje, 'auto', 'auto');
				}
				else{
					var tipo_contrato = '1';
					var dpi_letras = LetrasANumeros(dpi);
					var dpi_letras_recibidor = LetrasANumeros(dpi_recibidor);
					jQuery.ajax({
				        url: "contrato_revisar",
				        type: 'post',
				        data: {
				        	nombre:encode(nombre),
				            edad:encode(edad),
				            nacionalidad:encode(nacionalidad),
				            civil:encode(civil),
				            dpi:encode(dpi),
				            dpi_letras:encode(dpi_letras),
				            nombre_recibidor:encode(nombre_recibidor),
				            edad_recibidor:encode(edad_recibidor),
				            nacionalidad_recibidor:encode(nacionalidad_recibidor),
				            civil_recibidor:encode(civil_recibidor),
				            dpi_recibidor:encode(dpi_recibidor),
				            dpi_letras_recibidor:encode(dpi_letras_recibidor),
				            tipo_contrato:encode(tipo_contrato),
				            motivo_firma:encode(motivo_firma),
				            contrato_nombre:encode(contrato_nombre),
				            contrato_descripcion:encode(contrato_descripcion)
				        },
				        dataType: 'json',
				        success: function(respuesta) {
				        	var mensaje;
				        	switch(parseInt(respuesta.res)){
				        		case 1:
				        			mensaje = respuesta.contrato_revision+
				        			'</br>'+
				        			'</br>'+
				        			'<input type="button" class="previous action-button" value="Cancelar" onclick="$.fancybox.close();" />'+
									'<input type="button" name="submit" class="submit" value="Guardar" onclick="ValidarDatos();" />';
				        			break;
				        		default:
				        			mensaje = '<div>Error de conexi&oacute;n. Intente nuevamente.</div>';
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
			/*
			function disableselect(e){
				return false
			}
			function reEnable(){
				return true
			}
			document.onselectstart=new Function ("return false")
				if (window.sidebar){
				document.onmousedown=disableselect
				document.onclick=reEnable
			}*/
		</script>
<?php $this->load->view('footer'); ?>