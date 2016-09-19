<?php 
include("control.php");
include("principal.php");
require_once("clases/Configuraciones.php");
require_once ('clases/Routers.php');
require_once ('clases/RouterDb.php');
$Configuraciones = new Configuraciones ();
$ruta_instalacion =  $Configuraciones->getKeyConfig("RUTA_PORTAL");

$ADMROUTERS = new RoutersDb();
$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['PHP_SELF']);
$validaSesion->getPageByName($php_self);
$action=$_REQUEST['action']; 
$profile=$_REQUEST['profile'];

		
		
		
// echo "<pre>";
// print_r($_REQUEST);
// echo "</pre>";

$info = $ADMROUTERS->getEstadosRouter();
			// echo "aqui voy <pre>";
			// print_r($info);
			// echo "</pre>";
			// exit();
			
			
if ($action=="routerAdd")
{
	// echo "Proceso registrado Exitosamente";

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
}
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
		// $mensajeRespuestaConnect = $ROUTERS->getMensajeRespuesta();
		// $codigoRespuestaConnect = $ROUTERS->getCodigoRespuesta();
	// if($mensajeRespuestaConnect!='' and $codigoRespuestaConnect!='00'){
		// echo $codigoRespuestaConnect."::".$mensajeRespuestaConnect."::idUser::".$user."<br><br>";
	// }
?>
		</label>
	</div>
	

	<form class="contacto" id="addRouters" action="#" method="POST" enctype="multipart/form-data"> 
		<div class="form-group has-success">
			<label for="inputSuccess" class="col-lg-12 control-label">Nombre Router </label>
			<div class="col-lg-4">
				<input type="text" name="nameRouter" id="nameRouter" class="form-control" value=""  placeholder=" Nombre Router" />
			</div>
			
			<label for="inputSuccess" class="col-lg-12 control-label">IP </label>
			<div class="col-lg-4">
				<input type="text" name="ipRouter" id="ipRouter" class="form-control" value=""  placeholder=" Digite la IP" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">Puerto </label>
			<div class="col-lg-4">
				<input type="text" name="puertoRouter" id="puertoRouter" class="form-control" value="8728"  placeholder="Digite el Puerto" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">Estado </label>
			 <div class="col-lg-4">
				<select id="estados_router_id" name="estados_router_id" class="form-control">
					<?php 		
						$info = $ADMROUTERS->getEstadosRouter();
						foreach ($info as $i => $value) {
							echo '<option id="'.$info[$i]['estados_router_id'].'" value="'.$info[$i]['estados_router_id'].'">'.$info[$i]['estado_router'].'</option>';
						}
					?>
				</select> 
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">Versión </label>
			<div class="col-lg-4">
				<input type="text" name="versionRouter" id="versionRouter" class="form-control" value=""  placeholder="Versión Router" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">Usuario </label>
			<div class="col-lg-4">
				<input type="text" name="userRouter" id="userRouter" class="form-control" value=""  placeholder="Digite el usuario" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">Clave </label>
			<div class="col-lg-4">
				<input type="password" name="claveRouter" id="claveRouter" class="form-control" value=""  placeholder="Digite la Clave" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">Reintentos Conexión </label>
			<div class="col-lg-4">
				<input type="text" name="reintentosCx" id="reintentosCx" class="form-control" value="3"  placeholder="Reintentos Conexión" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">Retraso Conexión </label>
			<div class="col-lg-4">
				<input type="text" name="retrasoCx" id="retrasoCx" class="form-control" value="3"  placeholder="Retraso Conexión" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">Tiempo Maximo espera Conexión </label>
			<div class="col-lg-4">
				<input type="text" name="tiempoMaximoCx" id="tiempoMaximoCx" class="form-control" value="3"  placeholder="Tiempo Maximo Conexión" />
			</div>
		</div>

					<input type="submit" class="btn btn-success" value="Agregar">
					<input type="hidden" name="action" value="routerAdd"/>
	</form>	

</div>


