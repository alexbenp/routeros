<?php 
include("control.php");
include("include/config.php");
require_once("principal.php");
// require_once ('clases/Routers.php');
require_once ('clases/AuditoriaSysLog.php');
$action	=	$_REQUEST['action']; 

$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['REQUEST_URI']);
$validaSesion->getPageByName($php_self);





?>

<div class="container">
  <div class="">
    <h3 class="text-center text-success">Auditoria RouterOS<h3>
  </div>

<form id="auditoria" action="#" method="POST">
	<table class="table table-hover" id="tabla">
	
		<tr>
			<th>Fecha Inicial</th>
			<th>Fecha Final</th>
		</tr>
		<tr>
			<th>
				<input type="text" name="fechaInicial" class="fechaInicial" value="" id="fechaInicial"/>
			</th>
			<th>
				<input type="text" name="fechaFinal" class="fechaFinal" value="" id="fechaFinal"/>
				<input class="btn btn-success" id="submit_button" type="submit" value="Buscar" />
			</th>
		</tr>
	</table>	
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
			<th class="success">Mensaje</th>
			<th class="success">Etiqueta Log</th>
		  </tr>
		</div>
	</div>
<?php 
if($action =="1" ){
	
	$fechaInicial = $_POST['fechaInicial'];
	$fechaFinal = $_POST['fechaFinal'];
	$AuditoriaSysLog = new AuditoriaSysLog();

if (empty($fechaInicial)){
	
	echo '<h4 class="text-center">Debe Seleccionar Fecha Inicial</h4>';
}elseif(empty($fechaFinal)){
	echo '<h4 class="text-center">Debe Seleccionar Fecha Final</h4>';
}else{
	$getSystemEvents 	= $AuditoriaSysLog->getSystemEvents($fechaInicial,$fechaFinal);
?>	

<?php
	foreach ($getSystemEvents as $i => $value) {
		$id    		= hexdec($getSystemEvents[$i]['ID']);
		$FromHost	= $getSystemEvents[$i]['FromHost'];
		$ReceivedAt	= $getSystemEvents[$i]['ReceivedAt'];
		$Message	= $getSystemEvents[$i]['Message'];
		$SysLogTag	= $getSystemEvents[$i]['SysLogTag'];

		echo 
		'<tr>
			<td class="text-info">'.$id.'</td>
			<td class="text-info">'.$FromHost.'</td>
			<td class="text-info">'.$ReceivedAt.'</td>
			<td class="text-info">'.$Message.'</td>
			<td class="text-info">'.$SysLogTag.'</td>
			
		</tr>';
	}
}
?>
  </table>
</div>
<?php
}


