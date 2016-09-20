<?php 
include("control.php");
include("principal.php");
require_once("clases/Configuraciones.php");

require_once 'clases/Usuarios.php';

$Configuraciones = new Configuraciones ();
$ruta_instalacion =  $Configuraciones->getKeyConfig("RUTA_PORTAL");

$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['PHP_SELF']);
$validaSesion->getPageByName($php_self);
$action=$_REQUEST['action']; 
$usuarioPortal=$_REQUEST['usuarioPortal'];
$usuario_modificar=$_REQUEST['usuario_modificar'];

	// echo "<pre>";
	// print_r($_REQUEST);
	// echo "</pre>";
	
	
$classUsuario = new Usuarios($p_usuario_id,$usuarioPortal,$p_identificacion,$p_nombres,$p_apellidos,$p_direccion,$p_telefono,$p_estados_usuario_id,$p_fecharegistro,$p_clave,$p_correo,$p_perfil_id);

?>
	
<div class="container">
	<div class="">
		<h3 class="text-center text-success">ACTUALIZACION USAURIO PORTAL</h3>

	</div>
	<form id="usuariosPortal" action="#" method="post">
		<div class="form-group has-success">
			<label for="inputSuccess" class="col-lg-12 control-label">Usuario </label>
			<div class="col-lg-4">
				<input type="text" name="usuarioPortal" id="usuarioPortal" class="form-control" value=""  placeholder=" Busrcar por Usuario" />
			</div>
			<div class="col-lg-8">
				<input type="submit" class="btn btn-success" value="Buscar">
			</div>
			
			<input type="hidden" name="action" value="findUser"/>
		</div>
	</form>
</div>

	<div>
		<label>
		
<?php 

if($action=="findUser" or $action=="getInfoUser"){
	
	if(empty($usuarioPortal)){
		$getUsuarioPortal = $classUsuario->getAllUsers($estados_usuario_id);
		$mensajeRespuestaUsuarioPortal = $classUsuario->getMensajeRespuesta();
		$codigoRespuestaUsuarioPortal = $classUsuario->getCodigoRespuesta();
	}else{
		$getUsuarioPortal = $classUsuario->getUsuarioPortal($usuarioPortal,$correo);
		$mensajeRespuestaUsuarioPortal = $classUsuario->getMensajeRespuesta();
		$codigoRespuestaUsuarioPortal = $classUsuario->getCodigoRespuesta();
	}
	// echo "<pre>";
	// print_r($getUsuarioPortal);
	// echo "</pre>";
	
	if($mensajeRespuestaUsuarioPortal!=''){
		echo $codigoRespuestaUsuarioPortal."::".$mensajeRespuestaUsuarioPortal."<br><br>";
	}
	
}
				
?>		
		<label>
		</div>
	<form class="contacto" id="actualiza_usuario" action="#" method="POST" enctype="multipart/form-data"> 
		<input class="btn btn-success" id="submit_button" onclick="buttonSendForm('');" type="button" value="Volver" />
		<table class="table table-hover">
			<div class="container">
						<div class="form-group">
							<tr>
								<th class="success"><label>Usuario</label></th>
								<th class="success"><label>Nombres</label></th>
								<th class="success"><label>Apellidos</label></th>
								<th class="success"><label>Estado</label></th>
								<th class="success"><label>Correo</label></th>
								<th class="success"><label>Direccion</label></th>
								<th class="success"><label>Telefono</label></th>
								<th class="success"><label>Usar</label></th>
							</tr>
						</div>
					</div>

<?php
	if(is_array($getUsuarioPortal)){
		foreach($getUsuarioPortal as $llave=>$elmento){
			$usuario_id = $getUsuarioPortal[$llave]['usuario_id'];
			$usuario = $getUsuarioPortal[$llave]['usuario'];
			$nombres = $getUsuarioPortal[$llave]['nombres'];
			$apellidos = $getUsuarioPortal[$llave]['apellidos'];
			$estados_usuario_id = $getUsuarioPortal[$llave]['estados_usuario_id'];
			$correo = $getUsuarioPortal[$llave]['correo'];
			$direccion = $getUsuarioPortal[$llave]['direccion'];
			$telefono = $getUsuarioPortal[$llave]['telefono'];
			// $listClaveRouter = $AdminRouters[$llave]['claveRouter'];
			// $estadoRouter = $getUsuarioPortal[$llave]['estadoRouter'];
			// $reintentosConexionRouter = $getUsuarioPortal[$llave]['reintentos_conexion'];
			// $retrasoConexionRouter = $getUsuarioPortal[$llave]['retraso_conexion'];
			// $tiempoMaximoConexionRouter = $getUsuarioPortal[$llave]['tiempo_maximo_conexion'];
			
			echo '<tr id="tr'.$usuario_id.'">';
			echo '<td class="text-info"><label>'.$usuario.'</label></td>';
			echo '<td class="text-info"><label>'.$nombres.'</label></td>';
			echo '<td class="text-info"><label>'.$apellidos.'</label></td>';
			echo '<td class="text-info"><label>'.$estados_usuario_id.'</label></td>';
			echo '<td class="text-info"><label>'.$correo.'</label></td>';
			echo '<td class="text-info"><label>'.$direccion.'</label></td>';
			echo '<td class="text-info"><label>'.$telefono.'</label></td>';
				echo '<td class="text-info">	
				<input class="btn btn-success" id="submit_button" onclick="buttonSendForm(\''.$usuario.'\');" type="button" value="A" />
				  </td>';
			echo '<tr>';
		}	
	}
