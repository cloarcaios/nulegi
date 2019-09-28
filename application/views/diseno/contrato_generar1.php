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
		.formContract{
			height:77vh !important; 
			margin: 0;
		}
	</style>
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script src="<?php echo($this->config->base_url());?>includes/js/jquery.maskedinput.min.js"></script>
	<script src="<?php echo($this->config->base_url());?>includes/tinymce/es.js"></script>
	<script type="text/javascript">
        /*
		var nombres = '<?php echo $sesion["nombres"];?>';
	    var apellidos = '<?php echo $sesion["apellidos"];?>';
	    var direccion = '<?php echo $sesion["direccion"];?>';
	    var telefono = '<?php echo $sesion["telefono"];?>';
	    var nacimiento = '<?php echo $sesion["nacimiento"];?>';
	    var dpi = '<?php echo $sesion["dpi"];?>';
	    var licencia = '<?php echo $sesion["licencia"];?>';
	    var oficio = '<?php echo $sesion["oficio"];?>';
	    if(nombres != '0' && apellidos != '0'){
	    	jQuery('#txt_nombre').val(nombres+' '+apellidos);
	    }
	    if(nacimiento != '0000-00-00'){
	    	var anio_actual = (new Date).getFullYear();
	    	var nacimiento_anio = nacimiento.substring(0, 4);
	    	var edad = parseInt(anio_actual) - parseInt(nacimiento_anio);
	    	jQuery('#txt_edad').val(edad);
	    }
	    if(dpi != '0'){
	    	jQuery('#txt_dpi').val(dpi);
	    }
        */

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
        
	    var socio = 2;
	    function SocioAgregar(){
	    	socio++;
	    	var html_socio = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 socio_paso1">'+
								'<div>Socio '+socio+'</div>'+
								'<div>Tipo de socio:</div>'+
								'<select class="slc_socio_tipo select-bg">'+
									'<option value="0">Individual</option>'+
									'<option value="1">Sociedad Anonima</option>'+
									'<option value="2">Juridico</option>'+
								'</select>'+
								'<input type="button" onclick="SocioEliminar(this);" class="fillButton prev" value="Eliminar"/>'+
							'</div>';
			jQuery('#div_socios_paso1').append(html_socio);
	    }

	    function SocioEliminar(etiqueta){
	    	$(etiqueta).parent().remove();
	    	socio--;
	    }

	    function DepositoAgregar(){
	    	var html_deposito = '<div class="deposito">'+
									'<div>Numero de deposito:</div>'+
                                    '<input type="text" class="tabButton sociedad_deposito" onkeypress="return validar_caracter(event, 1);">'+
                                    '<div>Numero de boleta:</div>'+
                                    '<input type="text" class="tabButton sociedad_boleta" onkeypress="return validar_caracter(event, 1);">'+
									'<input type="button" onclick="DepositoEliminar(this);" class="fillButton prev" value="Eliminar"/>'+
								'</div>';
			jQuery('#div_depositos').append(html_deposito);
	    }

	    function DepositoEliminar(etiqueta){
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
                var moneda = parseInt($(elemento).val()).toFixed(2);
                $(elemento).val(moneda);
            }
            else{
                $(elemento).val('');
            }
        }

        function PasoVer(id){
        	$('.circle').removeClass('active');
            $('.textCircle').removeClass('active');
            $('.paso').each(function(key,element){
                if($(element).prop('id') == 'div_paso'+id){
                    $(element).css('display','block');
                    $('#item'+id+'C').addClass('active');
                    $('#item'+id+'TC').addClass('active');
                }
                else{
                	$(element).css('display','none');
                }
            });
            ValidacionesLimpiar();
        }

    	var tipos = new Array();
    	var capitales = new Array();
        function Paso1Validar(){
	    	tipos = new Array();
        	var tipo;
        	jQuery('#div_mensaje_error1').html('');
        	$('.socio_paso1').each(function(key, elemento){
        		tipo = $(elemento).find('.slc_socio_tipo').val();
        		tipos.push(tipo);
	 		});
            PasosGenerar();
 			PasoVer(2);
        }

        function PasosGenerar(){
        	var formulario = '';
            var contenedor = '';
        	var socio_individual = 0;
        	var socio_sa = 0;
        	var socio_juridico = 0;
            var pasos_formularios = 1;
            $('.paso').each(function(key,element){
                if($(element).prop('id') == 'div_paso1'){
                    $(element).css('display','block');
                }else{
                    $(element).remove();
                }
            });
			jQuery('.contentCircle').html('');
			jQuery('.contentText').html('');
			IconoPasoGenerar(1, 'Socios');
            $(tipos).each(function(key, elemento){
                pasos_formularios++;
        		if(elemento == '0'){
        			formulario = '<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 socio_individual">'+
										'<h3>Socio tipo individual</h3>'+
										'<div>Nombres:</div>'+
										'<span class="spn_nombres error"></span>'+
										'<input type="text" class="tabButton socio_nombres" onkeypress="return validar_caracter(event, 0);">'+
										'<div>Apellidos:</div>'+
										'<span class="spn_apellidos error"></span>'+
										'<input type="text" class="tabButton socio_apellidos" onkeypress="return validar_caracter(event, 0);">'+
										'<div>Edad:</div>'+
										'<span class="spn_edad error"></span>'+
										'<input type="text" class="tabButton socio_edad" onkeypress="return validar_caracter(event, 1);">'+
										'<div>Género:</div>'+
										'<select class="socio_genero select-bg" onchange="GeneroVerificar(this);">'+
											'<option value="masculino">Masculino</option>'+
											'<option value="femenino">Femenino</option>'+
										'</select>'+
										'<div>Estado Civil:</div>'+
										'<select class="socio_civil select-bg">'+
											'<option value="Casado">Casado</option>'+
											'<option value="Soltero">Soltero</option>'+
											'<option value="Divorciado">Divorciado</option>'+
											'<option value="Viudo">Viudo</option>'+
										'</select>'+
										'<div>Profesion:</div>'+
										'<span class="spn_profesion error"></span>'+
										'<input type="text" class="tabButton socio_profesion" onkeypress="return validar_caracter(event, 0);">'+
										'<div>Nacionalidad:</div>'+
										'<select class="socio_nacionalidad select-bg" onchange="NacionalidadVerificar(this);">'+
										<?php
											echo "'".$html_paises."'+";
										?>
										'</select>'+
										'<div>Departamento:</div>'+	
										'<span class="spn_departamento error"></span>'+
										'<select class="socio_departamento select-bg">'+
										<?php
											echo "'".$html_departamentos."'+";
										?>
										'</select>'+
										'<div class="dpi">DPI:</div>'+
										'<span class="spn_dpi error"></span>'+
										'<input type="text" class="tabButton socio_dpi" onkeypress="return validar_caracter(event, 1);">'+
										'<div>Capital a aportar:</div>'+
										'<span class="spn_capital error"></span>'+
										'<input type="text" class="tabButton socio_capital" onkeypress="return validar_caracter(event, 1);" onchange="FormatoMoneda(this);">'+
										'<input type="hidden" class="hdd_socio_individual" value="'+socio_individual+'">'+
									'</div>';
					socio_individual++;
        		}
        		if(elemento == '1'){
        			formulario = '<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 socio_sa">'+
										'<h3>Socio tipo Sociedad Anonima</h3>'+
										'<div>Nombres:</div>'+
										'<span class="spn_socio_nombres error"></span>'+
										'<input type="text" class="tabButton socio_nombres" onkeypress="return validar_caracter(event, 0);">'+
										'<div>Apellidos:</div>'+
										'<span class="spn_socio_apellidos error"></span>'+
										'<input type="text" class="tabButton socio_apellidos" onkeypress="return validar_caracter(event, 0);">'+
										'<div>Edad:</div>'+
										'<span class="spn_socio_edad error"></span>'+
										'<input type="text" class="tabButton socio_edad" onkeypress="return validar_caracter(event, 1);">'+
										'<div>Género:</div>'+
										'<select class="socio_genero select-bg" onchange="GeneroVerificar(this);">'+
											'<option value="masculino">Masculino</option>'+
											'<option value="femenino">Femenino</option>'+
										'</select>'+
										'<div>Estado Civil:</div>'+
										'<select class="socio_civil select-bg">'+
											'<option value="Casado">Casado</option>'+
											'<option value="Soltero">Soltero</option>'+
											'<option value="Divorciado">Divorciado</option>'+
											'<option value="Viudo">Viudo</option>'+
										'</select>'+
										'<div>Profesion:</div>'+
										'<span class="spn_socio_profesion error"></span>'+
										'<input type="text" class="tabButton socio_profesion" onkeypress="return validar_caracter(event, 0);">'+
										'<div>Nacionalidad:</div>'+
										'<select class="socio_nacionalidad select-bg" onchange="NacionalidadVerificar(this);">'+
										<?php
											echo "'".$html_paises."'+";
										?>
										'</select>'+
										'<div>Departamento:</div>'+	
										'<select class="socio_departamento select-bg">'+
										<?php
											echo "'".$html_departamentos."'+";
										?>
										'</select>'+
										'<div class="dpi">DPI:</div>'+
										'<span class="spn_socio_dpi error"></span>'+
										'<input type="text" class="tabButton socio_dpi" onkeypress="return validar_caracter(event, 1);">'+
										'<div>Puesto en la empresa:</div>'+
										'<span class="spn_socio_puesto error"></span>'+
										'<input type="text" class="tabButton socio_puesto" onkeypress="return validar_caracter(event, 0);">'+
										'<div>Nombre comercial:</div>'+
										'<span class="spn_socio_comercial error"></span>'+	
										'<input type="text" class="tabButton socio_comercial" onkeypress="return validar_caracter(event, 0);">'+
										'<div>Fecha de nombramiento (dd/mm/aaaa):</div>'+
										'<span class="spn_socio_nombramiento error"></span>'+	
										'<input type="text" class="tabButton socio_nombramiento">'+
										'<div>Notario que autorizó:</div>'+
										'<span class="spn_socio_notario error"></span>'+
										'<input type="text" class="tabButton socio_notario" onkeypress="return validar_caracter(event, 0);">'+
										'<div>Número de registro mercantil:</div>'+
										'<span class="spn_socio_registro error"></span>'+	
										'<input type="text" class="tabButton socio_registro" onkeypress="return validar_caracter(event, 1);">'+
										'<div>Número de folio:</div>'+
										'<span class="spn_socio_folio error"></span>'+
										'<input type="text" class="tabButton socio_folio" onkeypress="return validar_caracter(event, 1);">'+
										'<div>Número de libro:</div>'+
										'<span class="spn_socio_libro error"></span>'+	
										'<input type="text" class="tabButton socio_libro" onkeypress="return validar_caracter(event, 1);">'+
										'<div>Capital a aportar:</div>'+
										'<span class="spn_socio_capital error"></span>'+
										'<input type="text" class="tabButton socio_capital" onkeypress="return validar_caracter(event, 1);" onchange="FormatoMoneda(this);">'+
										'<input type="hidden" class="hdd_socio_sa" value="'+socio_sa+'">'+
									'</div>';
					socio_sa++;
        		}
        		if(elemento == '2'){
        			formulario = '<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 socio_juridico">'+
										'<h3>Socio tipo juridico</h3>'+
										'<div>Nombres:</div>'+
										'<span class="spn_juridico_nombres error"></span>'+
										'<input type="text" class="tabButton socio_nombres" onkeypress="return validar_caracter(event, 0);">'+
										'<div>Apellidos:</div>'+
										'<span class="spn_juridico_apellidos error"></span>'+
										'<input type="text" class="tabButton socio_apellidos" onkeypress="return validar_caracter(event, 0);">'+
										'<div>Edad:</div>'+
										'<span class="spn_juridico_edad error"></span>'+
										'<input type="text" class="tabButton socio_edad" onkeypress="return validar_caracter(event, 1);">'+
										'<div>Género:</div>'+
										'<select class="socio_genero select-bg" onchange="GeneroVerificar(this);">'+
											'<option value="masculino">Masculino</option>'+
											'<option value="femenino">Femenino</option>'+
										'</select>'+
										'<div>Estado Civil:</div>'+
										'<select class="socio_civil select-bg">'+
											'<option value="Casado">Casado</option>'+
											'<option value="Soltero">Soltero</option>'+
											'<option value="Divorciado">Divorciado</option>'+
											'<option value="Viudo">Viudo</option>'+
										'</select>'+
										'<div>Profesion:</div>'+
										'<span class="spn_juridico_profesion error"></span>'+
										'<input type="text" class="tabButton socio_profesion" onkeypress="return validar_caracter(event, 0);">'+
										'<div>Nacionalidad:</div>'+
										'<select class="socio_nacionalidad select-bg" onchange="NacionalidadVerificar(this);">'+
										<?php
											echo "'".$html_paises."'+";
										?>
										'</select>'+
										'<div>Departamento:</div>'+	
										'<select class="socio_departamento select-bg">'+
										<?php
											echo "'".$html_departamentos."'+";
										?>
										'</select>'+
										'<div class="dpi">DPI:</div>'+
										'<span class="spn_juridico_dpi error"></span>'+
										'<input type="text" class="tabButton socio_dpi" onkeypress="return validar_caracter(event, 1);">'+
										'<div>Número de colegiado:</div>'+
										'<span class="spn_juridico_colegiado error"></span>'+	
										'<input type="text" class="tabButton socio_colegiado" onkeypress="return validar_caracter(event, 1);">'+
										'<div>Capital a aportar:</div>'+
										'<span class="spn_juridico_capital error"></span>'+
										'<input type="text" class="tabButton socio_capital" onkeypress="return validar_caracter(event, 1);" onchange="FormatoMoneda(this);">'+
										'<input type="hidden" class="hdd_socio_juridico" value="'+socio_juridico+'">'+
									'</div>';
					socio_juridico++;
        		}
                var contenedor = '<div class="formContract paso" id="div_paso'+pasos_formularios+'" style="display:none;">'+
                                    '<span class="legendForm">Paso '+pasos_formularios+'</span>'+
                                    '<h2 class="titleGeneral">Información del Socio '+(pasos_formularios-1)+'</h2>'+
                                    '<div id="div_mensaje_error'+pasos_formularios+'" class="mensaje_error"></div>'+
                                    '<div id="div_socios_paso'+pasos_formularios+'">'+
                                    formulario+
                                    '</div>'+
                                    '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">'+
                                        '<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">'+
                                            '<input class="fillButton prev" type="button" value="Anterior" onclick="PasoVer('+(pasos_formularios-1)+');">'+
                                        '</div>'+
                                        '<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">'+
                                            '<input class="fillButton" type="button" value="Siguiente" onclick="PasoGeneradoValidar('+elemento+','+pasos_formularios+',this);">'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
	 		    jQuery('.pasos').append(contenedor);
	 		    jQuery(".socio_nombramiento").mask("99/99/9999");
	 		    IconoPasoGenerar(pasos_formularios, 'Información del Socio '+(pasos_formularios-1));
            });
            socios_individual = new Array();
            socios_sa = new Array();
            socios_juridico = new Array();
            socios_acciones_nombres = new Array();
            GenerarUltimosPasos(pasos_formularios);
        }

        function IconoPasoGenerar(paso, texto){
        	jQuery('.contentCircle').append('<div class="circle item'+paso+'C" id="item'+paso+'C">'+paso+'</div>');
        	jQuery('.contentText').append('<span class="textCircle item'+paso+'TC" id="item'+paso+'TC">'+texto+'</span>');
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
		        	jQuery(elemento).parent().find('.socio_departamento').html(respuesta);
		        },
		        error: function (error){
		            //alert(error);
		        }
		    });
        }

        var socios_individual;
        var socios_sa;
        var socios_juridico;
        function PasoGeneradoValidar(tipo, paso, elemento){
            var error_individual = false;
            var error_sa = false;
            var error_juridico = false;
            var mensaje_error = '';
            var socio = 0;
            jQuery('#div_mensaje_error'+paso).html('');
            switch(tipo){
                case 0:
                    var elemento = $(elemento).parent().parent().parent();
                    var nombres = $(elemento).find('.socio_nombres').val();
                    var apellidos = $(elemento).find('.socio_apellidos').val();
                    var edad = $(elemento).find('.socio_edad').val();
                    var profesion = $(elemento).find('.socio_profesion').val();
                    var departamento = $(elemento).find('.socio_departamento').val();
                    var dpi = $(elemento).find('.socio_dpi').val();
                    var identificacion = $(elemento).find('.dpi').html();
                    var capital = $(elemento).find('.socio_capital').val();
                    var posicion = $(elemento).find('.hdd_socio_individual').val();
                    ValidacionesLimpiar();
                    if(nombres == ''){
                        error_individual = true;
                        mensaje_error = 'Ingrese los nombres del socio individual.';
                        jQuery('.spn_nombres').html(mensaje_error);
                    }
                    if(apellidos == ''){
                        error_individual = true;
                        mensaje_error = 'Ingrese los apellidos del socio individual.';
                        jQuery('.spn_apellidos').html(mensaje_error);
                    }
                    if(edad == ''){
                        error_individual = true;
                        mensaje_error = 'Ingrese la edad del socio individual.';
                        jQuery('.spn_edad').html(mensaje_error);
                    }
                    if(profesion == ''){
                        error_individual = true;
                        mensaje_error = 'Ingrese la profesion del socio individual.';
                        jQuery('.spn_profesion').html(mensaje_error);
                    }
                    if(departamento == ''){
                        error_individual = true;
                        mensaje_error = 'Ingrese el departamento del socio individual.';
                        jQuery('.spn_departamento').html(mensaje_error);
                    }
                    if(dpi == ''){
                        error_individual = true;
                        mensaje_error = 'Ingrese el DPI del socio individual.';
                        jQuery('.spn_dpi').html(mensaje_error);
                    }
                    if(capital == ''){
                        error_individual = true;
                        mensaje_error = 'Ingrese el capital a aportar del socio individual.';
                        jQuery('.spn_capital').html(mensaje_error);
                    }
                    if(error_individual == false){
                        var individual = new Array();
                        var individual_existe = false;
                        individual['nombres'] = nombres;
                        individual['apellidos'] = apellidos;
                        individual['edad'] = edad;
                        individual['civil'] = $(elemento).find('.socio_civil').val();
                        individual['genero'] = $(elemento).find('.socio_genero').val();
                        individual['profesion'] = profesion;
                        individual['nacionalidad'] = $(elemento).find('.socio_nacionalidad').val();
                        individual['departamento'] = departamento;
                        individual['dpi'] = dpi;
                        individual['identificacion'] = identificacion;
                        individual['capital'] = capital;
                        individual['posicion'] = posicion;
                        $.each(socios_individual, function( indice, valor ) {
                        	console.log('Valor: '+valor['posicion']);
                        	console.log('Posicion:'+posicion);
							if(valor['posicion'] == posicion){
								console.log('Valor igual a la posicion:');
								socios_individual[posicion] = individual;
								individual_existe = true;
							}
						});
						if(individual_existe == false){
							socios_individual.push(individual);
						}
                        PasoVer(paso+1);
                    }
                    break;
                case 1:
                    var elemento = $(elemento).parent().parent().parent();
                    var nombres = $(elemento).find('.socio_nombres').val();
                    var apellidos = $(elemento).find('.socio_apellidos').val();
                    var edad = $(elemento).find('.socio_edad').val();
                    var profesion = $(elemento).find('.socio_profesion').val();
                    var departamento = $(elemento).find('.socio_departamento').val();
                    var dpi = $(elemento).find('.socio_dpi').val();
                    var identificacion = $(elemento).find('.dpi').html();
                    var puesto = $(elemento).find('.socio_puesto').val();
                    var comercial = $(elemento).find('.socio_comercial').val();
                    var nombramiento = $(elemento).find('.socio_nombramiento').val();
                    var notario = $(elemento).find('.socio_notario').val();
                    var registro = $(elemento).find('.socio_registro').val();
                    var folio = $(elemento).find('.socio_folio').val();
                    var libro = $(elemento).find('.socio_libro').val();
                    var capital = $(elemento).find('.socio_capital').val();
                    var posicion = $(elemento).find('.hdd_socio_sa').val();
                    ValidacionesLimpiar();
                    if(nombres == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese los nombres del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_nombres').html(mensaje_error);
                    }
                    if(apellidos == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese los apellidos del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_apellidos').html(mensaje_error);
                    }
                    if(edad == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese la edad del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_edad').html(mensaje_error);
                    }
                    if(profesion == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese la profesion del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_profesion').html(mensaje_error);
                    }
                    if(departamento == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese el departamento del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_departamento').html(mensaje_error);
                    }
                    if(dpi == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese el DPI del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_dpi').html(mensaje_error);
                    }
                    if(puesto == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese el puesto del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_puesto').html(mensaje_error);
                    }
                    if(comercial == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese el nombre comercial del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_comercial').html(mensaje_error);
                    }
                    if(nombramiento == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese la fecha de nombramiento del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_nombramiento').html(mensaje_error);
                    }
                    if(notario == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese el nombre del notario que autorizo al socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_notario').html(mensaje_error);
                    }
                    if(registro == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese el registro mercantil del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_registro').html(mensaje_error);
                    }
                    if(folio == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese el numero de folio del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_folio').html(mensaje_error);
                    }
                    if(libro == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese el numero de libro del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_libro').html(mensaje_error);
                    }
                    if(capital == ''){
                        error_sa = true;
                        mensaje_error = '<div>Ingrese el capital a aportar del socio tipo sociedad anonima.</div>';
                        jQuery('.spn_socio_capital').html(mensaje_error);
                    }
                    if(error_sa == false){
                        var sa = new Array();
                        var sa_existe = false;
                        sa['nombres'] = nombres;
                        sa['apellidos'] = apellidos;
                        sa['edad'] = edad;
                        sa['civil'] = $(elemento).find('.socio_civil').val();
                        sa['genero'] = $(elemento).find('.socio_genero').val();
                        sa['profesion'] = profesion;
                        sa['nacionalidad'] = $(elemento).find('.socio_nacionalidad').val();
                        sa['departamento'] = departamento;
                        sa['dpi'] = dpi;
                        sa['identificacion'] = identificacion;
                        sa['puesto'] = puesto;
                        sa['comercial'] = comercial;
                        sa['nombramiento'] = nombramiento;
                        sa['notario'] = notario;
                        sa['registro'] = registro;
                        sa['folio'] = folio;
                        sa['libro'] = libro;
                        sa['capital'] = capital;
                        sa['posicion'] = posicion;
                        $.each(socios_sa, function( indice, valor ) {
                        	console.log('Valor: '+valor['posicion']);
                        	console.log('Posicion:'+posicion);
							if(valor['posicion'] == posicion){
								console.log('Valor igual a la posicion:');
								socios_sa[posicion] = sa;
								sa_existe = true;
							}
						});
						if(sa_existe == false){
							socios_sa.push(sa);
						}
                        PasoVer(paso+1);
                    }
                    break;
                case 2:
                    var elemento = $(elemento).parent().parent().parent();
                    var nombres = $(elemento).find('.socio_nombres').val();
                    var apellidos = $(elemento).find('.socio_apellidos').val();
                    var edad = $(elemento).find('.socio_edad').val();
                    var profesion = $(elemento).find('.socio_profesion').val();
                    var departamento = $(elemento).find('.socio_departamento').val();
                    var dpi = $(elemento).find('.socio_dpi').val();
                    var identificacion = $(elemento).find('.dpi').html();
                    var colegiado = $(elemento).find('.socio_colegiado').val();
                    var capital = $(elemento).find('.socio_capital').val();
                    var posicion = $(elemento).find('.hdd_socio_juridico').val();
                    ValidacionesLimpiar();
                    if(nombres == ''){
                        error_juridico = true;
                        mensaje_error = '<div>Ingrese los nombres del socio juridico.</div>';
                        jQuery('.spn_juridico_nombres').html(mensaje_error);
                    }
                    if(apellidos == ''){
                        error_juridico = true;
                        mensaje_error = '<div>Ingrese los apellidos del socio juridico.</div>';
                    	jQuery('.spn_juridico_apellidos').html(mensaje_error);
                    }
                    if(edad == ''){
                        error_juridico = true;
                        mensaje_error = '<div>Ingrese la edad del socio juridico.</div>';
                        jQuery('.spn_juridico_edad').html(mensaje_error);
                    }
                    if(profesion == ''){
                        error_juridico = true;
                        mensaje_error = '<div>Ingrese la profesion del socio juridico.</div>';
                        jQuery('.spn_juridico_profesion').html(mensaje_error);
                    }
                    if(departamento == ''){
                        error_juridico = true;
                        mensaje_error = '<div>Ingrese el departamento del socio juridico.</div>';
                        jQuery('.spn_juridico_departamento').html(mensaje_error);
                    }
                    if(dpi == ''){
                        error_juridico = true;
                        mensaje_error = '<div>Ingrese el DPI del socio juridico.</div>';
                        jQuery('.spn_juridico_dpi').html(mensaje_error);
                    }
                    if(colegiado == ''){
                        error_juridico = true;
                        mensaje_error = '<div>Ingrese el colegiado del socio juridico.</div>';
                        jQuery('.spn_juridico_colegiado').html(mensaje_error);
                    }
                    if(capital == ''){
                        error_juridico = true;
                        mensaje_error = '<div>Ingrese el capital a aportar del socio juridico.</div>';
                        jQuery('.spn_juridico_capital').html(mensaje_error);
                    }
                    if(error_juridico == false){
                        var juridico = new Array();
                        var juridico_existe = false;
                        juridico['nombres'] = nombres;
                        juridico['apellidos'] = apellidos;
                        juridico['edad'] = edad;
                        juridico['civil'] = $(elemento).find('.socio_civil').val();
                        juridico['genero'] = $(elemento).find('.socio_genero').val();
                        juridico['profesion'] = profesion;
                        juridico['nacionalidad'] = $(elemento).find('.socio_nacionalidad').val();
                        juridico['departamento'] = departamento;
                        juridico['dpi'] = dpi;
                        juridico['identificacion'] = identificacion;
                        juridico['colegiado'] = colegiado;
                        juridico['capital'] = capital;
                        juridico['posicion'] = posicion;
                        $.each(socios_juridico, function( indice, valor ) {
                        	console.log('Valor: '+valor['posicion']);
                        	console.log('Posicion:'+posicion);
							if(valor['posicion'] == posicion){
								console.log('Valor igual a la posicion:');
								socios_juridico[posicion] = juridico;
								juridico_existe = true;
							}
						});
						if(juridico_existe == false){
							socios_juridico.push(juridico);
						}
                        PasoVer(paso+1);
                    }
                    break;
                default:
                    break;
            }
        }

        var socios_sociedad = new Array();
        function PasoSociedadValidar(paso){
        	var departamento = jQuery('.sociedad_departamento').val();
        	var ciudad = jQuery('.sociedad_ciudad').val();
        	var nombre = jQuery('.sociedad_nombre').val();
        	var comercial = jQuery('.sociedad_comercial').val();
        	var actividad = jQuery('.sociedad_actividad').val();
            ValidacionesLimpiar();
        	var error = false;
        	if(ciudad == ''){
        		error = true;
        		mensaje_error = 'Ingrese la ciudad de la sociedad.';
        		jQuery('.spn_sociedad_ciudad').html(mensaje_error);
        	}
        	if(nombre == ''){
        		error = true;
        		mensaje_error = 'Ingrese el nombre de la sociedad.';
        		jQuery('.spn_sociedad_nombre').html(mensaje_error);
        	}
        	if(comercial == ''){
        		error = true;
        		mensaje_error = 'Ingrese el nombre comercial de la sociedad.';
        		jQuery('.spn_sociedad_comercial').html(mensaje_error);
        	}
        	if(actividad == ''){
        		error = true;
        		mensaje_error = 'Ingrese la actividad principal de la sociedad.';
        		jQuery('.spn_sociedad_actividad').html(mensaje_error);
        	}
        	if(error == false){
        		socios_sociedad = new Array();
        		socios_sociedad.push(departamento);
        		socios_sociedad.push(ciudad);
        		socios_sociedad.push(nombre);
        		socios_sociedad.push(comercial);
        		socios_sociedad.push(actividad);
        		PasoVer(paso+1);
        	}
        	console.log(socios_individual);
        	console.log(socios_sa);
        	console.log(socios_juridico);
        }

        var socios_bancario = new Array();
        function PasoBancarioValidar(paso){
        	var depositos = new Array();
	    	var boletas = new Array();
        	var tipo;
        	var boleta;
        	error = false;
        	$('.deposito').each(function(key, elemento){
        		deposito = $(elemento).find('.sociedad_deposito').val();
        		depositos.push(deposito);
        		boleta = $(elemento).find('.sociedad_boleta').val();
        		boletas.push(boleta);
        	});
        	var banco = jQuery('.sociedad_banco').val();
    		var cuenta = jQuery('.sociedad_cuenta').val();
    		socios_bancario = new Array();
    		socios_bancario.push(banco);
    		socios_bancario.push(depositos);
    		socios_bancario.push(boletas);
    		socios_bancario.push(cuenta);
    		PasoVer(paso+1);
    		CapitalesObtener();
    		AccionesCalcular();
    		var html_valor = '';
	        $.each(moduloscompletos, function( indice, valor ) {
				html_valor += '<option value="'+valor+'">'+valor+'</option>';
			});
			jQuery('#slc_sociedad_valor').html(html_valor);
    		AccionesValorCalcular();
    		console.log(capitales);
        }
        
        var socios_acciones = new Array();
        var socios_acciones_nombres;
        function PasoAccionesValidar(paso){
        	PasoVer(paso+1);
        }

        function GenerarUltimosPasos(paso_actual){
            var pasos_finales = '<div class="formContract paso" id="div_paso'+(paso_actual+1)+'" style="display:none;">'+
                                    '<span class="legendForm">Paso '+(paso_actual+1)+'</span>'+
                                    '<h2 class="titleGeneral">Información de la sociedad</h2>'+
                                    '<div id="div_socios_paso'+(paso_actual+1)+'">'+
                                        '<div id="div_mensaje_error'+(paso_actual+1)+'" class="mensaje_error"></div>'+
                                        '<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 sociedad_paso'+(paso_actual+1)+'">'+
                                            '<div>Departamento de direccion fiscal:</div>'+
                                            '<select class="sociedad_departamento select-bg">'+
                                                '<?php echo $html_departamentos;?>'+
                                            '</select>'+
                                            '<div>Ciudad:</div>'+
                                            '<span class="spn_sociedad_ciudad error"></span>'+	
                                            '<input type="text" class="tabButton sociedad_ciudad" onkeypress="return validar_caracter(event, 0);">'+
                                            '<div>Nombre de la sociedad:</div>'+
                                            '<span class="spn_sociedad_nombre error"></span>'+
                                            '<div>Nota: Recomendamos que se haga una búsqueda en el Registro Mercantil y se solicité certificación, para asegurar que el nombre está disponible y no habrá oposición.</div>'+
                                            '<input type="text" class="tabButton sociedad_nombre">'+
                                            '<div>Nombre comercial:</div>'+
                                            '<span class="spn_sociedad_comercial error"></span>'+
                                            '<input type="text" class="tabButton sociedad_comercial">'+
                                            '<div>Actividad principal:</div>'+
                                            '<span class="spn_sociedad_actividad error"></span>'+
                                            '<div>Nota: Debe estar escrito con la ortografía correcta.</div>'+
                                            '<textarea rows="6" cols="60" class="tabButton sociedad_actividad"></textarea>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">'+
                                        '<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">'+
                                            '<input class="fillButton prev" type="button" value="Anterior" onclick="PasoVer('+(paso_actual)+');">'+
                                        '</div>'+
                                        '<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">'+
                                            '<input class="fillButton" type="button" value="Siguiente" onclick="PasoSociedadValidar('+(paso_actual+1)+');">'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="formContract paso" id="div_paso'+(paso_actual+2)+'" style="display:none;">'+
                                    '<span class="legendForm">Paso '+(paso_actual+2)+'</span>'+
                                    '<h2 class="titleGeneral">Información Bancaria</h2>'+
                                    '<div id="div_socios_paso'+(paso_actual+2)+'">'+
                                        '<div id="div_mensaje_error'+(paso_actual+2)+'" class="mensaje_error"></div>'+
                                        '<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 sociedad_paso'+(paso_actual+2)+'">'+
                                            '<div>Departamento de direccion fiscal:</div>'+
                                            '<select class="sociedad_banco select-bg">'+
                                                '<?php echo $html_bancos;?>'+
                                            '</select>'+
                                            '<div>Numero de cuenta de la sociedad:</div>'+
                                            '<span class="spn_bancario_cuenta error"></span>'+
                                            '<input type="text" class="tabButton sociedad_cuenta" onkeypress="return validar_caracter(event, 1);">'+
                                            '<div id="div_depositos">'+
                                            	'<div class="deposito">'+
		                                            '<div>Numero de deposito:</div>'+
		                                            '<span class="spn_bancario_deposito error"></span>'+
		                                            '<input type="text" class="tabButton sociedad_deposito" onkeypress="return validar_caracter(event, 1);">'+
		                                            '<div>Numero de boleta:</div>'+
		                                            '<span class="spn_bancario_boleta error"></span>'+
		                                            '<input type="text" class="tabButton sociedad_boleta" onkeypress="return validar_caracter(event, 1);">'+
		                                        '</div>'+
	                                        '</div>'+
                                        	'<input type="button" onclick="DepositoAgregar();" class="fillButton prev" value="Agregar Deposito">'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">'+
                                        '<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">'+
                                            '<input class="fillButton prev" type="button" value="Anterior" onclick="PasoVer('+(paso_actual+1)+');">'+
                                        '</div>'+
                                        '<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">'+
                                            '<input class="fillButton" type="button" value="Siguiente" onclick="PasoBancarioValidar('+(paso_actual+2)+');">'+
                                        '</div>'+   
                                    '</div>'+
                                '</div>'+
                                '<div class="formContract paso" id="div_paso'+(paso_actual+3)+'" style="display:none;">'+
                                    '<span class="legendForm">Paso '+(paso_actual+3)+'</span>'+
                                    '<h2 class="titleGeneral">Información de Acciones</h2>'+
                                    '<div id="div_socios_paso'+(paso_actual+3)+'">'+
                                        '<div id="div_mensaje_error'+(paso_actual+3)+'" class="mensaje_error"></div>'+
                                        '<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 sociedad_paso'+(paso_actual+3)+'">'+
                                            '<div>Valor de cada acción en quetzales:</div>'+
                                            '<select id="slc_sociedad_valor" class="select-bg" onchange="AccionesValorCalcular();">'+
                                            '</select>'+
                                            '<div id="div_acciones"></div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">'+
                                        '<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">'+
                                            '<input class="fillButton prev" type="button" value="Anterior" onclick="PasoVer('+(paso_actual+2)+');">'+
                                        '</div>'+
                                        '<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">'+
                                            '<input class="fillButton" type="button" value="Siguiente" onclick="PasoAccionesValidar('+(paso_actual+3)+');">'+
                                        '</div>'+   
                                    '</div>'+
                                '</div>'+
                                '<div class="formContract paso" id="div_paso'+(paso_actual+4)+'" style="display:none;">'+
                                    '<span class="legendForm">Paso '+(paso_actual+4)+'</span>'+
                                    '<h2 class="titleGeneral">Administración</h2>'+
                                    '<div id="div_socios_paso'+(paso_actual+4)+'">'+
                                        '<div id="div_mensaje_error'+(paso_actual+4)+'" class="mensaje_error"></div>'+
                                        '<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 sociedad_paso'+(paso_actual+4)+'">'+
                                            '<div>Tipo de Administración:</div>'+
                                            '<select id="slc_sociedad_administracion" class="select-bg" onchange="AdministracionConsejo();">'+
                                                '<option value="0">Administración Unica</option>'+
                                                '<option value="1">Consejo de Administración</option>'+
                                            '</select>'+
                                            '<div id="div_administracion">'+
                                            	'<div>Nombre completo del Representante legal</div>'+
                                            	'<span class="spn_administracion_representante error"></span>'+
												'<input type="text" class="tabButton" id="txt_representante" onkeypress="return validar_caracter(event, 0);"/>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">'+
                                        '<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">'+
                                            '<input class="fillButton prev" type="button" value="Anterior" onclick="PasoVer('+(paso_actual+3)+');">'+
                                        '</div>'+
                                        '<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">'+
                                            '<input class="fillButton" type="button" value="Finalizar" onclick="PasoAdministracionValidar('+(paso_actual+4)+');">'+
                                        '</div>'+   
                                    '</div>'+
                                '</div>';
            jQuery('.pasos').append(pasos_finales);
			IconoPasoGenerar(paso_actual+1, 'Información de la Sociedad');
			IconoPasoGenerar(paso_actual+2, 'Información Bancaria');
			IconoPasoGenerar(paso_actual+3, 'Información de Acciones');
			IconoPasoGenerar(paso_actual+4, 'Administración');
        }

		var moduloscompletos;
		function AccionesCalcular(){
			var modulosUno = new Array();
			var modulosDiez = new Array();
			var modulosCien = new Array();
			var modulosMil = new Array();
	        $.each(capitales, function( indice, valor ) {
				valor = parseFloat(valor);
				if(valor%1 == 0){
					modulosUno.push(valor);
				}
				if(valor%10 == 0){
					modulosDiez.push(valor);
				}
				if(valor%100 == 0){
					modulosCien.push(valor);
				}
				if(valor%1000 == 0){
					modulosMil.push(valor);
				}
			});
			moduloscompletos = new Array();
			if(modulosUno.length == capitales.length){
				moduloscompletos.push('1');
			}
			if(modulosDiez.length == capitales.length){
				moduloscompletos.push('10');
			}
			if(modulosCien.length == capitales.length){
				moduloscompletos.push('100');
			}
			if(modulosMil.length == capitales.length){
				moduloscompletos.push('1000');
			}
		}

		var acciones_cantidad;
		var accion_valor;
		function AccionesValorCalcular(){
			var html_acciones = '';
			acciones_cantidad = new Array();
			SociosNombresCapitalObtener();
			console.log('Socios acciones nombres:'+socios_acciones_nombres);
			socios_acciones = new Array();
			$.each(socios_acciones_nombres, function( indice, valor ) {
				accion_valor = jQuery('#slc_sociedad_valor').val();
				var accion_cantidad = capitales[indice]/accion_valor;
				acciones_cantidad.push([indice, accion_cantidad, accion_valor, capitales[indice]]);
				html_acciones += '<div><strong>Socio '+valor[0]+' '+valor[1]+'.</strong></div>'+
								 '<div>Capital: <input type="text" class="tabButton socio_acciones_capital" value="'+capitales[indice]+'" disabled/></div>'+
								 '<div>Cantidad de acciones.</div>'+
                            	 '<input type="text" class="tabButton socio_acciones_cantidad" value="'+accion_cantidad+'" disabled/>';
        		socios_acciones.push([valor[0]+' '+valor[1], capitales[indice], accion_cantidad, accion_valor]);
			});
        	jQuery('#div_acciones').html(html_acciones);
		}

		function SociosNombresCapitalObtener(){
			socios_acciones_nombres = new Array();
			$.each(socios_individual, function( indice, valor ) {
				socios_acciones_nombres.push([valor['nombres'], valor['apellidos'], valor['capital']]);
			});
			$.each(socios_sa, function( indice, valor ) {
				socios_acciones_nombres.push([valor['nombres'], valor['apellidos'], valor['capital']]);
			});
			$.each(socios_juridico, function( indice, valor ) {
				socios_acciones_nombres.push([valor['nombres'], valor['apellidos'], valor['capital']]);
			});
		}

		function AdministracionConsejo(){
			var admin = jQuery('#slc_sociedad_administracion').val();
			var html_admin;
			var html_representante = '';
            $.each(socios_acciones_nombres, function( indice, valor ) {
				html_representante += '<option value="'+valor[0]+' '+valor[1]+'">'+valor[0]+' '+valor[1]+'</option>';
			});
			if(admin == '0'){
				html_admin = '<div>Nombre completo del Representante legal</div>'+
							'<span class="spn_administracion_representante error"></span>'+
							'<input type="text" class="tabButton" id="txt_representante" value="" onkeypress="return validar_caracter(event, 0);"/>';
			}
			else{
				html_admin = '<div>Presidente y Representante legal</div>'+
							'<span class="spn_administracion_presidente error"></span>'+
							'<input type="text" class="tabButton" id="txt_presidente" onkeypress="return validar_caracter(event, 0);"/>'+
							'<div>Secretario</div>'+
							'<span class="spn_administracion_secretario error"></span>'+
							'<input type="text" class="tabButton" id="txt_secretario" onkeypress="return validar_caracter(event, 0);"/>'+
							'<div>Tesorero</div>'+
							'<span class="spn_administracion_tesorero error"></span>'+
							'<input type="text" class="tabButton" id="txt_tesorero" onkeypress="return validar_caracter(event, 0);"/>';
			}
			jQuery('#div_administracion').html(html_admin);
		}

		var administracion;
		function PasoAdministracionValidar(paso){
			jQuery('#div_mensaje_error'+paso).html('');
        	var error = false;
        	var admin = jQuery('#slc_sociedad_administracion').val();
			if(admin == '0'){
				var representante = jQuery('#txt_representante').val();
				if(representante == ''){
					error = true;
					mensaje_error = 'Ingrese el nombre completo del representante legal.';
					jQuery('.spn_administracion_representante').html(mensaje_error);
				}
				else{
					administracion = new Array();
					administracion.push([representante]);
					ContratoGenerar(1);
				}
			}
			else{
				var presidente = jQuery('#txt_presidente').val();
				var secretario = jQuery('#txt_secretario').val();
				var tesorero = jQuery('#txt_tesorero').val();
				if(presidente == ''){
					error = true;
					mensaje_error = 'Ingrese el nombre completo del presidente.';
					jQuery('.spn_administracion_presidente').html(mensaje_error);
				}
				if(secretario == ''){
					error = true;
					mensaje_error = 'Ingrese el nombre completo del secretario.';
					jQuery('.spn_administracion_secretario').html(mensaje_error);
				}
				if(tesorero == ''){
					error = true;
					mensaje_error = 'Ingrese el nombre completo del tesorero.';
					jQuery('.spn_administracion_tesorero').html(mensaje_error);
				}
				if(error == false){
					administracion = new Array();
					administracion.push([presidente, secretario, tesorero]);
					ContratoGenerar(1);
				}
			}
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
			var socios_conteo = 0;
			var texto_socios_individual = '';
			var texto_contrato_acciones_individual = '';
			var texto_contrato_acciones_individual2 = '';
			var acciones_totales_cantidad = 0;
			var acciones_totales_valor = 0;
			var capital_total = 0;
			if(socios_individual.length > 0){
				$.each(socios_individual, function(indice, valor){
					var contrato_socio_nombre = valor['nombres']+' '+valor['apellidos'];
					var contrato_socio_edad = NumerosACantidad(valor['edad']);
					var contrato_socio_civil = valor['civil'];
					var contrato_socio_genero = valor['genero'];
					var contrato_socio_profesion = valor['profesion'];
					var contrato_socio_nacionalidad = valor['nacionalidad'];
					var contrato_socio_departamento = valor['departamento'];
					var contrato_socio_dpi_numeros = valor['dpi'];
					var contrato_socio_dpi_letras = NumerosALetras(valor['dpi']);
					var contrato_socio_identificacion = valor['identificacion'];
					var texto_identificacion = '';
					if(contrato_socio_identificacion == 'Pasaporte:'){
						texto_identificacion = 'Pasaporte número <strong>'+contrato_socio_dpi_letras+'</strong> (<strong>'+contrato_socio_dpi_numeros+'</strong>)';
					}
					else{
						texto_identificacion = 'Documento Personal de Identificación –DPI- con Código Único de Identificación –CUI- <strong>'+contrato_socio_dpi_letras+'</strong> (<strong>'+contrato_socio_dpi_numeros+'</strong>) extendido por el Registrador del Registro Nacional de las Personas';
					}
					texto_socios_individual += indices[socios_conteo]+') <strong>'+contrato_socio_nombre+'</strong>, de <strong>'+contrato_socio_edad+'</strong> años, genero <strong>'+contrato_socio_genero+'</strong>, <strong>'+contrato_socio_civil+'</strong>, <strong>'+contrato_socio_profesion+'</strong>, <strong>'+contrato_socio_nacionalidad+'</strong>, con domicilio en el departamento de <strong>'+contrato_socio_departamento+'</strong>, quien se identifica con el '+texto_identificacion+';';

					var contrato_socio_capital_numeros = capitales[socios_conteo];
					contrato_socio_capital_numeros = parseFloat(contrato_socio_capital_numeros).toFixed(2);
					var contrato_socio_capital_letras = NumerosACantidad(capitales[socios_conteo]);
					var contrato_socio_acciones_numeros = socios_acciones[socios_conteo][2];
					var contrato_socio_acciones_letras = NumerosACantidad(socios_acciones[socios_conteo][2]);
					var contrato_socio_acciones_valor_numeros = socios_acciones[socios_conteo][3];
					contrato_socio_acciones_valor_numeros = parseFloat(contrato_socio_acciones_valor_numeros).toFixed(2);
					var contrato_socio_acciones_valor_letras = NumerosACantidad(socios_acciones[socios_conteo][3]);
					texto_contrato_acciones_individual += indices[socios_conteo]+') <strong>'+contrato_socio_nombre+'</strong> aporta la suma de <strong>'+contrato_socio_capital_letras+'</strong> (Q. <strong>'+contrato_socio_capital_numeros+'</strong>), equivalentes a <strong>'+contrato_socio_acciones_letras+'</strong> (<strong>'+contrato_socio_acciones_numeros+'</strong>) acciones con valor nominal de <strong>'+contrato_socio_acciones_valor_letras+'</strong> (Q. <strong>'+contrato_socio_acciones_valor_numeros+'</strong>) cada una;';

					texto_contrato_acciones_individual2 += indices[socios_conteo]+') '+ 'La aportación de SOCIO <strong>'+contrato_socio_nombre+'</strong> equivale a <strong>'+contrato_socio_acciones_letras+'</strong> acciones;';

					acciones_totales_cantidad += parseInt(socios_acciones[socios_conteo][2]);
					acciones_totales_valor += parseInt(socios_acciones[socios_conteo][3]);
					capital_total += parseInt(capitales[socios_conteo]);
					socios_conteo++;
				});
			}
			var texto_socios_juridico = '';
			var texto_contrato_acciones_juridico = '';
			var texto_contrato_acciones_juridico2 = '';
			if(socios_juridico.length > 0){
				$.each(socios_juridico, function(indice, valor){
					var contrato_socio_nombre = valor['nombres']+' '+valor['apellidos'];
					var contrato_socio_edad = NumerosACantidad(valor['edad']);
					var contrato_socio_civil = valor['civil'];
					var contrato_socio_genero = valor['genero'];
					var contrato_socio_profesion = valor['profesion'];
					var contrato_socio_nacionalidad = valor['nacionalidad'];
					var contrato_socio_departamento = valor['departamento'];
					var contrato_socio_dpi_numeros = valor['dpi'];
					var contrato_socio_dpi_letras = NumerosALetras(valor['dpi']);
					var contrato_socio_identificacion = valor['identificacion'];
					var texto_identificacion = '';
					if(contrato_socio_identificacion == 'Pasaporte:'){
						texto_identificacion = 'Pasaporte número <strong>'+contrato_socio_dpi_letras+'</strong> (<strong>'+contrato_socio_dpi_numeros+'</strong>)';
					}
					else{
						texto_identificacion = 'Documento Personal de Identificación –DPI- con Código Único de Identificación –CUI- <strong>'+contrato_socio_dpi_letras+'</strong> (<strong>'+contrato_socio_dpi_numeros+'</strong>) extendido por el Registrador del Registro Nacional de las Personas';
					}
					texto_socios_juridico += indices[socios_conteo]+') <strong>'+contrato_socio_nombre+'</strong>, de <strong>'+contrato_socio_edad+'</strong> años, genero <strong>'+contrato_socio_genero+'</strong>, <strong>'+contrato_socio_civil+'</strong>, <strong>'+contrato_socio_profesion+'</strong>, <strong>'+contrato_socio_nacionalidad+'</strong>, con domicilio en el departamento de <strong>'+contrato_socio_departamento+'</strong>, quien se identifica con el '+texto_identificacion+';';

					var contrato_socio_capital_numeros = capitales[socios_conteo];
					contrato_socio_capital_numeros = parseFloat(contrato_socio_capital_numeros).toFixed(2);
					var contrato_socio_capital_letras = NumerosACantidad(capitales[socios_conteo]);
					var contrato_socio_acciones_numeros = socios_acciones[socios_conteo][2];
					var contrato_socio_acciones_letras = NumerosACantidad(socios_acciones[socios_conteo][2]);
					var contrato_socio_acciones_valor_numeros = socios_acciones[socios_conteo][3];
					contrato_socio_acciones_valor_numeros = parseFloat(contrato_socio_acciones_valor_numeros).toFixed(2);
					var contrato_socio_acciones_valor_letras = NumerosACantidad(socios_acciones[socios_conteo][3]);
					texto_contrato_acciones_juridico += indices[socios_conteo]+') <strong>'+contrato_socio_nombre+'</strong> aporta la suma de <strong>'+contrato_socio_capital_letras+'</strong> (Q. <strong>'+contrato_socio_capital_numeros+'</strong>), equivalentes a <strong>'+contrato_socio_acciones_letras+'</strong> (<strong>'+contrato_socio_acciones_numeros+'</strong>) acciones con valor nominal de <strong>'+contrato_socio_acciones_valor_letras+'</strong> (Q. <strong>'+contrato_socio_acciones_valor_numeros+'</strong>) cada una;';

					texto_contrato_acciones_juridico2 += indices[socios_conteo]+') '+ 'La aportación de SOCIO <strong>'+contrato_socio_nombre+'</strong> equivale a <strong>'+contrato_socio_acciones_letras+'</strong> acciones;';

					acciones_totales_cantidad += parseInt(socios_acciones[socios_conteo][2]);
					acciones_totales_valor += parseInt(socios_acciones[socios_conteo][3]);
					capital_total += parseInt(capitales[socios_conteo]);
					socios_conteo++;
				});
			}
			var texto_socios_sociedad = '';
			var texto_contrato_acciones_sociedad = '';
			var texto_contrato_acciones_sociedad2 = '';
			if(socios_sa.length > 0){
				$.each(socios_sa, function(indice, valor){
					var contrato_socio_nombre = valor['nombres']+' '+valor['apellidos'];
					var contrato_socio_edad = NumerosACantidad(valor['edad']);
					var contrato_socio_civil = valor['civil'];
					var contrato_socio_genero = valor['genero'];
					var contrato_socio_profesion = valor['profesion'];
					var contrato_socio_nacionalidad = valor['nacionalidad'];
					var contrato_socio_departamento = valor['departamento'];
					var contrato_socio_dpi_numeros = valor['dpi'];
					var contrato_socio_dpi_letras = NumerosALetras(valor['dpi']);
					var contrato_socio_identificacion = valor['identificacion'];
					var texto_identificacion = '';
					if(contrato_socio_identificacion == 'Pasaporte:'){
						texto_identificacion = 'Pasaporte número <strong>'+contrato_socio_dpi_letras+'</strong> (<strong>'+contrato_socio_dpi_numeros+'</strong>)';
					}
					else{
						texto_identificacion = 'Documento Personal de Identificación –DPI- con Código Único de Identificación –CUI- <strong>'+contrato_socio_dpi_letras+'</strong> (<strong>'+contrato_socio_dpi_numeros+'</strong>) extendido por el Registrador del Registro Nacional de las Personas';
					}
					texto_socios_sociedad += indices[socios_conteo]+') <strong>'+contrato_socio_nombre+'</strong>, de <strong>'+contrato_socio_edad+'</strong> años, genero <strong>'+contrato_socio_genero+'</strong>, <strong>'+contrato_socio_civil+'</strong>, <strong>'+contrato_socio_profesion+'</strong>, <strong>'+contrato_socio_nacionalidad+'</strong>, con domicilio en el departamento de <strong>'+contrato_socio_departamento+'</strong>, quien se identifica con el '+texto_identificacion+';';

					var contrato_socio_capital_numeros = capitales[socios_conteo];
					contrato_socio_capital_numeros = parseFloat(contrato_socio_capital_numeros).toFixed(2);
					var contrato_socio_capital_letras = NumerosACantidad(capitales[socios_conteo]);
					var contrato_socio_acciones_numeros = socios_acciones[socios_conteo][2];
					var contrato_socio_acciones_letras = NumerosACantidad(socios_acciones[socios_conteo][2]);
					var contrato_socio_acciones_valor_numeros = socios_acciones[socios_conteo][3];
					contrato_socio_acciones_valor_numeros = parseFloat(contrato_socio_acciones_valor_numeros).toFixed(2);
					var contrato_socio_acciones_valor_letras = NumerosACantidad(socios_acciones[socios_conteo][3]);
					texto_contrato_acciones_sociedad += indices[socios_conteo]+') <strong>'+contrato_socio_nombre+'</strong> aporta la suma de <strong>'+contrato_socio_capital_letras+'</strong> (Q. <strong>'+contrato_socio_capital_numeros+'</strong>), equivalentes a <strong>'+contrato_socio_acciones_letras+'</strong> (<strong>'+contrato_socio_acciones_numeros+'</strong>) acciones con valor nominal de <strong>'+contrato_socio_acciones_valor_letras+'</strong> (Q. <strong>'+contrato_socio_acciones_valor_numeros+'</strong>) cada una;';

					texto_contrato_acciones_sociedad2 += indices[socios_conteo]+') '+ 'La aportación de SOCIO <strong>'+contrato_socio_nombre+'</strong> equivale a <strong>'+contrato_socio_acciones_letras+'</strong> acciones;';

					acciones_totales_cantidad += parseInt(socios_acciones[socios_conteo][2]);
					acciones_totales_valor += parseInt(socios_acciones[socios_conteo][3]);
					capital_total += parseInt(capitales[socios_conteo]);
					socios_conteo++;
				});
			}
			/*Capital*/
			var contrato_capital_numeros = parseFloat(capital_total).toFixed(2);
			var contrato_capital_letras = NumerosACantidad(capital_total);
			/*Acciones*/
			var acciones_totales_valor_letras = NumerosACantidad(acciones_totales_valor);
			acciones_totales_valor = parseFloat(acciones_totales_valor).toFixed(2);
			var acciones_totales_cantidad_letras = NumerosACantidad(acciones_totales_cantidad);
			var accion_valor_letras = NumerosACantidad(accion_valor);
			accion_valor = parseFloat(accion_valor).toFixed(2);
			var contrato_socios = texto_socios_individual+texto_socios_juridico+texto_socios_sociedad;
			var contrato_acciones = texto_contrato_acciones_individual+texto_contrato_acciones_juridico+texto_contrato_acciones_sociedad;
			var contrato_acciones2 = texto_contrato_acciones_individual2+texto_contrato_acciones_juridico2+texto_contrato_acciones_sociedad2;
			/*sociedad*/
			var contrato_sociedad_departamento = socios_sociedad[0];
			var contrato_sociedad_ciudad = socios_sociedad[1];
			var contrato_sociedad_nombre = socios_sociedad[2];
			var contrato_sociedad_comercial = socios_sociedad[3];
			var contrato_sociedad_actividad = socios_sociedad[4];
			var contrato_sociedad = 'DOMICILIO: El Departamento de <strong>'+contrato_sociedad_departamento+'</strong>, teniendo su sede en la ciudad de <strong>'+contrato_sociedad_ciudad+'</strong>, pero podrá establecer sucursales, agencias, establecimientos mercantiles, extensiones o actividades comerciales, empresas, bodegas u oficinas dentro del país o en el extranjero; pudiendo trasladar su domicilio cuando más convenga al desarrollo de sus actividades y así sea acordado por la Asamblea General de Accionistas. NUMERAL CUATRO (4). PLAZO: La duración de la sociedad será indefinida y su plazo principiará a contarse desde la fecha de su inscripción en el Registro Mercantil. NUMERAL CINCO (5). DENOMINACIÓN: La sociedad se denominará <strong>'+contrato_sociedad_nombre+'</strong> SOCIEDAD ANÓNIMA, que podrá abreviarse de conformidad con la ley y usará el nombre comercial <strong>'+contrato_sociedad_comercial+'</strong> o el que determine y acuerde el Órgano de Administración. La traducción a otros idiomas de la denominación o del nombre comercial no significa cambio alguno de los mismos. NUMERAL SEIS (6). OBJETO: El objeto de la sociedad lo constituyen las actividades que a continuación se enumeran, con carácter ejemplificativo y nunca limitativo: a) <strong>'+contrato_sociedad_actividad+'</strong>; b) Prestación de servicios varios; c) Comprar, permutar, vender, ceder y transferir o de otro modo enajenar, invertir manejar, comerciar, arrendar, administrar por su propia cuenta como por cuenta de cualquier clase de personas o sociedades, toda clase de bienes, derechos y acciones, así como su adquisición, explotación y disposición bajo cualquier título, pudiendo efectuar toda clase de inversiones mobiliarias e inmobiliarias, instalar, operar y explotar industrias, negocios o servicios y en fin efectuar todos aquellos actos ya sean de carácter civil o mercantil, que se relacionen en una u otra forma con el objeto, tipo de negocios y prestación de servicios relativos; d) Recibir y contratar préstamos o créditos para la realización de las actividades que forman parte del objeto principal de sus negocios; e) Realizar operaciones conexas, complementarias o cualesquiera otras necesarias o convenientes para un adecuado servicio, siempre que no estén prohibidas por la ley; f) cualquier actividad lícita y lucrativa relacionada directa o indirectamente con el objeto principal de sus negocios, así como cualquier actividad industrial, agrícola, comercial o de servicios que se relacionen con dicho objeto. Para el cumplimiento del objeto y fines de la sociedad, ésta podrá igualmente dedicarse a la prestación de servicios en cualquiera de sus formas, la realización de toda clase de negocios y promover contratos mercantiles en nombre y por cuenta de sus principales. Asimismo podrá, para el cumplimiento de sus fines adquirir y disponer de bienes muebles e inmuebles en la forma que se estime conveniente, descontar y pedir el descuento de títulos de crédito, valores y participaciones; prestar y solicitar todo tipo de garantías reales y/o personales; g) obtener financiamiento y disponer de los bienes propios en la forma que considere más conveniente a sus fines. Las actividades anteriormente relacionadas podrán ser desarrolladas por la sociedad total o parcialmente de modo indirecto, mediante la titularidad de acciones o participaciones sociales  en sociedades o participaciones en cualesquiera otras entidades con objeto idéntico o análogo. Todas las actividades que integran el objeto social podrán desarrollarse tanto en Guatemala como en el extranjero. En términos del cumplimiento de los fines y objeto de la sociedad, no podrá suponerse limitada la actividad de la sociedad a tales rubros, sino debe entenderse en el sentido más amplio posible.  En términos del cumplimiento de los fines y objeto de la sociedad, no podrá suponerse limitada la actividad de la sociedad a tales rubros, sino que debe entenderse en el sentido más amplio posible.';
			/*Administracion*/	
			var admin = jQuery('#slc_sociedad_administracion').val();
			if(admin == '0'){
				var contrato_representante = administracion[0][0];
				var contrato_administracion = 'Los otorgantes, en la calidad con que actúan y como únicos accionistas de la entidad que se constituye, designan como primer órgano de administración de la entidad <strong>'+contrato_sociedad_nombre+'</strong>, el de Administrador Único, cargo para el cual se designa a <strong>'+contrato_representante+'</strong>, quien durará en su cargo un período de TRES (3) AÑOS, contados a partir del día de hoy y hasta que se nombre nuevo órgano de administración y éste tome o tomen posesión de su cargo. El Administrador Único aquí nombrado tendrá plena representación legal de la entidad en juicio y fuera de él y el uso de la denominación, además de todas las facultades que señala la escritura de constitución de la sociedad y la ley, teniendo amplias facultades para otorgar cualquier clase de mandatos, incluso judiciales, que sean necesarios para poder llevar a cabo el objeto de la sociedad, mismos que podrá revocar en cualquier momento.';
			}
			else{
				var contrato_presidente = administracion[0][0];
				var contrato_secretario = administracion[0][1];
				var contrato_tesorero = administracion[0][2];
				var contrato_administracion = 'Los otorgantes, en la calidad con que actúan y como únicos accionistas de la entidad que se constituye, designan como primer órgano de administración de la entidad <strong>'+contrato_sociedad_nombre+'</strong>, el de Consejo de Administración, cuyos miembros serán <strong>'+contrato_presidente+'</strong> como presidente y representante legal, <strong>'+contrato_secretario+'</strong> como Secretario y <strong>'+contrato_tesorero+'</strong> como Tesorero, quienes durarán en su cargo un período de TRES (3) AÑOS, contados a partir del día de hoy y hasta que se nombre nuevo órgano de administración y éste tome o tomen posesión de su cargo. El Administrador Único aquí nombrado tendrá plena representación legal de la entidad en juicio y fuera de él y el uso de la denominación, además de todas las facultades que señala la escritura de constitución de la sociedad y la ley, teniendo amplias facultades para otorgar cualquier clase de mandatos, incluso judiciales, que sean necesarios para poder llevar a cabo el objeto de la sociedad, mismos que podrá revocar en cualquier momento.';
			}
			/*Banco*/
			var contrato_banco = socios_bancario[0];
			var contrato_cuenta_numeros = socios_bancario[3];
			var contrato_cuenta_letras = NumerosALetras(socios_bancario[3]);
			var contrato_deposito_letras = NumerosALetras(socios_bancario[1]);
			var contrato_deposito_numeros = socios_bancario[1];
			var contrato_deposito_fecha = 'FECHA DEL DEPOSITO';
			/*Contrato Completo*/
			var contrato_contenido = 'NUMERO ** [**] CONSTITUCIÓN DE SOCIEDAD MERCANTIL. En la ciudad de Guatemala, el ***, ante mí, ***, Notario, comparecen: '+contrato_socios+' Yo, el infrascrito Notario, hago constar que he tenido a la vista los documentos relacionados y que los comparecientes me aseguran ser de las generales indicadas, hallarse en el libre ejercicio de sus derechos civiles, por el presente acto constituyen una SOCIEDAD MERCANTIL, la que se organiza y funcionará conforme lo que disponga la presente escritura, sus ampliaciones y modificaciones; por las resoluciones aprobadas por las Asambleas de Accionistas y Órgano de Administración; y por lo dispuesto en el Código de Comercio de Guatemala (Decreto dos guión setenta del Congreso de la República y sus reformas); en la siguiente forma: PRIMERA: NUMERAL UNO (1). CLASE: Sociedad Anónima. NUMERAL DOS (2). NACIONALIDAD: Guatemalteca. NUMERAL TRES (3). '+contrato_sociedad+' NUMERAL SIETE (7). CAPITAL SOCIAL: El capital social autorizado es de <strong>'+contrato_capital_letras+'</strong> (Q. <strong>'+contrato_capital_numeros+'</strong>), que será dividido y representado por <strong>'+acciones_totales_cantidad_letras+'</strong> acciones comunes con un valor nominal de <strong>'+accion_valor_letras+'</strong> QUETZALES (Q. <strong>'+accion_valor+'</strong>) cada una. NUMERAL OCHO (8). CAPITAL SUSCRITO Y PAGADO: Se suscribe y paga en este acto la suma de <strong>'+contrato_capital_letras+'</strong> (Q. <strong>'+contrato_capital_numeros+'</strong>) del capital social autorizado, el cual se paga de la manera siguiente: '+contrato_acciones+' Los accionistas efectuaron el pago mediante depósito dinerario efectuado en el BANCO <strong>'+contrato_banco+'</strong> SOCIEDAD ANÓNIMA por la suma de <strong>'+contrato_capital_letras+'</strong> (Q. <strong>'+contrato_capital_numeros+'</strong>). Como Notario, CERTIFICO tener a la vista la constancia de depósito respectivo por la suma de <strong>'+contrato_capital_letras+'</strong> (Q. <strong>'+contrato_capital_numeros+'</strong>), identificada con el número <strong>'+contrato_deposito_letras+'</strong>  (<strong>'+contrato_deposito_numeros+'</strong>) de fecha <strong>'+contrato_deposito_fecha+'</strong>, para acreditar a la cuenta de depósitos monetarios del Banco <strong>'+contrato_banco+'</strong>, Sociedad Anónima en la cuenta número <strong>'+contrato_cuenta_letras+'</strong> (<strong>'+contrato_cuenta_numeros+'</strong>) a nombre de la sociedad que se constituye.  Por lo tanto se suscriben y pagan en este acto la cantidad de <strong>'+acciones_totales_cantidad_letras+'</strong> ACCIONES, en las proporciones siguientes: '+contrato_acciones2+' NUMERAL NUEVE (9). RESPONSABILIDAD: La responsabilidad de cada accionista se limita al monto de su participación en la sociedad representada por su capital y reservas, en la parte alícuota correspondiente al número de acciones. NUMERAL DIEZ (10). ACCIONES: Todas las acciones serán de igual valor, comunes entre sí, de clase única y no pagarán intereses, primas, ni amortizaciones de cualquier clase y sólo devengarán dividendos cuando así lo decida la Asamblea General de Accionistas; conferirán iguales derechos a sus titulares; no habrá acciones preferentes, salvo que así lo disponga la Asamblea General, quien decidirá sobre sus características. Cada acción conferirá a su titular derecho a un voto. NUMERAL ONCE (11). INDIVISIBILIDAD DE LAS ACCIONES: Las acciones son indivisibles. Los titulares de una o más acciones deberán unificar en una sola persona el ejercicio del voto, ya sea que lo ejerza uno de los copropietarios o un tercero que sea representante común de los mismos. Para el caso de que la nuda propiedad y el usufructo de una o más acciones no pertenezcan a la misma persona, la sociedad tendrá como accionista con derecho a voto  y con derecho preferente para suscripción de nuevas acciones al nudo propietario, sin perjuicio de los efectos legales del usufructo. En caso de pignoración de acciones la sociedad reconocerá el derecho a voto y todos los demás inherentes a la acción, únicamente al titular de la misma. En cualquier evento, queda a salvo lo que las partes hubiesen convenido en contrario. NUMERAL DOCE (12). TÍTULOS: Las acciones únicamente pueden ser nominativas. Las acciones estarán representadas por títulos que servirán para acreditar y transmitir la calidad de accionista. Los títulos podrán representar una o varias acciones a elección del titular. En tanto se emiten los títulos definitivos, podrán expedirse certificados provisionales, los que se canjearán por los definitivos cuando éstos se hayan emitido. Los certificados provisionales serán nominativos y deberán llenar los mismos requisitos de los títulos definitivos. NUMERAL TRECE (13). CONTENIDO: Los títulos de acciones deben contener por lo menos lo que establece el artículo número ciento siete (107) del Código de Comercio (Decreto número dos guión setenta (2‑70) del Congreso de la República y sus reformas). Los certificados provisionales, así como los títulos definitivos de acciones, serán firmados por el Administrador Único o por el Presidente del Consejo de Administración, según sea el caso. NUMERAL CATORCE (14). ACCIONISTAS: La sociedad considerará como accionista al inscrito como tal en el Registro de Accionistas. La acción confiere a su titular la condición de accionista, sometiéndolo a los términos de la presente escritura, a las determinaciones de los Órganos Sociales y a lo establecido en el Código de Comercio. El Registro de Accionistas de la Sociedad, así como cualquier otro libro o documento  legalmente requerido podrá ser electrónico en aquellos casos en que no sea prohibido por la ley.  NUMERAL QUINCE (15). DERECHOS DE LOS ACCIONISTAS: Son derechos de los accionistas, además de los consignados en la presente escritura, y/o sus modificaciones y lo que establece el Código de Comercio, los siguientes: a) Participar en la distribución de las utilidades y en el haber social al momento de la liquidación de la misma; b) Derecho preferente, en proporción a su participación, para suscribir acciones de nueva emisión; Derecho preferente, en proporción a su participación, para adquirir las acciones de otro socio que quisiera enajenarlas; c) Participar con voz y voto en las Asambleas Generales de Accionistas; d) Examinar por sí o por medio de los delegados que designen, la contabilidad y documentos de la sociedad, así como enterarse de la política Económico‑Financiera de la misma, este derecho lo ejercerán, por lo menos, dentro de los quince días anteriores a la fecha en que haya de celebrarse la Asamblea General Anual de Accionistas; e) Promover judicialmente ante el Juez de Primera Instancia del Ramo Civil correspondiente la convocatoria a Asamblea General de Accionistas de la sociedad, si pasada la época en que deba celebrarse según la presente escritura, o transcurrido más de un año desde la última Asamblea General Anual de Accionistas, los administradores no lo hubieren hecho o si habiéndose celebrado no se hubiere ocupado de los asuntos que indica el artículo ciento treinta y cuatro (134) del Código de Comercio. El Juez resolverá el asunto en incidente con audiencia de los administradores; f) Exigir a la sociedad el reintegro de los gastos en que incurran por el desempeño de sus obligaciones para con la misma; g) Reclamar contra la forma de distribución de las utilidades o pérdidas dentro de los tres meses siguientes a la Asamblea General de Accionistas en que ella se hubiere acordado. Sin embargo carecerá de ese derecho el accionista que la hubiere aprobado con su voto o que hubiere empezado a cumplirla; h) Pedir que la Asamblea General Ordinaria Anual de Accionistas resuelva sobre la distribución de utilidades. NUMERAL DIECISÉIS (16). OBLIGACIONES DE LOS ACCIONISTAS: a) Aceptar las disposiciones de esta escritura, sus modificaciones y ampliaciones; b) Aceptar las resoluciones que sean debidamente tomadas por los Órganos de la sociedad; y, c) No usar el patrimonio o la denominación social para negocios ajenos a la sociedad. NUMERAL DIECISIETE (17). REGISTRO: La sociedad llevará un libro de registro de las acciones nominativas y de los certificados provisionales que emita, el cual además de los datos que determine el Órgano de Administración correspondiente, deberá contener los siguientes: a) El nombre y el domicilio del accionista, la indicación de las acciones que le pertenezcan, expresándose claramente los números de registro y de orden, así como las particularidades que las identifiquen; b) Los llamamientos efectuados y los pagos hechos; c) Las transmisiones que se realicen; d) Los canjes de títulos; e) Los gravámenes que afecten a las acciones; f) Las cancelaciones de los gravámenes; y, g) Las cancelaciones de los títulos. NUMERAL DIECIOCHO (18). FORMA DE TRANSFERENCIA DE LAS ACCIONES: Las acciones se transferirán mediante: i) aprobación previa del Órgano de Administración, quien deberá resolver en un plazo no mayor a quince (15) días, el silencio por parte de los administradores se entenderá como aceptación a la solicitud presentada. En caso de negar la autorización el órgano de administración podrá designar comprador, al precio que sea determinado por los expertos, con base en la contabilidad de la sociedad, tomando en cuenta para el efecto el derecho preferente de los otros accionistas; ii) endoso del título que ampare las acciones; e, iii) inscripción del endoso realizado en los registros de la sociedad.  En el caso de que los títulos que amparen este tipo de acciones deban ser enajenados coactivamente, el acreedor o el funcionario que realice la venta deberá ponerlo en conocimiento de la sociedad, para que ésta pueda hacer uso de los derechos que este artículo le confiere. La sociedad no está obligada a inscribir ninguna transmisión de las acciones nominativas, que se haga en forma distinta a las previstas en este inciso. La sociedad sólo puede adquirir sus propias acciones en caso de exclusión o separación de un accionista y siempre que tenga utilidades acumuladas y reservas de capital, excluyendo la reserva legal. Si el total de las utilidades y reservas de capital no fueren suficientes para cubrir el valor de las acciones a adquirir, deberá procederse a reducir el capital. Sólo se podrá disponer de las acciones que la sociedad adquiera por exclusión o separación de un accionista, con autorización de la Asamblea General de Accionistas y nunca a un precio menor que el de su adquisición. Los derechos que otorgan las acciones así adquiridas, quedarán en suspenso, mientras ellas permanezcan en propiedad de la sociedad. Si en un plazo de seis meses la sociedad no ha logrado la venta de tales acciones, deberá reducirse el capital, con observación de los requisitos legales. Las disposiciones de este numeral aplicarán de igual forma a los Certificados Provisionales emitidos por la sociedad.  NUMERAL DIECINUEVE (19). REPOSICIÓN DE ACCIONES: En caso de destrucción o pérdida, la reposición de las acciones la hará la sociedad por resolución del Órgano de Administración. NUMERAL VEINTE (20). EJERCICIO SOCIAL: El ejercicio financiero de la sociedad será anual y se computará desde el uno de enero al treinta y uno de diciembre de cada año, a excepción del primero que correrá desde la fecha en que la sociedad inicie sus operaciones hasta el treinta y uno de diciembre del presente año. NUMERAL VEINTIUNO (21). UTILIDADES: En el reparto de utilidades obtenidas se observarán las reglas establecidas en los incisos primero y segundo del artículo treinta y tres (33) del Código de Comercio (Decreto dos guión setenta del Congreso de la República y sus reformas). Queda prohibida la distribución de utilidades que no se hayan realmente obtenido conforme el Balance General del Ejercicio. Aparte de las utilidades del ejercicio social recién pasado, también se podrán distribuir las utilidades acumuladas de ejercicios anteriores. Los administradores que autoricen pagos en contravención de lo anterior y los accionistas que los hubieren percibido responderán solidariamente de su reintegro a la sociedad, lo que podrá ser exigido por la propia sociedad, por sus acreedores y por los otros accionistas. NUMERAL VEINTIDÓS (22). RESERVAS: De las utilidades netas de cada ejercicio se separará anualmente el cinco por ciento (5%) para formar la reserva legal. La reserva legal no podrá ser distribuida en forma alguna entre los accionistas sino hasta la liquidación de la sociedad; sin embargo podrá capitalizarse cuando exceda del quince por ciento (15%) del capital al cierre del ejercicio inmediato anterior, sin perjuicio de seguir capitalizando el cinco por ciento (5%) anual a que se refiere la primera parte de este numeral. NUMERAL VEINTITRÉS (23) ÓRGANOS DE LA SOCIEDAD: Las funciones de dirección, administración y fiscalización se ejercerán por medio de los órganos de la sociedad que son: Asamblea General de Accionistas, Consejo de Administración o Administrador Único, Gerencia General, Auditoría Interna y Comisión de Fiscalización y/o Auditoría Externa, en caso que sus miembros sean nombrados. NUMERAL VEINTICUATRO (24). ASAMBLEA GENERAL: La Asamblea General formada por los accionistas legalmente convocados y reunidos, es el órgano supremo de la sociedad y expresa la voluntad social en las materias de su competencia. NUMERAL VEINTICINCO (25). CLASES DE ASAMBLEAS GENERALES: Las Asambleas Generales de Accionistas son de dos clases: a) Ordinarias y b) Extraordinarias. NUMERAL VEINTISÉIS (26). ASAMBLEAS GENERALES ORDINARIAS: La Asamblea General Ordinaria de Accionistas se reunirá por lo menos una vez al año, dentro de los cuatro meses que sigan al cierre del ejercicio social y en cualquier tiempo en que sea convocada y se reúna el quórum necesario, correspondiéndole: a) Discutir, aprobar o improbar el Estado de Pérdidas y Ganancias, Balance General e Informe del Consejo de Administración y del Órgano de Fiscalización; b) Fijación del número, nombramiento y remoción de los Administradores y del Órgano de Fiscalización así como determinación de los emolumentos de los mismos; c) Conocer y resolver sobre el proyecto de distribución de utilidades que debe someter a su consideración el Órgano de Administración respectivo; y, d) Cualquier otro asunto incluido en la Agenda o propuesto por los accionistas concurrentes. NUMERAL VEINTISIETE (27). ASAMBLEAS GENERALES EXTRAORDINARIAS: La Asamblea General Extraordinaria de Accionistas se reunirá en cualquier tiempo, siendo de su competencia conocer y aprobar: a) Toda modificación de la escritura social, incluyendo el aumento o reducción de capital, disolución, fusión o liquidación de la sociedad; b) La adquisición de acciones de la misma sociedad y la disposición de ellas; c) Aumento o disminución del valor nominal de las acciones; d) Las políticas, directrices, normativas, regulaciones, disposiciones, códigos y cuadros de mando/autoridad que sean emitidas o aprobadas por, o aplicables a, las entidades accionistas de la sociedad y que le sean aplicables a ésta, sus funcionarios, colaboradores, representantes, mandatarios, actividades u objetivos; y, e) Cualquier otro asunto para el que sea convocada, aún cuando sea competencia de la Asamblea Ordinaria. Dentro de los quince días siguientes a la celebración de cada Asamblea General Extraordinaria, el Órgano de Administración de la sociedad deberá enviar al Registro Mercantil una copia certificada de las resoluciones que se hayan adoptado. NUMERAL VEINTIOCHO (28). OTRAS ASAMBLEAS: Cualquier otra Asamblea Ordinaria de Accionistas que se convoque podrá conocer y resolver cualquier asunto que no sea de conocimiento exclusivo de la Asamblea Extraordinaria de Accionistas. NUMERAL VEINTINUEVE (29). LUGAR Y FECHA DE LA CELEBRACIÓN DE ASAMBLEAS GENERALES: Las Asambleas Generales de Accionistas deberán celebrarse en el lugar y fecha que determine la convocatoria, pudiendo llevarse a cabo fuera de la República de Guatemala. Si no fuera posible concluir la agenda aprobada por la Asamblea General, dicha Asamblea podrá acordar su continuación en los días inmediatos siguientes, hasta la conclusión de su Agenda. NUMERAL TREINTA (30). CONVOCATORIA: Las Asambleas Generales Ordinarias y Extraordinarias de Accionistas podrán ser convocadas por el Consejo de Administración o por el Administrador Único, en su caso, por sí o a solicitud de accionistas que representen por lo menos el veinticinco por ciento (25%) del capital pagado, o por el Órgano de Fiscalización. La convocatoria a las Asambleas Generales de Accionistas deberá hacerse mediante avisos publicados por lo menos dos veces  en el Diario Oficial o en otro de los de mayor circulación en el país, con no menos de quince (15) días de anticipación a la fecha de su celebración. La convocatoria deberá contener: a) el nombre de la sociedad; b) el lugar, fecha y hora de la reunión; c) la indicación de si se trata de Asamblea Ordinaria o Extraordinaria; d) los requisitos que se necesiten para participar en ella; y, e) la Agenda para la sesión, si se trata de una Asamblea Extraordinaria. A los tenedores de acciones nominativas de la sociedad se les enviará un aviso por correo con no menos de quince (15) días de anticipación a la fecha de su celebración, que contenga los detalles indicados y la Agenda para la sesión. La  convocatoria podrá tener una segunda convocatoria en la que se señale el lugar y la hora en que se celebrará la asamblea, si no fuere posible llevarse a cabo la asamblea en la fecha en que fue primeramente convocada por falta de quórum. NUMERAL TREINTA Y UNO (31). ASAMBLEAS GENERALES ORDINARIAS O EXTRAORDINARIAS TOTALITARIAS: No obstante lo anteriormente establecido, si concurrieren la totalidad de los accionistas podrá realizarse la Asamblea General Totalitaria, sin necesidad de convocatoria previa, siempre que ningún accionista se opusiere a celebrarla y que la Agenda sea aprobada por unanimidad. NUMERAL TREINTA Y DOS (32). QUÓRUM: Para que una Asamblea General Ordinaria de Accionistas se considere válidamente reunida, deberán encontrarse representadas en la misma, por lo menos la mitad de las acciones emitidas que tengan derecho a voto. Para que una Asamblea General Extraordinaria de Accionistas se considere válidamente reunida deberán encontrarse representadas en la misma, por lo menos el sesenta por ciento (60%) de las acciones que tengan derecho a voto. No obstante lo anteriormente establecido, se considerarán válidamente reunidas las Asambleas Ordinarias o Extraordinarias de Segunda convocatoria con la presencia del treinta y uno por ciento (31%) de las acciones emitidas con derecho a voto. La desintegración del quórum de presencia no será obstáculo para que la Asamblea continúe y pueda adoptar acuerdos, si son votados por las mayorías que la presente escritura establece. Las Asambleas Generales se podrán llevar a cabo con la presencia física de los accionistas, o sus representantes, o por medio de conferencia telefónica, videoconferencia u otro medio de comunicación que permita deliberar, proponer y acordar. NUMERAL TREINTA Y TRES (33). MAYORÍAS: Tanto en las Asambleas Ordinarias como en las Extraordinarias de accionistas, cada acción dará derecho a un voto. En las Asambleas Ordinarias de primera convocatoria se tomarán las resoluciones por el CINCUENTA Y UNO por ciento (51%) de las acciones presentes y representadas y, en las Asambleas Extraordinarias de Primera convocatoria las resoluciones se tomarán con más del CINCUENTA Y UNO por ciento (51%) de las acciones emitidas por la sociedad con derecho a voto. Tratándose de Asambleas Ordinarias o Extraordinarias de segunda convocatoria, se requerirá la presencia como mínimo del treinta y uno por ciento (31%) de las acciones con derecho a voto y las resoluciones se tomarán por la mayoría simple de votos presentes o representados. Sin embargo, tratándose de los siguientes asuntos: a) Toda modificación de la escritura social, incluyendo el aumento o reducción del capital; b) Creación de acciones de voto limitado o preferentes y la emisión de obligaciones o bonos, cuando no esté previsto en la escritura social; c) La adquisición de acciones de la misma sociedad y la disposición de ellas; y, d) Aumentar o disminuir el valor nominal de las acciones; en Asambleas Generales de Segunda Convocatoria las resoluciones deberán tomarse por el voto favorable de por lo menos el treinta y uno por ciento (31%) del total de las acciones emitidas con derecho a voto. Para los casos de fusión o liquidación de la sociedad se exigirá que el acuerdo se tome, como mínimo, por los accionistas que representen el SESENTA Y CINCO por ciento (65%) del capital pagado y con derecho a voto. NUMERAL TREINTA Y CUATRO (34). ASISTENCIA A LAS ASAMBLEAS GENERALES: Podrán asistir a las Asambleas Generales de Accionistas por sí o por medio de representante acreditado, los titulares de Acciones nominativas que aparezcan inscritos en los registros de la sociedad en el momento de celebración de la Asamblea. Lo anterior se entiende salvo que la Asamblea sea Totalitaria. Una misma persona, sea o no accionista, podrá ejercer la representación de uno o varios accionistas en las Asambleas Generales de Accionistas mediante delegación mediante mandato o simple carta. NUMERAL TREINTA Y CINCO (35). ESTADOS E INFORMES: Durante los quince (15) días anteriores a la Asamblea Ordinaria Anual de Accionistas que debe celebrarse dentro de los cuatro meses siguientes al cierre del ejercicio social, estará a disposición de los accionistas en las oficinas centrales de la entidad durante las horas laborales, de los días hábiles: a) El Balance General del ejercicio social y su correspondiente estado de pérdidas y ganancias; b) Proyecto de distribución de utilidades; c) Informe detallado sobre las remuneraciones y otros beneficios de cualquier orden que hayan recibido los administradores; d) Memoria razonada de los administradores en cuanto a labores, sobre el estado de los negocios y actividades de la sociedad durante el período precedente; e) Libro de actas de las Asambleas Generales; f) Libros que se refieren a la emisión y registro de acciones y de obligaciones; g) Informe del Órgano de Fiscalización; y, h) Cualquier otro documento o dato necesario para la debida comprensión e inteligencia de cualquier asunto incluido en la Agenda. Cuando se trate de Asambleas Generales, que no sean anuales, los accionistas gozarán de igual derecho, en cuanto a los documentos señalados en los incisos f), g) y h) de este numeral. En caso de Asambleas Extraordinarias o Especiales, deberá además circular con la misma antelación un informe circunstanciado sobre cuanto concierne a la necesidad de adoptar la resolución de carácter extraordinario. NUMERAL TREINTA Y SEIS  (36). PRESIDENTE Y SECRETARIO DE LAS ASAMBLEAS GENERALES: Las Asambleas Generales de Accionistas serán presididas por el Presidente del Consejo de Administración o el Administrador Único, y alternativamente, la propia Asamblea designará a la persona que habrá de presidirla. Fungirá como Secretario de las Asambleas Generales de Accionistas: el del Consejo de Administración, el Gerente, el suplente del Administrador Único, la persona que la Asamblea designe o un Notario. NUMERAL TREINTA Y SIETE (37). ACTAS: La realización de las Asambleas Generales se hará constar en acta, que se asentará en el libro respectivo y deberán ser firmadas por el Secretario y Presidente de la Asamblea General y los accionistas que así deseen hacerlo. Alternativamente, también se podrán hacer constar en acta notarial levantada ante un Notario. NUMERAL TREINTA Y OCHO (38). RESOLUCIONES: Las resoluciones adoptadas por Asambleas Generales de Accionistas dentro de sus atribuciones y de acuerdo con la ley, serán obligatorias para todos los accionistas desde el momento de su aprobación, aún cuando no hubiesen estado presentes o representados en la sesión en que se adoptaron o hubiesen votado en contra de las mismas. Los acuerdos de las Asambleas Generales de Accionistas podrán impugnarse o anularse cuando se hayan tomado con infracción de la ley o de la escritura social. Estas acciones se ventilarán en la forma que establece el Código de Comercio. NUMERAL TREINTA Y NUEVE (39). ADMINISTRACIÓN: Un Administrador Único o varios administradores actuando conjuntamente constituidos en Consejo de Administración constituyen el Órgano de Administración de la sociedad, teniendo a su cargo la dirección de los negocios de la misma. Corresponderá a la Asamblea General de Accionistas, la fijación del número de administradores, las dietas que devengarán los mismos, y los sueldos del Presidente, Secretario, Tesorero y demás Consejeros que la Asamblea acuerde. La misma Asamblea podrá determinar el nombramiento o no de administradores suplentes y el número de los mismos, y así mismo autorizar a los administradores para dedicarse por su propia cuenta al mismo género de negocios que constituyen el objeto de la sociedad. Los administradores titulares, si fueren varios, en su primera reunión siguiente a la Asamblea General Ordinaria Anual de Accionistas, elegirá de entre sus miembros un Presidente y un Vicepresidente y determinará el orden en que los demás miembros quedan como vocales si hubieren más administradores, salvo que la designación la hubiere hecho una Asamblea. Los administradores podrán ser o no accionistas y serán electos por períodos no mayores de tres años por la Asamblea General de Accionistas en Sesión Ordinaria o Extraordinaria. La reelección es permitida. Los administradores podrán ser removidos por la Asamblea General de Accionistas sin expresión de causa en cuyo caso, la misma Asamblea General de Accionistas nombrará a la o a las personas que los sustituyan en su caso y terminen el período del o los removidos. El Administrador que tenga interés directo o indirecto en cualquier operación o negocio, deberá manifestarlo a los demás administradores y abstenerse de participar en la deliberación y resolución de tal asunto y retirarse del local de la reunión. El Administrador que contravenga esta disposición será responsable de los daños y perjuicios que se causen a la sociedad. Todo Administrador que por razón de serlo derive alguna utilidad o beneficio personal ajeno a los negocios de la sociedad deberá manifestarlo al Consejo de Administración para que se tomen las resoluciones pertinentes. De no hacerlo podrá ser obligado a reintegrar al patrimonio de la sociedad tal beneficio o utilidad y además será removido de su cargo. Los administradores responderán solidariamente ante la sociedad, ante los accionistas y ante los acreedores de la sociedad, por cualquiera de los daños o perjuicios causados por su culpa o dolo. Estarán exentos de tal responsabilidad los administradores que hayan votado en contra de los acuerdos que hayan causado el daño, siempre que el voto en contra se consigne en el Acta de la reunión. Los administradores serán también responsables solidariamente: a) De la efectividad de las aportaciones y de los valores asignados a las mismas si fueren en especie; b) De la existencia real de las utilidades netas que se distribuyen en forma de dividendos a los accionistas; c) De velar que la contabilidad de la sociedad se lleve de conformidad con las disposiciones legales y que ésta sea veraz; y, d) Del exacto cumplimiento de los acuerdos de las Asambleas Generales de Accionistas. NUMERAL CUARENTA (40). ELECCIÓN: En la elección de administradores de la sociedad, los accionistas tendrán tantos votos como el número de acciones multiplicado por el de administradores a elegir y podrán emitir sus votos a favor de un solo candidato o distribuirlo entre dos o más de ellos. Los administradores serán electos por mayoría simple y la elección habrá de verificarse en una sola votación. NUMERAL CUARENTA Y UNO (41). SESIONES DEL CONSEJO: El Consejo de Administración se reunirá con la frecuencia que lo determine el Presidente del Consejo de Administración, o a solicitud del Gerente General; mediante convocatoria que deberá indicar el lugar, fecha y hora en que se llevará a cabo la sesión respectiva y el motivo de la misma. Las sesiones del Consejo de Administración podrán llevarse a cabo fuera de la República de Guatemala. A las sesiones del Consejo, los Administradores podrán concurrir personalmente o representados por otro administrador de la misma sociedad, delegado por mandato o carta poder. Un administrador podrá ejercer una o varias representaciones simultáneamente. En el caso de que estuviesen presentes o representados  todos los administradores propietarios, no será necesaria la previa convocatoria, pudiendo el Consejo deliberar y adoptar resoluciones válidas, siempre y cuando ninguno de sus integrantes se opusiere a la celebración de la sesión y la agenda se aprobará por la mayoría de votos. Las sesiones del Consejo de Administración se podrán llevar a cabo con la presencia física de sus miembros, o de sus representantes, o por medio de conferencia telefónica videoconferencia u otro medio de comunicación que permita deliberar, proponer y acordar. Dichas sesiones quedarán documentadas a través de confirmación enviada, escrita y firmada por quienes participaron, la cual, para tal efecto, será enviada por medio de courier internacional, telegrama o facsímil. Además, el Consejo de Administración podrá actuar mediante consentimiento unánime por escrito, firmado por todos sus miembros. NUMERAL CUARENTA Y DOS (42). RESOLUCIONES DEL CONSEJO DE ADMINISTRACIÓN: Las resoluciones del Consejo de Administración se tomarán por la mayoría de votos de los Administradores presentes o representados en la reunión y podrán deliberar y tomar resoluciones válidas con la asistencia de por lo menos la mayoría de sus integrantes. Cada administrador tendrá un voto. El Presidente del Consejo tendrá voto resolutivo para el caso de empate en la votación. Las resoluciones tomadas por el Consejo serán firmes y ejecutivas desde el momento de ser adoptadas. NUMERAL CUARENTA Y TRES (43). DIETAS Y/O RETRIBUCIONES: Los administradores podrán percibir las dietas correspondientes por las sesiones a que asistan de acuerdo a lo establecido por la Asamblea General Ordinaria de Accionistas y/o podrán percibir las retribuciones periódicas acordadas por la Asamblea General de Accionistas. NUMERAL CUARENTA Y CUATRO (44). ACTAS DEL CONSEJO: De todas las sesiones que celebre el Consejo de Administración se levantarán actas en el libro especialmente designado para el efecto o ante un Notario. Dichas actas irán firmadas por el Presidente y Secretario del Consejo, cualquiera de los miembros del Consejo de Administración, o cualquier persona designada por el Consejo de Administración para una sesión especifica. NUMERAL CUARENTA Y CINCO (45). FACULTADES DE LOS ADMINISTRADORES: El o los administradores tendrán a su cargo la gestión y dirección de los negocios de la sociedad y la ejecución de las resoluciones adoptadas por la Asamblea General de Accionistas siempre y cuando la misma no designe ejecutores especiales. Tendrán todas las facultades que por disposición de la ley o de la presente escritura, sus modificaciones y/o ampliaciones, o por resolución de la Asamblea General de Accionistas, le correspondan o les fueren conferidas y/o encomendadas. Les corresponderá así mismo someter a la Asamblea General de Accionistas reunida en su sesión ordinaria anual, el Estado de Pérdidas y Ganancias, el Balance General, Informe Anual de su Gestión y el Proyecto de Distribución de Utilidades. El Presidente y el Vicepresidente, o el Administrador Único según el caso, devengarán sueldo, así como los demás administradores que determine la Asamblea General. Facultades Especiales: Adicionalmente a lo arriba indicado, los Administradores estarán especialmente facultados para: contratar préstamos; hacer inversiones de capital o efectivo; abrir cuentas bancarias; realizar un pago de cualquier naturaleza y firmar contratos; comprar materiales, contratar suministros o servicios operativos; pagar servicios profesionales, tales como legales, auditoría, ingeniería; otorgar fianzas o aval a favor de obligaciones de terceros, tales como pero sin limitarse a, fianzas contractuales, de cumplimiento, para licitaciones, cartas de crédito y demás similares; disponer, vender, donar, transferir o disponer de activos o bienes de la sociedad; comprar, arrendar, o adquirir cualquier derecho real o gravamen sobre bienes o activos a favor de la sociedad; realizar transacciones en juicio, de reclamos, acciones o demandas, y acuerdos extrajudiciales; realizar cualquier donación o contribución social, de beneficencia o sin fines de lucro; presentar ofertas vinculantes para el desarrollo de proyectos, para la adquisición de acciones o para realizar cualquier negocio conjunto, de participación o joint venture; y para realizar cualquier otro asunto, actividad, contratación o transacción conforme el objeto de la sociedad.  NUMERAL CUARENTA Y SEIS (46). REPRESENTACIÓN LEGAL DE LA SOCIEDAD: El Administrador Único o el Presidente del Consejo de Administración, según sea el caso, tendrán la representación legal de la entidad, judicial o extrajudicialmente, pudiendo delegar dicha representación mediante el otorgamiento de mandatos, los cuales podrán revocar en cualquier momento. La representación legal igualmente la podrá tener el Gerente o Gerentes que se designe o cualquier otro miembro del Consejo de Administración, siempre que así se haga constar en forma expresa al momento de su designación o nombramiento. La representación podrá limitarse en la forma que lo estime conveniente el Órgano encargado de su elección o designación.  NUMERAL CUARENTA Y SIETE (47). SUBSTITUCIÓN DEL PRESIDENTE DEL CONSEJO O DEL ADMINISTRADOR ÚNICO: El Vicepresidente sustituirá al Presidente en el ejercicio de sus facultades y cumplimiento de las obligaciones que le corresponden, en caso de falta temporal del mismo. En caso de falta definitiva del Presidente, el Consejo elegirá de su seno en votación secreta a quien debe sustituirlo, quien completará el período respectivo. En caso de falta temporal del Presidente y Vicepresidente, los sustituirán el Secretario y luego los vocales propietarios en su orden. En caso de falta temporal del Administrador Único lo sustituirá la persona que él designe y en caso de falta definitiva deberá convocarse lo más pronto posible a la Asamblea General para que designe nuevo Administrador Único o el Consejo de Administración correspondiente. Dicho substituto, ya sea del Presidente o del Administrador Único, tendrá, mientras dure la ausencia de ellos o hasta que la Asamblea General decida, todas las facultades y atribuciones que le corresponden a aquellos. NUMERAL CUARENTA Y OCHO (48). SECRETARIO: Salvo en el caso que dicho nombramiento haya sido realizado por una Asamblea, fungirá como secretario del Consejo de Administración, la persona que éste designe, sea o no miembro del Consejo y sus atribuciones serán fijadas por este instrumento, además de las que le fije la Asamblea. Fungirá como Secretario del Administrador Único, la persona que el designe, sea o no accionista, y sus funciones serán netamente administrativas y de auxilio al Administrador Único. NUMERAL CUARENTA Y NUEVE (49). GERENTES: La Asamblea General de Accionistas o el Órgano de Administración podrá nombrar uno o más Gerentes, quienes ejercerán el cargo por tiempo definido o indefinido según lo establezca el Órgano de Administración. Los Gerentes tendrán las facultades y atribuciones que les confiera el Órgano de Administración y dentro de ellas gozarán de todas las facultades necesarias para representar judicialmente y extrajudicialmente a la sociedad y para ejecutar los actos y celebrar los contratos que sean del giro ordinario de la sociedad, según su naturaleza y objeto, de los que de él se deriven y de los que con él se relacionen. La facultad de representación legal y uso de la denominación social podrá ser limitado por el órgano de administración al momento de otorgar el nombramiento. Los Gerentes pueden ser o no accionistas y así mismo administradores de la entidad. El cargo de Gerente no implica incompatibilidad con otro cargo en diferente órgano de la sociedad. El cargo de Gerente es personal, indelegable, revocable y temporal. Cuando así se desee, la designación y nombramiento podrá hacerse por tiempo indefinido. Los Gerentes actuarán bajo la dirección y vigilancia del Órgano de Administración, el que, en su caso, responderá solidariamente por la actuación de aquellos. Los Gerentes rendirán cuenta de su gestión al Órgano de Administración, cada vez que los requieran para ello. Además podrá haber un gerente o mandatario de relaciones obrero‑patronales, quien será nombrado por el Órgano de Administración y quien por el sólo hecho de su nombramiento será el representante legal nato de la sociedad en todos los asuntos judiciales y extrajudiciales vinculados con el derecho laboral y las prestaciones económico‑sociales que las diversas leyes de previsión social establecen en favor de los trabajadores en la República de Guatemala. Para esta clase de asuntos, se considerará como representante legal nato de la entidad al Gerente o Mandatario de Relaciones Obrero‑Patronales, quien por su sola designación tendrá conferidas las facultades específicas que se señalan en la Ley del Organismo Judicial y las que le confiera el Órgano de Administración. Sin embargo, para aprobar o transar en conflictos colectivos económico‑sociales requerirá previa autorización del Órgano de Administración de la sociedad. NUMERAL CINCUENTA (50). FISCALIZACIÓN: Las operaciones sociales podrán ser fiscalizadas por los propios accionistas, por uno o varios contadores o auditores, o por uno o varios comisarios electos por un plazo máximo de tres años por la Asamblea General Ordinaria de Accionistas. La reelección es permitida. Los auditores, contadores o comisarios podrán ser removidos en cualquier tiempo por la Asamblea siguiendo el procedimiento establecido por la ley. Si hubiere dos o más comisarios, deberán actuar separadamente; si hubiere dos o más contadores o auditores podrán actuar en forma conjunta o separada, de conformidad con lo que determine la Asamblea que los designe. NUMERAL CINCUENTA Y UNO (51). OBLIGACIONES DEL ÓRGANO DE FISCALIZACIÓN: Son atribuciones y obligaciones del Órgano de Fiscalización, además de aquellas que específicamente le encomiende la Asamblea General Anual de Accionistas: a) Fiscalizar la Administración de la sociedad y examinar su Balance General y demás estados de contabilidad, para cerciorarse de su veracidad y razonable exactitud; b) Verificar que la contabilidad sea llevada en forma legal y usando principios de contabilidad generalmente aceptados; c) Hacer los arqueos, cortes, comprobaciones y verificaciones que considere convenientes; d) Solicitar a los Administradores informes sobre el desarrollo de las operaciones sociales o sobre determinados negocios; e) Convocar a la Asamblea General de Accionistas cuando ocurran causas de disolución y se presenten asuntos, que, en su opinión requieran del conocimiento de los accionistas; f) Someter al Consejo de Administración y hacer que se inserten en las Agendas de las Asambleas los puntos que estime pertinente; g) Asistir con voz, pero sin voto a las reuniones del Consejo de Administración, cuando lo estime necesario; h) Asistir con voz pero sin voto a las Asambleas Generales Ordinarias Anuales de Accionistas y presentar su informe y dictamen sobre los estados financieros, incluyendo las iniciativas que a su juicio convenga; i) Informar inmediatamente al Gerente General y al Consejo de Administración o al Administrador Único de cualquier irregularidad que advierta, proponiendo las medidas que estime conducentes para su corrección; y, j) En general, fiscalizar, vigilar, e inspeccionar en cualquier tiempo las operaciones de la sociedad. NUMERAL CINCUENTA Y DOS (52). DISOLUCIÓN: La sociedad se disolverá por las siguientes causas: a) Imposibilidad de seguir realizando el objeto principal de la sociedad o por quedar éste consumado; b) Por resolución de los accionistas cuyas acciones representen el sesenta y cinco por ciento (65%) del capital pagado y que haya sido tomada en Asamblea General Extraordinaria; c) Pérdida de más del sesenta por ciento (60%) del capital pagado; d) Reunión de las acciones de la sociedad en una sola persona; y, e) En los casos específicamente determinados por la ley. La liquidación de la sociedad y la división del haber social se hará por uno o varios liquidadores designados por la Asamblea General Extraordinaria de Accionistas. Los administradores no podrán iniciar nuevas operaciones con posterioridad al acuerdo de disolución total o a la comprobación de una causa de disolución total. Si contravinieran esta prohibición, los administradores serán solidaria e ilimitadamente responsables por las operaciones emprendidas. Disuelta la sociedad entrará en liquidación pero conservará su personalidad jurídica, hasta que la liquidación se concluya y durante ese tiempo deberá añadir a su denominación social o razón: "EN LIQUIDACIÓN". El plazo para la liquidación no excederá de un año y cuando transcurra éste sin que se hubiere concluido aquella, cualquiera de los accionistas o de los acreedores, podrá pedir al Juez de Primera Instancia de lo Civil de este departamento que fije un término prudencial para concluirla, quien previo conocimiento de causa lo acordará así. Nombrados el o los liquidadores y aceptados los cargos, el nombramiento se inscribirá en el Registro Mercantil. Los honorarios de los liquidadores se fijarán por acuerdo de los accionistas, antes de que tomen posesión del cargo y si tal acuerdo no fuere posible, a petición de cualquier accionista, resolverá un Juez de Primera Instancia de lo Civil de este departamento, en procedimiento incidental. El Registro Mercantil pondrá en conocimiento del público que la sociedad ha entrado en liquidación y el nombre de él o los liquidadores por medio de avisos que se publicarán tres veces en el término de un mes en el Diario Oficial y en otro de los de mayor circulación en el país. Los administradores de la sociedad continuarán en el desempeño de su cargo, hasta que se haga entrega al o los liquidadores de todos los bienes, libros y documentos de la sociedad, conforme inventario. En lo que sea compatible con el estado de liquidación, la sociedad continuará rigiéndose por las determinaciones de su escritura social y por las disposiciones del Código de Comercio. Los liquidadores no pueden emprender nuevas operaciones. Si contravinieren tal prohibición responden personal y solidariamente por los negocios emprendidos. A los liquidadores les serán aplicables las normas referentes a los Administradores, con las limitaciones inherentes a su carácter. En los pagos, los liquidadores observarán en todo caso el orden siguiente: Primero (1º) Gastos de liquidación; Segundo (2º) Deudas de la sociedad; Tercero (3º) Aportes de los accionistas; y, Cuarto (4º) Utilidades. Los liquidadores no pueden distribuir entre los accionistas, ni siquiera parcialmente, los bienes sociales, mientras no hayan sido pagados a los acreedores de la sociedad o no hayan sido separadas las sumas necesarias para pagarles. Si los bienes de la sociedad no alcanzan a cubrir las deudas, se procederá con arreglo a lo dispuesto en materia de concurso o quiebra. Los accionistas no pueden exigir la restitución de su capital antes de concluir la liquidación de la sociedad, a menos que consista en el usufructo de los bienes aportados al fondo común. En la liquidación, el o los liquidadores procederán obligadamente a distribuir el remanente entre los accionistas, con sujeción a las siguientes reglas: I) En el Balance General final se indicará el haber social distribuible y el valor proporcional del mismo pagaderos a cada acción. II) Dicho Balance se publicará en el Diario Oficial y en otro de los de mayor circulación en el país por tres veces durante un término de quince días. El Balance, los documentos, libros y registros de la sociedad quedarán a disposición de los accionistas hasta el día anterior a la Asamblea General de Accionistas inclusive. Los accionistas gozarán de un plazo de quince días a partir de la última publicación para presentar sus reclamos a los liquidadores. III) En las mismas publicaciones se hará la convocatoria a Asamblea General de Accionistas, para que se resuelva en definitiva sobre el Balance. La Asamblea deberá celebrarse por lo menos un mes después de la primera publicación y en ella los accionistas podrán hacer las reclamaciones que no hubieren sido atendidas con anterioridad o formular las que estimen pertinentes. NUMERAL CINCUENTA Y TRES (53). DE LAS DIFERENCIAS: Cualquier conflicto o diferencia que surja entre los accionistas o entre éstos y la sociedad deberá ser resuelto por mutuo acuerdo entre las partes. En caso que esto no sea posible luego de transcurridos treinta días calendario desde la fecha en que un accionista notificó al otro accionista sobre la existencia de tal conflicto o diferencia, los accionistas convienen que cualquier conflicto, disputa o reclamación que surja de o se relacione con la aplicación, interpretación, y/o cumplimiento del presente instrumento, por cualquier causa, tanto durante su vigencia como a la terminación del mismo, deberá ser resuelto mediante arbitraje de equidad de conformidad con el Reglamento de Arbitraje de la Comisión de Resolución de Conflictos de la Cámara de Industria de Guatemala (“CRECIG”), el cual las partes aceptan desde ya en forma irrevocable. El arbitraje será ante un solo árbitro que será elegido de conformidad con dicho Reglamento. Para el efecto, al surgir cualquier conflicto, disputa o reclamación, las partes  desde ya autorizan a la CRECIG para que nombre al conciliador y árbitro de conformidad con su reglamento. El lugar del arbitraje será la ciudad de Guatemala y el idioma será el castellano. Adicionalmente acuerdan los contratantes que la CRECIG serán la institución encargada de administrar el procedimiento de conformidad con su normativa. El laudo será inimpugnable, final y definitivo, y deberá ser cumplido de buena fe y sin demora alguna. SEGUNDA: '+contrato_administracion+' TERCERA: DISPOSICIONES TRANSITORIAS: El Administrador Único designado en la cláusula anterior, tendrá, además de todas las facultades establecidas en la presente escritura y en el Código de Comercio, las facultades necesarias para actuar ante cualquier oficina del Estado, como ante los tribunales de justicia y ante cualquier entidad pública y/o privada; tendrá facultades para representar legalmente a la sociedad y usar la denominación social; podrá nombrar personal, firmar contratos y llevar a cabo cualesquiera negocios y actos necesarios para que la sociedad inicie operaciones; podrá hacer todo aquello necesario para el debido registro de la sociedad en el Registro Mercantil General de la República; deberá tomar todos aquellos pasos necesarios para el debido registro de la sociedad, así como el otorgamiento de cualquier ampliación o modificación de este instrumento público. A partir de la fecha en que la sociedad quede provisionalmente registrada en el Registro Mercantil General de la República, podrá usar su denominación y nombre comercial en toda la documentación, libros y/o documentación contable. CUARTA: ACEPTACIÓN: Los otorgantes, en la calidad con que actúan, aceptan el contenido de la presente escritura pública de constitución de la entidad <strong>'+contrato_sociedad_nombre+'</strong>, SOCIEDAD ANÓNIMA y lo expresado en todas y cada una de sus cláusulas. Yo, el infrascrito Notario, DOY FE: a) que tuve a la vista los documentos relacionados; b) de todo lo expuesto; y, c) que leí íntegramente lo escrito a los otorgantes quienes bien impuestos de su contenido, objeto, validez y efectos legales, así como de la obligación registral que advertí, lo ratifican, aceptan y firman.';	
			var $body = $(tinymce.activeEditor.getBody());
			$body.find('p:last').html(contrato_contenido.toString());
			//jQuery('#elm1').html(contrato_contenido.toString());
			//jQuery('.contentCondition').html(contrato_contenido);
			console.log(contrato_socios);
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

		function CapitalesObtener(){
			capitales = new Array();
			$.each(socios_individual, function( indice, valor ) {
				capitales.push(valor['capital'])
			});
			$.each(socios_sa, function( indice, valor ) {
				capitales.push(valor['capital'])
			});
			$.each(socios_juridico, function( indice, valor ) {
				capitales.push(valor['capital'])
			});
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
			var civil = jQuery(_socio_genero).parent().find('.socio_civil');
			var nacionalidad = jQuery(_socio_genero).parent().find('.socio_nacionalidad');
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

        function ValidacionesLimpiar(){
        	jQuery('.spn_nombres').html('');
            jQuery('.spn_apellidos').html('');
            jQuery('.spn_edad').html('');
            jQuery('.spn_profesion').html('');
            jQuery('.spn_departamento').html('');
            jQuery('.spn_dpi').html('');
            jQuery('.spn_capital').html('');
            jQuery('.spn_socio_nombres').html('');
	        jQuery('.spn_socio_apellidos').html('');
	        jQuery('.spn_socio_edad').html('');
	        jQuery('.spn_socio_profesion').html('');
	        jQuery('.spn_socio_departamento').html('');
	        jQuery('.spn_socio_dpi').html('');
	        jQuery('.spn_socio_puesto').html('');
	        jQuery('.spn_socio_comercial').html('');
	        jQuery('.spn_socio_nombramiento').html('');
	        jQuery('.spn_socio_notario').html('');
	        jQuery('.spn_socio_registro').html('');
	        jQuery('.spn_socio_folio').html('');
	        jQuery('.spn_socio_libro').html('');
	        jQuery('.spn_socio_capital').html('');
	        jQuery('.spn_juridico_nombres').html('');
        	jQuery('.spn_juridico_apellidos').html('');
        	jQuery('.spn_juridico_edad').html('');
        	jQuery('.spn_juridico_profesion').html('');
        	jQuery('.spn_juridico_departamento').html('');
        	jQuery('.spn_juridico_dpi').html('');
        	jQuery('.spn_juridico_colegiado').html('');
        	jQuery('.spn_juridico_capital').html('');
        	jQuery('.spn_sociedad_ciudad').html('');
    		jQuery('.spn_sociedad_nombre').html('');
    		jQuery('.spn_sociedad_comercial').html('');
    		jQuery('.spn_sociedad_actividad').html('');
    		jQuery('.spn_administracion_representante').html('');
    		jQuery('.spn_administracion_presidente').html('');
    		jQuery('.spn_administracion_secretario').html('');
    		jQuery('.spn_administracion_tesorero').html('');
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding marginLarge">
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
							<h2 class="titleGeneral">Socios</h2>
				          	<div id="div_socios_paso1">
				          		<div id="div_mensaje_error1" class="mensaje_error"></div>
					          	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 socio_paso1">
									<div>Socio 1</div>	
									<div>Tipo de socio:</div>
									<select class="slc_socio_tipo select-bg">
										<option value="0">Individual</option>
										<option value="1">Sociedad Anonima</option>
										<option value="2">Juridico</option>
									</select>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 socio_paso1">
									<div>Socio 2</div>	
									<div>Tipo de socio:</div>
									<select class="slc_socio_tipo select-bg">
										<option value="0">Individual</option>
										<option value="1">Sociedad Anonima</option>
										<option value="2">Juridico</option>
									</select>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nonePadding">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<input type="button" onclick="SocioAgregar();" class="fillButton prev" value="Agregar"/>
								</div>
								<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " align="left">
									<!--input class="fillButton prev" type="submit" value="Anterior"-->
								</div>				
								<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  marginLarge " style="float:right;">
									<input class="fillButton" type="button" value="Siguiente" onclick="Paso1Validar();">
								</div>				
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-3 col-xs-12 lineCircle">
				<div class="contentCircle">
					<div class="circle item1C active" id="item1C">1</div>
					<div class="circle item2C active" id="item2C">2</div>
					<div class="circle item3C active" id="item3C">3</div>
					<div class="circle item4C active" id="item4C">4</div>
					<div class="circle item5C active" id="item5C">5</div>
				</div>
				<div class="contentText">
					<span class="textCircle item1TC active" id="item1TC">Socios</span>
					<span class="textCircle item1TC active" id="item2TC">Información de la sociedad</span>
					<span class="textCircle item1TC active" id="item3TC">Información bancaria</span>
					<span class="textCircle item1TC active" id="item4TC">Información de acciones</span>
					<span class="textCircle item1TC active" id="item5TC">Administración</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 wrap wrapEditContract ContratoGenerado" style="display:none;">
		<h2 class="titleGeneral"><span class="backLevel">Sociedad Anonima|</span> <b class="level">Contrato Generado</b></h2>
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
	</script>
<?php $this->layout->block(); ?>
