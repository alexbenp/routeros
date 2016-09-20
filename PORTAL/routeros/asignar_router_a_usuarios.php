<?php 
include("control.php");
require_once("clases/Configuraciones.php");
require_once ('clases/RouterDb.php');
require_once ('clases/Routers.php');
require_once 'clases/Usuarios.php';
$Configuraciones = new Configuraciones ();
$ruta_instalacion =  $Configuraciones->getKeyConfig("RUTA_PORTAL");

$imprimeMenu 		= 1;
$estados_router_id = 1;
$action			= $_REQUEST['action']; 
$routerId		= $_REQUEST['router_id']; 
$usuario_id 	= $_SESSION['usuario_id'];
$usuario	 	= $_SESSION['usuario'];



$users = new Usuarios($usuario_id,$usuario,$identificacion,$nombres,$apellidos,$direccion,$telefono,$estados_usuario_id,$fecharegistro,$password3,$correo,$perfil_id);
					
			

			
if($action=="sSgetInfoRouter"){
	require_once ('clases/Menus.php');
	$imprimeMenu = 0;
}

if($imprimeMenu == 1){
	require_once("principal.php");	
}

$ADMROUTERS = new RoutersDb();

$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['PHP_SELF']);
$validaSesion->getPageByName($php_self);


$AdminRouters = $ADMROUTERS->getParametrosRouter($estados_router_id);
$getCodigoRespuestaRouter = $ADMROUTERS->getCodigoRespuesta();
$getMensajeRespuestaRouter = $ADMROUTERS->getMensajeRespuesta();

// echo "<pre>";
// // print_r($_POST);
// echo "</pre>";

$lista_usuarios = $users->getAllUsers($estados_router_id);
$getCodigoRespuestaAllUsers = $users->getCodigoRespuesta();
$getMensajeRespuestaAllUsers = $users->getMensajeRespuesta();

if($imprimeMenu == 1){
?>
	<form class="contacto" id="asocia_router_usuario" action="#" method="POST" enctype="multipart/form-data"> 
	
		<div>
			<h3 class="text-center text-success">Registro Routers a Usuarios</h3>
		<h5 class="text-center text-success">
		<?php //echo $_SESSION['nombreRouter'].' IP: '.$_SESSION['ipRouter'].' Versión: '.$_SESSION['versionRouter'];
		?>
		</h5>
		</div>
		
<?php 
		if($getMensajeRespuestaRouter!='' and $getCodigoRespuestaRouter!='00'){
			echo $getCodigoRespuestaRouter."::".$getMensajeRespuestaRouter."<br><br>";
		}
		if($getMensajeRespuestaAllUsers!='' and $getCodigoRespuestaAllUsers!='00'){
			echo $getCodigoRespuestaAllUsers."::".$getMensajeRespuestaAllUsers."<br><br>";
		}
?>		
		
		<table class="table table-hover">
			<div class="container">
				<select multiple name="usuarios[]">
				<?php
					foreach($lista_usuarios as $llave=>$elmento){
						echo '<option value="'.$lista_usuarios[$llave]['usuario'].'" >'.$lista_usuarios[$llave]['usuario'].'</option>';
					}
				
				?>

				</select>

				<select multiple name="routers[]">
				<?php
					foreach($AdminRouters as $llave=>$elmento){
						echo '<option value="'.$AdminRouters[$llave]['router_id'].'" >'.$AdminRouters[$llave]['nombre'].'-'.$AdminRouters[$llave]['nombre'].'</option>';
					}
				
				?>

				</select>
			</div>
		</table>
		<input type="hidden" id="action" name="action" value="setRouterUser"/>
		<input type="submit" id="1" name="Registrar" value="Registrar"/>
	</form>
<script>
function buttonSendForm(router_id){
	document.getElementById('router_id').value = router_id;
    document.getElementById('asocia_router_usuario').submit();
}

</script>

<div id="resultado">
<?php 
}



?>
</div>
<?php
