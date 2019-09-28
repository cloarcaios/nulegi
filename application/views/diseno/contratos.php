<?php $this->layout->block('headhtml'); ?>
	<script type="text/javascript">
		$(document).ready(function(){
	        $(".contentScroll2").hide();
	        $(".previewOrder").css("opacity", "0.5");
	        $(".listOrder").css("opacity", "1");
	    });

	    function ContratoBuscar(){
	    	var contrato_tipo = parseInt(jQuery('#slc_buscar').val());
	    	if(contrato_tipo > 0){
	    		var buscar = jQuery('#txt_buscar').val();
	    		if(buscar == ''){
	    			buscar = 0;
	    		}
	    		jQuery.ajax({
	               	url: "buscar",
	               	type: 'post',
	               	data: {
	                	contrato_tipo:contrato_tipo,
	                	buscar:buscar
	               	},
	               	dataType: 'json',
	               	success: function(respuesta) {
	                    switch(parseInt(respuesta.res)){
	                       	case 1:
	                       		jQuery('#div_busqueda').html(respuesta.resultado_busqueda);
	                       		jQuery('#div_busqueda').css('display','block');
	                       		jQuery('#div_contratos').css('display','none');
	                       		$.getScript("../../includes/diseno/js/owl.carousel.js", function( data, textStatus, jqxhr ) {
								  console.log( textStatus ); // Success
								  console.log( "Load was performed." );
								});
								$.getScript("../../includes/diseno/js/scripts.js", function( data, textStatus, jqxhr ) {
								  console.log( textStatus ); // Success
								  console.log( "Load was performed." );
								});
	                        	break;
	                       	default:
	                        	var mensaje = 'No se encontró ningun contrato con los parametros de busqueda. Intente nuevamente.';
	                        	AbrirAlerta(mensaje, 'auto','auto');
	                        	break;
	                   	}
	               	},
	            	error: function (error){
	                   //alert(error);
	               	}
	           	});
	    	}
	    	if(contrato_tipo == 0){
	    		jQuery('#div_busqueda').html('');
           		jQuery('#div_busqueda').css('display','none');
           		jQuery('#div_contratos').css('display','block');
           		jQuery('#txt_buscar').val('');
           		$.getScript("../../includes/diseno/js/owl.carousel.js", function( data, textStatus, jqxhr ) {
				  console.log( textStatus ); // Success
				  console.log( "Load was performed." );
				});
				$.getScript("../../includes/diseno/js/scripts.js", function( data, textStatus, jqxhr ) {
				  console.log( textStatus ); // Success
				  console.log( "Load was performed." );
				});
	    	}
	    }

	    function CategoriaBuscar(contrato_tipo){
	    	if(contrato_tipo == '0'){
	    		jQuery('#div_busqueda').html('');
           		jQuery('#div_busqueda').css('display','none');
           		jQuery('#div_contratos').css('display','block');
           		jQuery('.toggle-category').css('display','none');
           		/*
           		$.getScript("../../includes/diseno/js/owl.carousel.js", function( data, textStatus, jqxhr ) {
				});
				*/
				$.getScript("../../includes/diseno/js/scripts.js", function( data, textStatus, jqxhr ) {
				});
	    	}
	    	else{
	    		jQuery.ajax({
	               	url: "categoria_buscar",
	               	type: 'post',
	               	data: {
	                	contrato_tipo:contrato_tipo
	               	},
	               	dataType: 'json',
	               	success: function(respuesta) {
	                    switch(parseInt(respuesta.res)){
	                       	case 1:
	                       		jQuery('#div_busqueda').html(respuesta.resultado_busqueda);
	                       		jQuery('#div_busqueda').css('display','block');
	                       		jQuery('#div_contratos').css('display','none');/*
	                       		$.getScript("../../includes/diseno/js/owl.carousel.js", function( data, textStatus, jqxhr ) {
								});*/
								$.getScript("../../includes/diseno/js/scripts.js", function( data, textStatus, jqxhr ) {
								});
								jQuery('.toggle-category').css('display','none');
	                        	break;
	                       	default:
	                        	var mensaje = 'No se encontró ningun contrato con los parametros de busqueda. Intente nuevamente.';
	                        	alert(mensaje);
	                        	break;
	                   	}
	               	},
	            	error: function (error){
	                   //alert(error);
	               	}
	           	});
	    	}
	    	$("#select-category").click(function(){
				$(".toggle-category").toggle();
			});	
	    }
	</script>
<?php $this->layout->block(); ?>

