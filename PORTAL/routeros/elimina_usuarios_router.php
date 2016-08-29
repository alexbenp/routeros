<?php 
include("control.php");
include("principal.php");
require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/Routers.php');
$action=$_REQUEST['action']; 

$ipRB="192.168.56.2"; //IP de tu RB.
$Username="admin"; //Nombre de usuario con privilegios para acceder al RB
$clave=""; //Clave del usuario con privilegios
$api_puerto=8728; //Puerto que definimos el API en IP--->Services
$attempts = 3; // Connection attempt count
$delay = 3; // Delay between connection attempts in seconds
$timeout = 3; // Connection attempt timeout and data read timeout

$ipRB			= $_SESSION["ip"]; //IP de tu RB.
$Username		= $_SESSION["usuario"]; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION["clave"]; //Clave del usuario con privilegios
$api_puerto		= $_SESSION["puerto"]; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION["reintentos_conexion"]; // Connection attempt count
$delay 			= $_SESSION["retraso_conexion"]; // Delay between connection attempts in seconds
$timeout 		= $_SESSION["tiempo_maximo_conexion"]; // Connection attempt timeout and data read timeout


$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);


if ($action=="userRemove") 
{ 
	$idborrado	=$_REQUEST['idborrado'];
	$name		=$_REQUEST['name']; 
	$password	=$_REQUEST['password']; 
	$uptime		=$_REQUEST['uptime'];
	$user_shared=$_REQUEST['user_shared'];
	$comentario	=$_REQUEST['comentario'];
	$rx			=$_REQUEST['rx']; 
	$tx			=$_REQUEST['tx'];
	if (($idborrado=="")) 
	{ 
		echo "Todos los campos son obligatorios, por favor completa <a href=\"\">el formulario</a> nuevamente.";
	}else{
		$userRemove = $ROUTERS->ipHotspotUserRemove($idborrado);
		$mensajeRespuestaUserRemove = $ROUTERS->getMensajeRespuesta();
		$codigoRespuestaUserRemove = $ROUTERS->getCodigoRespuesta();
		// echo "<pre>";
		// print_r($userRemove);
		// echo "</pre>";

	}
}

?> 
	<form class="contacto" id="contact_form" action="#" method="POST" enctype="multipart/form-data"> 
		<div>
			<label>
<?php 		
		if($mensajeRespuestaUserRemove!=''){
			echo $codigoRespuestaUserRemove."::".$mensajeRespuestaUserRemove."<br><br>";
		}
?>
			</label>
		<div>
			<label>Formulario para Eliminar los Usuarios<label>
		</div>
		<div> 
			<label>Ingrese ID usuario a Borrar:</label>
			<input id="idborrado" class="input" name="idborrado" type="text" value="" size="2" /> 
			<input type="hidden" name="action" value="userRemove"/>
			<input id="submit_button" class="btn btn-primary" type="submit" value="Borrar Usuario" />
		</div> 
		

		<br /><br /><br />
		
	 </form> 	

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
		</tr>';
	}

?>
    </tbody>
  </table>
 </form>



