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

// echo "<pre>";
// print_r($_REQUEST);
// echo "</pre>";

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
				// echo "ada".$id;
				echo '<tr id="fila_'.$id.'">
						<td>'.$id.'</td>
						<td>'.$valor['name'].'</td>
						<td>'.$valor['shared-users'].'</td>
						<td>'.$valor['rate-limit'].'</td>
						<td>'.$valor['mac-cookie-timeout'].'</td>
						<td>
						<input id="submit_button" class="btn btn-primary" type="submit" value="Del" />
						<input name="profile" type="hidden" value="'.$id.'" />
						</td>
					</tr>';
			}
?>
    </tbody>
  </table>
  <input type="hidden" name="action" value="profileDel"/>
 </form>
 
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
	  <table class="table2" id="tablaReg">
		<thead>
		  <tr>
			<th width=10></th>
			<th width=50>Perfil</th>
			<th width=200>Dispositivos</th>
			<th width=100 colspan=2>Vigencia</th>
			<th width=200>Velocidad RX</th>
			<th>Velocidad TX</th>
			<th>&nbsp </th>
		  </tr>
		</thead>
		<tbody>
		<tr>
			<td></td>
			<td><input id="profile_name" type="text" name="profile_name" size="10"></td>
			<td> <!--<input id="user_shared" type="text" name="user_shared" size="20"> -->
				<select id="user_shared" name="user_shared" class="form-control">
				  <option>1</option>
				  <option>2</option>
				</select>
				</td>
			<td><input id="value_mac_uptime" type="text" name="value_mac_uptime" size="2"></td>
			<td><select id="unid_mac_uptime" name="unid_mac_uptime" class="form-control">
				  <option value="d">Dias</option>
				  <option value="h">Horas</option>
				  <option value="w">Semanas</option>
				  <option value="m">Minutos</option>
				  <option value="s">Segundos</option>
				</select>
			</td>
			<td><input id="rx" type="text" name="rx"  value="512" size="4"></td>
			<td><input id="tx" type="text" name="tx"  value="512" size="4"></td>
			<td><input type="submit" class="btn btn-primary" value="Agregar">
				<input type="hidden" name="action" value="profileAdd"/>
			</td>
		</tr>
		</tbody>
	  </table>
	</form>	
</div>
