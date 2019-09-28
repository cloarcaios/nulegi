<?php $this->layout->block('headhtml'); ?>
	<script type="text/javascript">
		function GenerarContrato(contrato_disponible){
			var usuario_id = '<?php echo $sesion["id"];?>';
			if(!usuario_id){
				var iniciar_sesion_form = '<div id="div_inicio_sesion">'+
											'<header>'+
												'<h2>Iniciar Sesión</h2>'+
												'<p>Ingrese los siguientes datos</p>'+
											'</header>'+
											'<p>'+
												'<form style="width:350px;" action="#">'+
													'<label>Correo</label>'+
													'<input type="email" id="txt_correo_inicio"/>'+
													'<label>Contraseña</label>'+
													'<input type="password" id="txt_clave_inicio"/>'+
													'<input type="button" value="Iniciar Sesion" onclick="IniciarSesion(\'../../index.php/inicio/iniciar_sesion\', true);">'+
												'</form> '+
											'</p>'+
										'</div>';
				AbrirAlerta(iniciar_sesion_form, 'auto', 'auto');
			}
			else{
				window.location.href='contrato_gen?c='+contrato_disponible;
			}
		}
	</script>
<?php $this->layout->block(); ?>

<?php $this->layout->block('section-page'); ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
      <h2 class="titleGeneral"><span class="backLevel">Buscar Contratos | Propiedades |</span> <b class="level"><?php echo $contrato_disponible['contrato_disponible']['nombre']?></b></h2>
    </div>
    <p>Haga click sobre Generar contrato y llene la información solicitada. </p>

    <div class="flex-content">
    
      <div class="wrap ">
        <div class="contentScroll scrollFull">
      
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="imageContractCreate">
                <img src="<?php echo $this->config->base_url().'includes/diseno/'.$contrato_disponible['contrato_disponible']['imagen']; ?>">
            </div>
          </div>

          <div>
            <?php echo $contrato_disponible['contrato_disponible']['descripcion']?>
          </div>


        </div>    
      </div>
    </div>
  
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12  marginLarge nonePadding">
      <img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/back.png">
      <input class="fillButton contract-btn" type="submit" value="Regresar" >
    </div>        
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12  marginLarge nonePadding">
    </div>        
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12  marginLarge nonePadding">
      <input class="fillButton contract-btn" type="submit" value="Generar contrato" data-toggle="modal" href="#previewContract">
      <img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/generar.png">
    </div>        

<div class="modal fade" id="condition" role="dialog">
    <div class="modal-dialog">
      	<!-- Modal content-->
      	<div class="modal-content">
        	<div class="modal-body">
          		<button type="button" class="close" data-dismiss="modal">&times;</button>
          		<p style="background:white;" class="contentCondition">
          			Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.
        		</p>
         		<p class="marginLarge legend-Contract">Por favor leer nuestros términos y condiciones antes de comenzar.</p>
          		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge">
          			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          				<a href="#">
	          				<input type="submit" value="Acepto" class="buttonLightbox" data-toggle="modal">
          				</a>
          			</div>
          			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          				<input type="button" value="Cancelar" class="buttonLightbox" data-dismiss="modal">
          			</div>
          		</div>
        	</div>
      	</div>
    </div>
</div>
<div class="modal fade" id="previewContract" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      	<div class="modal-content">
        	<div class="modal-body">
          		<button type="button" class="close" data-dismiss="modal">&times;</button>
          		<p style="background:white;" class="contentCondition">
          			Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. 
          			Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, 
          			cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una 
          			galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. 
          			No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos 
          			electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la
          			 creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más 
          			 recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye 
          			 versiones de Lorem Ipsum.Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de 
          			 texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un
          			  impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los 
          			  mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino 
          			  que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al 
          			  original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian 
          			  pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, 
          			  el cual incluye versiones de Lorem Ipsum.Lorem Ipsum es simplemente el texto de relleno de las imprentas y
          			   archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500,
          			    cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos
          			     y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, 
          			     sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual 
          			     al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian
          			      pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus 
          			      PageMaker, el cual incluye versiones de Lorem Ipsum.Lorem Ipsum es simplemente el texto de relleno de
          			       las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las indust
          			       rias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) 
          			       desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de 
          			       textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en
          			        documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la 
          			        reación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con 
          			        software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de
          			         Lorem Ipsum.
         		</p>
         		<p class="marginLarge legend-Contract">
         			Esta es la vista previa de su contrato, haga click en guardar despues de leerlo 
         			y para poder editarlo mas tarde haga click en guardar como borrador si ya es un contrato 
         			ﬁnal haga click en guardar
         		</p>
      			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge button-generator">
	          		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	          			<a href="borrador.html">
		          			<input type="submit" value="Cancelar" class="buttonLightbox" data-dismiss="modal">
	          			</a>
	          		</div>
	          		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	          			<input type="submit" value="Generar" class="buttonLightbox" onclick="GenerarContrato(<?php echo $contrato_disponible['contrato_disponible']['contrato_id']?>);">
	          		</div>
      			</div>
        	</div>
      </div>
    </div>
</div>
<?php $this->layout->block(); ?>