<?php
 require_once 'Conexion.php';
 class Usuarios {
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
	private $keyconfig = '$UjhY&743*#4#r1+u38s';
	private $reintentos = 3;
	
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
    }
	
	
	
	public function guardarRegistrar(){
		$conexion = new Conexion();
		
		//echo 'client version: ', $conexion->getAttribute(PDO::ATTR_CLIENT_VERSION), "\n";
		 //echo 'server version: ', $conexion->getAttribute(PDO::ATTR_SERVER_VERSION), "\n";
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		if($this->usuario_id) {
			$sql = $conexion->prepare('UPDATE ' . self::TABLA .' SET usuario = :usuario, clave = :clave WHERE usuario_id = :usuario_id');
			$sql->bindParam(':usuario', $this->usuario);
			$sql->bindParam(':clave', $this->clave);
			$sql->bindParam(':usuario_id', $this->usuario_id);
			

			$sql->execute();
		
		}else {
			try {
				$sql = $conexion->prepare(
						'INSERT INTO ' . self::TABLA .
						' (	 usuario
							,identificacion
							,nombres
							,apellidos
							,direccion
							,telefono
							,estados_usuario_id
							,fecharegistro
							,clave
							,correo
							,perfil_id
						) VALUES(
							:usuario
							,:identificacion
							,:nombres
							,:apellidos
							,:direccion
							,:telefono
							,:estados_usuario_id
							,:fecharegistro
							,:clave
							,:correo
							,:perfil_id
						)
						');
				$sql->bindParam(':usuario', $this->usuario);
				$sql->bindParam(':identificacion', $this->identificacion);
				$sql->bindParam(':nombres', $this->nombres);
				$sql->bindParam(':apellidos', $this->apellidos);
				$sql->bindParam(':direccion', $this->direccion);
				$sql->bindParam(':telefono', $this->telefono);
				$sql->bindParam(':estados_usuario_id', $this->estados_usuario_id);
				$sql->bindParam(':fecharegistro', $this->fecharegistro);
				$sql->bindParam(':clave', $this->clave);
				$sql->bindParam(':correo', $this->correo);
				$sql->bindParam(':perfil_id', $this->perfil_id);
				
				
				$sql->execute();
				$this->usuario_id = $conexion->lastInsertId();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Se ha registrado el usuario ".$this->usuario." correctamente";
			}catch (PDOException $e) {
				echo "<br>guardarRegistrar::DataBase Error: <br>".$e->getMessage();
				echo "<br>Error Code:<br> ".$e->getCode();
				$this->codigoRespuesta = $e->getCode();
				$this->mensajeRespuesta = $e->getMessage();
			  //  var_dump($e->getMessage());
				//var_dump($conexion->errorInfo());
				exit;
			}catch (Exception $e) {
				$this->codigoRespuesta = $e->getCode();
				$this->mensajeRespuesta = $e->getMessage();
				echo "guardarRegistrar::General Error: The user could not be added.<br>".$e->getMessage();
				exit;
			}
		}

		$conexion = null;
	}
	
	public function validaUsuario(){
		$conexion = new Conexion();
		
		 // echo 'client version: ', $conexion->getAttribute(PDO::ATTR_CLIENT_VERSION), "\n";
		 // echo 'server version: ', $conexion->getAttribute(PDO::ATTR_SERVER_VERSION), "\n";
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		if($this->usuario && $this->clave) {
			try {
				$this->codigoRespuesta = "01";
				$this->mensajeRespuesta = "USUARIO O CLAVE NO VALIDO:";
				$sql = $conexion->prepare('SELECT usuario_id,nombres,apellidos,perfil_id,estados_usuario_id,intentos_fallidos FROM ' . self::TABLA .' WHERE usuario = :usuario');
				$sql->bindParam(':usuario', $this->usuario);
				
	//			var_dump($sql);

				$sql->execute();
				$resultado = $sql->fetchAll();
//exit;
				foreach ($resultado as $row) {
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
					}elseif($this->intentos_fallidos >= $this->reintentos){
						$this->setCambiaEstadoUsuario($this->usuario_id,$nuevo_estado_usuario);
						$this->codigoRespuesta 		= "13";
						$this->mensajeRespuesta 	= "Ha superado los ".$this->reintentos." Intentos maximos, Esta en ".$this->intentos_fallidos."";
						
						$nuevo_estado_usuario = 3;
						

					}else{
						
						$this->codigoRespuesta = "02";
						$this->mensajeRespuesta = "Clave no Valida:";
						$sql = $conexion->prepare('SELECT usuario_id,nombres,apellidos,perfil_id,estados_usuario_id,intentos_fallidos FROM ' . self::TABLA .' WHERE usuario = :usuario AND clave = AES_ENCRYPT(:clave,:keyconfig) ');
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
				// echo $this->usuario." ".$this->clave."".$this->intentos_fallidos;
				// exit();
				return $resultado;
			}catch (PDOException $e) {
				echo "<br>validaUsuario::DataBase Error: <br>".$e->getMessage();
				echo "<br>Error Code:<br> ".$e->getCode();
			  //  var_dump($e->getMessage());
				//var_dump($conexion->errorInfo());
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
		$conexion = new Conexion();
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "33";
			$this->mensajeRespuesta = "Perfil no definido: ";
			$sql = $conexion->prepare('SELECT perfil,descripcion,estados_perfil_id FROM perfiles WHERE perfil_id = :perfil_id');
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
		$conexion = new Conexion();
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			
			$this->codigoRespuesta = "44";
			$this->mensajeRespuesta = "Error Actualizando los reintentos: ";
			$sql = $conexion->prepare('UPDATE usuarios SET intentos_fallidos = intentos_fallidos+1 WHERE usuario_id = :usuario_id');
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
		$conexion = new Conexion();
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			
			$this->codigoRespuesta = "45";
			$this->mensajeRespuesta = "Error Actualizando los reintentos: ";
			$sql = $conexion->prepare('UPDATE usuarios SET intentos_fallidos = 0 WHERE usuario_id = :usuario_id');
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
		$conexion = new Conexion();
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			
			// $this->codigoRespuesta = "00";
			$this->mensajeRespuesta = "Error Actualizando estado usuario: ";
			$sql = $conexion->prepare('UPDATE usuarios SET estados_usuario_id = :estados_usuario_id WHERE usuario_id = :usuario_id');
			$sql->bindParam(':usuario_id', $this->usuario_id);
			$sql->bindParam(':estados_usuario_id', $this->estados_usuario_id);
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
		$conexion = new Conexion();
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			
			
			$this->mensajeRespuesta = "Error Actualizando estado usuario: ";
			// $sql = $conexion->prepare('UPDATE usuarios SET clave = AES_ENCRYPT(\''.$clave.'\',\''.$this->keyconfig.'\') WHERE usuario_id = '.$usuario_id);
			$sql = $conexion->prepare('UPDATE usuarios SET clave = AES_ENCRYPT(:clave,:keyconfig) WHERE usuario_id = :usuario_id');
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
			echo "<br>setCambiaEstadoUsuario::DataBase Error: ".$usuario_id." clave = ".$clave."<br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "setCambiaEstadoUsuario::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		$conexion = null;
		
	}
			
 }
?>