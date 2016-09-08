<?php 
include("control.php");
include("principal.php");
include("include/config.php");
require_once ('clases/Routers.php');
$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['REQUEST_URI']);
$validaSesion->getPageByName($php_self);

$action			= $_REQUEST['action']; 
$profile		= $_REQUEST['profile']; 
$ipRB			= $_SESSION["ip"]; //IP de tu RB.
$Username		= $_SESSION["usuario"]; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION["clave"]; //Clave del usuario con privilegios
$api_puerto		= $_SESSION["puerto"]; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION["reintentos_conexion"]; // Connection attempt count
$delay 			= $_SESSION["retraso_conexion"]; // Delay between connection attempts in seconds
$timeout 		= $_SESSION["tiempo_maximo_conexion"]; // Connection attempt timeout and data read timeout

$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);


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
		$profileAdd = $ROUTERS->ipHotspotUserProfileAdd($profile_name,$user_shared,$rx,$tx,$add_mac_cookie,$mac_uptime);
		$mensajeRespuestaProfileAdd = $ROUTERS->getMensajeRespuesta();
		$codigoRespuestaProfileAdd = $ROUTERS->getCodigoRespuesta();
	}
}elseif($action=="profileDel"){
	// echo "Amtes ".$profile;
	// $profile = str_replace($profile,'*','');
	// echo "despues ".$profile;
	$profileRemove = $ROUTERS->ipHotspotUserProfileRemove($profile);
	$mensajeRespuestaProfileRemove = $ROUTERS->getMensajeRespuesta();
	$codigoRespuestaProfileRemove = $ROUTERS->getCodigoRespuesta();
}

$info = $ROUTERS->ipHotspotUserProfileGetall();

?>

<div class="container">
  <div class="">
    <h3 class="text-center text-success">Crea Perfiles RouterOS<h3><br />
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
