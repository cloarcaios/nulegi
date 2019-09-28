<?php $this->layout->block('headhtml'); ?>
<?php $this->layout->block(); ?>

<?php $this->layout->block('section-page'); ?>
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap ">
	<div class="contentScroll2 marginLarge">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h2 class="titleGeneral"><span class="backLevel">Notarios |</span> <b class="level"><?php echo $notario['notario']['nombres'].' '.$notario['notario']['apellidos'];?></b></h2>
	</div>
	<hr class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<?php
        $html_notario = '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottomSingle">
							<div class="col-lg-6 col-md-10 col-sm-6 col-xs-12">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 nonePadding imgNotario">
									<img src="'.$this->config->base_url().'includes/'.$notario['notario']['foto'].'">
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 marginLarge">
										<div  class="intoName">'.$notario['notario']['nombres'].' '.$notario['notario']['apellidos'].'</div>
										<div>Colegiado no. '.$notario['notario']['colegiado'].'</div>
										<div>'.$notario['notario']['universidad'].'</div>
										<div class="itemMenu">
											<div class="subItem">
												Contactar	
											</div>
											<div class="subItem">
												CV
											</div>
											<div class="subItem">
												Reportar
											</div>
										</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginLarge">
							<b clasS="level">Sobre mi</b>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							'.$notario['notario']['descripcion'].'
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginLarge">
							<b clasS="level">Experiencia</b>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							'.$notario['notario']['experiencia'].'
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginLarge">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 nonePadding marginLarge">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12  marginLarge">
									<input class="fillButton" type="submit" value="Descargar CV">
								</div>				
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12  marginLarge">
									<input class="fillButton" type="submit" value="contactar">
								</div>				
							</div>
						</div>';
        echo $html_notario;
    ?>
</div>
<?php $this->layout->block(); ?>