<?php 
include("control.php");
include("principal.php");
//require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/Routers.php');
$action=$_REQUEST['action']; 
$profile=$_REQUEST['profile']; 

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
	
	$profileRemove = $ROUTERS->ipHotspotUserProfileRemove($profile);
	$mensajeRespuestaProfileRemove = $ROUTERS->getMensajeRespuesta();
	$codigoRespuestaProfileRemove = $ROUTERS->getCodigoRespuesta();
}


	$info = $ROUTERS->ipHotspotUserProfileGetall();
	unset($action);
?> 
	<form class="contacto" id="profile_form" action="#" method="POST" enctype="multipart/form-data"> 
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
		<div><label> Lista de Perfiles</label></div>
		<input type="hidden" name="action" value="profileDel"/>
		<table border = 0>
			<tr><td>Eliminar</td><td>IdPerfil</td><td>Perfil</td><td>Dispositivos</td><td>Velocidad</td><td>Vigencia</td></tr>
<?php 
			foreach ($info as $i => $value) {
				$valor=$info[$i];
				echo "<tr>
						<td>
							<input id=\"submit_button\" type=\"submit\" value=\"Del\" />
							<input name=\"profile\" type=\"hidden\" value=\"".$valor['.id']."\" />
							
						</td>
						<td>".$valor['.id']."</td>
						<td>".$valor['name']."</td>
						<td>".$valor['shared-users']." </td>
						<td>".$valor['rate-limit']." </td>
						<td>".$valor['mac-cookie-timeout']."</td>
					</tr>";
			}
?>			
		</table>
	</form>
	
	<form class="contacto" id="contact_form" action="#" method="POST" enctype="multipart/form-data"> 
		<div>
			<label> Configuración de Perfiles de Usuarios <label><br />
		</div>
		<div>
			<label for="profile_name">Nombre del Perfil</label>
			<input id="profile_name" class="input" name="profile_name" type="text" value="" size="50" />
			<label for="user_shared"> Dispositivos a compartir:</label>
			<input id="user_shared" class="input" name="user_shared" type="text" value="" size="1" />
		</div>	
		<div>
			<label for="mac_uptime">Vigencia </label>
			<input id="value_mac_uptime" name="value_mac_uptime" type="text" value="" size="10" />
			<input id="unid_mac_uptime" name="unid_mac_uptime" type="text" value="" size="1" />
		</div>
		<div>
			<label for="uptime">Velocidad de Navegacion</label>
			<label for="rx"> BW RX (kbps):</label>
			<input id="rx" class="input" name="rx" type="text" value="" size="10" />
			<label for="tx"> BW TX (kbps):</label>
			<input id="tx" class="input" name="tx" type="text" value="" size="10" /><br />
		</div>
	<br>
		<input type="hidden" name="action" value="profileAdd"/>
		<input id="submit_button" type="submit" value="Crear Pefil" />

		<input id="submit_button1" type="reset" value="Limpiar" />
	</form> 
<?php



