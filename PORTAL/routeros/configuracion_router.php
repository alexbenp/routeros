<?php 
include("control.php");
include("include/config.php");
// require_once("principal.php");
//require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/RouterDb.php');
require_once ('clases/Routers.php');


$imprimeMenu 	= 1;
$estados_router_id = 1;
$action			= $_REQUEST['action']; 
$routerId		=$_REQUEST['router_id']; 
$usuario_id 	= $_SESSION['usuario_id'];

if($action=="sSgetInfoRouter"){
	require_once ('clases/Menus.php');
	$imprimeMenu = 0;
}

if($imprimeMenu == 1){
	require_once("principal.php");	
}

$ADMROUTERS = new RoutersDb();
$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['PHP_SELF']);
// echo "php_self".$php_self;
$validaSesion->getPageByName($php_self);





// require_once 'clases/Menus.php';





// $ROUTERS = new Routers();
// $AdminRouters = $ROUTERS->getInformacionAdminRouter($estados_router_id);



$AdminRouters = $ADMROUTERS->getRouterUser($usuario_id,$estados_router_id);
$getCodigoRespuestaRouter = $ADMROUTERS->getCodigoRespuesta();
$getMensajeRespuestaRouter = $ADMROUTERS->getMensajeRespuesta();


if(empty($routerId) and empty($_SESSION['ipRouter'])){
	
	if($getCodigoRespuestaRouter!='00'){
		echo $getCodigoRespuestaRouter."::".$getMensajeRespuestaRouter."<br><br>";
	}else{
		$contar = true;
		$_SESSION['router_id'] 				= $AdminRouters[0]['router_id'];
		$_SESSION['ipRouter'] 				= $AdminRouters[0]['ipRouter'];
		$_SESSION['nombreRouter'] 			= $AdminRouters[0]['nombreRouter'];
		$_SESSION['usuarioRouter'] 			= $AdminRouters[0]['usuarioRouter'];
		$_SESSION['claveRouter'] 			= $AdminRouters[0]['claveRouter'];
		$_SESSION['puertoRouter'] 			= $AdminRouters[0]['puertoRouter'];
		$_SESSION['reintentos_conexion'] 	= $AdminRouters[0]['reintentos_conexion'];
		$_SESSION['retraso_conexion'] 		= $AdminRouters[0]['retraso_conexion'];
		$_SESSION['tiempo_maximo_conexion'] = $AdminRouters[0]['tiempo_maximo_conexion'];
	}
}elseif($routerId>0){
	$getRouterUserByRouterId = $ADMROUTERS->getRouterUserByRouterId($usuario_id,$routerId,$estados_router_id);
	$getCodigoRespuestaRouterUser = $ADMROUTERS->getCodigoRespuesta();
	$getMensajeRespuestaRouterUser = $ADMROUTERS->getMensajeRespuesta();
	
	if($getCodigoRespuestaRouterUser!='00'){
		echo $getCodigoRespuestaRouterUser."::".$getMensajeRespuestaRouterUser."<br><br>";
	}else{
		$contar = true;
		$_SESSION['router_id'] 				= $getRouterUserByRouterId[0]['router_id'];
		$_SESSION['ipRouter'] 				= $getRouterUserByRouterId[0]['ipRouter'];
		$_SESSION['nombreRouter'] 			= $getRouterUserByRouterId[0]['nombreRouter'];
		$_SESSION['usuarioRouter'] 			= $getRouterUserByRouterId[0]['usuarioRouter'];
		$_SESSION['claveRouter'] 			= $getRouterUserByRouterId[0]['claveRouter'];
		$_SESSION['puertoRouter'] 			= $getRouterUserByRouterId[0]['puertoRouter'];
		$_SESSION['reintentos_conexion'] 	= $getRouterUserByRouterId[0]['reintentos_conexion'];
		$_SESSION['retraso_conexion'] 		= $getRouterUserByRouterId[0]['retraso_conexion'];
		$_SESSION['tiempo_maximo_conexion'] = $getRouterUserByRouterId[0]['tiempo_maximo_conexion'];
	}

}

$ipRB			= $_SESSION['ipRouter']; //IP de tu RB.
$UsernameRouter	= $_SESSION['usuarioRouter']; //Nombre de usuario con privilegios para acceder al RB
$claveRouter	= $_SESSION['claveRouter']; //Clave del usuario con privilegios
$api_puerto		= $_SESSION['puertoRouter']; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION['reintentos_conexion']; // Connection attempt count
$delay 			= $_SESSION['retraso_conexion']; // Delay between connection attempts in seconds
$timeout 		= $_SESSION['tiempo_maximo_conexion']; // Connection attempt timeout and data read timeout



			// echo "<pre>";
			// print_r($_SESSION);
			// // echo "</pre>";
			// // echo "<pre>";
			// print_r($_REQUEST);
			// print_r($_POST);
			// echo "</pre>";
// echo "kjhkjh".$router;


