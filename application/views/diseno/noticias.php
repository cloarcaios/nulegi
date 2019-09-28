<?php $this->layout->block('headhtml'); ?>
<?php $this->layout->block(); ?>

<?php $this->layout->block('section-page'); ?>
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap ">
	<div class="contentScroll scrollFull">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="titleGeneral">Noticias</h2>
			<div>Encuentra noticias relacionadas a la legalidad en Guatemala</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
				<div class="col-lg-6 col-md-8 col-sm-6 col-xs-12 nonePadding marginLarge">
					<div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 nonePadding">
						<input type="text" placeholder="Ingrese palabra clave">
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 newsPrincipal">
			<img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/newsPrincipal.png">
		</div>
		<?php
            $html_noticias = '';
            foreach ($noticias['noticias'] as $key => $value) {
                $html_noticias .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 newsPrincipal marginLarge">
									<a href="noticia?n='.$value['noticia_id'].'">
										<div class="preview">
											<img src="'.$this->config->base_url().'includes/'.$value['imagen'].'">
										</div>				
										<div>
											<div class="contentDoc txtNews">
												<h3>'.$value['nombre'].'</h3>
												<div>'.$value['descripcion'].'</div>
											</div>
										</div>
									</a>
								</div>';
            }
            echo $html_noticias;
        ?>
		<hr class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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