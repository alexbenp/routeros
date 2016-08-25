<?php 
include("control.php");
include("principal.php");
//require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/Routers.php');

$estados_router_id = 1;


$ROUTERS = new Routers();
$AdminRouters = $ROUTERS->getInformacionAdminRouter($estados_router_id);

//echo "<pre>";
//print_r($AdminRouters);
//echo "</pre>";

?>
	<form class="contacto" id="configura_router" action="#" method="POST" enctype="multipart/form-data"> 
	
		<div>
			<label> Seleccion de Routers Para Administrar <label><br />
		</div>
		
		<table border=1>
			<tr>
				<td><label>IdRouter</label></td>
				<td><label>Nombre</label></td>
				<td><label>IP</label></td>
				<td><label>Puerto</label></td>
				<td><label>Version</label></td>
				<td><label>Usar</label></td>
			</tr>
<?php
		foreach($AdminRouters as $llave=>$elmento){
			$idRouter = $AdminRouters[$llave]['router_id'];
			$nombreRouter = $AdminRouters[$llave]['nombre'];
			$ipRouter = $AdminRouters[$llave]['ip'];
			$puertoRouter = $AdminRouters[$llave]['puerto'];
			$versionRouter = $AdminRouters[$llave]['version'];
			$claveRouter = $AdminRouters[$llave]['clave'];
			$estadoRouter = $AdminRouters[$llave]['estado'];
			$reintentosConexionRouter = $AdminRouters[$llave]['reintentos_conexion'];
			$retrasoConexionRouter = $AdminRouters[$llave]['retraso_conexion'];
			$tiempoMaximoConexionRouter = $AdminRouters[$llave]['tiempo_maximo_conexion'];
			
			echo "<tr>";
			echo "<td><label>".$idRouter."</label></td>";
			echo "<td><label>".$nombreRouter."</label></td>";
			echo "<td><label>".$ipRouter."</label></td>";
			echo "<td><label>".$puertoRouter."</label></td>";
			echo "<td><label>".$versionRouter."</label></td>";
			echo "<td><label>boton</label></td>";
			echo "<tr>";
		}			
?>
		</table>
<?php 

?>
