<?php
/*
|--------------------------------------------------------------------------
| view register
|--------------------------------------------------------------------------
| Conectada con app/controllers/authController::register()
| Muestra un formulario 
| 
*/
include_once("./views/templates/document-start.php");
?>
<!--pattern: text El nombre debe de contener entre 4 y 15 letras o números sin espacios: pattern="[a-zA-Z0-9\d_]{4,15}" -->	
<!-- email: [a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5} -->
<div class="row col-md-4 offset-md-4 text-center bg-warning">		
    <form class="form-horizontal" name="registerform" id="registerform" action="<?php echo PATHSERVER."Auth/register"?>" method="post">
        <div class="form-group m-4">
            <h3>Register on this site</h3>
            <label for="error" class="control-label text-danger"><?php echo $this->message;?></label>
        </div>    
        <div class="form-group m-4">
            <label for="nombreusuario" class="control-label">Name</label>
            <input type="text" class="form-control" name="nombreusuario" id="nombreusuario" title="El nombre debe de contener entre 4 y 15 letras o números sin espacios" placeholder="Nombre:" pattern="[a-zA-Z0-9\d_]{4,15}" required />
        </div>
        <div class="form-group m-4">
            <label for="correousuario" class="control-label">Email:</label>
            <input type="email" class="form-control" name="correousuario" id="correousuario" placeholder="Correo:" required />
        </div> 
        <p>You will receive a password in this email.</p>
        <br />
         <div class="form-group m-4" > 
            <div class="col-md-offset-2" >
                <input type="hidden" name="codigoActivacion" id="codigoActivacion" value="<?php echo $this->codigoActivacion; ?>"  >
                <input type="submit" name="submit" class="button btn-primary btn-large" value="Registrarse" />
            </div>
        </div> 
    </form>
    <p><a href="<?php echo PATHSERVER."Auth/login";?>">Login </a> | <a href="<?php echo PATHSERVER; ?>Auth/recoveryPassword" title="Recovery your password">Did you forget your password?</a></p>
    <p><a href="<?php echo PATHSERVER;?>" title=" | Are you lost?">return gamedb</a></p>
</div>
<?php
include_once("./views/templates/document-end.php");	
?>