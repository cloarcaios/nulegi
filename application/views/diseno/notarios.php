<?php $this->layout->block('headhtml'); ?>
<?php $this->layout->block(); ?>

<?php $this->layout->block('section-page'); ?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 wrap ">
	<div class="contentScroll2 scrollFull marginLarge" style="display:block !important;">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="titleGeneral">Notarios</h2>
			<div>Encuentra notarios según tu región. </div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
				<div class="col-lg-8 col-md-10 col-sm-6 col-xs-12 nonePadding marginLarge">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
						<select class="">
							<option>Selccionar categoría</option>
						</select>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
						<input type="text" placeholder="Ingrese palabra clave">
					</div>
				</div>
			</div>
		</div>
		<hr class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<?php
            $html_notarios = '';
            foreach ($notarios['notarios'] as $key => $value) {
                $html_notarios .= '<div class="col-lg-4 col-md-6 col-sm-4 col-xs-12 marginLarge notario">
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 nonePadding imgNotario">
											<img src="'.$this->config->base_url().'includes/'.$value['foto'].'">
										</div>
										<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 marginLarge">
											<div class="nameNotarioList">'.$value['nombres'].' '.$value['apellidos'].'</div>
											<div>Colegiado no. '.$value['colegiado'].'</div>
											<div>'.$value['universidad'].'</div>
											<div class="itemMenu hoverNotario">
												<div class="subItem">
													Contactar	
												</div>
												<div class="subItem">
													CV
												</div>
												<div class="subItem">
													<a href="notario?n='.$value['abogado_id'].'">
													Reportar
													</a>
												</div>
											</div>
										</div>
									</div>';
            }
            echo $html_notarios;
        ?>

	</div>
</div>
<?php $this->layout->block(); ?>