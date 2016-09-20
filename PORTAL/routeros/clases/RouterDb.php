<?php
require_once 'Conexion.php';
class RoutersDb extends Conexion {
	private $router_id;
	private $usuario_id;
	private $estados_router_id;
	private $conexion;
	const TABLA = 'routers';
	
	public function getCodigoRespuesta() {
		return $this->codigoRespuesta;
	}
	public function getMensajeRespuesta() {
		return $this->mensajeRespuesta;
	}
	
	public function __construct($router_id=null,$usuario_id=null) {
		$this->router_id = $router_id;
		$this->usuario_id = $usuario_id;
		$this->conexion = new Conexion();
	}
	
	public function getParametrosRouter($estados_router_id){

		$this->estados_router_id = $estados_router_id;
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "10";
			$this->mensajeRespuesta = "Router: ";
			if(!is_null($this->router_id)){
				$sql = $this->conexion->prepare('SELECT * FROM routers r INNER JOIN estados_router er ON (r.estados_router_id = er.estados_router_id) WHERE r.router_id = :router_id');
				$sql->bindParam(':router_id', $this->router_id);
			}elseif(!is_null($this->estados_router_id)){
				$this->codigoRespuesta = "00";
				$sql = $this->conexion->prepare('SELECT * FROM routers r INNER JOIN estados_router er ON (r.estados_router_id = er.estados_router_id) WHERE r.estados_router_id = :estados_router_id');
				$sql->bindParam(':estados_router_id', $this->estados_router_id);
			}else{
				$this->codigoRespuesta = "00";
				$sql = $this->conexion->prepare('SELECT * FROM routers INNER JOIN estados_router er ON (r.estados_router_id = er.estados_router_id) ');
			}
			$sql->execute();
			$resultado = $sql->fetchAll();
			
			return $resultado;

		}catch (PDOException $e) {
			echo "<br>getParametrosRouter::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "getParametrosRouter::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		
	}

	public function getRouterUser($usuario_id,$estados_router_id){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "20";
			$this->mensajeRespuesta = "Router: ";
			
			if(is_null($usuario_id)){
				$this->codigoRespuesta = "21";
				$this->mensajeRespuesta = "Informacion Incompleta para Generar Resultado: ";
			}else{
				// echo "WEEntra qui11".$usuario_id;
				$sql = $this->conexion->prepare('SELECT  r.router_id,r.nombre as nombreRouter,er.estado as estadoRouter,r.version as versionRouter,r.ip as ipRouter,r.puerto as puertoRouter,r.usuario as usuarioRouter,ru.principal,ru.estados_router_id,u.usuario,erc.estado as estado_router_usuario,r.clave as claveRouter,r.reintentos_conexion,r.retraso_conexion,r.tiempo_maximo_conexion FROM routers r inner join estados_router er on (r.estados_router_id = er.estados_router_id) inner join router_usuario ru on (r.router_id = ru.router_id) inner join estados_router erc on (ru.estados_router_id = erc.estados_router_id) inner join usuarios u on (ru.usuario_id = u.usuario_id)  WHERE u.usuario_id = :usuario_id and r.estados_router_id = ru.estados_router_id and r.estados_router_id = :estados_router_id ORDER BY ru.principal DESC' );
				$sql->bindParam(':estados_router_id', $estados_router_id);
				$sql->bindParam(':usuario_id', $usuario_id);
				$sql->execute();
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Resultado Exitoso ";
				return $resultado;				
			}

		}catch (PDOException $e) {
			echo "<br>getParametrosRouter::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "getParametrosRouter::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		
	}
	
