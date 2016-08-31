<?php 
include("control.php");
require_once("principal.php");
require_once ('clases/Routers.php');


$ipRB			= $_SESSION["ip"]; //IP de tu RB.
$Username		= $_SESSION["usuario"]; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION["clave"]; //Clave del usuario con privilegios
$api_puerto		= $_SESSION["puerto"]; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION["reintentos_conexion"]; // Connection attempt count
$delay 			= $_SESSION["retraso_conexion"]; // Delay between connection attempts in seconds
$timeout 		= $_SESSION["tiempo_maximo_conexion"]; // Connection attempt timeout and data read timeout

$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);
$historySystemRouter = $ROUTERS->historySystemRouter();
// echo "<pre>";
// print_r($logSystemRouter);
// echo "</pre>";	

?>
<div class="container">
  <div class="">
    <h1>Auditoria RouterOS</h1>
  </div>
<form id="auditoria" action="#" method="post">
  <table class="table table-hover" id="tabla">
    <thead>
      <tr>
        <th>Id</th>
        <th>Acción</th>
        <th>Realizado por</th>
        <th>Politica</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody>
		
		
<?php

	foreach ($historySystemRouter as $i => $value) {
		$id    		= hexdec($historySystemRouter[$i]['.id']);
		$action		= $historySystemRouter[$i]['action'];
		$by			= $historySystemRouter[$i]['by'];
		$policy		= $historySystemRouter[$i]['policy'];
		$time		= $historySystemRouter[$i]['time'];
		$floating_undo	= $historySystemRouter[$i]['floating-undo'];

		echo 
		'<tr>
			<td>'.$id.'</td>
			<td>'.$action.'</td>
			<td>'.$by.'</td>
			<td>'.$policy.'</td>
			<td>'.$time.'</td>
		</tr>';
	}
?>
    </tbody>
  </table>
  <input type="hidden" name="action" value="userDel"/>
 </form>



</div>
