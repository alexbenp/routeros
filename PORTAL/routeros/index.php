<html>
	<head>
		<meta charset="utf-8">
		<title>Portal RouterOs</title>

		<link href="css/bootstrap.min.css" rel="stylesheet"> 
		   <meta name="viewport" content="width=device-width, initial-scale=1">
		</head>
	<p><h1 class="text-center"> INICIAR  SESION</h1></p>
	<p>
		<form name="ingreso" id="ingreso" action="ingreso.php" method="POST">
			<div class="container">
				<div class="form-group has-success">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="inputSuccess" class="col-lg-1 control-label">Usuario </label>
							<div class="col-lg-3">
								<input type="text" name="usuario" id="usuario" class="form-control" value=""  placeholder=" USUARIO" />
								</label>
							</div>
						</div>
				</div>
	</p>
	<p>
		<div class="form-group has-success">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="inputSuccess"  class="col-lg-1 control-label" >Contraseña</label>
					<div class="col-lg-4">
						<input type="password" class="form-control" name="clave" id="clave" placeholder="Contraseña">
					</div>
				</div>
		</div>
	</p>
	<p class="submit">
		<input type="submit" name="login" class="btn btn-success" value="Entrar" />
	</p>
	</form>
	</div>

	</div>