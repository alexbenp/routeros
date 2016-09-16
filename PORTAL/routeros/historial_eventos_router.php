<?php 
include("control.php");
include("include/config.php");
require_once("principal.php");
require_once ('clases/Routers.php');
$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['PHP_SELF']);
$validaSesion->getPageByName($php_self);

$ipRB			= $_SESSION['ipRouter']; //IP de tu RB.
$Username		= $_SESSION['usuarioRouter']; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION['claveRouter']; //Clave del usuario con privilegios
$api_puerto		= $_SESSION['puertoRouter']; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION['reintentos_conexion']; // Connection attempt count
$delay 			= $_SESSION['retraso_conexion']; // Delay between connection attempts in seconds
$timeout 		= $_SESSION['tiempo_maximo_conexion']; // Connection attempt timeout and data read timeout

$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);
$historySystemRouter = $ROUTERS->historySystemRouter();
// echo "<pre>";
// print_r($logSystemRouter);
// echo "</pre>";	

?>
<div class="container">
  <div class="">
    <h3 class="text-center text-success">Auditoria Eventos RouterOS</h3>
	<h5 class="text-center text-success">
	<?php echo $_SESSION['nombreRouter'].' IP: '.$_SESSION['ipRouter'].' Versión: '.$_SESSION['versionRouter'];
	?>
	</h5>
  </div>
<form id="auditoria" action="#" method="post">
  <table class="table table-hover" id="tabla">
	<div class="container">
		<div class="form-group">
		  <tr>
			<th class="success">Id</th>
			<th class="success">Acción</th>
			<th class="success">Realizado por</th>
			<th class="success">Politica</th>
			<th class="success">Fecha</th>
		  </tr>
		</div>
	</div>
<?php

	foreach ($historySystemRouter as $i => $value) {
		$id    		= hexdec($historySystemRouter[$i]['.id']);
		$action		= $historySystemRouter[$i]['action'];
		$by			= $historySystemRouter[$i]['by'];
		$policy		= $historySystemRouter[$i]['policy'];
		$time		= $historySystemRouter[$i]['time'];
		$floating_undo	= $historySystemRouter[$i]['floating-undo'];

		echo 
		'<tr>
			<td class="text-info">'.$id.'</td>
			<td class="text-info">'.$action.'</td>
			<td class="text-info">'.$by.'</td>
			<td class="text-info">'.$policy.'</td>
			<td class="text-info">'.$time.'</td>
		</tr>';
	}
?>
    </tbody>
  </table>
  <input type="hidden" name="action" value="userDel"/>
 </form>



</div>
