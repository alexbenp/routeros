<?php
require_once 'ConexionSysLog.php';
class AuditoriaSysLog {
	
	public function __construct() {

    }
	
	public function getSystemEvents($fechaInicio,$fechaFinal){
		$conexion = new ConexionSysLog();
// echo "<pre>";
// print_r($conexion);
// echo "</pre>";
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
	
}
?>