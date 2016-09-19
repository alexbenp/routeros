<?php 
include("control.php");
include("principal.php");
include("include/config.php");
require_once ('clases/Routers.php');
require_once ('clases/RouterDb.php');

$ADMROUTERS = new RoutersDb();
$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['PHP_SELF']);
$validaSesion->getPageByName($php_self);
$action=$_REQUEST['action']; 
$router_id=$_REQUEST['router_id'];
// $idRouter =$_REQUEST['idRouter'];


		
		
		
// echo "<pre>";
// print_r($_REQUEST);
// echo "</pre>";

$info = $ADMROUTERS->getEstadosRouter();


			// echo "aqui voy <pre>";
			// print_r($AdminRouters);
			// echo "</pre>";
			// exit();
			
if ($action=="routerAdd")
{
	// echo "Proceso registrado Exitosamente";
	$router_id			=$_REQUEST['router_id'];
    $nameRouter			=$_REQUEST['nameRouter'];
	$estados_router_id	=$_REQUEST['estados_router_id'];
    $ipRouter			=$_REQUEST['ipRouter'];
    $puertoRouter		=$_REQUEST['puertoRouter'];
    $versionRouter		=$_REQUEST['versionRouter'];
    $userRouter			=$_REQUEST['userRouter'];
    $claveRouter		=$_REQUEST['claveRouter'];
    $reintentosCx		=$_REQUEST['reintentosCx'];
    $retrasoCx			=$_REQUEST['retrasoCx'];
    $tiempoMaximoCx		=$_REQUEST['tiempoMaximoCx'];

	
	if (($nameRouter=="")||($ipRouter=="")||($userRouter=="")||($claveRouter=="")||($puertoRouter=="")||($versionRouter=="")||($reintentosCx=="")||($retrasoCx=="")||($tiempoMaximoCx=="")) 
	{
		$mensajeRespuestaSetRouter = 'Todos los campos son obligatorios';
		$codigoRespuestaSetRouter  = '99';
	}else{
		


		// fin de crear perfil de usuario
		$userAdd = $ADMROUTERS->setRouter($router_id,$nameRouter,$estados_router_id,$ipRouter,$puertoRouter,$versionRouter,$userRouter,$claveRouter,$reintentosCx,$retrasoCx,$tiempoMaximoCx);
		$mensajeRespuestaSetRouter = $ADMROUTERS->getMensajeRespuesta();
		$codigoRespuestaSetRouter = $ADMROUTERS->getCodigoRespuesta();
	}
	
	if($codigoRespuestaSetRouter !='00'){
		$action = 'getInfoRouter';
	}

}


$AdminRouters = $ADMROUTERS->getAllRouters($router_id);
$getCodigoRespuestaGetAllRouter = $ADMROUTERS->getCodigoRespuesta();
$getMensajeRespuestaGetAllRouter = $ADMROUTERS->getMensajeRespuesta();


?>
	<form class="contacto" id="configura_router" action="#" method="POST" enctype="multipart/form-data"> 
	
		<div>
			<h3 class="text-center text-success">Conectado al Router</h3>
		<h5 class="text-center text-success">
		<?php echo $_SESSION['nombreRouter'].' IP: '.$_SESSION['ipRouter'].' Versión: '.$_SESSION['versionRouter'];
		?>
		</h5>
		</div>
		<div>
		<label>
		
<?php 
		if($getMensajeRespuestaGetAllRouter!='' and $getCodigoRespuestaGetAllRouter!='00'){
			echo $getCodigoRespuestaGetAllRouter."::".$getMensajeRespuestaGetAllRouter."<br><br>";
		}
		if($mensajeRespuestaSetRouter!=''){
			echo $codigoRespuestaSetRouter."::".$mensajeRespuestaSetRouter."<br><br>";
		}
				
