<?php 
include_once("control.php");
include_once("include/config.php");
require_once ('clases/Routers.php');

$imprimeMenu 	= 1;
$action			= $_REQUEST['action']; 

if($action=="sfindUser"){
	$imprimeMenu = 0;
}

if($imprimeMenu == 1){
	require_once("principal.php");	
}

$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['REQUEST_URI']);
$validaSesion->getPageByName($php_self);




$ipRB			= $_SESSION['ip']; //IP de tu RB.
$Username		= $_SESSION['usuario']; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION['clave']; //Clave del usuario con privilegios
$api_puerto		= $_SESSION['puerto']; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION['reintentos_conexion']; // Connection attempt count
$delay 			= $_SESSION['retraso_conexion']; // Delay between connection attempts in seconds
$timeout 		= $_SESSION['tiempo_maximo_conexion']; // Connection attempt timeout and data read timeout


$usuario 		= $_POST['name'];
$perfil 		= $_POST['profile'];
$estado 		= $_POST['estado'];


$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);


?> 
<div class="container">
  <div class="">
    <h3 class="text-center text-success">Usuarios RouterOS<h3>
  </div>
<form id="Usuarios" action="#" method="post">
	<div class="form-group has-success">
		<label for="inputSuccess" class="col-lg-12 control-label">Usuario </label>
		<div class="col-lg-4">
			<input type="text" name="name" id="name" class="form-control" value=""  placeholder=" DIGITE USUARIO" />
			<input type="submit" class="btn btn-success" value="Buscar">
		</div>
		
		<input type="hidden" name="action" value="findUser"/>
	</div>
 </form>
<?php
if($action=="findUser"){
	$info = $ROUTERS->ipHotspotUserPrint($usuario,$estado,$perfil);
	$mensajeRespuestaUserPrint = $ROUTERS->getMensajeRespuesta();
	$codigoRespuestaUserPrint = $ROUTERS->getCodigoRespuesta();
	
	if($mensajeRespuestaUserPrint!=''){
		echo $codigoRespuestaUserPrint."::".$mensajeRespuestaUserPrint."<br><br>";
	}

 ?> 
  <table class="table table-hover" id="tabla">
	<div class="container">
		<div class="form-group">
			<tr>
				<th class="success"><label>Id</label></th>
				<th class="success"><label>Nombre</label></th>
				<th class="success"><label>Tiempo Uso</label></th>
				<th class="success"><label>Profile</label></th>
				<th class="success"><label>Tiempo Limite</label></th>
				<th class="success"><label>Estado</label></th>
				<th class="success"><label>Direccion IP</label></th>
				<th class="success"><label>Mac</label></th>

			</tr>
		</div>
	</div>

<?php


	if(is_array($info)){

		foreach ($info as $i => $value) {
			$valor=$info[$i];
			$tiempo = $valor['uptime'];
			$tiempouso  = $ROUTERS->formateaUnidades($tiempo);
			
			$limite = $valor['limit-uptime'];
			$tiempoLimite  = $ROUTERS->formateaUnidades($limite);
			
			echo 
			'<tr id="tr'.$id.'">
				<td class="text-info">'.hexdec($valor['.id']).'</td>
				<td class="text-info">'.$valor['name'].'</td>
				<td class="text-info">'.$tiempouso.'</td>
				<td class="text-info">'.$valor['profile'].'</td>
				<td class="text-info">'.$tiempoLimite.'</td>
				<td class="text-info">'.$valor['disabled'].'</td>
				<td class="text-info">'.$valor['address'].'</td>
				<td class="text-info">'.$valor['mac-address'].'</td>
			</tr>';
		}
	}
?>
    </tbody>
  </table>
</div>


<?php
}
