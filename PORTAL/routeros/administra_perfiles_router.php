<?php 
include("control.php");
include("principal.php");
require_once ('clases/Routers.php');

$ipRB			= $_SESSION["ip"]; //IP de tu RB.
$Username		= $_SESSION["usuario"]; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION["clave"]; //Clave del usuario con privilegios
$api_puerto		= $_SESSION["puerto"]; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION["reintentos_conexion"]; // Connection attempt count
$delay 			= $_SESSION["retraso_conexion"]; // Delay between connection attempts in seconds
$timeout 		= $_SESSION["tiempo_maximo_conexion"]; // Connection attempt timeout and data read timeout

$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);

$info = $ROUTERS->ipHotspotUserProfileGetall();
// echo "<pre>";
// print_r($info);
// echo "</pre>";
?>
<div class="container">
  <div class="">
    <h1>Lista de Perfiles</h1>
  </div>
  <table class="table" id="tabla">
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
				echo "ada".$id;
				echo '<tr id="fila_'.$id.'">
						<td>'.$valor['.id'].'</td>
						<td>'.$valor['name'].'</td>
						<td>'.$valor['shared-users'].'</td>
						<td>'.$valor['rate-limit'].'</td>
						<td>'.$valor['mac-cookie-timeout'].'</td>
						<td><a onclick="eliminar('.$id.')">Eliminar</a></td>
					</tr>';
			}
?>
    </tbody>
  </table>
  
  
	<form id="formulario3" action="" method="post">
	  <table class="table2" id="tablaReg">
		<thead>
		  <tr>
			<th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Perfil</th>
			<th>Dispositivos</th>
			<th>Vigencia</th>
			<th>Velocidad RX</th>
			<th>Velocidad TX</th>
			<th>&nbsp </th>
		  </tr>
		</thead>
		<tbody>
		<tr>
			<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
			<td><input id="profile_name" type="text" name="profile_name" size="15"></td>
			<td><input id="user_shared" type="text" name="user_shared" size="3"></td>
			<td><input id="mac_uptime" type="text" name="mac_uptime" size="10"></td>
			<td><input id="rx" type="text" name="rx"  value="512" size="4"></td>
			<td><input id="tx" type="text" name="tx"  value="512" size="4"></td>
			<td><input type="submit" value="Agregar"></td>
		</tr>
		</tbody>
	  </table>
	</form>	
</div>

<div>
<br>
<br><br><br><br>
