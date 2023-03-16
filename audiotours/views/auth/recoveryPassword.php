<?php 
/*
|--------------------------------------------------------------------------
| view rcoveryPassword
|--------------------------------------------------------------------------
| Conectada con app/controllers/authController::recoveryPassword()
| Muestra un formulario 
| 
*/
include_once("./views/templates/document-start.php");
?>
<div class="row text-center">		
    <h3>Enter your email</h3>
    <form class="form-horizontal col-lg-6 offset-lg-3" action="<?php echo PATHSERVER."Auth/recoveryPassword"?>" method="post">
    <div class="form-group">
            <label for="error" class="control-label text-danger"><?php echo $this->message;?></label>
    </div>    
    <div class="form-group">
            <label for="email" class="control-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" placeholder="email" required />
    </div>
       
    <p>You will receive a password in this email.</p>
        <br />
        <input type="hidden" name="codigoActivacion" id="codigoActivacion" value="<?php echo $this->codigoActivacion; ?>"  >
        <div class="form-group" > 
            <div class="col-md-offset-2" >
                <input type="submit" name="submit" class="button btn-primary btn-large" value="Reset password" />
            </div>
        </div> 
    </form>
    
</div>
<?php include_once("./views/templates/document-end.php");?>