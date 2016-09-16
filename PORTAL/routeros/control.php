<?php
error_reporting(E_ALL ^ E_NOTICE);
@session_start();

if($_SESSION['sesion'] != "TRUE"){
	header("Location: index.php");
	session_destroy(); 
	exit();
}
?>