<?php
require_once 'Conexion.php';
class Menus {
	private $menusPerfil;
	private $nivel_uno 	= 1;
	private $nivel_dos 	= 2;
	private $nivel_tres = 3;
	private $conexion;
	// private $principal;
	// private $url_principal;
	
	public function __construct($perfil_id) {
		$this->perfil_id = $perfil_id;
		$this->conexion = new Conexion();
		// $this->menu_id = $menu_id;
		// $this->menu = $menu;
		// $this->orden_menu = $orden_menu;
		// $this->estados_menu_id = $estados_menu_id;
		// $this->estado_menu = $estado_menu;
		// $this->nivel_menu_id = $nivel_menu_id;
		// $this->submenu_id = $submenu_id;
    }
	

	public function getMenusNivelUno(){

		
		  // echo 'client version: ', $this->conexion->getAttribute(PDO::ATTR_CLIENT_VERSION), "\n";
		  // echo 'server version: ', $this->conexion->getAttribute(PDO::ATTR_SERVER_VERSION), "\n";
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			try {
				$this->codigoRespuesta = "11";
				$this->mensajeRespuesta = "Menu no valido:";
				$sql = $this->conexion->prepare('SELECT * FROM menus_perfil mp INNER JOIN menus m ON (mp.menu_id = m.menu_id) WHERE mp.perfil_id = :perfil_id AND m.nivel = :nivel_id AND m.estados_menu_id = 1 AND mp.estados_menu_id = 1 order by nivel,orden');
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

		$this->menu_id = $menu_id;
		
		  // echo 'client version: ', $this->conexion->getAttribute(PDO::ATTR_CLIENT_VERSION), "\n";
		  // echo 'server version: ', $this->conexion->getAttribute(PDO::ATTR_SERVER_VERSION), "\n";
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			try {
				$this->codigoRespuesta = "12";
				$this->mensajeRespuesta = "SubMenu no valido:";
				$sql = $this->conexion->prepare('SELECT * FROM menus_perfil mp INNER JOIN menus m ON (mp.menu_id = m.menu_id) WHERE mp.perfil_id = :perfil_id AND m.nivel = :nivel_id AND m.submenu_id = :menu_id AND m.estados_menu_id = 1 AND mp.estados_menu_id = 1 order by nivel,orden');
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
	
	public function getMenu(){
		
		$arreglo = $this->getMenusNivelUno();
		$principal = 0;
		foreach($arreglo as $llave=>$elemento){
			$menu_id = $arreglo[$llave]['menu_id'];
			if($principal == '0'){
				$principal = $arreglo[$llave]['principal'];
				if($principal == '1'){
					$url_principal = $arreglo[$llave]['ruta_url'];
					// echo "nivel 1::".$arreglo[$llave]['ruta_url'];
				}
			}
			
			if($menu_id > 0){
				$arreglo[$llave]['submenu'] = $this->getMenusNivelDos($menu_id);
				if($principal == '0'){
					foreach($arreglo[$llave]['submenu'] as $key=>$item){
						$principal = $arreglo[$llave]['submenu'][$key]['principal'];
						if($principal == '1'){
							$url_principal = $arreglo[$llave]['submenu'][$key]['ruta_url'];
						}
					}
				}
			}
		}
		$retorna['info'] = $arreglo;
		$retorna['url_principal'] = $url_principal;
		 
		return $retorna;
	}

	public function getPageByName($ruta_url){
		$this->ruta_url = $ruta_url;
		
		  // echo 'client version: ', $this->conexion->getAttribute(PDO::ATTR_CLIENT_VERSION), "\n";
		  // echo 'server version: ', $this->conexion->getAttribute(PDO::ATTR_SERVER_VERSION), "\n";
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			try {
				$this->codigoRespuesta = "13";
				$this->mensajeRespuesta = "Menu no valido:";
				$sql = $this->conexion->prepare('SELECT count(*) AS VALIDA FROM menus_perfil mp INNER JOIN menus m ON (mp.menu_id = m.menu_id) WHERE mp.perfil_id = :perfil_id AND m.estados_menu_id = 1 AND mp.estados_menu_id = 1 AND m.ruta_url = :ruta_url order by nivel,orden');
				$sql->bindParam(':perfil_id', $this->perfil_id);
				$sql->bindParam(':ruta_url', $this->ruta_url);


				$sql->execute();
				$resultado = $sql->fetchAll();
				$valida = $resultado[0]['VALIDA'];

				if($valida == 0){
					echo ' No encuenrta datos '.$this->perfil_id.' ruta:'.$this->ruta_url;
					session_destroy();
					UNSET($_SESSION);
					// Redireccionamos a index.php (al inicio de sesión) 
					header("Location: index.php"); 
				}else{
					return $resultado;	
				}


			} catch (PDOException $e) {
			  echo "<br>getMenusNivelUno::DataBase Error: <br>".$e->getMessage();
			  echo "<br>Error Code:<br> ".$e->getCode();
			  exit;
			} catch (Exception $e) {
			  echo "getMenusNivelUno::General Error: The user could not be added.<br>".$e->getMessage();
			  exit;
			}
		
	}

}
?>