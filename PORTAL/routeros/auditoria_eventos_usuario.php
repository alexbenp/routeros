<?php 
include("control.php");
include("include/config.php");
include("principal.php");
// require_once ('clases/Routers.php');
require_once ('clases/AuditoriaSysLog.php');
$action	=	$_REQUEST['action']; 

$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['PHP_SELF']);
$validaSesion->getPageByName($php_self);

$fechaInicial 	= $_POST['fechaInicial'];
$fechaFinal 	= $_POST['fechaFinal'];
$usuario 		= $_POST['name'];
$perfil 		= $_POST['profile'];
$estado 		= $_POST['estado'];


?>

<div class="container">
  <div class="">
    <h3 class="text-center text-success">Auditoria RouterOS</h3>
	<h5 class="text-center text-success">
	<?php 
		echo $_SESSION['nombreRouter'].' IP: '.$_SESSION['ipRouter'].' Versión: '.$_SESSION['versionRouter'];
	?>
	</h5>
  </div>

<form id="auditoria" action="#" method="POST">
	<div class="form-group has-success">
		<div class="col-lg-6">
			<table class="table table-hover" id="tabla">
			<div class="container">
				<div class="form-group">
					<tr>
						<th>Usuario</th>
						<th></th>
					</tr>
				</div>
			</div>
					<tr>
						<th>
							<input type="text" name="name" id="name" class="form-control" value="" placeholder=" Digite Usuario" />
						</th>
						<th>
							<input class="btn btn-success" id="submit_button" type="submit" value="Buscar" />
						</th>
					</tr>
				
			</table>	
		</div>
	</div>
	<input type="hidden" name="action" value="1"/>
	
</form>
<form id="auditoria" action="#" method="post">
	
  <table class="table table-hover" id="tabla">
	<div class="container">
		<div class="form-group">
		  <tr>
			<th class="success">Fecha LogIn</th>
			<th class="success">Usuario</th>
			<th class="success">Mac</th>
			<th class="success">Ip</th>
			<th class="success">Perfil</th>
			<th class="success">Velocidad</th>
			<th class="success">Fecha LogOut</th>
			<th class="success">Motivo</th>
		  </tr>
		</div>
	</div>
<?php 

if($action =="1" ){
	

	$AuditoriaSysLog = new AuditoriaSysLog();
	
	
	
if(empty($usuario)){
	echo '<h4 class="text-center">Debe Digital un usuario</h4>';
}else{
	$getSystemEvents 	= $AuditoriaSysLog->getHotspotUserEvents($usuario);
	
}


?>	

<?php

if(is_array($getSystemEvents)){
	$lineas = 0;
	foreach ($getSystemEvents as $i => $value) {
		
		
		$Atributo	= $getSystemEvents[$i]['Atributo'];
		if($Atributo == 'add cookie'){
			$User			= "";
			$FechaLogin		= "";
			$Mac			= "";
			$Ip				= "";
			$UploadDownload	= "";
			$Perfil			= "";
			$FechaLogout	= "";
			$MotivoLogout	= "";
			
			$login = true;

			$User 		= $getSystemEvents[$i]['Usuario'];
			$FechaLogin = $getSystemEvents[$i]['ReceivedAt'];
			$Mac 		= $getSystemEvents[$i]['IpMac'];
			
			$analisis[$lineas]['Atributo'] 		= $Atributo;			
			$analisis[$lineas]['Usuario'] 		= $User;
			$analisis[$lineas]['Mac'] 			= $Mac;
			$analisis[$lineas]['FechaLogin'] 	= $FechaLogin;
			// if(){
				
			// }
			$lineas++;
		}elseif($Atributo == 'adding queue'){
			$Ip 			= $getSystemEvents[$i]['IpMac'];
			$UploadDownload	= $getSystemEvents[$i]['ValorAtributo'];

			$analisis[$lineas]['Atributo'] 		= $Atributo;			
			$analisis[$lineas]['Ip'] 			= $Ip;
			$analisis[$lineas]['Velocidad'] 	= $UploadDownload;		
			
		}elseif($Atributo == 'using profile'){
			$Perfil		= $getSystemEvents[$i]['ValorAtributo'];
			
			$analisis[$lineas]['Atributo'] 		= $Atributo;			
			$analisis[$lineas]['Perfil'] 		= $Perfil;			
		}elseif($Atributo == 'logged out'){
			$FechaLogout 	= $getSystemEvents[$i]['ReceivedAt'];
			$MotivoLogout 	= $getSystemEvents[$i]['ValorAtributo'];
		
			$analisis[$lineas]['Atributo'] 		= $Atributo;			
			$analisis[$lineas]['FechaLogout'] 	= $FechaLogout;
			$analisis[$lineas]['Motivo'] 		= $MotivoLogout;
			$login = false;
		}
	}
	
	foreach($analisis as $i => $value){
		$User = $analisis[$i]['Usuario'];
		$Mac = $analisis[$i]['Mac'];
		$Ip = $analisis[$i]['Ip'];
		$FechaLogin = $analisis[$i]['FechaLogin'];
		$Perfil = $analisis[$i]['Perfil'];
		$UploadDownload = $analisis[$i]['Velocidad'];
		$FechaLogout = $analisis[$i]['FechaLogout'];
		$MotivoLogout = $analisis[$i]['Motivo'];
		
		echo 
		'<tr>
			<td class="text-info">'.$FechaLogin.'</td>
			<td class="text-info">'.$User.'</td>
			<td class="text-info">'.$Mac.'</td>
			<td class="text-info">'.$Ip.'</td>
			<td class="text-info">'.$Perfil.'</td>
			<td class="text-info">'.$UploadDownload.'</td>
			<td class="text-info">'.$FechaLogout.'</td>
			<td class="text-info">'.$MotivoLogout.'</td>
			
		</tr>';	
	}
}

?>
  </table>
</div>
<?php
}


