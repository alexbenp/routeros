<?php 
include("control.php");
include("principal.php");
require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/Routers.php');
$action=$_REQUEST['action']; 
// $usuario_id = $_POST['id'];
$usuario_id = $_GET['id'];


$ipRB			= $_SESSION["ip"]; //IP de tu RB.
$Username		= $_SESSION["usuario"]; //Nombre de usuario con privilegios para acceder al RB
$clave			= $_SESSION["clave"]; //Clave del usuario con privilegios
$api_puerto		= $_SESSION["puerto"]; //Puerto que definimos el API en IP--->Services
$attempts 		= $_SESSION["reintentos_conexion"]; // Connection attempt count
$delay 			= $_SESSION["retraso_conexion"]; // Delay between connection attempts in seconds
$timeout 		= $_SESSION["tiempo_maximo_conexion"]; // Connection attempt timeout and data read timeout


$ROUTERS = new Routers($ipRB , $Username , $clave, $api_puerto, $attempts, $delay, $timeout);

if (!empty($usuario_id)) 
{
	
	if (($usuario_id =="")) 
	{ 
		echo "Todos los campos son obligatorios, por favor completa <a href=\"\">el formulario</a> nuevamente.";
	}else{
		$userRemove = $ROUTERS->ipHotspotUserRemove($usuario_id);
		$mensajeRespuestaUserRemove = $ROUTERS->getMensajeRespuesta();
		$codigoRespuestaUserRemove = $ROUTERS->getCodigoRespuesta();

	}
	
}else
?> 


<body>
		<div id="resultado"></div>
		
<?php 		
		if($mensajeRespuestaUserRemove!=''){
			echo $codigoRespuestaUserRemove."::".$mensajeRespuestaUserRemove."<br><br>";
		}
?>
		</div>

<div class="container">
  <div class="">
    <h1>Usuarios RouterOS</h1>
  </div>



 <table class="table table-hover" id="tabla">
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Tiempo Uso</th>
        <th>Profile</th>
		<th>Tiempo Limite</th>
        <th>Comentarios</th>
		<th></th>
      </tr>

<?php 		

	
	$arreglo = array("w"=>"Semana","d"=>"Dia","h"=>"Hora","m"=>"Minuto","s"=>"Segundo");
		
	$info = $ROUTERS->ipHotspotUserGetall();

	foreach ($info as $i => $value) {
		$linea = "";
		$valor=$info[$i];
		$id = $info[$i]['.id'];
		$unidad = $valor['limit-uptime'];
		$linea  = $ROUTERS->formateaUnidades($unidad);
		echo 
		'<tr id="tr'.$id.'">
				<td>'.$valor['.id'].'</td>
				<td>'.$valor['name'].'</td>
				<td>'.$valor['uptime'].'</td>
				<td>'.$valor['profile'].'</td>
				<td>'.$linea.'</td>
				<td>'.$valor['comment'].'</td>
				<td>
					<a style="text-decoration:underline;cursor:pointer;"  onclick="deleteInfo(\''.$id.'\',\'elimina_dato_router.php\')">Del</a>
				</td>
		</tr>
		';
	}
?>

</table>   
 </body>




