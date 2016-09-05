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

$info = $ROUTERS->ipHotspotUserProfileGetall();

?>

 		<div id="resultado">
			<label>
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
					</tr>';
			}
?>
    </tbody>
  </table>
 </form>
</div>
