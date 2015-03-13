# cltvo-form
## Validar form por medio de *jQuery Validation Plugin*

### jQuery Validation Plugin
* Descarga el jQuery Validation Plugin de  [aquí](http://jqueryvalidation.org/)
* Para agregar el un Plugin  [aquí](http://jqueryvalidation.org/files/jquery-validation-1.13.1.zip)
* Para agregar el un JQuery  [aquí](http://jquery.com/download/)

### Creación del formulario html
* Para comenzar a es necesario la asignación de un identificador para el from, esto es importante ya que sirve para ligar los input a el y realizar la validación por medio del Plugin `< form id = "id_form"      >`.
* Para cada input es importante que se le asigne un identificador por medio del cual se realizara la validación personalizada de cada dicho campo `< input id = "id_input"` ademas de la asignación del nombre del `< input name = "id_from[input i]" `
* La asignación del nombre de cada imput debe tener la siguiente estructura: identificador del form y entre corchetes el nombre que se le asignara a este input. Es importante utilizar los nombres completos y no abreviaciones ya que estos valores formaran parte del correo de notificación.
  * En caso de que se cuenten con input dependientes en el form los nombres deberán tener la siguiente estructura: identificador del form, entre corchetes el nombre que se le asignara al input parent y entre corchetes el nombre que se le asignara a este input child `< input name = "id_from[input parent][input child]" `.
* Todos input deben de estar vinculados al form que los contiene por medio del tag form de la siguiente manera `< input                form = “id_from”          > `. Esto es impotante para evitar que se envíen inputs de otros form y se generen errores, esto sucede generalmente cuando se tienen form dentro de otros form.
* Para preparar la validación recomienda escribir los atributos que requiera cada input por ejemplo:
  
  ```
  < input                        disabled >
  < input                        checked >
  < input                        required >
  ```
  
  * **Notas:** 
    * Todos los input con el atributo required serán interpretados por el Plugin con este atributo como regla por lo que no es necesario que se especifique nuevamente en las reglas especificas.  
    * Los tipos de input de html5 como url, number, email, etc. son interpretados por el Plugin como reglas de validación, que se especifique nuevamente en las reglas especificas. 
    * Es importante que todos los input dependientes se marque con el atributo *disabled* con el fin de que no sean enviados a menos que esto sea requerido.

### Envío del formulario javascript
* Es necesario para que la validación del form funcione correctamente las siguientes lineas deben de colocarse siempre dentro de `$(document).ready(function(){}`. Esta funcion junto con la explicación de su uso se encuentra en archivo functions.js
  
  ```
  $("#id_form").validate({ // activa la validación de los campos
  submitHandler:function(form){ // envía vía post
  		//aquí se define la función para el envío de la información 
  		/*var datos = $(form).serialize();
  		$.post(ajax_mail_url,
  			datos,
  			function(data) {
  				$('#id_submit').val(data);
  			}
  		);*/
  	}
});
  ```
  
* **Notas:** 
  * El envió de información se realiza por medio de ajax por lo cual esta función puede modificarse si es requerido
  * El parámetro `parametrajax_mail_url` se refiere a la ubicación del archivo *ajax-mail.php* por lo cual debe terminar siempre con */ajax/ajax-mail.php*.
  * La función `$("#id_form").validate({` debe de repetirse para cada uno de los form que contenga la pagina.
  ```
  $("#id_form").validate({ // activa la validación de los campos
  submitHandler:function(form){ // envía vía post
  		//aquí se define la función para el envío de la información 
  		/*var datos = $(form).serialize();
  		$.post(ajax_mail_url,
  			datos,
  			function(data) {
  				$('#id_submit').val(data);
  			}
  		);*/
  	}
});
  ```
  
### Definición de las reglas de validación javascript
* Los mensajes de error del Plugin se encuentran en ingles por lo que se hace necesario cambiarlos de idiomas o ajustarlos al contexto de la pagina. Para ello se pueden especificar mensajes de validación que apliquen a los input con un criterio especifico:

  ```
  jQuery.extend(jQuery.validator.messages, { 
  // mensajes generales de validación 
  });
  ```
  
  * **Nota:** Este código deberá siempre ir después del ultimo `$("#id_form").validate({` y no repetirse para cada form 

* Para cada input se pueden definir las reglas de validación y los mensajes específicos que le apliquen:
  
  ```  
  $("#id_input").rules( "add", {
  	// reglas personalizadas para el input
  messages:{ 
  	// mensajes personalizados para el input
  	}	
  });   
  ```
  
	* **Notas:** 
		* Las reglas de validación estándar y la definición de nuevas reglas se encuentran [aquí](http://jqueryvalidation.org/documentation/) 
		* Este código siempre ir después del  `$("#id_form").validate({` y necesita repetirse para cada input al que se le quiera dar una regla especifica.

### Estilo de los mensajes css 
* Para generar mensajes acorde a pagina se puede usar el `#id_form label.error{}` para definir los estilos por ejemplo:

  ``` 
  #id_form label.error{
  margin: 0px;
  font-style: italic;
  color:#d54742;
  font-size:20px;
  }
  ```
  
  * **Nota:** Se puede personalizar el diseño de los errores para cada input por medio de su identificador 

### Configuración del envió PHP
* Dentro de la carpeta ajax se encuentran dos archivos *ajax-mail.php* y *ajax-mail_config.php*.
  * El archivo **ajax-mail.php** contiene las funciones necesarias para el envió de los correos y la aplicación de las mismas (No necesita ser modificado). 
  * El archivo **ajax-mail_config.php** contiene todos los parámetros necesarios para configuración del envió de los correos y el registro en mailchimp.
  * Es necesario definir los siguientes parámetros en función de los form de la pagina:
    * *mail* e-mail de la prestadora de servicios 
	* Adicionalmente para cada form que contenga la pagina es necesario definir los siguientes parámetros:
		*  *id_from* identificador del form al que se trate 
		*  *reg_name* nombre de la persona que se registra 
		*  *reg_mail* e-mail de la persona que se registra 
		*  *primera_linea* primera linea del contenido del mail de notificación.  
		*  *mailchip* llave para identificar el uso de mailchimp para este form. Por defecto false.
		*  Solo para el uso de mailchimp 
		    * *mailchip_apikey* parámetro de la api de mailchimp 
			* *mailchip_listid* parámetro de la lista de mailchimp
			* *mailchip_listurl* dirección de la lista de mailchimp 
			* *mailchip_mergevar_on* llave para identificar el uso de parámetros adicionales en para el registro de mailchimp. Por defecto false.
			* *mailchip_errors_send* llave para identificar el envió de errores por correo del registro de mailchimp. Por defecto false.      
				* Solo para el uso de parámetros  adicionales en mailchimp
					* *$mailchip_merge_array* arreglo con la identificación de la columnas de mailchimp como llaves y los nombres de los input del form que contienen esa informacion.  
				* Solo para el uso de reporte de errores de registro a mailchimp vía email 
					* *mail_errors_send* e-mail donde se envían el reporte de errores 
  


