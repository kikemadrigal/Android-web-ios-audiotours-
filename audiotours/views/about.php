<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mensaje="";
if (isset($_POST['submit'])){
    /****************************************
                        PRODUCTION                    
    ****************************************/ 
    /*if (PRODUCTION==1){

        $subject = "New message from gamesdb.tipolisto.es";
        if (mail(ADMINEMAIL,$subject,$_POST['text'])){
            $mensaje="Mensaje enviado al admimistrador, mira en correo no deseado / Message sent to admin, check spam.";
        }else{
            $mensaje= "Mensaje fallido / Message could not be sent";
        } 
    }else{
        require "./libraries/PHPMailer/Exception.php";
        require "./libraries/PHPMailer/PHPMailer.php";
        require "./libraries/PHPMailer/SMTP.php";


        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = "smtp.gmail.com";                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = EMAILSERVER;                     //SMTP username
            $mail->Password   = EMAILPASSWORD;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 465;        
            //Desde donde se va a enviar
            $mail->setFrom(EMAILSERVER, EMAILUSER);
            //a quien se le va a enviar
            $mail->addAddress(ADMINEMAIL, $_POST['userName']);    
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject =  "New message from gamesdb.tipolisto.es";
            $mail->Body    = $_POST['text'];
            $mail->send();
            $mensaje="Mensaje enviado al admimistrador / Message sent to administrator.";
        } catch (Exception $e) {
            $mensaje= "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }*/
}

include_once("./views/templates/document-start.php");
?>
<div class="row color-azul">
    <div class="col md-4 m-4">
        <br><br>
        <p>Somos dos amigos.</p>
        <p>Un abrazo.</p>
        <p>email:audiotour@audiotour.es</p>
        <p>Blog: <?php echo PATHSERVER;?>blog</p>
        <hr>
        <p>We are two friends.</p>
        <p>A hug.</p>
    </div>
    <div class="col md-8">
        <img class="img-fluid mt-4 rounded" src="<?php echo PATHIMAGES;?>amigos.png" />
    </div>
</div>



<!-- SEND EMAIL-->
<!--<div class="row col-md-12 text-center bg-warning">		
    <form class="form-horizontal" name="sendEmail" id="sendEmail" action="<?php echo PATHSERVER."about"?>" method="post">
        <div class="form-group m-4">
            <h3>Enviar mensaje al administrador / Send message to administrator</h3>
            <label for="error" class="control-label text-danger"><?php echo $mensaje;?></label>
        </div>    
        <div class="form-group m-4">
            <label for="userName" class="control-label">Name</label>
            <input type="text" class="form-control" name="userName" id="userName" title="El nombre debe de contener entre 4 y 15 letras o números sin espacios" placeholder="User:" pattern="[a-zA-Z0-9\d_]{4,15}" required />
        </div>
        <div class="form-group m-4">
            <label for="text" class="control-label">Text:</label>
            <textarea type='text' class='form-control' name='text' id='text' rows=3 cols=60 title='Enter instructions' placeholder="Text:" required></textarea>
        </div> 
        <div class="form-group m-4" > 
            <div class="col-md-offset-2" >
                <input type="submit" name="submit" class="button btn-primary btn-large" value="Send email" />
            </div>
        </div> 
    </form>
</div>-->
<?php include_once("./views/templates/document-end.php");?>