<?php $this->layout->block('headhtml'); ?>
	<style type="text/css">
		.mensaje_error div{
			color:red;
		}
	</style>
	<script type="text/javascript">
        $( document ).ready(function() {
        });

		function PreguntaEnviar(){
			var pregunta = jQuery('#txt_pregunta').val();
			jQuery('#div_mensaje_error1').html('');
			if(pregunta == ''){
				jQuery('#div_mensaje_error1').html('Ingrese la pregunta.');
			}
			else{
				jQuery('#btn_pregunta').prop('disabled', true);
				jQuery.ajax({
			        url: "pregunta_guardar",
			        type: 'post',
			        data: {
			        	pregunta:pregunta,
			        },
			        dataType: 'json',
			        success: function(respuesta) {
			        	jQuery('#btn_pregunta').prop('disabled', true);
			        	if(parseInt(respuesta.res) == 1){
			        		jQuery('#btn_modal_exito').click();
			        		jQuery('#txt_pregunta').html('');
			        	}
			        	else{
			        		jQuery('#btn_modal_cancelar').click();
			        	}
			        },
			        error: function (error){
			            jQuery('#btn_modal_cancelar').click();
			        }
			    });
			}
		}	    
	</script>
<?php $this->layout->block(); ?>

<?php $this->layout->block('section-page'); ?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
		<h2 class="titleGeneral"><span class="backLevel">Abogados | Realizar pregunta </span></h2>
	</div>

	<p>Ingrese la información solicitada. </p>
	<div class="flex-content">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap wrapEditContract">
			<div class="col-lg-9 col-md-8 col-sm-9 col-xs-12" style="width:100%;">
				<div class="contentScroll scrollFull generatorContract">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding marginLarge pasos" style="margin-top:-2%; margin-bottom:-2%;">
						<div class="formContract descripcion_paso4" id="div_paso1">
							<h2 class="titleGeneral">Pregunta</h2>
							<br/>
				          	<div id="div_pregunta">
				          		<div id="div_mensaje_error1" class="mensaje_error"></div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<textarea id="txt_pregunta" class="col-lg-12"></textarea>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
								<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">
									<input class="fillButton" id="btn_pregunta" type="button" value="Enviar" onclick="PreguntaEnviar();">
								</div>				
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <input class="fillButton" type="button" id="btn_modal_cancelar" value="Nombre" data-toggle="modal" href="#mdl_contrato_nombre" style="display:none;">
    <div class="modal fade" id="mdl_contrato_nombre" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div id="div_mensaje_error_nombre" class="mensaje_error"></div>
                    <p class="marginLarge legend-Contract" id="p_contrato_nombre">
                        Error al guardar la pregunta. Intente nuevamente.
                        <input type="text" id="txt_contrato_nombre">
                    </p>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <input type="button" id="btn_nombre_verificar" value="Aceptar" class="buttonLightbox" data-dismiss="modal">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input class="fillButton" type="button" id="btn_modal_exito" value="Exito" data-toggle="modal" href="#mdl_contrato_exito" style="display:none;">
    <div class="modal fade" id="mdl_contrato_exito" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div id="div_mensaje_error_exito" class="mensaje_error"></div>
                    <p class="marginLarge legend-Contract" id="p_contrato_nombre">
                        Pregunta realizada exitosamente.
                    </p>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <input type="submit" id="btn_exito_cancelar" value="Aceptar" class="buttonLightbox" data-dismiss="modal">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->layout->block(); ?>
