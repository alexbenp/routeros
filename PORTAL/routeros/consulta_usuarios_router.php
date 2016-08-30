<?php 
include("control.php");
include("principal.php");
//require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/Routers.php');
$action=$_REQUEST['action']; 

// $ipRB="192.168.56.2"; //IP de tu RB.
// $Username="admin"; //Nombre de usuario con privilegios para acceder al RB
// $clave=""; //Clave del usuario con privilegios
// $api_puerto=8728; //Puerto que definimos el API en IP--->Services
// $attempts = 3; // Connection attempt count
// $delay = 3; // Delay between connection attempts in seconds
// $timeout = 3; // Connection attempt timeout and data read timeout

$ipRB			= $_SESSION["ip"]; //IP de tu RB.
$Username		= $_SESSION["usuario"]; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION["clave"]; //Clave del usuario con privilegios
$api_puerto		= $_SESSION["puerto"]; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION["reintentos_conexion"]; // Connection attempt count
$delay 			= $_SESSION["retraso_conexion"]; // Delay between connection attempts in seconds
$timeout 		= $_SESSION["tiempo_maximo_conexion"]; // Connection attempt timeout and data read timeout


$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);
?> 
<div class="container">
  <div class="">
    <h1>Usuarios RouterOS</h1>
  </div>
<form id="Usuarios" action="#" method="post">
  <table class="table table-hover" id="tabla">
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Tiempo Uso</th>
        <th>Profile</th>
		<th>Tiempo Limite</th>
        <th>Comentarios</th>
      </tr>
    </thead>
    <tbody>

<?php
	$unidadOriginal 	= array("s", "m", "h", "d", "w");
	$valores			= array("");
	$unidadFormateado   = array(" Segundo"," Minuto", " Hora", " Dia", " Semana");
	$unidadMayores   = array(" Segundos"," Minutos", " Horas", " Dias", " Semanas");
		
	$info = $ROUTERS->ipHotspotUserGetall();

	foreach ($info as $i => $value) {
		$valor=$info[$i];
		$unidad = $valor['limit-uptime'];
		$valor_sin_unidad = str_replace($unidadOriginal, $valores, $unidad);
		if ($valor_sin_unidad == '1'){
			$limite = str_replace($unidadOriginal, $unidadFormateado, $unidad);
		}else{
			$limite = str_replace($unidadOriginal, $unidadMayores, $unidad);	
		}
		echo 
		'<tr>
			<td>'.$valor['.id'].'</td>
			<td>'.$valor['name'].'</td>
			<td>'.$valor['uptime'].'</td>
			<td>'.$valor['profile'].'</td>
			<td>'.$limite.'</td>
			<td>'.$valor['comment'].'</td>
		</tr>';
	}

?>
    </tbody>
  </table>
  <input type="hidden" name="action" value="userDel"/>
 </form>



</div>


