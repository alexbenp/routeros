<?php 
include("control.php");
include("principal.php");
require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
//error_reporting(E_ALL ^ E_NOTICE);
$action=$_REQUEST['action']; 
//api mikoritk con

$ipRB="192.168.56.2"; //IP de tu RB.
$Username="admin"; //Nombre de usuario con privilegios para acceder al RB
$clave=""; //Clave del usuario con privilegios
$api_puerto=8728; //Puerto que definimos el API en IP--->Services
$attempts = 3; // Connection attempt count
$delay = 3; // Delay between connection attempts in seconds
$timeout = 3; // Connection attempt timeout and data read timeout

$API = new routeros_api(); //Creamos un objeto de la clase API
$API->debug = false; //Desactivamos el debug


//-----------------------------------


if ($action=="")    /* display the contact form */ 
    { 
?> 
    <form class="contacto" id="contact_form" action="#" method="POST" enctype="multipart/form-data"> 
        
	<div class="row">
	    <label for="title1">Pagina de prueba de Borrado de Usuarios<label><br /><br />
	</div>
	
	<div class="row"> 
            	<label for="idborrado">Ingrese ID usuario a Borrar:</label>
            	<input id="idborrado" class="input" name="idborrado" type="text" value="" size="2" /> 
	</div> 

<?php 
         if ($API->connect($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout)) {
		$ARRAY = $API->comm("/system/resource/print");
		$first = $ARRAY['0'];
		$memperc = ($first['free-memory']/$first['total-memory']);
		$hddperc = ($first['free-hdd-space']/$first['total-hdd-space']);
		$mem = ($memperc*100);
		$hdd = ($hddperc*100);
		echo "Mikrotik RouterOs 4.16 Resources";
		//echo "<br />";
		echo "<table width=550 border=1 align=center>";

		echo "<tr><td>Platform, board name and Ros version is:</td><td>" . $first['platform'] . " - " . $first['board-name'] . " - "  . $first['version'] . " - " . $first['architecture-name'] . "</td></tr><br />";
		echo "<tr><td>Cpu and available cores:</td><td>" . $first['cpu'] . " at " . $first['cpu-frequency'] . " Mhz with " . $first['cpu-count'] . " core(s) "  . "</td></tr><br />";
		echo "<tr><td>Uptime is:</td><td>" . $first['uptime'] . " (hh/mm/ss)" . "</td></tr><br />";
		echo "<tr><td>Cpu Load is:</td><td>" . $first['cpu-load'] . " %" . "</td></tr><br />";
		echo "<tr><td>Total,free memory and memory % is:</td><td>" . $first['total-memory'] . "Kb - " . $first['free-memory'] . "Kb - " . number_format($mem,3) . "% </td></tr><br />";
		echo "<tr><td>Total,free disk and disk % is:</td><td>" . $first['total-hdd-space'] . "Kb - " . $first['free-hdd-space'] . "Kb - " . number_format($hdd,3) . "% </td></tr><br />";
		echo "<tr><td>Sectors (write,since reboot,bad blocks):</td><td>" . $first['write-sect-total'] . " - " . $first['write-sect-since-reboot'] . " - " . $first['bad-blocks'] . "% </td></tr><br />";

		echo "</table>";

		echo "<br />";
		echo "<br />";
		echo "<br />";
		echo "<br />";

	   $API->disconnect();
	}
?>
        <input type="hidden" name="action" value="submit"/>
        <input id="submit_button" type="submit" value="Borrar Usuario" />

        <input id="submit_button1" type="reset" value="Limpiar" />
	
<?php		
		// ESTA PARTE SAQUE LA INFORMACION DE LOS USUARIO
		if ($API->connect($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout)) {
                $API->write('/ip/hotspot/user/getall');
                $READ = $API->read(false);
                $ARRAY = $API->parse_response($READ);
		// echo "<pre>";
		// print_r($ARRAY);
		// echo "</pre>";		
 		echo "<br /><br /> Usuarios creados a la fecha <br /><br />";
		foreach ($ARRAY as $i => $value) {
		$valor=$ARRAY[$i];
		echo "<tr><td> ".$valor['.id']." ".$valor['name']." tiempo actual:".$valor['uptime']."</td></tr><br />";
		}
                $API->disconnect();

}
?>


<?php
                // ESTA PARTE SAQUE LA INFORMACION DE LOS USUARIO
                if ($API->connect($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout)) {
                $API->write('/ip/hotspot/user/profile/getall');
                $READ = $API->read(false);
                $ARRAY = $API->parse_response($READ);
                echo "<br /><br /> Perfiles de Usuarios creados a la fecha <br /><br />";
                foreach ($ARRAY as $i => $value) {
                $valor=$ARRAY[$i];
                echo "<tr><td> ".$valor['.id']." ".$valor['name']." Dispositivos:  ".$valor['shared-users']." Rate: ".$valor['rate-limit']."</td></tr><br />";
                }
                $API->disconnect();

}
?>


<?php
                $API->debug = false;
                if ($API->connect($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout)) {
                $API->write('/ip/hotspot/user/profile/getall');
                $READ = $API->read(false);
                $ARRAY = $API->parse_response($READ);
				echo "Respuesta: ";
		// echo "<pre>";
		// print_r($ARRAY);
		// echo "</pre>";		
                $API->disconnect();
}


?>




<?php
		$API->debug = false;
	        if ($API->connect($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout)) {
		$API->write('/ip/hotspot/user/getall');
   		$READ = $API->read(false);
		$ARRAY = $API->parse_response($READ);
echo "Respuesta.:";
 // print_r($ARRAY);

		$API->disconnect();
}


?>

    </form> 
<?php 
    } 
