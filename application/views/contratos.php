<?php 
	$data['pagina'] = 'pagina2';
	$data['id'] = $sesion['id'];
	$this->load->view('header', $data); 
?>
				<!-- Banner -->
				<section id="banner">
					<header>
						<h2>Semper. Elit in Varius.</h2>
						<p>A varius primis at Nullam</p>
					</header>
				</section>
			</div>
		</div>
		<!-- Main -->
		<div id="main-wrapper">
			<div class="container">
				<div class="row">
					<div class="12u">
						<!-- Portfolio -->
						<section>
							<header class="major">
								<h2>Contratos</h2>
							</header>
							<div class="row">
								<div class="4u">
									<section class="box">
										<a href="#" class="image featured"><img src="<?php echo $this->config->base_url(); ?>includes/images/pic02.jpg" alt="" /></a>
										<header>
											<h3>Contrato 1</h3>
										</header>
										<p>Lorem ipsum dolor sit amet sit veroeros sed amet blandit consequat veroeros lorem blandit  adipiscing et feugiat phasellus tempus dolore ipsum lorem dolore.</p>
										<footer>
											<a href="contrato_pre1" class="button alt">Generar contrato</a>
										</footer>
									</section>
								</div>
								<div class="4u">
									<section class="box">
										<a href="contrato1" class="image featured"><img src="<?php echo $this->config->base_url(); ?>includes/images/pic03.jpg" alt="" /></a>
										<header>
											<h3>Contrato 2</h3>
										</header>
										<p>Lorem ipsum dolor sit amet sit veroeros sed amet blandit consequat veroeros lorem blandit  adipiscing et feugiat phasellus tempus dolore ipsum lorem dolore.</p>
										<footer>
											<a href="contrato_pre1" class="button alt">Generar contrato</a>
										</footer>
									</section>
								</div>
								<div class="4u">
									<section class="box">
										<a href="contrato_pre1" class="image featured"><img src="<?php echo $this->config->base_url(); ?>includes/images/pic04.jpg" alt="" /></a>
										<header>
											<h3>Contrato 3</h3>
										</header>
										<p>Lorem ipsum dolor sit amet sit veroeros sed amet blandit consequat veroeros lorem blandit  adipiscing et feugiat phasellus tempus dolore ipsum lorem dolore.</p>
										<footer>
											<a href="contrato1" class="button alt">Generar Contrato</a>
										</footer>
									</section>
								</div>
							</div>
							<div class="row">
								<div class="4u">
									<section class="box">
										<a href="contrato_pre1" class="image featured"><img src="<?php echo $this->config->base_url(); ?>includes/images/pic05.jpg" alt="" /></a>
										<header>
											<h3>Contrato 4</h3>
										</header>
										<p>Lorem ipsum dolor sit amet sit veroeros sed amet blandit consequat veroeros lorem blandit  adipiscing et feugiat phasellus tempus dolore ipsum lorem dolore.</p>
										<footer>
											<a href="contrato1" class="button alt">Generar contrato</a>
										</footer>
									</section>
								</div>
								<div class="4u">
									<section class="box">
										<a href="contrato_pre1" class="image featured"><img src="<?php echo $this->config->base_url(); ?>includes/images/pic06.jpg" alt="" /></a>
										<header>
											<h3>Contrato 5</h3>
										</header>
										<p>Lorem ipsum dolor sit amet sit veroeros sed amet blandit consequat veroeros lorem blandit  adipiscing et feugiat phasellus tempus dolore ipsum lorem dolore.</p>
										<footer>
											<a href="contrato1" class="button alt">Generar contrato</a>
										</footer>
									</section>
								</div>
								<div class="4u">
									<section class="box">
										<a href="contrato_pre1" class="image featured"><img src="<?php echo $this->config->base_url(); ?>includes/images/pic07.jpg" alt="" /></a>
										<header>
											<h3>Contrato 6</h3>
										</header>
										<p>Lorem ipsum dolor sit amet sit veroeros sed amet blandit consequat veroeros lorem blandit  adipiscing et feugiat phasellus tempus dolore ipsum lorem dolore.</p>
										<footer>
											<a href="contrato1" class="button alt">Generar contrato</a>
										</footer>
									</section>
								</div>
							</div>
						</section>
					</div>
				</div>
				<div class="row">
					<div class="12u">
						<!-- Blog -->
						<section>
							<header class="major">
								<h2>The Blog</h2>
							</header>
							<div class="row">
								<div class="6u">
									<section class="box">
										<a href="#" class="image featured"><img src="<?php echo $this->config->base_url(); ?>includes/images/pic08.jpg" alt="" /></a>
										<header>
											<h3>Magna tempus consequat lorem</h3>
											<p>Posted 45 minutes ago</p>
										</header>
										<p>Lorem ipsum dolor sit amet sit veroeros sed et blandit consequat sed veroeros lorem et blandit  adipiscing feugiat phasellus tempus hendrerit, tortor vitae mattis tempor, sapien sem feugiat sapien, id suscipit magna felis nec elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos lorem ipsum dolor sit amet.</p>
										<footer>
											<ul class="actions">
												<li><a href="#" class="button icon fa-file-text">Continue Reading</a></li>
												<li><a href="#" class="button alt icon fa-comment">33 comments</a></li>
											</ul>
										</footer>
									</section>
								</div>
								<div class="6u">
									<section class="box">
										<a href="#" class="image featured"><img src="<?php echo $this->config->base_url(); ?>includes/images/pic09.jpg" alt="" /></a>
										<header>
											<h3>Aptent veroeros et aliquam</h3>
											<p>Posted 45 minutes ago</p>
										</header>
										<p>Lorem ipsum dolor sit amet sit veroeros sed et blandit consequat sed veroeros lorem et blandit  adipiscing feugiat phasellus tempus hendrerit, tortor vitae mattis tempor, sapien sem feugiat sapien, id suscipit magna felis nec elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos lorem ipsum dolor sit amet.</p>
										<footer>
											<ul class="actions">
												<li><a href="#" class="button icon fa-file-text">Continue Reading</a></li>
												<li><a href="#" class="button alt icon fa-comment">33 comments</a></li>
											</ul>
										</footer>
									</section>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
<?php $this->load->view('footer'); ?>