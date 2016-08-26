<?php 
include("control.php");
require_once("principal.php");
//require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/RouterDb.php');
$router=$_REQUEST['router']; 
$estados_router_id = 1;


// $ROUTERS = new Routers();
// $AdminRouters = $ROUTERS->getInformacionAdminRouter($estados_router_id);

$ADMROUTERS = new RoutersDb($router);
$AdminRouters = $ADMROUTERS->getParametrosRouter($estados_router_id);

echo "<pre>";
print_r($AdminRouters);
echo "</pre>";
echo "kjhkjh".$router;
$_SESSION["ip"] 	= $AdminRouters[0]['ip'];
$_SESSION["usuario"] 	= $AdminRouters[0]['usuario'];
$_SESSION["clave"] 	=   ""; //$AdminRouters[0]['usuario'];
$_SESSION["puerto"] 	= $AdminRouters[0]['puerto'];
$_SESSION["reintentos_conexion"] 	= $AdminRouters[0]['reintentos_conexion'];
$_SESSION["retraso_conexion"] 	= $AdminRouters[0]['retraso_conexion'];
$_SESSION["tiempo_maximo_conexion"] 	= $AdminRouters[0]['tiempo_maximo_conexion'];
?>
	<form class="contacto" id="configura_router" action="#" method="POST" enctype="multipart/form-data"> 
	
		<div>
			<label> Seleccion de Routers Para Administrar <label><br />
		</div>
		
		<table border=1>
			<tr>
				<td><label>Usar</label></td>
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
			echo "<td>	<input id=\"submit_button\" type=\"submit\" value=\"A\" />
						<input name=\"router\" type=\"hidden\" value=\"".$idRouter."\" />
				  </td>";
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