else    /* send the submitted data */ 
    { 
    $idborrado=$_REQUEST['idborrado'];
    $name=$_REQUEST['name']; 
    $password=$_REQUEST['password']; 
    $uptime=$_REQUEST['uptime'];
    $user_shared=$_REQUEST['user_shared'];
    $comentario=$_REQUEST['comentario'];
    $rx=$_REQUEST['rx']; 
    $tx=$_REQUEST['tx'];
    if (($idborrado=="")) 
        { 
        echo "Todos los campos son obligatorios, por favor completa <a href=\"\">el formulario</a> nuevamente.";
        } 
    else{         
        //$from="From: $name<$email>\r\nReturn-path: $email"; 
        //$subject="Mensaje enviado usando tu formulario de contacto"; 
        //mail("youremail@yoursite.com", $subject, $message, $from); 
        
	// Se creara perfil de usuario
//	if ($API->connect($ipRB , $Username , $clave, $api_puerto)) 
//	{
//	
//	$API->comm("/ip/hotspot/user/remove",array("id" => $idborrado)); //Enviamos el comando y el true que significa enter
//	echo "Usuario con el ID ".$idborrado." fue borrado";
//	$API->disconnect();
//	}
//	else
//	{

//		echo 'No se puede conectar al Routerboard con IP:'.$ipRB.' con el usuario '.$Username.' Clave: '.$clave.' en el puerto: '.$api_puerto;
 //       }

	// fin de crear perfil de usuario

	// Se crea Usuario
	if ($API->connect($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout)) 
	{
		$API->write('/ip/hotspot/user/remove', false); //Enviamos el comando y el true que significa enter
		$API->write('=.id='.$idborrado);
		$READ = $API->read(false);
                $ARRAY = $API->parse_response($READ);
                //print_r($ARRAY);

//		$API->write("=.id=".$idborrado);
	$API->disconnect();
	}
	else
	{
	echo 'No se puede conectar al Routerboard con IP:'.$ipRB.' con el usuario '.$Username.' Clave: '.$clave.' en el puerto: '.$api_puerto;
	}


	echo " ¡Usuario Borrado! ".$idborrado." Desea eliminar otro usuario haga click <a href=\"\">aquí</a>"; 
        } 
    }   
?>