?>
		</table>
		<input type="hidden" id="action" name="action" value="getInfoUser"/>
		<input type="hidden" id="usuarioPortalUpdate" name="usuarioPortal" value=""/>

	</form>
<script>
function buttonSendForm(usuario){
	document.getElementById('usuarioPortalUpdate').value = usuario;
    document.getElementById('actualiza_usuario').submit();
}

</script>

<div id="resultado">
<?php 

if($action=="getInfoUser" and !empty($usuarioPortal)){
	Echo "casii";
		$getUsuarioPortal = $classUsuario->getUsuarioPortal($usuarioPortal,"");
		$mensajeRespuestaUsuarioPortal = $classUsuario->getMensajeRespuesta();
		$codigoRespuestaUsuarioPortal = $classUsuario->getCodigoRespuesta();
		if($codigoRespuestaUsuarioPortal == '00'){
			if(count($getUsuarioPortal) == 1){
				$llave =0;
				$usuario_id = $getUsuarioPortal[$llave]['usuario_id'];
				$usuario = $getUsuarioPortal[$llave]['usuario'];
				$nombres = $getUsuarioPortal[$llave]['nombres'];
				$apellidos = $getUsuarioPortal[$llave]['apellidos'];
				$estados_usuario_id = $getUsuarioPortal[$llave]['estados_usuario_id'];
				$correo = $getUsuarioPortal[$llave]['correo'];
				$direccion = $getUsuarioPortal[$llave]['direccion'];
				$telefono = $getUsuarioPortal[$llave]['telefono'];
			}else{
				$mensajeRespuestaUsuarioPortal = "Error: Se encontraron dos usuarios";
				$codigoRespuestaUsuarioPortal = "39";
			}

		}else{
			
		}



?> 
	<div class="container">
	  <div class="">
			<h5 class="text-center text-success"> </h5>
		<div>
			<label>
	<?php 		
		if($mensajeRespuestaUsuarioPortal!=''){
			echo $codigoRespuestaUsuarioPortal."::".$mensajeRespuestaUsuarioPortal."<br><br>";
		}

	?>
			</label>
		</div>
		

		<form class="contacto" id="addRouters" action="#" method="POST" enctype="multipart/form-data"> 
			<div class="form-group has-success">
				<input type="hidden" name="usuario_id" value="<?php echo $usuario_id; ?>"/>
				<label for="inputSuccess" class="col-lg-12 control-label">Usuario </label>
				<div class="col-lg-4">
					<input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo $usuario; ?>"  placeholder=" Usuario - Login" />
				</div>
				
				<label for="inputSuccess" class="col-lg-12 control-label">IP </label>
				<div class="col-lg-4">
					<input type="text" name="nombres" id="nombres" class="form-control" value="<?php echo $nombres; ?>"  placeholder=" Nombres" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">Puerto </label>
				<div class="col-lg-4">
					<input type="text" name="apellidos" id="apellidos" class="form-control" value="<?php echo $apellidos; ?>"  placeholder=" Apellidos" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">Estado </label>
				 <div class="col-lg-4">
					<select id="estados_router_id" name="estados_router_id" class="form-control">
						<?php 		
							// $info = $ADMROUTERS->getEstadosRouter();
							// foreach ($info as $i => $value) {
								
								// if($estados_router_id == $info[$i]['estados_router_id']){
									// echo '<option id="'.$info[$i]['estados_router_id'].'" value="'.$info[$i]['estados_router_id'].'" selected>'.$info[$i]['estado_router'].'</option>';
								// }else{
									// echo '<option id="'.$info[$i]['estados_router_id'].'" value="'.$info[$i]['estados_router_id'].'">'.$info[$i]['estado_router'].'</option>';
								// }

								

							// }
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
