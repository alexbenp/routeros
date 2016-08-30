<?php 
include("control.php");
include("principal.php");
require_once ('clases/api.php'); //aqui incluimos la clase API para trabajar con ella
require_once ('clases/Routers.php');
$action=$_REQUEST['action']; 
$usuario_id = $_POST['id'];
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

if (!empty($usuario_id)) 
{ 
	// $idborrado	=$_REQUEST['idborrado'];
	// $name		=$_REQUEST['name']; 
	// $password	=$_REQUEST['password']; 
	// $uptime		=$_REQUEST['uptime'];
	// $user_shared=$_REQUEST['user_shared'];
	// $comentario	=$_REQUEST['comentario'];
	// $rx			=$_REQUEST['rx']; 
	// $tx			=$_REQUEST['tx'];
	// if (($idborrado=="")) 
	// { 
		// echo "Todos los campos son obligatorios, por favor completa <a href=\"\">el formulario</a> nuevamente.";
	// }else{
		// $userRemove = $ROUTERS->ipHotspotUserRemove($idborrado);
		// $mensajeRespuestaUserRemove = $ROUTERS->getMensajeRespuesta();
		// $codigoRespuestaUserRemove = $ROUTERS->getCodigoRespuesta();
		// // echo "<pre>";
		// // print_r($userRemove);
		// // echo "</pre>";

	// }
	
	if (($usuario_id =="")) 
	{ 
		echo "Todos los campos son obligatorios, por favor completa <a href=\"\">el formulario</a> nuevamente.";
	}else{
		$userRemove = $ROUTERS->ipHotspotUserRemove($usuario_id);
		$mensajeRespuestaUserRemove = $ROUTERS->getMensajeRespuesta();
		$codigoRespuestaUserRemove = $ROUTERS->getCodigoRespuesta();
		
		// echo "<pre>";
		// print_r($userRemove);
		// echo "</pre>";

	}
	
}

?> 

<body>
	<!-- <form class="contacto" id="contact_form" action="#" method="POST" enctype="multipart/form-data"> 
	-->
		<div id="delete-ok">
		
<?php 		
		if($mensajeRespuestaUserRemove!=''){
			echo $codigoRespuestaUserRemove."::".$mensajeRespuestaUserRemove."<br><br>";
		}
?>
		</div>
		<!--<div>
			<label>Formulario para Eliminar los Usuarios<label>
		</div>
		<div> 
			<label>Ingrese ID usuario a Borrar:</label>
			<input id="idborrado" class="input" name="idborrado" type="text" value="" size="2" /> 
			<input type="hidden" name="action" value="userRemove"/>
			<input id="submit_button" class="btn btn-primary" type="submit" value="Borrar Usuario" />
		</div> 
		

		<br /><br /><br />
		-->
		
	 <!-- </form> -->	

<div class="container">
  <div class="">
    <h1>Usuarios RouterOS</h1>
  </div>
<!-- <form id="Usuarios" action="#" method="post"> -->


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
	// $info = $ROUTERS->ipHotspotUserGetall();

	// foreach ($info as $i => $value) {
		// $valor=$info[$i];
		// echo 
		// '<tr>
			// <td>'.$valor['.id'].'</td>
			// <td>'.$valor['name'].'</td>
			// <td>'.$valor['uptime'].'</td>
			// <td>'.$valor['comment'].'</td>
			// <td>'.$valor['comment'].'</td>
		// </tr>';
	// }

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
		'<div><tr>
				<td>'.$valor['.id'].'</td>
				<td>'.$valor['name'].'</td>
				<td>'.$valor['uptime'].'</td>
				<td>'.$valor['profile'].'</td>
				<td>'.$limite.'</td>
				<td>'.$valor['comment'].'</td>
				<td>
				<div id="'.$valor['.id'].'" data="'.$valor['.id'].'">
					<a class="delete" >Eliminar</a>
				</div></td>
			</tr>
		</div>
		';
	}
	
?>
</table> 

<script type="text/javascript">

$(document).ready(function() {

	$('.delete').click(function(){
	
		var parent = $(this).parent().attr('id');
		var service = $(this).parent().attr('data');
				
		var dataString = 'id='+service;
		
		$.ajax({
            type: "POST",
            url: "elimina_usuarios_router.php",
            data: dataString,
            success: function() {			
				$('#delete-ok').empty();
				 $('#delete-ok').append('<div class="correcto">Se ha eliminado correctamente el servicio con id='+service+'.</div>').fadeIn("slow");
				$('#'+parent).fadeOut("slow");
				//$('#'+parent).remove();
            }
        });
    });                 
});    
</script>

  
 </body>

<!-- </form> -->



