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
				<article class="box post" style="height:1200px;">
					<a href="#" class="image featured"><img src="../../includes/images/pic01.jpg" alt="" /></a>
					<header>
						<h2>Contratos</h2>
						<p>Lista general de Contratos</p>
					</header>
					<p>
						<h3>Acuerdos</h3>
						<table>
							<th>Nombre</th>
							<th>Descripcion</th>
							<tr>
								<td><a href="contrato_pre1">Confidencialidad Absoluta</a></td>
								<td>Contrato de confidencialidad entre dos personas.</td>
							</tr>
							<tr>
								<td><a href="contrato_pre1">Confidencialidad Relativa</a></td>
								<td>Contrato de confidencialidad entre dos personas.</td>
							</tr>
						</table>
						<h3>Negocios</h3>
						<table>
							<th>Nombre</th>
							<th>Descripcion</th>
							<tr>
								<td><a href="contrato_pre1">Compra Venta</a></td>
								<td>Contrato de compra y venta de inmuebles</td>
							</tr>
							<tr>
								<td><a href="contrato_pre1">Donacion</a></td>
								<td>Contrato de donacion entre vivos</td>
							</tr>
						</table>
					</p>
				</article>
			</div>
		</div>
<?php $this->load->view('footer'); ?>