<?php 
include("control.php");
include("principal.php");
require_once("clases/Configuraciones.php");
// require_once ('clases/Routers.php');
require_once ('clases/RouterDb.php');
require_once 'clases/Usuarios.php';
$Configuraciones = new Configuraciones ();
$ruta_instalacion =  $Configuraciones->getKeyConfig("RUTA_PORTAL");

$ADMROUTERS = new RoutersDb();
$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['PHP_SELF']);
$validaSesion->getPageByName($php_self);
$action=$_REQUEST['action']; 
$profile=$_REQUEST['profile'];

$cantidadCaracteres = $Configuraciones->getKeyConfig("CANTIDAD_CARACTERES_CLAVE");

$classUsuario = new Usuarios($p_usuario_id,$p_usuario,$p_identificacion,$p_nombres,$p_apellidos,$p_direccion,$p_telefono,$p_estados_usuario_id,$p_fecharegistro,$p_clave,$p_correo,$p_perfil_id);
		
		
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

$getEstadosUsuario 		= $classUsuario->getEstadosUsuario();
$getAllPerfilUsuario 	= $classUsuario->getAllPerfilUsuario($estados_perfil_id);
			// echo "aqui voy <pre>";
			// print_r($getEstadosUsuario);
			// print_r($getAllPerfilUsuario);
			// echo "</pre>";
			// exit();
			
			
if ($action=="userAdd")
{


	$p_usuario_id = NULL;
	$p_fecharegistro = NULL;
	$p_usuario 				= $_POST['usuario'];
	$p_identificacion 		= $_POST['identificacion'];
	$p_nombres				= $_POST['nombres'];
	$p_apellidos 			= $_POST['apellidos'];
	$p_direccion 			= $_POST['direccion'];
	$p_telefono 			= $_POST['telefono'];
	$p_estados_usuario_id 	= $_POST['estados_usuario_id'];
	$p_clave 				= $_POST['claveUsuario'];
	$p_claveUsuarioConfirma	= $_POST['claveUsuarioConfirma'];
	$p_correo 				= $_POST['correo'];
	$p_perfil_id 			= $_POST['perfil_id'];
	
	if (($p_usuario=="")||($p_identificacion=="")||($p_nombres=="")||($p_apellidos=="")||($p_direccion=="")||($p_telefono=="")||($p_estados_usuario_id=="")||($p_clave=="")||($p_correo=="")||($p_perfil_id=="")||($p_claveUsuarioConfirma=="")) 
	{
		$mensajeRespuestaSetUserPortal = 'Todos los campos son obligatorios';
		$codigoRespuestaSetUserPortal  = '99';
	}else{
		if (empty($p_clave) or empty($p_claveUsuarioConfirma)){
			$mensajeRespuestaSetUserPortal = "Paramentros Invalidos<br>";
			$codigoRespuestaSetUserPortal  = '35';
		}else{
			if($p_clave !== $p_claveUsuarioConfirma){
				$mensajeRespuestaSetUserPortal = "Error: La clave y la confirmación no son iguales<br>";
				$codigoRespuestaSetUserPortal  = '36';
			}else{

				if(preg_match("/^.*(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/",$p_clave)){
					
					if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$p_correo)){
						$validaUsuarioPortal = $classUsuario->getUsuarioPortal($p_usuario,"");
						$validaCorreoUsuarioPortal = $classUsuario->getUsuarioPortal("",$p_correo);
						// echo "<pre>";
						// print_r($validaUsuarioPortal);
						// print_r($validaCorreoUsuarioPortal);
						// echo "</pre>";
						if(count($validaUsuarioPortal)>0){
							$mensajeRespuestaSetUserPortal = 'Usuario ya Existe';
							$codigoRespuestaSetUserPortal  = '22';
						}else{
							if(count($validaCorreoUsuarioPortal)>0){
								$mensajeRespuestaSetUserPortal = 'Correo ya Existe';
								$codigoRespuestaSetUserPortal  = '23';
							}else{
								// fin de crear perfil de usuario
								$userAdd = $classUsuario->setUsuarioPortal($p_usuario_id,$p_usuario,$p_identificacion,$p_nombres,$p_apellidos,$p_direccion,$p_telefono,$p_estados_usuario_id,$p_clave,$p_correo,$p_perfil_id,$_SESSION['usuario_id']);
								$mensajeRespuestaSetUserPortal = $classUsuario->getMensajeRespuesta();
								$codigoRespuestaSetUserPortal = $classUsuario->getCodigoRespuesta();
								// echo "Error en registro???'";
							}			
						}						
					}else{
						$mensajeRespuestaSetUserPortal = 'Correo no es valido';
						$codigoRespuestaSetUserPortal  = '38';
					}
				}else{
					$mensajeRespuestaSetUserPortal = 'Clave no tiene las condiciones minimas';
					$codigoRespuestaSetUserPortal  = '37';
				}
			}
		}
	}
}
?> 
<div class="container">
  <div class="">
		<h3 class="text-center text-success"> CREACIÓN DE USUARIOS PORTAL</h3>
		<h5 class="text-center text-success">
		<?php //echo $_SESSION['nombreRouter'].' IP: '.$_SESSION['ipRouter'].' Versión: '.$_SESSION['versionRouter'];
		?>
	</h5>
	<div>
		<label>
