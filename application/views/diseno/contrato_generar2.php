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
        .Nocopia{
            -webkit-user-select: none;
            -moz-user-select: -moz-none;
            -ms-user-select: none;
            user-select: none;
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

            jQuery('body').attr('oncopy','return false');
            jQuery('body').attr('oncut','return false');
            jQuery('body').attr('onpaste','return false');
            jQuery('body').find('iframe').find('body').attr('oncopy', 'return false');
            jQuery('body').find('iframe').find('body').attr('oncut', 'return false');
            jQuery('body').find('iframe').find('body').attr('onpaste', 'return false');
        });

	    function ServicioAgregar(){
	    	var html_servicio = '<div class="servicios">'+
									'<div>Obligaciones o servicios:</div>'+
                                    '<span class="spn_requerimiento_servicio error"></span>'+
									'<input type="text" class="tabButton servicio" style="width:94%;">'+
									'<button onclick="ServicioEliminar(this);" style="margin-left:4px;">x</button>'+
								'</div>';
			jQuery('#div_servicios').append(html_servicio);
	    }

	    function ServicioEliminar(etiqueta){
	    	$(etiqueta).parent().remove();
	    }

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

        var patrono = new Array();
        function Paso1Validar(){
            var nombres = $('#txt_patrono_nombres').val();
            var apellidos = $('#txt_patrono_apellidos').val();
            var edad = $('#txt_patrono_edad').val();
            var civil = $('#slc_patrono_civil').val();
            var genero = $('#slc_patrono_genero').val();
            var profesion = $('#txt_patrono_profesion').val();
            var nacionalidad = $('#slc_patrono_nacionalidad').val();
            var departamento = $('#slc_patrono_departamento').val();
            var dpi = $('#txt_patrono_dpi').val();
            var identificacion = $('.patrono_dpi').html();
            var representacion = $('#slc_patrono_representacion').val();
            var error = false;
            jQuery('.spn_patrono_nombres').html('');
            jQuery('.spn_patrono_apellidos').html('');
            jQuery('.spn_patrono_edad').html('');
            jQuery('.spn_patrono_profesion').html('');
            jQuery('.spn_patrono_departamento').html('');
            jQuery('.spn_patrono_dpi').html('');
            jQuery('.spn_patrono_sociedad').html('');
            if(nombres == ''){
                error = true;
                mensaje_error = 'Ingrese los nombres del patrono.';
                jQuery('.spn_patrono_nombres').html(mensaje_error);
            }
            if(apellidos == ''){
                error = true;
                mensaje_error = 'Ingrese los apellidos del patrono.';
                jQuery('.spn_patrono_apellidos').html(mensaje_error);
            }
            if(edad == ''){
                error = true;
                mensaje_error = 'Ingrese la edad del patrono.';
                jQuery('.spn_patrono_edad').html(mensaje_error);
            }
            if(profesion == ''){
                error = true;
                mensaje_error = 'Ingrese la profesion del patrono.';
                jQuery('.spn_patrono_profesion').html(mensaje_error);
            }
            if(departamento == ''){
                error = true;
                mensaje_error = 'Ingrese el departamento del patrono.';
                jQuery('.spn_patrono_departamento').html(mensaje_error);
            }
            if(dpi == ''){
                error = true;
                mensaje_error = 'Ingrese el DPI del patrono.';
                jQuery('.spn_patrono_dpi').html(mensaje_error);
            }
            if(representacion == '2'){
            	var puesto = jQuery('#slc_patrono_puesto').val();
            	var sociedad = jQuery('#txt_patrono_sociedad').val();
	            if(sociedad == ''){
                	error = true;
	                mensaje_error = 'Ingrese el nombre de la sociedad.';
                    jQuery('.spn_patrono_sociedad').html(mensaje_error);
	            }
            }
            if(error == false){
                patrono = new Array();
                patrono['nombres'] = nombres;
                patrono['apellidos'] = apellidos;
                patrono['edad'] = edad;
                patrono['genero'] = genero;
                patrono['civil'] = civil;
                patrono['profesion'] = profesion;
                patrono['nacionalidad'] = nacionalidad;
                patrono['departamento'] = departamento;
                patrono['dpi'] = dpi;
                patrono['identificacion'] = identificacion;
                if(representacion == '1'){
	            	patrono['representacion'] = '1';
	            }
	            else{
	            	patrono['representacion'] = '2';
	            	patrono['puesto'] = puesto;
	            	patrono['sociedad'] = sociedad;
	            }
				console.log(patrono);
                PasoVer(2);
            }
        }

        var trabajador = new Array();
        function Paso2Validar(){
            var nombres = $('#txt_trabajador_nombres').val();
            var apellidos = $('#txt_trabajador_apellidos').val();
            var edad = $('#txt_trabajador_edad').val();
            var profesion = $('#txt_trabajador_profesion').val();
            var dpi = $('#txt_trabajador_dpi').val();
            var error = false;
            jQuery('.spn_trabajador_nombres').html('');
            jQuery('.spn_trabajador_apellidos').html('');
            jQuery('.spn_trabajador_edad').html('');
            jQuery('.spn_trabajador_profesion').html('');
            jQuery('.spn_trabajador_departamento').html('');
            jQuery('.spn_trabajador_dpi').html('');
            if(nombres == ''){
                error = true;
                mensaje_error = 'Ingrese los nombres del trabajador.';
                jQuery('.spn_trabajador_nombres').html(mensaje_error);
            }
            if(apellidos == ''){
                error = true;
                mensaje_error = 'Ingrese los apellidos del trabajador.';
                jQuery('.spn_trabajador_apellidos').html(mensaje_error);
            }
            if(edad == ''){
                error = true;
                mensaje_error = 'Ingrese la edad del trabajador.';
                jQuery('.spn_trabajador_edad').html(mensaje_error);
            }
            if(profesion == ''){
                error = true;
                mensaje_error = 'Ingrese la profesion del trabajador.';
                jQuery('.spn_trabajador_profesion').html(mensaje_error);
            }
            if(departamento == ''){
                error = true;
                mensaje_error = 'Ingrese el departamento del trabajador.';
                jQuery('.spn_trabajador_departamento').html(mensaje_error);
            }
            if(dpi == ''){
                error = true;
                mensaje_error = 'Ingrese el DPI del trabajador.';
                jQuery('.spn_trabajador_dpi').html(mensaje_error);
            }
            if(error == false){
                trabajador = new Array();
                var civil = $('#slc_trabajador_civil').val();
            	var nacionalidad = $('#slc_trabajador_nacionalidad').val();
            	var departamento = $('#slc_trabajador_departamento').val();
                var identificacion = $('.trabajador_dpi').html();
            	var genero = $('#slc_trabajador_genero').val();
                trabajador['nombres'] = nombres;
                trabajador['apellidos'] = apellidos;
                trabajador['edad'] = edad;
                trabajador['genero'] = genero;
                trabajador['civil'] = civil;
                trabajador['profesion'] = profesion;
                trabajador['nacionalidad'] = nacionalidad;
                trabajador['departamento'] = departamento;
                trabajador['dpi'] = dpi;
                trabajador['identificacion'] = identificacion;
				console.log(trabajador);
                PasoVer(3);
            }
        }

        var requerimiento = new Array();
        function Paso3Validar(){
            var puesto = $('#txt_requerimiento_puesto').val();
            var jornada_inicio = $('#txt_requerimiento_jornada_inicio').val();
            var jornada_fin = $('#txt_requerimiento_jornada_fin').val();
            var salario = $('#txt_requerimiento_salario').val();
            var direccion = $('#txt_requerimiento_direccion').val();
            var fecha = $('#txt_requerimiento_fecha').val();
            var error = false;
            jQuery('.spn_requerimiento_puesto').html('');
            jQuery('.spn_requerimiento_jornada_inicio').html('');
            jQuery('.spn_requerimiento_jornada_fin').html('');
            jQuery('.spn_requerimiento_salario').html('');
            jQuery('.spn_requerimiento_direccion').html('');
            jQuery('.spn_requerimiento_fecha').html('');
            jQuery('.spn_requerimiento_servicio').html('');
            if(puesto == ''){
                error = true;
                mensaje_error = 'Ingrese el puesto del trabajador.';
                jQuery('.spn_requerimiento_puesto').html(mensaje_error);
            }
            if(jornada_inicio == ''){
                error = true;
                mensaje_error = 'Ingrese la hora inicial de la jornada.';
                jQuery('.spn_requerimiento_jornada_inicio').html(mensaje_error);
            }
            if(jornada_fin == ''){
                error = true;
                mensaje_error = 'Ingrese la hora final de la jornada.';
                jQuery('.spn_requerimiento_jornada_fin').html(mensaje_error);
            }
            if(salario == ''){
                error = true;
                mensaje_error = 'Ingrese el salario acordado.';
                jQuery('.spn_requerimiento_salario').html(mensaje_error);
            }
            if(direccion == ''){
                error = true;
                mensaje_error = 'Ingrese la direccion donde se prestarán los servicios.';
                jQuery('.spn_requerimiento_direccion').html(mensaje_error);
            }
            if(fecha == ''){
                error = true;
                mensaje_error = 'Ingrese la fecha de inicio de relación de trabajo.';
                jQuery('.spn_requerimiento_fecha').html(mensaje_error);
            }
            var servicios = new Array();
	    	var servicio;
	    	var error_servicios = true;
        	$('.servicios').each(function(key, elemento){
        		servicio = $(elemento).find('.servicio').val();
        		if(servicio != ''){
        			servicios.push(servicio);
        			error_servicios = false;
        		}
        	});
        	if(error_servicios == true){
                error = true;
                mensaje_error = 'Debe ingresar al menos una obligación o servicio.';
                jQuery('.spn_requerimiento_servicio').html(mensaje_error);
            }
            if(error == false){
               	requerimiento = new Array();
                var forma_pago = $('#slc_requerimiento_forma_pago').val();
            	var intelectual = $('#slc_requerimiento_intelectual').val();
                requerimiento['puesto'] = puesto;
                requerimiento['servicios'] = servicios;
                requerimiento['jornada_inicio'] = jornada_inicio;
                requerimiento['jornada_fin'] = jornada_fin;
                requerimiento['salario'] = salario;
                requerimiento['forma_pago'] = forma_pago;
                requerimiento['direccion'] = direccion;
                requerimiento['fecha'] = fecha;
                requerimiento['intelectual'] = intelectual;
				console.log(requerimiento);
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
			console.log(patrono);
			console.log(trabajador);
			console.log(requerimiento);
			if(regresar == 1){
				jQuery('.wrapEditContract').css('display','none');
				jQuery('.ContratoGenerado').css('display','block');
			}
			else{
				jQuery('.wrapEditContract').css('display','block');
				jQuery('.ContratoGenerado').css('display','none');
			}
			var indices = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
			/*PATRONO*/
			var patrono_nombre = patrono['nombres']+' '+patrono['apellidos'];
			var patrono_edad = NumerosACantidad(patrono['edad']);
			var patrono_profesion = patrono['profesion'];
			var patrono_genero = patrono['genero'];
            var patrono_civil = patrono['civil'];
			var patrono_nacionalidad = patrono['nacionalidad'];
			var patrono_departamento = patrono['departamento'];
			var patrono_dpi_numeros = patrono['dpi'];
			var patrono_dpi_letras = NumerosALetras(patrono['dpi']);
			var patrono_representacion;
			if(patrono['representacion'] == '1'){
				patrono_representacion = 'quién actúa a título personal. A la persona anteriormente identificada podrá denominársele como "el Patrono". ';
			}
			else{
				var patrono_puesto = patrono['puesto'];
				var patrono_sociedad = patrono['sociedad'];
				patrono_representacion = 'actúo en mi calidad de <strong>'+patrono_puesto+'</strong> y Representante Legal de la entidad <strong>'+patrono_sociedad+'</strong>. A la entidad anteriormente identificada podrá denominársele como "el Patrono". ';
			}
            var patrono_identificacion = patrono['identificacion'];
            var texto_identificacion = '';
            if(patrono_identificacion == 'Pasaporte:'){
                texto_identificacion = 'Pasaporte número <strong>'+patrono_dpi_letras+'</strong> (<strong>'+patrono_dpi_numeros+'</strong>)';
            }
            else{
                texto_identificacion = 'Documento Personal de Identificación –DPI- con Código Único de Identificación –CUI- <strong>'+patrono_dpi_letras+'</strong> (<strong>'+patrono_dpi_numeros+'</strong>) extendido por el Registrador del Registro Nacional de las Personas';
            }
			var texto_patrono = 'a) Por un lado, A) <strong>'+patrono_nombre+'</strong>, de <strong>'+patrono_edad+'</strong> años, genero <strong>'+patrono_genero+'</strong>, <strong>'+patrono_profesion+'</strong>, <strong>'+patrono_civil+'</strong>, <strong>'+patrono_nacionalidad+'</strong>, con domicilio en el departamento de <strong>'+patrono_departamento+'</strong>, quien se identifica con el '+texto_identificacion+', '+patrono_representacion;
			/*TRABAJADOR*/
			var trabajador_nombre = trabajador['nombres']+' '+trabajador['apellidos'];
			var trabajador_edad = NumerosACantidad(trabajador['edad']);
			var trabajador_profesion = trabajador['profesion'];
			var trabajador_genero_original = trabajador['genero'];
            var trabajador_civil = trabajador['civil'];
			var trabajador_nacionalidad = trabajador['nacionalidad'];
			var trabajador_departamento = trabajador['departamento'];
			var trabajador_dpi_numeros = trabajador['dpi'];
			var trabajador_dpi_letras = NumerosALetras(trabajador['dpi']);
			if(trabajador['genero'] == 'masculino'){
				var trabajador_genero = 'El trabajador';
				var trabajador_contratado = 'contratado';
			}
			else{
				var trabajador_genero = 'La trabajadora';
				var trabajador_contratado = 'contratada';
			}
            var trabajador_identificacion = trabajador['identificacion'];
            var texto_identificacion = '';
            if(trabajador_identificacion == 'Pasaporte:'){
                texto_identificacion = 'Pasaporte número <strong>'+trabajador_dpi_letras+'</strong> (<strong>'+trabajador_dpi_numeros+'</strong>)';
            }
            else{
                texto_identificacion = 'Documento Personal de Identificación –DPI- con Código Único de Identificación –CUI- <strong>'+trabajador_dpi_letras+'</strong> (<strong>'+trabajador_dpi_numeros+'</strong>) extendido por el Registrador del Registro Nacional de las Personas';
            }
			var texto_trabajador = 'b) Por el otro lado, <strong>'+trabajador_nombre+'</strong>, de <strong>'+trabajador_edad+'</strong> años, genero <strong>'+trabajador_genero_original+'</strong>, <strong>'+trabajador_profesion+'</strong>, <strong>'+trabajador_civil+'</strong>, <strong>'+trabajador_nacionalidad+'</strong>, con domicilio en el departamento de <strong>'+trabajador_departamento+'</strong>, quien se identifica con el '+texto_identificacion+', y actúo a título personal. A la persona anteriormente identificada se le podrá denominar como "'+trabajador_genero+'"';
			/*REQUERIMIENTOS*/
			var requerimiento_puesto = requerimiento['puesto'];
			var requerimiento_jornada_inicio = requerimiento['jornada_inicio'];
			var requerimiento_jornada_fin = requerimiento['jornada_fin'];
			var requerimiento_salario_numeros = requerimiento['salario'];
			var requerimiento_salario_letras = NumerosACantidad(parseInt(requerimiento['salario']));
			var requerimiento_bono_numeros = parseFloat(requerimiento['salario'])+parseFloat('250.00');
			var requerimiento_bono_letras = NumerosACantidad(parseInt(requerimiento_bono_numeros));
			var requerimiento_forma_pago = requerimiento['forma_pago'];
			var requerimiento_direccion = requerimiento['direccion'];
			var requerimiento_fecha = requerimiento['fecha'];
			var requerimiento_intelectual = requerimiento['intelectual'];
			if(requerimiento_intelectual == '0'){
				var texto_requerimiento_intelectual = 'DÉCIMA TERCERA.  LEYES APLICABLES A LA RELACIÓN. Las leyes aplicables a esta relación, tanto en materia sustantiva como procesal, serán las guatemaltecas, salvo que durante la vigencia del presente contrato se acordare entre las partes que '+trabajador_genero+' preste sus servicios en forma definitiva y no transitoria fuera de este territorio. En este último evento las leyes sustantivas y procesales a aplicar a esta relación de trabajo serán las vigentes en el país o localidad de que se trate. DÉCIMA CUARTA. MODIFICACIONES AL CONTRATO DE TRABAJO. El Patrono y '+trabajador_genero+', por este medio convienen que en cualquier momento podrán, de mutuo acuerdo modificar las condiciones de trabajo pactadas entre ambos, apoyados para ello en los términos relacionados en el artículo 20 del Código de Trabajo. Será innecesario documentar cualquier cambio de condición que mejore las condiciones previstas en este contrato. DÉCIMA QUINTA. Aceptación.  Ambas partes, en la calidad con que actúan declaran que están de acuerdo con todas y cada una de las cláusulas y condiciones que se desarrollan en el presente contrato y lo suscriben, el cual en conjunto firmamos. El presente contrato se suscribe en dos copias, uno para '+trabajador_genero+' y una para el Patrono.';
			}
			else{
				var texto_requerimiento_intelectual = 'DÉCIMA TERCERA. PROPIEDAD INTELECTUAL. Manifiestan las partes que por la clase de servicios que serán brindados por '+trabajador_genero+', éste de tiempo en tiempo y conforme los requerimientos del patrono, desarrollará “obras inéditas” o “invenciones”, “desarrollo de productos nuevos”  que pueden consistir en contribuciones e invenciones, descubrimientos, creaciones, desarrollos, mejoras, trabajos de autoría e ideas (ya sean patentables o registrables u en cualquier otro producto del trabajo, sujetas a la tutela por las leyes de propiedad intelectual e industrial vigentes en la República de Guatemala o que sean protegibles bajo las normas de derecho común, por lo que en tales casos '+trabajador_genero+' por éste acto  expresa e incondicionalmente cede a favor del Patrono todos los derechos patrimoniales que del desarrollo de la obra  o invención mencionada se deriven, expresamente renunciando a cualquier reclamo, uso, derecho y demás situaciones relacionadas, pudiendo en tal virtud el Patrono ejercer todos los derechos que conforme a la ley correspondan, comprometiéndose además '+trabajador_genero+' a no divulgar ni de ninguna forma coadyuvar al desarrollo de similares invenciones u obras por parte de terceros, debiendo mantener el desarrollo realizado bajo estricta confidencialidad. '+trabajador_genero+' expresamente se compromete a colaborar con el Patrono a efecto de realizar cualquier gestión incluyendo el registro o protección del producto, a efecto de lograr la efectiva de protección de los derechos que al patrono pudieran corresponderle. Este compromiso de cesión de derechos será aplicable también a cualquier desarrollo que '+trabajador_genero+' realice derivado de la relación laboral o por información que haya obtenido con motivo del desarrollo de la misma, aún y cuando el desarrollo no sea directamente relacionado a los servicios prestados al patrono, debiendo en tales poner en conocimiento de éste el desarrollo de la obra o invención de que se trate. DÉCIMA CUARTA.  LEYES APLICABLES A LA RELACIÓN. Las leyes aplicables a esta relación, tanto en materia sustantiva como procesal, serán las guatemaltecas, salvo que durante la vigencia del presente contrato se acordare entre las partes que '+trabajador_genero+' preste sus servicios en forma definitiva y no transitoria fuera de este territorio. En este último evento las leyes sustantivas y procesales a aplicar a esta relación de trabajo serán las vigentes en el país o localidad de que se trate. DÉCIMA QUINTA. MODIFICACIONES AL CONTRATO DE TRABAJO. El Patrono y '+trabajador_genero+', por este medio convienen que en cualquier momento podrán, de mutuo acuerdo modificar las condiciones de trabajo pactadas entre ambos, apoyados para ello en los términos relacionados en el artículo 20 del Código de Trabajo. Será innecesario documentar cualquier cambio de condición que mejore las condiciones previstas en este contrato. DÉCIMA SEXTA. Aceptación.  Ambas partes, en la calidad con que actúan declaran que están de acuerdo con todas y cada una de las cláusulas y condiciones que se desarrollan en el presente contrato y lo suscriben, el cual en conjunto firmamos. El presente contrato se suscribe en dos copias, uno para '+trabajador_genero+' y una para el Patrono.';
			}
			var servicios_conteo = 0;
			var texto_servicios = '';
			$.each(requerimiento['servicios'], function(indice, valor){
				var requerimiento_servicio = valor;
				texto_servicios += indices[servicios_conteo]+') '+requerimiento_servicio+'. ';
				servicios_conteo++;
			});
			/*CONTRATO COMPLETO*/
			var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			var fecha = new Date();
			var fecha_actual = NumerosACantidad(fecha.getDate()) + ' de ' + meses[fecha.getMonth()] + ' de ' + fecha.getFullYear()+'.';
			var contrato_contenido = 'CONTRATO DE TRABAJO '+texto_patrono+texto_trabajador+'I. Requerimientos del Patrono.  EL PATRONO declara que para desarrollar sus actividades requiriere de personal capacitado para ocupar el puesto de <strong>'+requerimiento_puesto+'</strong> y cuyas funciones, atribuciones, retribuciones y otras condiciones propias de la relación de trabajo se enumeran más adelante; habiendo dispuesto elegir para ocupar dicho cargo a '+trabajador_genero+'. II. Declaración de '+trabajador_genero+'. '+trabajador_genero+' declara que cuenta con los conocimientos y la experiencia necesaria para cubrir el puesto de <strong>'+requerimiento_puesto+'</strong> que requiere el Patrono, motivo por el cual y con anterioridad a este acto, solicitó la asignación del mismo. III. Del Contrato de trabajo: Con apoyo en las declaraciones que anteceden, ambas partes están de acuerdo en celebrar CONTRATO INDIVIDUAL DE TRABAJO POR TIEMPO INDEFINIDO sujeto a las condiciones y estipulaciones contractuales relacionadas en las siguientes, CLÁUSULAS: PRIMERA. DE LA EXCLUSIVIDAD, CONFIDENCIALIDAD Y NO DIVULGACIÓN DE SECRETOS. '+trabajador_genero+' prestará sus servicios bajo la dirección, subordinación y dependencia económica continuada del Patrono, comprometiéndose a cumplir las órdenes e instrucciones que se le den en relación a su trabajo contratado. En términos del artículo 18 del Código de Trabajo '+trabajador_genero+' se compromete a, salvo con la autorización por escrito del Patrono, no trabajar mientras dure la relación de trabajo para una empresa de igual o similar actividad a la de su Patrono. Las Partes convienen en que para los efectos de este contrato se entenderá como “secreto o información confidencial no divulgable” cualquier tipo de información verbal, escrita, auditiva o de cualquier naturaleza que conozca '+trabajador_genero+' con motivo de la relación laboral y que al divulgarse o ser utilizarlos para beneficios personales de '+trabajador_genero+' o de terceros distintos al Patrono, puede causar daños o perjuicios a este último. De esa cuenta las partes convienen que la información confidencial que sea suministrada o a la cual tenga acceso '+trabajador_genero+' con motivo de la relación laboral no deberá ser revelada a terceras personas, sino con autorización expresa del Patrono, debiendo '+trabajador_genero+' guardar estricto cuidado para evitar que la Información Confidencial sea divulgada a terceros no autorizados y siendo responsable de cualquier omisión o acción que permita el acceso de terceros no autorizados a la citada Información Confidencial. Igualmente queda convenido que '+trabajador_genero+' no podrá utilizar la información confidencial para beneficio personal o para cualquier otra finalidad distinta a la requerida en virtud de este Acuerdo y la relación que del mismo nace. Éste compromiso de no divulgación de información tendrá efectos tanto “durante” la vigencia de la relación de trabajo como “al terminar” ésta. Si la divulgación de esa información o conocimientos confidenciales se hiciere “durante” la vigencia del contrato de trabajo, ese hecho constituirá causal adicional suficiente para dar por terminada la relación de trabajo sin responsabilidad atribuible al Patrono, sin perjuicio de que este último inicie las acciones judiciales que correspondan a efecto de reparar el daño que causó la divulgación de esa información. Si la divulgación ocurre “luego de terminada la relación de trabajo” el Patrono podrá iniciar las acciones que correspondan a efecto de lograr la reparación del daño y/o perjuicio causado. SEGUNDA. DE LOS SERVICIOS. '+trabajador_genero+' ocupará el puesto de <strong>'+requerimiento_puesto+'</strong>. Los servicios que prestará '+trabajador_genero+' en favor del patrono son los que se describen a continuación en forma enunciativa y no limitativa: <strong>'+texto_servicios+'</strong> TERCERA. DE LA INEXISTENCIA DE INTERMEDIARIOS. '+trabajador_genero+' declara que al inicio de la presente relación no intervino persona individual o jurídica alguna a la que pueda darse la calidad de intermediario y si así quisiera denunciarse en un futuro, con la sola presentación de este contrato en juicio o fuera de él será suficiente para separar o excluir a éstos o éste de cualquier reclamación formulada en su contra, lo cual acepta y ratifica en este acto '+trabajador_genero+' al firmar el presente contrato. CUARTA: JORNADA ORDINARIA DE TRABAJO. La jornada de trabajo se regirá como lo establece el Código de Trabajo y en especial el artículo 149 de dicho cuerpo legal. '+trabajador_genero+' es '+trabajador_contratado+' para que preste sus servicios en jornada ordinaria diurna en un horario de <strong>'+requerimiento_jornada_inicio+'</strong> a <strong>'+requerimiento_jornada_fin+'</strong> horas, sin embargo, '+trabajador_genero+' podrá prestar sus servicios en otro tipo de jornadas u horarios, siempre y cuando el patrono le comunique con la anticipación debida el cambio de la misma y respetando las jornadas legales establecidas para este tipo de contratos. QUINTA: DEL SALARIO Y BONIFICACIÓN INCENTIVO. Por los servicios que prestará '+trabajador_genero+' a favor del Patrono se conviene entre las partes que éste devengará un salario mensual de <strong>'+requerimiento_salario_letras+'</strong> quetzales (<strong>'+requerimiento_salario_numeros+'</strong>). El Salario será pagado a partir de esta fecha por parte del Patrono. Las partes pactan que '+trabajador_genero+' devengará la correspondiente Bonificación Incentivo para trabajadores del sector privado, la cual es de un monto de DOSCIENTOS CINCUENTA QUETZALES (Q.250.00) y será pagada junto con el salario en el lugar de la prestación de los servicios contra presentación y firma del recibo contable respectivo, de tal forma que el monto efectivamente percibido mensualmente por '+trabajador_genero+' será de <strong>'+requerimiento_bono_letras+'</strong> quetzales (<strong>'+requerimiento_bono_numeros.toFixed(2)+'</strong>). Se conviene entre las partes que el pago de salarios y otras prestaciones de ley podrán ser efectuados mediante cheque, efectivo o mediante depósitos bancarios en la o las cuentas bancarias que '+trabajador_genero+' tenga en los bancos del sistema, para lo cual '+trabajador_genero+' da su pleno consentimiento e indicará al Patrono los datos de la cuenta a la cual podrán hacerse los depósitos. Se conviene entre las partes que dicho salario mensual será pagado a '+trabajador_genero+', en la proporción que corresponda, en forma '+requerimiento_forma_pago+'. SEXTA. DEL LUGAR DE PRESTACIÓN DE LOS SERVICIOS. '+trabajador_genero+' prestará sus servicios en la siguiente dirección <strong>'+requerimiento_direccion+'</strong>. Así también se conviene que '+trabajador_genero+' prestará sus servicios en cualquier otro lugar que se le indique en forma escrita o verbal, tanto dentro como fuera del territorio guatemalteco. De esto '+trabajador_genero+' desde ya da su consentimiento claro y expreso al firmar el presente contrato. SÉPTIMA. DEL PERÍODO VACACIONAL. '+trabajador_genero+' tendrá derecho a gozar de un período vacacional remunerado luego de un año de servicios continuos; dicho período será de quince (15) días hábiles. A partir de hoy la entidad el Patrono queda facultada a señalar a '+trabajador_genero+' la época en que dentro de los sesenta (60) días siguientes a aquel en que se cumplió el año de servicios continuos debe gozar efectivamente de sus vacaciones. Las faltas injustificadas de asistencia al trabajo no se descontarán del período vacacional, salvo que se hayan pagado a '+trabajador_genero+'.  Para el cálculo del salario que '+trabajador_genero+' debe recibir con motivo de sus vacaciones, se seguirá lo ordenado en el artículo 134 del Código de Trabajo. OCTAVA. DEL PAGO DE AGUINALDO ANUAL.  El Patrono a partir del día de hoy queda obligado a pagar a '+trabajador_genero+' en concepto de aguinaldo para trabajadores del sector privado, el equivalente al cien por ciento (100%) del salario ordinario mensual que éste haya devengado por un año de servicios continuos o la parte proporcional correspondiente. Dicho aguinaldo podrá ser pagado en un cien por ciento dentro de la primera quincena del mes de diciembre de cada año o bien pagado en un cincuenta por ciento (50%) en la primera quincena del mes de diciembre y el cincuenta por ciento (50%) restante en el mes de enero siguiente y todo a elección del Patrono. NOVENA. DEL PAGO DE LA BONIFICACIÓN ANUAL PARA LOS TRABAJADORES DEL SECTOR PRIVADO Y PÚBLICO (BONO 14). El Patrono queda obligada a partir del día de hoy a efectuar un pago, en concepto de bonificación anual para trabajadores del sector privado y público equivalente a un salario ordinario que devengue '+trabajador_genero+'. Para la determinación del procedimiento de cálculo de esta prestación se estará a lo que al efecto disponga la ley. Dicha bonificación se hará efectiva durante la primera quincena del mes de julio de cada año. DÉCIMA. DEL INICIO DE LA RELACIÓN DE TRABAJO. Aun cuando la relación de trabajo queda documentada el día de hoy, se deja constancia que la relación de trabajo es efectiva desde el <strong>'+requerimiento_fecha+'</strong>; de manera que para una eventual terminación de la relación de trabajo será considerada esa fecha para efecto de pago de las prestaciones que correspondan. DÉCIMA PRIMERA. FORMAS DE TERMINAR LA RELACIÓN DE TRABAJO. El presente contrato podrá darse por terminado al concurrir cualquiera de los siguientes supuestos: 1. Mutuo acuerdo. En este caso '+trabajador_genero+' tendrá derecho únicamente a percibir sus prestaciones irrenunciables y algún eventual pago adicional que derive de ese acuerdo. 2. Por renuncia de '+trabajador_genero+'. En este caso '+trabajador_genero+' tendrá derecho únicamente a percibir sus prestaciones irrenunciables. 3. Por disposición unilateral del patrono. En este caso el Patrono estará obligado al pago de prestaciones irrenunciables e indemnización si '+trabajador_genero+' fuera despedido injustamente. Si '+trabajador_genero+' es despedido por haber incurrido en causal justa de acuerdo a la ley o este Acuerdo, que faculta para dar por terminada la relación laboral sin responsabilidad de su parte, el Patrono quedará liberado de toda responsabilidad de pago de suma indemnizatoria. 4. Por cualquiera de la forma que contempla la ley y el presente contrato. DÉCIMA SEGUNDA. CAUSAS JUSTAS DE TERMINACIÓN DEL CONTRATO. Además de otras causas de terminación de la relación de trabajo contempladas en las leyes ordinarias del país, el incumplimiento a las disposiciones, condiciones y estipulaciones aquí pactadas o que en un futuro se concierten, serán causas suficientes para que El Patrono pueda dar por terminado el contrato de trabajo, sin necesidad de declaración judicial previa o a demandar e iniciar las acciones que correspondan por la trasgresión  a las estipulaciones aquí contenidas. Además de las obligaciones contraídas por '+trabajador_genero+' en el presente contrato, este tendrá las siguientes: Ser puntual, Obrar con Respeto, Obrar con Sinceridad, Obrar con Honestidad, Obrar con Buena Fe, Obrar con Diligencia, Obrar con Cordialidad, Velar por el bienestar del Patrono, No hablar mal del Patrono o personas relacionadas con el mismo. El incumplimiento por parte '+trabajador_genero+' de las obligaciones antes transcritas, así como de cualquier otra establecida en el presente contrato de trabajo y el Código de Trabajo, constituirá FALTA GRAVE que facultara a dar por terminado el contrato de trabajo con causa justa y sin responsabilidad alguna atribuible al Patrono conforme lo dispone el artículo 77 inciso “k” del Código de Trabajo.'+texto_requerimiento_intelectual+' Ciudad de Guatemala, '+fecha_actual;
			var $body = $(tinymce.activeEditor.getBody());
            $body.addClass('Nocopia');
            contrato_contenido += '<style type="text/css">'+
                                        '.Nocopia{'+
                                            '-webkit-user-select: none;'+
                                            '-moz-user-select: -moz-none;'+
                                            '-ms-user-select: none;'+
                                            'user-select: none;'+
                                        '}'+
                                    '</style>';
			$body.find('p:last').html(contrato_contenido.toString());
			//jQuery('#elm1').html(contrato_contenido.toString());
			//jQuery('.contentCondition').html(contrato_contenido);
			console.log(contrato_contenido);
			//jQuery('#btn_modal').click();
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

		function RepresentacionCambiar(){
			var representacion = jQuery('#slc_patrono_representacion').val();
			if(representacion == '2'){
				jQuery('#div_patrono_representacion').css('display','block');
			}
			else{
				jQuery('#div_patrono_representacion').css('display','none');
			}
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
                                jQuery('#div_mensaje_error4').html('Ese nombre de contrato no está disponible. Ingrese uno distinto');
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
    						<h2 class="titleGeneral">Patrono</h2>
    			          	<div id="div_patrono_paso1">
    			          		<div id="div_mensaje_error1" class="mensaje_error"></div>
    				          	<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 patrono_paso1">
    								<div>Información del patrono</div>	
    								<div>Nombres:</div>
                                    <span class="spn_patrono_nombres error"></span>
    								<input type="text" class="tabButton" id="txt_patrono_nombres" onkeypress="return validar_caracter(event, 0);">
    								<div>Apellidos:</div>
                                    <span class="spn_patrono_apellidos error"></span>
    								<input type="text" class="tabButton"  id="txt_patrono_apellidos" onkeypress="return validar_caracter(event, 0);">
    								<div>Edad:</div>
                                    <span class="spn_patrono_edad error"></span>
    								<input type="text" class="tabButton"  id="txt_patrono_edad" onkeypress="return validar_caracter(event, 1);">
    								<div>Género:</div>
                                    <select id="slc_patrono_genero" class="genero select-bg" onchange="GeneroVerificar(this);">
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                    </select>
                                    <div>Estado Civil:</div>
    								<select id="slc_patrono_civil" class="civil select-bg">
    									<option value="Casado">Casado</option>
    									<option value="Soltero">Soltero</option>
    									<option value="Divorciado">Divorciado</option>
    									<option value="Viudo">Viudo</option>
    								</select>
    								<div>Profesion:</div>
                                    <span class="spn_patrono_profesion error"></span>
    								<input type="text" class="tabButton" id="txt_patrono_profesion" onkeypress="return validar_caracter(event, 0);">
    								<div>Nacionalidad:</div>
    								<select id="slc_patrono_nacionalidad" onchange="NacionalidadVerificar(this);" class="nacionalidad select-bg">
    								<?php
    									echo $html_paises;
    								?>
    								</select>
    								<div>Departamento de domicilio:</div>
                                    <span class="spn_patrono_departamento error"></span>
    								<select id="slc_patrono_departamento" class="slc_patrono_departamento select-bg">
    								<?php
    									echo $html_departamentos;
    								?>
    								</select>
    								<div class="patrono_dpi dpi">DPI:</div>
                                    <span class="spn_patrono_dpi error"></span>
    								<input type="text" class="tabButton" id="txt_patrono_dpi" onkeypress="return validar_caracter(event, 1);">
    								<div>¿Actúa a título personal o en representación de una sociedad?</div>
    								<select id="slc_patrono_representacion" onchange="RepresentacionCambiar();" class="select-bg">
    									<option value="1">Personal</option>
    									<option value="2">Representación</option>
    								</select>
    								<div id="div_patrono_representacion" style="display:none;">
    									<div>Nombre de la sociedad</div>
                                        <span class="spn_patrono_sociedad error"></span>
    									<input type="text" id="txt_patrono_sociedad" class="tabButton"/>
    									<div>Puesto</div>
    									<select id="slc_patrono_puesto" class="select-bg">
    										<option value="Administrador Único">Administrador Único</option>
    										<option value="Presidente del Consejo de Administración">Presidente del Consejo de Administración</option>
    										<option value="Mandatario">Mandatario</option>
    										<option value="Gerente">Gerente</option>
    									</select>
    								</div>
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
    						<h2 class="titleGeneral">Trabajador</h2>
    			          	<div id="div_patrono_paso2">
    			          		<div id="div_mensaje_error2" class="mensaje_error"></div>
    				          	<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 patrono_paso2">
    								<div>Información del trabajador</div>	
    								<div>Nombres:</div>
                                    <span class="spn_trabajador_nombres error"></span>
    								<input type="text" class="tabButton" id="txt_trabajador_nombres" onkeypress="return validar_caracter(event, 0);">
    								<div>Apellidos:</div>
                                    <span class="spn_trabajador_apellidos error"></span>
    								<input type="text" class="tabButton"  id="txt_trabajador_apellidos" onkeypress="return validar_caracter(event, 0);">
    								<div>Edad:</div>
                                    <span class="spn_trabajador_edad error"></span>
    								<input type="text" class="tabButton"  id="txt_trabajador_edad" onkeypress="return validar_caracter(event, 1);">
    								<div>Género:</div>
                                    <select id="slc_trabajador_genero" class="genero select-bg" onchange="GeneroVerificar(this);">'+
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                    </select>
                                    <div>Estado Civil:</div>
    								<select id="slc_trabajador_civil" class="civil select-bg">
    									<option value="Casado">Casado</option>
    									<option value="Soltero">Soltero</option>
    									<option value="Divorciado">Divorciado</option>
    									<option value="Viudo">Viudo</option>
    								</select>
    								<div>Profesion:</div>
                                    <span class="spn_trabajador_profesion error"></span>
    								<input type="text" class="tabButton" id="txt_trabajador_profesion" onkeypress="return validar_caracter(event, 0);">
    								<div>Nacionalidad:</div>
    								<select id="slc_trabajador_nacionalidad" onchange="NacionalidadVerificar(this);" class="nacionalidad select-bg">
    								<?php
    									echo $html_paises;
    								?>
    								</select>
    								<div>Departamento de domicilio:</div>
                                    <span class="spn_trabajador_departamento error"></span>
    								<select id="slc_trabajador_departamento" class="slc_patrono_departamento select-bg">
    								<?php
    									echo $html_departamentos;
    								?>
    								</select>
    								<div class="trabajador_dpi dpi">DPI:</div>
                                    <span class="spn_trabajador_dpi error"></span>
    								<input type="text" class="tabButton" id="txt_trabajador_dpi" onkeypress="return validar_caracter(event, 1);">
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
    						<h2 class="titleGeneral">Requerimientos del patrono</h2>
    			          	<div id="div_requerimiento_paso3">
    			          		<div id="div_mensaje_error3" class="mensaje_error"></div>
    				          	<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 patrono_paso3">
    								<div>Información del requerimiento</div>	
    								<div>Puesto a ocupar:</div>
                                    <span class="spn_requerimiento_puesto error"></span>
    								<input type="text" class="tabButton" id="txt_requerimiento_puesto" onkeypress="return validar_caracter(event, 0);">
    								<div id="div_servicios">
    									<div class="servicios">
    										<div>Obligaciones o servicios:</div>
                                            <span class="spn_requerimiento_servicio error"></span>
    										<input type="text" class="tabButton servicio">
    									</div>
    								</div>
    								<input class="fillButton" type="button" value="Agregar Obligación o servicio" onclick="ServicioAgregar();;">
    								<div>Inicio de jornada:</div>
                                    <span class="spn_requerimiento_jornada_inicio error"></span>
    								<input type="text" class="tabButton"  id="txt_requerimiento_jornada_inicio">
    								<div>Fin de jornada:</div>
                                    <span class="spn_requerimiento_jornada_fin error"></span>
    								<input type="text" class="tabButton"  id="txt_requerimiento_jornada_fin">
    								<div>Salario mensual:</div>
                                    <span class="spn_requerimiento_salario error"></span>
    								<input type="text" class="tabButton" id="txt_requerimiento_salario" onkeyup="return validar_caracter1(event, this);" onchange="FormatoMoneda(this);">
    								<div>Forma de pago:</div>
    								<select id="slc_requerimiento_forma_pago" class="select-bg">
    									<option value="mensual">Mensual</option>
    									<option value="quincenal">Quincenal</option>
    									<option value="semanal">Semanal</option>
    									<option value="diaria">Diario</option>
    								</select>
    								<div>Dirección donde se prestarán los servicios:</div>
                                    <span class="spn_requerimiento_direccion error"></span>
    								<input type="text" class="tabButton" id="txt_requerimiento_direccion">
    								<div>Fecha de inicio de relación de trabajo (dd/mm/aaaa):</div>
                                    <span class="spn_requerimiento_fecha error"></span>
    								<input type="text" class="tabButton" id="txt_requerimiento_fecha">
    								<div>¿El trabajador desarrollará algún servicio relacionado a propiedad intelectual?</div>
    								<select id="slc_requerimiento_intelectual" class="select-bg">
    									<option value="0">No</option>
    									<option value="1">Si</option>
    								</select>
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
    				</div>
    			</div>
    		</div>
    		<div class="col-lg-3 col-md-4 col-sm-3 col-xs-12 lineCircle">
    			<div class="contentCircle">
    				<div class="circle item1C active" id="item1C">1</div>
    				<div class="circle item2C" id="item2C">2</div>
    				<div class="circle item3C" id="item3C">3</div>
    			</div>
    			<div class="contentText">
    				<span class="textCircle item1TC active" id="item1TC">Patrono</span>
    				<span class="textCircle item2TC" id="item2TC">Trabajador</span>
    				<span class="textCircle item3TC" id="item3TC">Requerimiento</span>
    			</div>
    		</div>
        </div>
	</div>
	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap wrapEditContract ContratoGenerado" style="display:none;">
        <h2 class="titleGeneral"><span class="backLevel">Laboral |</span> <b class="level">Contrato Generado</b></h2>
		<div class="form-group">
			<textarea id="elm1" name="elm1" cols="40" rows="10" wrap="hard"></textarea>
		</div>
        <input class="fillButton" type="button" value="Pagar y guardar" onclick="ContratoPagar(1);">
        <input class="fillButton" type="button" value="Regresar" onclick="ContratoGenerar(0);">
		<!--input class="fillButton" type="button" value="Guardar" onclick="ValidarNombre();"-->
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
		
		jQuery("#txt_requerimiento_jornada_inicio").mask("99:99");
		jQuery("#txt_requerimiento_jornada_fin").mask("99:99");
		jQuery("#txt_requerimiento_fecha").mask("99/99/9999");
	</script>
<?php $this->layout->block(); ?>
