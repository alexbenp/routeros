<html>
<head>
<meta charset="utf-8">
<title>Portal Routeros</title>
<link href="estilos/ingreso.css" rel="stylesheet" type="text/css">
</head>

 <div class="container mlogin">
 <div id="login">
 <h1>INGRESO A PORTAL</h1>
<form name="ingreso" id="ingreso" action="ingreso.php" method="POST">
 <p>
 <label for="user_login">Usuario<br />
 <input type="text" name="usuario" id="usuario" class="input" value="" size="20" /></label>
 </p>
 <p>
 <label for="user_pass">Clave<br />
 <input type="password" name="clave" id="clave" class="input" value="" size="20" /></label>
 </p>
 <p class="submit">
 <input type="submit" name="login" class="button" value="Entrar" />
 </p>
 <!-- <p class="regtext">No estas registrado? <a href="register.php" >Registrate Aquí</a>!</p>
 -->
</form>
 
</div>
 
</div>
 <?php if (!empty($_POST['message'])) {echo "<p class=\"error\">" . "ATENCIÓN!!: ". $_POST['message'] . "</p>";} ?>