(function($) {
	$(document).ready(function(){
		
		
		// Se define la ruta del post mail vía ajax
		var ajax_mail_url = iarpp_js_vars.template_url + '/ajax/ajax-mail.php'; 

	
		//........................form de contacto.................................
		
		// en caso de existir input condicionados se definen aquí la reglas de dependencia 		
		// es importante que todas los input dependientes se deshabiliten para evitar envió de información errónea o contradictoria 		
		/*
		$('#id_input_trigger').click(function(){
		});		
		*/
		
		//.........................validación y envío ...................................
		
		$("#id_form").validate({ // activación de la validación de los campos
			submitHandler:function(form){ // envía el post vía ajax esta función puede cambiarse 
				var datos = $(form).serialize();
				$.post(ajax_mail_url,
					datos,
					function(data) {
						$('#id_submit').val(data); // regresa las alertas al submit 
					}
				);
			}
		});

		
		// .......................reglas de validación....................

		$("#id_input").rules( "add", { 
			// se pueden personalizan las reglas de validación de cada input
			messages:{ // así como sus mensajes personalizados 
			}	
		});	
		
		// y/o se pueden persnalizar los mensajes de validacion de manera global 
		jQuery.extend(jQuery.validator.messages, {
			//  mensajes generales la validación
		});
		
	
	});
})(jQuery);

