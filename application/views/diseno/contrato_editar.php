<?php $this->layout->block('headhtml'); ?>
    <style type="text/css">
		.mensaje_error div{
			color:red;
		}
	</style>
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script src="<?php echo($this->config->base_url());?>includes/tinymce/es.js"></script>
	<script src="<?php echo($this->config->base_url());?>includes/js/jquery.maskedinput.min.js"></script>
	<script type="text/javascript">
	    function ContratoGuardar(){
            $('#elm1').html(tinymce.get('elm1').getContent());      
            var contrato = jQuery('#elm1').val();
            var contrato_generado_id = getURLParameter('c');
            if(contrato != ''){
                jQuery.ajax({
                    url: "contrato_guardar_editado",
                    type: 'post',
                    data: {
                        contrato:contrato,
                        contrato_generado_id:contrato_generado_id,
                        nombre: jQuery('#hdd_contrato_nombre').val()
                    },
                    dataType: 'json',
                    success: function(respuesta) {
                        switch(parseInt(respuesta.res)){
                            case 1:
                                jQuery('#btn_modal_exito').click();
                                break;
                            default:
                                jQuery('#btn_modal_error').click();
                                break;
                        }
                    },
                    error: function (error){
                        //alert(error);
                    }
                });
            }  
        }

        function UsuarioExisteVerificar(){
            var correo = jQuery('#txt_correo').val();
            jQuery.ajax({
                url: "usuario_existe_verificar",
                type: 'post',
                data: {
                    correo:correo
                },
                dataType: 'json',
                success: function(respuesta) {
                    switch(parseInt(respuesta.res)){
                        case 1:
                            jQuery('#btn_compartir_cancelar').click();
                            ContratoCompartir();
                            break;
                        case 0:
                            jQuery('#div_mensaje_error').html('El usuario asociado al correo ingresado no existe, desea compartirlo de todas maneras? <input type="button" value="Compartir" onclick="ContratoCompartir();">');
                            break;
                        default:
                        	jQuery('#btn_compartir_cancelar').click();
                            jQuery('#btn_modal_error').click();
                            break;
                    }
                },
                error: function (error){
                    //alert(error);
                }
            });
        }

        function ContratoCompartir(){
        	var correo = jQuery('#txt_correo').val();
            var contrato_generado_id = getURLParameter('c');
            if(correo != ''){
                jQuery.ajax({
                    url: "contrato_compartir2",
                    type: 'post',
                    data: {
                        correo:correo,
                        contrato_generado_id:contrato_generado_id
                    },
                    dataType: 'json',
                    success: function(respuesta) {
                    	jQuery('#btn_compartir_cancelar').click();
                    	jQuery('#div_mensaje_error').html('');
                        switch(parseInt(respuesta.res)){
                            case 1:
                                jQuery('#btn_modal_exito').click();
                                break;
                            default:
                                jQuery('#btn_modal_error').click();
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
<?php $this->layout->block(); ?>

<?php $this->layout->block('section-page'); ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
        <h2 class="titleGeneral"><span class="backLevel">Buscar Contratos | Propiedades |</span> <b class="level"><?php echo $contrato['nombre']?></b></h2>
    </div>

    <p>Ingrese la información solicitada. </p>
    <div class="flex-content">

	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap wrapEditContract ContratoGenerado">
		<div class="form-group">
			<textarea id="elm1" name="elm1" cols="40" rows="10" wrap="hard"><?php echo $contrato['contenido']?></textarea>
		</div>
        <input class="fillButton" type="button" value="Compartir" data-toggle="modal" href="#mdl_compartir">
		<input class="fillButton" type="button" value="Guardar" onclick="ContratoGuardar();">
		<input id="hdd_contrato_nombre" type="hidden" value="<?php echo $contrato['nombre'];?>">
	</div>
	<input class="fillButton" type="button" id="btn_modal_exito" value="Aceptar" data-toggle="modal" href="#mdl_exito" style="display:none;">
	<div class="modal fade" id="mdl_exito" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  	<div class="modal-content">
		    	<div class="modal-body">
		      		<button type="button" class="close" data-dismiss="modal">&times;</button>
		     		<p class="marginLarge legend-Contract">
		     			Acción procesada exitosamente.
		     		</p>
		  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge">
		          		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		          			<input type="submit" value="Aceptar" class="buttonLightbox" data-dismiss="modal">
		          		</div>
		  			</div>
		    	</div>
		  </div>
		</div>
	</div>
	<input class="fillButton" type="button" id="btn_modal_error" value="Aceptar" data-toggle="modal" href="#mdl_error" style="display:none;">
	<div class="modal fade" id="mdl_error" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  	<div class="modal-content">
		    	<div class="modal-body">
		      		<button type="button" class="close" data-dismiss="modal">&times;</button>
		     		<p class="marginLarge legend-Contract">
		     			Error al procesar el contrato. Intente nuevamente.
		     		</p>
		  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge">
		          		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		          			<input type="submit" value="Aceptar" class="buttonLightbox" data-dismiss="modal">
		          		</div>
		  			</div>
		    	</div>
		  </div>
		</div>
	</div>
	<div class="modal fade" id="mdl_compartir" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div id="div_mensaje_error" class="mensaje_error"></div>
                    <p class="marginLarge legend-Contract" id="p_contrato_nombre">
                        Ingrese el correo del usuario al que le desea compartir este contrato
                        <input type="email" id="txt_correo">
                    </p>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <input type="submit" id="btn_compartir_cancelar" value="Cancelar" class="buttonLightbox" data-dismiss="modal">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <input type="button" id="btn_compartir_aceptar" value="Aceptar" class="buttonLightbox" onclick="UsuarioExisteVerificar();">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script>
  		tinymce.init({
          	selector: "textarea#elm1",
	         plugins: [
				    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
				    'searchreplace wordcount visualblocks visualchars code fullscreen',
				    'insertdatetime media nonbreaking save table contextmenu directionality',
				    'emoticons template paste textcolor colorpicker textpattern imagetools'
				  ],
      		theme: 'modern',			 	
			height:"250px",
			width:"100%",
			toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				toolbar2: 'print preview media | forecolor backcolor emoticons',
       		image_advtab: true,
			templates: [
			    { title: 'Test template 1', content: 'Test 1' },
			    { title: 'Test template 2', content: 'Test 2' }
			  ],
			content_css: [
			    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
			    '//www.tinymce.com/css/codepen.min.css'
			  ]
		});
		
		jQuery("#txt_requerimiento_jornada_inicio").mask("99:99");
		jQuery("#txt_requerimiento_jornada_fin").mask("99:99");
		jQuery("#txt_requerimiento_fecha").mask("99/99/9999");
	</script>
<?php $this->layout->block(); ?>
