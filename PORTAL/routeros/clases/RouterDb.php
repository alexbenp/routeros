<?php
require_once 'Conexion.php';
class RoutersDb {
	private $router_id;
	private $estados_router_id;
	const TABLA = 'routers';
	public function __construct($router_id=null) {
		$this->router_id = $router_id;
	}
	
	public function getParametrosRouter($estados_router_id){
		$conexion = new Conexion();
		$this->estados_router_id = $estados_router_id;
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try {
			$this->codigoRespuesta = "10";
			$this->mensajeRespuesta = "Router: ";
			if(!is_null($this->router_id)){
				$sql = $conexion->prepare('SELECT * FROM routers r INNER JOIN estados_router er ON (r.estados_router_id = er.estados_router_id) WHERE r.router_id = :router_id');
				$sql->bindParam(':router_id', $this->router_id);
			}elseif(!is_null($this->estados_router_id)){
				echo "entra qui".$this->estados_router_id;
				$sql = $conexion->prepare('SELECT * FROM routers r INNER JOIN estados_router er ON (r.estados_router_id = er.estados_router_id) WHERE r.estados_router_id = :estados_router_id');
				$sql->bindParam(':estados_router_id', $this->estados_router_id);
			}else{
				$sql = $conexion->prepare('SELECT * FROM routers INNER JOIN estados_router er ON (r.estados_router_id = er.estados_router_id) ');
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
	// public function getAllRouter($estados_router_id){
		// $this->estados_router_id = $estados_router_id;
		// $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		// try {
			// $this->codigoRespuesta = "60";
			// $this->mensajeRespuesta = "Router: ";
			// if($this->estados_router_id > 0){
				// $sql = $conexion->prepare('SELECT * FROM routers r INNER JOIN estados_router er ON (r.estados_router_id = er.estados_router_id) WHERE r.estados_router_id = :estados_router_id');
				// $sql->bindParam(':estados_router_id', $this->estados_router_id);
			// }else{
				// $sql = $conexion->prepare('SELECT * FROM routers INNER JOIN estados_router er ON (r.estados_router_id = er.estados_router_id)');
				// $sql->bindParam(':estados_router_id', $this->estados_router_id);				
			// }
			// $sql->execute();
			// $resultado = $sql->fetchAll();
			
			// return $resultado;

		// }catch (PDOException $e) {
			// echo "<br>getAllRouter::DataBase Error: <br>".$e->getMessage();
			// echo "<br>Error Code:<br> ".$e->getCode();
			// exit;
		// }catch (Exception $e) {
			// echo "getAllRouter::General Error: The user could not be added.<br>".$e->getMessage();
			// exit;
		// }
	// }
}
?>