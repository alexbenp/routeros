<?php
require_once 'Conexion.php';
class Menus {
	private $menusPerfil;
	private $nivel_uno 	= 1;
	private $nivel_dos 	= 2;
	private $nivel_tres = 3;
	
	public function __construct($perfil_id) {
		$this->perfil_id = $perfil_id;
		// $this->menu_id = $menu_id;
		// $this->menu = $menu;
		// $this->orden_menu = $orden_menu;
		// $this->estados_menu_id = $estados_menu_id;
		// $this->estado_menu = $estado_menu;
		// $this->nivel_menu_id = $nivel_menu_id;
		// $this->submenu_id = $submenu_id;
    }
	
	public function getMenusNivelUno(){
		$conexion = new Conexion();
		
		  // echo 'client version: ', $conexion->getAttribute(PDO::ATTR_CLIENT_VERSION), "\n";
		  // echo 'server version: ', $conexion->getAttribute(PDO::ATTR_SERVER_VERSION), "\n";
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			try {
				$this->codigoRespuesta = "11";
				$this->mensajeRespuesta = "Menu no valido:";
				$sql = $conexion->prepare('SELECT * FROM menus_perfil mp INNER JOIN menus m ON (mp.menu_id = m.menu_id) WHERE mp.perfil_id = :perfil_id AND m.nivel = :nivel_id order by nivel,orden');
				$sql->bindParam(':perfil_id', $this->perfil_id);
				$sql->bindParam(':nivel_id',  $this->nivel_uno);

				$sql->execute();
				$resultado = $sql->fetchAll();
				return $resultado;

			} catch (PDOException $e) {
			  echo "<br>getMenusNivelUno::DataBase Error: <br>".$e->getMessage();
			  echo "<br>Error Code:<br> ".$e->getCode();
			  exit;
			} catch (Exception $e) {
			  echo "getMenusNivelUno::General Error: The user could not be added.<br>".$e->getMessage();
			  exit;
			}
		
	}
	public function getMenusNivelDos($menu_id){
		$conexion = new Conexion();
		$this->menu_id = $menu_id;
		
		  // echo 'client version: ', $conexion->getAttribute(PDO::ATTR_CLIENT_VERSION), "\n";
		  // echo 'server version: ', $conexion->getAttribute(PDO::ATTR_SERVER_VERSION), "\n";
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			try {
				$this->codigoRespuesta = "12";
				$this->mensajeRespuesta = "SubMenu no valido:";
				$sql = $conexion->prepare('SELECT * FROM menus_perfil mp INNER JOIN menus m ON (mp.menu_id = m.menu_id) WHERE mp.perfil_id = :perfil_id AND m.nivel = :nivel_id AND m.submenu_id = :menu_id order by nivel,orden');
				$sql->bindParam(':perfil_id', $this->perfil_id);
				$sql->bindParam(':menu_id', $this->menu_id);
				$sql->bindParam(':nivel_id',  $this->nivel_dos);

				$sql->execute();
				$resultado = $sql->fetchAll();
			
				return $resultado;

			} catch (PDOException $e) {
			  echo "<br>getMenusNivelDos::DataBase Error: <br>".$e->getMessage();
			  echo "<br>Error Code:<br> ".$e->getCode();
			  exit;
			} catch (Exception $e) {
			  echo "getMenusNivelDos::General Error: The user could not be added.<br>".$e->getMessage();
			  exit;
			}
		
	}
	
	
}
?>