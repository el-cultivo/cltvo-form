<?php

/*--------------------- datos del correo -------------------------------------*/
define('mail', 'contacto@contacto.mx'); //  mail donde se registran 


/*-------------------- es necesario repetir y modificar las siguientes lineas para cada form que contenga la pagina ------------*/ 
$id_form = ''; // cambiar el identificador del form
if(isset( $_POST[$id_form]) ){	

		if(defined('id_form')){ // detiene el código en caso de que ingrese información de dos form diferentes 
			$break_form=true;
		}else{
			/*--------------------- identificadores del form -------------------------------------*/
			define('id_form', $id_form);  
			define('reg_name', $_POST[$id_form]['']); // cambiar el identificador del nombre de la persona que envía en caso de no contar con este campo marcarlo como ''
			define('reg_mail', $_POST[$id_form]['']); // cambiar el identificador del mail de la persona que suscribe  
			
			/*--------------------- contenido del correo -------------------------------------*/
			define('primera_linea', '<strong> Información de Contacto </strong>'); // cambiar el primera linea del contenido del correo 
			
			/*----------------------uso de mail chimp----------------------------------------*/
			define('mailchip', false); // cambiar a true en caso de uso del mailchimp
			if (mailchip == true ){
				define('mailchip_apikey', ''); // cambiar el apy key de mailchimp
				define('mailchip_listid', ''); // cambiar el list id de mailchimp
				define('mailchip_listurl', ''); // cambiar el list id de mailchimp
				define('mailchip_mergevar_on', false); // cambiar a true en caso de que se cuente con campos extra
				if (mailchip_mergevar_on == true){
					//permite tener mas input en el form para seleccionar solo los indispensables para mailchimp o cambiar así como depurar los input no enviados
					$mailchip_merge_array = array( // cambiar la clave y el valor en función del tag de mailchimp y el nombre del input 
												'MERGE1' => id_form.'[]', 
												'MERGE2' => id_form.'[]'
												); 
				}
				define('mailchip_errors_send', false); // cambiar a true en caso de que quieras reporte de errores de mailchimp por mail 
				if (mailchip_errors_send == true ){
					define('mail_errors_send', ''); // cambiar correo donde se envían los errores del mailchimp
				}
			}
		}

}
unset($id_form);
/*--------------------- repetir hasta aquí -------------------------*/

?>