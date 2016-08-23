<?php
/*
$message = "";

if(1 == 2)
{
	echo "Entra";
	
	$p_usuario_id = "";
	$p_usuario = $_POST['usuario'];
	$p_clave = $_POST['clave'];
	$p_identificacion = "";
	$p_nombres = "";
	$p_apellidos = "";
	$p_direccion = "";
	$p_telefono = "";
	$p_estados_usuario_id = "";
	$p_fecharegistro = "";
	
	$p_correo = "";
	$p_perfil_id = "";
 
	if(!empty($p_usuario) && !empty($p_clave)) {
		session_start();
		require_once 'clases/Usuarios.php';  
		$usuario = new Usuarios($p_usuario_id,$p_usuario,$p_identificacion,$p_nombres,$p_apellidos,$p_direccion,$p_telefono,$p_estados_usuario_id,$p_fecharegistro,$p_clave,$p_correo,$p_perfil_id);
		$usuario->validaUsuario();
		if ($usuario->getCodigoRespuesta() =="00"){
			
			$usuario->getPerfilUsuario();
			
			// $message = $usuario->getMensajeRespuesta().": ".$usuario->getCodigoRespuesta() ;
			 // header("Location: registrarusuarios.php");
			 header("Location: principal.php");
		}else{
			$message = $usuario->getMensajeRespuesta().":".$usuario->getCodigoRespuesta() ;
			session_destroy();
		}

	 

	} else {
	 $message = "Los campos de Usuario y Clave son Requeridos";
	// echo $message;
	}
}
*/
?>
<html>
<head>
<meta charset="utf-8">
<title>Portal Routeros</title>
<link href="estilos/ingreso.css" rel="stylesheet" type="text/css">
</head>

 <div class="container mlogin">
 <div id="login">
 <h1>INGRESO A PORTAL</h1>
<form name="ingreso" id="ingreso" action="ingreso.php" method="POST">
 <p>
 <label for="user_login">Usuario<br />
 <input type="text" name="usuario" id="usuario" class="input" value="" size="20" /></label>
 </p>
 <p>
 <label for="user_pass">Clave<br />
 <input type="password" name="clave" id="clave" class="input" value="" size="20" /></label>
 </p>
 <p class="submit">
 <input type="submit" name="login" class="button" value="Entrar" />
 </p>
 <!-- <p class="regtext">No estas registrado? <a href="register.php" >Registrate Aquí</a>!</p>
 -->
</form>
 
</div>
 
</div>
 <?php if (!empty($_POST['message'])) {echo "<p class=\"error\">" . "ATENCIÓN!!: ". $_POST['message'] . "</p>";} ?>