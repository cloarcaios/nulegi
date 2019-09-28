<?php 
	$data['pagina'] = 'pagina2';
	$data['id'] = $sesion['id'];
	$this->load->view('header', $data);
?>
			</div>
		</div>
		<div id="main-wrapper">
			<div class="container">						
				<!-- Content -->
				<article class="box post" style="height:2100px;">
					<a href="#" class="image featured"><img src="../../includes/images/pic01.jpg" alt="" /></a>
					<header>
						<h2><?php echo $contrato['nombre']; ?></h2>
						<p><?php echo $contrato['descripcion'];?></p>
					</header>
					<p>
						<?php echo $contrato['contenido'];?>
					</p>
				</article>
			</div>
		</div>
<?php $this->load->view('footer'); ?>