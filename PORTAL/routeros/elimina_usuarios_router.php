<?php 
include("control.php");
include("principal.php");
include("include/config.php");
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
    <h3 class="text-center text-success">Usuarios RouterOS<h3><br />
  </div>
  <table class="table table-hover" id="tabla">
	<div class="container">
		<div class="form-group">
			<tr>
				<th class="success"><label>Id</label></th>
				<th class="success"><label>Nombre</label></th>
				<th class="success"><label>Tiempo Uso</label></th>
				<th class="success"><label>Profile</label></th>
				<th class="success"><label>Tiempo Limite</label></th>
				<th class="success"><label>Comentarios</label></th>
				<th class="success"></th>
			</tr>
		</div>
	</div>

<?php 		

	
	// $arreglo = array("w"=>"Semana","d"=>"Dia","h"=>"Hora","m"=>"Minuto","s"=>"Segundo");
		
	$info = $ROUTERS->ipHotspotUserGetall();

	foreach ($info as $i => $value) {
		$linea = "";
		$valor=$info[$i];
		$id = $info[$i]['.id'];
		$unidad = $valor['limit-uptime'];
		$linea  = $ROUTERS->formateaUnidades($unidad);
		echo 
		'<tr id="tr'.$id.'">
				<td class="text-info">'.hexdec($valor['.id']).'</td>
				<td class="text-info">'.$valor['name'].'</td>
				<td class="text-info">'.$valor['uptime'].'</td>
				<td class="text-info">'.$valor['profile'].'</td>
				<td class="text-info">'.$linea.'</td>
				<td class="text-info">'.$valor['comment'].'</td>
				<td class="text-info">
					<a style="text-decoration:underline;cursor:pointer;"  onclick="deleteInfo(\''.$id.'\',\'elimina_dato_router.php\')">Del</a>
				</td>
		</tr>
		';
	}
?>

</table>   
 </body>




