<?php
@session_start();

if($_SESSION["sesion"] != "TRUE"){
	header("Location: index.php");
	exit();
}
?>