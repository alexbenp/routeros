<?php 
 error_reporting(E_ALL ^ E_NOTICE);
include("control.php");
include("include/config.php");
require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/Routers.php');


$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['REQUEST_URI']);
$validaSesion->getPageByName($php_self);
// $usuario_id = $_POST['id'];
$usuario_id = $_GET['id'];


$ipRB			= $_SESSION["ip"]; //IP de tu RB.
$Username		= $_SESSION["usuario"]; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION["clave"]; //Clave del usuario con privilegios
$api_puerto		= $_SESSION["puerto"]; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION["reintentos_conexion"]; // Connection attempt count
$delay 			= $_SESSION["retraso_conexion"]; // Delay between connection attempts in seconds
$timeout 		= $_SESSION["tiempo_maximo_conexion"]; // Connection attempt timeout and data read timeout


$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);

if (!empty($usuario_id)) 
{
	
	if (($usuario_id =="")) 
	{ 
		echo "Todos los campos son obligatorios, por favor completa <a href=\"\">el formulario</a> nuevamente.";
	}else{
		$userRemove = $ROUTERS->ipHotspotUserRemove($usuario_id);
		$mensajeRespuestaUserRemove = $ROUTERS->getMensajeRespuesta();
		$codigoRespuestaUserRemove = $ROUTERS->getCodigoRespuesta();


	}
	
}
?> 