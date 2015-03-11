<?php

include_once 'ajax-mail_config.php';

//----------------------------envió de los correos --------------------------------


if( isset($_POST[id_form]) && !isset($break_form) ){ // en esta función se envía la información  solo en caso de que la información llegue correctamente 
	$datos = nl2br(isarray($_POST[id_form],primera_linea.'<br>')); // nombre del form para crear la cadena 
	if(!isset($mailchip_merge_array)){
		$mailchip_merge_array= array();
	}
	echo cltvo_manda_mail( reg_name, reg_mail, $datos , $mailchip_merge_array); // requiere conocer los input de nombre y mail 
}else{ // o regresa un error en caso de que exista un problema con los form 
	echo "Error en envío"; 
}

//----------------------------funciones para el envió del correo --------------------------------

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


function cltvo_manda_mail($de_quien, $de_quien_mail, $qui_hubo, $mailchip_merge_array){ // envía correo de registro y notificación 
	$pa_donde = mail;
	$qui_hubo_asunto = "Nuevo registro: ". $de_quien_mail;
	
	if ( !empty($de_quien) ){
		$qui_hubo_asunto .= " (".$de_quien.") ";
	}
	
	if($qui_hubo == '') $qui_hubo = '- No hubo mensaje escrito -';
	$qui_hubo_msj  = $qui_hubo;
	
	/*---------------------------------envió del mail de registro ----------------------------------------------------------*/
	$from = "FROM: ".$de_quien_mail."\r\n";
	$cabeza = "MIME-Version: 1.0\r\n";
	$cabeza .= "Content-Type: text/html; charset=UTF-8\r\n";

	$primer_mail = mail($pa_donde, $qui_hubo_asunto, $qui_hubo_msj, $from.$cabeza);
	
	/*---------------------------------envió del mail de agradecimiento ----------------------------------------------------------*/
	$asunto = "Registro";
	$mensaje = "Gracias por tu mensaje. Nos comunicaremos contigo pronto.";
	$cabeza .=  "FROM: <".$pa_donde.">\r\n";

	$segundo_mail = mail($de_quien_mail, $asunto, $mensaje, $cabeza);
	
	/*---------------------------------regreso de información vía ajax y activación del mailchimp----------------------------------------------------------*/
	
	if( $primer_mail && $segundo_mail ){	
		if mailchip == true ){ // solo en caso de que quieran registrarse en mailchimp
			
			$mergevars_val=array(); // inicia si campos extra en para mailchimp
			if(mailchip_mergevar_on==true){ // solo en caso de que quieran registrarse campos extra en mailchimp
				$mailchimp_mergevars=merge_vars_gen($_POST[id_form]);// función para definir el valor de los campos extra

				foreach ($mailchip_merge_array as $key => $value) { // asigna el valor correspondiente a campo extra 
					if( isset( $mailchimp_mergevars[$value] ){
						$mergevars_val[$key] = $mailchimp_mergevars[$value]; 
					}else{
						$mergevars_val[$key] = ""; // en caso de que el input no llegara lo marca como vació
					}
				}

			}
			mailchimp($mergevars_val, $cabeza); // función para enviar a mailchimp 
		}
		return '¡Gracias!';	
	}else{
		return "Error en envío";
	}
}

//----------------------------funciones para el mailchimp --------------------------------

function merge_vars_gen($variable){ // genera los campos extra en caso del uso del mailchimp

	$string=merge_vars_string($variable,id_form); // obtiene un string con todas las llaves y las variables 

	$array_simple=explode('/fin/',$string); // obtiene un array con cada llave y su variable

	foreach ($array_simple as  $key_array) {
		if(!empty($key_array)){//Solo no vacias 
			$key_y_array= explode('/sep/',$key_array);
			//$salida[]=$key_y_array;
			if(count($key_array)<>2){//solo los array que se encuentren bien 
				$salida[$key_y_array[0]]=$key_y_array[1];
			}

		}
	}

	return $salida;
}	

function merge_vars_string($variable,$prehol){ // genera una cadena a partir de la cadena enviada por el form para obtener los los campos extra en caso del uso del mailchimp 
	if(!empty($variable)){
		if(is_array($variable)){
				$salida=""; // escribe la primer linea 
				foreach ( $variable as $key => $value ) { // escribe las key para como encabezados
					if(!is_array($value)){ // solo escribe la key en caso de que no sea array
						$salida.=$prehol.'['.$key.']/sep/';
					}
					$salida.=merge_vars_string($value,$prehol."[".$key."]");
				}				
		}else{ // escribe en contenido de cada input 
			$salida=$variable.'/fin/';
		}
	}else{ // en caso de que el input se enviara vacío
		$salida=''.'/fin/';
	}
	return $salida;
}


function mailchimp($mailchimp_mergevars, $cabeza){ // función de registro en mailchimp 

	/*----------------------------parámetros del mailchimp----------------------------------*/
	
	$apiKey = mailchip_apikey; // apikey de mail chimp 
	$listId = mailchip_listid; // id de la lista de mail chimp 
	$submit_url = mailchip_listurl; // dirección de la lista en mail chimp 
	$double_optin=false;
	$send_welcome=false;
	$email_type = 'html';
	
	$data = array( //array de parametros  
	    'apikey'=>$apiKey,
	    'id' => $listId,
	    'double_optin' => $double_optin,
	    'send_welcome' => $send_welcome,
	    'email_type' => $email_type
	);
	
	/*-----------------------ingreso de los datos------------------------------------------------*/
	
	$data['email_address']=reg_mail; //definición del mail que se inscribe
	if(mailchip_mergevar_on==true){
		$data['merge_vars']= $mailchimp_mergevars; // definición del resto de los campos 
	}
	
	
	/*--------------- codigo de envio a mailchimp----------------------*/
	$payload = json_encode($data);
	 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $submit_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
	 
	$result = curl_exec($ch);
	curl_close ($ch);

	/*---------------detección de errores y envió de los mismos-------------------*/
	if($result != true){
		if (mailchip_errors_send == true ){ // solo en caso de que quieran recibirse los errores por mail
			$data = json_decode($result);
			if ($data->error){
				if($data->code != '214'){
						$mail_cultivo = mail_errors_send; // mail para el reporte de errores 
						$mailchimp_mensaje = "Hubo un error al tratar de registrar un mail a la lista. (".$listId.") \r\nCódigo de error: ".$data->code;
						mail($mail_cultivo, "Error Mailchimp", $mailchimp_mensaje, $cabeza);
				}else{
					// en caso de mail ya inscrito
				} 
			}
		}
	}else{
		// en caso de correcto
	}

}

?>