<?php 
 class Conexion extends PDO { 
   private $tipo_de_base = 'mysql';
   private $host = 'localhost';
   private $port = '3306';
   private $nombre_de_base = 'routeros';
   private $usuario = 'Syslog.sip';
   private $contrasena = 'Syslog.sipltda2016';
    
   public function __construct() {
      //Sobreescribo el método constructor de la clase PDO.
      try{
        parent::__construct($this->tipo_de_base.':host='.$this->host.';port='.$this->port.';dbname='.$this->nombre_de_base, $this->usuario, $this->contrasena);
	
      }catch(PDOException $e){
         echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: '.$this->nombre_de_base.' Detalle: ' . $e->getMessage();
         exit;
      }
   } 
 } 
?>