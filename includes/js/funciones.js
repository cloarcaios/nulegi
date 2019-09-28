    function validateEmail(email) { 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function encode (input) {
        var _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;
     
        input = utf8_encode(input);
     
        while (i < input.length) {
     
          chr1 = input.charCodeAt(i++);
          chr2 = input.charCodeAt(i++);
          chr3 = input.charCodeAt(i++);
     
          enc1 = chr1 >> 2;
          enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
          enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
          enc4 = chr3 & 63;
     
          if (isNaN(chr2)) {
            enc3 = enc4 = 64;
          } else if (isNaN(chr3)) {
            enc4 = 64;
          }
     
          output = output +
          _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
          _keyStr.charAt(enc3) + _keyStr.charAt(enc4);
     
        }
     
        return output;
    }

    function utf8_encode (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";
     
        for (var n = 0; n < string.length; n++) {
     
          var c = string.charCodeAt(n);
     
          if (c < 128) {
            utftext += String.fromCharCode(c);
          }
          else if((c > 127) && (c < 2048)) {
            utftext += String.fromCharCode((c >> 6) | 192);
            utftext += String.fromCharCode((c & 63) | 128);
          }
          else {
            utftext += String.fromCharCode((c >> 12) | 224);
            utftext += String.fromCharCode(((c >> 6) & 63) | 128);
            utftext += String.fromCharCode((c & 63) | 128);
          }
     
        }
     
        return utftext;
    }

    function getURLParameter(name) {
        return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
    }

    function ver_mensaje(mensaje, tipo){
    	var clase = '';
    	var texto = '';
    	switch (tipo){
    		case 'exito':
    			clase = 'success';
    			texto = 'Exito';
    			break;
    		case 'advertencia':
    			clase = 'warning';
    			texto = 'Advertencia';
    			break;
    		case 'error':
    			clase = 'danger';
    			texto = 'Error';
    			break;
    		default:
    			clase = 'danger';
    			texto = 'Error';
    			break;
    	}
    	var div_mensaje = '<div class="alert alert-'+clase+' alert-dismissible" role="alert">'+
								'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
							  	+mensaje+
							'</div>';
		return div_mensaje;
    }

    //FUNCION QUE VALIDA QUE SOLO NUMEROS O LETRAS SEAN INGRESADAS   
    function validar_caracter(e,tipo){
        tecla = (document.all) ? e.keyCode : e.which;
        //Tecla de retroceso para borrar, siempre la permite
        switch (tipo){
            case 0:
                if (tecla == 8 || tecla == 32 || tecla == 0) return true;
                // Patron de entrada para letras
                patron =/[A-Za-z]/; 
                break;
            case 1:
                if (tecla == 8 || tecla == 0) return true;
                // Patron de entrada para numeros
                patron = /\d/;  
                break;
            case 2:
                if (tecla == 8 || tecla == 0 || tecla == 46) return true;
                // Patron de entrada para numeros
                patron = /\d/;
                break; 
            default:
            	if (tecla == 8 || tecla == 32 || tecla == 0) return true;
                // Patron de entrada para letras
                patron =/[A-Za-z]/; 
            	break;
        }
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }

    function CerrarSesion(){
        var tarea = 'cerrar_sesion';
        jQuery.ajax({
            url: "validar_admin.php",
            type: 'post',
            data: {
              tarea:tarea
          },
          dataType: 'json',
          success: function(respuesta) {
            switch(parseInt(respuesta.res)){
                case 1:
                    window.location = 'index.php';
                    break;
                default:
                    mensaje = 'No fue posible cerrar sesi&oacute;n. Intente nuevamente.';
                    jQuery('#div_mensaje').html(mensaje);
                    break;
            }
          },
          error: function (error){
                  //alert(error);
          }
      });
    }      

    function AbrirAlerta(msg, alto, ancho, typemodal) {
        var modal = (typemodal != undefined) ? typemodal: false;
        $.fancybox('<div class="content_msg">'+msg+'</div>', {
            'modal': modal,
            'height' : alto,
            'width'  : ancho,
            'autoSize' : false
        });
    }

    function Redir(ruta){
        window.location.href = ruta;
    }