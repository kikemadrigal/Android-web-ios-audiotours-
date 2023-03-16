<?php
/*
|--------------------------------------------------------------------------
| view mailValidation
|--------------------------------------------------------------------------
| Conectada con app/vontrollers/authController::mailValidation()
| Muestra un formulario que gestiona la contraseña enviada por el médodo GET
| del correo electrónico de un usuario que está intetando darse de alta
|
*/

//enviarCorreoAlAdministrador("En gestorwebs se ha confirmado el usuario: ".$nombreusuario.", se le han creado las tablas.");
include_once("./views/templates/document-start.php");
?>
<div class="row text-center">		
    <h3>Enter your password</h3>
    <form class="form-horizontal col-lg-6 offset-lg-3" name="registerform" id="registerform" action="<?php echo PATHSERVER."Auth/mailValidation"?>" method="post">
    <div class="form-group">
            <label for="error" class="control-label fs-1 fw-bold text-warning"><?php echo $this->message;?></label>
    </div>    
    <div class="form-group">
            <label for="password1" class="control-label">Password</label>
            <input type="password" class="form-control" name="password1" id="password1" title="The name must contain between 4 and 15 letters or numbers without spaces" placeholder="password 1" pattern="[a-zA-Z0-9\d_]{4,15}" required />
        </div>
        <div class="form-group">
            <label for="password2" class="control-label">Repeat password:</label>
            <input type="password" class="form-control" name="password2" id="password2"  placeholder="password 2" pattern="[a-zA-Z0-9\d_]{4,15}" required />
        </div> 
        <div class="form-group" > 
            <div class="col-md-offset-2" >
                <input type="submit" name="submit" class="button btn-primary btn-large" value="Registrarse" />
                <input type="hidden" name="nombreUsuario" value="<?php echo $this->nombreUsuario ?>" />
            </div>
        </div> 
    </form>
    <p><a href="<?php echo PATHSERVER."Auth/login";?>">Login</a> |<a href=""<?php echo PATHSERVER."Auth/recoverPassword";?>" title="Recover your password">Did you forget your password?</a></p>
    <p><a href="<?php echo PATHSERVER;?>" title="¿Te has perdido?">Volver a Gestor de webs</a></p>
</div>
<?php include_once("./views/templates/document-end.php");	


