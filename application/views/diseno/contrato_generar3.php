<?php $this->layout->block('headhtml'); ?>
    <?php
		$html_paises = '';
		foreach ($paises as $key => $pais) {
			$html_paises .= '<option value="'.$pais['nacionalidad'].'">'.$pais['nacionalidad'].'</option>';
		}
        $html_departamentos = '';
        foreach ($departamentos as $key => $departamento) {
            $html_departamentos .= '<option value="'.$departamento['nombre'].'">'.$departamento['nombre'].'</option>';
        }
        $html_bancos = '';
        foreach ($bancos as $key => $banco) {
            $html_bancos .= '<option value="'.$banco['nombre'].'">'.$banco['nombre'].'</option>';
        }
    ?>
	<style type="text/css">
		.mensaje_error div{
			color:red;
		}
        .formContract{
            height:77vh !important; 
            margin: 0;
        }
	</style>
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script src="<?php echo($this->config->base_url());?>includes/tinymce/es.js"></script>
	<script src="<?php echo($this->config->base_url());?>includes/js/jquery.maskedinput.min.js"></script>
	<script type="text/javascript">
        $( document ).ready(function() {
            var valor = 0;
            $('.circle').each(function(key,element){
                $(element).css('top', valor + 'px');
                valor = valor + 80;
            });
            $(".contentText, .contentCircle").css("height", (valor - 40) + "px");
            valor = 0;
            $('.textCircle').each(function(key,element){
                $(element).css('top', valor + 'px');
                valor = valor + 80;
            });
        });

	    function validar_caracter1(e,element){
            tecla = (document.all) ? e.keyCode : e.which;
            //Reconoce números con un único punto decimal
            var patron1 = /\d/;
            var patron2 = /^\d+(?:\.\d{0,2})?$/;
            if (tecla == 8 || tecla == 0){
            	return true;
           	}
           	else if(patron1.test($(element).val()) == true || tecla == 46){
           		if(patron2.test($(element).val()) == true){
	                return true;
            	}
            	else{
            		var texto = $(element).val();
	                texto = texto.substring(0,texto.length-1);
	                $(element).val(texto);
	                return false;
            	}
           	}
           	else{
           		var texto = $(element).val();
                texto = texto.substring(0,texto.length-1);
                $(element).val(texto);
                return false;
           	}
        }

        function FormatoMoneda(elemento){
            var valor = $(elemento).val();
            if(parseInt(valor) > 0){
                var moneda = parseFloat($(elemento).val()).toFixed(2);
                $(elemento).val(moneda);
            }
            else{
                $(elemento).val('');
            }
        }

        function PasoVer(paso){
        	$('.circle').removeClass('active');
            $('.textCircle').removeClass('active');
            $('.paso').each(function(key,element){
                if($(element).prop('id') == 'div_paso'+paso){
                    $(element).css('display','block');
                    $('#item'+paso+'C').addClass('active');
                    $('#item'+paso+'TC').addClass('active');
                }
                else{
                	$(element).css('display','none');
                }
            });
        }

        var vendedor = new Array();
        function Paso1Validar(){
            var nombres = $('#txt_vendedor_nombres').val();
            var apellidos = $('#txt_vendedor_apellidos').val();
            var direccion = $('#txt_vendedor_direccion').val();
            var edad = $('#txt_vendedor_edad').val();
            var correo = $('#txt_vendedor_correo').val();
            var profesion = $('#txt_vendedor_profesion').val();
            var dpi = $('#txt_vendedor_dpi').val();
            var nombre = $('#txt_vendedor_nombre').val();
            var notario = $('#txt_vendedor_notario').val();
            var fecha = $('#txt_vendedor_fecha').val();
            var registro = $('#txt_vendedor_registro').val();
            var folio = $('#txt_vendedor_folio').val();
            var libro = $('#txt_vendedor_libro').val();
            var error = false;
            jQuery('.spn_vendedor_nombres').html('');
            jQuery('.spn_vendedor_apellidos').html('');
            jQuery('.spn_vendedor_direccion').html('');
            jQuery('.spn_vendedor_edad').html('');
            jQuery('.spn_vendedor_correo').html('');
            jQuery('.spn_vendedor_profesion').html('');
            jQuery('.spn_vendedor_dpi').html('');
            jQuery('.spn_vendedor_nombre').html('');
            jQuery('.spn_vendedor_notario').html('');
            jQuery('.spn_vendedor_fecha').html('');
            jQuery('.spn_vendedor_registro').html('');
            jQuery('.spn_vendedor_folio').html('');
            jQuery('.spn_vendedor_libro').html('');
            if(nombres == ''){
                error = true;
                mensaje_error = 'Ingrese los nombres del vendedor.';
                jQuery('.spn_vendedor_nombres').html(mensaje_error);
            }
            if(apellidos == ''){
                error = true;
                mensaje_error = 'Ingrese los apellidos del vendedor.';
                jQuery('.spn_vendedor_apellidos').html(mensaje_error);
            }
            if(direccion == ''){
                error = true;
                mensaje_error = 'Ingrese la dirección del vendedor.';
                jQuery('.spn_vendedor_direccion').html(mensaje_error);
            }
            if(edad == ''){
                error = true;
                mensaje_error = 'Ingrese la edad del vendedor.';
                jQuery('.spn_vendedor_edad').html(mensaje_error);
            }
            if(correo == '' || validateEmail(correo) ==  false){
                error = true;
                mensaje_error = 'Ingrese un correo valido del vendedor.';
                jQuery('.spn_vendedor_correo').html(mensaje_error);
            }
            if(profesion == ''){
                error = true;
                mensaje_error = 'Ingrese la profesion del vendedor.';
                jQuery('.spn_vendedor_profesion').html(mensaje_error);
            }
            if(dpi == ''){
                error = true;
                mensaje_error = 'Ingrese el DPI del vendedor.';
                jQuery('.spn_vendedor_dpi').html(mensaje_error);
            }
            if(nombre == ''){
                error = true;
                mensaje_error = 'Ingrese el nombre de la entidad.';
                jQuery('.spn_vendedor_nombre').html(mensaje_error);
            }
            if(notario == ''){
                error = true;
                mensaje_error = 'Ingrese el nombre del notario.';
                jQuery('.spn_vendedor_notario').html(mensaje_error);
            }
            if(fecha == ''){
                error = true;
                mensaje_error = 'Ingrese la fecha de inscripción de la entidad.';
                jQuery('.spn_vendedor_fecha').html(mensaje_error);
            }
            if(registro == ''){
                error = true;
                mensaje_error = 'Ingrese el numero de registro mercantil de la entidad.';
                jQuery('.spn_vendedor_registro').html(mensaje_error);
            }
            if(folio == ''){
                error = true;
                mensaje_error = 'Ingrese el numero de folio.';
                jQuery('.spn_vendedor_folio').html(mensaje_error);
            }
            if(libro == ''){
                error = true;
                mensaje_error = 'Ingrese el numero de libro.';
                jQuery('.spn_vendedor_libro').html(mensaje_error);
            }
            if(error == false){
                var genero = $('#slc_vendedor_genero').val();
                var civil = $('#slc_vendedor_civil').val();
                var nacionalidad = $('#slc_vendedor_nacionalidad').val();
                var departamento = $('#slc_vendedor_departamento').val();
                var calidad = $('#slc_vendedor_calidad').val();
                var identificacion = $('.vendedor_dpi').html();
                vendedor = new Array();
                vendedor['nombres'] = nombres;
                vendedor['apellidos'] = apellidos;
                vendedor['direccion'] = direccion;
                vendedor['edad'] = edad;
                vendedor['correo'] = correo;
                vendedor['genero'] = genero;
                vendedor['civil'] = civil;
                vendedor['profesion'] = profesion;
                vendedor['nacionalidad'] = nacionalidad;
                vendedor['departamento'] = departamento;
                vendedor['dpi'] = dpi;
                vendedor['identificacion'] = identificacion;
	            vendedor['calidad'] = calidad;
                vendedor['nombre'] = nombre;
                vendedor['notario'] = notario;
                vendedor['fecha'] = fecha;
                vendedor['registro'] = registro;
                vendedor['folio'] = folio;
                vendedor['libro'] = libro;
                console.log(vendedor);
                PasoVer(2);
            }
        }

        var comprador = new Array();
        function Paso2Validar(){
            var nombres = $('#txt_comprador_nombres').val();
            var apellidos = $('#txt_comprador_apellidos').val();
            var direccion = $('#txt_comprador_direccion').val();
            var edad = $('#txt_comprador_edad').val();
            var correo = $('#txt_comprador_correo').val();
            var profesion = $('#txt_comprador_profesion').val();
            var dpi = $('#txt_comprador_dpi').val();
            var representacion = $('#slc_comprador_representacion').val();
            var error = false;
            jQuery('.spn_comprador_nombres').html('');
            jQuery('.spn_comprador_apellidos').html('');
            jQuery('.spn_comprador_direccion').html('');
            jQuery('.spn_comprador_edad').html('');
            jQuery('.spn_comprador_correo').html('');
            jQuery('.spn_comprador_profesion').html('');
            jQuery('.spn_comprador_dpi').html('');
            if(nombres == ''){
                error = true;
                mensaje_error = 'Ingrese los nombres del comprador.';
                jQuery('.spn_comprador_nombres').html(mensaje_error);
            }
            if(apellidos == ''){
                error = true;
                mensaje_error = 'Ingrese los apellidos del comprador.';
                jQuery('.spn_comprador_apellidos').html(mensaje_error);
            }
            if(direccion == ''){
                error = true;
                mensaje_error = 'Ingrese la dirección del comprador.';
                jQuery('.spn_comprador_direccion').html(mensaje_error);
            }
            if(edad == ''){
                error = true;
                mensaje_error = 'Ingrese la edad del comprador.';
                jQuery('.spn_comprador_edad').html(mensaje_error);
            }
            if(correo == '' || validateEmail(correo) == false){
                error = true;
                mensaje_error = 'Ingrese un correo valido del comprador.';
                jQuery('.spn_comprador_correo').html(mensaje_error);
            }
            if(profesion == ''){
                error = true;
                mensaje_error = 'Ingrese la profesion del comprador.';
                jQuery('.spn_comprador_profesion').html(mensaje_error);
            }
            if(dpi == ''){
                error = true;
                mensaje_error = 'Ingrese el DPI del comprador.';
                jQuery('.spn_comprador_dpi').html(mensaje_error);
            }
            if(representacion == '2'){
                var nombre = $('#txt_comprador_nombre').val();
                var notario = $('#txt_comprador_notario').val();
                var fecha = $('#txt_comprador_fecha').val();
                var registro = $('#txt_comprador_registro').val();
                var folio = $('#txt_comprador_folio').val();
                var libro = $('#txt_comprador_libro').val();
                jQuery('.spn_comprador_nombre').html('');
                jQuery('.spn_comprador_notario').html('');
                jQuery('.spn_comprador_fecha').html('');
                jQuery('.spn_comprador_registro').html('');
                jQuery('.spn_comprador_libro').html('');
                jQuery('.spn_comprador_folio').html('');
                if(nombre == ''){
                    error = true;
                    mensaje_error = 'Ingrese el nombre de la entidad.';
                    jQuery('.spn_comprador_nombre').html(mensaje_error);
                }
                if(notario == ''){
                    error = true;
                    mensaje_error = 'Ingrese el nombre del notario.';
                    jQuery('.spn_comprador_notario').html(mensaje_error);
                }
                if(fecha == ''){
                    error = true;
                    mensaje_error = 'Ingrese la fecha de inscripción de la entidad.';
                    jQuery('.spn_comprador_fecha').html(mensaje_error);
                }
                if(registro == ''){
                    error = true;
                    mensaje_error = 'Ingrese el numero de registro mercantil de la entidad.';
                    jQuery('.spn_comprador_registro').html(mensaje_error);
                }
                if(folio == ''){
                    error = true;
                    mensaje_error = 'Ingrese el numero de folio.';
                    jQuery('.spn_comprador_folio').html(mensaje_error);
                }
                if(libro == ''){
                    error = true;
                    mensaje_error = 'Ingrese el numero de libro.';
                    jQuery('.spn_comprador_libro').html(mensaje_error);
                }
            }
            if(error == false){
                var genero = $('#slc_comprador_genero').val();
                var civil = $('#slc_comprador_civil').val();
                var nacionalidad = $('#slc_comprador_nacionalidad').val();
                var departamento = $('#slc_comprador_departamento').val();
                var identificacion = $('.comprador_dpi').html();
                var calidad = $('#slc_comprador_calidad').val();
                comprador = new Array();
                comprador['nombres'] = nombres;
                comprador['apellidos'] = apellidos;
                comprador['direccion'] = direccion;
                comprador['edad'] = edad;
                comprador['correo'] = correo;
                comprador['genero'] = genero;
                comprador['civil'] = civil;
                comprador['profesion'] = profesion;
                comprador['nacionalidad'] = nacionalidad;
                comprador['departamento'] = departamento;
                comprador['dpi'] = dpi;
                comprador['identificacion'] = identificacion;
                comprador['representacion'] = representacion;
                if(representacion == '2'){
                    comprador['calidad'] = calidad;
                    comprador['nombre'] = nombre;
                    comprador['notario'] = notario;
                    comprador['fecha'] = fecha;
                    comprador['registro'] = registro;
                    comprador['folio'] = folio;
                    comprador['libro'] = libro;
                }
                console.log(comprador);
                PasoVer(3);
            }
        }

        var inmueble = new Array();
        function Paso3Validar(){
            var finca = $('#txt_inmueble_finca').val();
            var folio = $('#txt_inmueble_folio').val();
            var libro = $('#txt_inmueble_libro').val();
            var area = $('#txt_inmueble_area').val();
            var direccion = $('#txt_inmueble_direccion').val();
            var proyecto = $('#txt_inmueble_proyecto').val();
            var error = false;
            jQuery('.spn_inmueble_finca').html('');
            jQuery('.spn_inmueble_folio').html('');
            jQuery('.spn_inmueble_libro').html('');
            jQuery('.spn_inmueble_area').html('');
            jQuery('.spn_inmueble_direccion').html('');
            jQuery('.spn_inmueble_proyecto').html('');
            if(finca == ''){
                error = true;
                mensaje_error = 'Ingrese el numero de finca.';
                jQuery('.spn_inmueble_finca').html(mensaje_error);
            }
            if(folio == ''){
                error = true;
                mensaje_error = 'Ingrese el numero de folio.';
                jQuery('.spn_inmueble_folio').html(mensaje_error);
            }
            if(libro == ''){
                error = true;
                mensaje_error = 'Ingrese el numero de libro.';
                jQuery('.spn_inmueble_libro').html(mensaje_error);
            }
            if(area == ''){
                error = true;
                mensaje_error = 'Ingrese el area en metros cuadrados.';
                jQuery('.spn_inmueble_area').html(mensaje_error);
            }
            if(direccion == ''){
                error = true;
                mensaje_error = 'Ingrese la dirección.';
                jQuery('.spn_inmueble_direccion').html(mensaje_error);
            }
            if(proyecto == ''){
                error = true;
                mensaje_error = 'Ingrese el nombre del proyecto inmobiliario.';
                jQuery('.spn_inmueble_proyecto').html(mensaje_error);
            }
            if(error == false){
                inmueble = new Array();
                inmueble['finca'] = finca;
                inmueble['folio'] = folio;
                inmueble['libro'] = libro;
                inmueble['area'] = area;
                inmueble['direccion'] = direccion;
                inmueble['proyecto'] = proyecto;
                console.log(inmueble);
                PasoVer(4);
            }
        }

        var area = new Array();
        function Paso4Validar(){
            var areas = new Array();
            var nombre = '';
            var descripcion = '';
            var error = false;
            jQuery('.spn_area_nombre').html('');
            $('.area').each(function(key, elemento){
                nombre = $(elemento).find('.area_nombre').val();
                descripcion = $(elemento).find('.area_descripcion').val();
                if(nombre != '' && descripcion != ''){
                    areas.push([nombre, descripcion]);
                }
                else{
                    error = true;
                    mensaje_error = 'Debe ingresar el nombre y descripción de cada área.';
                    jQuery('.spn_area_nombre').html(mensaje_error);
                }
            });
            if(error == false){
                PasoVer(5);
                console.log(areas);
            }
        }

        var apartamento = new Array();
        function Paso5Validar(){
            var descripcion = jQuery('#txt_apartamento_descripcion').val();
            var area = jQuery('#txt_apartamento_area').val();
            var metro_valor = jQuery('#txt_apartamento_valor_metro').val();
            var apartamento_accion = jQuery('#txt_apartamento_accion').val();
            var estacionamiento = jQuery('#txt_apartamento_estacionamiento').val();
            var estacionamiento_area = jQuery('#txt_apartamento_estacionamiento_area').val();
            var estacionamiento_metro_valor = jQuery('#txt_apartamento_estacionamiento_valor_metro').val();
            var bodega = jQuery('#txt_apartamento_bodega').val();
            var bodega_area = jQuery('#txt_apartamento_bodega_area').val();
            var bodega_metro_valor = jQuery('#txt_apartamento_bodega_valor_metro').val();
            var acabados_si = jQuery('#txt_apartamento_acabados_si').val();
            var acabados_no = jQuery('#txt_apartamento_acabados_no').val();
            var error = false;
            jQuery('.spn_apartamento_descripcion').html('');
            jQuery('.spn_apartamento_area').html('');
            jQuery('.spn_apartamento_valor_metro').html('');
            jQuery('.spn_apartamento_acabados_si').html('');
            jQuery('.spn_apartamento_acabados_no').html('');
            if(descripcion == ''){
                error = true;
                mensaje_error = 'Ingrese la descripción del apartamento.';
                jQuery('.spn_apartamento_descripcion').html(mensaje_error);
            }
            if(area == ''){
                error = true;
                mensaje_error = 'Ingrese el área en metros cuadrados del apartamento.';
                jQuery('.spn_apartamento_area').html(mensaje_error);
            }
            if(metro_valor == ''){
                error = true;
                mensaje_error = 'Ingrese el valor del metro cuadrado del apartamento.';
                jQuery('.spn_apartamento_valor_metro').html(mensaje_error);
            }
            if(acabados_si == ''){
                error = true;
                mensaje_error = 'Ingrese los acabados que SI incluye.';
                jQuery('.spn_apartamento_acabados_si').html(mensaje_error);
            }
            if(acabados_no == ''){
                error = true;
                mensaje_error = 'Ingrese los acabados que NO incluye.';
                jQuery('.spn_apartamento_acabados_no').html(mensaje_error);
            }
            if(error == false){
                apartamento = new Array();
                var apartamento_valor_total = jQuery('#txt_apartamento_valor_total').val();
                var estacionamiento_valor_total = jQuery('#txt_apartamento_estacionamiento_valor_total').val();
                var bodega_valor_total = jQuery('#txt_apartamento_bodega_valor_total').val();
                apartamento['descripcion'] = descripcion;
                apartamento['area'] = area;
                apartamento['metro_valor'] = metro_valor;
                apartamento['apartamento_valor_total'] = apartamento_valor_total;
                apartamento['apartamento_accion'] = apartamento_accion;
                apartamento['estacionamiento'] = estacionamiento;
                apartamento['estacionamiento_area'] = estacionamiento_area;
                apartamento['estacionamiento_metro_valor'] = estacionamiento_metro_valor;
                apartamento['estacionamiento_valor_total'] = estacionamiento_valor_total;
                apartamento['bodega'] = bodega;
                apartamento['bodega_area'] = bodega_area;
                apartamento['bodega_metro_valor'] = bodega_metro_valor;
                apartamento['bodega_valor_total'] = bodega_valor_total;
                apartamento['acabados_si'] = acabados_si;
                apartamento['acabados_no'] = acabados_no;
                console.log(apartamento);
                PasoVer(6);
            }
        }

        var pago = new Array();
        function Paso6Validar(){
            var pago_forma = jQuery('#txt_pago_forma').val();
            var facturacion = jQuery('#txt_pago_facturacion').val();
            var mora = jQuery('#txt_pago_mora').val();
            var fecha = jQuery('#txt_pago_fecha').val();
            var fecha_firma = jQuery('#txt_pago_fecha_firma').val();
            var multa = jQuery('#txt_pago_multa').val();
            var atraso = jQuery('#txt_pago_atraso').val();
            var error = false;
            jQuery('.spn_pago_forma').html('');
            jQuery('.spn_pago_facturacion').html('');
            jQuery('.spn_pago_mora').html('');
            jQuery('.spn_pago_fecha').html('');
            jQuery('.spn_pago_fecha_firma').html('');
            jQuery('.spn_pago_multa').html('');
            jQuery('.spn_pago_atraso').html('');
            if(pago_forma == ''){
                error = true;
                mensaje_error = 'Ingrese la forma de pago.';
                jQuery('.spn_pago_forma').html(mensaje_error);
            }
            if(facturacion == ''){
                error = true;
                mensaje_error = 'Ingrese la facturación.';
                jQuery('.spn_pago_facturacion').html(mensaje_error);
            }
            if(mora == ''){
                error = true;
                mensaje_error = 'Ingrese el porcentaje anual de recargo por mora.';
                jQuery('.spn_pago_mora').html(mensaje_error);
            }
            if(fecha == ''){
                error = true;
                mensaje_error = 'Ingrese la fecha en que debe formalizarse la escritura de compraventa.';
                jQuery('.spn_pago_fecha').html(mensaje_error);
            }
            if(fecha_firma == ''){
                error = true;
                mensaje_error = 'Ingrese la fecha de firma del contrato.';
                jQuery('.spn_pago_fecha_firma').html(mensaje_error);
            }
            if(multa == ''){
                error = true;
                mensaje_error = 'Ingrese la multa por incumplimiento.';
                jQuery('.spn_pago_multa').html(mensaje_error);
            }
            if(atraso == ''){
                error = true;
                mensaje_error = 'Ingrese el interés applicable al atraso de devolución de fondos.';
                jQuery('.spn_pago_atraso').html(mensaje_error);
            }
            if(error == false){
                pago = new Array();
                var atraso_tipo = jQuery('#slc_pago_tipo').val();
                pago['pago_forma'] = pago_forma;
                pago['facturacion'] = facturacion;
                pago['mora'] = mora;
                pago['fecha'] = fecha;
                pago['fecha_firma'] = fecha_firma;
                pago['multa'] = multa;
                pago['atraso'] = atraso;
                pago['atraso_tipo'] = atraso_tipo;
                console.log(pago);
                ContratoGenerar(1);
            }
        }

        function NacionalidadVerificar(elemento){
        	var nacionalidad = jQuery(elemento).val();
        	if(nacionalidad != 'Guatemalteco' && nacionalidad != 'Guatemalteca'){
        		jQuery(elemento).parent().find('.dpi').html('Pasaporte:');
        	}
        	else{
        		jQuery(elemento).parent().find('.dpi').html('DPI:');
        	}
        	jQuery.ajax({
		        url: "departamentos_obtener",
		        type: 'post',
		        data: {
		        	nacionalidad:nacionalidad,
		        },
		        dataType: 'json',
		        success: function(respuesta) {
		        	jQuery(elemento).parent().find('.slc_patrono_departamento').html(respuesta);
		        },
		        error: function (error){
		            //alert(error);
		        }
		    });
        }

        function ContratoGenerar(regresar){
			if(regresar == 1){
				jQuery('.wrapEditContract').css('display','none');
				jQuery('.ContratoGenerado').css('display','block');
			}
			else{
				jQuery('.wrapEditContract').css('display','block');
				jQuery('.ContratoGenerado').css('display','none');
			}
			var indices = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
			/*VENDEDOR*/
            var vendedor_nombre = vendedor['nombres']+' '+vendedor['apellidos'];
            var vendedor_direccion = vendedor['direccion'];
			var vendedor_edad = NumerosACantidad(vendedor['edad']);
            var vendedor_correo = vendedor['correo'];
			var vendedor_profesion = vendedor['profesion'];
			var vendedor_genero = vendedor['genero'];
            var vendedor_civil = vendedor['civil'];
			var vendedor_nacionalidad = vendedor['nacionalidad'];
			var vendedor_departamento = vendedor['departamento'];
			var vendedor_dpi_numeros = vendedor['dpi'];
			var vendedor_dpi_letras = NumerosALetras(vendedor['dpi']);
            var vendedor_dpi_numeros = vendedor['dpi'];
			var vendedor_calidad = vendedor['calidad'];
            var vendedor_entidad = vendedor['nombre'];
            var vendedor_notario = vendedor['notario'];
            var vendedor_fecha = vendedor['fecha'];
            var vendedor_registro_numeros = vendedor['registro'];
            var vendedor_registro_letras = NumerosALetras(vendedor['registro']);
            var vendedor_folio_numeros = vendedor['folio'];
            var vendedor_folio_letras = NumerosALetras(vendedor['folio']);
            var vendedor_libro_numeros = vendedor['libro'];
            var vendedor_libro_letras = NumerosALetras(vendedor['libro']);
            var vendedor_identificacion = vendedor['identificacion'];
            var texto_identificacion = '';
            if(vendedor_identificacion == 'Pasaporte:'){
                texto_identificacion = 'Pasaporte número <strong>'+vendedor_dpi_letras+'</strong> (<strong>'+vendedor_dpi_numeros+'</strong>)';
            }
            else{
                texto_identificacion = 'Documento Personal de Identificación –DPI- con Código Único de Identificación –CUI- <strong>'+vendedor_dpi_letras+'</strong> (<strong>'+vendedor_dpi_numeros+'</strong>) extendido por el Registrador del Registro Nacional de las Personas';
            }
			var texto_vendedor = 'A) <strong>'+vendedor_nombre+'</strong>, de <strong>'+vendedor_edad+'</strong> años, genero <strong>'+vendedor_genero+'</strong>, <strong>'+vendedor_profesion+'</strong>, <strong>'+vendedor_civil+'</strong>, <strong>'+vendedor_nacionalidad+'</strong>, con domicilio en el departamento de <strong>'+vendedor_departamento+'</strong>, quien se identifica con el '+texto_identificacion+', quién actúo en mi calidad de <strong>'+vendedor_calidad+'</strong> Y REPRESENTANTE LEGAL de la entidad <strong>'+vendedor_entidad+'</strong>, SOCIEDAD ANÓNIMA, lo cual acredito con mi nombramiento contenido en Acta Notarial autorizada en la ciudad de Guatemala, por el Notario <strong>'+vendedor_notario+'</strong>, con fecha <strong>'+vendedor_fecha+'</strong>, inscrita en el Registro Mercantil General de la República bajo registro <strong>'+vendedor_registro_letras+'</strong> (<strong>'+vendedor_registro_numeros+'</strong>), folio <strong>'+vendedor_folio_letras+'</strong> (<strong>'+vendedor_folio_numeros+'</strong>), del libro <strong>'+vendedor_libro_letras+'</strong> (<strong>'+vendedor_libro_numeros+'</strong>) de Auxiliares de Comercio. La entidad <strong>'+vendedor_entidad+'</strong>, SOCIEDAD ANÓNIMA se encuentra inscrita en el Registro Mercantil General de la República bajo registro <strong>'+vendedor_registro_letras+'</strong> (<strong>'+vendedor_registro_numeros+'</strong>), folio <strong>'+vendedor_folio_letras+'</strong> (<strong>'+vendedor_folio_numeros+'</strong>), libro <strong>'+vendedor_libro_letras+'</strong> (<strong>'+vendedor_libro_numeros+'</strong>) de Sociedades Mercantiles y en el curso del presente contrato se le podrá denominar simplemente como “LA PROMITENTE VENDEDORA”. ';
			/*COMPRADOR*/
			var comprador_nombre = comprador['nombres']+' '+comprador['apellidos'];
            var comprador_direccion = comprador['direccion'];
			var comprador_edad = NumerosACantidad(comprador['edad']);
            var comprador_correo = comprador['correo'];
			var comprador_profesion = comprador['profesion'];
			var comprador_genero = comprador['genero'];
            var comprador_civil = comprador['civil'];
			var comprador_nacionalidad = comprador['nacionalidad'];
			var comprador_departamento = comprador['departamento'];
			var comprador_dpi_numeros = comprador['dpi'];
			var comprador_dpi_letras = NumerosALetras(comprador['dpi']);
            var comprador_representacion;
            if(comprador['representacion'] == '1'){
                comprador_representacion = 'quién actúa a título personal. En el curso del presente contrato se le podrá denominar simplemente como el “PROMITENTE COMPRADOR”. ';
            }
            else{
                var comprador_calidad = comprador['calidad'];
                var comprador_entidad = comprador['nombre'];
                var comprador_notario = comprador['notario'];
                var comprador_fecha = comprador['fecha'];
                var comprador_registro_numeros = comprador['registro'];
                var comprador_registro_letras = NumerosALetras(comprador['registro']);
                var comprador_folio_numeros = comprador['folio'];
                var comprador_folio_letras = NumerosALetras(comprador['folio']);
                var comprador_libro_numeros = comprador['libro'];
                var comprador_libro_letras = NumerosALetras(comprador['libro']);
                comprador_representacion = 'quién actúo en mi calidad de <strong>'+comprador_calidad+'</strong> Y REPRESENTANTE LEGAL de la entidad <strong>'+comprador_entidad+'</strong>, SOCIEDAD ANÓNIMA, lo cual acredito con mi nombramiento contenido en Acta Notarial autorizada en la ciudad de Guatemala, por el Notario <strong>'+comprador_notario+'</strong>, con fecha <strong>'+comprador_fecha+'</strong>, inscrita en el Registro Mercantil General de la República bajo registro <strong>'+comprador_registro_letras+'</strong> (<strong>'+comprador_registro_numeros+'</strong>), folio <strong>'+comprador_folio_letras+'</strong> (<strong>'+comprador_folio_numeros+'</strong>), del libro <strong>'+comprador_libro_letras+'</strong> (<strong>'+comprador_libro_numeros+'</strong>) de Auxiliares de Comercio. En el curso del presente contrato se le podrá denominar simplemente como el “PROMITENTE COMPRADOR”.';
            }
            var comprador_identificacion = comprador['identificacion'];
            var texto_identificacion = '';
            if(comprador_identificacion == 'Pasaporte:'){
                texto_identificacion = 'Pasaporte número <strong>'+comprador_dpi_letras+'</strong> (<strong>'+comprador_dpi_numeros+'</strong>)';
            }
            else{
                texto_identificacion = 'Documento Personal de Identificación –DPI- con Código Único de Identificación –CUI- <strong>'+comprador_dpi_letras+'</strong> (<strong>'+comprador_dpi_numeros+'</strong>) extendido por el Registrador del Registro Nacional de las Personas';
            }
			var texto_comprador = 'B) <strong>'+comprador_nombre+'</strong>, de <strong>'+comprador_edad+'</strong> años, genero <strong>'+comprador_genero+'</strong>, <strong>'+comprador_profesion+'</strong>, <strong>'+comprador_civil+'</strong>, <strong>'+comprador_nacionalidad+'</strong>, con domicilio en el departamento de <strong>'+comprador_departamento+'</strong>, quien se identifica con el '+texto_identificacion+', '+comprador_representacion;
			/*INMUEBLE*/
			var inmueble_finca = inmueble['finca'];
			var inmueble_folio = inmueble['folio'];
			var inmueble_libro = inmueble['libro'];
			var inmueble_area = inmueble['area'];
			var inmueble_direccion = inmueble['direccion'];
			var inmueble_proyecto = inmueble['proyecto'];
			var texto_inmueble = 'Manifestamos estar en el libre ejercicio de nuestros derechos civiles y que por este acto hacemos constar que celebramos el presente CONTRATO DE PROMESA DE COMPRAVENTA DE INMUEBLE (S) y ACCIÓN, contenido en las cláusulas siguientes: PRIMERA: ANTECEDENTES. A. DESCRIPCIÓN DEL INNMUEBLE. Manifiesta el señor <strong>'+vendedor_nombre+'</strong>, que su representada es propietaria del siguiente bien inmueble: FINCA <strong>'+inmueble_finca+'</strong>, FOLIO <strong>'+inmueble_folio+'</strong>, LIBRO <strong>'+inmueble_libro+'</strong>, ÁREA <strong>'+inmueble_area+'</strong> metros cuadrados, DIRECCIÓN <strong>'+inmueble_direccion+'</strong>. Dicho inmueble en un futuro se someterá a un Régimen de Propiedad Horizontal en el que se creará el Edificio de Apartamentos denominado <strong>'+inmueble_proyecto+'</strong> (en adelante el Edificio), el cual constará de áreas privadas y elementos comunes (generales y limitados) que serán distribuidos de la siguiente manera:';
            /*AREAS*/
            var areas_conteo = 0;
			var texto_apartamento_areas = '';
			$.each(area, function(indice, valor){
				var area_nombre = valor['nombre'];
                var area_descripcion = valor['descripcion'];
				texto_apartamento_areas += indices[areas_conteo]+') '+area_nombre+': '+area_descripcion+'.';
				areas_conteo++;
			});
            /*DESCRIPCION DEL APARTAMENTO*/
            var apartamento_descripcion = apartamento['descripcion'];
            var apartamento_area = apartamento['area'];
            var apartamento_metro_valor = apartamento['metro_valor'];
            var apartamento_apartamento_valor_total = parseFloat(apartamento['apartamento_valor_total']);
            var apartamento_apartamento_accion = apartamento['apartamento_accion'];
            var apartamento_acabados_si = apartamento['acabados_si'];
            var apartamento_acabados_no = apartamento['acabados_no'];
            var texto_areas = '';
            var texto_areas_iva = '';
            var cantidad_areas = 1;
            var apartamento_total = 0;
            if(apartamento['apartamento_accion']){
                cantidad_areas++;
                var apartamento_accion_total = parseFloat(apartamento_apartamento_accion)*1.03;
                texto_areas += cantidad_areas+'. Una acción que da derecho al propietario a su parte alícuota de las áreas comunes; por un valor de Q. <strong>'+apartamento_apartamento_accion+'</strong>.';
                texto_areas_iva += cantidad_areas+'. ACCIÓN. El precio base de la acción prometida en venta será de Q. <strong>'+apartamento_apartamento_accion+'</strong>, lo que incluyendo el Impuesto de la Ley del Timbre Fiscal y Papel Sellado Especial para Protocolos equivale a precio total de Q. <strong>'+apartamento_accion_total.toFixed(2)+'</strong>.'; 
                apartamento_total += apartamento_accion_total.toFixed(2);
            }
            if(apartamento['estacionamiento_valor_total']){
                cantidad_areas++;
                var apartamento_estacionamiento = apartamento['estacionamiento'];
                var apartamento_estacionamiento_area = apartamento['estacionamiento_area'];
                var apartamento_estacionamiento_metro_valor = apartamento['estacionamiento_metro_valor'];
                var apartamento_estacionamiento_valor_total = apartamento['estacionamiento_valor_total'];
                var apartamento_estacionamiento_total = parseFloat(apartamento_estacionamiento_valor_total)*1.12;
                texto_areas += cantidad_areas+'. '+apartamento_estacionamiento+' Estacionamiento(s), con un área total de <strong>'+apartamento_estacionamiento_area+'</strong> metros cuadrados cada uno; por un valor por metro cuadrado de Q. <strong>'+apartamento_estacionamiento_metro_valor+'</strong>; por un valor de Q. <strong>'+apartamento_estacionamiento_valor_total+'</strong>.';
                texto_areas_iva = cantidad_areas+'. PARQUEOS. El precio base por parqueo será de Q. <strong>'+apartamento_estacionamiento_valor_total+'</strong>, lo que incluyendo el Impuesto al Valor Agregado equivale a precio total de Q. <strong>'+apartamento_estacionamiento_total.toFixed(2)+'</strong>.';
                apartamento_total += apartamento_estacionamiento_total.toFixed(2);
            }
            if(apartamento['bodega_valor_total']){
                cantidad_areas++;
                var apartamento_bodega = apartamento['bodega'];
                var apartamento_bodega_area = apartamento['bodega_area'];
                var apartamento_bodega_metro_valor = apartamento['bodega_metro_valor'];
                var apartamento_bodega_valor_total = apartamento['bodega_valor_total'];
                var apartamento_bodega_total = parseFloat(apartamento_bodega_valor_total)*1.12;
                texto_areas += cantidad_areas+'. '+apartamento_bodega+' Bodega, con un área de <strong>'+apartamento_bodega_area+'</strong> metros cuadrados, por un valor por metro cuadrado de <strong>'+apartamento_bodega_metro_valor+'</strong>, por un de Q. <strong>'+apartamento_bodega_valor_total+'</strong>.';                    
                texto_areas_iva += cantidad_areas+'. BODEGAS. El precio base por bodega será de Q. <strong>'+apartamento_bodega_valor_total+'</strong>, lo que incluyendo el Impuesto al Valor Agregado equivale a precio total de Q. <strong>'+apartamento_bodega_total.toFixed(2)+'</strong>.'; 
                apartamento_total += apartamento_bodega_total.toFixed(2);
            }
            var apartamento_apartamento_valor_total_iva = apartamento_apartamento_valor_total*1.12;
            var apartamento_apartamento_valor_total_total = apartamento_apartamento_valor_total_iva+apartamento_total;
            apartamento_apartamento_valor_total_total = parseFloat(apartamento_apartamento_valor_total_total);
            var texto_apartamento = 'El número de apartamentos, locales comerciales, bodegas y parqueos, sus áreas, la distribución y ubicación podrán variar de conformidad con lo que sea requerido por las autoridades municipales o por reestructuración del diseño del Edificio por parte de LA PROMITENTE VENDEDORA. Para la regulación recíproca de las relaciones de vecindad, así como lo referente a la administración y atención de los servicios comunes se aprobará e incluirá en la Escritura Pública en la que se constituya el Régimen de Propiedad Horizontal el REGLAMENTO DE COPROPIEDAD Y ADMINISTRACIÓN del Edificio. Dentro de las regulaciones con que contará el REGLAMENTO se incluirán las siguientes: a. Obligatoriedad de residentes a regir su conducta según las Normas de Convivencia del Edificio. b. Limitación al derecho de propiedad relativa a la facultad de la administración del Edificio <strong>'+inmueble_proyecto+'</strong> para sancionar e inclusive suspender servicios prestados a residentes/inquilinos por incumplimiento en el pago a las cuotas de mantenimiento y gastos comunes que se defina por la Asamblea de Propietarios. c. Limitación al derecho de propiedad relativa a la facultad de la administración del Edificio <strong>'+inmueble_proyecto+'</strong> para sancionar por violación de las Normas de Convivencia del Edificio. d. Limitación al derecho de propiedad relativa a la obligatoriedad de solicitar a la Junta Directiva autorización para la venta y arrendamiento de los bienes inmuebles sujetos al Régimen de Propiedad Horizontal, de acuerdo a los procedimientos definidos en el Reglamento. e. Reglamentación sobre la forma, tiempo y modo de uso de las instalaciones comunes de acceso limitado. f. Limitaciones razonables sobre horarios de uso de instalaciones comunes, reuniones, volumen de aparatos, y otros que se consideren necesarios y convenientes. El servicio de mantenimiento y conservación de las áreas comunes lo brindará una entidad cuyos accionistas serán los propietarios de las unidades independientes creadas en el Régimen de Propiedad Horizontal. La titularidad de una acción de dicha entidad dará derecho a su propietario a la participación en las decisiones que dicha entidad estipule sobre el uso, mantenimiento y conservación de las áreas comunes, y su tenencia permite el uso de las áreas comunes limitadas del Edificio, de acuerdo a las normas específicas que se reglamentarán. SEGUNDA: DE LA PROMESA DE VENTA DEL APARTAMENTO Y LA ACCIÓN. La PROMITENTE VENDEDORA, PROMETE VENDER a el PROMITENTE COMPRADOR un título de acción y los bienes inmuebles que se describen a continuación de conformidad con las estipulaciones siguientes: A. DESCRIPCIÓN: 1. Apartamento de <strong>'+apartamento_area+'</strong> metros cuadrados, <strong>'+apartamento_descripcion+'</strong>, de conformidad con los planos aprobados por las partes; por un valor por metro cuadrado de <strong>'+apartamento_metro_valor+'</strong>, por un valor de Q. <strong>'+apartamento_apartamento_valor_total+'</strong>; '+texto_areas+' Dentro de las áreas antes descritas se incluyen las áreas de columnas, ducto de instalaciones y soportes estructurales. Las divisiones y acabados con que cuenta el apartamento serán definidas por las partes. Las partes reconocen que el PROMITENTE COMPRADOR, podrá ceder su derecho de compraventa, a una sociedad u a otra persona (siempre y cuando sea aprobada por LA PROMITENTE VENDEDORA), para la firma del contrato final.  B. MODIFICACIONES: Manifiestan ambas partes que el diseño original del proyecto es una ilustración para efectos de explicación y venta. Puede existir una variación en el diseño final, colores y acabados reales de dicho diseño, por lo que no debe interpretarse la información presentada como respaldo al momento de entrega del mismo. El inmueble incluirá los siguientes acabados: <strong>'+apartamento_acabados_si+'</strong>. El inmueble no incluirá lo siguiente: <strong>'+apartamento_acabados_no+'</strong>. En caso el PROMITENTE COMPRADOR lo requiera, se le podrá cotizar estos acabados por separado y las partes deberán acordar precio. Para que LA PROMITENTE VENDEDORA proceda a realizar dichos cambios se deberá contar con autorización y aceptación de las condiciones pactadas en dicha orden de cambio, y deberá haberse cumplido las condiciones de pago. Si los pagos estipulados en la orden de cambio no fueran aceptados, o habiendo sido aceptados no se hubiere cumplido con las condiciones y plazos de pago estipulados, LA PROMITENTE VENDEDORA. cumplirá con la entrega de los inmuebles de conformidad con lo prometido en el documento final de compraventa. Este mismo procedimiento aplicará para cualquier tipo de cambio o modificación solicitado, ya sea que el mismo sea en acabados, tipo de artefactos a instalarse, pisos, cantidad, calidad y ubicación de enchufes, toma-corrientes y cualquier otro tipo de cambio a realizarse al plano original entregado y firmado por este acto. A. PRECIO: El precio de venta sin impuestos será de: Q. <strong>'+apartamento_apartamento_valor_total+'</strong>,  desglosado de la siguiente manera: INMUEBLE. El precio base del inmueble será de Q. <strong>'+apartamento_apartamento_valor_total+'</strong>, lo que incluyendo el Impuesto al Valor Agregado equivale a precio total de Q. <strong>'+apartamento_apartamento_valor_total_iva.toFixed(2)+'</strong>. '+texto_areas_iva+' De tal forma, el precio final, incluyendo impuestos correspondientes será de Q. <strong>'+apartamento_apartamento_valor_total_total.toFixed(2)+'</strong>. De antemano acuerdan las partes que todo aumento en los costos de las materias primas, fuera del control de LA PROMITENTE VENDEDORA (hierro, cemento, entre otros de similar naturaleza) aumentará el precio global de la venta prometida. Al efecto, LA PROMITENTE VENDEDORA deberá avisar, por los medios establecidos en el presente contrato, del aumento en el precio. El PROMITENTE COMPRADOR tendrá cinco días hábiles para manifestar su inconformidad, transcurrido dicho plazo, se tendrá por aceptado el cambio. La inconformidad en el nuevo precio global del inmueble dará derecho al PROMITENTE COMPRADOR de rescindir el presente contrato sin ninguna penalización de su parte, lo cual deberá comunicar expresamente a LA PROMITENTE VENDEDORA y quedando la PROMITENTE VENDEDORA obligada al reintegro de cualquier monto que le hubiere entregado el PROMITENTE COMPRADOR, dentro de los siguientes diez días hábiles. En caso no se haga la devolución en ese período, se entenderá que la PROMITENTE VENDEDORA ha aceptado mantener el precio original. Si el PROMITENTE COMPRADOR solicita financiamiento con el Instituto de Fomento de Hipotecas Aseguradas (FHA) se aumentará el precio global del inmueble de acuerdo a los gastos de cierre que en su momento determine LA PROMITENTE VENDEDORA. Si los pagos fueran en quetzales el tipo de cambio será el tipo de cambio del día de acuerdo al Banco de Guatemala.';
			/*FORMA DE PAGO*/
            var pago_forma = pago['pago_forma'];
            var pago_facturacion = pago['facturacion'];
            var pago_mora_numeros = pago['mora'];
            var pago_mora_letras = NumerosACantidad(pago['mora']);
            var pago_fecha = pago['fecha'];
            var pago_fecha_firma = pago['fecha_firma'];
            var pago_multa_numeros = pago['multa'];
            var pago_multa_letras = NumerosACantidad(pago['multa']);
            var pago_atraso_numeros = pago['atraso'];
            var pago_atraso_letras = NumerosACantidad(pago['atraso']);
            var pago_atraso_tipo = pago['atraso_tipo'];
            var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            var pago_fecha_formateada = NumerosACantidad(pago['fecha'].substring(0,2)) +' de '+meses[parseInt((pago['fecha'].substring(3,5))+1)]+' de '+NumerosACantidad(pago['fecha'].substring(6,10));
            var texto_pago = 'B. FORMA DE PAGO: El precio por los bienes prometidos en venta será pagado en su totalidad por el PROMITENTE COMPRADOR en la forma siguiente: <strong>'+pago_forma+'</strong>. <strong>'+pago_facturacion+'</strong>. C. INTERESES Y MORAS: La suma adeudada por el saldo de la promesa de venta no devengará intereses. Sin embargo, en el caso de que las amortizaciones mensuales pactadas no sean canceladas a más tardar después de los quince días en que debió ser pagada, el recargo por mora será del <strong>'+pago_mora_letras+'</strong> por ciento (<strong>'+pago_mora_numeros+'%</strong>) anual sobre el saldo deudor hasta su pago efectivo. D. PLAZO: El plazo de la presente promesa de compraventa de los inmuebles y acción mencionada vencerá: El <strong>'+pago_fecha_formateada+'</strong>, fecha en la cual se deberá formalizar la escritura de compraventa con el PROMITENTE COMPRADOR, en la cual se establecerán las condiciones de pago aquí establecidas. El plazo del presente contrato podrá a la sola discreción de LA PROMITENTE VENDEDORA prorrogarse hasta por seis (6) meses adicionales al plazo pactado, lo cual se le hará saber al PROMITENTE COMPRADOR a más tardar dos meses previo al vencimiento de la presente promesa de compraventa o sus prorrogas. En este caso, todos los pagos a que el PROMITENTE COMPRADOR se ha obligado contra entrega de los bienes prometidos en venta se deberán realizar en la nueva fecha pactada. Durante el tiempo que le tome PROMITENTE VENDEDOR terminar todo el Edificio y cualquier reparación que pudiera ser necesaria, el PROMITENTE COMPRADOR acepta desde ya lo siguiente: i) Exonera a la Promitente Vendedora de cualquier reclamo por molestias y/o daños que pudiera causarles la presencia de los trabajadores y el desarrollo de las construcciones pendientes; ii) Se compromete a aceptar todas aquellas instalaciones que hubieran de colocarse en el Edificio. iii) Se sujeta a las disposiciones que emita LA PROMITENTE VENDEDORA para asegurar el normal y seguro desarrollo de las actividades de construcción. E. DEL INCUMPLIMIENTO DEL PROMITENTE COMPRADOR: Será causal de incumplimiento de la presente promesa de compraventa por parte del PROMITENTE COMPRADOR, si el mismo no acredita lo siguiente: a) ser titular o haber cancelado totalmente, la acción prometida en venta (sin perjuicio de la posibilidad de ceder la acción a una sociedad). b) Si el PROMITENTE COMPRADOR incumpliere en realizar cualquiera de los pagos a que se ha obligado de conformidad con la presente promesa de compraventa; c) si llegado el vencimiento del plazo de la presente promesa el PROMITENTE COMPRADOR se negare irrazonablemente a suscribir el contrato de compraventa por este acto prometido, y no compareciere a formalizarla el día pactado por las partes para el efecto o se negare injustificadamente a pactar fecha para la firma o c.3) Incumpliere con las obligaciones materiales contraídas en el presente contrato. En caso de incumplimiento del presente contrato LA PROMITENTE VENDEDORA podrá optar por tener por resuelto el contrato por incumplimiento de parte del PROMITENTE COMPRADOR, conservando para si la cantidad de <strong>'+pago_multa_letras+'</strong> (Q. <strong>'+pago_multa_numeros+'</strong>). El resto de las sumas pagadas por cualquier concepto serán devueltas al PROMITENTE COMPRADOR en un plazo que no excederá de un mes (1)  contado a partir de la fecha de que se declare su incumplimiento. Cualquier atraso adicional en la devolución de los montos sujetos a devolución, correrá con un interés de <strong>'+pago_atraso_letras+'</strong> por ciento (<strong>'+pago_atraso_numeros+'</strong>) <strong>'+pago_atraso_tipo+'</strong> hasta que se pague.';
            /*CONTRATO COMPLETO*/
			var fecha = new Date();
			var fecha_actual = NumerosACantidad(fecha.getDate()) + ' de ' + meses[fecha.getMonth()] + ' de ' + fecha.getFullYear()+'.';
            var fecha_firma_formateada = NumerosACantidad(pago['fecha_firma'].substring(0,2)) +' de '+meses[parseInt((pago['fecha_firma'].substring(3,5))+1)]+' de '+pago['fecha_firma'].substring(6,10);
			var contrato_contenido = 'CONTRATO DE PROMESA DE COMPRAVENTA DE INMUEBLE. En la ciudad de Guatemala, el <strong>'+fecha_firma_formateada+'</strong>, Nosotros: '+texto_vendedor+' '+texto_comprador+' '+texto_inmueble+' '+texto_apartamento_areas+' '+texto_apartamento+' '+texto_pago+' En tal evento, las partes quedarán desligadas de toda obligación, sin necesidad de declaratoria judicial alguna.F. DEL INCUMPLIMIENTO DE LA PROMITENTE VENDEDORA: Si fuese la entidad HEROCHA, SOCIEDAD ANÓNIMA quien incumpliese su obligación de otorgar la escritura traslativa de dominio de los inmuebles objeto de la presente promesa de compraventa una vez se haya cancelado el precio pactado y se haya acreditado ser titular o haber cancelado totalmente el precio de la acción. G. ADMINISTRACIÓN DEL RÉGIMEN DE PROPIEDAD HORIZONTAL: Las partes aceptan expresamente que LA PROMITENTE VENDEDORA designará (o podrá designar) en la escritura de constitución del régimen de Propiedad Horizontal a una entidad como el ente administrador del Edificio durante un plazo de veinte años, el cual podrá prorrogarse por los propietarios del Edificio en Asamblea de Condóminos de acuerdo a los procedimientos establecidos en la escritura del Régimen de Propiedad Horizontal. H. PACTO ESPECIAL. Si por alguna razón el Impuesto al Valor Agregado (IVA) o el Impuesto de la Ley del Timbre y Papel Sellado para Protocolos a cancelar por la venta del inmueble (s) y acción prometida fuere ajustado por cambio de legislación o por cambio en los criterios de tributación por parte de la Superintendencia de Administración Tributaria, el PROMITENTE COMPRADOR deberá cancelar el monto de los impuestos ajustados. Esto no obsta para que se planteen las defensas tributarias respectivas a efecto de hacer valer la validez y efectos tributarios de la presente negociación. I. CESIÓN DE DERECHOS: El PROMITENTE COMPRADOR podrá ceder los derechos derivados del presente contrato únicamente con el consentimiento expreso por escrito de el PROMITENTE VENDEDOR. TERCERA: PACTOS PROCESALES Y DIRECCIÓN PARA RECIBIR NOTIFICACIONES. Las partes renuncian al fuero de su domicilio y para cualquier tipo de controversia se someten a los tribunales de la ciudad de Guatemala, departamento de Guatemala. El PROMITENTE COMPRADOR señala como lugar para recibir notificaciones por cualquier acción judicial derivada del presente contrato la siguiente dirección: <strong>'+comprador_direccion+'</strong>. Para efectos de comunicar cualquier información derivada del presente contrato señalo la siguiente dirección de correo electrónico <strong>'+comprador_correo+'</strong>, la cual podrá ser cambiada en cualquier momento por el PROMITENTE COMPRADOR por aviso simple. LA PROMITENTE VENDEDORA señala como lugar para recibir notificación por cualquier acción derivada del presente contrato la siguiente dirección: <strong>'+vendedor_direccion+'</strong>. Para efectos de comunicar cualquier información derivada del presente contrato señalo la siguiente dirección de correo electrónico: <strong>'+vendedor_correo+'</strong>. Las partes acuerdan que cualquier variación a las direcciones anteriormente establecidas deberá comunicarse a la otra parte para que rinda efectos a la otra parte. CUARTA: AUTORIZACIÓN PARA INVESTIGAR: EL PROMITENTE COMPRADOR otorga una autorización irrevocable para que se investigue en los medios que estime conveniente, LA PROMIETENTE COMPRADORA, su perfil financiero y judicial, de forma que autoriza voluntariamente que la información recopilada y/o proporcionada por entidades públicas o privadas y la generada de relaciones contractuales, crediticias o comerciales, sea reportada a centrales de riesgo o burós de crédito para ser tratada, almacenada o transferida; y autoriza expresamente a las centrales de riesgo o burós de crédito a suministrar reportes o estudios que contengan información sobre su persona según artículo 64 Ley de Acceso a la Información Pública. QUINTA: ACEPTACIÓN. Manifestamos que aceptamos expresamente el presente contrato en todas sus partes y cláusulas y en manifestación de nuestra voluntad firmamos este documento en todas sus hojas. Extendemos el presente documento, en dos originales.';
            var $body = $(tinymce.activeEditor.getBody());
			$body.find('p:last').html(contrato_contenido.toString());
			console.log(contrato_contenido);
		}

		function NumerosALetras(numero){
			if(isNaN(numero) == false){
				var letra = [];
					letra[0] = "cero";
					letra[1] = "uno";
					letra[2] = "dos";
					letra[3] = "tres";
					letra[4] = "cuatro";
					letra[5] = "cinco";
					letra[6] = "seis";
					letra[7] = "siete";
					letra[8] = "ocho";
					letra[9] = "nueve";
				var enletras = '';
				var numeroenletra = numero.toString();
				for(var i = 0; i < numeroenletra.length; i++){
					var caracter = numeroenletra.charAt(i);
					enletras += letra[caracter] + ' ';
				}
				return enletras.trim();
			}
			else{
				return 'error';
			}
		}

		var o=new Array("diez", "once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisiete", "dieciocho", "diecinueve", "veinte", "veintiuno", "veintidós", "veintitrés", "veinticuatro", "veinticinco", "veintiséis", "veintisiete", "veintiocho", "veintinueve");
		var u=new Array("cero", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve");
		var d=new Array("", "", "", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa");
		var c=new Array("", "ciento", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos");
		 
		function NumerosACantidad(n){
		  	var n=parseFloat(n).toFixed(2); /*se limita a dos decimales, no sabía que existía toFixed() :)*/
		  	var p=n.toString().substring(n.toString().indexOf(".")+1); /*decimales*/
		  	var m=n.toString().substring(0,n.toString().indexOf(".")); /*número sin decimales*/
		  	var m=parseFloat(m).toString().split("").reverse(); /*tampoco que reverse() existía :D*/
		  	var t="";
		 
		  	/*Se analiza cada 3 dígitos*/
		  	for (var i=0; i<m.length; i+=3){
		    	var x=t;
		    	/*formamos un número de 2 dígitos*/
		    	var b=m[i+1]!=undefined?parseFloat(m[i+1].toString()+m[i].toString()):parseFloat(m[i].toString());
		    	/*analizamos el 3 dígito*/
		    	t=m[i+2]!=undefined?(c[m[i+2]]+" "):"";
		    	t+=b<10?u[b]:(b<30?o[b-10]:(d[m[i+1]]+(m[i]=='0'?"":(" y "+u[m[i]]))));
		    	t=t=="ciento cero"?"cien":t;
		    	if (2<i&&i<6)
		      		t=t=="uno"?"mil ":(t.replace("uno","un")+" mil ");
		    	if (5<i&&i<9)
		      		t=t=="uno"?"un millón ":(t.replace("uno","un")+" millones ");
		    	t+=x;
		    	//t=i<3?t:(i<6?((t=="uno"?"mil ":(t+" mil "))+x):((t=="uno"?"un millón ":(t+" millones "))+x));
		  	}
		  	//t+=" con "+p+"/100";
		  	/*correcciones*/
		  	t=t.replace("  "," ");
		  	t=t.replace(" cero","");
		  	//t=t.replace("ciento y","cien y");
		  	//alert("Numero: "+n+"\nNº Dígitos: "+m.length+"\nDígitos: "+m+"\nDecimales: "+p+"\nt: "+t);
		  	//document.getElementById("esc").value=t;
		  	return t;
		}

        function GeneroVerificar(_socio_genero){
            var genero = jQuery(_socio_genero).val();
            var civil = jQuery(_socio_genero).parent().find('.civil');
            var nacionalidad = jQuery(_socio_genero).parent().find('.nacionalidad');
            if(genero == 'masculino'){
                var civil_opciones = '<option value="Casado">Casado</option>'+
                                        '<option value="Soltero">Soltero</option>'+
                                        '<option value="Divorciado">Divorciado</option>'+
                                        '<option value="Viudo">Viudo</option>';
                jQuery(civil).html(civil_opciones);
                var nacionalidad_opciones = '<option value="Guatemalteco">Guatemalteco</option>'+
                                            '<option value="Beliceño">Beliceño</option>'+
                                            '<option value="Salvadoreño">Salvadoreño</option>'+
                                            '<option value="Hondureño">Hondureño</option>'+
                                            '<option value="Nicaragüense">Nicaragüense</option>'+
                                            '<option value="Costarricense">Costarricense</option>'+
                                            '<option value="Panameño">Panameño</option>';
                jQuery(nacionalidad).html(nacionalidad_opciones);
            }
            else{
                var civil_opciones = '<option value="Casada">Casada</option>'+
                                        '<option value="Soltera">Soltera</option>'+
                                        '<option value="Divorciada">Divorciada</option>'+
                                        '<option value="Viuda">Viuda</option>';
                jQuery(civil).html(civil_opciones);
                var nacionalidad_opciones = '<option value="Guatemalteca">Guatemalteca</option>'+
                                            '<option value="Beliceña">Beliceña</option>'+
                                            '<option value="Salvadoreña">Salvadoreña</option>'+
                                            '<option value="Hondureña">Hondureña</option>'+
                                            '<option value="Nicaragüense">Nicaragüense</option>'+
                                            '<option value="Costarricense">Costarricense</option>'+
                                            '<option value="Panameña">Panameña</option>';
                jQuery(nacionalidad).html(nacionalidad_opciones);
            }
        }

        function RepresentacionCambiar(){
            var representacion = jQuery('#slc_comprador_representacion').val();
            if(representacion == '2'){
                jQuery('#div_comprador_representacion').css('display','block');
            }
            else{
                jQuery('#div_comprador_representacion').css('display','none');
            }
        }

        function AreaAgregar(){
            var area = '<div class="area">'+
                            '<div>Nombre:</div>'+
                            '<span class="spn_area_nombre error"></span>'+
                            '<input type="text" class="tabButton area_nombre">'+
                            '<div>Descripción:</div>'+
                            '<span class="spn_area_descripcion error"></span>'+
                            '<textarea class="col-lg-12 area_descripcion"></textarea>'+
                            '<input type="button" class="fillButton prev" onclick="AreaEliminar(this);" value="Eliminar">'+
                        '</div>';
            jQuery('#div_areas').append(area);
        }

        function AreaEliminar(etiqueta){
            $(etiqueta).parent().remove();
        }

        function ApartamentoPrecio(){
            var area = jQuery('#txt_apartamento_area').val();
            var metro_valor = jQuery('#txt_apartamento_valor_metro').val();
            if(area != '' && metro_valor != ''){
                var total = parseFloat(area)*parseFloat(metro_valor);
                jQuery('#txt_apartamento_valor_total').val(total.toFixed(2));
            }
            else{
                jQuery('#txt_apartamento_valor_total').val('');   
            }
        }
        function EstacionamientoPrecio(){
            var estacionamiento = jQuery('#txt_apartamento_estacionamiento').val();
            var area = jQuery('#txt_apartamento_estacionamiento_area').val();
            var metro_valor = jQuery('#txt_apartamento_estacionamiento_valor_metro').val();
            if(estacionamiento != '' && area != '' && metro_valor != ''){
                var total = parseFloat(area)*parseFloat(metro_valor)*parseFloat(estacionamiento);
                jQuery('#txt_apartamento_estacionamiento_valor_total').val(total.toFixed(2));
            }
            if(estacionamiento == '' || area == '' || metro_valor == ''){
                jQuery('#txt_apartamento_estacionamiento_valor_total').val('');
            }
        }
        function BodegaPrecio(){
            var bodega = jQuery('#txt_apartamento_bodega').val();
            var area = jQuery('#txt_apartamento_bodega_area').val();
            var metro_valor = jQuery('#txt_apartamento_bodega_valor_metro').val();
            if(bodega != '' && area != '' && metro_valor != ''){
                var total = parseFloat(area)*parseFloat(metro_valor)*parseFloat(bodega);
                jQuery('#txt_apartamento_bodega_valor_total').val(total.toFixed(2));
            }
            if(bodega == '' || area == '' || metro_valor == ''){
                jQuery('#txt_apartamento_bodega_valor_total').val('');
            }
        }

        var contrato_guardar = 0;
        var contrato_guardado = 0;
        function ContratoGuardar(){
            $('#elm1').html(tinymce.get('elm1').getContent());      
            var contrato = jQuery('#elm1').val();
            var contrato_id = getURLParameter('c');
            if(contrato != ''){
                jQuery.ajax({
                    url: "contrato_guardar2",
                    type: 'post',
                    data: {
                        contrato:contrato,
                        contrato_id:contrato_id,
                        nombre: jQuery('#txt_contrato_nombre').val()
                    },
                    dataType: 'json',
                    success: function(respuesta) {
                        switch(parseInt(respuesta.res)){
                            case 1:
                                jQuery('#btn_modal_exito').click();
                                contrato_guardar = 1;
                                contrato_guardado = respuesta.contrato_guardado;
                                break;
                            default:
                                jQuery('#div_mensaje_error4').html('Error al guardar el contrato. Intente nuevamente.');
                                break;
                        }
                    },
                    error: function (error){
                        //alert(error);
                    }
                });
            }  
        }

        function ContratoNombreVerificar(){
            var contrato_nombre = jQuery('#txt_contrato_nombre').val();
            if(contrato_nombre != ''){
                jQuery('#btn_nombre_verificar').prop('disabled', true);
                jQuery('#div_mensaje_error4').html('');
                jQuery.ajax({
                    url: "ContratoNombreVerificar",
                    type: 'post',
                    data: {
                        contrato_nombre: contrato_nombre
                    },
                    dataType: 'json',
                    success: function(respuesta) {
                        jQuery('#btn_nombre_verificar').prop('disabled', false);
                        switch(parseInt(respuesta.res)){
                            case 0:
                                jQuery('#btn_nombre_cancelar').click();
                                ContratoGuardar();
                                jQuery('#p_contrato_nombre').hide();
                                break;
                            case 1:
                                jQuery('#div_mensaje_error4').html('Ese nombre de contrato no está disponible. Seleccione uno distinto');
                                //jQuery('#txt_contrato_nombre').val('');
                                break;
                            default:
                                jQuery('#div_mensaje_error4').html('Error de conexión. Intente nuevamente.');
                                break;
                        }
                    },
                    error: function (error){
                        //alert(error);
                    }
                });
            }
            else{
                jQuery('#div_mensaje_error4').html('Ingrese el nombre del contrato.');
            }
        }

        function ValidarNombre(){
            if(contrato_guardar == 0){
                jQuery('#btn_modal_nombre').click();
            }
            else{
                ContratoGuardar();
            }
        }

        function PagoValidar(){
            var tarjeta = jQuery('#tarjeta').val();
            var tarjeta_mes = jQuery('#tarjeta_mes').val();
            var tarjeta_ano = jQuery('#tarjeta_ano').val();
            var tarjeta_cvv = jQuery('#tarjeta_cvv').val();
            var monto = jQuery('#amount').val();
            var factura = jQuery('#txt_nombreFactura').val();
            var correo = jQuery('#txt_correo').val();
            var error = false;
            jQuery('.spn_pago_tarjeta').html('');
            jQuery('.spn_pago_expiracion_mes').html('');
            jQuery('.spn_pago_expiracion_ano').html('');
            jQuery('.spn_pago_cvv').html('');
            jQuery('.spn_pago_monto').html('');
            jQuery('.spn_pago_factura_nombre').html('');
            jQuery('.spn_pago_factura_correo').html('');
            if(tarjeta == ''){
                mensaje_error = 'Ingrese el numero de la tarjeta.';
                jQuery('.spn_pago_tarjeta').html(mensaje_error);
                error =  true;
            }
            if(tarjeta_mes == ''){
                mensaje_error = 'Ingrese el mes de vencimiento de la tarjeta.';
                error =  true;
                jQuery('.spn_pago_expiracion_mes').html(mensaje_error);
            }
            if(tarjeta_ano == ''){
                mensaje_error = 'Ingrese el año de vencimiento de la tarjeta.';
                error =  true;
                jQuery('.spn_pago_expiracion_ano').html(mensaje_error);
            }
            if(tarjeta_cvv == ''){
                mensaje_error = 'Ingrese el codigo CVV de la tarjeta.';
                error =  true;
                jQuery('.spn_pago_cvv').html(mensaje_error);
            }
            if(monto == ''){
                mensaje_error = 'Monto invalido.';
                error =  true;
                jQuery('.spn_pago_monto').html(mensaje_error);
            }
            if(factura == ''){
                mensaje_error = 'Ingrese el nombre para la factura.';
                error =  true;
                jQuery('.spn_pago_factura_nombre').html(mensaje_error);
            }
            if(correo != '' && validateEmail(correo) == false){
                mensaje_error = 'Ingrese el correo valido al que se enviará la factura.';
                error =  true;
                jQuery('.spn_pago_factura_correo').html(mensaje_error);
            }
            if(error == false){
                jQuery('#payment-form').submit();
            }
        }

        function ContratoPagar(regresar){
            if(regresar == 1){
                jQuery('.ContratoGenerado').css('display','none');
                jQuery('#payment-form').css('display','block');
            }
            else{
                jQuery('.ContratoGenerado').css('display','block');
                jQuery('#payment-form').css('display','none');;
            }
        }

        function ContratoGuardadoVer(){
            window.location.href = 'contratos_versiones?c='+contrato_guardado;
        }
	</script>
<?php $this->layout->block(); ?>

<?php $this->layout->block('section-page'); ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
        <h2 class="titleGeneral"><span class="backLevel">Buscar Contratos | Propiedades |</span> <b class="level"><?php echo $contrato_disponible['contrato_disponible']['nombre']?></b></h2>
    </div>
    <form action="" method="POST" id="payment-form" style="display:none;">
        <div class="flex-content">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap" style="padding: 0;">
                <div class="col-lg-12 col-md-8 col-sm-12 col-xs-12">
                    <div class="contentScroll scrollFull generatorContract">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding marginLarge pasos">
                            <div class="formContract">
                                <h2 class="titleGeneral">Información de pago</h2>
                                <span class="payment-errors error"></span>
                                <div>Numero de tarjeta:</div>
                                <span class="spn_pago_tarjeta error"></span>
                                <input type="text" size="20" data-stripe="number" class="registerText contact tabButton" id="tarjeta">
                                <div>Expiración mes(MM):</div>
                                <span class="spn_pago_expiracion_mes error"></span>
                                <input type="text" size="2" data-stripe="exp_month" class="registerText  expiracion tabButton" id="tarjeta_mes">
                                <div>Expiración año(YY):</div>
                                <span class="spn_pago_expiracion_ano error"></span>
                                <input type="text" size="2" data-stripe="exp_year" class="registerText expiracion tabButton" id="tarjeta_ano">
                                <div>CVC:</div>
                                <span class="spn_pago_cvv error"></span>
                                <input type="text" size="4" data-stripe="cvc" class="registerText contact tabButton" id="tarjeta_cvv">
                                <div>Monto:</div>
                                <span class="spn_pago_monto error"></span>
                                <input type="text" size="20" id="amount" name="amount" value="<?php echo $contrato_disponible['contrato_disponible']['precio']?>" class="registerText  contact tabButton" disabled>
                                <div>Nombre factura:</div>
                                <span class="spn_pago_factura_nombre error"></span>
                                <input type="text" size="30" id="txt_nombreFactura" name="txt_nombreFactura" value="" onkeypress="return validar_caracter(event,0);" class="registerText contact tabButton">
                                <div>NIT: (Si lo dejas en blanco es C/F)</div>
                                <span class="spn_pago_factura_nit error"></span>
                                <input type="text" size="30" id="txt_nitFactura" name="txt_nitFactura" value="" class="registerText  contact tabButton" >
                                <div>Correo: (Si lo dejas en blanco se enviara al correo registrado)</div>
                                <span class="spn_pago_factura_correo error"></span>
                                <input type="text" size="30" id="txt_correo" name="txt_correo" value="" class="registerText  contact tabButton" >
                                <!--<div class="form-row">
                                    <label>
                                        <span>Codigo Zip</span>
                                        <input type="text" size="6" data-stripe="address_zip" class="registerText  contact" id="tarjeta_zip">
                                    </label>
                                </div>-->
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
                                    <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">
                                        <!--input class="fillButton prev" type="submit" value="Anterior"-->
                                        <input type="button" id="btn_submitPago" class="reservation pago fillButton" value="Regresar" onclick="ContratoPagar(0);"/>
                                    </div>              
                                    <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">
                                        <input type="button" id="btn_submitPago" class="reservation pago fillButton prev" value="Confirmar pago" onclick="PagoValidar();"/>
                                        <!--input class="fillButton" type="button" value="Siguiente" onclick="Paso1Validar();"-->
                                    </div>              
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <p>Ingrese la información solicitada. </p>
    <div class="flex-content">
    	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap wrapEditContract">
    		<div class="col-lg-9 col-md-8 col-sm-9 col-xs-12">
    			<div class="contentScroll scrollFull generatorContract">
    				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding marginLarge pasos">
    					<div class="formContract paso" id="div_paso1">
    						<span class="legendForm">Paso 1</span>
    						<h2 class="titleGeneral">Vendedor</h2>
    			          	<div id="div_vendedor_paso1">
    			          		<div id="div_mensaje_error1" class="mensaje_error"></div>
    				          	<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 vendedor_paso1">
    								<div>Nombres:</div>
                                    <span class="spn_vendedor_nombres error"></span>
    								<input type="text" class="tabButton" id="txt_vendedor_nombres" onkeypress="return validar_caracter(event, 0);">
    								<div>Apellidos:</div>
                                    <span class="spn_vendedor_apellidos error"></span>
    								<input type="text" class="tabButton"  id="txt_vendedor_apellidos" onkeypress="return validar_caracter(event, 0);">
    								<div>Dirección:</div>
                                    <span class="spn_vendedor_direccion error"></span>
                                    <input type="text" class="tabButton"  id="txt_vendedor_direccion">
                                    <div>Edad:</div>
                                    <span class="spn_vendedor_edad error"></span>
    								<input type="text" class="tabButton"  id="txt_vendedor_edad" onkeypress="return validar_caracter(event, 1);" maxlength="3">
    								<div>Correo Electrónico:</div>
                                    <span class="spn_vendedor_correo error"></span>
                                    <input type="text" class="tabButton"  id="txt_vendedor_correo">
                                    <div>Género:</div>
                                    <select id="slc_vendedor_genero" class="genero select-bg" onchange="GeneroVerificar(this);">
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                    </select>
                                    <div>Estado Civil:</div>
    								<select id="slc_vendedor_civil" class="civil select-bg">
    									<option value="Casado">Casado</option>
    									<option value="Soltero">Soltero</option>
    									<option value="Divorciado">Divorciado</option>
    									<option value="Viudo">Viudo</option>
    								</select>
    								<div>Profesion:</div>
                                    <span class="spn_vendedor_profesion error"></span>
    								<input type="text" class="tabButton" id="txt_vendedor_profesion" onkeypress="return validar_caracter(event, 0);">
    								<div>Nacionalidad:</div>
    								<select id="slc_vendedor_nacionalidad" onchange="NacionalidadVerificar(this);" class="nacionalidad select-bg">
    								<?php
    									echo $html_paises;
    								?>
    								</select>
    								<div>Departamento de domicilio:</div>
    								<select id="slc_vendedor_departamento" class="slc_patrono_departamento select-bg">
    								<?php
    									echo $html_departamentos;
    								?>
    								</select>
    								<div class="vendedor_dpi dpi">DPI:</div>
                                    <span class="spn_vendedor_dpi error"></span>
    								<input type="text" class="tabButton" id="txt_vendedor_dpi" onkeypress="return validar_caracter(event, 1);">
    								<div>Actúa a en su calidad de:</div>
    								<select id="slc_vendedor_calidad" class="select-bg"> 
    									<option value="Presidente del Consejo de Administración">Presidente del Consejo de Administración</option>
    									<option value="Administrador Único">Administrador Único</option>
                                        <option value="Gerente General">Gerente General</option>
    								</select>
                                    <div>Información de la entidad</div>    
                                    <div>Nombre:</div>
                                    <span class="spn_vendedor_nombre error"></span>
                                    <input type="text" class="tabButton" id="txt_vendedor_nombre">
                                    <div>Notario:</div>
                                    <span class="spn_vendedor_notario error"></span>
                                    <input type="text" class="tabButton"  id="txt_vendedor_notario" onkeypress="return validar_caracter(event, 0);">
                                    <div>Fecha de nombramiento (dd/mm/aaaa):</div>
                                    <span class="spn_vendedor_fecha error"></span>
                                    <input type="text" class="tabButton" id="txt_vendedor_fecha">
                                    <div>Registro Mercantil:</div>
                                    <span class="spn_vendedor_registro error"></span>
                                    <input type="text" class="tabButton"  id="txt_vendedor_registro" onkeypress="return validar_caracter(event, 1);">
                                    <div>Folio:</div>
                                    <span class="spn_vendedor_folio error"></span>
                                    <input type="text" class="tabButton"  id="txt_vendedor_folio" onkeypress="return validar_caracter(event, 1);">
                                    <div>Libro:</div>
                                    <span class="spn_vendedor_libro error"></span>
                                    <input type="text" class="tabButton"  id="txt_vendedor_libro" onkeypress="return validar_caracter(event, 1);">
    							</div>
    						</div>
    						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
    							<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">
    								<!--input class="fillButton prev" type="submit" value="Anterior"-->
    							</div>				
    							<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">
    								<input class="fillButton" type="button" value="Siguiente" onclick="Paso1Validar();">
    							</div>				
    						</div>
    					</div>
    					<div class="formContract paso" id="div_paso2" style="display:none;">
    						<span class="legendForm">Paso 2</span>
    						<h2 class="titleGeneral">Comprador</h2>
    			          	<div id="div_patrono_paso2">
    			          		<div id="div_mensaje_error2" class="mensaje_error"></div>
    				          	<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 comprador_paso2">
                                    <div>Nombres:</div>
                                    <span class="spn_comprador_nombres error"></span>
                                    <input type="text" class="tabButton" id="txt_comprador_nombres" onkeypress="return validar_caracter(event, 0);">
                                    <div>Apellidos:</div>
                                    <span class="spn_comprador_apellidos error"></span>
                                    <input type="text" class="tabButton"  id="txt_comprador_apellidos" onkeypress="return validar_caracter(event, 0);">
                                    <div>Dirección:</div>
                                    <span class="spn_comprador_direccion error"></span>
                                    <input type="text" class="tabButton"  id="txt_comprador_direccion">
                                    <div>Edad:</div>
                                    <span class="spn_comprador_edad error"></span>
                                    <input type="text" class="tabButton"  id="txt_comprador_edad" onkeypress="return validar_caracter(event, 1);" maxlength="3">
                                    <div>Correo Electrónico:</div>
                                    <span class="spn_comprador_correo error"></span>
                                    <input type="text" class="tabButton"  id="txt_comprador_correo">
                                    <div>Género:</div>
                                    <select id="slc_comprador_genero" class="genero select-bg" onchange="GeneroVerificar(this);">
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                    </select>
                                    <div>Estado Civil:</div>
                                    <select id="slc_comprador_civil" class="civil select-bg">
                                        <option value="Casado">Casado</option>
                                        <option value="Soltero">Soltero</option>
                                        <option value="Divorciado">Divorciado</option>
                                        <option value="Viudo">Viudo</option>
                                    </select>
                                    <div>Profesion:</div>
                                    <span class="spn_comprador_profesion error"></span>
                                    <input type="text" class="tabButton" id="txt_comprador_profesion" onkeypress="return validar_caracter(event, 0);">
                                    <div>Nacionalidad:</div>
                                    <select id="slc_comprador_nacionalidad" onchange="NacionalidadVerificar(this);" class="nacionalidad select-bg">
                                    <?php
                                        echo $html_paises;
                                    ?>
                                    </select>
                                    <div>Departamento de domicilio:</div>
                                    <select id="slc_comprador_departamento" class="slc_patrono_departamento select-bg">
                                    <?php
                                        echo $html_departamentos;
                                    ?>
                                    </select>
                                    <div class="comprador_dpi dpi">DPI:</div>
                                    <span class="spn_comprador_dpi error"></span>
                                    <input type="text" class="tabButton" id="txt_comprador_dpi" onkeypress="return validar_caracter(event, 1);">
                                    <div>¿Actúa a título personal o en representación de una sociedad?</div>
                                    <select id="slc_comprador_representacion" onchange="RepresentacionCambiar();" class="select-bg">
                                        <option value="1">Personal</option>
                                        <option value="2">Representación</option>
                                    </select>
                                    <div id="div_comprador_representacion" style="display:none;">
                                        <div>Información de la entidad</div>    
                                        <div>Nombre:</div>
                                        <span class="spn_comprador_nombre error"></span>
                                        <input type="text" class="tabButton" id="txt_comprador_nombre" onkeypress="return validar_caracter(event, 0);">
                                        <div>Actúa a en su calidad de:</div>
                                        <select id="slc_comprador_calidad" class="select-bg"> 
                                            <option value="Presidente del Consejo de Administración">Presidente del Consejo de Administración</option>
                                            <option value="Administrador Único">Administrador Único</option>
                                            <option value="Gerente General">Gerente General</option>
                                        </select>
                                        <div>Notario:</div>
                                        <span class="spn_comprador_notario error"></span>
                                        <input type="text" class="tabButton"  id="txt_comprador_notario" onkeypress="return validar_caracter(event, 0);">
                                        <div>Fecha de nombramiento (dd/mm/aaaa):</div>
                                        <span class="spn_comprador_fecha error"></span>
                                        <input type="text" class="tabButton" id="txt_comprador_fecha">
                                        <div>Registro Mercantil:</div>
                                        <span class="spn_comprador_registro error"></span>
                                        <input type="text" class="tabButton"  id="txt_comprador_registro" onkeypress="return validar_caracter(event, 1);">
                                        <div>Folio:</div>
                                        <span class="spn_comprador_folio error"></span>
                                        <input type="text" class="tabButton"  id="txt_comprador_folio" onkeypress="return validar_caracter(event, 1);">
                                        <div>Libro:</div>
                                        <span class="spn_comprador_libro error"></span>
                                        <input type="text" class="tabButton"  id="txt_comprador_libro" onkeypress="return validar_caracter(event, 1);">
                                    </div>
    							</div>
    						</div>
    						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
    							<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">
    								<input class="fillButton prev" type="button" value="Anterior" onclick="PasoVer(1);">
    							</div>				
    							<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">
    								<input class="fillButton" type="button" value="Siguiente" onclick="Paso2Validar();">
    							</div>				
    						</div>
    					</div>
    					<div class="formContract paso" id="div_paso3" style="display:none;">
    						<span class="legendForm">Paso 3</span>
    						<h2 class="titleGeneral">Información general del inmueble</h2>
    			          	<div id="div_informacion_paso3">
    			          		<div id="div_mensaje_error3" class="mensaje_error"></div>
    				          	<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 inmueble_paso3">
                                    <div>Finca:</div>
                                    <span class="spn_inmueble_finca error"></span>
                                    <input type="text" class="tabButton" id="txt_inmueble_finca" onkeypress="return validar_caracter(event, 1);">
                                    <div>Folio:</div>
                                    <span class="spn_inmueble_folio error"></span>
                                    <input type="text" class="tabButton"  id="txt_inmueble_folio" onkeypress="return validar_caracter(event, 1);">
                                    <div>Libro:</div>
                                    <span class="spn_inmueble_libro error"></span>
                                    <input type="text" class="tabButton"  id="txt_inmueble_libro" onkeypress="return validar_caracter(event, 1);">
                                    <div>Area (Metros cuadrados):</div>
                                    <span class="spn_inmueble_area error"></span>
                                    <input type="text" class="tabButton"  id="txt_inmueble_area" onkeypress="return validar_caracter(event, 1);">
                                    <div>Direccion:</div>
                                    <span class="spn_inmueble_direccion error"></span>
                                    <input type="text" class="tabButton"  id="txt_inmueble_direccion">
                                    <div>Nombre del proyecto inmobiliario:</div>
                                    <span class="spn_inmueble_proyecto error"></span>
                                    <input type="text" class="tabButton"  id="txt_inmueble_proyecto">
    							</div>
    						</div>
    						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
    							<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">
    								<input class="fillButton prev" type="button" value="Anterior" onclick="PasoVer(2);">
    							</div>				
    							<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">
    								<input class="fillButton" type="button" value="Siguiente" onclick="Paso3Validar();">
    							</div>
    						</div>
    					</div>
                        <div class="formContract paso" id="div_paso4" style="display:none;">
                            <span class="legendForm">Paso 4</span>
                            <h2 class="titleGeneral">Areas del inmueble</h2>
                            <div id="div_areas_paso4">
                                <div id="div_mensaje_error4" class="mensaje_error"></div>
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 descripcion_paso4">
                                    <div class="area">
                                        <div>Nombre:</div>
                                        <span class="spn_area_nombre error"></span>
                                        <input type="text" class="tabButton area_nombre">
                                        <div>Descripción:</div>
                                        <span class="spn_area_descripcion error"></span>
                                        <textarea class="col-lg-12 area_descripcion"></textarea>
                                        <input type="button" onclick="AreaAgregar();" class="fillButton prev" value="Agregar">
                                    </div>
                                    <div id="div_areas"></div>    
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
                                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">
                                    <input class="fillButton prev" type="button" value="Anterior" onclick="PasoVer(3);">
                                </div>              
                                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">
                                    <input class="fillButton" type="button" value="Siguiente" onclick="Paso4Validar();">
                                </div>
                            </div>
                        </div>
                        <div class="formContract paso" id="div_paso5" style="display:none;">
                            <span class="legendForm">Paso 5</span>
                            <h2 class="titleGeneral">Descripción del apartamento</h2>
                            <div id="div_descripcion_paso5">
                                <div id="div_mensaje_error5" class="mensaje_error"></div>
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 descripcion_paso5">    
                                    <div>Descripción:</div>
                                    <span class="spn_apartamento_descripcion error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_descripcion">
                                    <div>Area (Metros cuadrados):</div>
                                    <span class="spn_apartamento_area error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_area" onchange="ApartamentoPrecio();" onkeypress="return validar_caracter(event, 2);">
                                    <div>Precio por metro cuadrado:</div>
                                    <span class="spn_apartamento_valor_metro error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_valor_metro" onchange="FormatoMoneda(this); ApartamentoPrecio();" onkeypress="return validar_caracter(event, 2);">
                                    <div>Precio:</div>
                                    <span class="spn_apartamento_valor_total error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_valor_total" onchange="FormatoMoneda(this);" onkeypress="return validar_caracter(event, 2);" disabled>
                                    <div>Valor de la Acción:</div>
                                    <span class="spn_apartamento_accion error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_accion" onchange="FormatoMoneda(this);" onkeypress="return validar_caracter(event, 2);">
                                    <div>Número de estacionamientos:</div>
                                    <span class="spn_apartamento_estacionamiento error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_estacionamiento" onchange="EstacionamientoPrecio();" onkeypress="return validar_caracter(event, 1);">
                                    <div>Area de cada estacionamiento (Metros cuadrados):</div>
                                    <span class="spn_apartamento_estacionamiento_area error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_estacionamiento_area" onchange="EstacionamientoPrecio();" onkeypress="return validar_caracter(event, 2);">
                                    <div>Precio por metro cuadrado de estacionamiento:</div>
                                    <span class="spn_apartamento_estacionamiento_valor_metro error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_estacionamiento_valor_metro" onchange="FormatoMoneda(this); EstacionamientoPrecio();" onkeypress="return validar_caracter(event, 2);">
                                    <div>Valor Total de estacionamiento:</div>
                                    <span class="spn_apartamento_estacionamiento_valor_total error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_estacionamiento_valor_total" onchange="FormatoMoneda(this);" onkeypress="return validar_caracter(event, 2);" disabled>
                                    <div>Número de bodegas:</div>
                                    <span class="spn_apartamento_bodega error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_bodega" onchange="BodegaPrecio();" onkeypress="return validar_caracter(event, 1);">
                                    <div>Area de cada bodega (Metros cuadrados):</div>
                                    <span class="spn_apartamento_bodega_area error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_bodega_area" onchange="BodegaPrecio();" onkeypress="return validar_caracter(event, 2);">
                                    <div>Precio por metro cuadrado de bodega:</div>
                                    <span class="spn_apartamento_bodega_valor_metro error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_bodega_valor_metro" onchange="FormatoMoneda(this); BodegaPrecio();" onkeypress="return validar_caracter(event, 2);">
                                    <div>Valor Total de bodegas:</div>
                                    <span class="spn_apartamento_bodega_valor_total error"></span>
                                    <input type="text" class="tabButton" id="txt_apartamento_bodega_valor_total" onchange="FormatoMoneda(this);" onkeypress="return validar_caracter(event, 2);" disabled>      
                                    <div>Acabados que SI incluye:</div>
                                    <span class="spn_apartamento_acabados_si error"></span>
                                    <textarea class="tabButton" id="txt_apartamento_acabados_si" cols="70"></textarea>
                                    <div>Acabados que NO incluye:</div>
                                    <span class="spn_apartamento_acabados_no error"></span>
                                    <textarea class="tabButton" id="txt_apartamento_acabados_no" cols="70"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
                                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">
                                    <input class="fillButton prev" type="button" value="Anterior" onclick="PasoVer(4);">
                                </div>              
                                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">
                                    <input class="fillButton" type="button" value="Siguiente" onclick="Paso5Validar();">
                                </div>
                            </div>
                        </div>
                        <div class="formContract paso" id="div_paso6" style="display:none;">
                            <span class="legendForm">Paso 6</span>
                            <h2 class="titleGeneral">Forma de Pago</h2>
                            <div id="div_descripcion_paso6">
                                <div id="div_mensaje_error6" class="mensaje_error"></div>
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 pago_paso6">
                                    <div>Forma de pago:</div>
                                    <span class="spn_pago_forma error"></span>
                                    <textarea class="tabButton" id="txt_pago_forma" cols="70"></textarea>
                                    <div>Facturación:</div>
                                    <span class="spn_pago_facturacion error"></span>
                                    <textarea class="tabButton" id="txt_pago_facturacion" cols="70"></textarea> 
                                    <div>Porcentaje anual de recargo por mora:</div>
                                    <span class="spn_pago_mora error"></span>
                                    <input type="text" class="tabButton" id="txt_pago_mora" onchange="FormatoMoneda(this);" onkeypress="return validar_caracter(event, 2);">
                                    <div>Fecha en que debe formalizarse la escritura de compraventa (dd/mm/aaaa):</div>
                                    <span class="spn_pago_fecha error"></span>
                                    <input type="text" class="tabButton" id="txt_pago_fecha">
                                    <div>Fecha de Firma (dd/mm/aaaa):</div>
                                    <span class="spn_pago_fecha_firma error"></span>
                                    <input type="text" class="tabButton" id="txt_pago_fecha_firma">
                                    <div>Multa por incumplimiento:</div>
                                    <span class="spn_pago_multa error"></span>
                                    <input type="text" class="tabButton" id="txt_pago_multa" onchange="FormatoMoneda(this);" onkeypress="return validar_caracter(event, 2);">
                                    <div>Interés applicable al atraso de devolución de fondos:</div>
                                    <span class="spn_pago_atraso error"></span>
                                    <input type="text" class="tabButton" id="txt_pago_atraso" onchange="FormatoMoneda(this);" onkeypress="return validar_caracter(event, 2);">
                                    <div>Tipo de interés aplicable al atraso:</div>
                                    <select id="slc_pago_tipo" class="select-bg">
                                        <option value="mensual">Mensual</option>
                                        <option value="anual">Anual</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
                                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">
                                    <input class="fillButton prev" type="button" value="Anterior" onclick="PasoVer(5);">
                                </div>              
                                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">
                                    <input class="fillButton" type="button" value="Siguiente" onclick="Paso6Validar();">
                                </div>
                            </div>
                        </div>
    				</div>
    			</div>
    		</div>
    		<div class="col-lg-3 col-md-4 col-sm-3 col-xs-12 lineCircle">
    			<div class="contentCircle">
    				<div class="circle item1C active" id="item1C">1</div>
    				<div class="circle item2C" id="item2C">2</div>
    				<div class="circle item3C" id="item3C">3</div>
                    <div class="circle item4C" id="item4C">4</div>
                    <div class="circle item5C" id="item5C">5</div>
                    <div class="circle item6C" id="item6C">6</div>
    			</div>
    			<div class="contentText">
    				<span class="textCircle item1TC active" id="item1TC">Vendedor</span>
    				<span class="textCircle item2TC" id="item2TC">Comprador</span>
    				<span class="textCircle item3TC" id="item3TC">Información General del Inmueble</span>
                    <span class="textCircle item4TC" id="item4TC">Areas del Inmueble</span>
                    <span class="textCircle item5TC" id="item5TC">Descripción del Apartamento</span>
                    <span class="textCircle item6TC" id="item6TC">Forma de pago</span>
    			</div>
    		</div>
        </div>
	</div>
	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap wrapEditContract ContratoGenerado" style="display:none;">
		<h2 class="titleGeneral"><span class="backLevel">Contrato de Compraventa|</span> <b class="level">Contrato Generado</b></h2>
		<div class="form-group">
			<textarea id="elm1" name="elm1" cols="40" rows="10" wrap="hard"></textarea>
		</div>
        <input class="fillButton" type="button" value="Pagar y guardar" onclick="ContratoPagar(1);">
        <input class="fillButton" type="button" value="Regresar" onclick="ContratoGenerar(0);">
	</div>
    <input class="fillButton" type="button" id="btn_modal_nombre" value="Nombre" data-toggle="modal" href="#mdl_contrato_nombre" style="display:none;">
	<div class="modal fade" id="mdl_contrato_nombre" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div id="div_mensaje_error4" class="mensaje_error"></div>
                    <p class="marginLarge legend-Contract" id="p_contrato_nombre">
                        Ingrese el nombre del contrato
                        <input type="text" id="txt_contrato_nombre" value="<?php echo $contrato_disponible['contrato_disponible']['contrato_tipo'].date('Y-m-d');?>">
                    </p>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <a href="#">
                                <input type="submit" id="btn_nombre_cancelar" value="Cancelar" class="buttonLightbox" data-dismiss="modal" style="display:none;">
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <input type="button" id="btn_nombre_verificar" value="Aceptar" class="buttonLightbox" data-dismiss="modal" onclick="ContratoNombreVerificar();">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input class="fillButton" type="button" id="btn_modal_exito" value="Exito" data-toggle="modal" href="#mdl_contrato_exito" style="display:none;">
    <div class="modal fade" id="mdl_contrato_exito" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div id="div_mensaje_error5" class="mensaje_error"></div>
                    <p class="marginLarge legend-Contract" id="p_contrato_nombre">
                        Contrato guardado exitosamente.
                    </p>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding marginLarge">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <input type="submit" id="btn_exito_cancelar" value="Aceptar" class="buttonLightbox" data-dismiss="modal" onclick="ContratoGuardadoVer();">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script>
  		tinymce.init({
          	selector: "textarea#elm1",
	         plugins: [
				    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
				    'searchreplace wordcount visualblocks visualchars code fullscreen',
				    'insertdatetime media nonbreaking save table contextmenu directionality',
				    'emoticons template paste textcolor colorpicker textpattern imagetools'
				  ],
      		theme: 'modern',			 	
			height:"250px",
			width:"100%",
			toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				toolbar2: 'print preview media | forecolor backcolor emoticons',
       		image_advtab: true,
			templates: [
			    { title: 'Test template 1', content: 'Test 1' },
			    { title: 'Test template 2', content: 'Test 2' }
			  ],
			content_css: [
			    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
			    '//www.tinymce.com/css/codepen.min.css'
			  ]
		});
		
		jQuery("#txt_vendedor_fecha").mask("99/99/9999");
        jQuery("#txt_comprador_fecha").mask("99/99/9999");
        jQuery("#txt_pago_fecha").mask("99/99/9999");
        jQuery("#txt_pago_fecha_firma").mask("99/99/9999");
	</script>
<?php $this->layout->block(); ?>
