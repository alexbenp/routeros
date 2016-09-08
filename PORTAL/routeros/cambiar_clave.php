<?php 
include("control.php");
include("include/config.php");
require_once("principal.php");
// require_once ('clases/Routers.php');
require_once ('clases/AuditoriaSysLog.php');
$action	=	$_REQUEST['action']; 

$validaSesion = new Menus($_SESSION['getPerfilId']);
$php_self = str_replace($ruta_instalacion,'',$_SERVER['REQUEST_URI']);
$validaSesion->getPageByName($php_self);


?>


<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1 class="text-center text-success">Cambiar Clave</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<form method="post" id="passwordForm">
				<input type="password" class="input-lg form-control" name="password3" id="password3" placeholder="Clave Actual" autocomplete="off">
				<div class="row">
					<div class="col-sm-12">
						<span id="antpwd" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> La nueva clave no puede ser igual a la actual.<br><br>
					</div>
				</div>

				
				<input type="password" class="input-lg form-control" name="password1" id="password1" placeholder="Nueva Clave" autocomplete="off">
				<div class="row">
					<div class="col-sm-6">
						<span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Minimo XX Caracteres<br>
						<span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Un Caracter en Mayuscula
					</div>
					<div class="col-sm-6">
						<span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span>Una Caracter en Minuscula<br>
						<span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Minimo XX Numeros
					</div>
				</div>
				
				<br>
				<input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Confirmar nueva Clave" autocomplete="off">
				<div class="row">
					<div class="col-sm-12">
					<span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Valida Clave
					</div>
				</div>
				<br>
				<input type="submit" id="" onclick="alert(boton)" class="col-xs-4 btn btn-primary btn-load btn-lg" data-loading-text="Cambiando Clave..." value="Cambiar Clave">
				<input type="hidden" name="action" value="1"/>
			</form>
		</div><!--/col-sm-6-->
	</div><!--/row-->
</div>

<script>
$("input[type=password]").keyup(function(){
    var ucase = new RegExp("[A-Z]+");
	var lcase = new RegExp("[a-z]+");
	var num = new RegExp("[0-9]+");

	if($("#password1").val().length >= 8){
		$("#8char").removeClass("glyphicon-remove");
		$("#8char").addClass("glyphicon-ok");
		$("#8char").css("color","#00A41E");

	}else{
		$("#8char").removeClass("glyphicon-ok");
		$("#8char").addClass("glyphicon-remove");
		$("#8char").css("color","#FF0004");

	}
	
	if(ucase.test($("#password1").val())){
		$("#ucase").removeClass("glyphicon-remove");
		$("#ucase").addClass("glyphicon-ok");
		$("#ucase").css("color","#00A41E");

	}else{
		$("#ucase").removeClass("glyphicon-ok");
		$("#ucase").addClass("glyphicon-remove");
		$("#ucase").css("color","#FF0004");

	}
	
	if(lcase.test($("#password1").val())){
		$("#lcase").removeClass("glyphicon-remove");
		$("#lcase").addClass("glyphicon-ok");
		$("#lcase").css("color","#00A41E");

	}else{
		$("#lcase").removeClass("glyphicon-ok");
		$("#lcase").addClass("glyphicon-remove");
		$("#lcase").css("color","#FF0004");

	}
	
	if(num.test($("#password1").val())){
		$("#num").removeClass("glyphicon-remove");
		$("#num").addClass("glyphicon-ok");
		$("#num").css("color","#00A41E");

	}else{
		$("#num").removeClass("glyphicon-ok");
		$("#num").addClass("glyphicon-remove");
		$("#num").css("color","#FF0004");

	}
	
	if($("#password1").val() == $("#password2").val()){
		$("#pwmatch").removeClass("glyphicon-remove");
		$("#pwmatch").addClass("glyphicon-ok");
		$("#pwmatch").css("color","#00A41E");
		if($("#password1").val() == $("#password3").val()){
			$("#antpwd").removeClass("glyphicon-ok");
			$("#antpwd").addClass("glyphicon-remove");
			$("#antpwd").css("color","#FF0004");
		}else{
			$("#antpwd").removeClass("glyphicon-remove");
			$("#antpwd").addClass("glyphicon-ok");
			$("#antpwd").css("color","#00A41E");
		}
	}else{
		$("#pwmatch").removeClass("glyphicon-ok");
		$("#pwmatch").addClass("glyphicon-remove");
		$("#pwmatch").css("color","#FF0004");
	}
	
});
</script>

<?php 
if($action =="1" ){
	
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$password3 = $_POST['password3'];
	
	if (empty($password1) or empty($password2) or empty($password3)){
		echo "Paramentros Invalidos<br>";
	}else{
		if($password1 !== $password2){
			echo "Error: La nueva clave y la confirmación no son iguales<br>";
		}else{
			if($password1 == $password3){
				echo "Error: La nueva clave es igual a la anterior<br>";
			}else{
				if(preg_match("/^.*(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/",$password1)){
					echo "ok";
				}else{
					echo "La clave no cumple criterios de seguridad<br>
					Clave que contengan al menos una letra mayúscula.<br>
					Clave que contengan al menos una letra minúscula.<br>
					Clave que contengan al menos un número o caracter especial.<br>
					Clave cuya longitud sea como mínimo 8 caracteres.<br>
					Clave cuya longitud máxima no debe ser arbitrariamente limitada.<br>
					";
				}
				
			   if (preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $password1)){     
			   echo "Su password es seguro.";   
			   }else{
				 echo "Su password no es seguro."; 
			   }
				
			}
		}
		
	}
	
	
	echo "<pre>";
	print_r($_REQUEST);
	echo "</pre>";
	
}
?>	