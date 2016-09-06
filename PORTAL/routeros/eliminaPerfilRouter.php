<?php 
 error_reporting(E_ALL ^ E_NOTICE);
include("control.php");
require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/Routers.php');
$profile = $_GET['id'];


$ipRB			= $_SESSION["ip"]; //IP de tu RB.
$Username		= $_SESSION["usuario"]; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION["clave"]; //Clave del usuario con privilegios
$api_puerto		= $_SESSION["puerto"]; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION["reintentos_conexion"]; // Connection attempt count
$delay 			= $_SESSION["retraso_conexion"]; // Delay between connection attempts in seconds
$timeout 		= $_SESSION["tiempo_maximo_conexion"]; // Connection attempt timeout and data read timeout


$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);

if (!empty($profile)) 
{
	
	if (($profile =="")) 
	{ 
		echo "No se ha podido eliminar el registro";
	}else{
		$profileRemove = $ROUTERS->ipHotspotUserProfileRemove($profile);
		$mensajeRespuestaProfileRemove = $ROUTERS->getMensajeRespuesta();
		$codigoRespuestaProfileRemove = $ROUTERS->getCodigoRespuesta();
	}
	
}
?> 