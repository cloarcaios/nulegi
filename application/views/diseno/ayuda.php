<?php $this->layout->block('headhtml'); ?>
<?php $this->layout->block(); ?>

<?php $this->layout->block('section-page'); ?>
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap ">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h2 class="titleGeneral">Ayuda</h2>
		<div>Para conocer nuestra plataforma toma este tutorial y familiarizate con nuestra plataforma</div>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginLarge">
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 nonePadding">
			<input type="button" class="fillButton tutorial" value="Ver tutorial">
		</div>
	</div>
	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginLarge">
		<h3>¿Necesitas ayuda más personalizada?</h3>
		<p>Escribenos un mensaje con tu pregunta.</p>

		<textarea class="col-lg-6 col-md-12 col-sm-6 col-xs-6"></textarea>
	</div>
	<div class="col-lg-6 col-md-12 col-sm-6 col-xs-12  marginLarge">
		<input type="submit" class="submitHelp">
	</div>
</div>
<div class="modal fade" id="delete" role="dialog">
    <div class="modal-dialog">
      	<!-- Modal content-->
      	<div class="modal-content">
        	<div class="modal-body">
          		<button type="button" class="close" data-dismiss="modal">&times;</button>
          		<p><img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/imgBorrar.png"></p>
          		<p class="txtLightbox">Esta seguro que desea eliminar logo funsepa</p>
          		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding">
          			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          				<input type="submit" value="Si" class="buttonLightbox">
          			</div>
          			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          				<input type="submit" value="No" class="buttonLightbox">
          			</div>
          		</div>
        	</div>
      	</div>
    </div>
</div>

<div class="modal fade" id="submit" role="dialog">
    <div class="modal-dialog">
      	<!-- Modal content-->
      	<div class="modal-content">
	        <div class="modal-body">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<p><img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/imgEnviar.png"></p>
	          	<p class="txtLightbox">Aque correo deseas enviar Matrimonio Juan
		          	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginLarge">
			          	<input type="email" class="email" value="correo@servicio.com">
				  	</div>	
	          	</p>
	          	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginLarge">
	          		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	          			<input type="submit" value="Enviar" class="buttonLightbox">
	          		</div>
	          		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	          			<input type="submit" value="Cancelar" class="buttonLightbox">
	          		</div>
	          	</div>
	        </div>
      	</div> 
    </div>
</div>
<?php $this->layout->block(); ?>