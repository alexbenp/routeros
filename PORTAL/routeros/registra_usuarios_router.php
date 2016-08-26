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

if ($action=="userAdd")
{
	
	$name		=$_REQUEST['name']; 
	$password	=$_REQUEST['password']; 
	$uptime		=$_REQUEST['uptime'];
	$user_shared=$_REQUEST['user_shared'];
	$comentario	=$_REQUEST['comentario'];
	$rx			=$_REQUEST['rx']; 
	$tx			=$_REQUEST['tx'];

	$profile_name	=$_REQUEST['profile_name']; 
	$mac_uptime		=$_REQUEST['value_mac_uptime'].$_REQUEST['unid_mac_uptime'];

	
	if(empty($mac_uptime) ){
		$add_mac_cookie = "no";
	}else{
		$add_mac_cookie = "yes";
	}
		
	


	
	if (($name=="")||($password=="")||($user_shared=="")) 
	{
		echo "Todos los campos son obligatorios, por favor completa <a href=\"\">el formulario</a> nuevamente.";
	}else{
		$profileAdd = $ROUTERS->ipHotspotUserProfileAdd($profile_name,$user_shared,$rx,$tx,$add_mac_cookie,$mac_uptime);
		$mensajeRespuestaProfileAdd = $ROUTERS->getMensajeRespuesta();
		$codigoRespuestaProfileAdd = $ROUTERS->getCodigoRespuesta();
		
		// fin de crear perfil de usuario
		$userAdd = $ROUTERS->ipHotspotUserAdd($name,$password,$uptime,$comentario,$profile_name);
		$mensajeRespuestaUserAdd = $ROUTERS->getMensajeRespuesta();
		$codigoRespuestaUserAdd = $ROUTERS->getCodigoRespuesta();

	} 
}
?> 
	<form class="contacto" id="contact_form" action="#" method="POST" enctype="multipart/form-data"> 
		<div>
			<label>
<?php 		
		if($mensajeRespuestaProfileAdd!=''){
			echo $codigoRespuestaProfileAdd."::".$mensajeRespuestaProfileAdd."<br><br>";
		}
		if($mensajeRespuestaUserAdd!=''){
			echo $codigoRespuestaUserAdd."::".$mensajeRespuestaUserAdd."<br><br>";
		}
?>
			</label>
		
		<div>
			<label> Creación de usuarios para RouterOS <label><br />
		</div>
		<div>
			<label for="name">Usuario:</label>
			<input id="name" class="input" name="name" type="text" value="" size="15" /> 
			<label for="password">Contraseña:</label> 
			<input id="password" class="input" name="password" type="text" value="" size="15" />
		</div> 
		
		<div>
			<label for="profile_name">Nombre del Perfil</label>
			<input id="profile_name" class="input" name="profile_name" type="text" value="" size="50" />
			 <label for="uptime">Tiempo Navegacion</label>
            <input id="uptime" class="input" name="uptime" type="text" value="01:00:00" size="6" />
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


		<div class="row"> 
			<label for="comentario">Comentario</label><br /> 
			<textarea id="comentario" class="input" name="comentario" rows="3" cols="30"></textarea><br /><br />
		</div>
	<br>
		<input type="hidden" name="action" value="userAdd"/>
		<input id="submit_button" type="submit" value="Crear Usuario" />

		<input id="submit_button1" type="reset" value="Limpiar" />
<?php 
	$first = $ROUTERS->systemResourcePrint();

	echo "<div><label>Mikrotik RouterOs 4.16 Resources</label></div>";
	echo "<table width=500 border=0 align=center>";
	echo "<tr><td>Platform, board name and Ros version is:</td><td>" . $first['platform'] . " - " . $first['board-name'] . " - "  . $first['version'] . " - " . $first['architecture-name'] . "</td></tr>";
	echo "<tr><td>Cpu and available cores:</td><td>" . $first['cpu'] . " at " . $first['cpu-frequency'] . " Mhz with " . $first['cpu-count'] . " core(s) "  . "</td></tr>";
	echo "<tr><td>Uptime is:</td><td>" . $first['uptime'] . " (hh/mm/ss)" . "</td></tr><br />";
	echo "<tr><td>Cpu Load is:</td><td>" . $first['cpu-load'] . " %" . "</td></tr><br />";
	echo "<tr><td>Total,free memory and memory % is:</td><td>" . $first['total-memory'] . "Kb - " . $first['free-memory'] . "Kb - " . number_format($first['mem'],3) . "% </td></tr>";
	echo "<tr><td>Total,free disk and disk % is:</td><td>" . $first['total-hdd-space'] . "Kb - " . $first['free-hdd-space'] . "Kb - " . number_format($first['hdd'],3) . "% </td></tr>";
	echo "<tr><td>Sectors (write,since reboot,bad blocks):</td><td>" . $first['write-sect-total'] . " - " . $first['write-sect-since-reboot'] . " - " . $first['bad-blocks'] . "% </td></tr>";
	echo "</table>";

	$info = $ROUTERS->ipHotspotUserGetall();

	echo "<br><div><label> Usuarios creados a la fecha</label></div> ";
	echo "<table>";
	foreach ($info as $i => $value) {
		$valor=$info[$i];
		echo "<tr><td> ".$valor['.id']." ".$valor['name']." tiempo actual:".$valor['uptime']."</td></tr>";
	}
	echo "</table>";
	echo "<table>";
	$info = $ROUTERS->ipHotspotUserProfileGetall();
	echo "<br /><br /><div><label> Perfiles de Usuarios creados a la fecha</label></div>";
	foreach ($info as $i => $value) {
		$valor=$info[$i];
		echo "<tr><td> ".$valor['.id']." ".$valor['name']." Dispositivos:  ".$valor['shared-users']." Rate: ".$valor['rate-limit']."</td></tr>";
	}
	echo "</table>";	
?>
    </form> 
