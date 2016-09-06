<?php 
include("control.php");
include("principal.php");
//require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/Routers.php');
$action=$_REQUEST['action']; 


$ipRB			= $_SESSION['ip']; //IP de tu RB.
$Username		= $_SESSION['usuario']; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION['clave']; //Clave del usuario con privilegios
$api_puerto		= $_SESSION['puerto']; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION['reintentos_conexion']; // Connection attempt count
$delay 			= $_SESSION['retraso_conexion']; // Delay between connection attempts in seconds
$timeout 		= $_SESSION['tiempo_maximo_conexion']; // Connection attempt timeout and data read timeout


$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);
?> 
<div class="container">
  <div class="">
    <h3 class="text-center text-success">Usuarios RouterOS<h3><br />
  </div>
<form id="Usuarios" action="#" method="post">
  <table class="table table-hover" id="tabla">
	<div class="container">
		<div class="form-group">
			<tr>
				<th class="success"><label>Id</label></th>
				<th class="success"><label>Nombre</label></th>
				<th class="success"><label>Tiempo Uso</label></th>
				<th class="success"><label>Profile</label></th>
				<th class="success"><label>Tiempo Limite</label></th>
				<th class="success"><label>Comentarios</label></th>
			</tr>
		</div>
	</div>

<?php

	$info = $ROUTERS->ipHotspotUserGetall();

	foreach ($info as $i => $value) {
		$valor=$info[$i];
		$unidad = $valor['limit-uptime'];
		$linea  = $ROUTERS->formateaUnidades($unidad);
		echo 
		'<tr>
			<td class="text-info">'.hexdec($valor['.id']).'</td>
			<td class="text-info">'.$valor['name'].'</td>
			<td class="text-info">'.$valor['uptime'].'</td>
			<td class="text-info">'.$valor['profile'].'</td>
			<td class="text-info">'.$linea.'</td>
			<td class="text-info">'.$valor['comment'].'</td>
		</tr>';
	}
?>
    </tbody>
  </table>
  <input type="hidden" name="action" value="userDel"/>
 </form>



</div>


