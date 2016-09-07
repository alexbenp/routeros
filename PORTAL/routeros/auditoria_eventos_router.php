<?php 
include("control.php");
require_once("principal.php");
// require_once ('clases/Routers.php');
require_once ('clases/AuditoriaSysLog.php');

$AuditoriaSysLog = new AuditoriaSysLog();

$fechaInicio 		= '2016-09-06 20:00:00';
$fechaFinal			= '2016-09-06 23:59:59';
$getSystemEvents 	= $AuditoriaSysLog->getSystemEvents($fechaInicio,$fechaFinal);
// echo "<pre>";
// print_r($getSystemEvents);
// echo "</pre>";	

?>
<div class="container">
  <div class="">
    <h3 class="text-center text-success">Auditoria RouterOS<h3>
  </div>
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
?>
  </table>
  <input type="hidden" name="action" value="userDel"/>
 </form>



</div>
