<?php

/*--------------------- datos del correo -------------------------------------*/
define('mail', 'contacto@contacto.mx'); //  mail donde se registran 


/*-------------------- es necesario repetir y modificar las siguientes lineas para cada form que contenga la pagina ------------*/ 
$id_form = 'contact_form'; // cambiar el identificador del form
if(isset( $_POST[$id_form]) ){	
		/*--------------------- identificadores del form -------------------------------------*/
		define('id_form', 'contact_form');  
		define('reg_name', $_POST[$id_form]['Nombre(s)']); // cambiar el identificador del nombre de la persona que envía en caso de no contar con este campo marcarlo como ''
		define('reg_mail', $_POST[$id_form]['E-mail']); // cambiar el identificador del mail de la persona que suscribe  
		/*--------------------- contenido del correo -------------------------------------*/
		define('primera_linea', '<strong> Información de Contacto </strong><br>'); // cambiar el primera linea del contenido del correo 
}
unset($id_form);
/*--------------------- repetir hasta aquí -------------------------*/

?>