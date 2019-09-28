<?php $this->layout->block('headhtml'); ?>
<?php $this->layout->block(); ?>

<?php $this->layout->block('section-page'); ?>
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap ">		
	<div class="contentScroll scrollFull">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
			<h2 class="titleGeneral">Mi cuenta</h2>
			<p>En esta area puedes ver y editar tus datos y subscripcion a Nulegi. </p>
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#home">Información Personal</a></li>
				<li><a data-toggle="tab" href="#menu1">Información Laboral</a></li>
				<li><a data-toggle="tab" href="#menu2">Información Legal</a></li>
			</ul>
			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div>Nombre completo</div>	
							<input type="text" class="tabButton" placeholder="Daniela Pinto">
						</div> 
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div>Correo</div>	
							<input type="text" class="tabButton" placeholder="pintodc90@gmail.com">
						</div> 
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div>Profesión</div>	
							<input type="text" class="tabButton" placeholder="Diseñadora Gráﬁca">
						</div> 
					</div>
					<div class="col-lg-3 col-md-4 col-sm-2 col-xs-12 marginLarge">
						<div class="module1">
							<p>Plan</p>
							<p>Básico</p>
						</div>
						<div class="subModule1">
							10 contratos
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-2 col-xs-12 marginLarge">
						<div class="module2">
							<p>Plan</p>
							<p>Medio</p>
						</div>
						<div class="subModule2">
							10 contratos
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-2 col-xs-12 marginLarge">
						<div class="module3">
							<p>Plan</p> 
							<p>Premium</p>
						</div>
						<div class="subModule3">
							Ilimitado
						</div>
					</div>
				</div>
				<div id="menu1" class="tab-pane fade">
		  			<h3>Menu 1</h3>
		  			<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				</div>
				<div id="menu2" class="tab-pane fade">
		  			<h3>Menu 2</h3>
		  			<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
				</div>
			</div>
		</div>
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