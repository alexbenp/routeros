<?php 
include("control.php");
include("principal.php");
//require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/Routers.php');
$action=$_REQUEST['action']; 

$ipRB="192.168.56.2"; //IP de tu RB.
$Username="admin"; //Nombre de usuario con privilegios para acceder al RB
$clave=""; //Clave del usuario con privilegios
$api_puerto=8728; //Puerto que definimos el API en IP--->Services
$attempts = 3; // Connection attempt count
$delay = 3; // Delay between connection attempts in seconds
$timeout = 3; // Connection attempt timeout and data read timeout


$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);

if ($action=="")
{
?> 
	<form class="contacto" id="contact_form" action="#" method="POST" enctype="multipart/form-data"> 
		<div>
			<label> Pagina de prueba de creacion de Usuarios <label><br />
		</div>
		<div>
			<label for="name">Usuario:</label>
			<input id="name" class="input" name="name" type="text" value="" size="15" /> 
			<label for="password">Contraseña:</label> 
			<input id="password" class="input" name="password" type="text" value="" size="15" />
		</div> 
		
		<div>
			<label for="uptime">Tiempo Navegacion</label>
			<input id="uptime" class="input" name="uptime" type="text" value="01:00:00" size="6" />
			<label for="user_shared"> Dispositivos a compartir:</label>
			<input id="user_shared" class="input" name="user_shared" type="text" value="1" size="1" /><br /><br />
		</div>
		<div>
			<label for="rx"> BW RX (kbps):</label>
			<input id="rx" class="input" name="rx" type="text" value="512" size="10" />
			<label for="tx"> BW TX (kbps):</label>
			<input id="tx" class="input" name="tx" type="text" value="512" size="10" /><br /><br />
		</div>


		<div class="row"> 
			<label for="comentario">Comentario</label><br /> 
			<textarea id="comentario" class="input" name="comentario" rows="3" cols="30"></textarea><br /><br />
		</div>
	<br>
		<input type="hidden" name="action" value="submit"/>
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
<?php 
}else{ 

	$name		=$_REQUEST['name']; 
	$password	=$_REQUEST['password']; 
	$uptime		=$_REQUEST['uptime'];
	$user_shared=$_REQUEST['user_shared'];
	$comentario	=$_REQUEST['comentario'];
	$rx			=$_REQUEST['rx']; 
	$tx			=$_REQUEST['tx'];
	if (($name=="")||($password=="")||($user_shared=="")) 
	{
		echo "Todos los campos son obligatorios, por favor completa <a href=\"\">el formulario</a> nuevamente.";
	}else{
		$info = $ROUTERS->ipHotspotUserProfileAdd($user_shared,$rx,$tx);

		// fin de crear perfil de usuario
		$crea_usuario = $ROUTERS->ipHotspotUserAdd($name,$password,$uptime,$comentario,$user_shared,$rx,$tx);
		if($ROUTERS->getCodigoRespuesta() =='00'){
			echo " ¡Usuario Creado! ".$name." Desea crear otro usuario haga click <a href=\"\">aquí</a>"; 	
		}else{
			echo $ROUTERS->mensajeRespuesta();
		}
	} 
}   
?>
