<?php 
include_once("control.php");
require_once("clases/Configuraciones.php");
$Configuraciones = new Configuraciones ();
$ruta_instalacion =  $Configuraciones->getKeyConfig("RUTA_PORTAL");

$imprimeMenu 	= 1;
$action			= $_REQUEST['action']; 

if($action=="profileRemove"){
	$imprimeMenu = 0;
}

if($imprimeMenu == 1){
	require_once("principal.php");	
}
require_once ('clases/Routers.php');
require_once ('clases/Menus.php');

$validaSesion = new Menus($_SESSION['getPerfilId']);

$php_self = str_replace($ruta_instalacion,'',$_SERVER['PHP_SELF']);
 $validaSesion->getPageByName($php_self);
 


$profile		= $_REQUEST['id']; 

$ipRB			= $_SESSION['ipRouter']; //IP de tu RB.
$Username		= $_SESSION['usuarioRouter']; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION['claveRouter']; //Clave del usuario con privilegios
$api_puerto		= $_SESSION['puertoRouter']; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION['reintentos_conexion']; // Connection attempt count
$delay 			= $_SESSION['retraso_conexion']; // Delay between connection attempts in seconds
$timeout 		= $_SESSION['tiempo_maximo_conexion']; // Connection attempt timeout and data read timeout


$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);


if($action=="profileRemove"){
$imprimeMenu = 0;

	$profileRemove = $ROUTERS->ipHotspotUserProfileRemove($profile);
	$mensajeRespuestaProfileRemove = $ROUTERS->getMensajeRespuesta();
	$codigoRespuestaProfileRemove = $ROUTERS->getCodigoRespuesta();
}


if($imprimeMenu == 1){
$info = $ROUTERS->ipHotspotUserProfileGetall();
	$mensajeRespuestaProfileGetAll = $ROUTERS->getMensajeRespuesta();
	$codigoRespuestaProfileGetAll = $ROUTERS->getCodigoRespuesta();


?>
 		<div id="resultado">
			<label>
<?php 		
		if($mensajeRespuestaProfileRemove!=''){
			echo $codigoRespuestaProfileRemove."::".$mensajeRespuestaProfileRemove."::idProfile::".$profile."<br><br>";
		}
		
?>
			</label>
		</div>
<div class="container">
  <div class="">
	<h3 class="text-center text-success">Eliminar Perfiles</h3>
	<h5 class="text-center text-success">
	<?php echo $_SESSION['nombreRouter'].' IP: '.$_SESSION['ipRouter'].' Versión: '.$_SESSION['versionRouter'];
	?>
	</h5>
  </div>
  <?php 
		if($mensajeRespuestaProfileGetAll!='' and $codigoRespuestaProfileGetAll!='00'){
			echo $codigoRespuestaProfileGetAll."::".$mensajeRespuestaProfileGetAll."::idProfile::";
		}
	?>	
<form id="Perfiles" action="#" method="post">
  <table class="table table-hover" id="tabla">
    <thead>
      <tr>
        <th class="success">Id</th>
        <th class="success">Perfil</th>
        <th class="success">Dispositivos</th>
        <th class="success">Velocidad</th>
        <th class="success">Vigencia</th>
		<th class="success">&nbsp</th>
      </tr>
<?php
		if(is_array($info)){
			foreach ($info as $i => $value) {
				$valor	= $info[$i];
				$id 	= $info[$i]['.id'];
				$unidad = $valor['mac-cookie-timeout'];
				$linea  = $ROUTERS->formateaUnidades($unidad);
				echo '<tr id="tr'.$id.'">
						<td class="text-info">'.hexdec($id).'</td>
						<td class="text-info">'.$valor['name'].'</td>
						<td class="text-info">'.$valor['shared-users'].'</td>
						<td class="text-info">'.$valor['rate-limit'].'</td>
						<td class="text-info">'.$linea.'</td>
						<td class="text-info">
							<a style="text-decoration:underline;cursor:pointer;" onclick="deleteInfo(\''.$id.'\',\'elimina_perfiles_router.php\',\'tr\',\'resultado\',\'action\')">Del</a>
						</td>
					</tr>';
			}
		}
?>
  </table>
  <input type="hidden" id="action" name="action" value="profileRemove"/>
 </form>
</div>

<?php
}