<?php
include("control.php");
include("include/config.php");
//  var_dump($_POST);
  
if($_POST)
 {
	require_once 'clases/Usuarios.php';
	$p_usuario_id = NULL;
	$p_fecharegistro = NULL;
	//$p_usuario_id = $_POST['usuario_id'];
	$p_usuario = $_POST['usuario'];
	$p_identificacion = $_POST['identificacion'];
	$p_nombres = $_POST['nombres'];
	$p_apellidos = $_POST['apellidos'];
	$p_direccion = $_POST['direccion'];
	$p_telefono = $_POST['telefono'];
	$p_estados_usuario_id = $_POST['estados_usuario_id'];
	//$p_fecharegistro = $_POST['fecharegistro'];
	$p_clave = $_POST['clave'];
	$p_correo = $_POST['correo'];
	$p_perfil_id = $_POST['perfil_id'];
	
	if(!empty($p_usuario) && !empty($p_clave) && !empty($p_correo)) {

	$usuario = new Usuarios($p_usuario_id,$p_usuario,$p_identificacion,$p_nombres,$p_apellidos,$p_direccion,$p_telefono,$p_estados_usuario_id,$p_fecharegistro,$p_clave,$p_correo,$p_perfil_id);
							
            $usuario->guardarRegistrar();
            // echo $usuario->getUsuario() . ' se ha guardado correctamente con el id: ' . $usuario->getUsuarioId();
            //crea instancia de sesion segura
             $_SESSION['usuario']=$_POST['usuario'];//variable de sesion;
			 $_SESSION['nombres']=$this->nombres;//variable de sesion;
			 $_SESSION['apellidos']=$this->apellidos;//variable de sesion;
            # si usuario existe -> redireccionar a nueva pagina 
            // echo 'Exito: Usuario '.$_SESSION['usuario'].' logueado';
			$message = $usuario->getMensajeRespuesta();
	}else{
		$message = "Parametros Incompletos";
	}
}
?>
<html>
<head>
<meta charset="utf-8">
<title>Portal Routeros</title>
<link href="estilos/ingreso.css" rel="stylesheet" type="text/css">
</head>
<div>BIENVENIDO</div>
<?php
//echo $this->nombres." ".$this->apellidos;

//echo $_SESSION['nombres'];
?>
<form id="form" name="form" method="post" action="">
<span>Usuario</span>
<br />
<input id="usuario" name="usuario" type="text" value="" />
<br />
<span>Contraseña</span>
<br />
<input id="clave" name="clave" type="password" value="" />
<br />
<span>Nombres</span>
<br />
<input id="nombres" name="nombres" type="text" value="" />
<br />
<span>Apellidos</span>
<br />
<input id="apellidos" name="apellidos" type="text" value="" />
<br />
<span>Identificacion</span>
<br />
<input id="identificacion" name="identificacion" type="text" value="" />
<br />
<span>Direccion</span>
<br />
<input id="direccion" name="direccion" type="text" value="" />
<br />
<span>Telefono</span>
<br />
<input id="telefono" name="telefono" type="text" value="" />
<br />
<span>Correo</span>
<br />
<input id="correo" name="correo" type="text" value="" />
<br />
<input id="estados_usuario_id" name="estados_usuario_id" type="hidden" value="1" />
<input id="perfil_id" name="perfil_id" type="hidden" value="1" />
<input name="enviar" id="enviar" type="submit" value="Entrar" />
<input name="enviar" id="enviar" type="submit" value="Salir" />
 
</form>

<?php if (!empty($message)) {echo "<p class=\"error\">" . " ". $message . "</p>";} ?>
