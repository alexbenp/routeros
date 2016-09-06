<?php
//Reanudamos la sesión 
session_start(); 
//Literalmente la destruimos 
session_destroy(); 
UNSET($_SESSION);
//Redireccionamos a index.php (al inicio de sesión) 
header("Location: index.php"); 
?>