<?php $this->layout->block('headhtml'); ?>
<?php $this->layout->block(); ?>
<?php $this->layout->block('section-page'); ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
        <h2 class="titleGeneral"><span class="backLevel">Versiones del Contrato |</span> <b class="level"><?php echo $contrato_nombre['nombre']?></b></h2>
    </div>
    <div class="flex-content">
		<div id="div_contratos" class="wrap">
			<div class="contentScroll marginLarge">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile">
						<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
						</div>
						<div class="col-lg-5 col-md-2 col-sm-2 col-xs-12">
							Nombre
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
							Tipo
						</div>
						<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12" style="padding: 0!important;">
							Fecha de modificación
						</div>
				</div>
				<?php
					$contratos_html = '';
					foreach ($contratos_versiones as $key => $contrato) {
						$contratos_html .= '<a href="contrato_editar?c='.$contrato['contrato_generado_id'].'">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile marginLarge">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
														<img src="../../includes'.$contrato['icono'].'">
													</div>
													<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 txtFile">
														'.$contrato['contrato_nombre'].'
													</div>
													<div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
														'.$contrato['contrato_tipo'].'
													</div>
													<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12 dateFile">
														'.$contrato['fecha_creacion'].'
													</div>
												</div>
											</a>';
/*
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile">
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">
									<input type="checkbox" class="check">
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
								<img src="images/pluma.png">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile">
									Archivo contrato no editable
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile">
									10/05/2016 9:30 PM
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile">
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">
									<input type="checkbox" class="check">
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
								<img src="images/docImage.png">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile">
									Archivo jpg
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile">
									10/05/2016 9:30 PM
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile">
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">
									<input type="checkbox" class="check">
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
								<img src="images/docWord.png">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile">
									Archivo word
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile">
									10/05/2016 9:30 PM
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile">
								<a href="previewPdf.html">
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">
										<input type="checkbox" class="check">
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
									<img src="images/docPdf.png">
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile">
										Archivo PDF
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile">
										10/05/2016 9:30 PM
									</div>
								</a>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colFile">
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 checkFile">
									<input type="checkbox" class="check">
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
								<img src="images/pluma2.png">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 txtFile">
									Archivo contrato editable
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 dateFile">
									10/05/2016 9:30 PM
								</div>
							</div>*/
					}
					echo $contratos_html;
				?>
			</div>
		</div>
	</div>
<?php $this->layout->block(); ?>
