<?php 
/*
|--------------------------------------------------------------------------
| view resetPassword
|--------------------------------------------------------------------------
| Conectada con app/controllers/authController::resetPassword()
| Muestra un formulario 
| 
*/

include_once("./views/templates/document-start.php");
?>
<div class="row text-center">		
    <h3>Enter your new password</h3>
    <form class="form-horizontal col-lg-6 offset-lg-3" action="<?php echo PATHSERVER."Auth/resetPassword"?>" method="post">
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
                <input type="submit" name="submit" class="button btn-primary btn-large" value="Reset password" />
                <input type="hidden" name="id" value="<?php echo $_SESSION['idusuario'] ?>" />
            </div>
        </div> 
    </form>
    
</div>
<?php include_once("./views/templates/document-end.php");?>