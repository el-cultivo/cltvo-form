<?php

include_once 'ajax-mail_config.php';

//----------------------------envio de los correos --------------------------------


if(isset( $_POST[id_form]) ){ // en esta función se envía la información  
	$datos = nl2br(isarray($_POST[id_form],primera_linea.'<br>')); // nombre del form para crear la cadena 
	echo cltvo_manda_mail( reg_name, reg_mail, $datos ); // requiere conocer los input de nombre y mail 
}


function isarray($variable,$first_line){ // genera el texto del correo a partir de la cadena enviada por el form 

	if(!empty($variable)){
		if(is_array($variable)){
				$salida=$first_line; // escribe la primer linea 
				foreach ( $variable as $key => $value ) { // escribe las key para como encabezados 
					$salida.='<strong>'.$key.'.- </strong> '.isarray($value,'<br>');
				}				
		}else{ // escribe en contenido de cada input 
			$salida=$variable.'. <br>';
		}
	}else{ // en caso de que el input se enviara vacío
		$salida='Sin información'.'. <br>';
	}
	return $salida;
}


function cltvo_manda_mail($de_quien, $de_quien_mail, $qui_hubo){ // envía correo de registro y notificación 
	$pa_donde = mail;
	$qui_hubo_asunto = "Nuevo registro: ". $de_quien_mail;
	
	if ( !empty($de_quien) ){
		$qui_hubo_asunto .= " (".$de_quien.") ";
	}
	
	if($qui_hubo == '') $qui_hubo = '- No hubo mensaje escrito -';
	$qui_hubo_msj  = $qui_hubo;
	
	/*---------------------------------envió del mail de registro ----------------------------------------------------------*/
	$from = "FROM: $de_quien_mail\r\n";
	$cabeza = "MIME-Version: 1.0\r\n";
	$cabeza .= "Content-Type: text/html; charset=UTF-8\r\n";

	$primer_mail = mail($pa_donde, $qui_hubo_asunto, $qui_hubo_msj, $from.$cabeza);
	
	/*---------------------------------envió del mail de agradecimiento ----------------------------------------------------------*/
	$asunto = "Registro";
	$mensaje = "Gracias por tu mensaje. Nos comunicaremos contigo pronto.";
	$cabeza .=  "FROM: <".$pa_donde.">\r\n";

	$segundo_mail = mail($de_quien_mail, $asunto, $mensaje, $cabeza);
	
	/*---------------------------------regreso de información vía ajax----------------------------------------------------------*/
	
	if( $primer_mail && $segundo_mail ){
		//mailchimp($de_quien_mail, $cabeza); // / función desestabilizada temporalmente 
		return '¡Gracias!';
	}else{
		return "Error en envío";
	}
}


function mailchimp($mail_suscriptor, $cabeza){ // función desestabilizada temporalmente  
	$apiKey = '4104c5726ff76b0a724c56eefd56e1ac';
	$listId = '9b155e6de6';
	$double_optin=false;
	$send_welcome=false;
	$email_type = 'html';
	$email = $mail_suscriptor;
	$submit_url = "http://us7.api.mailchimp.com/1.3/?method=listSubscribe";
	$data = array(
	    'email_address'=>$email,
	    'apikey'=>$apiKey,
	    'id' => $listId,
	    'double_optin' => $double_optin,
	    'send_welcome' => $send_welcome,
	    'email_type' => $email_type
	);
	$payload = json_encode($data);
	 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $submit_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
	 
	$result = curl_exec($ch);
	curl_close ($ch);
	$data = json_decode($result);
	if ($data->error){
		if($data->code != '214'){
			$mail_cultivo = 'hola@elcultivo.mx';
			$mailchimp_mensaje = "Hubo un error al tratar de registrar un mail a la lista.\r\nCódigo de error: ".$data->code;
			mail($mail_cultivo, "Error Mailchimp", $mailchimp_mensaje, $cabeza);
		}
	    
	} 
}

?>