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
	
		//........................form de contacto.................................
		
		// en caso de existir input condicionados se definen aquí la reglas de dependencia 		
		// es importante que todas los input dependientes se deshabiliten para evitar envió de información errónea o contradictoria 		
		/*
		$('#id_input_trigger').click(function(){
		});		
		*/
		
		
		//.........................validación y envío ...................................
		if ($("#contact-form_JS").length > 0 ){ 
			$("#contact-form_JS").validate({ // activación de la validación de los campos
				submitHandler:function(form){ // envía el post vía ajax esta función puede cambiarse 
					var datos = $(form).serialize();
					
					$.post(ajax_mail_url,
						datos,
						function(data) {
							$('#contact_sub_JS').val(data); // regresa las alertas al submit 
								if (data == "¡Gracias!"){
									$("#contact-form_JS")[0].reset();
								}							
						}
					);
				},
				errorElement: "div",
				wrapper: "div ",  // a wrapper around the error message

				errorPlacement: function(error, element) {					
					$("#contact-form_JS").append(error);
					error.addClass('contenedor-error');
					altura = element.height(),
					ancho = element.width();
					incial = $("#contact-form_JS").offset().top;
										
					var posicion = element.offset(),
					arriba = parseInt(posicion.top) - parseInt(incial) +'px',
					lado = parseInt(posicion.left+ancho)+'px';

					error.css('position', 'absolute');
					error.css('top',arriba);
					error.css('left',lado);		
				}
			});

			
			// .......................reglas de validación....................

			$("#cont_mail_JS").rules( "add", { 
				email: true
			});	
			
			$("#cont_telefono_JS").rules( "add", {
				number: true,
				minlength:10,
				maxlength:10,
				messages:{ // mensajes personalizados 
					number: "Sólo ingresa números",
					minlength:"El número debe incluir la lada (10 dígitos)",
					maxlength:"El número debe incluir la lada (10 dígitos)",
				}	
			});			
			
			// y/o se pueden personalizar los mensajes de validacion de manera global 
			jQuery.extend(jQuery.validator.messages, {
				required: 'Este campo es obligatorio.',
				email: 'El E-mail debe tener un formato válido',
			});
		}

		
	
	});
})(jQuery);

