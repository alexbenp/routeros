<?php
require_once 'ConexionSysLog.php';
class AuditoriaSysLog {
	
	public function __construct() {

    }
	
	public function getSystemEvents($fechaInicio,$fechaFinal){
		$conexion = new ConexionSysLog();

		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			try {
				$this->codigoRespuesta = "01";
				$this->mensajeRespuesta = "No existe Información de Auditoria:";
				$sql = $conexion->prepare('SELECT * FROM SystemEvents WHERE ReceivedAt BETWEEN  :fechaInicio AND :fechaFinal ORDER BY ReceivedAt DESC');
				$sql->bindParam(':fechaInicio', $fechaInicio);
				$sql->bindParam(':fechaFinal',  $fechaFinal);

				$sql->execute();
				$resultado = $sql->fetchAll();
				// print_r($sql);
				// echo 'la Consulta es:';
				return $resultado;

			} catch (PDOException $e) {
			  echo "<br>getSystemEvents::DataBase Error: <br>".$e->getMessage();
			  echo "<br>Error Code:<br> ".$e->getCode();
			  exit;
			} catch (Exception $e) {
			  echo "getSystemEvents::General Error:<br>".$e->getMessage();
			  exit;
			}
			
	}
	
	public function getHotspotUserEvents($usuario){
		$conexion = new ConexionSysLog();

		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
			try {
				$this->codigoRespuesta = "02";
				$this->mensajeRespuesta = "No existe Información de Auditoria:";
				
				$sql_final = "SELECT ID,FromHost,ReceivedAt,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',1),'(',1)) as Usuario,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',1),'(',-1))  as IpMac,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',-1),'(',-1))  as Mensaje,Message FROM (SELECT SUBSTRING_INDEX(SysLogTag,'[',1) AS UniqueSysLogTar FROM syslog.systemevents group by SUBSTRING_INDEX(SysLogTag,'[',1)) AS log INNER JOIN syslog.systemevents s ON (SUBSTRING_INDEX(SysLogTag,'[',1) = log.UniqueSysLogTar) WHERE upper(UniqueSysLogTar) like upper('%hotspot%') AND trim(SUBSTRING_INDEX(Message,'(',1)) = :usuario ORDER BY ReceivedAt DESC";

				$sql = $conexion->prepare($sql_final);
				$sql->bindParam(':usuario',  $usuario);

				$sql->execute();
				$resultado = $sql->fetchAll();
				return $resultado;

			} catch (PDOException $e) {
			  echo "<br>getHotspotUserEvents::DataBase Error: <br>".$e->getMessage();
			  echo "<br>Error Code:<br> ".$e->getCode();
			  exit;
			} catch (Exception $e) {
			  echo "getHotspotUserEvents::General Error:<br>".$e->getMessage();
			  exit;
			}
			
	}
	
	public function getHotspotDateEvents($fechaInicio,$fechaFinal){
		$conexion = new ConexionSysLog();

		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		
			try {
				$this->codigoRespuesta = "03";
				$this->mensajeRespuesta = "No existe Información de Auditoria:";
				
				$sql_final = "SELECT ID,FromHost,ReceivedAt,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',1),'(',1)) as Usuario,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',1),'(',-1))  as IpMac,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',-1),'(',-1))  as Mensaje,Message FROM (SELECT SUBSTRING_INDEX(SysLogTag,'[',1) AS UniqueSysLogTar FROM syslog.systemevents group by SUBSTRING_INDEX(SysLogTag,'[',1)) AS log INNER JOIN syslog.systemevents s ON (SUBSTRING_INDEX(SysLogTag,'[',1) = log.UniqueSysLogTar) WHERE upper(UniqueSysLogTar) like upper('%hotspot%')  AND ReceivedAt BETWEEN :fechaInicio AND :fechaFinal ORDER BY ReceivedAt DESC";
				
				$sql = $conexion->prepare($sql_final);
				$sql->bindParam(':fechaInicio', $fechaInicio);
				$sql->bindParam(':fechaFinal',  $fechaFinal);

				$sql->execute();
				$resultado = $sql->fetchAll();
				return $resultado;

			} catch (PDOException $e) {
			  echo "<br>getHotspotDateEvents::DataBase Error: <br>".$e->getMessage();
			  echo "<br>Error Code:<br> ".$e->getCode();
			  exit;
			} catch (Exception $e) {
			  echo "getHotspotDateEvents::General Error:<br>".$e->getMessage();
			  exit;
			}
			
	}

	public function getHotspotUserDateEvents($usuario,$fechaInicio,$fechaFinal){
		$conexion = new ConexionSysLog();

		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		
			try {
				$this->codigoRespuesta = "04";
				$this->mensajeRespuesta = "No existe Información de Auditoria:";
				
				$sql_final = "SELECT ID,FromHost,ReceivedAt,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',1),'(',1)) as Usuario,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',1),'(',-1))  as IpMac,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',-1),'(',-1))  as Mensaje,Message FROM (SELECT SUBSTRING_INDEX(SysLogTag,'[',1) AS UniqueSysLogTar FROM syslog.systemevents group by SUBSTRING_INDEX(SysLogTag,'[',1)) AS log INNER JOIN syslog.systemevents s ON (SUBSTRING_INDEX(SysLogTag,'[',1) = log.UniqueSysLogTar) WHERE upper(UniqueSysLogTar) like upper('%hotspot%') AND trim(SUBSTRING_INDEX(Message,'(',1)) = :usuario AND ReceivedAt BETWEEN :fechaInicio AND :fechaFinal ORDER BY ReceivedAt DESC";
				
				$sql = $conexion->prepare($sql_final);
				$sql->bindParam(':fechaInicio', $fechaInicio);
				$sql->bindParam(':fechaFinal',  $fechaFinal);
				$sql->bindParam(':usuario',  $usuario);
				$sql->execute();
				$resultado = $sql->fetchAll();
				return $resultado;

			} catch (PDOException $e) {
			  echo "<br>getSystemEvents::DataBase Error: <br>".$e->getMessage();
			  echo "<br>Error Code:<br> ".$e->getCode();
			  exit;
			} catch (Exception $e) {
			  echo "getSystemEvents::General Error:<br>".$e->getMessage();
			  exit;
			}
			
	}
}
?>