<?php $this->layout->block('section-page'); ?>

	<div clasS="contentScroll">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="titleGeneral">Buscar Contratos</h2>
			<div>Encuentra contratos según categoría o por palabra clave. Pon tu cursor sobre el contrato </div>
			<div>que desees para obtener una vista previa o haz click en el para verlo completo. </div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
					<div class="col-lg-8 col-md-10 col-sm-8 col-xs-12 nonePadding marginLarge">
						<div class="col-lg-6 col-lg-6-md-6 col-sm-6 col-xs-12 ">
							<button class="select-bg" id="select-category">
								Selccionar categorìa
							</button>
								<div class="toggle-category" style="display: none">
									<?php
										$html_categorias = '';
										$i = 1;
										foreach ($categorias['categorias'] as $key => $value) {
											if($i == 1){
												$html_categorias .= '<div class="row-cat">';
											}
											$html_categorias .= 			'<button onclick="CategoriaBuscar('.$value['contrato_tipo_id'].');"><img src="'.$this->config->base_url().'includes'.$value['icono'].'"><p>'.$value['nombre'].'</p></button>';
											if($i == 5){
												$html_categorias .= '</div>';
											}
											$i++;	
											if($i > 5){
												$i = 1;
											}											
										}
										echo $html_categorias
									?>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="div_busqueda">
		</div>
		<div id="div_contratos">
			<?php
	            $html_contratos_categoria = '';
	            $i = 0;
	            $primera_vez = true;
	            $categoria_actual = '';
	            $categoria_anterior = '';
	            foreach ($contratos_categoria['contratos'] as $key => $value) {
	            	$categoria_anterior = $categoria_actual;
	            	$categoria_actual = $value['categoria_nombre'];
	            	if($categoria_actual != $categoria_anterior){
	            		if($primera_vez == true){
	            			$i = 0;
	            			$primera_vez = false;
	            		}
	            		else{
	            			$i = 0;
	            			$html_contratos_categoria .= '</div>';
	            		}            		
	            	}
	            	if($i == 0){
	            		$html_contratos_categoria .= '
													<div class="col-lg-12 col-md-12 col-sm-12 nonePadding" style="margin: 15px 0 0;">
														<div class="row-flex">
															<img width="30px" src="'.$this->config->base_url() .'includes'.$value['icono'].'">
															<h3>'.$value['categoria_nombre'].'</h3>
															<hr class="lineTitle"></hr>
														</div>
													</div>

													<div class="marginLarge sliderContract">';
	            	}
	                $html_contratos_categoria .= '		<div class="contractPreview">
															<a href="contrato_pre?c='.$value['contrato_id'].'">
																<div class="preview">
																	<img class="mCS_img_loaded" src="'.$this->config->base_url().'includes/diseno/'.$value['contrato_imagen'].'">
																</div>
																<div class="contentDoc">
																	<h4>'.$value['contrato_nombre'].'</h4>
																	'.$value['contrato_descripcion'].'
																</div>
															</a>
														</div>';
					$i++;
	            }
	            echo $html_contratos_categoria.'</div>';
	        ?>
    	</div>
	</div>
	<div clasS="contentScroll2">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="titleGeneral">Buscar Contratos</h2>
			<div>Encuentra contratos según categoría o por palabra clave. Pon tu cursor sobre el contrato </div>
			<div>que desees para obtener una vista previa o haz click en el para verlo completo. </div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
				<div class="col-lg-8 col-md-10 col-sm-8 col-xs-12 nonePadding marginLarge">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
						<select class="">
							<option>Selccionar categorìa</option>
						</select>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
						<input type="text" placeholder="Ingrese palabra clave">
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowIcon marginLarge">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div class="legendIcon">Labores</div>
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/laborales.png">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div class="legendIcon">Maritales</div>
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/maritales.png">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div class="legendIcon">
					<div>Divorcio y</div>
					<div> custodias</div>
				</div>
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/divorcio.png">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div class="legendIcon">
					<div >Formación</div>
					<div >de negocios</div>
				</div>
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/negocios.png">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div class="legendIcon">
					<div>Lo más</div>
					<div>Usado</div>
				</div>
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/masUsado.png">
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowIcon marginLarge">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div class="legendIcon">
					<div>Bienes</div>
					<div>Raices</div>
				</div>
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/bienesRaices.png">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div class="legendIcon">
					<div>Propiedad</div>
					<div>intelectual</div>
				</div>
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/intelectual.png">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div class="legendIcon">Escolares</div>
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/escolares.png">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div class="legendIcon">ONG's</div>
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/ong.png">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div class="legendIcon">ONG's</div>
				<div>
					<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/ongs.png">
				</div>
			</div>
		</div>
	</div>
<?php $this->layout->block(); ?>