?>		
		<label>
		</div>
		<input class="btn btn-success" id="submit_button" onclick="buttonSendForm('');" type="button" value="Volver" />
		<table class="table table-hover">
			<div class="container">
						<div class="form-group">
							<tr>
								<th class="success"><label>IdRouter</label></th>
								<th class="success"><label>Nombre</label></th>
								<th class="success"><label>IP</label></th>
								<th class="success"><label>Puerto</label></th>
								<th class="success"><label>Usuario</label></th>
								<th class="success"><label>Versión</label></th>
								<th class="success"><label>Princial</label></th>
								<th class="success"><label>Usar</label></th>
							</tr>
						</div>
					</div>

<?php
	if(is_array($AdminRouters)){
		foreach($AdminRouters as $llave=>$elmento){
			$idRouter = $AdminRouters[$llave]['router_id'];
			$nombreRouter = $AdminRouters[$llave]['nombreRouter'];
			$ipRouter = $AdminRouters[$llave]['ipRouter'];
			$puertoRouter = $AdminRouters[$llave]['puertoRouter'];
			$usuarioRouter = $AdminRouters[$llave]['usuarioRouter'];
			$versionRouter = $AdminRouters[$llave]['versionRouter'];
			$principalRouter = $AdminRouters[$llave]['principal'];
			// $listClaveRouter = $AdminRouters[$llave]['claveRouter'];
			$estadoRouter = $AdminRouters[$llave]['estadoRouter'];
			$reintentosConexionRouter = $AdminRouters[$llave]['reintentos_conexion'];
			$retrasoConexionRouter = $AdminRouters[$llave]['retraso_conexion'];
			$tiempoMaximoConexionRouter = $AdminRouters[$llave]['tiempo_maximo_conexion'];
			
			echo '<tr id="tr'.$idRouter.'">';
			echo '<td class="text-info"><label>'.$idRouter.'</label></td>';
			echo '<td class="text-info"><label>'.$nombreRouter.'</label></td>';
			echo '<td class="text-info"><label>'.$ipRouter.'</label></td>';
			echo '<td class="text-info"><label>'.$puertoRouter.'</label></td>';
			echo '<td class="text-info"><label>'.$usuarioRouter.'</label></td>';
			echo '<td class="text-info"><label>'.$versionRouter.'</label></td>';
			echo '<td class="text-info"><label>'.$principalRouter.'</label></td>';
				echo '<td class="text-info">	
				<input class="btn btn-success" id="submit_button" onclick="buttonSendForm(\''.$idRouter.'\');" type="button" value="A" />
				  </td>';
			echo '<tr>';
		}	
	}
?>
		</table>
		<input type="hidden" id="action" name="action" value="getInfoRouter"/>
		<input type="hidden" id="router_id" name="router_id" value=""/>

	</form>
<script>
function buttonSendForm(router_id){
	document.getElementById('router_id').value = router_id;
    document.getElementById('configura_router').submit();
}

</script>

<div id="resultado">
<?php 

