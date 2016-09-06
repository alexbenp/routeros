<?php 
include("control.php"); 
require_once 'clases/Menus.php';
error_reporting(E_ALL ^ E_NOTICE);
?> 
<html>
<head>
<title>Portal RouterOS</title>
<script language="JavaScript" type="text/javascript" src="js/ajax.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<!--<link href="css/ingreso.css" rel="stylesheet" type="text/css"> -->
<!--<link href="css/menu.css" rel="stylesheet" type="text/css">  -->
<!--<link href="css/formulario.css" rel="stylesheet" type="text/css"> -->
<!--<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"> -->
<!--<link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"> -->


<!-- Versión compilada y comprimida del CSS de Bootstrap -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
 
<!-- Tema opcional -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">


</head>
<body> 

<script src="https://code.jquery.com/jquery.js"></script>


<!-- Versión compilada y comprimida del JavaScript de Bootstrap -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>


<?php
	$menus = new Menus($_SESSION['getPerfilId']);
	$info = $menus->getMenu();
	$arreglo = $info['info'];


$cierra_linea = "";
	echo '<div id="collapse navbar-collapse navbar-ex1-collapse">';
		// echo '<ul class="nav nav-tabs">';
		echo '<ul class="nav nav-tabs nav-justified">';
	
	// $menus = $_SESSION['menuPerfil'];
	foreach($arreglo as $llave=>$elmento){
		// echo "llave".$llave."<br>";
		$menu_nombre = $arreglo[$llave]['menu'];
		$link = $arreglo[$llave]['ruta_url'];
		$submenu = $arreglo[$llave]['submenu'];
		if(empty($link)){
			echo '<li class="dropdown">';
			echo '<a href="'.$link.'" class="dropdown-toggle" data-toggle="dropdown">'.$menu_nombre.'<b class="caret"></b></a>';
			if(is_array($submenu)){

				foreach($submenu as $key=>$item){
					$submenu_nombre = $submenu[$key]['menu'];
					$link = $submenu[$key]['ruta_url'];
					if($key == 0){
						$cierra_linea = true;
						echo '<ul  class="dropdown-menu">';
					}
					echo '<li class="active"><a href="'.$link.'"> '.$submenu_nombre.' </a></li>';
				}
			}
			echo '</li>';
			if($cierra_linea == true){
				echo '</ul>';
				$cierra_linea = false;
			}
		}else{
			 echo '<li><a href="'.$link.'"> '.$menu_nombre.' </a></li>';
		}
	 }
		echo '</ul>';
	echo '</div><br><br>';
?>