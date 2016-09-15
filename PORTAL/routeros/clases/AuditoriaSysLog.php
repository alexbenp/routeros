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
				$this->mensajeRespuesta = "No existe Informacon de Auditoria:";
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
	
	public function getHotspotUserEvents($fechaInicio,$fechaFinal,$usuario){
		$conexion = new ConexionSysLog();

		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		$etiqueta = "hostpot";
		
			try {
				$this->codigoRespuesta = "02";
				$this->mensajeRespuesta = "No existe Informacon de Auditoria:";
				
				$sql_campos = "SELECT ID,FromHost,ReceivedAt,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',1),'(',1)) as Usuario,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',1),'(',-1))  as IpMac,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',-1),'(',-1))  as Mensaje,Message FROM (SELECT SUBSTRING_INDEX(SysLogTag,'[',1) AS UniqueSysLogTar FROM syslog.systemevents group by SUBSTRING_INDEX(SysLogTag,'[',1)) AS log INNER JOIN syslog.systemevents s ON (SUBSTRING_INDEX(SysLogTag,'[',1) = log.UniqueSysLogTar) ";
				$sql_condiciones = " WHERE upper(UniqueSysLogTar) like upper('%hotspot%')";
				$sql_orden = " ORDER BY ReceivedAt DESC";
				$sql_condiciones = $sql_condiciones." AND ReceivedAt BETWEEN :fechaInicio AND :fechaFinal";
				$sql_condiciones = $sql_condiciones." AND trim(SUBSTRING_INDEX(Message,'(',1)) = :usuario";
				
				$sql_final = $sql_campos.$sql_condiciones.$sql_orden;
				$sql = $conexion->prepare($sql_final);
				// $sql = $conexion->prepare("SELECT ID,FromHost,ReceivedAt,Message,trim(SUBSTRING_INDEX(SUBSTRING_INDEX(Message,'):',1),'(',-1))  as IpMac FROM (SELECT SUBSTRING_INDEX(SysLogTag,'[',1) AS UniqueSysLogTar FROM syslog.systemevents group by SUBSTRING_INDEX(SysLogTag,'[',1)) AS log INNER JOIN syslog.systemevents s ON (SUBSTRING_INDEX(SysLogTag,'[',1) = log.UniqueSysLogTar) WHERE upper(UniqueSysLogTar) like upper('%hotspot%') AND trim(SUBSTRING_INDEX(Message,'(',1)) = 'Prueba1' AND ReceivedAt BETWEEN :fechaInicio AND :fechaFinal				SELECT * FROM SystemEvents WHERE ReceivedAt BETWEEN  :fechaInicio AND :fechaFinal ORDER BY ReceivedAt DESC");
				$sql->bindParam(':fechaInicio', $fechaInicio);
				$sql->bindParam(':fechaFinal',  $fechaFinal);
				$sql->bindParam(':usuario',  $usuario);

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
}
?>