if($action=="getInfoRouter" and $router_id > 0){

			$llave =0;
			$idRouter = $AdminRouters[$llave]['router_id'];
			$nombreRouter = $AdminRouters[$llave]['nombreRouter'];
			$ipRouter = $AdminRouters[$llave]['ipRouter'];
			$puertoRouter = $AdminRouters[$llave]['puertoRouter'];
			$usuarioRouter = $AdminRouters[$llave]['usuarioRouter'];
			$versionRouter = $AdminRouters[$llave]['versionRouter'];
			$estados_router_id = $AdminRouters[$llave]['estados_router_id'];
			$estadoRouter = $AdminRouters[$llave]['estadoRouter'];
			$reintentosConexionRouter = $AdminRouters[$llave]['reintentos_conexion'];
			$retrasoConexionRouter = $AdminRouters[$llave]['retraso_conexion'];
			$tiempoMaximoConexionRouter = $AdminRouters[$llave]['tiempo_maximo_conexion'];


?> 
	<div class="container">
	  <div class="">
			<h3 class="text-center text-success"> CREACIÓN DE ROUTERS EN BD</h3>
			<h5 class="text-center text-success">
			<?php echo $_SESSION['nombreRouter'].' IP: '.$_SESSION['ipRouter'].' Versión: '.$_SESSION['versionRouter'];
			?>
		</h5>
		<div>
			<label>
	<?php 		
		if($mensajeRespuestaSetRouter!=''){
			echo $codigoRespuestaSetRouter."::".$mensajeRespuestaSetRouter."<br><br>";
		}

	?>
			</label>
		</div>
		

		<form class="contacto" id="addRouters" action="#" method="POST" enctype="multipart/form-data"> 
			<div class="form-group has-success">
				<input type="hidden" name="router_id" value="<?php echo $idRouter; ?>"/>
				<label for="inputSuccess" class="col-lg-12 control-label">Nombre Router </label>
				<div class="col-lg-4">
					<input type="text" name="nameRouter" id="nameRouter" class="form-control" value="<?php echo $nombreRouter; ?>"  placeholder=" Nombre Router" />
				</div>
				
				<label for="inputSuccess" class="col-lg-12 control-label">IP </label>
				<div class="col-lg-4">
					<input type="text" name="ipRouter" id="ipRouter" class="form-control" value="<?php echo $ipRouter; ?>"  placeholder=" Digite la IP" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">Puerto </label>
				<div class="col-lg-4">
					<input type="text" name="puertoRouter" id="puertoRouter" class="form-control" value="<?php echo $puertoRouter; ?>"  placeholder="Digite el Puerto" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">Estado </label>
				 <div class="col-lg-4">
					<select id="estados_router_id" name="estados_router_id" class="form-control">
						<?php 		
							$info = $ADMROUTERS->getEstadosRouter();
							foreach ($info as $i => $value) {
								
								if($estados_router_id == $info[$i]['estados_router_id']){
									echo '<option id="'.$info[$i]['estados_router_id'].'" value="'.$info[$i]['estados_router_id'].'" selected>'.$info[$i]['estado_router'].'</option>';
								}else{
									echo '<option id="'.$info[$i]['estados_router_id'].'" value="'.$info[$i]['estados_router_id'].'">'.$info[$i]['estado_router'].'</option>';
								}

								

							}
						?>
					</select> 
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">Versión </label>
				<div class="col-lg-4">
					<input type="text" name="versionRouter" id="versionRouter" class="form-control" value="<?php echo $versionRouter; ?>"  placeholder="Versión Router" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">Usuario </label>
				<div class="col-lg-4">
					<input type="text" name="userRouter" id="userRouter" class="form-control" value="<?php echo $usuarioRouter; ?>"  placeholder="Digite el usuario" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">Clave </label>
				<div class="col-lg-4">
					<input type="password" name="claveRouter" id="claveRouter" class="form-control" value=""  placeholder="Digite la Clave" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">Reintentos Conexión </label>
				<div class="col-lg-4">
					<input type="text" name="reintentosCx" id="reintentosCx" class="form-control" value="<?php echo $reintentosConexionRouter; ?>"  placeholder="Reintentos Conexión" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">Retraso Conexión </label>
				<div class="col-lg-4">
					<input type="text" name="retrasoCx" id="retrasoCx" class="form-control" value="<?php echo $retrasoConexionRouter; ?>"  placeholder="Retraso Conexión" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">Tiempo Maximo espera Conexión </label>
				<div class="col-lg-4">
					<input type="text" name="tiempoMaximoCx" id="tiempoMaximoCx" class="form-control" value="<?php echo $tiempoMaximoConexionRouter; ?>"  placeholder="Tiempo Maximo Conexión" />
				</div>
			</div>

						<input type="submit" class="btn btn-success" value="Actualizar">
						<input type="hidden" name="action" value="routerAdd"/>
		</form>	

	</div>


</div>
<?php
}
