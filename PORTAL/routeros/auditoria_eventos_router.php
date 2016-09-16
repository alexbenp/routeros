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
	<?php echo $_SESSION['nombreRouter'].' IP: '.$_SESSION['ipRouter'].' Versión: '.$_SESSION['versionRouter'];
	?>
	</h5>
  </div>

<form id="auditoria" action="#" method="POST">
	<div class="form-group has-success">
		<div class="col-lg-12">
			<table class="table table-hover" id="tabla">
			<div class="container">
				<div class="form-group">
					<tr>
						<th>Fecha Inicial</th>
						<th>Fecha Final</th>
						<th>Usuario</th>
						<th></th>
					</tr>
				</div>
			</div>
					<tr>
						<th>
							<input type="text" name="fechaInicial" value="" id="fechaInicial" class="fechaInicial" placeholder=" Fecha Inicial"/>
						</th>
						<th>
							<input type="text" name="fechaFinal" value="" id="fechaFinal" class="fechaInicial" placeholder=" Fecha Final"/>
						</th>
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

<script>
$.datetimepicker.setLocale('es');
$('.fechaInicial').datetimepicker({
});
$('.fechaFinal').datetimepicker({
});
</script>

<form id="auditoria" action="#" method="post">
  <table class="table table-hover" id="tabla">
	<div class="container">
		<div class="form-group">
		  <tr>
			<th class="success">Id</th>
			<th class="success">Equipo</th>
			<th class="success">Fecha</th>
			<th class="success">Usuario</th>
			<th class="success">IP/MAC</th>
			<th class="success">Mensaje</th>
		  </tr>
		</div>
	</div>
<?php 

if($action =="1" ){
	

	$AuditoriaSysLog = new AuditoriaSysLog();
	
	
	
if(!empty($usuario)){
	if(!empty($fechaInicial) and !empty($fechaFinal)){
		$getSystemEvents 	= $AuditoriaSysLog->getHotspotUserDateEvents($usuario,$fechaInicial,$fechaFinal);
	}else{
		$getSystemEvents 	= $AuditoriaSysLog->getHotspotUserEvents($usuario);
	}
}else{
	if (empty($fechaInicial)){
		echo '<h4 class="text-center">Debe Seleccionar Fecha Inicial</h4>';
	}elseif(empty($fechaFinal)){
		echo '<h4 class="text-center">Debe Seleccionar Fecha Final</h4>';
	}else{
		$getSystemEvents 	= $AuditoriaSysLog->getHotspotDateEvents($fechaInicial,$fechaFinal,$usuario);
	}
}


?>	

<?php
if(is_array($getSystemEvents)){
	foreach ($getSystemEvents as $i => $value) {
		$id    		= hexdec($getSystemEvents[$i]['ID']);
		$FromHost	= $getSystemEvents[$i]['FromHost'];
		$ReceivedAt	= $getSystemEvents[$i]['ReceivedAt'];
		$Message	= $getSystemEvents[$i]['Message'];
		$Mensaje	= $getSystemEvents[$i]['Mensaje'];
		$IpMac		= $getSystemEvents[$i]['IpMac'];
		$user		= $getSystemEvents[$i]['Usuario'];

		echo 
		'<tr>
			<td class="text-info">'.$id.'</td>
			<td class="text-info">'.$FromHost.'</td>
			<td class="text-info">'.$ReceivedAt.'</td>
			<td class="text-info">'.$user.'</td>
			<td class="text-info">'.$IpMac.'</td>
			<td class="text-info">'.$Mensaje.'</td>

			
		</tr>';
	}
}

?>
  </table>
</div>
<?php
}


