<?php 
include("control.php");
include("principal.php");
require_once ('clases/Routers.php');
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
    <h1>Lista de Perfiles</h1>
  </div>
<form id="Perfiles" action="#" method="post">
  <table class="table table-hover" id="tabla">
    <thead>
      <tr>
        <th>Id</th>
        <th>Perfil</th>
        <th>Dispositivos</th>
        <th>Velocidad</th>
        <th>Vigencia</th>
		<th>&nbsp</th>
      </tr>
    </thead>
    <tbody>
<?php

			foreach ($info as $i => $value) {
				$valor	= $info[$i];
				$id 	= $info[$i]['.id'];
				$unidad = $valor['mac-cookie-timeout'];
				$linea  = $ROUTERS->formateaUnidades($unidad);
				// echo "ada".$id;
				echo '<tr id="tr'.$id.'">
						<td>'.$id.'</td>
						<td>'.$valor['name'].'</td>
						<td>'.$valor['shared-users'].'</td>
						<td>'.$valor['rate-limit'].'</td>
						<td>'.$linea.'</td>
						<td>
							<a style="text-decoration:underline;cursor:pointer;" onclick="deleteInfo(\''.$id.'\',\'eliminaPerfilRouter.php\')">Del</a>
						</td>
					</tr>';
			}
?>
    </tbody>
  </table>
  <input type="hidden" name="action" value="profileDel"/>
 </form>
</div>