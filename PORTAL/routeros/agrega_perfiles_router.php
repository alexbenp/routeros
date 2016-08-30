<?php
// include("control.php");
// include("principal.php");

// extract($_POST);
		// Con la función header podemos indicar al explorar que el tipo de contenido será JSON
		// en caso de no hacer esto en el PHP entonces tendríamos que convertir el texto a JSON en el javascript
		header('Content-Type: application/json');

		//Luego vamos a crear un arreglo con toda la información que queremos enviar como respuesta y lo convertimos a JSON
		// para esto utilizamos la función json_encode
		echo json_encode(array('exito'=>true, 'id'=>88888, 'profile_name'=>$profile_name, 'user_shared'=>$user_shared, 'mac_uptime'=> $mac_uptime, 'rx'=> $rx, 'tx'=> $tx ));

		// exit();
		
		/*
$ipRB			= $_SESSION["ip"]; //IP de tu RB.
$Username		= $_SESSION["usuario"]; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION["clave"]; //Clave del usuario con privilegios
$api_puerto		= $_SESSION["puerto"]; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION["reintentos_conexion"]; // Connection attempt count
$delay 			= $_SESSION["retraso_conexion"]; // Delay between connection attempts in seconds
$timeout 		= $_SESSION["tiempo_maximo_conexion"]; // Connection attempt timeout and data read timeout


$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);


if ($action=="profileAdd")
{
	// $profile_name	=$_REQUEST['profile_name']; 
	// $mac_uptime		=$_REQUEST['value_mac_uptime'].$_REQUEST['unid_mac_uptime'];
	// $user_shared	=$_REQUEST['user_shared'];
	// $rx				=$_REQUEST['rx']; 
	// $tx				=$_REQUEST['tx'];
	
	if(empty($mac_uptime) ){
		$add_mac_cookie = "no";
	}else{
		$add_mac_cookie = "yes";
	}
		
	
	if (($profile_name=="")||($user_shared=="")) 
	{
		echo "<br>Todos los campos son obligatorios, por favor completa <a href=\"\">el formulario</a> nuevamente.";
	}else{
		$profileAdd = $ROUTERS->ipHotspotUserProfileAdd($profile_name,$user_shared,$rx,$tx,$add_mac_cookie,$mac_uptime);
		$mensajeRespuestaProfileAdd = $ROUTERS->getMensajeRespuesta();
		$codigoRespuestaProfileAdd = $ROUTERS->getCodigoRespuesta();
		

	}

}


?>