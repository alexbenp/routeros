<?php
require_once 'Conexion.php';
class AuditoriaRoutersDb extends Conexion {
	private $router_id;
	private $usuario_id;
	const TABLA = 'auditoria_registro_usuarios_router';
	
	public function getCodigoRespuesta() {
		return $this->codigoRespuesta;
	}
	public function getMensajeRespuesta() {
		return $this->mensajeRespuesta;
	}
	
	public function __construct($router_id=null,$usuario_id=null) {
		$this->router_id = $router_id;
		$this->usuario_id = $usuario_id;
	}
	
	public function getAcciones($accion){
		$conexion = new Conexion();
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "02";
			$this->mensajeRespuesta = "Acciones: ";
			IF(EMPTY($accion)){
				$sql = $conexion->prepare('SELECT accion_id, accion FROM acciones ORDER BY accion_id' );
				$sql->execute();
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Resultado Consulta Exitoso: ";
			}ELSE{
				$sql = $conexion->prepare('SELECT accion_id, accion FROM acciones WHERE accion = :accion ORDER BY accion_id DESC' );
				$sql->bindParam(':accion', $accion);
				$sql->execute();
				$resultado = $sql->fetchAll();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Resultado Consulta Exitoso: ";
				
			}
			
			 $conexion = null;
			 return $resultado;
		}catch (PDOException $e) {
			echo "<br>getAcciones::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "getAcciones::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
	}
	
	public function ipHotspotUserAddDB($accion_id,$id_usuario_router,$usuario_router,$clave_usuario_router,$tiempo_unidad,$perfil_usuario_router,$comentario_registro){
		$conexion = new Conexion();
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "03";
			$this->mensajeRespuesta = "Reg Audit: ";
			if($this->router_id > 0){
				$sql = $conexion->prepare('INSERT INTO '. self::TABLA .' (router_id, usuario_id, accion_id,id_usuario_router, usuario_router, clave_usuario_router, tiempo_unidad, perfil_usuario_router, comentario_registro) VALUES (:router_id, :usuario_id, :accion_id, :id_usuario_router, :usuario_router, :clave_usuario_router, :tiempo_unidad, :perfil_usuario_router, :comentario_registro)' );
				$sql->bindParam(':router_id', $this->router_id);
				$sql->bindParam(':usuario_id', $this->usuario_id);
				$sql->bindParam(':accion_id', $accion_id);
				$sql->bindParam(':id_usuario_router', $id_usuario_router);
				$sql->bindParam(':usuario_router', $usuario_router);
				$sql->bindParam(':clave_usuario_router', $clave_usuario_router);
				$sql->bindParam(':tiempo_unidad', $tiempo_unidad);
				$sql->bindParam(':perfil_usuario_router', $perfil_usuario_router);
				$sql->bindParam(':comentario_registro', $comentario_registro);
				$sql->execute();
				$lastInsertId = $conexion->lastInsertId();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Resultado Exitoso ";
			}else{
				$this->codigoRespuesta = "05";
				$this->mensajeRespuesta = "Error en el Router para Registrar Auditoria ";
			}
			 $conexion = null;
			 return $lastInsertId;
		}catch (PDOException $e) {
			echo "<br>ipHotspotUserAddDB::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "ipHotspotUserAddDB::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		
	}
	
	public function ipHotspotUserAddDBUpdate($auditoria_registro_id,$id_usuario_router,$respuesta){
		$conexion = new Conexion();
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "03";
			$this->mensajeRespuesta = "Reg Audit: ";
			if($auditoria_registro_id > 0){
				$sql = $conexion->prepare('UPDATE '. self::TABLA .' SET id_usuario_router = :id_usuario_router, respuesta = :respuesta WHERE auditoria_registro_id = :auditoria_registro_id;' );
				$sql->bindParam(':id_usuario_router', $id_usuario_router);
				$sql->bindParam(':auditoria_registro_id', $auditoria_registro_id);
				$sql->bindParam(':respuesta', $respuesta);
				$sql->execute();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Resultado Exitoso ";
			}else{
				$this->codigoRespuesta = "06";
				$this->mensajeRespuesta = "Error finalizando registro auditoria ";
			}
			 $conexion = null;
			 return $resultado;
		}catch (PDOException $e) {
			echo "<br>ipHotspotUserAddDBUpdate::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "ipHotspotUserAddDBUpdate::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
	}
	public function ipHotspotUserProfileAddDB($accion_id,$profile_name,$user_shared,$rx,$tx,$add_mac_cookie,$mac_uptime){
		$conexion = new Conexion();
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "04";
			$this->mensajeRespuesta = "Reg Audit: ";
			if($this->router_id > 0){
				$sql = $conexion->prepare('INSERT INTO auditoria_registro_perfil_router (router_id, usuario_id, accion_id, profile_name, user_shared, rx, tx, add_mac_cookie,mac_uptime) VALUES (:router_id, :usuario_id, :accion_id, :profile_name, :user_shared, :rx, :tx, :add_mac_cookie, :mac_uptime)' );
				$sql->bindParam(':router_id', $this->router_id);
				$sql->bindParam(':usuario_id', $this->usuario_id);
				$sql->bindParam(':accion_id', $accion_id);
				$sql->bindParam(':profile_name', $profile_name);
				$sql->bindParam(':user_shared', $user_shared);
				$sql->bindParam(':rx', $rx);
				$sql->bindParam(':tx', $tx);
				$sql->bindParam(':add_mac_cookie', $add_mac_cookie);
				$sql->bindParam(':mac_uptime', $mac_uptime);
				$sql->execute();
				$lastInsertId = $conexion->lastInsertId();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Resultado Exitoso ";
			}else{
				$this->codigoRespuesta = "15";
				$this->mensajeRespuesta = "Error en el Router para Registrar Auditoria ";
			}
			 $conexion = null;
			 return $lastInsertId;
		}catch (PDOException $e) {
			echo "<br>ipHotspotUserProfileAddDB::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "ipHotspotUserProfileAddDB::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
		
	}
	public function ipHotspotUserProfileAddDBUpdate($auditoria_registro_perfil_id,$id_perfil_usuario_router,$respuesta){
		$conexion = new Conexion();
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "03";
			$this->mensajeRespuesta = "Reg Audit: ";
			if($auditoria_registro_perfil_id > 0){
				$sql = $conexion->prepare('UPDATE auditoria_registro_perfil_router SET id_perfil_usuario = :id_perfil_usuario_router, respuesta = :respuesta WHERE auditoria_registro_perfil_id = :auditoria_registro_perfil_id;' );
				$sql->bindParam(':id_perfil_usuario_router', $id_perfil_usuario_router);
				$sql->bindParam(':auditoria_registro_perfil_id', $auditoria_registro_perfil_id);
				$sql->bindParam(':respuesta', $respuesta);
				$sql->execute();
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Resultado Exitoso ";
			}else{
				$this->codigoRespuesta = "06";
				$this->mensajeRespuesta = "Error finalizando registro auditoria ";
			}
			 $conexion = null;
			 return $resultado;
		}catch (PDOException $e) {
			echo "<br>ipHotspotUserAddDBUpdate::DataBase Error: <br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "ipHotspotUserAddDBUpdate::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
	}
}
?>