﻿# cltvo-form
## Validar form por medio de *jQuery Validation Plugin*

### jQuery Validation Plugin
* Descarga el jQuery Validation Plugin de  [aquí](http://jqueryvalidation.org/)
* Para agregar el Plugin  [aquí](http://jqueryvalidation.org/files/jquery-validation-1.13.1.zip)
* Para agregar  JQuery  [aquí](http://jquery.com/download/)

### Creación del formulario *html*
* Para comenzar a es necesario la asignación de un identificador (id) para el form, esto es importante ya que sirve para ligar los input a el y realizar la validación por medio del Plugin `< form id = "id_form"      >`.
* A cada input es necesario se le asigne un identificador por medio del cual se realizara su validación personalizada `< input id = "id_input"` ademas de la asignación de su nombre.
* El nombre de cada input debe tener la siguiente estructura: identificador del form y entre corchetes un nombre que se le asignara a este input   `< input name = "id_form[input i]" `. Es importante utilizar los nombres completos y no abreviaciones ya que estos valores formaran parte del correo de notificación.
  * En caso de que se cuenten con input dependientes en el form los nombres deberán tener la siguiente estructura: identificador del form, entre corchetes el nombre que se le asignara al input parent y entre corchetes el nombre que se le asignara a este input child `< input name = "id_form[input parent][input child]" `.
* Todos input deben de estar vinculados al form por medio del tag *form* de la siguiente manera `< input                form = “id_form”          > `. Esto es impotante para evitar que se envíen inputs de otros form y se generen errores (sucede comunmente cuando se tienen form dentro de otros form).
* Para preparar la validación se recomienda escribir los atributos que requieran para cada input por ejemplo:
  
  ```HTML
  < input                        disabled >
  < input                        checked >
  < input                        required >
  ```
  
  * **Notas:** 
    * Todos los input con el atributo required serán interpretados por el Plugin con esta regla por lo que no es necesario que se le asigne nuevamente en las reglas especificas.  
    * Los tipos de input de html5 como url, number, email, etc. son interpretados por el Plugin como reglas de validación, por lo que no es necesario que se les asignen nuevamente en las reglas especificas. 
    * Es importante que todos los input dependientes se marque con el atributo *disabled* para que no sean enviados con el submit a menos que esto sea requerido.

### Uso del reCAPTCHA *html*
* Para integrar el reCAPTCHA en un form, antes que nada es necesario contar con una cuenta de google.
* Ingresar a la pagina [Google RECAPTCHA](https://www.google.com/recaptcha/intro/index.html) y dar click sobre el boton **Get reCAPTCHA**
* Seguir los pasos indicados para *Registrar un nuevo sitio* 
* Agregar las siguientes claves lineas al código.
  * En el Header
  ```HTML 
	<script src='https://www.google.com/recaptcha/api.js'></script>
  ```
  * En el form 
  ```HTML 
	<div class="g-recaptcha" data-sitekey="Clave del sitio"></div>
  ``` 
	* La **Clave del sitio** debe ser sustituida por la que te asigna google cuando *Registras el sitio* 
* **Nota** No es necesario configurar ningún paramento adicional para uso del reCAPTCHA, ya que dentro del archivo *ajax-mail.php* ya se cuenta con una validación simple del mismo.

### Envío del formulario *javascript*
* Para que la validación del form funcione correctamente las siguientes lineas deben de colocarse siempre dentro de `$(document).ready(function(){}`. 
  
  ```JavaScript
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
  * El parámetro `ajax_mail_url` se refiere a la ubicación del archivo *ajax-mail.php* por lo cual debe terminar siempre con *ajax/ajax-mail.php*.
  * La función `$("#id_form").validate({` debe de repetirse para cada uno de los form que contenga la pagina.
  ```JavaScript
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
  
### Definición de las reglas de validación *javascript*
* Los mensajes de error del Plugin se encuentran en ingles por lo que se hace necesario cambiarlos de idiomas o ajustarlos al contexto de la pagina. Para ello se pueden especificar mensajes de validación que apliquen a los input con un criterio especifico:

  ```JavaScript
  jQuery.extend(jQuery.validator.messages, { 
  // mensajes generales de validación 
  });
  ```
  
  * **Nota:** Este código deberá ir siempre después del ultimo `$("#id_form").validate({` y no repetirse para cada form 

* Para cada input se pueden definir las reglas de validación y los mensajes específicos que le apliquen:
  
  ```JavaScript
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

  ```CSS 
  #id_form label.error{
  margin: 0px;
  font-style: italic;
  color:#d54742;
  font-size:20px;
  }
  ```
  
  * **Nota:** Se puede personalizar el diseño de los errores para cada input por medio de su identificador 

### Configuración del envió *PHP*
* Dentro de la carpeta ajax se encuentran dos archivos *ajax-mail.php* y *ajax-mail_config.php*.
  * El archivo **ajax-mail.php** contiene las funciones necesarias para el envió de los correos y la aplicación de las mismas (No necesita ser modificado). 
  * El archivo **ajax-mail_config.php** contiene todos los parámetros necesarios para configuración del envió de los correos y el registro en mailchimp.
  * Es necesario definir los siguientes parámetros en función de los form de la pagina:
    * *mail* e-mail de la prestadora de servicios 
	* Adicionalmente para cada form que contenga la pagina es necesario definir los siguientes parámetros:
		*  *id_form* identificador del form al que se trate 
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