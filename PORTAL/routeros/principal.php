<?php include("control.php"); ?> 
<html>
<head>
<title>Portal RouterOS</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<link href="estilos/ingreso.css" rel="stylesheet" type="text/css">
<link href="estilos/menu.css" rel="stylesheet" type="text/css">
</head>
<body> 
<?php 			 
$cierra_linea = "";
	echo "<div id=\"header\">";
		echo "<ul class=\"nav\">";
	
	$menus = $_SESSION['menuPerfil'];
	foreach($menus as $llave=>$elmento){
		$menu_nombre = $menus[$llave]["menu"];
		$link = $menus[$llave]["ruta_url"];
		$submenu = $menus[$llave]["submenu"];
		echo "<li><a href=\"".$link."\">".$menu_nombre."</a>";
		foreach($submenu as $key=>$item){
			$submenu_nombre = $submenu[$key]["menu"];
			$link = $submenu[$key]["ruta_url"];
			if($key == 0){
				$cierra_linea = true;
				echo "<ul>";
			}
			echo "<li><a href=\"".$link."\"> ".$submenu_nombre." </a></li>";
		}
			echo "</li>";
		if($cierra_linea == true){
			echo "</ul>";
			$cierra_linea = false;
		}
	 }
		echo "</ul>";
	echo "</div>";
?>
<br>
<br>


<?php