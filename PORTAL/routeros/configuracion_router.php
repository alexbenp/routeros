<?php 
include("control.php");
require_once("principal.php");
//require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/RouterDb.php');
require_once ('clases/Routers.php');
$router=$_REQUEST['router']; 
$action=$_REQUEST['action']; 
$estados_router_id = 1;


// $ROUTERS = new Routers();
// $AdminRouters = $ROUTERS->getInformacionAdminRouter($estados_router_id);

$ADMROUTERS = new RoutersDb($router);
$AdminRouters = $ADMROUTERS->getParametrosRouter($estados_router_id);

$ipRB			= $_SESSION["ip"]; //IP de tu RB.
$Username		= $_SESSION["usuario"]; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION["clave"]; //Clave del usuario con privilegios
$api_puerto		= $_SESSION["puerto"]; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION["reintentos_conexion"]; // Connection attempt count
$delay 			= $_SESSION["retraso_conexion"]; // Delay between connection attempts in seconds
$timeout 		= $_SESSION["tiempo_maximo_conexion"]; // Connection attempt timeout and data read timeout





// echo "kjhkjh".$router;
$_SESSION["ip"] 	= $AdminRouters[0]['ip'];
$_SESSION["usuario"] 	= $AdminRouters[0]['usuario'];
$_SESSION["clave"] 	=  $AdminRouters[0]['clave'];
$_SESSION["puerto"] 	= $AdminRouters[0]['puerto'];
$_SESSION["reintentos_conexion"] 	= $AdminRouters[0]['reintentos_conexion'];
$_SESSION["retraso_conexion"] 	= $AdminRouters[0]['retraso_conexion'];
$_SESSION["tiempo_maximo_conexion"] 	= $AdminRouters[0]['tiempo_maximo_conexion'];
?>
	<form class="contacto" id="configura_router" action="#" method="POST" enctype="multipart/form-data"> 
	
		<div>
			<label> Seleccion de Router Para Administrar <label><br />
		</div>
		
		<table class="table table-hover">
			<tr>
				<td><label>Usar</label></td>
				<td><label>IdRouter</label></td>
				<td><label>Nombre</label></td>
				<td><label>IP</label></td>
				<td><label>Puerto</label></td>
				<td><label>Version</label></td>
			</tr>
<?php
		foreach($AdminRouters as $llave=>$elmento){
			$idRouter = $AdminRouters[$llave]['router_id'];
			$nombreRouter = $AdminRouters[$llave]['nombre'];
			$ipRouter = $AdminRouters[$llave]['ip'];
			$puertoRouter = $AdminRouters[$llave]['puerto'];
			$versionRouter = $AdminRouters[$llave]['version'];
			$claveRouter = $AdminRouters[$llave]['clave'];
			$estadoRouter = $AdminRouters[$llave]['estado'];
			$reintentosConexionRouter = $AdminRouters[$llave]['reintentos_conexion'];
			$retrasoConexionRouter = $AdminRouters[$llave]['retraso_conexion'];
			$tiempoMaximoConexionRouter = $AdminRouters[$llave]['tiempo_maximo_conexion'];
			
			echo "<tr>";
			echo "<td>	<input id=\"submit_button\" type=\"submit\" value=\"A\" />
						<input name=\"router\" type=\"hidden\" value=\"".$idRouter."\" />
				  </td>";
			echo "<td><label>".$idRouter."</label></td>";
			echo "<td><label>".$nombreRouter."</label></td>";
			echo "<td><label>".$ipRouter."</label></td>";
			echo "<td><label>".$puertoRouter."</label></td>";
			echo "<td><label>".$versionRouter."</label></td>";
			echo "<tr>";
		}			
?>
		</table>
	</form>
<?php 
if(!empty($router)){
	
	$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);
// echo "<pre>";
// print_r($ROUTERS);
// echo "</pre>";
	$first = $ROUTERS->systemResourcePrint();

	echo "<div><label>Mikrotik RouterOs 4.16 Resources</label></div>";
	echo "<table class=\"table table-hover\" width=500 border=0 align=center>";
	echo "<tr><td>Platform, board name and Ros version is:</td><td>" . $first['platform'] . " - " . $first['board-name'] . " - "  . $first['version'] . " - " . $first['architecture-name'] . "</td></tr>";
	echo "<tr><td>Cpu and available cores:</td><td>" . $first['cpu'] . " at " . $first['cpu-frequency'] . " Mhz with " . $first['cpu-count'] . " core(s) "  . "</td></tr>";
	echo "<tr><td>Uptime is:</td><td>" . $first['uptime'] . " (hh/mm/ss)" . "</td></tr><br />";
	echo "<tr><td>Cpu Load is:</td><td>" . $first['cpu-load'] . " %" . "</td></tr><br />";
	echo "<tr><td>Total,free memory and memory % is:</td><td>" . $first['total-memory'] . "Kb - " . $first['free-memory'] . "Kb - " . number_format($first['mem'],3) . "% </td></tr>";
	echo "<tr><td>Total,free disk and disk % is:</td><td>" . $first['total-hdd-space'] . "Kb - " . $first['free-hdd-space'] . "Kb - " . number_format($first['hdd'],3) . "% </td></tr>";
	echo "<tr><td>Sectors (write,since reboot,bad blocks):</td><td>" . $first['write-sect-total'] . " - " . $first['write-sect-since-reboot'] . " - " . $first['bad-blocks'] . "% </td></tr>";
	echo "</table>";
}
?>
