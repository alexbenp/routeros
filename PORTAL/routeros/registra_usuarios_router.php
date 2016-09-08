<?php 
include("control.php");
include("principal.php");
include("include/config.php");
//require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/Routers.php');
$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['REQUEST_URI']);
$validaSesion->getPageByName($php_self);
$action=$_REQUEST['action']; 
$profile=$_REQUEST['profile'];

$ipRB			= $_SESSION["ip"]; //IP de tu RB.
$Username		= $_SESSION["usuario"]; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION["clave"]; //Clave del usuario con privilegios
$api_puerto		= $_SESSION["puerto"]; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION["reintentos_conexion"]; // Connection attempt count
$delay 			= $_SESSION["retraso_conexion"]; // Delay between connection attempts in seconds
$timeout 		= $_SESSION["tiempo_maximo_conexion"]; // Connection attempt timeout and data read timeout


$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);

if ($action=="userAdd")
{
	
	$name		=$_REQUEST['name']; 
	$password	=$_REQUEST['password']; 
	$uptime		=$_REQUEST['uptime'].$_REQUEST['unid_uptime'];
	$comentario	=$_REQUEST['comentario'];

	$profile_name	= $_REQUEST['profile_name']; 
	

	if (($name=="")||($password=="")||($uptime=="")||($profile_name=="")) 
	{
		$mensajeRespuestaUserAdd = 'Todos los campos son obligatorios';
		$codigoRespuestaUserAdd = '99';
		
	}else{
		// fin de crear perfil de usuario
		$userAdd = $ROUTERS->ipHotspotUserAdd($name,$password,$uptime,$comentario,$profile_name);
		$mensajeRespuestaUserAdd = $ROUTERS->getMensajeRespuesta();
		$codigoRespuestaUserAdd = $ROUTERS->getCodigoRespuesta();
	} 
}
?> 
<div class="container">
  <div class="">
		<h4 class="text-center text-success"> CREACION DE USUARIOS</h4>
	<br>
	<div>
		<label>
<?php 		
	if($mensajeRespuestaUserAdd!=''){
		echo $codigoRespuestaUserAdd."::".$mensajeRespuestaUserAdd."<br><br>";
	}
	if($mensajeRespuestaUserRemove!=''){
		echo $codigoRespuestaUserAdd."::".$mensajeRespuestaUserRemove."::idUser::".$user."<br><br>";
	}
?>
		</label>
	</div>
	

	<form class="contacto" id="addUsers" action="#" method="POST" enctype="multipart/form-data"> 
		<div class="form-group has-success">
			<label for="inputSuccess" class="col-lg-12 control-label">Usuario </label>
			<div class="col-lg-4">
				<input type="text" name="name" id="name" class="form-control" value=""  placeholder=" DIGITE USUARIO" />
			</div>
			
			<label for="inputSuccess" class="col-lg-12 control-label">Clave </label>
			<div class="col-lg-4">
				<input type="password" name="password" id="password" class="form-control" value=""  placeholder=" DIGITE CLAVE" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">Tiempo </label>
			<div class="col-lg-4">
				<input type="text" name="uptime" id="uptime" class="form-control" value=""  placeholder="DIGITE TIEMPO" />
			</div>

			 <div class="col-lg-6">
				<select id="unid_uptime" name="unid_uptime" class="form-control">
					<?php 		
						$info = $ROUTERS->unidadesTiempo();
						foreach ($info as $i => $value) {
							echo '<option id="'.$i.'" value="'.$i.'">'.$value.'</option>';
						}
					?>
				</select> 
			</div>
			
		   <label for="inputSuccess" class="col-lg-12 control-label">Perfil </label>
				<div class="col-lg-4">
					<select id="profile_name" name="profile_name" class="form-control">
							<?php 		
								$info = $ROUTERS->ipHotspotUserProfileGetall();
								foreach ($info as $i => $value) {
										$valor=$info[$i];
										echo '<option id="'.$valor['.id'].'" value="'.$valor['name'].'">'.$valor['name'].'</option>';
								}
							?>
					</select> 
				</div>
			 
			<label for="inputSuccess" class="col-lg-12 control-label">Comentario </label>
				<div class="col-lg-4">						 
					<textarea id="comentario" class="input" name="comentario" rows="3" cols="30"></textarea><br />
					<br /><br />
					<input type="submit" class="btn btn-success" value="Agregar">
					<input type="hidden" name="action" value="userAdd"/>
				 </div>
		</div>

	</form>	

</div>


