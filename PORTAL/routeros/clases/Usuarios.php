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
				$sql = $conexion->prepare('SELECT nombres,apellidos,perfil_id FROM ' . self::TABLA .' WHERE usuario = :usuario AND clave = AES_ENCRYPT(:clave,:keyconfig) ');
				$sql->bindParam(':usuario', $this->usuario);
				$sql->bindParam(':clave', $this->clave);
				$sql->bindParam(':keyconfig', $this->keyconfig);
	//			var_dump($sql);
//echo $this->usuario." ".$this->clave."".$this->keyconfig;
				$sql->execute();
				$resultado = $sql->fetchAll();
//exit;
				foreach ($resultado as $row) {
					$this->codigoRespuesta 	= "00";
					$this->mensajeRespuesta = "Usuario valido";
					$this->perfil_id 		= $row["perfil_id"];
					$this->nombres 			= $row["nombres"];
					$this->apellidos 		= $row["apellidos"];
		
				}
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
			$sql = $conexion->prepare('SELECT perfil,descripcion,estados_perfil_id FROM perfiles WHERE perfil_id = '.$this->perfil_id);
			$sql->bindParam(':perfil_id', $this->perfil_id);
			$sql->execute();
			$resultado = $sql->fetchAll();
			// echo "<pre>";
			// print_r($resultado);
			// echo "</pre>";
			foreach ($resultado as $row) {
				if($row["estados_perfil_id"] <> 1){
					$this->codigoRespuesta 		= "22";
					$this->mensajeRespuesta 	= "Perfil Asignado no esta activo";
				}else{
					$this->codigoRespuesta 		= "00";
					$this->mensajeRespuesta 	= "Perfil Correcto";
					$this->perfil 				= $row["perfil"];
					// $this->descripcionPerfil	= $row["descripcion"];
					// $this->estados_perfil_id 	= $row["estados_perfil_id"];
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
	
	
			
 }
?>