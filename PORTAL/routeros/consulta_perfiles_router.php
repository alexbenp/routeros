<?php 
include("control.php");
include("principal.php");
require_once("clases/Configuraciones.php");
require_once ('clases/Routers.php');
$Configuraciones = new Configuraciones ();
$ruta_instalacion =  $Configuraciones->getKeyConfig("RUTA_PORTAL");

$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['PHP_SELF']);
$validaSesion->getPageByName($php_self);

$action			= $_REQUEST['action']; 
$profile		= $_REQUEST['profile']; 
$ipRB			= $_SESSION['ipRouter']; //IP de tu RB.
$Username		= $_SESSION['usuarioRouter']; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION['claveRouter']; //Clave del usuario con privilegios
$api_puerto		= $_SESSION['puertoRouter']; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION['reintentos_conexion']; // Connection attempt count
$delay 			= $_SESSION['retraso_conexion']; // Delay between connection attempts in seconds
$timeout 		= $_SESSION['tiempo_maximo_conexion']; // Connection attempt timeout and data read timeout

$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);

$info = $ROUTERS->ipHotspotUserProfileGetall();

?>

 		<div id="resultado">
			<label>
			</label>
		</div>
		
<div class="container">
  <div class="">
    <h3 class="text-center text-success">Lista de Perfiles</h3>
	<h5 class="text-center text-success">
	<?php echo $_SESSION['nombreRouter'].' IP: '.$_SESSION['ipRouter'].' Versión: '.$_SESSION['versionRouter'];
	?>
	</h5>
  </div>
 <?php
  	$mensajeRespuestaUserProfile = $ROUTERS->getMensajeRespuesta();
	$codigoRespuestaUserProfile = $ROUTERS->getCodigoRespuesta();
	
	if($mensajeRespuestaUserProfile!='' and $codigoRespuestaUserProfile!='00'){
		echo $codigoRespuestaUserProfile."::".$mensajeRespuestaUserProfile."<br><br>";
	}
 ?> 
	
<form id="Perfiles" action="#" method="post">
  <table class="table table-hover" id="tabla">
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
				// echo "ada".$id;
				echo '<tr id="tr'.$id.'">
						<td class="text-info">'.$id.'</td>
						<td class="text-info">'.$valor['name'].'</td>
						<td class="text-info">'.$valor['shared-users'].'</td>
						<td class="text-info">'.$valor['rate-limit'].'</td>
						<td class="text-info">'.$linea.'</td>
					</tr>';
			}
	}
?>
  </table>
 </form>
</div>