	public function getRouterUserByRouterId($usuario_id,$router_id,$estados_router_id){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "30";
			$this->mensajeRespuesta = "Router: ";
			if(is_null($router_id)){
				$this->codigoRespuesta = "21";
				$this->mensajeRespuesta = "Informacion Incompleta para Generar Resultado: ";
				

			}else{				
				$sql = $this->conexion->prepare('SELECT  r.router_id,r.nombre as nombreRouter,er.estado as estadoRouter,r.version as versionRouter,r.ip as ipRouter,r.puerto as puertoRouter,r.usuario as usuarioRouter,ru.principal,ru.estados_router_id,u.usuario,erc.estado as estado_router_usuario,r.clave as claveRouter,r.reintentos_conexion,r.retraso_conexion,r.tiempo_maximo_conexion FROM routers r inner join estados_router er on (r.estados_router_id = er.estados_router_id) inner join router_usuario ru on (r.router_id = ru.router_id) inner join estados_router erc on (ru.estados_router_id = erc.estados_router_id) inner join usuarios u on (ru.usuario_id = u.usuario_id)  WHERE u.usuario_id = :usuario_id and r.estados_router_id = ru.estados_router_id and r.estados_router_id = :estados_router_id AND r.router_id = :router_id');
				$sql->bindParam(':router_id', $router_id);
				$sql->bindParam(':estados_router_id', $estados_router_id);
				$sql->bindParam(':usuario_id', $usuario_id);
				$sql->execute();
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Resultado Exitoso: ";
				
			return $resultado;
			}
			
			// echo "<pre>";
			// print_r($sql);
			// echo "</pre>";


		}catch (PDOException $e) {
			echo "<br>getParametrosRouter::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "getParametrosRouter::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		
	}
	