<?php 		
	if($mensajeRespuestaSetUserPortal!=''){
		echo $codigoRespuestaSetUserPortal."::".$mensajeRespuestaSetUserPortal."<br><br>";
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
			<label for="inputSuccess" class="col-lg-12 control-label">USUARIO </label>
			<div class="col-lg-4">
				<input type="text" name="usuario" id="usuario" class="form-control" value=""  placeholder=" Usuario - Login" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">IDENTIFICACION </label>
			<div class="col-lg-4">
				<input type="text" name="identificacion" id="identificacion" class="form-control" value=""  placeholder="Numero Identificacion" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">NOMBRES </label>
			<div class="col-lg-4">
				<input type="text" name="nombres" id="nombres" class="form-control" value=""  placeholder="Nombres" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">APELLIDOS </label>
			<div class="col-lg-4">
				<input type="text" name="apellidos" id="puertoRouter" class="form-control" value=""  placeholder="Apellidos" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">DIRECCION </label>
			<div class="col-lg-4">
				<input type="text" name="direccion" id="direccion" class="form-control" value=""  placeholder="Dirección" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">TELEFONO </label>
			<div class="col-lg-4">
				<input type="text" name="telefono" id="telefono" class="form-control" value=""  placeholder="Telefono - Celular" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">ESTADO </label>
			 <div class="col-lg-4">
				<select id="estados_usuario_id" name="estados_usuario_id" class="form-control">
					<?php 		
						foreach ($getEstadosUsuario as $i => $value) {
							echo '<option id="'.$getEstadosUsuario[$i]['estados_usuario_id'].'" value="'.$getEstadosUsuario[$i]['estados_usuario_id'].'">'.$getEstadosUsuario[$i]['estado_usuario'].'</option>';
						}
					?>
				</select> 
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">CLAVE </label>
			<div class="col-lg-4">
				<input type="password" name="claveUsuario" id="claveUsuario" class="form-control" value=""  placeholder="Digite la Clave" />
				<input type="password" name="claveUsuarioConfirma" id="claveUsuarioConfirma" class="form-control" value=""  placeholder="Confrme la Clave" />
				<div class="row">
					<div class="col-sm-6">
						<span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Minimo <?php echo $cantidadCaracteres; ?> Caracteres<br>
						<span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Un Caracter en Mayuscula
					</div>
					<div class="col-sm-6">
						<span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span>Una Caracter en Minuscula<br>
						<span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Minimo Numeros
					</div>
					<div class="row">
						<div class="col-sm-12">
						<span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Valida Clave
						</div>
					</div>
				</div>
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">CORREO ELECTRONICO</label>
			<div class="col-lg-4">
				<input type="text" name="correo" id="correo" class="form-control" value=""  placeholder="Correo - Email" />
			</div>
			<label for="inputSuccess" class="col-lg-12 control-label">PERFIL</label>
			 <div class="col-lg-4">
				<select id="perfil_id" name="perfil_id" class="form-control">
					<?php 		
						foreach ($getAllPerfilUsuario as $i => $value) {
							echo '<option id="'.$getAllPerfilUsuario[$i]['perfil_id'].'" value="'.$getAllPerfilUsuario[$i]['perfil_id'].'">'.$getAllPerfilUsuario[$i]['perfil'].'</option>';
						}
					?>
				</select> 
			</div>
			
			<label for="inputSuccess" class="col-lg-12 control-label"></label>
			<div class="col-lg-4">
					<input type="submit" class="btn btn-success" value="Crear!!">
					<input type="hidden" name="action" value="userAdd"/>
			</div>
		</div>


	</form>	

</div>


<script>
$("input[type=password]").keyup(function(){
    var ucase = new RegExp("[A-Z]+");
	var lcase = new RegExp("[a-z]+");
	var num = new RegExp("[0-9]+");

	if($("#claveUsuario").val().length >= <?php echo $cantidadCaracteres;  ?>){
		$("#8char").removeClass("glyphicon-remove");
		$("#8char").addClass("glyphicon-ok");
		$("#8char").css("color","#00A41E");

	}else{
		$("#8char").removeClass("glyphicon-ok");
		$("#8char").addClass("glyphicon-remove");
		$("#8char").css("color","#FF0004");

	}
	
	if(ucase.test($("#claveUsuario").val())){
		$("#ucase").removeClass("glyphicon-remove");
		$("#ucase").addClass("glyphicon-ok");
		$("#ucase").css("color","#00A41E");

	}else{
		$("#ucase").removeClass("glyphicon-ok");
		$("#ucase").addClass("glyphicon-remove");
		$("#ucase").css("color","#FF0004");

	}
	
	if(lcase.test($("#claveUsuario").val())){
		$("#lcase").removeClass("glyphicon-remove");
		$("#lcase").addClass("glyphicon-ok");
		$("#lcase").css("color","#00A41E");

	}else{
		$("#lcase").removeClass("glyphicon-ok");
		$("#lcase").addClass("glyphicon-remove");
		$("#lcase").css("color","#FF0004");

	}
	
	if(num.test($("#claveUsuario").val())){
		$("#num").removeClass("glyphicon-remove");
		$("#num").addClass("glyphicon-ok");
		$("#num").css("color","#00A41E");

	}else{
		$("#num").removeClass("glyphicon-ok");
		$("#num").addClass("glyphicon-remove");
		$("#num").css("color","#FF0004");

	}
	
	if($("#claveUsuario").val() == $("#claveUsuarioConfirma").val()){
		$("#pwmatch").removeClass("glyphicon-remove");
		$("#pwmatch").addClass("glyphicon-ok");
		$("#pwmatch").css("color","#00A41E");
	}else{
		$("#pwmatch").removeClass("glyphicon-ok");
		$("#pwmatch").addClass("glyphicon-remove");
		$("#pwmatch").css("color","#FF0004");
	}
	
});
</script>