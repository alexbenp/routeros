<?php
 require_once 'Conexion.php';
 require_once("Configuraciones.php");
 class Usuarios extends Conexion {
    private $usuario_id;
    private $usuario;
    private $identificacion;
    private $nombres;
    private $apellidos;
    private $direccion;
    private $telefono;
    private $estados_usuario_id;
    private $fecharegistro;
    private $clave;
    private $correo;
    private $perfil_id;
	private $keyconfig;
	private $Configuraciones;
	private $conexion;
	
    const TABLA = 'usuarios';
    
	public function getUsuarioId() {
		return $this->usuario_id;
	}
	public function getUsuario() {
		return $this->usuario;
	}
	public function getIdentificacion() {
		return $this->identificacion;
	}
	public function getNombres() {
		return $this->nombres;
	}
	public function getApellidos() {
		return $this->apellidos;
	}
	public function getDireccion() {
		return $this->direccion;
	}
	public function getTelefono() {
		return $this->telefono;
	}
	public function getEstadosUsuarioId() {
		return $this->estados_usuario_id;
	}
	public function getFecharegistro() {
		return $this->fecharegistro;
	}
	public function getClave() {
		return $this->clave;
	}
	public function getCorreo() {
		return $this->correo;
	}
	public function getPerfilId() {
		return $this->perfil_id;
	}
	public function getPerfil() {
		return $this->perfil;
	}
	public function getCodigoRespuesta() {
		return $this->codigoRespuesta;
	}
	public function getMensajeRespuesta() {
		return $this->mensajeRespuesta;
	}
	public function getCodigoRespuestaSession() {
		return $this->codigoRespuestaSession;
	}
	public function getMensajeRespuestaSession() {
		return $this->mensajeRespuestaSession;
	}

	public function __construct($usuario_id=null,$usuario,$identificacion=NULL,$nombres=NULL,$apellidos=NULL,$direccion=NULL,$telefono=NULL,$estados_usuario_id,$fecharegistro,$clave,$correo,$perfil_id) {
		$this->usuario_id = $usuario_id;
		$this->usuario = $usuario;
		$this->identificacion = $identificacion;
		$this->nombres = $nombres;
		$this->apellidos = $apellidos;
		$this->direccion = $direccion;
		$this->telefono = $telefono;
		$this->estados_usuario_id = $estados_usuario_id;
		$this->fecharegistro = $fecharegistro;
		$this->clave = $clave;
		$this->correo = $correo;
		$this->perfil_id = $perfil_id;
		$this->conexion = new Conexion();
		$this->Configuraciones = new Configuraciones ();
    }
	
	
	public function setUsuarioPortal($usuario_id,$usuario,$identificacion,$nombres,$apellidos,$direccion,$telefono,$estados_usuario_id,$clave,$correo,$perfil_id,$usuario_registro_id){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		

		$this->keyconfig =  $this->Configuraciones->getKeyConfig("LLAVE");
		try {
			$this->codigoRespuesta = "11";
			$this->mensajeRespuesta = "Registro Usuarios Portal: ";
			
			// echo "nameRouter:".$nameRouter." ipRouter:".$ipRouter." usuarioRouter:".$usuarioRouter." claveRouter:".$claveRouter."$ puertoRouter:".$puertoRouter." versionRouter:".$versionRouter." reintentosCx:".$reintentosCx." retrasoCx:".$retrasoCx." tiempoMaximoCx:".$tiempoMaximoCx."<br>";
			
			if (($usuario=="")||($identificacion=="")||($nombres=="")||($apellidos=="")||($direccion=="")||($telefono=="")||($estados_usuario_id=="")||($correo=="")||($perfil_id=="")) 
			{
				$this->codigoRespuesta = "12";
				$this->mensajeRespuesta = "Informacion Incompleta para Crear el Usuario Portal ";
			}else{
				
				if($usuario_id > 0){
					$sql = $this->conexion->prepare('UPDATE '. self::TABLA .' SET usuario = :usuario, identificacion = :identificacion, nombres = :nombres, apellidos = :apellidos, direccion = :direccion, telefono = :telefono, estados_usuario_id = :estados_usuario_id, correo = :correo, perfil_id = :perfil_id, usuario_registro_id = :usuario_registro_id WHERE usuario_id = :usuario_id');
						$sql->bindParam(':usuario_id', $usuario_id);
						$sql->bindParam(':usuario', $usuario);
						$sql->bindParam(':identificacion', $identificacion);
						$sql->bindParam(':nombres', $nombres);
						$sql->bindParam(':apellidos', $apellidos);
						$sql->bindParam(':direccion', $direccion);
						$sql->bindParam(':telefono', $telefono);
						$sql->bindParam(':estados_usuario_id', $estados_usuario_id);
						$sql->bindParam(':correo', $correo);
						$sql->bindParam(':perfil_id', $perfil_id);
						$sql->bindParam(':usuario_registro_id', $usuario_registro_id);
					
					$sql->execute();
					// $resultado = $sql->fetchAll();
					$this->codigoRespuesta = "00";
					$this->mensajeRespuesta = "Resultado Actualización Exitoso: ";	
					$lastInsertId = usuario_id;
				}else{
					if($clave ==""){
						$this->codigoRespuesta = "13";
						$this->mensajeRespuesta = "Informacion Incompleta para Crear el Usuario Portal clave ";
					}else{
						$sql = $this->conexion->prepare('INSERT INTO '. self::TABLA .' (usuario, identificacion, nombres, apellidos, direccion, telefono, estados_usuario_id, clave, correo, perfil_id, usuario_registro_id) VALUES (lower(:usuario), :identificacion, :nombres, :apellidos, :direccion, :telefono, :estados_usuario_id, AES_ENCRYPT(:clave,:keyconfig), lower(:correo), :perfil_id, :usuario_registro_id)');
						$sql->bindParam(':usuario', $usuario);
						$sql->bindParam(':identificacion', $identificacion);
						$sql->bindParam(':nombres', $nombres);
						$sql->bindParam(':apellidos', $apellidos);
						$sql->bindParam(':direccion', $direccion);
						$sql->bindParam(':telefono', $telefono);
						$sql->bindParam(':estados_usuario_id', $estados_usuario_id);
						$sql->bindParam(':clave', $clave);
						$sql->bindParam(':keyconfig', $this->keyconfig);
						$sql->bindParam(':correo', $correo);
						$sql->bindParam(':perfil_id', $perfil_id);
						$sql->bindParam(':usuario_registro_id', $usuario_registro_id);
						$sql->execute();
						$this->codigoRespuesta = "00";
						$this->mensajeRespuesta = "Resultado Registro Exitoso: ";
						$lastInsertId = $this->conexion->lastInsertId();
					}
				}
				

				 $conexion = null;
			return $lastInsertId;
			}
		}catch (PDOException $e) {
			echo "<br>setRouter::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "setRouter::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		
	}
	
	
	public function validaUsuario(){
		
		 // echo 'client version: ', $this->conexion->getAttribute(PDO::ATTR_CLIENT_VERSION), "\n";
		 // echo 'server version: ', $this->conexion->getAttribute(PDO::ATTR_SERVER_VERSION), "\n";
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		if($this->usuario && $this->clave) {
			try {
				$this->keyconfig = $this->Configuraciones->getKeyConfig("REINTENTOS_FALLIDOS_USUARIO");
				
				$this->codigoRespuesta = "01";
				$this->mensajeRespuesta = "USUARIO O CLAVE NO VALIDO:";
				$sql = $this->conexion->prepare('SELECT usuario_id,nombres,apellidos,perfil_id,estados_usuario_id,intentos_fallidos FROM ' . self::TABLA .' WHERE usuario = :usuario');
				$sql->bindParam(':usuario', $this->usuario);
				
	//			var_dump($sql);

				$sql->execute();
				$resultado = $sql->fetchAll();
				
				$cantidad = count($resultado);
				if($cantidad>0){
					
				
//exit;
					foreach ($resultado as $row) {
						// echo "entra<br>";
						$this->usuario_id 		= $row['usuario_id'];
						$this->perfil_id 		= $row['perfil_id'];
						$this->nombres 			= $row['nombres'];
						$this->apellidos 		= $row['apellidos'];
						$this->estados_usuario_id = $row['estados_usuario_id'];
						$this->intentos_fallidos = $row['intentos_fallidos'];
						// // echo $this->intentos_fallidos."--- ";
						// exit();
						if($row['estados_usuario_id'] == 2){
							$this->codigoRespuesta 		= "11";
							$this->mensajeRespuesta 	= "Usuario Inactivo";
						}elseif($row['estados_usuario_id'] == 3){
							$this->codigoRespuesta 		= "12";
							$this->mensajeRespuesta 	= "Usuario Bloqueado";						
						}elseif($this->intentos_fallidos >= $this->keyconfig){
							$nuevo_estado_usuario = 3;
							$this->setCambiaEstadoUsuario($this->usuario_id,$nuevo_estado_usuario);
							
							$this->codigoRespuesta 		= "13";
							$this->mensajeRespuesta 	= ":Ha superado los ".$this->keyconfig." Intentos maximos, Esta en ".$this->intentos_fallidos."";
							
							
							

						}else{
							$this->keyconfig = $this->Configuraciones->getKeyConfig("LLAVE");
							$this->codigoRespuesta = "02";
							$this->mensajeRespuesta = "Clave no Valida:";
							
							
							
							$sql = $this->conexion->prepare('SELECT usuario_id,nombres,apellidos,perfil_id,estados_usuario_id,intentos_fallidos FROM ' . self::TABLA .' WHERE usuario = :usuario AND clave = AES_ENCRYPT(:clave,:keyconfig) ');
							$sql->bindParam(':usuario', $this->usuario);
							$sql->bindParam(':clave', $this->clave);
							$sql->bindParam(':keyconfig', $this->keyconfig);
							$sql->execute();
							$informacion = $sql->fetchAll();
							
							foreach ($informacion as $linea){
								$this->codigoRespuesta 	= "00";
								$this->mensajeRespuesta = "Usuario valido";
								$this->usuario_id 		= $linea['usuario_id'];
								$this->perfil_id 		= $linea['perfil_id'];
								$this->nombres 			= $linea['nombres'];
								$this->apellidos 		= $linea['apellidos'];
								$this->estados_usuario_id = $linea['estados_usuario_id'];
								$this->intentos_fallidos = $linea['intentos_fallidos'];
							}
						}
					}
				}else{
					$this->codigoRespuesta = "04";
					$this->mensajeRespuesta = "Usuario no Existe:";
				}
				// echo $this->usuario." ".$this->clave."".$this->intentos_fallidos;
				// exit();
				return $resultado;
			}catch (PDOException $e) {
				echo "<br>validaUsuario::DataBase Error: <br>".$e->getMessage();
				echo "<br>Error Code:<br> ".$e->getCode();
			  //  var_dump($e->getMessage());
				//var_dump($this->conexion->errorInfo());
				exit;
			}catch (Exception $e) {
				echo "validaUsuario::General Error: The user could not be added.<br>".$e->getMessage();
				exit;
			}
		}else{
			$this->codigoRespuesta = "99";
			$this->mensajeRespuesta = "Parametros Incompletos";
		}
		$conexion = null;
	}
	
	public function getPerfilUsuario(){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "33";
			$this->mensajeRespuesta = "Perfil no definido: ";
			$sql = $this->conexion->prepare('SELECT perfil,descripcion,estados_perfil_id FROM perfiles WHERE perfil_id = :perfil_id');
			$sql->bindParam(':perfil_id', $this->perfil_id);
			$sql->execute();
			$resultado = $sql->fetchAll();
			// echo "<pre>";
			// print_r($resultado);
			// echo "</pre>";
			foreach ($resultado as $row) {
				if($row['estados_perfil_id'] <> 1){
					$this->codigoRespuesta 		= "22";
					$this->mensajeRespuesta 	= "Perfil Asignado no esta activo";
				}else{
					$this->codigoRespuesta 		= "00";
					$this->mensajeRespuesta 	= "Perfil Correcto";
					$this->perfil 				= $row['perfil'];
					// $this->descripcionPerfil	= $row['descripcion'];
					// $this->estados_perfil_id 	= $row['estados_perfil_id'];
				}
			}
		}catch (PDOException $e) {
			echo "<br>getPerfilUsuario::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "getPerfilUsuario::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		$conexion = null;
	}		
	
	public function setIncrementaIntentosfallidos($usuario_id){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			
			$this->codigoRespuesta = "44";
			$this->mensajeRespuesta = "Error Actualizando los reintentos: ";
			$sql = $this->conexion->prepare('UPDATE usuarios SET intentos_fallidos = intentos_fallidos+1 WHERE usuario_id = :usuario_id');
			$sql->bindParam(':usuario_id', $this->usuario_id);
			$sql->execute();
	
			
		}catch (PDOException $e) {
			echo "<br>setIncrementaIntentosfallidos::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "setIncrementaIntentosfallidos::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		$conexion = null;
		
	}
	
	public function setReiniciaIntentosfallidos($usuario_id){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			
			$this->mensajeRespuesta = "Error Actualizando los reintentos: ";
			$sql = $this->conexion->prepare('UPDATE usuarios SET intentos_fallidos = 0 WHERE usuario_id = :usuario_id');
			$sql->bindParam(':usuario_id', $this->usuario_id);
			$sql->execute();
	
			
		}catch (PDOException $e) {
			echo "<br>setReiniciaIntentosfallidos::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "setReiniciaIntentosfallidos::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		$conexion = null;
		
	}
	
	public function setCambiaEstadoUsuario($usuario_id,$estados_usuario_id){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			
			// $this->codigoRespuesta = "00";
			$this->mensajeRespuesta = "Error Actualizando estado usuario: ";
			$sql = $this->conexion->prepare('UPDATE usuarios SET estados_usuario_id = :estados_usuario_id WHERE usuario_id = :usuario_id');
			$sql->bindParam(':usuario_id', $usuario_id);
			$sql->bindParam(':estados_usuario_id', $estados_usuario_id);
			$sql->execute();
	
		}catch (PDOException $e) {
			echo "<br>setCambiaEstadoUsuario::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "setCambiaEstadoUsuario::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		$conexion = null;
		
	}
	
	public function setClave($usuario_id,$clave){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			
			
			$this->mensajeRespuesta = "Error Actualizando estado usuario: ";
			$this->keyconfig = $this->Configuraciones->getKeyConfig("LLAVE");
			$sql = $this->conexion->prepare('UPDATE usuarios SET clave = AES_ENCRYPT(:clave,:keyconfig) WHERE usuario_id = :usuario_id');
			$sql->bindParam(':clave', $clave);
			$sql->bindParam(':keyconfig', $this->keyconfig);
			$sql->bindParam(':usuario_id', $usuario_id);
			$sql->execute();
			// echo "<pre>";
			// print_r($sql);
			// echo "</pre>";
			
			$resultado = '00';
			return $resultado;
			
		}catch (PDOException $e) {
			echo "<br>setClave::DataBase Error: ".$usuario_id."<br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "setClave::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		$conexion = null;
		
	}
	
	public function setSessionUsuario($session_id,$usuario_id,$usuario,$perfil_id,$nombres,$apellidos,$ip,$navegador,$respuesta){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			
			$this->codigoRespuestaSession = "55";
			$this->mensajeRespuestaSession = "Error registrando session: ";
			$sql = $this->conexion->prepare('INSERT INTO ingresos (session_id, usuario_id, perfil_id, usuario, nombres, apellidos, ip, navegador,mensaje_ingreso) VALUES (:session_id, :usuario_id, :perfil_id, :usuario, :nombres, :apellidos, :ip, :navegador, :mensaje_ingreso)');
			$sql->bindParam(':session_id', $session_id);
			$sql->bindParam(':usuario_id', $usuario_id);
			$sql->bindParam(':perfil_id', $perfil_id);
			$sql->bindParam(':usuario', $usuario);
			$sql->bindParam(':nombres', $nombres);
			$sql->bindParam(':apellidos', $apellidos);
			$sql->bindParam(':ip', $ip);
			$sql->bindParam(':navegador', $navegador);
			$sql->bindParam(':mensaje_ingreso', $respuesta);
			$sql->execute();

			$resultado = '00';
			return $resultado;
			
		}catch (PDOException $e) {
			echo "<br>setSessionUsuario::DataBase Error: ".$usuario_id."<br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "setSessionUsuario::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		$conexion = null;
		
	}
	
	public function getAllUsers($estados_usuario_id){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "56";
			$this->mensajeRespuesta = "Error Consultado los usuarios: ";
			if($estados_usuario_id > 0){
				$sql = $this->conexion->prepare('SELECT u.usuario_id, u.usuario, u.identificacion, u.nombres, u.apellidos, u.direccion, u.telefono, u.estados_usuario_id, eu.estado, u.fecharegistro, u.correo, u.perfil_id, p.perfil, u.intentos_fallidos FROM ' . self::TABLA .' u INNER JOIN perfiles p ON (u.perfil_id = p.perfil_id) INNER JOIN estados_usuario eu ON (u.estados_usuario_id = eu.estados_usuario_id) WHERE u.estados_usuario_id = :estados_usuario_id');
				$sql->bindParam(':estados_usuario_id', $estados_usuario_id);
				$sql->execute();				
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Consulta Exitosa.: ";
			}else{
				$sql = $this->conexion->prepare('SELECT u.usuario_id, u.usuario, u.identificacion, u.nombres, u.apellidos, u.direccion, u.telefono, u.estados_usuario_id, eu.estado, u.fecharegistro, u.correo, u.perfil_id, p.perfil, u.intentos_fallidos FROM ' . self::TABLA .' u INNER JOIN perfiles p ON (u.perfil_id = p.perfil_id) INNER JOIN estados_usuario eu ON (u.estados_usuario_id = eu.estados_usuario_id)');
				$sql->execute();				
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Consulta Exitosa: ";
			}
			$conexion = null;
			return $resultado;
			
		}catch (PDOException $e) {
			echo "<br>getAllUsers::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "getAllUsers::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		
		
	}	
		
	public function getEstadosUsuario(){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "22";
			$this->mensajeRespuesta = "Estados Usuarios: ";
			$sql = $this->conexion->prepare('SELECT estados_usuario_id,estado as estado_usuario FROM estados_usuario');
			$sql->execute();
			$resultado = $sql->fetchAll();

			return $resultado;

		}catch (PDOException $e) {
			echo "<br>getEstadosUsuario::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "getEstadosUsuario::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		
	}
	
	
	public function getAllPerfilUsuario($estados_perfil_id){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "34";
			$this->mensajeRespuesta = "Perfiles de Usuarios: ";
			
			if($estados_perfil_id>0){
				$sql = $this->conexion->prepare('SELECT p.perfil_id,p.perfil,p.descripcion,p.estados_perfil_id,ep.estado as estado_perfil FROM perfiles p INNER JOIN estados_perfil ep ON (p.estados_perfil_id = ep.estados_perfil_id) WHERE estados_perfil_id = :estados_perfil_id');
				$sql->bindParam(':estados_perfil_id', $estados_perfil_id);
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Consulta Exitosa Perfiles: ";
			}else{
				$sql = $this->conexion->prepare('SELECT p.perfil_id,p.perfil,p.descripcion,p.estados_perfil_id,ep.estado as estado_perfil FROM perfiles p INNER JOIN estados_perfil ep ON (p.estados_perfil_id = ep.estados_perfil_id)');
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Consulta Exitosa Perfiles: ";
			}
			$sql->execute();
			$resultado = $sql->fetchAll();

			return $resultado;

		}catch (PDOException $e) {
			echo "<br>getAllPerfilUsuario::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "getAllPerfilUsuario::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		
	}

	public function getUsuarioPortal($usuario,$correo){

		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "47";
			$this->mensajeRespuesta = "Error Consulta Usuario: ";
			
			if(!empty($usuario)){
				$consulta = 1;
				if(!empty($correo)){
					$consulta = 2;
				}
			}else{
				if(!empty($correo)){
					$consulta = 3;
				}
			}
			
			if($consulta == 1){
				$sql = $this->conexion->prepare('SELECT u.usuario_id, u.usuario, u.identificacion, u.nombres, u.apellidos, u.direccion, u.telefono, u.estados_usuario_id, eu.estado, u.fecharegistro, u.correo, u.perfil_id, p.perfil, u.intentos_fallidos FROM usuarios u INNER JOIN perfiles p ON (u.perfil_id = p.perfil_id) INNER JOIN estados_usuario eu ON (u.estados_usuario_id = eu.estados_usuario_id) WHERE u.usuario = :usuario');
				$sql->bindParam(':usuario', $usuario);
				$sql->execute();
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Consulta Usuario: ";
			}elseif($consulta == 2){
				$sql = $this->conexion->prepare('SELECT u.usuario_id, u.usuario, u.identificacion, u.nombres, u.apellidos, u.direccion, u.telefono, u.estados_usuario_id, eu.estado, u.fecharegistro, u.correo, u.perfil_id, p.perfil, u.intentos_fallidos  FROM usuarios u INNER JOIN perfiles p ON (u.perfil_id = p.perfil_id) INNER JOIN estados_usuario eu ON (u.estados_usuario_id = eu.estados_usuario_id) WHERE u.usuario = :usuario AND u.correo = :correo');
				$sql->bindParam(':usuario', $usuario);
				$sql->bindParam(':correo', $correo);
				$sql->execute();
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Consulta Usuario: ";
			}elseif($consulta == 3){
				$sql = $this->conexion->prepare('SELECT u.usuario_id, u.usuario, u.identificacion, u.nombres, u.apellidos, u.direccion, u.telefono, u.estados_usuario_id, eu.estado, u.fecharegistro, u.correo, u.perfil_id, p.perfil, u.intentos_fallidos FROM usuarios u INNER JOIN perfiles p ON (u.perfil_id = p.perfil_id) INNER JOIN estados_usuario eu ON (u.estados_usuario_id = eu.estados_usuario_id) WHERE u.correo = :correo');
				$sql->bindParam(':correo', $correo);
				$sql->execute();
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Consulta Usuario: ";
			}else{
					$this->codigoRespuesta 		= "53";
					$this->mensajeRespuesta 	= "Consulta no definida";
			}
			$conexion = null;
			return $resultado;
		}catch (PDOException $e) {
			echo "<br>getUsuarioPortal::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "getUsuarioPortal::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		$conexion = null;
	}	
	
 }
?>