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
		require_once 'clases/Usuarios.php';
		$usuario = new Usuarios($p_usuario_id,$p_usuario,$p_identificacion,$p_nombres,$p_apellidos,$p_direccion,$p_telefono,$p_estados_usuario_id,$p_fecharegistro,$p_clave,$p_correo,$p_perfil_id);
		$usuario->validaUsuario();
		if ($usuario->getCodigoRespuesta() == $p_codigo_respuesta_exitosa){
			
			$usuario->getPerfilUsuario();
			$_SESSION["sesion"] 	= "TRUE";
			$_SESSION["usuario"] 	= $usuario->getUsuario();
			$_SESSION["nombres"] 	= $usuario->getNombres();
			$_SESSION["apellidos"] 	= $usuario->getApellidos();
			$_SESSION["perfil"] 	= $usuario->getPerfil();
			
			$principal = 0;
			require_once 'clases/Menus.php';
			$menus = new Menus($usuario->getPerfilId());
			$arreglo = $menus->getMenusNivelUno();
			foreach($arreglo as $llave=>$elemento){
				$menu_id = $arreglo[$llave]['menu_id'];
				if($principal == '0'){
					$principal = $arreglo[$llave]['principal'];
					if($principal == '1'){
						$ruta_url = $arreglo[$llave]['ruta_url'];
					}
				}
				
				if($menu_id > 0){
					$arreglo[$llave]['submenu'] = $menus->getMenusNivelDos($menu_id);
					if($principal == '0'){
						foreach($arreglo[$llave]['submenu'] as $key=>$item){
							$principal = $arreglo[$llave]['submenu'][$key]['principal'];
							if($principal == '1'){
								$ruta_url = $arreglo[$llave]['submenu'][$key]['ruta_url'];
							}
						}
					}

				}
			}
			
 // echo "<pre>";
 // print_r($arreglo);
 // echo "</pre>";			
			 $_SESSION["menuPerfil"] 	= $arreglo;


			
			// $message = $usuario->getMensajeRespuesta().": ".$usuario->getCodigoRespuesta() ;
			 // header("Location: registrarusuarios.php");
			 header("Location: ".$ruta_url);
		}else{
			$message = $usuario->getMensajeRespuesta().":".$usuario->getCodigoRespuesta() ;
			session_destroy();
			 echo"<script>alert('Usuario no Existe o la contrase\u00f1a no es correcta.'); window.location.href=\"index.php\"</script>"; 

			// header("Location: index.php");
		}

	 

	} else {
	 $message = "Los campos de Usuario y Clave son Requeridos";
	// echo $message;
	}
}
?>