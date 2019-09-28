<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
		$this->load->model('model_inicio','',TRUE);
		$sesion = $this->model_inicio->SesionObtener();
		$this->load->view('inicio', $sesion);
	}

	public function login(){
		$this->load->model('model_inicio','',TRUE);
		$sesion = $this->model_inicio->SesionObtener();
		$this->load->view('login', $sesion);
	}

	public function registro(){
		$this->load->model('model_inicio','',TRUE);
		$paises = $this->model_inicio->PaisesObtener();
        $respuesta['paises'] = $paises;
        $respuesta['sesion']= $this->model_inicio->SesionObtener();
		$this->load->view('registro', $respuesta);
	}

	public function pre_registro(){
		$this->load->model('model_inicio','',TRUE);
		$sesion = $this->model_inicio->SesionObtener();
		$this->load->view('pre_registro', $sesion);
	}

	public function perfil2(){
		$this->load->model('model_inicio','',TRUE);
		$respuesta['sesion'] = $this->model_inicio->SesionObtener();
		if($respuesta['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
        $respuesta['perfil'] = $this->model_inicio->PerfilObtener();
        $respuesta['paises'] = $this->model_inicio->PaisesObtener();
        $respuesta['documentos'] = $this->model_inicio->DocumentosObtener($respuesta['sesion']['id']);
        $this->load->view('perfil', $respuesta);
	}

	public function contratos(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
		$datos['perfil'] = $this->model_inicio->PerfilObtener();
		$datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$datos['contratos_compartidos'] = $this->model_inicio->ContratosCompartidosObtener();
		if($datos['contratos_compartidos']['res'] != 1){
			$datos['contratos_compartidos']['contratos'] = array();
		}
		$datos['contratos_categoria'] = $this->model_inicio->ContratosCategoriaObtener();
		if($datos['contratos_categoria']['res'] != 1){
			$datos['contratos_categoria']['contratos'] = array();
		}
		$datos['categorias'] = $this->model_inicio->CategoriasObtener();
		if($datos['categorias']['res'] != 1){
			$datos['categorias']['categorias'] = array();
		}
		$this->load->library('layout');
        $this->layout->title('Contratos');
        $this->layout->contratos_generados($datos['contratos_generados']);
        $this->layout->contratos_compartidos($datos['contratos_compartidos']);
        $this->layout->setLayout('layout');
		$this->layout->view('diseno/contratos', $datos);
	}

	public function contratos_lista(){
		$this->load->model('model_inicio','',TRUE);
		$respuesta['sesion'] = $this->model_inicio->SesionObtener();
		if($respuesta['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
        $respuesta['perfil'] = $this->model_inicio->PerfilObtener();
        $respuesta['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
        $respuesta['contratos_invitados'] = $this->model_inicio->ContratosInvitadosObtener();
		$this->load->view('contratos_lista', $respuesta);
	}	

	public function contrato_pre(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
        $datos['perfil'] = $this->model_inicio->PerfilObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
		$datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$datos['contratos_compartidos'] = $this->model_inicio->ContratosCompartidosObtener();
		if($datos['contratos_compartidos']['res'] != 1){
			$datos['contratos_compartidos']['contratos'] = array();
		}
		$datos['contrato_disponible'] = $this->model_inicio->ContratoDisponibleObtener($_GET['c']);
		if($datos['contrato_disponible']['res'] != 1){
			$datos['contrato_disponible'] = array();
		}
		$this->load->library('layout');
        $this->layout->title('Contrato');
        $this->layout->setLayout('layout');
        $this->layout->contratos_generados($datos['contratos_generados']);
        $this->layout->contratos_compartidos($datos['contratos_compartidos']);
		$this->layout->view('diseno/contrato_pre', $datos);
	}

	public function contrato_gen(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
        $datos['perfil'] = $this->model_inicio->PerfilObtener();
        $datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$datos['contratos_compartidos'] = $this->model_inicio->ContratosCompartidosObtener();
		if($datos['contratos_compartidos']['res'] != 1){
			$datos['contratos_compartidos']['contratos'] = array();
		}
		$this->load->library('layout');
        $this->layout->setLayout('layout');
        $datos['contrato_disponible'] = $this->model_inicio->ContratoDisponibleObtener($_GET['c']);
		if($datos['contrato_disponible']['res'] != 1){
			$datos['contrato_disponible'] = array();
		}
		else{
			$this->layout->title($datos['contrato_disponible']['contrato_disponible']['nombre']);
			$this->layout->contratos_generados($datos['contratos_generados']);
			$this->layout->contratos_compartidos($datos['contratos_compartidos']);
			switch ($_GET['c']) {
	        	case '18':
	        		$datos['paises'] = $this->model_inicio->PaisesObtener();
	        		$datos['departamentos'] = $this->model_inicio->DepartamentosObtener('Guatemalteco');
	        		$datos['bancos'] = $this->model_inicio->BancosObtener();
	        		$this->layout->view('diseno/contrato_generar1', $datos);
	        		break;
	        	case '14':
	        		$datos['paises'] = $this->model_inicio->PaisesObtener();
	        		$datos['departamentos'] = $this->model_inicio->DepartamentosObtener('Guatemalteco');
	        		$datos['bancos'] = $this->model_inicio->BancosObtener();
	        		$this->layout->view('diseno/contrato_generar2', $datos);
	        		break;
	        	case '9':
	        		$datos['paises'] = $this->model_inicio->PaisesObtener();
	        		$datos['departamentos'] = $this->model_inicio->DepartamentosObtener('Guatemalteco');
	        		$datos['bancos'] = $this->model_inicio->BancosObtener();
	        		$this->layout->view('diseno/contrato_generar3', $datos);
	        		break;
	        	default:
	        		# code...
	        		break;
	        }
		}
	}

	public function archivos(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
        $datos['perfil'] = $this->model_inicio->PerfilObtener();
        $datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$datos['contratos_invitados'] = $this->model_inicio->ContratosInvitadosObtener();
		if($datos['contratos_invitados']['res'] != 1){
			$datos['contratos_invitados']['contratos'] = array();
		}
		$datos['documentos'] = $this->model_inicio->DocumentosObtener($datos['sesion']['id']);
        $this->load->library('layout');
        $this->layout->title('Mis Archivos');
        $this->layout->setLayout('layout');
		$this->layout->view('diseno/archivos', $datos);
	}

	public function notarios(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
        $datos['perfil'] = $this->model_inicio->PerfilObtener();
        $datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$datos['contratos_invitados'] = $this->model_inicio->ContratosInvitadosObtener();
		if($datos['contratos_invitados']['res'] != 1){
			$datos['contratos_invitados']['contratos'] = array();
		}
		$datos['documentos'] = $this->model_inicio->DocumentosObtener($datos['sesion']['id']);
		$datos['notarios'] = $this->model_inicio->AbogadosObtener();
        $this->load->library('layout');
        $this->layout->title('Notarios');
        $this->layout->setLayout('layout');
		$this->layout->view('diseno/notarios', $datos);
	}

	public function notario(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
        $datos['perfil'] = $this->model_inicio->PerfilObtener();
        $datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$datos['contratos_invitados'] = $this->model_inicio->ContratosInvitadosObtener();
		if($datos['contratos_invitados']['res'] != 1){
			$datos['contratos_invitados']['contratos'] = array();
		}
		$datos['documentos'] = $this->model_inicio->DocumentosObtener($datos['sesion']['id']);
		$datos['notario'] = $this->model_inicio->AbogadoObtener($_GET['n']);
        $this->load->library('layout');
        $this->layout->title('Notario');
        $this->layout->setLayout('layout');
		$this->layout->view('diseno/notario', $datos);
	}

	public function noticias(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
        $datos['perfil'] = $this->model_inicio->PerfilObtener();
        $datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$datos['contratos_invitados'] = $this->model_inicio->ContratosInvitadosObtener();
		if($datos['contratos_invitados']['res'] != 1){
			$datos['contratos_invitados']['contratos'] = array();
		}
		$datos['documentos'] = $this->model_inicio->DocumentosObtener($datos['sesion']['id']);
		$datos['noticias'] = $this->model_inicio->NoticiasObtener();
        $this->load->library('layout');
        $this->layout->title('Noticias');
        $this->layout->setLayout('layout');
		$this->layout->view('diseno/noticias', $datos);
	}

	public function noticia(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
        $datos['perfil'] = $this->model_inicio->PerfilObtener();
        $datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$datos['contratos_invitados'] = $this->model_inicio->ContratosInvitadosObtener();
		if($datos['contratos_invitados']['res'] != 1){
			$datos['contratos_invitados']['contratos'] = array();
		}
		$datos['documentos'] = $this->model_inicio->DocumentosObtener($datos['sesion']['id']);
		$datos['noticia'] = $this->model_inicio->NoticiaObtener($_GET['n']);
        $this->load->library('layout');
        $this->layout->title('Noticia');
        $this->layout->setLayout('layout');
		$this->layout->view('diseno/noticia', $datos);
	}

	public function ayuda(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
        $datos['perfil'] = $this->model_inicio->PerfilObtener();
        $datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$datos['contratos_invitados'] = $this->model_inicio->ContratosInvitadosObtener();
		if($datos['contratos_invitados']['res'] != 1){
			$datos['contratos_invitados']['contratos'] = array();
		}
		$datos['documentos'] = $this->model_inicio->DocumentosObtener($datos['sesion']['id']);
        $this->load->library('layout');
        $this->layout->title('Ayuda');
        $this->layout->setLayout('layout');
		$this->layout->view('diseno/ayuda', $datos);
	}

	public function perfil(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
        $datos['perfil'] = $this->model_inicio->PerfilObtener();
        $datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$datos['contratos_invitados'] = $this->model_inicio->ContratosInvitadosObtener();
		if($datos['contratos_invitados']['res'] != 1){
			$datos['contratos_invitados']['contratos'] = array();
		}
		$datos['documentos'] = $this->model_inicio->DocumentosObtener($datos['sesion']['id']);
        $this->load->library('layout');
        $this->layout->title('Perfil');
        $this->layout->setLayout('layout');
		$this->layout->view('diseno/perfil', $datos);
	}

	public function departamentos_obtener(){
		$this->load->model('model_inicio','',TRUE);
		$departamentos = $this->model_inicio->DepartamentosObtener($_POST['nacionalidad']);
		$html_departamentos = '';
		foreach ($departamentos as $key => $departamento) {
			$html_departamentos .= '<option value="'.$departamento['nombre'].'">'.$departamento['nombre'].'</option>';
		}
		echo json_encode($html_departamentos);
	}

	public function contrato_lista(){
		$this->load->model('model_inicio','',TRUE);
		$respuesta['sesion'] = $this->model_inicio->SesionObtener();
        $respuesta['perfil'] = $this->model_inicio->PerfilObtener();
        $this->load->view('contrato_lista', $respuesta);
	}

	public function cerrar_sesion(){
		$this->load->library('session');
		$this->load->model('model_inicio','',TRUE);
		$respuesta = $this->model_inicio->CerrarSesion();
		$this->session->unset_userdata('tipo_usuario');
		$this->session->unset_userdata('nombre');
		$this->session->unset_userdata('correo');
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('token');
		header('location:../../');	
	}

	public function usuario_modificar(){
    	$this->load->model('model_inicio','',TRUE);
    	$nombres = $this->model_inicio->_sanitizeVar(base64_decode($_POST['nombres']));
	    $apellidos = $this->model_inicio->_sanitizeVar(base64_decode($_POST['apellidos']));
		$direccion = $this->model_inicio->_sanitizeVar(base64_decode($_POST['direccion']));
		$telefono = $this->model_inicio->_sanitizeVar(base64_decode($_POST['telefono']));
		$nacimiento = $this->model_inicio->_sanitizeVar(base64_decode($_POST['nacimiento']));
		$dpi = $this->model_inicio->_sanitizeVar(base64_decode($_POST['dpi']));
		$licencia = $this->model_inicio->_sanitizeVar(base64_decode($_POST['licencia']));
		$oficio = $this->model_inicio->_sanitizeVar(base64_decode($_POST['oficio']));
		$genero = $this->model_inicio->_sanitizeVar(base64_decode($_POST['genero']));
		$pais = $this->model_inicio->_sanitizeVar(base64_decode($_POST['pais']));
		$correo = $this->model_inicio->_sanitizeVar(base64_decode($_POST['correo']));
		$clave = $this->model_inicio->_sanitizeVar(base64_decode($_POST['clave']));
		$id = $this->model_inicio->_sanitizeVar(base64_decode($_POST['id']));
		$respuesta = $this->model_inicio->UsuarioModificar($nombres, $apellidos, $direccion, $telefono, $nacimiento, $dpi, $licencia, $oficio, $genero, $pais, $correo, $clave, $id);
    	if($respuesta['res'] == 1){
	    	$asunto = 'NULEGI - Modificacion de Usuario';
	    	$mensaje = 'Saludos <strong>'.$nombres.'</strong>.
						</br>
						</br>
						<p>Se han modificado sus datos personales en el sitio de NULEGI.</p>
						<ul>
							<li>Fecha:  <strong>'.date('Y-m-d').'</strong></li>
							<li>Hora:  <strong>'.date('H:i:s').'</strong></li>
							<li>Usuario: <strong>'. $correo.'.</strong></li>
						</ul>
						</br>
						Para ver su perfil puede visitar el siguiente link: http://innerorbitstudios.com/carlos/nulegi/index.php/inicio/perfil
						</br>
						<p>Saludos cordiales.</p>
						</br>
						</br>
						NULEGI.';
	    	$enviar_correo = $this->model_inicio->EnviarCorreo($correo, $nombres, $asunto, $mensaje);
	    	if($enviar_correo == 1){
		    	echo json_encode($respuesta);
		    }
		    else{
		    	$respuesta['res'] = 0;
	    		echo json_encode($respuesta);
	    	}
	    }
	    else{
			echo json_encode($respuesta);
		}
    }

    public function pre_registro_usuario(){
    	$this->load->model('model_inicio','',TRUE);
		$correo = $this->model_inicio->_sanitizeVar(base64_decode($_POST['correo']));
		$clave = $this->model_inicio->_sanitizeVar(base64_decode($_POST['clave']));
		$respuesta = $this->model_inicio->PreRegistroUsuario($correo, $clave);
		$nombres = 'Usuario';
    	if($respuesta['res'] == 1){
	    	$asunto = 'NULEGI - Registro de Usuario';
	    	$mensaje = 'Saludos <strong>'.$nombres.'</strong>.
						</br>
						</br>
						<p>Gracias por registrarse como Usuario en el sitio de NULEGI.</p>
						<p>Ahora puede crear y administrar sus contratos y otros servicios.</p>
						<ul>
							<li>Fecha:  <strong>'.date('Y-m-d').'</strong></li>
							<li>Hora:  <strong>'.date('H:i:s').'</strong></li>
							<li>Usuario: <strong>'. $correo.'.</strong></li>
						</ul>
						</br>
						Para ver su perfil puede visitar el siguiente link: http://innerorbitstudios.com/carlos/nulegi/index.php/inicio/perfil
						</br>
						<p>Saludos cordiales.</p>
						</br>
						</br>
						NULEGI.';
	    	$enviar_correo = $this->model_inicio->EnviarCorreo($correo, $nombres, $asunto, $mensaje);
	    	if($enviar_correo == 1){
		    	echo json_encode($respuesta);
		    }
		    else{
		    	$respuesta['res'] = 0;
	    		echo json_encode($respuesta);
	    	}
	    }
	    else{
			echo json_encode($respuesta);
		}
    }

    public function iniciar_sesion(){
		$this->load->model('model_inicio','',TRUE);
		$correo = $this->model_inicio->_sanitizeVar(base64_decode($_POST['correo']));
		$clave = $this->model_inicio->_sanitizeVar(base64_decode($_POST['clave']));
		$tipo_usuario = $this->model_inicio->_sanitizeVar(base64_decode($_POST['tipo_usuario']));
        $respuesta = $this->model_inicio->IniciarSesion($correo, $clave, $tipo_usuario);
        $this->load->library('session');
        switch (intval($respuesta['res'])){
        	case 1:
				$sesion = array('tipo_usuario' => $respuesta['tipo_usuario'],
								'nombres' => $respuesta['nombres'],
								'apellidos'  => $respuesta['apellidos'],
								'direccion'  => $respuesta['direccion'],
								'telefono'  => $respuesta['telefono'],
								'nacimiento'  => $respuesta['nacimiento'],
								'dpi'  => $respuesta['dpi'],
								'licencia'  => $respuesta['licencia'],
								'oficio'  => $respuesta['oficio'],
								'correo'  => $respuesta['correo'],
								'id' => $respuesta['id'],
				                'token'     => $respuesta['token']
				               );
				$this->session->set_userdata($sesion);
        		break;
        	case 2:
        		$respuesta['res'] = 2;
        		break;
        	default:
        		$respuesta['res'] = 0;		
        		break;
        }
        echo json_encode($respuesta);
	}

	public function contrato_guardar(){
		$this->load->model('model_inicio','',TRUE);
		$nombre_revelador = $this->model_inicio->_sanitizeVar(base64_decode($_POST['nombre']));
		$edad_revelador = $this->model_inicio->_sanitizeVar(base64_decode($_POST['edad']));
		$nacionalidad_revelador = $this->model_inicio->_sanitizeVar(base64_decode($_POST['nacionalidad']));
		$civil_revelador = $this->model_inicio->_sanitizeVar(base64_decode($_POST['civil']));
		$dpi_revelador = $this->model_inicio->_sanitizeVar(base64_decode($_POST['dpi']));
		$dpi_letras_revelador = $this->model_inicio->_sanitizeVar(base64_decode($_POST['dpi_letras']));
		$nombre_recibidor = $this->model_inicio->_sanitizeVar(base64_decode($_POST['nombre_recibidor']));
		$edad_recibidor = $this->model_inicio->_sanitizeVar(base64_decode($_POST['edad_recibidor']));
		$nacionalidad_recibidor = $this->model_inicio->_sanitizeVar(base64_decode($_POST['nacionalidad_recibidor']));
		$civil_recibidor = $this->model_inicio->_sanitizeVar(base64_decode($_POST['civil_recibidor']));
		$dpi_recibidor = $this->model_inicio->_sanitizeVar(base64_decode($_POST['dpi_recibidor']));
		$dpi_letras_recibidor = $this->model_inicio->_sanitizeVar(base64_decode($_POST['dpi_letras_recibidor']));
		$motivo_firma = $this->model_inicio->_sanitizeVar(base64_decode($_POST['motivo_firma']));
		$contrato_nombre = $this->model_inicio->_sanitizeVar(base64_decode($_POST['contrato_nombre']));
		$contrato_descripcion = $this->model_inicio->_sanitizeVar(base64_decode($_POST['contrato_descripcion']));
		$contrato_tipo = $this->model_inicio->_sanitizeVar(base64_decode($_POST['tipo_contrato']));
		$respuesta = $this->model_inicio->ContratoGuardar($nombre_revelador, $edad_revelador, $nacionalidad_revelador, $civil_revelador, $dpi_revelador, $dpi_letras_revelador, $nombre_recibidor, $edad_recibidor, $nacionalidad_recibidor, $civil_recibidor, $dpi_recibidor, $dpi_letras_recibidor, $motivo_firma, $contrato_nombre, $contrato_descripcion, $contrato_tipo);
		if($respuesta['res'] == 1){
		    echo json_encode($respuesta);
	    }
	    else{
	    	$respuesta['res'] = 0;
    		echo json_encode($respuesta);
    	}
	}

	public function contrato_revisar(){
		$this->load->model('model_inicio','',TRUE);
		$nombre_revelador = $this->model_inicio->_sanitizeVar(base64_decode($_POST['nombre']));
		$edad_revelador = $this->model_inicio->_sanitizeVar(base64_decode($_POST['edad']));
		$nacionalidad_revelador = $this->model_inicio->_sanitizeVar(base64_decode($_POST['nacionalidad']));
		$civil_revelador = $this->model_inicio->_sanitizeVar(base64_decode($_POST['civil']));
		$dpi_revelador = $this->model_inicio->_sanitizeVar(base64_decode($_POST['dpi']));
		$dpi_letras_revelador = $this->model_inicio->_sanitizeVar(base64_decode($_POST['dpi_letras']));
		$nombre_recibidor = $this->model_inicio->_sanitizeVar(base64_decode($_POST['nombre_recibidor']));
		$edad_recibidor = $this->model_inicio->_sanitizeVar(base64_decode($_POST['edad_recibidor']));
		$nacionalidad_recibidor = $this->model_inicio->_sanitizeVar(base64_decode($_POST['nacionalidad_recibidor']));
		$civil_recibidor = $this->model_inicio->_sanitizeVar(base64_decode($_POST['civil_recibidor']));
		$dpi_recibidor = $this->model_inicio->_sanitizeVar(base64_decode($_POST['dpi_recibidor']));
		$dpi_letras_recibidor = $this->model_inicio->_sanitizeVar(base64_decode($_POST['dpi_letras_recibidor']));
		$motivo_firma = $this->model_inicio->_sanitizeVar(base64_decode($_POST['motivo_firma']));
		$contrato_nombre = $this->model_inicio->_sanitizeVar(base64_decode($_POST['contrato_nombre']));
		$contrato_descripcion = $this->model_inicio->_sanitizeVar(base64_decode($_POST['contrato_descripcion']));
		$contrato_tipo = $this->model_inicio->_sanitizeVar(base64_decode($_POST['tipo_contrato']));
		$respuesta = $this->model_inicio->ContratoRevisar($nombre_revelador, $edad_revelador, $nacionalidad_revelador, $civil_revelador, $dpi_revelador, $dpi_letras_revelador, $nombre_recibidor, $edad_recibidor, $nacionalidad_recibidor, $civil_recibidor, $dpi_recibidor, $dpi_letras_recibidor, $motivo_firma, $contrato_nombre, $contrato_descripcion, $contrato_tipo);
		if($respuesta['res'] == 1){
		    	echo json_encode($respuesta);
	    }
	    else{
	    	$respuesta['res'] = 0;
    		echo json_encode($respuesta);
    	}
	}

	public function documento_subir(){
    	$this->load->model('model_inicio','',TRUE);
    	$nombrearchivo = $_FILES['fil_archivo_1']['name'];
		$archivo = $_FILES['fil_archivo_1']['tmp_name'];
		$tipo_archivo = $_FILES['fil_archivo_1']['type'];
		/*
		if (!(strpos($tipo_archivo, "pdf") || strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpg") )) {
			header('location: ../inicio/perfil?e=0');
		}*/
		$usuario_id = $this->model_inicio->_sanitizeVar($_POST['usuario_id']);
		$carpeta = $this->model_inicio->_sanitizeVar(base64_decode($_POST['carpeta']));
		$ruta = 'includes/filesmanager/files/'.$carpeta;
		$documento_existe = $this->model_inicio->DocumentoVerificar($usuario_id, $nombrearchivo, $ruta);
		if($documento_existe['res'] == 0){
			$copy = copy($archivo,'includes/filesmanager/files/'.$carpeta.'/'.$nombrearchivo);
			$resultado = $this->model_inicio->DocumentoInsertar($usuario_id, $nombrearchivo, $ruta);
		   	if($resultado['res'] == 1){
		   		$respuesta['res'] = 1;
		   	}
		   	else{
		   		$respuesta['res'] = 0;
		   	}
		}
		else{
	   		$respuesta['res'] = 2;
		}
		echo json_encode($respuesta);
    }

    public function documento_dragdrop(){
    	$this->load->model('model_inicio','',TRUE);
    	$usuario_id = $this->model_inicio->_sanitizeVar($_POST['hdd_usuario_id']);
		$carpeta = $this->model_inicio->_sanitizeVar($_POST['hdd_carpeta']);
		$ruta = 'includes/filesmanager/files/'.$carpeta;
		$nombrearchivo = $_FILES['fil_archivo_1']['name'];
		$archivo = $_FILES['fil_archivo_1']['tmp_name'];
		$tipo_archivo = $_FILES['fil_archivo_1']['type'];
		$documento_existe = $this->model_inicio->DocumentoVerificar($usuario_id, $nombrearchivo, $ruta);
		if($documento_existe['res'] == 0){
			$copy = copy($archivo,'includes/filesmanager/files/'.$carpeta.'/'.$nombrearchivo);
			$resultado = $this->model_inicio->DocumentoInsertar($usuario_id, $nombrearchivo, $ruta);
		   	if($resultado['res'] == 1){
		   		$respuesta = 1;
		   	}
		   	else{
		   		$respuesta = 0;
		   	}
		}
		else{
	   		$respuesta = 2;
		}
		echo $respuesta;
    }

    public function contrato_ver(){
    	$this->load->model('model_inicio','',TRUE);
		$contrato_id = $this->model_inicio->_sanitizeVar($_GET['id']);
		$respuesta = $this->model_inicio->ContratoObtener($contrato_id);
		if($respuesta['res'] != 1){
			header('location: ../inicio/contratos_lista');
		}
		$respuesta['sesion'] = $this->model_inicio->SesionObtener();
		if($respuesta['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
        $respuesta['perfil'] = $this->model_inicio->PerfilObtener();
        $this->load->view('contrato_ver', $respuesta);
    }

    public function contrato_compartir(){
    	$this->load->model('model_inicio','',TRUE);
		$contrato_id = $this->model_inicio->_sanitizeVar($_POST['contrato_id']);
		$sesion = $this->model_inicio->SesionObtener();
		$nombres = $sesion['nombres'];
		if($nombres == '0'){
            $nombres = $sesion['correo'];
        }
		$correo_invitado = $this->model_inicio->_sanitizeVar(base64_decode($_POST['correo_invitado']));
		$respuesta = $this->model_inicio->ContratoCompartir($contrato_id, $correo_invitado);
		if($respuesta['res'] == 1){
			$contrato = $this->model_inicio->ContratoObtener($contrato_id);
			$asunto = 'NULEGI - Invitacion a Contrato';
	    	$mensaje = 'Saludos <strong>'.$respuesta['nombres'].'</strong>.
						</br>
						</br>
						<p>Ha sido invitado por '.$nombres.' a participar en un contrato:</p>
						<ul>
							<li>Nombre del contrato:  <strong>'.$contrato['contrato']['nombre'].'</strong></li>
							<li>Descripcion del contrato:  <strong>'.$contrato['contrato']['descripcion'].'</strong></li>
							<li>Invitado por: <strong>'. $nombres.' ('.$sesion['correo'].').</strong></li>
							<li>Fecha:  <strong>'.date('Y-m-d').'</strong></li>
							<li>Hora:  <strong>'.date('H:i:s').'</strong></li>
						</ul>
						</br>
						Para ver los detalles del contrato puede consultar su perfil en el siguiente link: http://innerorbitstudios.com/carlos/nulegi/index.php/inicio/perfil
						</br>
						<p>Saludos cordiales.</p>
						</br>
						</br>
						NULEGI.';
	    	$enviar_correo = $this->model_inicio->EnviarCorreo($correo_invitado, $respuesta['nombres'], $asunto, $mensaje);
	    	$asunto = 'NULEGI - Invitacion a Contrato';
	    	$mensaje = 'Saludos <strong>'.$nombres.'</strong>.
						</br>
						</br>
						<p>Ha invitado a '.$respuesta['nombres'].' a participar en un contrato:</p>
						<ul>
							<li>Nombre del contrato:  <strong>'.$contrato['contrato']['nombre'].'</strong></li>
							<li>Descripcion del contrato:  <strong>'.$contrato['contrato']['descripcion'].'</strong></li>
							<li>Nombre del invitado: <strong>'. $respuesta['nombres'].'.</strong></li>
							<li>Correo del invitado: <strong>'. $correo_invitado.'.</strong></li>
							<li>Fecha:  <strong>'.date('Y-m-d').'</strong></li>
							<li>Hora:  <strong>'.date('H:i:s').'</strong></li>
						</ul>
						</br>
						Para ver los detalles del contrato puede consultar su perfil en el siguiente link: http://innerorbitstudios.com/carlos/nulegi/index.php/inicio/perfil
						</br>
						<p>Saludos cordiales.</p>
						</br>
						</br>
						NULEGI.';
	    	$enviar_correo = $this->model_inicio->EnviarCorreo($sesion['correo'], $nombres, $asunto, $mensaje);
	    	if($enviar_correo == 1){
	    		$respuesta['res'] = 1;
	    		$respuesta['invitado_nombre'] = $respuesta['nombres'];
		    }
		    else{
		    	$respuesta['res'] = 4;
	    	}
		}
		elseif($respuesta['res'] == 5){
			$contrato = $this->model_inicio->ContratoObtener($contrato_id);
			$asunto = 'NULEGI - Invitacion a Contrato';
	    	$mensaje = 'Saludos <strong>'.$respuesta['nombres'].'</strong>.
						</br>
						</br>
						<p>Ha sido invitado por '.$nombres.' a participar en un contrato:</p>
						<ul>
							<li>Nombre del contrato:  <strong>'.$contrato['contrato']['nombre'].'</strong></li>
							<li>Descripcion del contrato:  <strong>'.$contrato['contrato']['descripcion'].'</strong></li>
							<li>Invitado por: <strong>'. $nombres.' ('.$sesion['correo'].').</strong></li>
							<li>Fecha:  <strong>'.date('Y-m-d').'</strong></li>
							<li>Hora:  <strong>'.date('H:i:s').'</strong></li>
						</ul>
						</br>
						<p>
						Su contraseña temporal es: <strong>'.$respuesta['clave_aleatoria'].'</strong>
						</br>
						Utilicela para ingresar y cambiar sus datos personales.
						</p>
						Para registrarse y poder ver los detalles del contrato puede consultar su perfil en el siguiente link: http://innerorbitstudios.com/carlos/nulegi/index.php/inicio/perfil
						</br>
						<p>Saludos cordiales.</p>
						</br>
						</br>
						NULEGI.';
	    	$enviar_correo = $this->model_inicio->EnviarCorreo($correo_invitado, $respuesta['nombres'], $asunto, $mensaje);
	    	$asunto = 'NULEGI - Invitacion a Contrato';
	    	$mensaje = 'Saludos <strong>'.$nombres.'</strong>.
						</br>
						</br>
						<p>Ha invitado a '.$respuesta['nombres'].' a participar en un contrato:</p>
						<ul>
							<li>Nombre del contrato:  <strong>'.$contrato['contrato']['nombre'].'</strong></li>
							<li>Descripcion del contrato:  <strong>'.$contrato['contrato']['descripcion'].'</strong></li>
							<li>Nombre del invitado: <strong>'. $respuesta['nombres'].'.</strong></li>
							<li>Correo del invitado: <strong>'. $correo_invitado.'.</strong></li>
							<li>Fecha:  <strong>'.date('Y-m-d').'</strong></li>
							<li>Hora:  <strong>'.date('H:i:s').'</strong></li>
						</ul>
						</br>
						Para ver los detalles del contrato puede consultar su perfil en el siguiente link: http://innerorbitstudios.com/carlos/nulegi/index.php/inicio/perfil
						</br>
						<p>Saludos cordiales.</p>
						</br>
						</br>
						NULEGI.';
	    	$enviar_correo = $this->model_inicio->EnviarCorreo($sesion['correo'], $nombres, $asunto, $mensaje);
	    	if($enviar_correo == 1){
	    		$respuesta['res'] = 1;
	    		$respuesta['invitado_nombre'] = $respuesta['nombres'];
		    }
		    else{
		    	$respuesta['res'] = 4;
	    	}
		}
		echo json_encode($respuesta);
    }

    function directorios_obtener(){
    	$dir = $_POST['dir'];
    	// Run the recursive function 
    	$response = scan($dir);
    	// Output the directory listing as JSON
    	header('Content-type: application/json');
    	echo json_encode(array(
    		"name" => "files",
    		"type" => "folder",
    		"path" => $dir,
    		"items" => $response
    	));
    }

    // This function scans the files folder recursively, and builds a large array
    function scan($dir){
		$files = array();
		// Is there actually such a folder/file?
		if(file_exists($dir)){
			foreach(scandir($dir) as $f) {
				if(!$f || $f[0] == '.') {
					continue; // Ignore hidden files
				}
				if(is_dir($dir . '/' . $f)) {
					// The path is a folder
					$files[] = array(
						"name" => $f,
						"type" => "folder",
						"path" => $dir . '/' . $f,
						"items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
					);
				}
				else {
					// It is a file
					$files[] = array(
						"name" => $f,
						"type" => "file",
						"path" => $dir . '/' . $f,
						"size" => filesize($dir . '/' . $f) // Gets the size of this file
					);
				}
			}
		}
		return $files;
	}

	function carpeta_crear(){
		$respuesta = array();
		$carpeta_nombre = $_POST['carpeta_nombre'];
		$usuario_id = $_POST['usuario_id'];
		$ruta_actual = $_POST['ruta_actual'];
		$ruta_actual_array = explode("/", $ruta_actual);
		if($usuario_id == $ruta_actual_array[0]){
			mkdir('includes/filesmanager/files/'.$ruta_actual.'/'.$carpeta_nombre, 0775, TRUE);
            chmod('includes/filesmanager/files/'.$ruta_actual.'/'.$carpeta_nombre, 0775);
            $respuesta['res'] = 1;
		}
		else{
			$respuesta['res'] = 0;
		}
		echo json_encode($respuesta);
	}

	function carpeta_borrar(){
		$respuesta = array();
		$usuario_id = $_POST['usuario_id'];
		$ruta_actual = $_POST['ruta_actual'];
		$ruta_actual_array = explode("/", $ruta_actual);
		if($usuario_id == $ruta_actual_array[0]){
			$carpeta_borrar = $this->deleteDir('includes/filesmanager/files/'.$ruta_actual);
			if($carpeta_borrar){
				$respuesta['res'] = 1;
			}
			else{
				$respuesta['res'] = 2;
			}            
		}
		else{
			$respuesta['res'] = 0;
		}
		echo json_encode($respuesta);
	}

	function deleteDir($dirPath){
		if (!is_dir($dirPath)) {
		    if (file_exists($dirPath) !== false) {
		        unlink($dirPath);
		    }
		    return false;
		}

		if ($dirPath[strlen($dirPath) - 1] != '/') {
		    $dirPath .= '/';
		}

		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
		    if (is_dir($file)) {
		        $this->deleteDir($file);
		    } else {
		        unlink($file);
		    }
		}
		rmdir($dirPath);
		return true;
	}

	public function ReestablecerClave(){
		$respuesta = array();
		$this->load->model('model_inicio','',TRUE);
		$correo = $this->model_inicio->_sanitizeVar(base64_decode($_POST['correo']));
		$correo_existe = $this->model_inicio->CorreoExiste($correo);
		if($correo_existe['res'] == 1){
			$token = $this->model_inicio->hashPass(microtime());
    		$asunto = 'NULEGI - Reestablecer Clave.';
    		$mensaje = 'Saludos <strong>'.$correo.'.</strong>
						</br>
						</br>
						<p>Se ha solicitado el reestablecimiento de su contraseña en el sitio de Nulegi. </p> 
						<ul>
							<li>Fecha:  <strong>'.date('Y-m-d').'</strong></li>
							<li>Hora:  <strong>'.date('H:i:s').'</strong></li>
							<li>correo:  <strong>'.$correo.'</strong></li>
						</ul>
						</br>
						Para reestablecer su contraseña, haga clic en el siguiente enlace, o copielo y peguelo en su navegador.
						<br>
						<br>
						http://innerorbitstudios.com/carlos/nulegi?c='.base64_encode($correo).'&h='.$token.'
						</br>
						<p>Si no ha realizado esa solicitud, puede obviar este mensaje.
						</p>
						Saludos cordiales.
						</br>
						</br>
						Nulegi.';
    		$enviar_correo = $this->model_inicio->EnviarCorreo($correo, $correo, $asunto, $mensaje);
    		if($enviar_correo == 1){
    			$resultado = $this->model_inicio->ReestablecerToken($correo, $token);
    			if($resultado == true){
    				$respuesta['res'] = 1;
    			}
    			else{
    				$respuesta['res'] = 0;
    			}
		    }
		    else{
		    	$respuesta['res'] = 0;
	    	}
		}
		else{
			$respuesta['res'] = 2;
		}
		echo json_encode($respuesta);
    }
    
    public function ReestablecerClaveConfirmar(){
    	$this->load->model('model_inicio','',TRUE);
    	$correo = $this->model_inicio->_sanitizeVar(base64_decode($_POST['correo']));
		$hash = $this->model_inicio->_sanitizeVar($_POST['hash']);
   		$reestablecer = $this->model_inicio->ReestablecerVerificar($correo, $hash);
		if($reestablecer != null){
			$fecha_actual = strtotime(date('Y-m-d H:i:s'));
			$fecha_de_reestablecimiento = strtotime($reestablecer[0]['ultima_sesion']);
			$diferencia = intval($fecha_actual) - intval($fecha_de_reestablecimiento);
			//1 semana = 604800 segundos
			if($diferencia >= 604800){
				$respuesta['res'] = 2;
			}
			elseif($hash == $reestablecer[0]['token_reestablecer']){
				$clave = $this->model_inicio->_sanitizeVar(base64_decode($_POST['clave']));
				$restablecer = $this->model_inicio->ReestablecerConfirmar($correo, $hash, $clave);
				if($restablecer == true){
					$asunto = 'NULEGI - Cambio de Clave';
			    	$mensaje = 'Saludos <strong>'.$correo.'</strong>.
								</br>
								</br>
								<p>Su contraseña en el sitio de NULEGI ha sido cambiada exitosamente.</p>
								<ul>
									<li>Fecha:  <strong>'.date('Y-m-d').'</strong></li>
									<li>Hora:  <strong>'.date('H:i:s').'</strong></li>
									<li>Correo:  <strong>'.$correo.'</strong></li>
								</ul>
								</br>
								</br>
								<p>Saludos cordiales.</p>
								</br>
								</br>
								NULEGI.';
			    	$enviar_correo = $this->model_inicio->EnviarCorreo($correo, $correo, $asunto, $mensaje);
			    	if($enviar_correo == 1){
				    	$respuesta['res'] = 1;
				    }
				    else{
				    	$respuesta['res'] = 0;
			    	}
				}
				else{
					$respuesta['res'] = 0;
				}
			}
			else{
				$respuesta['res'] = 3;
			}
		}
		else{
			$respuesta['res'] = 4;
		}
		echo json_encode($respuesta);
    }

	function reestablecer(){
		$respuesta =  array();
		$this->load->model('model_inicio','',TRUE);
		$correo = $this->model_inicio->_sanitizeVar(base64_decode($_POST['correo']));
		$correo_existe = $this->model_inicio->RecuperarCorreo($correo);
		if($correo_existe['res'] == 1){
			$asunto = 'NULEGI - Recuperar Contraseña';
	    	$mensaje = 'Saludos <strong>'.$correo.'</strong>.
						</br>
						</br>
						<p>Se ha solicitado recuperar su contrasña:</p>
						<ul>
							<li>Correo: <strong>'.$correo.'</strong></li>
							<li>Contraseña: <strong>'.$correo_existe['recuperar']['clave'].'</strong></li>
							<li>Fecha:  <strong>'.date('Y-m-d').'</strong></li>
							<li>Hora:  <strong>'.date('H:i:s').'</strong></li>
						</ul>
						</br>
						<p>Saludos cordiales.</p>
						</br>
						</br>
						NULEGI.';
	    	$enviar_correo = $this->model_inicio->EnviarCorreo($correo, $correo, $asunto, $mensaje);
	    	if($enviar_correo == true){
	    		$respuesta['res'] = 1;
	    	}
	    	else{
	    		$respuesta['res'] = 0;
	    	}
		}
		else{
			$respuesta['res'] = 2;			
		}
		echo json_encode($respuesta);
	}

	public function archivos_borrar(){
		$respuesta = array();
		$this->load->model('model_inicio','',TRUE);
		$usuario_id = $this->model_inicio->_sanitizeVar($_POST['usuario_id']);
		$carpeta = $this->model_inicio->_sanitizeVar($_POST['carpeta']);
		if($usuario_id == $carpeta){
			foreach ($_POST['seleccionados_todos'] as $key => $value) {
				$dir = 'includes/filesmanager/files/'.$value;
				$this->ContenidoBorrar($usuario_id, $dir);
			}
		}
		$respuesta['res']= 1;
		echo json_encode($respuesta);	
	}

	public function ContenidoBorrar($usuario_id, $dir){
		$this->load->model('model_inicio','',TRUE);
		if(is_dir($dir)) { 
	    	$objects = scandir($dir); 
	    	foreach ($objects as $object) { 
	       		if ($object != "." && $object != "..") { 
	         		if (is_dir($dir."/".$object)){
	           			$this->ContenidoBorrar($dir."/".$object);
	         		}
	         		else{
	           			unlink($dir."/".$object);
	           			$this->model_inicio->DocumentoBorrar($usuario_id, $dir."/".$object);
	         		}
	       		} 
	     	}
	     	rmdir($dir); 
	   	}
	   	else{
	   		unlink($dir);
	   		$this->model_inicio->DocumentoBorrar($usuario_id, $dir);
	   	}
	}

	public function archivos_mover(){
		$respuesta = array();
		$this->load->model('model_inicio','',TRUE);
		$usuario_id = $this->model_inicio->_sanitizeVar($_POST['usuario_id']);
		$carpeta_nueva = $this->model_inicio->_sanitizeVar($_POST['carpeta_nueva']);
		foreach ($_POST['seleccionados_mover'] as $key => $value) {
			$archivo_nombre = end(explode('/', $value));
			$ruta_anterior = 'includes/filesmanager/files/'.$value;
			$ruta_nueva    = 'includes/filesmanager/files/'.$carpeta_nueva.'/'.$archivo_nombre;
			$mover = rename($ruta_anterior, $ruta_nueva);
			if(is_file($ruta_nueva)){
				$this->model_inicio->ContenidoMover($usuario_id, 'includes/filesmanager/files/'.$carpeta_nueva, $archivo_nombre);
			}
		}
		$respuesta['res']= 1;
		echo json_encode($respuesta);	
	}

	public function categoria_buscar(){
		$respuesta = array();
		$this->load->model('model_inicio','',TRUE);
		$contrato_tipo = $this->model_inicio->_sanitizeVar($_POST['contrato_tipo']);
		$resultado_busqueda = $this->model_inicio->ContratoBuscar($contrato_tipo);
		if($resultado_busqueda['res'] == 1){
			$html_contratos_categoria = '';
            $i = 0;
            $categoria_actual = '';
            $categoria_anterior = '';
            $primera_vez = true;
            foreach ($resultado_busqueda['contrato_busqueda'] as $key => $value) {
            	$categoria_anterior = $categoria_actual;
            	$categoria_actual = $value['categoria_nombre'];
            	if($categoria_actual != $categoria_anterior){
            		if($primera_vez == true){
            			$i = 0;
            			$primera_vez = false;
            		}
            		else{
            			$i = 0;
            			$html_contratos_categoria .= '</div>';
            		}            		
            	}
            	if($i == 0){
            		$html_contratos_categoria .= '
												<div class="col-lg-12 col-md-12 col-sm-12 nonePadding" style="margin: 15px 0 0;">
													<div class="row-flex">
														<img width="30px" src="'.$this->config->base_url() .'includes'.$value['icono'].'">
														<h3>'.$value['categoria_nombre'].'</h3>
														<hr class="lineTitle"></hr>
													</div>
												</div>

												<div class="marginLarge sliderContract">';
            	}
                $html_contratos_categoria .= '		<div class="contractPreview">
														<a href="contrato_pre?c='.$value['contrato_id'].'">
															<div class="preview">
																<img class="mCS_img_loaded" src="'.$this->config->base_url().'includes/diseno/'.$value['contrato_imagen'].'">
															</div>
															<div class="contentDoc">
																<h4>'.$value['contrato_nombre'].'</h4>
																'.$value['contrato_descripcion'].'
															</div>
														</a>
													</div>';
				$i++;
            }
            $respuesta['res'] = 1;
            $respuesta['resultado_busqueda'] = $html_contratos_categoria.'</div>';
		}
		else{
			$respuesta['res'] = 0;
		}
		echo json_encode($respuesta);
	}

	function contrato_guardar2(){
		$respuesta = array();
		$this->load->model('model_inicio','',TRUE);
		$contrato = $this->model_inicio->_sanitizeVar($_POST['contrato']);
		$contrato_id = $this->model_inicio->_sanitizeVar($_POST['contrato_id']);
		$nombre = $this->model_inicio->_sanitizeVar($_POST['nombre']);
		$contrato_guardar = $this->model_inicio->ContratoGuardar2($contrato, $contrato_id, $nombre);
		echo json_encode($contrato_guardar);
	}

	public function contrato_editar(){
		$this->load->model('model_inicio','',TRUE);
		$respuesta['sesion'] = $this->model_inicio->SesionObtener();
		if($respuesta['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
		$datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$contrato_generado_id = $_GET['c'];
		$contrato = $this->model_inicio->ContratoGeneradoObtener($contrato_generado_id);
		if($contrato['res'] == 1){
			$datos['contrato'] = $contrato['contrato'];
		}
		else{
			$datos['contrato'] = array();
		}
		$datos['contratos_compartidos'] = $this->model_inicio->ContratosCompartidosObtener();
		if($datos['contratos_compartidos']['res'] != 1){
			$datos['contratos_compartidos']['contratos'] = array();
		}
		$datos['perfil'] = $this->model_inicio->PerfilObtener();
		$this->load->library('layout');
		$this->layout->contratos_generados($datos['contratos_generados']);
		$this->layout->contratos_compartidos($datos['contratos_compartidos']);
        $this->layout->title('Contrato Editar');
        $this->layout->setLayout('layout');
		$this->layout->view('diseno/contrato_editar', $datos);
	}

	public function ContratoNombreVerificar(){
		$respuesta = array();
		$this->load->model('model_inicio','',TRUE);
		$contrato_nombre = $this->model_inicio->_sanitizeVar($_POST['contrato_nombre']);
		$contrato_nombre_verificar = $this->model_inicio->ContratoNombreVerificar($contrato_nombre);
		echo json_encode($contrato_nombre_verificar);
	}

	public function contratos_versiones(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
		$datos['perfil'] = $this->model_inicio->PerfilObtener();
		$datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$contratos_versiones = $this->model_inicio->ContratosVersiones($_GET['c']);
		if($contratos_versiones['res'] != 1){
			$datos['contratos_versiones'] = array();
			$datos['contrato_nombre'] = array('nombre'=>'');
		}
		else{
			$datos['contratos_versiones'] = $contratos_versiones['contratos'];
			$datos['contrato_nombre'] = $contratos_versiones['contrato_nombre'];
		}
		$datos['contratos_compartidos'] = $this->model_inicio->ContratosCompartidosObtener();
		if($datos['contratos_compartidos']['res'] != 1){
			$datos['contratos_compartidos']['contratos'] = array();
		}
		$datos['contratos_categoria'] = $this->model_inicio->ContratosCategoriaObtener();
		if($datos['contratos_categoria']['res'] != 1){
			$datos['contratos_categoria']['contratos'] = array();
		}
		$datos['categorias'] = $this->model_inicio->CategoriasObtener();
		if($datos['categorias']['res'] != 1){
			$datos['categorias']['categorias'] = array();
		}
		$this->load->library('layout');
        $this->layout->title('Contratos');
        $this->layout->contratos_generados($datos['contratos_generados']);
        $this->layout->contratos_compartidos($datos['contratos_compartidos']);
        $this->layout->setLayout('layout');
		$this->layout->view('diseno/contratos_versiones', $datos);
	}

	public function contrato_compartir2(){
    	$this->load->model('model_inicio','',TRUE);
		$contrato_generado_id = $this->model_inicio->_sanitizeVar($_POST['contrato_generado_id']);
		$sesion = $this->model_inicio->SesionObtener();
		$nombres = $sesion['nombres'];
		if($nombres == '0'){
            $nombres = $sesion['correo'];
        }
		$correo_invitado = $this->model_inicio->_sanitizeVar($_POST['correo']);
		$contrato_compartir = $this->model_inicio->ContratoCompartir2($contrato_generado_id, $correo_invitado);
		if($contrato_compartir['res'] == 1 || $contrato_compartir['res'] == 2){
			if($contrato_compartir['res'] == 2){
				$clave_info = '<p>
									Su contraseña temporal es: <strong>'.$contrato_compartir['clave_aleatoria'].'</strong>
									</br>
									Utilicela para ingresar y cambiar sus datos personales.
								</p>';
			}
			else{
				$clave_info = '';
			}
			$contrato = $this->model_inicio->ContratoGeneradoObtener($contrato_generado_id);
			$asunto = 'NULEGI - Invitacion a Contrato';
	    	$mensaje = 'Saludos <strong>'.$contrato_compartir['nombres'].'</strong>.
						</br>
						</br>
						<p>Ha sido invitado por '.$nombres.' a participar en un contrato:</p>
						<ul>
							<li>Nombre del contrato:  <strong>'.$contrato['contrato']['nombre'].'</strong></li>
							<li>Invitado por: <strong>'. $nombres.' ('.$sesion['correo'].').</strong></li>
							<li>Fecha:  <strong>'.date('Y-m-d').'</strong></li>
							<li>Hora:  <strong>'.date('H:i:s').'</strong></li>
						</ul>
						</br>
						'.$clave_info.'
						Para ver los detalles del contrato puede consultar el siguiente link: http://innerorbitstudios.com/carlos/nulegi
						</br>
						<p>Saludos cordiales.</p>
						</br>
						</br>
						NULEGI.';
	    	$enviar_correo = $this->model_inicio->EnviarCorreo($correo_invitado, $contrato_compartir['nombres'], $asunto, $mensaje);
	    	$asunto = 'NULEGI - Invitacion a Contrato';
	    	$mensaje = 'Saludos <strong>'.$nombres.'</strong>.
						</br>
						</br>
						<p>Ha invitado a '.$contrato_compartir['nombres'].' a participar en un contrato:</p>
						<ul>
							<li>Nombre del contrato:  <strong>'.$contrato['contrato']['nombre'].'</strong></li>
							<li>Nombre del invitado: <strong>'. $contrato_compartir['nombres'].'.</strong></li>
							<li>Correo del invitado: <strong>'. $correo_invitado.'.</strong></li>
							<li>Fecha:  <strong>'.date('Y-m-d').'</strong></li>
							<li>Hora:  <strong>'.date('H:i:s').'</strong></li>
						</ul>
						</br>
						Para ver los detalles del contrato puede consultar el siguiente link: http://innerorbitstudios.com/carlos/nulegi
						</br>
						<p>Saludos cordiales.</p>
						</br>
						</br>
						NULEGI.';
	    	$enviar_correo = $this->model_inicio->EnviarCorreo($sesion['correo'], $nombres, $asunto, $mensaje);
	    	if($enviar_correo == 1){
	    		$respuesta['res'] = 1;
	    		$respuesta['invitado_nombre'] = $contrato_compartir['nombres'];
		    }
		    else{
		    	$respuesta['res'] = 0;
	    	}
		}
		else{
	    	$respuesta['res'] = 2;
    	}
		echo json_encode($respuesta);
    }

    public function usuario_existe_verificar(){
    	$this->load->model('model_inicio','',TRUE);
    	$correo_invitado = $this->model_inicio->_sanitizeVar($_POST['correo']);
    	$correo_existe = $this->model_inicio->CorreoExiste($correo_invitado);
    	echo json_encode($correo_existe);
    }

    public function contratos_compartidos(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
		$datos['perfil'] = $this->model_inicio->PerfilObtener();
		$datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$datos['contratos_compartidos'] = $this->model_inicio->ContratosCompartidosObtener();
		if($datos['contratos_compartidos']['res'] != 1){
			$datos['contratos_compartidos']['contratos'] = array();
		}
		$datos['contratos_invitados'] = $this->model_inicio->ContratosInvitadosObtener();
		if($datos['contratos_invitados']['res'] != 1){
			$datos['contratos_invitados']['contratos'] = array();
		}
		$datos['contratos_categoria'] = $this->model_inicio->ContratosCategoriaObtener();
		if($datos['contratos_categoria']['res'] != 1){
			$datos['contratos_categoria']['contratos'] = array();
		}
		$datos['categorias'] = $this->model_inicio->CategoriasObtener();
		if($datos['categorias']['res'] != 1){
			$datos['categorias']['categorias'] = array();
		}
		$this->load->library('layout');
        $this->layout->title('Contratos');
        $this->layout->contratos_generados($datos['contratos_generados']);
        $this->layout->contratos_compartidos($datos['contratos_compartidos']);
        $this->layout->setLayout('layout');
		$this->layout->view('diseno/contratos_compartidos', $datos);
	}

	public function contrato_guardar_editado(){
		$respuesta = array();
		$this->load->model('model_inicio','',TRUE);
		$contrato = $this->model_inicio->_sanitizeVar($_POST['contrato']);
		$contrato_generado_id = $this->model_inicio->_sanitizeVar($_POST['contrato_generado_id']);
		$nombre = $this->model_inicio->_sanitizeVar($_POST['nombre']);
		$contrato_guardar = $this->model_inicio->ContratoGuardarEditado($contrato, $contrato_generado_id, $nombre);
		echo json_encode($contrato_guardar);
	}

	public function pregunta(){
		$this->load->model('model_inicio','',TRUE);
		$datos['sesion'] = $this->model_inicio->SesionObtener();
		if($datos['sesion']['id'] == false){
			header('Location: ../../');
			die;
		}
		$datos['perfil'] = $this->model_inicio->PerfilObtener();
		$datos['contratos_generados'] = $this->model_inicio->ContratosGeneradosObtener();
		if($datos['contratos_generados']['res'] != 1){
			$datos['contratos_generados']['contratos'] = array();
		}
		$datos['contratos_compartidos'] = $this->model_inicio->ContratosCompartidosObtener();
		if($datos['contratos_compartidos']['res'] != 1){
			$datos['contratos_compartidos']['contratos'] = array();
		}
		$datos['contratos_invitados'] = $this->model_inicio->ContratosInvitadosObtener();
		if($datos['contratos_invitados']['res'] != 1){
			$datos['contratos_invitados']['contratos'] = array();
		}
		$datos['contratos_categoria'] = $this->model_inicio->ContratosCategoriaObtener();
		if($datos['contratos_categoria']['res'] != 1){
			$datos['contratos_categoria']['contratos'] = array();
		}
		$datos['categorias'] = $this->model_inicio->CategoriasObtener();
		if($datos['categorias']['res'] != 1){
			$datos['categorias']['categorias'] = array();
		}
		$this->load->library('layout');
        $this->layout->title('Contratos');
        $this->layout->contratos_generados($datos['contratos_generados']);
        $this->layout->contratos_compartidos($datos['contratos_compartidos']);
        $this->layout->setLayout('layout');
		$this->layout->view('diseno/pregunta', $datos);
	}

	public function pregunta_guardar(){
		$this->load->model('model_inicio','',TRUE);
		$pregunta = $this->model_inicio->_sanitizeVar($_POST['pregunta']);
		$pregunta_guardar = $this->model_inicio->PreguntaGuardar($pregunta);
		if($pregunta_guardar['res'] == 1){
			$this->load->library('session');
        	$correo = $this->session->userdata('correo');
			$asunto = 'NULEGI - Envio de pregunta';
	    	$mensaje = 'Saludos.
						</br>
						</br>
						<p>Se ha realizado la siguiente pregunta.</p>
						<ul>
							<li>Pregunta:  <strong>'.$pregunta.'</strong></li>
							<li>Usuario: <strong>'. $correo.'.</strong></li>
							<li>Fecha:  <strong>'.date('Y-m-d').'</strong></li>
							<li>Hora:  <strong>'.date('H:i:s').'</strong></li>
						</ul>
						</br>
						</br>
						<p>Saludos cordiales.</p>
						</br>
						</br>
						NULEGI.';
	    	$enviar_correo = $this->model_inicio->EnviarCorreo('ed@innerorbitstudios.com', 'enrique@nulegi.com', $asunto, $mensaje);
	    	if($enviar_correo != 1){
		    	$pregunta_guardar['Error'] = 'Correo no enviado.';
		    }
		}
		echo json_encode($pregunta_guardar);
	}

	/*===================================================
	=		       Bloque de comentarios             	=
	=       HUMBERTO HERRADOR 09/04/2017       			=
	FUNCIÓN: Encargada de realizar el pago por medio de stripe
	PARAMETROS:
	POST:
		$_POST['stripeToken'] :: Clave se seguridad de stripe
	GET:
	DEVUELVE:
	NOTA:
	================= MODIFICACIONES ===================
	====================================================
	==================================================*/
	public function TarjetaPago(){
		/*
			@	HUMBERTO HERRADOR: 09/04/2017
			@	Cargando libreria stripe
		*/
		require_once(APPPATH.'libraries/stripe-php-4.4.0/init.php');
		// Set your secret key: remember to change this to your live secret key in production
		// See your keys here: https://dashboard.stripe.com/account/apikeys
		
		/*
			@	HUMBERTO HERRADOR: 26/03/2017
			@	Cambio de claves de stripe de test a live
			@	\Stripe\Stripe::setApiKey("sk_test_hlrDFH4EdRv6Oq3SxjRHfZzO");
		*/
		\Stripe\Stripe::setApiKey("sk_test_GINzBDSSXX8hXDIQ7y1WifSX");

		// Token is created using Stripe.js or Checkout!
		// Get the payment token submitted by the form:
		$token = $_POST['stripeToken'];

		
		// Charge the user's card:
		//$precio2 = number_format(floatval('100'), 2, ',', '');
		//$this->Mafersoto_model->_CorreoEnviarErrores('wherrador.ios@gmail.com','Encargado de desarrollo Humberto Herrador', 'ERRORES ENLIT cofidi',$precio2);
		try {
			$charge = \Stripe\Charge::create(array(
			  //"amount" => intval('100') * 100,
			  //"amount" => number_format(floatval($_POST['precio']), 2, ',', ''),
			  "amount" => intval($_POST['precio'])*100,
			  "currency" => "GTQ",
			  "description" => 'Pago de contrato',
			  "source" => $token
			));
			$res['res'] = 1;
			$res['mensaje'] = 'transacción procesada con exito.'; 

		}catch (Exception $e) {
    		$error = $e->getMessage();
    		$res['res'] = 3;
    		$res['error'] = 'Tuvimos problemas procesando tu tarjeta. Por favor intenta más tarde.';
    		$res['error_real'] = $error;
  		}
	  	echo json_encode($res);
		
		
	}
	/*========== Fin Bloque de comentarios ===========*/
}