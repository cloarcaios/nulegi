<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_inicio extends CI_Model {

    public function _sanitizeVar( $var, $type = false ){
        #type = true for array
        $sanitize = new stdClass();
        if ( $type ){
            foreach ($var as $key => $value) {
                $sanitize->$key = $this->_clearString( $value );
            }
            return $sanitize;
        } 
        else{
            return  $this->_clearString( $var );
        }
    }

    /**
    * Recibe String para aliminar carcteres especiales
    *
    * @var String
    * @return retorna string libre de caracteres especiales
    */
    private function _clearString( $string ){
        $string = strip_tags($string);
        $string = htmlspecialchars($string);
        $string = addslashes($string);
        #$string = quotemeta($string);
        return $string;
    }

    //funcion que realiza un desencriptado de data
    public function desencrypt_data($datos){
        $encoded = $datos;   // <-- encoded string from the request
        $decoded = "";
        //$strlen = strlen( $str );
        for( $i = 0; $i < strlen($encoded); $i++ ) {
            $b = ord($encoded[$i]);
            $a = $b ^ 123;  // <-- must be same number used to encode the character
            $decoded.=chr($a);   
        }
        return $decoded;
    }

    public function hashPass($string) {
        return str_replace('=', '', str_shuffle(base64_encode(hash("sha256", base_convert($string, 10, 32)))));
    }

    public function IniciarSesion($correo, $clave, $tipo_usuario){
        if($tipo_usuario == '1'){
            $query = 'SELECT usuario_id as id, nombres as nombres, apellidos, direccion, telefono, nacimiento, dpi, licencia, oficio
                    FROM usuario
                    WHERE correo = "'.$correo.'"
                    AND clave = "'.md5($clave).'"
                    AND estado = 1';
            $tipo = 'usuario';
        }
        else{
            $query = 'SELECT abogado_id as id, nombres as nombres
                    FROM abogado
                    WHERE correo = "'.$correo.'"
                    AND clave = "'.md5($clave).'"
                    AND estado = 1';
            $tipo = 'abogado';
        }
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $token = $this->hashPass(time());
            $fecha_hora = date('Y-m-d H:i:s');
            $query = 'UPDATE '.$tipo.'
                        SET token = "'.$token.'",
                            ultima_sesion = "'.$fecha_hora.'"
                        WHERE correo = "'.$correo.'"
                        AND estado = 1';
            $result = $this->db->query($query);
            if($result != null){
                $respuesta['res'] = 1; 
                $respuesta['tipo_usuario'] = $tipo; 
                $respuesta['id'] = $resultado[0]['id'];
                $respuesta['nombres'] = $resultado[0]['nombres'];
                $respuesta['apellidos'] = $resultado[0]['apellidos'];
                $respuesta['direccion'] = $resultado[0]['direccion'];
                $respuesta['telefono'] = $resultado[0]['telefono'];
                $respuesta['nacimiento'] = $resultado[0]['nacimiento'];
                $respuesta['dpi'] = $resultado[0]['dpi'];
                $respuesta['licencia'] = $resultado[0]['licencia'];
                $respuesta['oficio'] = $resultado[0]['oficio'];
                $respuesta['token'] = $token;
                $respuesta['correo'] = $correo;  
                return $respuesta;
            }
            else{
                $respuesta['res'] = 0;  
                return $respuesta;
            }
        }
        else{
            $respuesta['res'] = 2; 
            return $respuesta;
        }
    }

    public function CerrarSesion(){
        $this->load->library('session');
        $correo = $this->session->userdata('correo');
        $query = 'UPDATE usuario
                    SET token = ""
                    WHERE correo = "'.$correo.'"
                    AND estado = 1';
        $result = $this->db->query($query);
        if($result != null){
            $respuesta['res'] = 1;  
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function cerrar_sesion2($id){
        $query = 'UPDATE cliente
                    SET token = ""
                    WHERE cliente_id = "'.$id.'"
                    AND estado = 1';
        $result = $this->db->query($query);
        if($result != null){
            $respuesta['res'] = 1;  
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function PaisesObtener(){
        $query = 'SELECT pais_id, nombre, nacionalidad
                    FROM pais
                    WHERE estado = 1';
        $result = $this->db->query($query);
        if($result != null){
            $resultado = $result->result_array();
            return $resultado;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function DepartamentosObtener($nacionalidad){
        $nacionalidad = $this->_sanitizeVar($nacionalidad);
        $nacionalidad = substr($nacionalidad, 0,-3);
        $query = 'SELECT d.departamento_id as departamento_id, d.nombre as nombre
                    FROM departamento d, pais p
                    WHERE d.pais_pais_id = p.pais_id 
                    AND p.nacionalidad like "%'.$nacionalidad.'%" 
                    AND d.estado = 1';
        $result = $this->db->query($query);
        if($result != null){
            $resultado = $result->result_array();
            return $resultado;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function BancosObtener(){
        $query = 'SELECT banco_id, nombre
                    FROM banco
                    WHERE estado = 1';
        $result = $this->db->query($query);
        if($result != null){
            $resultado = $result->result_array();
            return $resultado;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function UsuarioModificar($nombres, $apellidos, $direccion, $telefono, $nacimiento, $dpi, $licencia, $oficio, $genero, $pais, $correo, $clave, $id){
        $respuesta = array();
        $query = ' SELECT * 
                    FROM usuario
                    WHERE usuario_id <> '.$id.'
                    AND correo = "'.$correo.'"';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado == null){
            $token = $this->hashPass(time());
            $fecha_creacion = date('Y-m-d H:i:s');
            $ultima_sesion = '';
            $estado = 1;
            $query = 'UPDATE usuario
                        SET nombres = "'.$nombres.'",
                            apellidos = "'.$apellidos.'",
                            telefono = "'.$telefono.'",
                            nacimiento = "'.$nacimiento.'",
                            genero = '.$genero.',
                            dpi = "'.$dpi.'",
                            licencia = "'.$licencia.'",
                            direccion = "'.$direccion.'",
                            oficio = "'.$oficio.'",
                            token = "'.$token.'",';
            if($clave != '0'){
                $query .= 'clave = "'.md5($clave).'",';
            }
            $query .= '
                            
                            correo = "'.$correo.'",
                            pais_pais_id = '.$pais.',
                            estado = '.$estado.'
                        WHERE usuario_id = '.$id.'
                        AND estado = 1';
            $result = $this->db->query($query);
            if($result != null){
                $respuesta['res'] = 1;
                return $respuesta;
            }
            else{
                $respuesta['res'] = 3;  
                return $respuesta;
            }
        }
        else{
            $respuesta['res'] = 2;  
            return $respuesta;
        }
    }

    public function PreRegistroUsuario($correo, $clave){
        $respuesta = array();
        $query = 'SELECT usuario_id
                    FROM usuario
                    WHERE correo = "'.$correo.'"';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado == null){
            $token = $this->hashPass(time());
            $fecha_creacion = date('Y-m-d H:i:s');
            $ultima_sesion = '';
            $estado = 1;
            $query = 'INSERT INTO usuario (nombres, apellidos, telefono, nacimiento, genero, dpi, licencia, direccion, oficio, fecha_creacion, token, clave, correo, ultima_sesion, pais_pais_id, estado) VALUES(
                        "0",
                        "0", 
                        "0", 
                        "0",  
                        0, 
                        "0",
                        "0",
                        "0",
                        "0",
                        "'.$fecha_creacion.'", 
                        "'.$token.'",
                        "'.md5($clave).'",
                        "'.$correo.'",
                        "0",
                        1,
                        1
                )';
            $result = $this->db->query($query);
            $ultimo_id = $this->db->insert_id();
            if($result != null){
                $respuesta['res'] = 1;
                $respuesta['ultimo_id'] = $ultimo_id;
                mkdir('includes/filesmanager/files/'.$ultimo_id, 0777, TRUE);
                chmod('includes/filesmanager/files/'.$ultimo_id, 0777);
                return $respuesta;
            }
            else{
                $respuesta['res'] = 0;  
                return $respuesta;
            }
        }
        else{
            $respuesta['res'] = 2;  
            return $respuesta;
        }
    }

    public function PerfilObtener(){
        $this->load->library('session');
        $correo = $this->session->userdata('correo');
        $query = 'SELECT usuario_id, nombres, apellidos, direccion, telefono, genero, nacimiento, pais_pais_id, dpi, licencia, oficio, correo, clave
                    FROM usuario
                    WHERE correo = "'.$correo.'"
                    AND estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            return $resultado;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function SesionObtener(){
        $this->load->library('session');
        $sesion = array('tipo_usuario' => $this->session->userdata('tipo_usuario'),
                        'nombres' => $this->session->userdata('nombres'),
                        'apellidos' => $this->session->userdata('apellidos'),
                        'direccion' => $this->session->userdata('direccion'),
                        'telefono' => $this->session->userdata('telefono'),
                        'nacimiento' => $this->session->userdata('nacimiento'),
                        'dpi' => $this->session->userdata('dpi'),
                        'licencia' => $this->session->userdata('licencia'),
                        'oficio' => $this->session->userdata('oficio'),
                        'correo'  => $this->session->userdata('correo'),
                        'id' => $this->session->userdata('id'),
                        'token' => $this->session->userdata('token')
                       );
        return $sesion;
    }

    public function ContratoGuardar($nombre_revelador, $edad_revelador, $nacionalidad_revelador, $civil_revelador, $dpi_revelador, $dpi_letras_revelador, $nombre_recibidor, $edad_recibidor, $nacionalidad_recibidor, $civil_recibidor, $dpi_recibidor, $dpi_letras_recibidor, $motivo_firma, $contrato_nombre, $contrato_descripcion, $contrato_tipo){
        $this->load->library('session');
        $usuario_id = $this->session->userdata('id');
        if(isset($usuario_id)){
            $contrato_tipo_respuesta = $this->TipoContratoObtener($contrato_tipo);
            if($contrato_tipo_respuesta['res'] == 1){
                $contrato  = $contrato_tipo_respuesta['contrato_tipo'][0]['contenido'];
                $datos = array($nombre_revelador, $edad_revelador, $nacionalidad_revelador, $civil_revelador, $dpi_revelador, $dpi_letras_revelador, $nombre_recibidor, $edad_recibidor, $nacionalidad_recibidor, $civil_recibidor, $dpi_recibidor, $dpi_letras_recibidor, $motivo_firma);
                $variables   = array("nombre_revelador", "edad_revelador", "nacionalidad_revelador", "civil_revelador", "dpi_revelador", "dpi_letras_revelador", "nombre_recibidor", "edad_recibidor", "nacionalidad_recibidor", "civil_recibidor", "dpi_recibidor", "dpi_letras_recibidor", "motivo_firma");
                $contrato_nuevo = str_replace($variables, $datos, $contrato);
                $fecha_creacion = date('Y-m-d H:i:s');
                $fecha_modificacion = date('Y-m-d H:i:s');
                $query = 'INSERT INTO contrato (nombre, descripcion, contenido, fecha_creacion, fecha_modificacion, clasificacion, contrato_tipo_contrato_tipo_id, estado) VALUES(
                            "'.$contrato_nombre.'",
                            "'.$contrato_descripcion.'",
                            "'.$contrato_nuevo.'", 
                            "'.$fecha_creacion.'",
                            "'.$fecha_modificacion.'",  
                            "0", 
                            '.$contrato_tipo.',
                            1
                    )';
                $result = $this->db->query($query);
                $ultimo_contrato = $this->db->insert_id();
                if($result != null){
                    $query = 'INSERT INTO contratante (abogado_abogado_id, usuario_usuario_id, contrato_contrato_id, estado) VALUES(
                                1,
                                '.$usuario_id.', 
                                '.$ultimo_contrato.',  
                                1
                        )';
                    $result = $this->db->query($query);
                    if($result != null){
                        $respuesta['res'] = 1; 
                        $respuesta['ultimo_id'] = $ultimo_contrato; 
                        return $respuesta;
                    }
                    else{
                        $respuesta['res'] = 3;  
                        return $respuesta;
                    }
                }
                else{
                    $respuesta['res'] = 4;  
                    return $respuesta;
                }
            }
            else{
                $respuesta['res'] = 5;  
                return $respuesta;
            }
        }
        else{
            $respuesta['res'] = 2;  
            return $respuesta;
        }
    }

    public function ContratoRevisar($nombre_revelador, $edad_revelador, $nacionalidad_revelador, $civil_revelador, $dpi_revelador, $dpi_letras_revelador, $nombre_recibidor, $edad_recibidor, $nacionalidad_recibidor, $civil_recibidor, $dpi_recibidor, $dpi_letras_recibidor, $motivo_firma, $contrato_nombre, $contrato_descripcion, $contrato_tipo){
        $this->load->library('session');
        $usuario_id = $this->session->userdata('id');
        if(isset($usuario_id)){
            $contrato_tipo_respuesta = $this->TipoContratoObtener($contrato_tipo);
            if($contrato_tipo_respuesta['res'] == 1){
                $contrato  = $contrato_tipo_respuesta['contrato_tipo'][0]['contenido'];
                $datos = array($nombre_revelador, $edad_revelador, $nacionalidad_revelador, $civil_revelador, $dpi_revelador, $dpi_letras_revelador, $nombre_recibidor, $edad_recibidor, $nacionalidad_recibidor, $civil_recibidor, $dpi_recibidor, $dpi_letras_recibidor, $motivo_firma);
                $variables   = array("nombre_revelador", "edad_revelador", "nacionalidad_revelador", "civil_revelador", "dpi_revelador", "dpi_letras_revelador", "nombre_recibidor", "edad_recibidor", "nacionalidad_recibidor", "civil_recibidor", "dpi_recibidor", "dpi_letras_recibidor", "motivo_firma");
                $contrato_nuevo = str_replace($variables, $datos, $contrato);
                $respuesta['contrato_revision'] = $contrato_nuevo;
                $respuesta['res'] = 1; 
            }
            else{
                $respuesta['res'] = 2;  
            }
        }
        else{
            $respuesta['res'] = 3;  
        }
        return $respuesta;
    }

    public function TipoContratoObtener($contrato_tipo){
        $respuesta = array();
        $query = 'SELECT nombre, contenido, tiempo, precio, estado
                    FROM contrato_tipo
                    WHERE contrato_tipo_id = '.$contrato_tipo;
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['contrato_tipo'] = $resultado;
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function ContratosGeneradosObtener(){
        $respuesta = array();
        $usuario_id = $this->session->userdata('id');
        if(isset($usuario_id)){
            $query = 'SELECT cg.nombre as nombre, cg.contrato_generado_id as contrato_id, ct.contrato_tipo_id as contrato_tipo_id, ct.nombre as contrato_tipo, ct.icono as icono
                        FROM contrato c, contrato_generado cg, contrato_tipo ct, usuario u
                        WHERE cg.contrato_id = c.contrato_id
                        AND c.contrato_tipo_contrato_tipo_id = ct.contrato_tipo_id
                        AND cg.usuario_id = u.usuario_id
                        AND u.usuario_id = '.$usuario_id.'
                        GROUP BY c.contrato_tipo_contrato_tipo_id, cg.nombre';
            $result = $this->db->query($query);
            $resultado = $result->result_array();
            if($resultado != null){
                $respuesta['res'] = 1;
                $respuesta['contratos'] = $resultado;
                return $respuesta;
            }
            else{
                $respuesta['res'] = 0;  
                return $respuesta;
            }
        }
        else{
            $respuesta['res'] = 2;  
            return $respuesta;
        }
    }

    public function ContratosInvitadosObtener(){
        $respuesta = array();
        $usuario_id = $this->session->userdata('id');
        if(isset($usuario_id)){
            $query = 'SELECT c.contrato_id as contrato_id, c.nombre as contrato_nombre, c.contenido as contenido, c.fecha_creacion as fecha_creacion, c.fecha_modificacion as fecha_modificacion, tc.nombre as categoria_nombre, c.estado as estado, u.correo as invitado_por
                        FROM contrato c, contratante ct, usuario u, contrato_tipo tc, invitacion i
                        WHERE i.contratante_contratante_id = ct.contratante_id
                        AND ct.contrato_contrato_id = c.contrato_id
                        AND c.contrato_tipo_contrato_tipo_id = tc.contrato_tipo_id
                        AND ct.usuario_usuario_id = u.usuario_id
                        AND i.usuario_usuario_id = '.$usuario_id;
            $result = $this->db->query($query);
            $resultado = $result->result_array();
            if($resultado != null){
                $respuesta['res'] = 1;
                $respuesta['contratos'] = $resultado;
                return $respuesta;
            }
            else{
                $respuesta['res'] = 0;  
                return $respuesta;
            }
        }
        else{
            $respuesta['res'] = 2;  
            return $respuesta;
        }
    }

    public function ContratosCategoriaObtener(){
        $respuesta = array();
        $query = 'SELECT c.contrato_id as contrato_id, c.nombre as contrato_nombre, c.descripcion as contrato_descripcion, ct.nombre as categoria_nombre, ct.icono as icono, c.imagen as contrato_imagen
                    FROM contrato c, contrato_tipo ct
                    WHERE c.contrato_tipo_contrato_tipo_id = ct.contrato_tipo_id
                    AND c.estado = 1
                    AND ct.estado = 1
                    ORDER BY c.contrato_tipo_contrato_tipo_id';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['contratos'] = $resultado;
        }
        else{
            $respuesta['res'] = 0;  
        }
        return $respuesta;
    }

    public function ContratoObtener($contrato_id){
        $sesion = $this->SesionObtener();
        $respuesta = array();
        $query = 'SELECT DISTINCT cto.nombre, cto.descripcion, cto.contenido
                    FROM contrato cto, contratante ctt, usuario u
                    WHERE ctt.contrato_contrato_id = cto.contrato_id
                    AND ctt.usuario_usuario_id = u.usuario_id
                    AND u.usuario_id = '.$sesion['id'].'
                    AND cto.contrato_id = '.$contrato_id;
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['contrato'] = $resultado[0];
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function MotivosObtener($contrato_tipo){
        $query = 'SELECT motivo_id, nombre, contenido, contrato_tipo_contrato_tipo_id
                    FROM motivo
                    WHERE estado = '.$contrato_tipo;
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['motivos'] = $resultado;
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function DocumentoVerificar($usuario_id, $nombrearchivo, $ruta){
        $query = 'SELECT d.documento_id
                    FROM documento d, usuario u
                    WHERE d.usuario_usuario_id = u.usuario_id
                    AND u.usuario_id = "'.$usuario_id.'"
                    AND d.nombre = "'.$nombrearchivo.'"
                    AND d.ruta = "'.$ruta.'"
                    AND d.estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function DocumentoInsertar($usuario_id, $nombrearchivo, $ruta){
        $fecha_hora = date('Y-m-d H:i:s');
        $query = 'INSERT INTO documento (nombre, ruta, fecha_hora, usuario_usuario_id, estado) VALUES(
                            "'.$nombrearchivo.'",
                            "'.$ruta.'",
                            "'.$fecha_hora.'", 
                            '.$usuario_id.',
                            1
                        )';
        $result = $this->db->query($query);
        if($result != null){
            $respuesta['res'] = 1;
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;
            return $respuesta;
        }
    }

    public function DocumentosObtener($usuario_id){
        $query = 'SELECT documento_id, ruta, nombre, fecha_hora
                    FROM documento
                    WHERE usuario_usuario_id = '.$usuario_id.'
                    AND estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['documentos'] = $resultado;
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function ContratoCompartir($contrato_id, $correo_invitado){
        $this->load->library('session');
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $usuario_id = $this->session->userdata('id');
        $query = 'SELECT usuario_id, nombres
                    FROM usuario
                    WHERE correo = "'.$correo_invitado.'"
                    AND estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $nombres = $resultado[0]['nombres'];
            if($nombres == '0'){
                $nombres = $correo_invitado;
            }
        }
        else{
            $nombres = $correo_invitado;
        }
        $contratante = $this->ContratanteObtener($usuario_id, $contrato_id);
        if($resultado != null){
            if($contratante['res'] == 1){
                $query = 'SELECT count(invitacion_id) as cantidad
                            FROM invitacion
                            WHERE contratante_contratante_id = '.$contratante['contratante_id'].'
                            AND usuario_usuario_id = '.$resultado[0]['usuario_id'].'
                            AND estado = 1';
                $result = $this->db->query($query);
                $invitacion_existe = $result->result_array();
                if($invitacion_existe[0]['cantidad'] == 0){
                    $query = 'INSERT INTO invitacion (fecha, hora, contratante_contratante_id, usuario_usuario_id, estado) VALUES(
                                        "'.$fecha.'",
                                        "'.$hora.'", 
                                        '.$contratante['contratante_id'].',
                                        '.$resultado[0]['usuario_id'].',
                                        1
                                    )';
                    $result = $this->db->query($query);
                    if($result != null){
                        $respuesta['nombres'] = $nombres;
                        $respuesta['res'] = 1;
                    }
                    else{
                        $respuesta['res'] = 2;
                    }
                }
                else{
                    $respuesta['res'] = 3;
                }
            }
            else{
                $respuesta['res'] = 4;   
            }
        }
        else{
            if($contratante['res'] == 1){
                $clave_aleatoria = substr($this->hashPass(microtime()), 0, 8);
                $usuario_nuevo = $this->PreRegistroUsuario($correo_invitado, $clave_aleatoria);
                if($usuario_nuevo['res'] == 1){
                    $query = 'INSERT INTO invitacion (fecha, hora, contratante_contratante_id, usuario_usuario_id, estado) VALUES(
                                        "'.$fecha.'",
                                        "'.$hora.'", 
                                        '.$contratante['contratante_id'].',
                                        '.$usuario_nuevo['ultimo_id'].',
                                        1
                                    )';
                    $result = $this->db->query($query);
                    if($result != null){
                        $respuesta['clave_aleatoria'] = $clave_aleatoria;
                        $respuesta['nombres'] = $nombres;
                        $respuesta['res'] = 5;
                    }
                    else{
                        $respuesta['res'] = 6;
                    }
                }
                else{
                    $respuesta['res'] = 7;
                }
            }
            else{
                $respuesta['res'] = 8;
            }
        }
        return $respuesta;
    }

    public function ContratanteObtener($usuario_id, $contrato_id){
        $query = 'SELECT contratante_id
                    FROM contratante
                    WHERE usuario_usuario_id = '.$usuario_id.'
                    AND contrato_contrato_id = '.$contrato_id.'
                    AND estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['contratante_id'] = $resultado[0]['contratante_id'];
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function CorreoExiste($correo){
        $respuesta = array();
        $query = 'SELECT correo
                FROM usuario
                WHERE correo = "'.$correo.'"
                AND estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
        }
        else{
            $respuesta['res'] = 0;
        }
        return $respuesta;
    }

    public function ReestablecerVerificar($correo, $hash){
        $query = 'SELECT token_reestablecer, ultima_sesion
                    FROM usuario
                    WHERE correo = "'.$correo.'"
                    AND estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        return $resultado;
    }

    public function ReestablecerToken($correo, $token){
        $query = 'UPDATE usuario 
                    SET token_reestablecer = "'.$token.'", 
                        ultima_sesion = "'.date('Y-m-d H:i:s').'"
                    WHERE correo = "'.$correo.'"
                    AND estado = 1';
        $result = $this->db->query($query);
        return $result;
    }

    public function ReestablecerConfirmar($correo, $hash, $clave){
        $query = 'UPDATE usuario 
                    SET token_reestablecer = "", 
                        clave = "'.md5($clave).'"
                    WHERE correo = "'.$correo.'"
                    AND estado = 1';
        $result = $this->db->query($query);
        return $result;
    }

    public function DocumentoBorrar($usuario_id, $dir){
        $archivo_nombre = end(explode('/', $dir));
        $ruta = str_replace($archivo_nombre, '', $dir);
        $ruta = substr($ruta, 0, -1);
        $query = 'DELETE FROM documento 
                    WHERE usuario_usuario_id = '.$usuario_id.'
                    AND ruta = "'.$ruta.'"
                    AND nombre = "'.$archivo_nombre.'"';
        $result = $this->db->query($query);
        return $result;
    }

    public function ContenidoMover($usuario_id, $ruta_nueva, $archivo_nombre){
        $query = 'UPDATE documento 
                    SET ruta = "'.$ruta_nueva.'"
                    WHERE usuario_usuario_id = '.$usuario_id.'
                    AND nombre = "'.$archivo_nombre.'"';
        $result = $this->db->query($query);
        return $result;
    }

    public function NoticiasObtener(){
        $query = 'SELECT noticia_id, nombre, titulo, descripcion, imagen
                    FROM noticia
                    WHERE estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['noticias'] = $resultado;
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function NoticiaObtener($noticia_id){
        $query = 'SELECT nombre, titulo, descripcion, contenido, imagen
                    FROM noticia
                    WHERE noticia_id = '.$noticia_id.' 
                    AND estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['noticia'] = $resultado[0];
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function AbogadosObtener(){
        $query = 'SELECT abogado_id, nombres, apellidos, colegiado, universidad, foto
                    FROM abogado
                    WHERE estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['notarios'] = $resultado;
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function AbogadoObtener($abogado_id){
        $respuesta = array();
        $query = 'SELECT nombres, apellidos, colegiado, universidad, foto, descripcion, experiencia
                    FROM abogado
                    WHERE abogado_id = '.$abogado_id.' 
                    AND estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['notario'] = $resultado[0];
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function ContratoBuscar($contrato_tipo){
        $respuesta = array();
        $query = 'SELECT c.contrato_id as contrato_id, c.nombre as contrato_nombre, c.descripcion as contrato_descripcion, ct.nombre as categoria_nombre, c.imagen as contrato_imagen, ct.icono as icono
                    FROM contrato c, contrato_tipo ct
                    WHERE c.contrato_tipo_contrato_tipo_id = ct.contrato_tipo_id
                    AND c.contrato_tipo_contrato_tipo_id = '.$contrato_tipo.'
                    AND c.estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['contrato_busqueda'] = $resultado;
        }
        else{
            $respuesta['res'] = 0;
        }
        return $respuesta;
    }

    public function ContratoDisponibleObtener($contrato_disponible_id){
        $contrato_disponible_id = $this->_sanitizeVar($contrato_disponible_id);
        $query = 'SELECT c.contrato_id as contrato_id, c.nombre as nombre, c.descripcion as descripcion, c.contenido as contenido, c.imagen as imagen, c.precio as precio, ct.nombre as contrato_tipo
                    FROM contrato c, contrato_tipo ct
                    WHERE c.contrato_tipo_contrato_tipo_id = ct.contrato_tipo_id
                    AND c.contrato_id = '.$contrato_disponible_id.'
                    AND c.estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['contrato_disponible'] = $resultado[0];
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function EnviarCorreo($correo, $nombre, $asunto, $mensaje){
        require_once 'includes/PHPMailer-master/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
        //$mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.innerorbitstudios.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'cloarca@innerorbitstudios.com';                 // SMTP username
        $mail->Password = 'Abcd1234';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->From = 'info@nulegi.com';
        $mail->FromName = 'NULEGI';
        $mail->addAddress($correo, $nombre);
        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;
        $mail->AltBody = $mensaje;
        if($mail->send()){
            return 1;
        }
        else{
            $respuesta['res'] = 3;
            $respuesta['error'] = $mail->ErrorInfo;
            return $respuesta;
        }
    }

    public function FechaFormateada2($FechaStamp){ 
        $ano = date('Y',$FechaStamp);
        $mes = date('n',$FechaStamp);
        $dia = date('d',$FechaStamp);
        $diasemana = date('w',$FechaStamp);
     
        $diassemanaN= array("Domingo",
                            "Lunes",
                            "Martes",
                            "Miércoles",
                            "Jueves",
                            "Viernes",
                            "Sábado"); 
        $mesesN=array(1=>"Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre");
        return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." de $ano";
    }

    public function FechaFormateada3($FechaStamp){ 
        $ano = date('Y',$FechaStamp);
        $mes = date('n',$FechaStamp);
        $dia = date('d',$FechaStamp);
     
        $tumadre=array(1=>"Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic");
        return $dia.'-'.$tumadre[$mes].'-'.$ano;
    }

    public function ContratoGuardar2($_contrato_contenido, $_contrato_id, $_nombre){
        $respuesta = array();
        $this->load->library('session');
        $usuario_id = $this->session->userdata('id');
        $descripcion = '';
        $numero = '';
        $fecha_creacion = date('Y-m-d H:i:s');
        $fecha_modificacion = date('Y-m-d H:i:s');
        $clasificacion = '';
        $estado = 1;
        $contrato_contenido = htmlspecialchars($_contrato_contenido);
        $query = 'INSERT INTO contrato_generado (nombre, descripcion, contenido, numero, fecha_creacion, fecha_modificacion, clasificacion, contrato_id, usuario_id, estado)
                    VALUES ("'.strtolower($_nombre).'", "'.$descripcion.'","'.$contrato_contenido.'", "'.$numero.'","'.$fecha_creacion.'","'.$fecha_modificacion.'", "'.$clasificacion.'",'.$_contrato_id.','.$usuario_id.','.$estado.')';
        $result = $this->db->query($query);
        if($result == true){
            $respuesta['res'] = 1;
            $respuesta['contrato_guardado'] = $this->db->insert_id();
        }
        else{
            $respuesta['res'] = 0;
        }
        return $respuesta;
    }

    public function ContratoGeneradoObtener($_contrato_generado_id){
        $respuesta = array();
        $query = 'SELECT nombre, contenido
                    FROM contrato_generado
                    WHERE contrato_generado_id = '.$_contrato_generado_id.'
                    AND estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != NULL){
            $respuesta['res'] = 1;
            $respuesta['contrato'] = $resultado[0];
        }
        else{
            $respuesta['res'] = 0;
        }
        return $respuesta;
    }

    public function CategoriasObtener(){
        $respuesta = array();
        $query = 'SELECT contrato_tipo_id, nombre, icono
                    FROM contrato_tipo
                    WHERE estado = 1';
        $result = $this->db->query($query);
        $resultado = $result->result_array();
        if($resultado != null){
            $respuesta['res'] = 1;
            $respuesta['categorias'] = $resultado;
            return $respuesta;
        }
        else{
            $respuesta['res'] = 0;  
            return $respuesta;
        }
    }

    public function ContratoNombreVerificar($_contrato_nombre){
        $respuesta = array();
        $query = 'SELECT contrato_generado_id
                    FROM contrato_generado
                    WHERE nombre = "'.$_contrato_nombre.'"';
        $result = $this->db->query($query);
        if($result->num_rows() > 0){
            $respuesta['res'] = 1;
        }
        else{
            $respuesta['res'] = 0;  
        }
        return $respuesta;
    }

    public function ContratosVersiones($_contrato_generado_id){
        $respuesta = array();
        $usuario_id = $this->session->userdata('id');
        if(isset($usuario_id)){
            $query = 'SELECT DISTINCT nombre 
                        FROM contrato_generado
                        WHERE contrato_generado_id = '.$_contrato_generado_id;
            $result = $this->db->query($query);
            $nombre = $result->result_array();
            $query = 'SELECT cg.contrato_generado_id as contrato_generado_id, cg.nombre as contrato_nombre, cg.fecha_creacion as fecha_creacion, ct.icono as icono, ct.nombre as contrato_tipo
                        FROM contrato c, contrato_generado cg, contrato_tipo ct, usuario u
                        WHERE c.contrato_tipo_contrato_tipo_id = ct.contrato_tipo_id
                        AND cg.contrato_id = c.contrato_id
                        AND cg.usuario_id = u.usuario_id
                        AND cg.nombre = "'.$nombre[0]['nombre'].'"';
            $result = $this->db->query($query);
            $resultado = $result->result_array();
            if($resultado != null){
                $respuesta['res'] = 1;
                $respuesta['contratos'] = $resultado;
                $respuesta['contrato_nombre'] = $nombre[0];
            }
            else{
                $respuesta['res'] = 0;
            }
        }
        else{
            $respuesta['res'] = 2;  
        }
        return $respuesta;
    }

    public function ContratoCompartir2($contrato_generado_id, $correo_invitado){
        $this->load->library('session');
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $usuario_id = $this->session->userdata('id');
        $query = 'SELECT usuario_id, nombres
                    FROM usuario
                    WHERE correo = "'.$correo_invitado.'"
                    AND estado = 1';
        $result = $this->db->query($query);
        $invitado = $result->result_array();
        if($invitado != null){
            $nombres = $invitado[0]['nombres'];
            if($nombres == '0'){
                $nombres = $correo_invitado;
            }
            $query = 'INSERT INTO contrato_invitacion (usuario_id, invitado, contrato_generado_id, fecha, hora, estado) VALUES(
                                '.$usuario_id.',
                                '.$invitado[0]['usuario_id'].',
                                '.$contrato_generado_id.',
                                "'.$fecha.'",
                                "'.$hora.'",
                                1
                            )';
            $result = $this->db->query($query);
            if($result != null){
                $respuesta['nombres'] = $nombres;
                $respuesta['res'] = 1;
            }
            else{
                $respuesta['res'] = 0;
            }
        }
        else{
            $clave_aleatoria = substr($this->hashPass(microtime()), 0, 8);
            $usuario_nuevo = $this->PreRegistroUsuario($correo_invitado, $clave_aleatoria);
            if($usuario_nuevo['res'] == 1){
                $query = 'INSERT INTO contrato_invitacion (usuario_id, invitado, contrato_generado_id, fecha, hora, estado) VALUES(
                                    '.$usuario_id.',
                                    '.$usuario_nuevo['ultimo_id'].',
                                    '.$contrato_generado_id.',
                                    "'.$fecha.'",
                                    "'.$hora.'",
                                    1
                                )';
                $result = $this->db->query($query);
                if($result != null){
                    $respuesta['clave_aleatoria'] = $clave_aleatoria;
                    $respuesta['nombres'] = $correo_invitado;
                    $respuesta['res'] = 2;
                }
                else{
                    $respuesta['res'] = 0;
                }
            }
            else{
                $respuesta['res'] = 3;
            }
        }
        return $respuesta;
    }

    public function ContratosCompartidosObtener(){
        $respuesta = array();
        $usuario_id = $this->session->userdata('id');
        if(isset($usuario_id)){
            $query = 'SELECT DISTINCT cg.contrato_generado_id as contrato_id, cg.nombre as nombre, ci.fecha as fecha, ct.icono as icono, ct.contrato_tipo_id as contrato_tipo_id, ct.nombre as contrato_tipo, ct.icono as icono
                        FROM contrato c, contrato_generado cg, contrato_invitacion ci, contrato_tipo ct, usuario u
                        WHERE c.contrato_tipo_contrato_tipo_id = ct.contrato_tipo_id
                        AND cg.contrato_generado_id = ci.contrato_generado_id
                        AND cg.contrato_id = c.contrato_id
                        AND cg.usuario_id = u.usuario_id
                        AND ci.invitado = '.$usuario_id;
            $result = $this->db->query($query);
            $resultado = $result->result_array();
            if($resultado != null){
                $respuesta['res'] = 1;
                $respuesta['contratos'] = $resultado;
            }
            else{
                $respuesta['res'] = 0;
            }
        }
        else{
            $respuesta['res'] = 2;  
        }
        return $respuesta;
    }

    public function ContratoGuardarEditado($_contrato_contenido, $_contrato_generado_id, $_nombre){
        $respuesta = array();
        $this->load->library('session');
        $usuario_id = $this->session->userdata('id');
        $descripcion = '';
        $numero = '';
        $fecha_creacion = date('Y-m-d H:i:s');
        $fecha_modificacion = date('Y-m-d H:i:s');
        $clasificacion = '';
        $estado = 1;
        $query = 'SELECT contrato_id
                    FROM contrato_generado
                    WHERE contrato_generado_id = '.$_contrato_generado_id;
        $result = $this->db->query($query);
        $contrato_id = $result->result_array();
        $contrato_contenido = htmlspecialchars($_contrato_contenido);
        $query = 'INSERT INTO contrato_generado (nombre, descripcion, contenido, numero, fecha_creacion, fecha_modificacion, clasificacion, contrato_id, usuario_id, estado)
                    VALUES ("'.strtolower($_nombre).'", "'.$descripcion.'","'.$contrato_contenido.'", "'.$numero.'","'.$fecha_creacion.'","'.$fecha_modificacion.'", "'.$clasificacion.'",'.$contrato_id[0]['contrato_id'].','.$usuario_id.','.$estado.')';
        $result = $this->db->query($query);
        if($result == true){
            $respuesta['res'] = 1;
        }
        else{
            $respuesta['res'] = 0;
        }
        return $respuesta;
    }

    public function PreguntaGuardar($_pregunta){
        $respuesta = array();
        $this->load->library('session');
        $usuario_id = $this->session->userdata('id');
        $fecha = date('Y-m-d H:i:s');
        $query = 'INSERT INTO pregunta (pregunta, usuario_id, fecha, estado)
                    VALUES ("'.$_pregunta.'", '.$usuario_id.',"'.$fecha.'", 1)';
        $result = $this->db->query($query);
        if($result == true){
            $respuesta['res'] = 1;
        }
        else{
            $respuesta['res'] = 0;
        }
        return $respuesta;
    }
}