if($imprimeMenu == 1){
?> 

		
<?php 

?>
	<form class="contacto" id="configura_router" action="#" method="POST" enctype="multipart/form-data"> 
	
		<div>
			<h3 class="text-center text-success">Conectado al Router <h3><br />
		</div>
		
<?php 
		if($getMensajeRespuestaRouter!='' and $getCodigoRespuestaRouter!='00'){
			echo $getCodigoRespuestaRouter."::".$getMensajeRespuestaRouter."<br><br>";
		}
?>		
		
		<table class="table table-hover">
			<div class="container">
						<div class="form-group">
							<tr>
								<th class="success"><label>IdRouter</label></th>
								<th class="success"><label>Nombre</label></th>
								<th class="success"><label>IP</label></th>
								<th class="success"><label>Puerto</label></th>
								<th class="success"><label>Version</label></th>
								<th class="success"><label>Princial</label></th>
								<th class="success"><label>Usar</label></th>
							</tr>
						</div>
					</div>

<?php
		foreach($AdminRouters as $llave=>$elmento){
			$idRouter = $AdminRouters[$llave]['router_id'];
			$nombreRouter = $AdminRouters[$llave]['nombreRouter'];
			$ipRouter = $AdminRouters[$llave]['ipRouter'];
			$puertoRouter = $AdminRouters[$llave]['puertoRouter'];
			$versionRouter = $AdminRouters[$llave]['versionRouter'];
			$principalRouter = $AdminRouters[$llave]['principal'];
			// $listClaveRouter = $AdminRouters[$llave]['claveRouter'];
			$estadoRouter = $AdminRouters[$llave]['estadoRouter'];
			$reintentosConexionRouter = $AdminRouters[$llave]['reintentos_conexion'];
			$retrasoConexionRouter = $AdminRouters[$llave]['retraso_conexion'];
			$tiempoMaximoConexionRouter = $AdminRouters[$llave]['tiempo_maximo_conexion'];
			
			echo '<tr id="tr'.$idRouter.'">';
			echo '<td class="text-info"><label>'.$idRouter.'</label></td>';
			echo '<td class="text-info"><label>'.$nombreRouter.'</label></td>';
			echo '<td class="text-info"><label>'.$ipRouter.'</label></td>';
			echo '<td class="text-info"><label>'.$puertoRouter.'</label></td>';
			echo '<td class="text-info"><label>'.$versionRouter.'</label></td>';
			echo '<td class="text-info"><label>'.$principalRouter.'</label></td>';
			if($idRouter == $_SESSION['router_id']){
				echo '<td class="text-info">Act</td>';
			}else{
				echo '<td class="text-info">	
				<input class="btn btn-success" id="submit_button" onclick="buttonSendForm(\''.$idRouter.'\');" type="button" value="A" />
				  </td>';
			}
			// echo '<td class="text-info">
						// <a style="text-decoration:underline;cursor:pointer;"  onclick="sendInfo(\''.$idRouter.'\',\'configuracion_router.php\',\'tr\',\'resultado\',\'action\')">A</a>
					// </td>';
					
			echo '<tr>';
		}			
?>
		</table>
		<input type="hidden" id="action" name="action" value="getInfoRouter"/>
		<input type="hidden" id="router_id" name="router_id" value=""/>
	</form>
<script>
function buttonSendForm(router_id){
	document.getElementById('router_id').value = router_id;
    document.getElementById('configura_router').submit();
}

</script>

<div id="resultado">
<?php 
}
// if($contar){
	// echo "Que hace aqui===???" .$ipRB . $UsernameRouter .$claveRouter. $api_puerto. $attempts. $delay. $timeout;
	$ROUTERS = new Routers($ipRB , $UsernameRouter , $claveRouter, $api_puerto, $attempts, $delay, $timeout);
// echo "<pre>";
// print_r($ROUTERS);
// echo "</pre>";
	echo '<script>document.getElementById("div_menu").value = alex </script>';
	
	$first = $ROUTERS->systemResourcePrint();

	echo '<div><label>Mikrotik RouterOs 4.16 Resources</label></div>';
	echo '<table class="table table-hover" width=500 border=0 align=center>';
	echo '<tr><td>Platform, board name and Ros version is:</td><td>' . $first['platform'] . ' - ' . $first['board-name'] . ' - '  . $first['version'] . ' - ' . $first['architecture-name'] . '</td></tr>';
	echo '<tr><td>Cpu and available cores:</td><td>' . $first['cpu'] . ' at ' . $first['cpu-frequency'] . ' Mhz with ' . $first['cpu-count'] . ' core(s) '  . '</td></tr>';
	echo '<tr><td>Uptime is:</td><td>' . $first['uptime'] . ' (hh/mm/ss)' . '</td></tr><br />';
	echo '<tr><td>Cpu Load is:</td><td>' . $first['cpu-load'] . ' %' . '</td></tr><br />';
	echo '<tr><td>Total,free memory and memory % is:</td><td>' . $first['total-memory'] . 'Kb - ' . $first['free-memory'] . 'Kb - ' . number_format($first['mem'],3) . '% </td></tr>';
	echo '<tr><td>Total,free disk and disk % is:</td><td>' . $first['total-hdd-space'] . 'Kb - ' . $first['free-hdd-space'] . 'Kb - ' . number_format($first['hdd'],3) . '% </td></tr>';
	echo '<tr><td>Sectors (write,since reboot,bad blocks):</td><td>' . $first['write-sect-total'] . ' - ' . $first['write-sect-since-reboot'] . ' - ' . $first['bad-blocks'] . '% </td></tr>';
	echo '</table>';
// }

?>
</div>
<?php