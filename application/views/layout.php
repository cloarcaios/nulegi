<?php
    $nombres = explode(' ', $perfil[0]['nombres']);
    $nombre = $nombres[0];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo($this->config->base_url()); ?>includes/diseno/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo($this->config->base_url()); ?>includes/diseno/css/style.css">
        <link rel="stylesheet" href="<?php echo($this->config->base_url()); ?>includes/diseno/css/jquery.mCustomScrollbar.css">
        <link rel="stylesheet" href="<?php echo($this->config->base_url()); ?>includes/diseno/css/uniform.default.min.css">
        <link rel="stylesheet" href="<?php echo($this->config->base_url()); ?>includes/diseno/css/owl.carousel.css">
        <script type="text/javascript" src="<?php echo($this->config->base_url()); ?>includes/diseno/js/jQuery-1.10.1.js"></script>
        <script type="text/javascript" src="<?php echo($this->config->base_url()); ?>includes/diseno/js/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo($this->config->base_url()); ?>includes/diseno/js/jquery.mCustomScrollbar.js"></script>
        <script type="text/javascript" src="<?php echo($this->config->base_url()); ?>includes/diseno/js/owl.carousel.js"></script>
        <script type="text/javascript" src="<?php echo($this->config->base_url()); ?>includes/diseno/js/jquery.uniform.js"></script>
        <script type="text/javascript" src="<?php echo($this->config->base_url()); ?>includes/diseno/js/scripts.js"></script>
        <script type="text/javascript" src="<?php echo($this->config->base_url()); ?>includes/js/funciones.js"></script>

        <!--==== libreria stripe ====-->
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <!--=========================-->

        <script type="text/javascript">
            //Stripe.setPublishableKey('pk_test_YfWXV7cWKq8BiPKeYtLCHa20');
            /*
                @   HUMBERTO HERRADOR: 26/03/2017
                @   Cambio de claves de stripe de test a live
                @   Stripe.setPublishableKey('pk_test_YfWXV7cWKq8BiPKeYtLCHa20');
            */
            //Stripe.setPublishableKey('pk_test_oUpWme3dMWRQhSwbONkGp0p4');
            Stripe.setPublishableKey('pk_test_YfWXV7cWKq8BiPKeYtLCHa20');
        </script>
        <style type="text/css">
            .accordion-content {
                display: none;
            }

            .accordion-titulo {
                width: 300px;
            }

            .accordion-content a{
                margin-left: 20px;
            }
        </style>
        <script type="text/javascript">
            function Acordeon(elemento){
                var contenido=$(elemento).next(".accordion-content");        
                if(contenido.css("display")=="none"){ //open        
                    $('.accordion-titulo').removeClass("open");  
                    $('.accordion-content').slideUp(250);
                    contenido.slideDown(250);
                    $(elemento).addClass("open");
                }
                else{ //close        
                    contenido.slideUp(250);
                    $(elemento).removeClass("open");  
                }                         
            }

            function stripeResponseHandler(status, response) {
                // Grab the form:
                var $form = $('#payment-form');

                if (response.error) { // Problem!
                    // Show the errors on the form:
                    //$form.find('.payment-errors').text(response.error.message);
                    $form.find('.submit').prop('disabled', false); // Re-enable submission
                    switch(response.error.code){
                        case 'incorrect_number':
                            $form.find('.payment-errors').text('El número de su tarjeta es incorrecto.');
                        break;
                        case 'invalid_expiry_year':
                            $form.find('.payment-errors').text('El año de vencimiento de su tarjeta no es válido.');
                        break;
                        case 'invalid_expiry_month':
                            $form.find('.payment-errors').text('El mes de vencimiento de su tarjeta no es válido.');
                        break;
                    }
                    /*
                        @   HUMBERTO HERRADOR 17/03/2017
                            @   Codigo para levantar el loader para la pagina

                    */
                    $('.div_loader').hide();

                } else { // Token was created!
                    // Get the token ID:
                    $('#btn_submitPago').prop('disabled', true); // Re-enable submission
                    var error = '';
                    var token = response.id;
                    // Insert the token ID into the form so it gets submitted to the server:
                    $form.append($('<input type="hidden" name="stripeToken">').val(token));
                    
                    var nombreFactura = $('#txt_nombreFactura').val();
                    var nitFactura = $('#txt_nitFactura').val();
                    //var curso_id = $('#txt_curso_id').val();
                    //var estudiante_id = $('#txt_estudiante_id').val();
                    var correo = $('#txt_correo').val();
                    var precio = $('#amount').val();
                    //var horario_id = $('#slc_horario').val();
                    //var fecha = $('#mydiv').val();
                    /*
                        @   HUMBERTO HERRADOR: 17/03/2017
                            @   dataTarjetaPago
                                    se utiliza para envia esa data para el error log de procesos
                    */
                    
                    // Submit the form:
                    //console.log('antes de submit');
                    //$form.get(0).submit();
                    //$form.submit();
                    var formData = new FormData();
                    formData.append('stripeToken',token.toString());
                    formData.append('precio',precio.toString());
                    //formData.append('curso_id',curso_id.toString());
                    //formData.append('estudiante_id',estudiante_id.toString());
                    if(nombreFactura != '')
                    formData.append('nombreFactura',nombreFactura.toString());
                    if(nitFactura != '')
                    formData.append('nitFactura',nitFactura.toString());
                    if(correo != '')
                    formData.append('correoFactura',correo.toString());
                    if(error == ''){
                        $.ajax({
                            url: 'TarjetaPago',
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType : 'json',
                            success: function(respuesta)
                            {
                                switch(respuesta.res){
                                    case 1: // pago satisfactorio
                                        $('.payment-errors').html(respuesta.mensaje);
                                        ValidarNombre();
                                        /*
                                            @ HUMBERTO HERRADOR
                                            @ Aqui es cuando el pago sale satisfactorio
                                        */
                                    break;
                                    /*case 2:
                                        $('.payment-errors').html(respuesta.error);
                                        
                                    break;*/
                                    case 3: // error
                                        $('.payment-errors').html(respuesta.error);
                                        /*
                                            @   HUMBERTO HERRADOR
                                            @   Aqui es cuando el pago sale insatisfactorio
                                        */
                                    break;
                                    /*case 4: //Errores de facturacion
                                        $('.payment-errors').html(respuesta.error);
                                    break;*/
                                }
                            }
                        }).fail( function( jqXHR, textStatus, errorThrown ) {

                            if (jqXHR.status === 0) {

                                alert('Not connect: Verify Network.');

                            } else if (jqXHR.status == 404) {

                                
                                ErrorLogInsertar({
                                                    'proceso':'Ingresar pago desde vista con ajax',
                                                    'archivo': 'curso_informacion.php',
                                                    'error':'Requested page not found [404]',
                                                    'datos_invulucrados':JSON.stringify(dataTarjetaPago)
                                                });
                                $('.payment-errors').html('Hemos experimentado un error interno, vuelva a intentarlo mas tarde, si tiene problemas puede enviar un correo a info@enlit.gt');
                                $('#btn_submitPago').prop('disabled', false);
                                /*
                                    @   HUMBERTO HERRADOR 17/03/2017
                                        @   Codigo para levantar el loader para la pagina

                                */
                                $('.div_loader').hide();

                            } else if (jqXHR.status == 500) {

                                ErrorLogInsertar({
                                                    'proceso':'Ingresar pago desde vista con ajax',
                                                    'archivo': 'curso_informacion.php',
                                                    'error':'Internal Server Error [500].',
                                                    'datos_invulucrados':JSON.stringify(dataTarjetaPago)
                                                });
                                $('.payment-errors').html('Hemos experimentado un error interno, vuelva a intentarlo mas tarde, si tiene problemas puede enviar un correo a info@enlit.gt');
                                $('#btn_submitPago').prop('disabled', false);
                                /*
                                    @   HUMBERTO HERRADOR 17/03/2017
                                        @   Codigo para levantar el loader para la pagina

                                */
                                $('.div_loader').hide();

                            } else if (textStatus === 'parsererror') {

                                ErrorLogInsertar({
                                                    'proceso':'Ingresar pago desde vista con ajax',
                                                    'archivo': 'curso_informacion.php',
                                                    'error':'Requested JSON parse failed.',
                                                    'datos_invulucrados':JSON.stringify(dataTarjetaPago)
                                                });
                                $('.payment-errors').html('Hemos experimentado un error interno, vuelva a intentarlo mas tarde, si tiene problemas puede enviar un correo a info@enlit.gt');
                                $('#btn_submitPago').prop('disabled', false);
                                /*
                                    @   HUMBERTO HERRADOR 17/03/2017
                                        @   Codigo para levantar el loader para la pagina

                                */
                                $('.div_loader').hide();

                            } else if (textStatus === 'timeout') {

                                ErrorLogInsertar({
                                                    'proceso':'Ingresar pago desde vista con ajax',
                                                    'archivo': 'curso_informacion.php',
                                                    'error':'Time out error.',
                                                    'datos_invulucrados':JSON.stringify(dataTarjetaPago)
                                                });
                                $('.payment-errors').html('Hemos experimentado un error interno, vuelva a intentarlo mas tarde, si tiene problemas puede enviar un correo a info@enlit.gt');
                                $('#btn_submitPago').prop('disabled', false);
                                /*
                                    @   HUMBERTO HERRADOR 17/03/2017
                                        @   Codigo para levantar el loader para la pagina

                                */
                                $('.div_loader').hide();

                            } else if (textStatus === 'abort') {

                                ErrorLogInsertar({
                                                    'proceso':'Ingresar pago desde vista con ajax',
                                                    'archivo': 'curso_informacion.php',
                                                    'error':'Ajax request aborted.',
                                                    'datos_invulucrados':JSON.stringify(dataTarjetaPago)
                                                });
                                $('.payment-errors').html('Hemos experimentado un error interno, vuelva a intentarlo mas tarde, si tiene problemas puede enviar un correo a info@enlit.gt');
                                $('#btn_submitPago').prop('disabled', false);
                                /*
                                    @   HUMBERTO HERRADOR 17/03/2017
                                        @   Codigo para levantar el loader para la pagina

                                */
                                $('.div_loader').hide();

                            } else {

                                ErrorLogInsertar({
                                                'proceso':'Ingresar pago desde vista con ajax',
                                                'archivo': 'curso_informacion.php',
                                                'error':'Uncaught Error: ' + jqXHR.responseText,
                                                'datos_invulucrados':JSON.stringify(dataTarjetaPago)
                                            });
                                $('.payment-errors').html('Hemos experimentado un error interno, vuelva a intentarlo mas tarde, si tiene problemas puede enviar un correo a info@enlit.gt');
                                $('#btn_submitPago').prop('disabled', false);
                                /*
                                    @   HUMBERTO HERRADOR 17/03/2017
                                        @   Codigo para levantar el loader para la pagina

                                */
                                $('.div_loader').hide();
                            }

                            });
                    }else{
                        $('.payment-errors').html(error);
                        $('#btn_submitPago').prop('disabled', false);
                        /*
                            @   HUMBERTO HERRADOR 17/03/2017
                                @   Codigo para levantar el loader para la pagina

                        */
                        $('.div_loader').hide();
                    }
              }
            }


            $(document).ready(function(){
                $(".contentScroll2").hide();
                $(".previewOrder").css("opacity", "0.5");
                $(".listOrder").css("opacity", "1");
                $(function() {
                    var $form = $('#payment-form');
                    $form.submit(function(event) {
                        /*
                            @   HUMBERTO HERRADOR 17/03/2017
                                @   Codigo para levantar el loader para la pagina

                        */
                        $('.div_loader').show();
                        // Disable the submit button to prevent repeated clicks:
                        $form.find('.submit').prop('disabled', true);
                        // Request a token from Stripe:
                        Stripe.card.createToken($form, stripeResponseHandler);

                        // Prevent the form from being submitted:
                        return false;
                    });
                });
            });

            function Redireccionar(ruta){
                window.location.href = ruta;
            }
        </script>
        <title><?php echo( $headerpage['title'] ); ?></title>
        <?php
            $url_contratos = $this->config->base_url().'index.php/inicio/contratos';
            $url_archivos = $this->config->base_url().'index.php/inicio/archivos';
            $url_notarios = $this->config->base_url().'index.php/inicio/notarios';
            $url_noticias = $this->config->base_url().'index.php/inicio/noticias';
            $url_ayuda = $this->config->base_url().'index.php/inicio/ayuda';
            $url_perfil = $this->config->base_url().'index.php/inicio/perfil';
       ?>
        <!--style type="text/css">
           .word-wrap{
                width: 15em; 
                word-break: break-all;
            }
            .tr-color{
                background-color: yellow !important;;
            }
        </style-->
        <?php $this->layout->block('headhtml'); ?>
        <?php $this->layout->block(); ?>
    </head>
    <body> 

    <div class="sidebar">
        <nav class="TopMenu">
            <div class="brand">
                <div><img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/brand.png"></div>
            </div>  
        </nav>
        <a href="<?php echo($this->config->base_url()); ?>index.php/inicio/contratos" class="active">
            <img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/searchDocs.png">
            <p>Buscar Contratos</p>
        </a>
        <a href="<?php echo($this->config->base_url()); ?>index.php/inicio/pregunta">
            <img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/iconNotarios.png">
            <p>Pregunta</p>
        </a>
        <!--a href="news.html">
            <img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/iconNews.png">
            <p>Noticias</p>
        </a-->
        <!--a href="help.html">
            <img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/iconHelp.png">
            <p>Ayuda</p>
        </a-->
        <!--a href="perfil.html">
            <img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/iconPerfil.png">
            <p>Mi perfil</p>
        </a-->
        <!--a href="file.html" class="file-active">
            <img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/filesAndDoc.png">
            <p>Mis archivo y Contratos</p>
        </a-->
        <div class="submenu">
            <a href="#">
                Contratos generados
            </a>
            <?php
                $html_contratos = '';
                $html_contratos_1 = '';
                $html_contratos_2 = '';
                $html_contratos_3 = '';
                $html_contratos_4 = '';
                $html_contratos_5 = '';
                $html_contratos_6 = '';
                $html_contratos_7 = '';
                $html_contratos_8 = '';
                $html_contratos_9 = '';
                if(isset($headerpage['contratos_generados']['contratos'])){
                    foreach ($headerpage['contratos_generados']['contratos'] as $key => $value) {
                        switch ($value['contrato_tipo_id']) {
                            case '1':
                                $html_contratos_1 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '2':
                                $html_contratos_2 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '3':
                                $html_contratos_3 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '4':
                                $html_contratos_4 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '5':
                                $html_contratos_5 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '6':
                                $html_contratos_6 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '7':
                                $html_contratos_7 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '8':
                                $html_contratos_8 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '9':
                                $html_contratos_9 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                }
                if($html_contratos_1 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Laborales
                                                <img src="'.$this->config->base_url().'includes/diseno/images/laborales.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_1.'</div>
                                        </div>';
                }
                if($html_contratos_2 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Maritales
                                                <img src="'.$this->config->base_url().'includes/diseno/images/maritales.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_2.'</div>
                                        </div>';
                }
                if($html_contratos_3 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Divorcio
                                                <img src="'.$this->config->base_url().'includes/diseno/images/divorcio.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_3.'</div>
                                        </div>';
                }
                if($html_contratos_4 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Negocios
                                                <img src="'.$this->config->base_url().'includes/diseno/images/negocios.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_4.'</div>
                                        </div>';
                }
                if($html_contratos_5 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Bienes Raices
                                                <img src="'.$this->config->base_url().'includes/diseno/images/bienesRaices.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_5.'</div>
                                        </div>';
                }
                if($html_contratos_6 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Intelectuales
                                                <img src="'.$this->config->base_url().'includes/diseno/images/intelectual.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_6.'</div>
                                        </div>';
                }
                if($html_contratos_7 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Escolares
                                                <img src="'.$this->config->base_url().'includes/diseno/images/escolares.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_7.'</div>
                                        </div>';
                }
                if($html_contratos_8 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                ONG
                                                <img src="'.$this->config->base_url().'includes/diseno/images/ong.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_8.'</div>
                                        </div>';
                }
                if($html_contratos_9 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);"
                                                ONGS
                                                <img src="'.$this->config->base_url().'includes/diseno/images/ongs.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_9.'</div>
                                        </div>';
                }
                echo $html_contratos;
            ?>
            <a href="#">
                Contratos compartidos
            </a>
            <?php
                $html_contratos = '';
                $html_contratos_1 = '';
                $html_contratos_2 = '';
                $html_contratos_3 = '';
                $html_contratos_4 = '';
                $html_contratos_5 = '';
                $html_contratos_6 = '';
                $html_contratos_7 = '';
                $html_contratos_8 = '';
                $html_contratos_9 = '';
                if(isset($headerpage['contratos_compartidos']['contratos'])){
                    foreach ($headerpage['contratos_compartidos']['contratos'] as $key => $value) {
                        switch ($value['contrato_tipo_id']) {
                            case '1':
                                $html_contratos_1 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '2':
                                $html_contratos_2 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '3':
                                $html_contratos_3 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '4':
                                $html_contratos_4 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '5':
                                $html_contratos_5 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '6':
                                $html_contratos_6 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '7':
                                $html_contratos_7 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '8':
                                $html_contratos_8 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            case '9':
                                $html_contratos_9 .= '<a href="contratos_versiones?c='.$value['contrato_id'].'">
                                                        '.$value['nombre'].'
                                                    </a>';
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                }
                if($html_contratos_1 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Laborales
                                                <img src="'.$this->config->base_url().'includes/diseno/images/laborales.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_1.'</div>
                                        </div>';
                }
                if($html_contratos_2 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Maritales
                                                <img src="'.$this->config->base_url().'includes/diseno/images/maritales.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_2.'</div>
                                        </div>';
                }
                if($html_contratos_3 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Divorcio
                                                <img src="'.$this->config->base_url().'includes/diseno/images/divorcio.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_3.'</div>
                                        </div>';
                }
                if($html_contratos_4 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Negocios
                                                <img src="'.$this->config->base_url().'includes/diseno/images/negocios.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_4.'</div>
                                        </div>';
                }
                if($html_contratos_5 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Bienes Raices
                                                <img src="'.$this->config->base_url().'includes/diseno/images/bienesRaices.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_5.'</div>
                                        </div>';
                }
                if($html_contratos_6 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Intelectuales
                                                <img src="'.$this->config->base_url().'includes/diseno/images/intelectual.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_6.'</div>
                                        </div>';
                }
                if($html_contratos_7 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                Escolares
                                                <img src="'.$this->config->base_url().'includes/diseno/images/escolares.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_7.'</div>
                                        </div>';
                }
                if($html_contratos_8 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);">
                                                ONG
                                                <img src="'.$this->config->base_url().'includes/diseno/images/ong.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_8.'</div>
                                        </div>';
                }
                if($html_contratos_9 != ''){
                    $html_contratos .= '<div class="accordion-container">
                                            <a href="#" class="accordion-titulo" onclick="Acordeon(this);"
                                                ONGS
                                                <img src="'.$this->config->base_url().'includes/diseno/images/ongs.png" style="width:20px;">
                                            </a>
                                            <div class="accordion-content">'.$html_contratos_9.'</div>
                                        </div>';
                }
                echo $html_contratos;
            ?>
        </div>
    </div>

    <div class="content-wrap">  
        <?php $this->layout->block('section-page'); ?>
        <?php $this->layout->block(); ?>
    </div>

        <div class="modal fade" id="delete" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-body">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <p><img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/imgBorrar.png"></p>
                  <p class="txtLightbox">Esta seguro que desea eliminar logo funsepa</p>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noPadding">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input type="submit" value="Si" class="buttonLightbox">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input type="submit" value="No" class="buttonLightbox">
                        </div>
                  </div>
                </div>
              </div>
              
            </div>
        </div>

        <div class="modal fade" id="submit" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-body">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <p><img src="<?php echo($this->config->base_url()); ?>includes/diseno/images/imgEnviar.png"></p>
                  <p class="txtLightbox">Aque correo deseas enviar Matrimonio Juan
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginLarge">
                            <input type="email" class="email" value="correo@servicio.com">
                      </div>    
                  </p>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginLarge">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input type="submit" value="Enviar" class="buttonLightbox">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input type="submit" value="Cancelar" class="buttonLightbox">
                        </div>
                  </div>
                </div>
              </div>
              
            </div>
        </div>
    </body>

</html>
