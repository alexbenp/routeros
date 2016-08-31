<?php
require_once 'api.php';
require_once 'Conexion.php';
class Routers extends routeros_api {
	var $debug = false;
	
	private $iprouter;
	private $usuariorouter;
	private $claverouter;
	private $puertorouter;
	private $attemptsrouter;
	private $delayrouter;
	private $timeoutrouter;
	
	private $estados_router_id;


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
	
	public function getEstadosRouterId() {
		return $this->estados_router_id;
	}	
	
	public function __construct($iprouter = null, $usuariorouter=null, $claverouter=null, $puertorouter=null, $attemptsrouter=null, $delayrouter=null, $timeoutrouter=null){
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
	public function ipHotspotUserProfileAdd($profile_name,$user_shared,$rx,$tx,$add_mac_cookie,$mac_uptime){
		if ($this->connect($this->iprouter , $this->usuariorouter , $this->claverouter, $this->puertorouter, $this->attemptsrouter, $this->delayrouter, $this->timeoutrouter)) {
			$resultado = $this->comm("/ip/hotspot/user/profile/add",array("name" => $profile_name,"shared-users" => $user_shared,"rate-limit" => $rx."k/".$tx."k","add-mac-cookie" => $add_mac_cookie,"mac-cookie-timeout" => $mac_uptime));
			$this->disconnect();
			// echo "<br>asasd <br><pre>";
			// print_r($resultado);
			// echo "</pre>";
			if(is_array($resultado)){
				$mensaje = $resultado['!trap'][0]['message'];	
			}
			if(!empty($mensaje)){
				$this->codigoRespuesta = "21";	
				$this->mensajeRespuesta = "Error Registro Perfil:".$mensaje;
			}else{
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Registro Exitoso Perfil";
			}
			return $resultado;
		}else{
			$this->codigoRespuesta = "30";
			$this->mensajeRespuesta = "ipHotspotUserProfileAdd::No se puede conectar al Routerboard con IP:".$this->iprouter." con el usuario ".$this->usuariorouter." Clave: ".$this->claverouter." en el puerto: ".$this->puertorouter;
		}
	}
	
	public function ipHotspotUserAdd($name,$password,$uptime,$comentario,$profile_name){
		if ($this->connect($this->iprouter , $this->usuariorouter , $this->claverouter, $this->puertorouter, $this->attemptsrouter, $this->delayrouter, $this->timeoutrouter)) {
			$resultado = $this->comm("/ip/hotspot/user/add",array("name" => $name,"password" => $password,"limit-uptime" => $uptime,"comment" => $comentario, "profile" => $profile_name)); 
			$this->disconnect();
			if(is_array($resultado)){
				$mensaje = $resultado['!trap'][0]['message'];	
			}
			if(!empty($mensaje)){
				$this->codigoRespuesta = "31";	
				$this->mensajeRespuesta = "Error Registro Usuario:".$mensaje;
			}else{
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Registro Exitoso Usuario";
			}
			return $resultado;
		}else{
			$this->codigoRespuesta = "40";
			$this->mensajeRespuesta = "ipHotspotUserAdd::No se puede conectar al Routerboard con IP:".$this->iprouter." con el usuario ".$this->usuariorouter." Clave: ".$this->claverouter." en el puerto: ".$this->puertorouter;
		}
	}
	
	public function systemResourcePrint(){
		if ($this->connect($this->iprouter , $this->usuariorouter , $this->claverouter, $this->puertorouter, $this->attemptsrouter, $this->delayrouter, $this->timeoutrouter)) {
			$ARRAY = $this->comm("/system/resource/print");
			// echo "<pre>";
			// print_r($ARRAY);
			// echo "</pre>";
			$info = $ARRAY['0'];
			$memperc = ($info['free-memory']/$info['total-memory']);
			$hddperc = ($info['free-hdd-space']/$info['total-hdd-space']);
			$mem = ($memperc*100);
			$hdd = ($hddperc*100);
			$info['mem'] = $mem;
			$info['hdd'] = $hdd;
			
			$this->disconnect();
			$this->codigoRespuesta = "00";
			$this->mensajeRespuesta = "Informacion del Router";
			return $info;
		}else{
			$this->codigoRespuesta = "50";
			$this->mensajeRespuesta = "systemResourcePrint::No se puede conectar al Routerboard con IP:".$this->iprouter." con el usuario ".$this->usuariorouter." Clave: ".$this->claverouter." en el puerto: ".$this->puertorouter;
		}
	}
	
	public function ipHotspotUserRemove($idborrado){
		if ($this->connect($this->iprouter , $this->usuariorouter , $this->claverouter, $this->puertorouter, $this->attemptsrouter, $this->delayrouter, $this->timeoutrouter)) {
			$this->write('/ip/hotspot/user/remove', false); //Enviamos el comando y el true que significa enter
			$this->write('=.id='.$idborrado);
			$READ = $this->read(false);
			$resultado = $this->parse_response($READ);
			$this->disconnect();

			if(is_array($resultado)){
				$mensaje = $resultado['!trap'][0]['message'];	
			}
			if(!empty($mensaje)){
				$this->codigoRespuesta = "51";	
				$this->mensajeRespuesta = "Error Eliminando Usuario:".$mensaje;
			// }elseif(empty($resultado)){
				// $this->codigoRespuesta = "53";	
				// $this->mensajeRespuesta = "Error Usuario no encontrado:".$mensaje;
			}else{
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Usuario Eliminado Exitosamente";
			}
			return $resultado;
		}else{
			$this->codigoRespuesta = "60";
			$this->mensajeRespuesta = "ipHotspotUserRemove::No se puede conectar al Routerboard con IP:".$this->iprouter." con el usuario ".$this->usuariorouter." Clave: ".$this->claverouter." en el puerto: ".$this->puertorouter;
		}
	}
	
	public function ipHotspotUserProfileRemove($idborrado){
		if ($this->connect($this->iprouter , $this->usuariorouter , $this->claverouter, $this->puertorouter, $this->attemptsrouter, $this->delayrouter, $this->timeoutrouter)) {
			$this->write('/ip/hotspot/user/profile/remove', false); //Enviamos el comando y el true que significa enter
			$this->write('=.id='.$idborrado);
			$READ = $this->read(false);
			$resultado = $this->parse_response($READ);
			$this->disconnect();
			if(is_array($resultado)){
				$mensaje = $resultado['!trap'][0]['message'];	
			}
			if(!empty($mensaje)){
				$this->codigoRespuesta = "61";	
				$this->mensajeRespuesta = "Error Eliminando Perfil:".$mensaje;
			}else{
				$this->codigoRespuesta = "00";
				$this->mensajeRespuesta = "Perfil Eliminado Exitosamente";
			}
			return $resultado;
		}else{
			$this->codigoRespuesta = "70";
			$this->mensajeRespuesta = "ipHotspotUserProfileRemove::No se puede conectar al Routerboard con IP:".$this->iprouter." con el usuario ".$this->usuariorouter." Clave: ".$this->claverouter." en el puerto: ".$this->puertorouter;
		}
	}
	
	public function logSystemRouter(){
		if ($this->connect($this->iprouter , $this->usuariorouter , $this->claverouter, $this->puertorouter, $this->attemptsrouter, $this->delayrouter, $this->timeoutrouter)) {
			$info = $this->comm("/log/print");
			// $info = $ARRAY['0'];

			// echo "<pre>";
			// print_r($info);
			// echo "</pre>";
			$this->disconnect();
			$this->codigoRespuesta = "00";
			$this->mensajeRespuesta = "Informacion del Router";
			return $info;
		}else{
			$this->codigoRespuesta = "80";
			$this->mensajeRespuesta = "logSystemRouter::No se puede conectar al Routerboard con IP:".$this->iprouter." con el usuario ".$this->usuariorouter." Clave: ".$this->claverouter." en el puerto: ".$this->puertorouter;
		}
	}
	
	public function historySystemRouter(){
		if ($this->connect($this->iprouter , $this->usuariorouter , $this->claverouter, $this->puertorouter, $this->attemptsrouter, $this->delayrouter, $this->timeoutrouter)) {
			$info = $this->comm("/system/history/print");
			$this->disconnect();
			$this->codigoRespuesta = "00";
			$this->mensajeRespuesta = "Informacion del Router";
			return $info;
		}else{
			$this->codigoRespuesta = "90";
			$this->mensajeRespuesta = "historySystemRouter::No se puede conectar al Routerboard con IP:".$this->iprouter." con el usuario ".$this->usuariorouter." Clave: ".$this->claverouter." en el puerto: ".$this->puertorouter;
		}
	}
}
	  
 
?>