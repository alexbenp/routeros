<?php
require_once 'Conexion.php';
class Configuraciones  {

	private $keyConfig;
	
	const TABLA = 'configuraciones';
	
	
	public function getKeyConfig($descripcion) {
		$conexion = new Conexion();
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$this->descripcion = $descripcion;
		if(empty($descripcion)){
			$descripcion = 'LLAVE';
		}
		
		try {
			$sql = $conexion->prepare('SELECT configuracion_id,descripcion,valor FROM '. self::TABLA .' WHERE descripcion = :descripcion');
			$sql->bindParam(':descripcion', $this->descripcion);
			$sql->execute();
			$resultado = $sql->fetchAll();

			$this->keyconfig =  $resultado[0]['valor'];
			if(empty($this->keyconfig)){
				$this->codigoRespuesta = "01";
				$this->mensajeRespuesta = "Eror en traer la llave ";
			}else{
				$conexion = null;
				return $this->keyconfig;
			}
			
		}catch (PDOException $e) {
			echo "<br>getKeyConfig::DataBase Error: ".$usuario_id." clave = ".$clave."<br>".$e->getMessage();
			echo "<br>Error Code:<br> ".$e->getCode();
			exit;
		}catch (Exception $e) {
			echo "getKeyConfig::General Error: The user could not be added.<br>".$e->getMessage();
			exit;
		}
	}	
}
?>