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

	$unidadOriginal 	= array("s", "m", "h", "d", "w");
	$valores			= array("");
	$unidadFormateado   = array(" Segundo"," Minuto", " Hora", " Dia", " Semana");
	$unidadMayores   = array(" Segundos"," Minutos", " Horas", " Dias", " Semanas");
		
	$info = $ROUTERS->ipHotspotUserGetall();

	foreach ($info as $i => $value) {
		$valor=$info[$i];
		$unidad = $valor['limit-uptime'];
		$valor_sin_unidad = str_replace($unidadOriginal, $valores, $unidad);
		if ($valor_sin_unidad == '1'){
			$limite = str_replace($unidadOriginal, $unidadFormateado, $unidad);
		}else{
			$limite = str_replace($unidadOriginal, $unidadMayores, $unidad);	
		}
		echo 
		'<tr id="tr'.$valor['.id'].'">
				<td>'.$valor['.id'].'</td>
				<td>'.$valor['name'].'</td>
				<td>'.$valor['uptime'].'</td>
				<td>'.$valor['profile'].'</td>
				<td>'.$limite.'</td>
				<td>'.$valor['comment'].'</td>
				<td>
					<a style="text-decoration:underline;cursor:pointer;" onclick="eliminarDato(\''.$valor['.id'].'\')">Del</a>
				</td>
		</tr>
		';
	}

?>

</table>   
 </body>




