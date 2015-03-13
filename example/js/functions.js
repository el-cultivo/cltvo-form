/**
 * Es necesario para que la validación del form funcione correctamente las siguientes lineas deben de colocarse siempre dentro de $(document).ready(function(){}
 *  
 * Parámetros:
 *
 *  @param string ajax_mail_url ruta donde se encuentra el archivo 'ajax-mail.php'
 *
 *  Para cada form dentro de la pagina se requieren los siguientes parámetros: 
 *      @param string id_form identificador del form al que se haga la referencia
 *      @param string id_input identificador de los inputs asociados al form que requieran reglas de validación especificas
 *      @param string id_submit identificador del submit asociado al form
 *      En caso de que el formulario contenga input condicionados es necesario escribir las reglas de funcionamiento de los mismos para lo cual vas a requerir los siguientes parámetros:
 *          @param string id_input_trigger identificador de lo input asociados al form del cual dependan los input condicionados 
 *          @param string id_input_child identificador de los input dependientes (Como regla general se recomienda que estos input sean deshabilitados cuando no son requeridos, esto evita que se envíen junto con el form  )
 *
 *En caso de ser necesario se pueden generar reglas de validación generales o personalización de los mensajes de validación:
*/


(function($) {
	$(document).ready(function(){
		

		
		
		// Se define la ruta del post mail vía ajax
		var ajax_mail_url = window.location.href + 'ajax/ajax-mail.php'; 
		console.log(ajax_mail_url);

	
		//........................form de contacto.................................
		
		// en caso de existir input condicionados se definen aquí la reglas de dependencia 		
		// es importante que todas los input dependientes se deshabiliten para evitar envió de información errónea o contradictoria 		
		/*
		$('#id_input_trigger').click(function(){
		});		
		*/
		
		//.........................validación y envío ...................................
		
		$("#suscribe").validate({ // activación de la validación de los campos
			submitHandler:function(form){ // envía el post vía ajax esta función puede cambiarse 
				var datos = $(form).serialize();
				$.post(ajax_mail_url,
					datos,
					function(data) {
						$('#suscribe_submit').val(data); // regresa las alertas al submit 
					}
				);
			}
		});
		
		//.........................validación y envío ...................................
		
		$("#contacto").validate({ // activación de la validación de los campos
			submitHandler:function(form){ // envía el post vía ajax esta función puede cambiarse 
				var datos = $(form).serialize();
				$.post(ajax_mail_url,
					datos,
					function(data) {
						$('#contacto_submit').val(data); // regresa las alertas al submit 
					}
				);
			}
		});

		
		// .......................reglas de validación....................

		$("#contacto_mail").rules( "add", { 
			email: true
		});	

		$("#contacto_nombre").rules( "add", {
			minlength:5,
			messages:{ // mensajes personalizados 
				minlength:"El nombre debe ser mayor a 5 caracteres",
			}	
		});	
		
		$("#contacto_numero").rules( "add", {
			number:true,
			messages:{ // mensajes personalizados 
				number:"Únicamente números",
			}	
		});			
		
		// y/o se pueden personalizar los mensajes de validacion de manera global 
		jQuery.extend(jQuery.validator.messages, {
			required: 'Este campo es obligatorio.',
			email: 'El E-mail debe tener un formato válido',
		});
		
	
	});
})(jQuery);

