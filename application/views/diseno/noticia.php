<?php $this->layout->block('headhtml'); ?>
<?php $this->layout->block(); ?>

<?php $this->layout->block('section-page'); ?>
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap ">
	<div class="contentScroll scrollFull">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="titleGeneral">Noticias</h2>
			<div>Encuentra noticias relacionadas a la legalidad en Guatemala</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 nonePadding marginLarge">
					<div class="col-lg-7 col-md-12 col-sm-7 col-xs-12 nonePadding">
						<a href="noticias"><button type="submit" class="back"><i class="glyphicon glyphicon-arrow-left"></i>Regresar a noticias</button></a>
					</div>
				</div>
			</div>
		</div>
		<?php
            $html_noticia = '	<div class="col-lg-6 col-md-12 col-sm-6 col-xs-12 new-single marginLarge">
									<img src="'.$this->config->base_url().'includes/'.$noticia['noticia']['imagen'].'">
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 newsPrincipal marginLarge infoNew" align="justify">
									<h2>'.$noticia['noticia']['titulo'].'</h2>
									<div>
										'.$noticia['noticia']['contenido'].'
									</div>
								</div>';
            echo $html_noticia;
        ?>
	</div>
</div>
<?php $this->layout->block(); ?>