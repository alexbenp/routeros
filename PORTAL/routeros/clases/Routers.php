<?php
require_once 'api.php';
class Routers extends routeros_api {
	var $debug = false;
	
	private $iprouter;
	private $usuariorouter;
	private $claverouter;
	private $puertorouter;
	private $attemptsrouter;
	private $delayrouter;
	private $timeoutrouter;


	public function getIpRouter() {
		return $this->iprouter;
	}
	public function getUsuarioRouter() {
		return $this->usuariorouter;
	}
	public function getClaveRouter() {
		return $this->claverouter;
	}
	public function getPuertoRouter() {
		return $this->puertorouter;
	}
	public function getAttemptsRouter() {
		return $this->attemptsrouter;
	}
	public function getDelayRouter() {
		return $this->delayrouter;
	}
	public function getTimeoutRouter() {
		return $this->timeoutrouter;
	}
	public function getCodigoRespuesta() {
		return $this->codigoRespuesta;
	}
	public function getMensajeRespuesta() {
		return $this->mensajeRespuesta;
	}
	
	public function __construct($iprouter, $usuariorouter, $claverouter, $puertorouter, $attemptsrouter, $delayrouter, $timeoutrouter){
		$this->iprouter			= $iprouter;
		$this->usuariorouter	= $usuariorouter;
		$this->claverouter		= $claverouter;
		$this->puertorouter		= $puertorouter;
		$this->attemptsrouter	= $attemptsrouter;
		$this->delayrouter 		= $delayrouter;
		$this->timeoutrouter 	= $timeoutrouter;
		
	}
	public function ipHotspotUserGetall(){
		if ($this->connect($this->iprouter , $this->usuariorouter , $this->claverouter, $this->puertorouter, $this->attemptsrouter, $this->delayrouter, $this->timeoutrouter)) {
			$this->write('/ip/hotspot/user/getall');
			$cargainfo 	= $this->read(false);
			$info 	= $this->parse_response($cargainfo);
			// echo "<br /><br /> Usuarios creados a la fecha <br /><br />";
			foreach ($info as $i => $value) {
				$valor=$info[$i];
				// echo "<tr><td> ".$valor['.id']." ".$valor['name']." tiempo actual:".$valor['uptime']."</td></tr><br />";
			}
			$this->disconnect();
			$this->codigoRespuesta = "00";
			$this->mensajeRespuesta = "Consulta Exitosa Usuarios";
			return $info;
		}else{
			$this->codigoRespuesta = "10";
			$this->mensajeRespuesta = "ipHotspotUserGetall::No se puede conectar al Routerboard con IP:".$this->iprouter." con el usuario ".$this->usuariorouter." Clave: ".$this->claverouter." en el puerto: ".$this->puertorouter;
		}
	}
	public function ipHotspotUserProfileGetall(){
		if ($this->connect($this->iprouter , $this->usuariorouter , $this->claverouter, $this->puertorouter, $this->attemptsrouter, $this->delayrouter, $this->timeoutrouter)) {
			$this->write('/ip/hotspot/user/profile/getall');
			$cargainfo 	= $this->read(false);
			$info 	= $this->parse_response($cargainfo);
			// echo "<br /><br /> Usuarios creados a la fecha <br /><br />";
			foreach ($info as $i => $value) {
				$valor=$info[$i];
				// echo "<tr><td> ".$valor['.id']." ".$valor['name']." tiempo actual:".$valor['uptime']."</td></tr><br />";
			}
			$this->disconnect();
			$this->codigoRespuesta = "00";
			$this->mensajeRespuesta = "Consulta Exitosa perfiles";
			return $info;
		}else{
			$this->codigoRespuesta = "20";
			$this->mensajeRespuesta = "ipHotspotUserProfileGetall::No se puede conectar al Routerboard con IP:".$this->iprouter." con el usuario ".$this->usuariorouter." Clave: ".$this->claverouter." en el puerto: ".$this->puertorouter;
		}
	}
	public function ipHotspotUserProfileAdd($user_shared,$rx,$tx){
		if ($this->connect($this->iprouter , $this->usuariorouter , $this->claverouter, $this->puertorouter, $this->attemptsrouter, $this->delayrouter, $this->timeoutrouter)) {
			$this->comm("/ip/hotspot/user/profile/add",array("name" => $user_shared."u.".$rx."k.".$tx."k","rate-limit" => $rx."k/".$tx."k","shared-users" => $user_shared)); //Enviamos el comando y el true que significa enter
			echo "Perfil creado ".$user_shared."u.".$rx."k.".$tx."k";
			$this->disconnect();
			$this->codigoRespuesta = "00";
			$this->mensajeRespuesta = "Registro Exitoso Perfil";
		}else{
			$this->codigoRespuesta = "30";
			$this->mensajeRespuesta = "ipHotspotUserProfileAdd::No se puede conectar al Routerboard con IP:".$this->iprouter." con el usuario ".$this->usuariorouter." Clave: ".$this->claverouter." en el puerto: ".$this->puertorouter;
		}
	}
	public function ipHotspotUserAdd($name,$password,$uptime,$comentario,$user_shared,$rx,$tx){
		if ($this->connect($this->iprouter , $this->usuariorouter , $this->claverouter, $this->puertorouter, $this->attemptsrouter, $this->delayrouter, $this->timeoutrouter)) {
		$this->comm("/ip/hotspot/user/add",array("name" => $name,"password" => $password,"limit-uptime" => $uptime,"comment" => $comentario,"profile" => $user_shared."u.".$rx."k.".$tx."k" )); //Enviamos el comando y el true que significa enter
			echo "Usuario creado ".$name."u.".$rx."k.".$tx."k";
			$this->disconnect();
			$this->codigoRespuesta = "00";
			$this->mensajeRespuesta = "Registro Exitoso Usuario";
		}else{
			$this->codigoRespuesta = "40";
			$this->mensajeRespuesta = "ipHotspotUserAdd::No se puede conectar al Routerboard con IP:".$this->iprouter." con el usuario ".$this->usuariorouter." Clave: ".$this->claverouter." en el puerto: ".$this->puertorouter;
		}
	}
	
	public function systemResourcePrint(){
		if ($this->connect($this->iprouter , $this->usuariorouter , $this->claverouter, $this->puertorouter, $this->attemptsrouter, $this->delayrouter, $this->timeoutrouter)) {
			$ARRAY = $this->comm("/system/resource/print");
			$first = $ARRAY['0'];
			$memperc = ($first['free-memory']/$first['total-memory']);
			$hddperc = ($first['free-hdd-space']/$first['total-hdd-space']);
			$mem = ($memperc*100);
			$hdd = ($hddperc*100);
			$first['mem'] = $mem;
			$first['hdd'] = $hdd;
			
			$this->disconnect();
			$this->codigoRespuesta = "00";
			$this->mensajeRespuesta = "Informacion del Router";
			return $first;
		}else{
			$this->codigoRespuesta = "50";
			$this->mensajeRespuesta = "systemResourcePrint::No se puede conectar al Routerboard con IP:".$this->iprouter." con el usuario ".$this->usuariorouter." Clave: ".$this->claverouter." en el puerto: ".$this->puertorouter;
		}
	}
		
}
	  
 
?>