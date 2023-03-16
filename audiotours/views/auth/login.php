<?php
/*
|--------------------------------------------------------------------------
| view login
|--------------------------------------------------------------------------
| Conectada con app/controllers/authController::login
| Muestra un formulario que gestiona el login o entrada de usuarios registrados
| 
*/
include_once("./views/templates/document-start.php");
?>
<!--pattern: text El nombre debe de contener entre 4 y 15 letras o números sin espacios: pattern="[a-zA-Z0-9\d_]{0,50}" -->	
<!-- email: [a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5} -->
<br /><br />
<div class="row col-md-4 offset-md-4 text-center">
	<form name="loginForm" id="loginForm" class='form-horizontal loginForm'  action="<?php echo PATHSERVER."Auth/login" ?>" method="post">
		<div class="form-group m-4">
			<h3>Login</h3>
			<label for="error" class="control-label text-danger"><?php echo $this->message;?></label>
		</div> 
		<!--m4= es margin 4-->
		<div class='form-group m-4'>
			<label for="nombreusuario" class='control-label'>Name</label>
			<input type="text" class="form-control" name="nombreusuario" id="nombreusuario" title='Se necesita un nombre' placeholder="Nombre:" required />
		</div>
		<div class='form-group m-4'>
			<label for="claveusuario"  class='control-label'>Password</label>
			<input type="password" class="form-control" name="claveusuario" id="claveusuario"  title='Se necesita una clave' placeholder="Contrase&ntilde;a:" required />
		</div>
		<div class='form-group m-4' > 
			<input type="submit" name="submit" class="btn btn-primary btn-large" value="Acceder" />
			<br><a href="<?php echo PATHSERVER;?>Auth/recoveryPassword" class="control-label m-4" title="Recover your password">Have you lost your password??</a>
		</div> 
	</form>
</div>


