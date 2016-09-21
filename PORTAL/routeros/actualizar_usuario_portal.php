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
$action2=$_REQUEST['action2']; 
$usuarioPortal=$_REQUEST['usuarioPortal'];
// $usuario_modificar=$_REQUEST['usuario_modificar'];

	// echo "<pre>";
	// print_r($_REQUEST);
	// echo "</pre>";
	
	
$classUsuario = new Usuarios($p_usuario_id,$usuarioPortal,$p_identificacion,$p_nombres,$p_apellidos,$p_direccion,$p_telefono,$p_estados_usuario_id,$p_fecharegistro,$p_clave,$p_correo,$p_perfil_id);


$getEstadosUsuario 		= $classUsuario->getEstadosUsuario();
$getAllPerfilUsuario 	= $classUsuario->getAllPerfilUsuario($estados_perfil_id);




if ($action2=="userUpdate")
{


	$p_fecharegistro = NULL;
	$p_usuario_id			= $_POST['usuario_id'];
	$p_usuario 				= $_POST['usuario'];
	$p_usuarioActual		= $_POST['usuarioPortal'];
	$p_identificacion 		= $_POST['identificacion'];
	$p_nombres				= $_POST['nombres'];
	$p_apellidos 			= $_POST['apellidos'];
	$p_direccion 			= $_POST['direccion'];
	$p_telefono 			= $_POST['telefono'];
	$p_estados_usuario_id 	= $_POST['estados_usuario_id'];
	$p_correo 				= $_POST['correo'];
	$p_correoActual			= $_POST['correoActual'];
	$p_perfil_id 			= $_POST['perfil_id'];
	
	if (($p_usuario_id=="")||($p_usuario=="")||($p_identificacion=="")||($p_nombres=="")||($p_apellidos=="")||($p_direccion=="")||($p_telefono=="")||($p_estados_usuario_id=="")||($p_correo=="")||($p_perfil_id=="")) 
	{
		$mensajeRespuestaSetUserPortal = 'Todos los campos son obligatorios';
		$codigoRespuestaSetUserPortal  = '99';
	}else{
		if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$p_correo)){
			
			
			$validaUsuarioPortal = $classUsuario->getUsuarioPortal($p_usuario,"");
			$validaCorreoUsuarioPortal = $classUsuario->getUsuarioPortal("",$p_correo);
			// echo "<pre>";
			// print_r($validaUsuarioPortal);
			// print_r($validaCorreoUsuarioPortal);
			// echo "</pre>";
			if(count($validaUsuarioPortal)>0 and ($p_usuario <> $p_usuarioActual)){
				$mensajeRespuestaSetUserPortal = 'Usuario ya Existe';
				$codigoRespuestaSetUserPortal  = '22';
			}else{
				if(count($validaCorreoUsuarioPortal)>0 and ($p_correo <> $p_correoActual)){
					$mensajeRespuestaSetUserPortal = 'Correo ya Existe';
					$codigoRespuestaSetUserPortal  = '23';
				}else{
					// fin de crear perfil de usuario
					$userAdd = $classUsuario->setUsuarioPortal($p_usuario_id,$p_usuario,$p_identificacion,$p_nombres,$p_apellidos,$p_direccion,$p_telefono,$p_estados_usuario_id,$p_clave,$p_correo,$p_perfil_id,$_SESSION['usuario_id']);
					$mensajeRespuestaSetUserPortal = $classUsuario->getMensajeRespuesta();
					$codigoRespuestaSetUserPortal = $classUsuario->getCodigoRespuesta();
					if( $codigoRespuestaSetUserPortal == '00'){
						$usuarioPortal = $p_usuario;
					}
					// echo "Error en registro???'";
				}			
			}						
		}else{
			$mensajeRespuestaSetUserPortal = 'Correo no es valido';
			$codigoRespuestaSetUserPortal  = '38';
		}
	}
}
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

	
	if($codigoRespuestaUsuarioPortal<> '00'){
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
								<th class="success"><label>Identificación</label></th>
								<th class="success"><label>Nombres</label></th>
								<th class="success"><label>Apellidos</label></th>
								<th class="success"><label>Estado</label></th>
								<th class="success"><label>Perfil</label></th>
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
			$identificacion = $getUsuarioPortal[$llave]['identificacion'];
			$nombres = $getUsuarioPortal[$llave]['nombres'];
			$apellidos = $getUsuarioPortal[$llave]['apellidos'];
			$estado = $getUsuarioPortal[$llave]['estado'];
			$perfil = $getUsuarioPortal[$llave]['perfil'];
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
			echo '<td class="text-info"><label>'.$identificacion.'</label></td>';
			echo '<td class="text-info"><label>'.$nombres.'</label></td>';
			echo '<td class="text-info"><label>'.$apellidos.'</label></td>';
			echo '<td class="text-info"><label>'.$estado.'</label></td>';
			echo '<td class="text-info"><label>'.$perfil.'</label></td>';
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
		$getUsuarioPortal = $classUsuario->getUsuarioPortal($usuarioPortal,"");
		$mensajeRespuestaUsuarioPortal = $classUsuario->getMensajeRespuesta();
		$codigoRespuestaUsuarioPortal = $classUsuario->getCodigoRespuesta();
		if($codigoRespuestaUsuarioPortal == '00'){
			if(count($getUsuarioPortal) == 1){
				$llave =0;
				$usuario_id = $getUsuarioPortal[$llave]['usuario_id'];
				$usuario = $getUsuarioPortal[$llave]['usuario'];
				$nombres = $getUsuarioPortal[$llave]['nombres'];
				$identificacion = $getUsuarioPortal[$llave]['identificacion'];
				$perfil = $getUsuarioPortal[$llave]['perfil'];
				$perfil_id = $getUsuarioPortal[$llave]['perfil_id'];
				$estado = $getUsuarioPortal[$llave]['estado'];
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
	
		if($codigoRespuestaUsuarioPortal <> '00'){
			echo $codigoRespuestaUsuarioPortal."::".$mensajeRespuestaUsuarioPortal."<br><br>";
		}

		if($mensajeRespuestaSetUserPortal!=''){
			echo $codigoRespuestaSetUserPortal."::".$mensajeRespuestaSetUserPortal."<br><br>";
		}
	?>
			</label>
		</div>
		

		<form class="contacto" id="addUsers" action="#" method="POST" enctype="multipart/form-data"> 
			<div class="form-group has-success">
				<label for="inputSuccess" class="col-lg-12 control-label">USUARIO </label>
				<div class="col-lg-4">
					<input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo $usuario; ?>"  placeholder=" Usuario - Login" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">IDENTIFICACION </label>
				<div class="col-lg-4">
					<input type="text" name="identificacion" id="identificacion" class="form-control" value="<?php echo $identificacion; ?>"  placeholder="Numero Identificación" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">NOMBRES </label>
				<div class="col-lg-4">
					<input type="text" name="nombres" id="nombres" class="form-control" value="<?php echo $nombres; ?>"  placeholder="Nombres" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">APELLIDOS </label>
				<div class="col-lg-4">
					<input type="text" name="apellidos" id="puertoRouter" class="form-control" value="<?php echo $apellidos; ?>"  placeholder="Apellidos" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">DIRECCION </label>
				<div class="col-lg-4">
					<input type="text" name="direccion" id="direccion" class="form-control" value="<?php echo $direccion; ?>"  placeholder="Dirección" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">TELEFONO </label>
				<div class="col-lg-4">
					<input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo $telefono; ?>"  placeholder="Telefono - Celular" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">ESTADO </label>
				 <div class="col-lg-4">
					<select id="estados_usuario_id" name="estados_usuario_id" class="form-control">
						<?php 		
							foreach ($getEstadosUsuario as $i => $value) {
								if($estados_usuario_id == $getEstadosUsuario[$i]['estados_usuario_id']){
									echo '<option id="'.$getEstadosUsuario[$i]['estados_usuario_id'].'" value="'.$getEstadosUsuario[$i]['estados_usuario_id'].'" selected>'.$getEstadosUsuario[$i]['estado_usuario'].'</option>';
								}else{
									echo '<option id="'.$getEstadosUsuario[$i]['estados_usuario_id'].'" value="'.$getEstadosUsuario[$i]['estados_usuario_id'].'">'.$getEstadosUsuario[$i]['estado_usuario'].'</option>';									
								}
							}
						?>
					</select> 
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">CORREO ELECTRONICO</label>
				<div class="col-lg-4">
					<input type="text" name="correo" id="correo" class="form-control" value="<?php echo $correo; ?>"  placeholder="Correo - Email" />
				</div>
				<label for="inputSuccess" class="col-lg-12 control-label">PERFIL</label>
				 <div class="col-lg-4">
					<select id="perfil_id" name="perfil_id" class="form-control">
						<?php 		
							foreach ($getAllPerfilUsuario as $i => $value) {
								if($perfil_id == $getAllPerfilUsuario[$i]['perfil_id']){
									echo '<option id="'.$getAllPerfilUsuario[$i]['perfil_id'].'" value="'.$getAllPerfilUsuario[$i]['perfil_id'].'" selected>'.$getAllPerfilUsuario[$i]['perfil'].'</option>';
								}else{
									echo '<option id="'.$getAllPerfilUsuario[$i]['perfil_id'].'" value="'.$getAllPerfilUsuario[$i]['perfil_id'].'">'.$getAllPerfilUsuario[$i]['perfil'].'</option>';									
								}

							}
						?>
					</select> 
				</div>
				
				<label for="inputSuccess" class="col-lg-12 control-label"></label>
				<div class="col-lg-4">
						<input type="hidden" name="action" value="getInfoUser"/>
						<input type="hidden" name="action2" value="userUpdate"/>
						<input type="hidden" name="usuario_id" value="<?php echo $usuario_id; ?>"/>
						<input type="hidden" name="usuarioPortal" value="<?php echo $usuario; ?>"/>
						<input type="hidden" name="correoActual" value="<?php echo $correo; ?>"/>
						<input type="submit" class="btn btn-success" value="Actualizar!!">
						
				</div>
			</div>
		</form>	

	</div>


</div>
<?php
}
