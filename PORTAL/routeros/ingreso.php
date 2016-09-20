<?php
$message = "";

 if($_POST)
 {
	
	
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
	$p_codigo_respuesta_exitosa = "00";
 
	if(!empty($p_usuario) && !empty($p_clave)) {
		session_start();
		$session_id = session_id();
		require_once 'clases/Usuarios.php';
		$usuario = new Usuarios($p_usuario_id,$p_usuario,$p_identificacion,$p_nombres,$p_apellidos,$p_direccion,$p_telefono,$p_estados_usuario_id,$p_fecharegistro,$p_clave,$p_correo,$p_perfil_id);
		$info = $usuario->validaUsuario();
		if ($usuario->getCodigoRespuesta() == $p_codigo_respuesta_exitosa){

			$usuario->getPerfilUsuario();
			$_SESSION['sesion'] 	= "TRUE";
			$_SESSION['usuario_id']	= $usuario->getUsuarioId();
			$_SESSION['usuario'] 	= $usuario->getUsuario();
			$_SESSION['nombres'] 	= $usuario->getNombres();
			$_SESSION['apellidos'] 	= $usuario->getApellidos();
			$_SESSION['perfil'] 	= $usuario->getPerfil();
			$_SESSION['getPerfilId'] 	= $usuario->getPerfilId();
			$_SESSION['estados_usuario_id'] 	= $usuario->getEstadosUsuarioId();

			
			// $principal = 0;
			require_once 'clases/Menus.php';
			$menus = new Menus($usuario->getPerfilId());
			$arreglo = $menus->getMenu();
			$ruta_url = $arreglo['url_principal'];
			
			$usuario ->setReiniciaIntentosfallidos($usuario->getUsuarioId());
		

			// echo "la session es:".$session_id;
			$usuario ->setSessionUsuario($session_id,$usuario->getUsuarioId(),$usuario->getUsuario(),$usuario->getPerfilId(),$usuario->getNombres(),$usuario->getApellidos(),$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$usuario->getCodigoRespuesta());
			// exit();

			 header("Location: ".$ruta_url);
		}else{
			$message = "Error:".$usuario->getCodigoRespuesta().":".$usuario->getMensajeRespuesta() ;
		
			$usuario ->setSessionUsuario($session_id,null,$p_usuario,null,$usuario->getNombres(),$usuario->getApellidos(),$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$message);
			
			if($usuario->getCodigoRespuesta() == '02'){
				$usuario ->setIncrementaIntentosfallidos($usuario->getUsuarioId());
			}

			session_destroy();

			 
			 echo '<script>alert(\''.$message.'\'); window.location.href="index.php"</script>'; 
		}
	} else {
	 $message = "Los campos de Usuario y Clave son Requeridos";
	}
 }
?>