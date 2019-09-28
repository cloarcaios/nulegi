<?php
	$current1 = '';
	$current2 = '';
	$current3 = '';
	$current4 = '';
	$current5 = '';
	$current6 = '';
	$current7 = '';
	switch ($pagina) {
		case 'pagina1':
			$current1 = 'class="current"';
			break;
		case 'pagina2':
			$current2 = 'class="current"';
			break;
		case 'pagina3':
			$current3 = 'class="current"';
			break;
		case 'pagina4':
			$current4 = 'class="current"';
			break;
		case 'pagina5':
			$current5 = 'class="current"';
			break;
		case 'pagina6':
			$current6 = 'class="current"';
			break;
		default:
			# code...
			break;
	}
	if($id != ''){
		$li_perfil = '<li '.$current3.'><a href="'.$this->config->base_url().'index.php/inicio/perfil/#'.$id.'">Dashboard</a></li>';
		$li_cerrar = '<li '.$current5.'><a href="'.$this->config->base_url().'index.php/inicio/cerrar_sesion">Cerrar Sesión</a></li>';
	}
	else{
		$li_perfil = '<li '.$current3.'><a href="'.$this->config->base_url().'#div_inicio_sesion">Iniciar Sesion</a></li>';
		$li_cerrar = '';
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title> </title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="<?php echo $this->config->base_url(); ?>includes/js/jquery.min.js"></script>
		<script src="<?php echo $this->config->base_url(); ?>includes/js/jquery.dropotron.min.js"></script>
		<script src="<?php echo $this->config->base_url(); ?>includes/js/skel.min.js"></script>
		<script src="<?php echo $this->config->base_url(); ?>includes/js/skel-layers.min.js"></script>
		<script src="<?php echo $this->config->base_url(); ?>includes/js/init.js"></script>
		<script src="<?php echo $this->config->base_url(); ?>includes/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
		<script src="<?php echo $this->config->base_url(); ?>includes/js/fancybox/source/jquery.fancybox.pack.js"></script>
		<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>includes/css/style.css" />
		<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>includes/css/style-desktop.css" />
		<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>includes/js/jquery-ui-1.11.4.custom/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>includes/js/fancybox/source/jquery.fancybox.css">
		<script src="<?php echo $this->config->base_url(); ?>includes/js/funciones.js"></script>
		<noscript>
			<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>includes/css/skel.css" />
			<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>includes/css/style.css" />
			<link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>includes/css/style-desktop.css" />
		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body class="homepage">
		<!-- Header -->
		<div id="header-wrapper">
			<div id="header">
				<!-- Logo -->
				<h1><a href="index.html">NULEGI</a></h1>
				<!-- Nav -->
				<nav id="nav">
					<ul>
						<li <?php echo $current1;?>><a href="<?php echo $this->config->base_url(); ?>">Home</a></li>
						<li <?php echo $current2;?>>
							<a href="<?php echo $this->config->base_url(); ?>index.php/inicio/contratos">Contratos</a>
							<ul>
								<li><a href="<?php echo $this->config->base_url(); ?>index.php/inicio/contratos">Categorias</a></li>
								<li><a href="<?php echo $this->config->base_url(); ?>index.php/inicio/contrato_lista">Lista</a></li>
								<!--li><a href="#">Tipo de contrato 2</a></li>
								<li><a href="#">Tipo de contrato 3</a></li>
								<li>
									<a href="">Tipo de contrato 4</a>
									<ul>
										<li><a href="#">Tipo de contrato 4.1</a></li>
										<li><a href="#">Tipo de contrato 4.2</a></li>
										<li><a href="#">Tipo de contrato 4.3</a></li>
										<li><a href="#">Tipo de contrato 4.4</a></li>
										<li><a href="#">Tipo de contrato 4.5</a></li>
									</ul>
								</li>
								<li><a href="#">Tipo de contrato 5</a></li-->
							</ul>
						</li>
						<?php
							echo $li_perfil;
						?>
						<!--li <?php //echo $current4;?>><a href="<?php //echo $this->config->base_url(); ?>index.php/inicio/pre_registro">Registro</a></li-->
						<?php
							echo $li_cerrar;
						?>
					</ul>
				</nav>