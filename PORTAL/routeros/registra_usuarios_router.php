<?php 
include("control.php");
include("principal.php");
//require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/Routers.php');
$action=$_REQUEST['action']; 
$profile=$_REQUEST['profile'];

// $ipRB="192.168.56.2"; //IP de tu RB.
// $Username="admin"; //Nombre de usuario con privilegios para acceder al RB
// $clave=""; //Clave del usuario con privilegios
// $api_puerto=8728; //Puerto que definimos el API en IP--->Services
// $attempts = 3; // Connection attempt count
// $delay = 3; // Delay between connection attempts in seconds
// $timeout = 3; // Connection attempt timeout and data read timeout

$ipRB			= $_SESSION["ip"]; //IP de tu RB.
$Username		= $_SESSION["usuario"]; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION["clave"]; //Clave del usuario con privilegios
$api_puerto		= $_SESSION["puerto"]; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION["reintentos_conexion"]; // Connection attempt count
$delay 			= $_SESSION["retraso_conexion"]; // Delay between connection attempts in seconds
$timeout 		= $_SESSION["tiempo_maximo_conexion"]; // Connection attempt timeout and data read timeout


$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);

if ($action=="userAdd")
{
	
	$name		=$_REQUEST['name']; 
	$password	=$_REQUEST['password']; 
	$uptime		=$_REQUEST['uptime'];
	$comentario	=$_REQUEST['comentario'];

	$profile_name	=$_REQUEST['profile_name']; 


	if (($name=="")||($password=="")||($uptime=="")|| ($profile_name="")) 
	{
		echo "Todos los campos son obligatorios, por favor completa <a href=\"\">el formulario</a> nuevamente.";
	}else{
		
		// fin de crear perfil de usuario
		$userAdd = $ROUTERS->ipHotspotUserAdd($name,$password,$uptime,$comentario,$profile_name);
		$mensajeRespuestaUserAdd = $ROUTERS->getMensajeRespuesta();
		$codigoRespuestaUserAdd = $ROUTERS->getCodigoRespuesta();

	} 
}
?> 
<div class="container">
  <div class="">
    <h1>Usuarios RouterOS</h1>
  </div>
<form id="Usuarios" action="#" method="post">
  <table class="table table-hover" id="tabla">
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Tiempo</th>
        <th>Comentarios</th>
        <th></th>
      </tr>
    </thead>
    <tbody>

<?php 		
	$info = $ROUTERS->ipHotspotUserGetall();

	foreach ($info as $i => $value) {
		$valor=$info[$i];
		echo 
		'<tr>
			<td>'.$valor['.id'].'</td>
			<td>'.$valor['name'].'</td>
			<td>'.$valor['uptime'].'</td>
			<td>'.$valor['comment'].'</td>
			<td>
				<input id="submit_button" class="btn btn-primary" type="submit" value="Del" />
				<input name="profile" type="hidden" value="'.$valor['.id'].'" />
			</td>
		</tr>';
	}

?>
    </tbody>
  </table>
  <input type="hidden" name="action" value="userDel"/>
 </form>


 	<div>
		<label> Creación de usuarios para RouterOS <label><br />
	</div>	

	<br>
	<div>
		<label>
<?php 		
	if($mensajeRespuestaUserAdd!=''){
		echo $codigoRespuestaUserAdd."::".$mensajeRespuestaUserAdd."<br><br>";
	}
	if($mensajeRespuestaUserRemove!=''){
		echo $codigoRespuestaUserAdd."::".$mensajeRespuestaUserRemove."::idUser::".$user."<br><br>";
	}
?>
		</label>
	</div>
	

	<form class="contacto" id="addUsers" action="#" method="POST" enctype="multipart/form-data"> 
	  <table class="table2" id="tablaReg">
		<thead>
		  <tr>
			<th width=10></th>
			<th width=50>Usuario</th>
			<th width=200>Clave</th>
			<th width=200>Tiempo</th>
			<th width=100>Perfil</th>
			<th width=100>Comentarios</th>
		  </tr>
		</thead>
		<tbody>
		<tr>
			<td></td>
			<td><input id="name" type="text" name="name" size="10"></td>
			<td><input id="password" class="input" name="password" type="password" value="" size="15" /></td>
			<td><input id="uptime" class="input" name="uptime" type="text" value="01:00:00" size="6" /></td>
			<td> <select id="profile_name" name="profile_name" > 
				<?php 		
					$info = $ROUTERS->ipHotspotUserProfileGetall();
					foreach ($info as $i => $value) {
						$valor=$info[$i];
						echo '<option id="'.$valor['.id'].'" value="'.$valor['name'].'">'.$valor['name'].'</option>';
					}
				?>			
			</td>
			<td><textarea id="comentario" class="input" name="comentario" rows="3" cols="30"></textarea><br /></td>
			
			<td><input type="submit" class="btn btn-primary" value="Agregar">
				<input type="hidden" name="action" value="userAdd"/>
		</tr>
		</tbody>
	  </table>
	</form>	

</div>


