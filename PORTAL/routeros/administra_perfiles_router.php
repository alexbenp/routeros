<?php 
include("control.php");
include("principal.php");
require_once("clases/Configuraciones.php");
require_once ('clases/Routers.php');
require_once ('clases/AuditoriaRoutersDb.php');
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

$AuditoriaRoutersDB = new AuditoriaRoutersDb ($_SESSION['usuario_id'],$_SESSION['router_id']);

if ($action=="profileAdd")
{
	$profile_name	=$_REQUEST['profile_name']; 
	$mac_uptime		=$_REQUEST['value_mac_uptime'].$_REQUEST['unid_mac_uptime'];
	$user_shared	=$_REQUEST['user_shared'];
	$rx				=$_REQUEST['rx']; 
	$tx				=$_REQUEST['tx'];
	
	if(empty($mac_uptime) ){
		$add_mac_cookie = "no";
	}else{
		$add_mac_cookie = "yes";
	}
		
	
	if (($profile_name=="")||($user_shared=="")) 
	{
		echo "<br>Todos los campos son obligatorios, por favor completa <a href=\"\">el formulario</a> nuevamente.";
	}else{
		
		$accionAud = $AuditoriaRoutersDB->getAcciones('CREACION');
		$accion_auditoria_id = $accionAud[0]['accion_id'];
		if(empty($accion_auditoria_id)){
			$mensajeRespuestaProfileAdd = 'No se ha definido que accion ejecutar';
			$codigoRespuestaProfileAdd = '34';
		}else{
			
			$regAuditoriaProfileId = $AuditoriaRoutersDB->ipHotspotUserProfileAddDB($accion_auditoria_id,$profile_name,$user_shared,$rx,$tx,$add_mac_cookie,$mac_uptime);
			
			$mensajeRespuestaAuditProfileAddDB = $AuditoriaRoutersDB->getMensajeRespuesta();
			$codigoRespuestaAuditProfileAddDB = $AuditoriaRoutersDB->getCodigoRespuesta();
			if($codigoRespuestaAuditProfileAddDB == '00'){
				if($regAuditoriaProfileId>0){
					
					$profileAdd = $ROUTERS->ipHotspotUserProfileAdd($profile_name,$user_shared,$rx,$tx,$add_mac_cookie,$mac_uptime);
					$mensajeRespuestaProfileAdd = $ROUTERS->getMensajeRespuesta();
					$codigoRespuestaProfileAdd = $ROUTERS->getCodigoRespuesta();
					
					if($codigoRespuestaProfileAdd == '00'){
						$validaExistencia = $ROUTERS->ipHotspotUserProfilePrint($profile_name,$estado);
						if(is_array($validaExistencia)){
							$id_perfil_usuario_router = $validaExistencia[0]['.id'];
							// echo "que tiene??<br>";
							// echo "$regAuditoriaId -- $id_usuario_router -- $name<br>";
							$regAuditoriaProfile = $AuditoriaRoutersDB->ipHotspotUserProfileAddDBUpdate($regAuditoriaProfileId,$id_perfil_usuario_router,$codigoRespuestaProfileAdd.":".$mensajeRespuestaProfileAdd);
							$mensajeRespuestaUserProfileAddBDUpdate = $AuditoriaRoutersDB->getMensajeRespuesta();
							$codigoRespuestaUserProfileAddBDUpdate = $AuditoriaRoutersDB->getCodigoRespuesta();
							
						}else{
							$mensajeRespuestaProfileAdd = 'No encuentra usuario registrado::'.$codigoRespuestaUserProfileAddBDUpdate;
							$codigoRespuestaProfileAdd = '35';
						}
					}
				}else{
					$mensajeRespuestaProfileAdd = 'Error identificando registro Auditoria::'.$codigoRespuestaAuditProfileAddDB;
					$codigoRespuestaProfileAdd = '37';
				}
			}else{
				$mensajeRespuestaProfileAdd = 'Error registro Auditoria::'.$codigoRespuestaAuditProfileAddDB;
				$codigoRespuestaProfileAdd = '36';
			}
			

			
			
			
			
		}	
		
	}
}

$info = $ROUTERS->ipHotspotUserProfileGetall();

?>

<div class="container">
  <div class="">
    <h3 class="text-center text-success">Crea Perfiles RouterOS</h3>
	<h5 class="text-center text-success">
	<?php echo $_SESSION['nombreRouter'].' IP: '.$_SESSION['ipRouter'].' Versión: '.$_SESSION['versionRouter'];
	?>
	</h5>
  </div>

 		<div>
			<label>
<?php 		
		if($mensajeRespuestaProfileAdd!=''){
			echo $codigoRespuestaProfileAdd."::".$mensajeRespuestaProfileAdd."<br><br>";
		}
		if($mensajeRespuestaProfileRemove!=''){
			echo $codigoRespuestaProfileRemove."::".$mensajeRespuestaProfileRemove."::idProfile::".$profile."<br><br>";
		}
?>
			</label>
		</div>
  
	<form id="addPerfiles" action="#" method="post">
		<div class="form-group has-success">
	  
			<label for="inputSuccess" class="col-lg-12 control-label">Perfil </label>
			<div class="col-lg-4">
				<input type="text" name="profile_name" id="profile_name" class="form-control" value="" size="10" placeholder=" DIGITE NOMBRE PERFIL" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">Dispositivos </label>
			<div class="col-lg-4">
				<select id="user_shared" name="user_shared" class="form-control">
				  <option>1</option>
				  <option>2</option>
				</select>
			</div>
			
			<label for="inputSuccess" class="col-lg-12 control-label">Vigencia </label>
			<div class="col-lg-4">
				<input id="value_mac_uptime" type="text" class="form-control" name="value_mac_uptime" size="2">
			</div>
			<div class="col-lg-6">
				<select id="unid_mac_uptime" name="unid_mac_uptime" class="form-control">
				<?php 		
					$info = $ROUTERS->unidadesTiempo();
					foreach ($info as $i => $value) {
						echo '<option id="'.$i.'" value="'.$i.'">'.$value.'</option>';
					}
				?>
				</select>
			</div>
			
			<label for="inputSuccess" class="col-lg-12 control-label">Velocidad RX </label>
			<div class="col-lg-4">
				<input id="rx" type="text" name="rx" class="form-control" value="512" size="4">
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">Velocidad TX </label>
			<div class="col-lg-4">
				<input id="tx" type="text" name="tx"  class="form-control"  value="512" size="4">
				<br /><br />
				<input type="submit" class="btn btn-success"  value="Agregar">
				<input type="hidden" name="action" value="profileAdd"/>
			</div>
			
		</div>

	</form>	
</div>