	public function setRouter($router_id = null,$nameRouter,$estados_router_id,$ipRouter,$puertoRouter,$versionRouter,$usuarioRouter,$claveRouter,$reintentosCx,$retrasoCx,$tiempoMaximoCx){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "40";
			$this->mensajeRespuesta = "Router: ";
			
			// echo "nameRouter:".$nameRouter." ipRouter:".$ipRouter." usuarioRouter:".$usuarioRouter." claveRouter:".$claveRouter."$ puertoRouter:".$puertoRouter." versionRouter:".$versionRouter." reintentosCx:".$reintentosCx." retrasoCx:".$retrasoCx." tiempoMaximoCx:".$tiempoMaximoCx."<br>";
			
			if (($nameRouter=="")||($ipRouter=="")||($usuarioRouter=="")||($claveRouter=="")||($puertoRouter=="")||($versionRouter=="")||($reintentosCx=="")||($retrasoCx=="")||($tiempoMaximoCx=="")) 
			{
				$this->codigoRespuesta = "41";
				$this->mensajeRespuesta = "Informacion Incompleta para Crear el Router ";
			}else{
				
				if($router_id > 0){
					$sql = $this->conexion->prepare('UPDATE '. self::TABLA .' SET nombre = :nameRouter, version = :versionRouter, ip = :ipRouter, puerto = :puertoRouter, usuario = :usuarioRouter, clave = :claveRouter, estados_router_id = :estados_router_id, reintentos_conexion = :reintentosCx, retraso_conexion = :retrasoCx, tiempo_maximo_conexion = :tiempoMaximoCx WHERE router_id = :router_id');
					$sql->bindParam(':router_id', $router_id);
					$sql->bindParam(':nameRouter', $nameRouter);
					$sql->bindParam(':estados_router_id', $estados_router_id);
					$sql->bindParam(':ipRouter', $ipRouter);
					$sql->bindParam(':usuarioRouter', $usuarioRouter);
					$sql->bindParam(':claveRouter', $claveRouter);
					$sql->bindParam(':puertoRouter', $puertoRouter);
					$sql->bindParam(':versionRouter', $versionRouter);
					$sql->bindParam(':reintentosCx', $reintentosCx);
					$sql->bindParam(':retrasoCx', $retrasoCx);
					$sql->bindParam(':tiempoMaximoCx', $tiempoMaximoCx);
					
					$sql->execute();
					// $resultado = $sql->fetchAll();
					$this->codigoRespuesta = "00";
					$this->mensajeRespuesta = "Resultado Actualización Exitoso: ";	
				}else{
					$sql = $this->conexion->prepare('INSERT INTO '. self::TABLA .' (nombre, version, ip, puerto, usuario, clave, estados_router_id, reintentos_conexion, retraso_conexion, tiempo_maximo_conexion) VALUES (:nameRouter,:versionRouter,:ipRouter,:puertoRouter,:usuarioRouter,:claveRouter,:estados_router_id,:reintentosCx,:retrasoCx,:tiempoMaximoCx)');
					$sql->bindParam(':nameRouter', $nameRouter);
					$sql->bindParam(':estados_router_id', $estados_router_id);
					$sql->bindParam(':ipRouter', $ipRouter);
					$sql->bindParam(':usuarioRouter', $usuarioRouter);
					$sql->bindParam(':claveRouter', $claveRouter);
					$sql->bindParam(':puertoRouter', $puertoRouter);
					$sql->bindParam(':versionRouter', $versionRouter);
					$sql->bindParam(':reintentosCx', $reintentosCx);
					$sql->bindParam(':retrasoCx', $retrasoCx);
					$sql->bindParam(':tiempoMaximoCx', $tiempoMaximoCx);
					
					
					// $router_id = $this->conexion->lastInsertId();
					// echo "<pre>";
					// print_r($sql);
					// echo "</pre>";

					
					$sql->execute();
					$this->codigoRespuesta = "00";
					$this->mensajeRespuesta = "Resultado Registro Exitoso: ";
				}

				 $conexion = null;
			return $resultado;
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
	
	public function getEstadosRouter(){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "50";
			$this->mensajeRespuesta = "Router: ";
			$sql = $this->conexion->prepare('SELECT estados_router_id,estado as estado_router FROM estados_router');
			$sql->execute();
			$resultado = $sql->fetchAll();

			return $resultado;

		}catch (PDOException $e) {
			echo "<br>getParametrosRouter::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "getParametrosRouter::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		
	}
	
	public function getAllRouters($router_id=null){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "33";
			$this->mensajeRespuesta = "Router: ";
			if($router_id > 0){
				$sql = $this->conexion->prepare('SELECT  r.router_id,r.nombre as nombreRouter,r.estados_router_id,er.estado as estadoRouter,r.version as versionRouter,r.ip as ipRouter,r.puerto as puertoRouter,r.usuario as usuarioRouter,r.clave as claveRouter,r.reintentos_conexion,r.retraso_conexion,r.tiempo_maximo_conexion FROM routers r inner join estados_router er on (r.estados_router_id = er.estados_router_id) WHERE router_id = :router_id ORDER BY r.router_id DESC' );
				$sql->bindParam(':router_id', $router_id);
				$sql->execute();
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Resultado Exitoso ";
				return $resultado;
			}else{
				$sql = $this->conexion->prepare('SELECT  r.router_id,r.nombre as nombreRouter,er.estado as estadoRouter,r.version as versionRouter,r.ip as ipRouter,r.puerto as puertoRouter,r.usuario as usuarioRouter,r.clave as claveRouter,r.reintentos_conexion,r.retraso_conexion,r.tiempo_maximo_conexion FROM routers r inner join estados_router er on (r.estados_router_id = er.estados_router_id) ORDER BY r.router_id DESC' );
				$sql->execute();
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Resultado Exitoso ";
				return $resultado;				
			}
		}catch (PDOException $e) {
			echo "<br>getAllRouter::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "getAllRouter::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		
	}
	public function ipHotspotUserAddDb(){
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "34";
			$this->mensajeRespuesta = "Router: ";
			if($router_id > 0){
				$sql = $this->conexion->prepare('SELECT  r.router_id,r.nombre as nombreRouter,r.estados_router_id,er.estado as estadoRouter,r.version as versionRouter,r.ip as ipRouter,r.puerto as puertoRouter,r.usuario as usuarioRouter,r.clave as claveRouter,r.reintentos_conexion,r.retraso_conexion,r.tiempo_maximo_conexion FROM routers r inner join estados_router er on (r.estados_router_id = er.estados_router_id) WHERE router_id = :router_id ORDER BY r.router_id DESC' );
				$sql->bindParam(':router_id', $router_id);
				$sql->execute();
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Resultado Exitoso ";
				return $resultado;
			}else{
				$sql = $this->conexion->prepare('SELECT  r.router_id,r.nombre as nombreRouter,er.estado as estadoRouter,r.version as versionRouter,r.ip as ipRouter,r.puerto as puertoRouter,r.usuario as usuarioRouter,r.clave as claveRouter,r.reintentos_conexion,r.retraso_conexion,r.tiempo_maximo_conexion FROM routers r inner join estados_router er on (r.estados_router_id = er.estados_router_id) ORDER BY r.router_id DESC' );
				$sql->execute();
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Resultado Exitoso ";
				return $resultado;				
			}
		}catch (PDOException $e) {
			echo "<br>ipHotspotUserAddDb::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "ipHotspotUserAddDb::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		
	}
	
}
?>