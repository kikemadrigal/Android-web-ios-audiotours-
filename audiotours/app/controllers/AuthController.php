<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class AuthController extends BaseController{
    /*
    |--------------------------------------------------------------------------
    | AuthController
    |--------------------------------------------------------------------------
    |
    | Gestiona la autenticación de los usuarios
    |
    */


    function __construct()
    {
        parent::__construct(); 
    }
    public function index(){}


    /**
    * Muestra un formulario de autentiación o logil y lo enví a este mismo método donde se valida.
    * o muestra los errores de validación
    * @return void
    */
    public function login(){
        $mensaje="";
        if (isset($_POST['submit'])){
            $usuario=$_POST['nombreusuario'];
            $clave=$_POST['claveusuario'];
            $basededatos= new MysqliClient();
            $basededatos->conectar_mysql();
            //1. Obtenemos el usuario por su nombre
            $consulta  = "SELECT * FROM users WHERE name='".$usuario."' ";
            $resultado=$basededatos->ejecutar_sql($consulta);
            $total_registros = mysqli_num_rows ($resultado);
            if($total_registros==false){
                $mensaje= "El nombre de usuario no existe.";
            }else{
                while ($linea = mysqli_fetch_array($resultado )) 
                {
                    if($linea['name']==$usuario){
                        //2.Comprobamos su contraseña
                        if($linea['password']==sha1($clave)){
                             //Si el usurio no está validado...
                            if( $linea['validate'] == '0'){
                                $mensaje="El usuario necesita ser validado para continuar, vaya a:";
                                $mensaje.="The user needs to be validated to continue, go to:";
                                $mensaje.=PATHSERVER."auth/mailValidation/".$linea['name']."/".$linea['password'];
                            //Si el usurio si está validado...
                            }else{
                                $_SESSION['idusuario']=$linea['id'];
                                ?>
                                <script type='text/javascript'>
                                    document.cookie = 'idusuario=<?php echo $linea['id'];?>; expires=Thu, 18 Dec 2080 12:00:00 UTC'; 
                                </script>
                                <?php
                                $_SESSION['nombreusuario']=$linea['name'];
                                $_SESSION['nivelaccesousuario']=$linea['role'];
                                //Redireccionamos al iniciar sesión
                                header('Location: '.PATHSERVER);
                                if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."';</script>";
                            }
                        }else{
                            $mensaje= "La clave del usuario ".$usuario." es incorrecta.<br>";
                            $mensaje.="The user password ".$usuario." is incorrect.";
                        }
                    }
                }
            }
            $basededatos->desconectar();
        }
        $this->view->message=$mensaje;
        $this->view->render("auth/login");    
    }











    public function logout(){
        if(isset($_SESSION['idusuario'])){
            session_unset();
            session_destroy();
        }
        header('Location: '.PATHSERVER);
        if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."';</script>";    
    }

















    public function register(){
        $mensaje="";
        $codigoActivacion=null;
        if (isset($_POST['submit'])){
            $existeCorreo=UserRepository::comprobarSiExisteCoreoYaRegistrado($_POST['correousuario']);
            if ($existeCorreo){
            $mensaje="Este correo ya existe.";
            }else{
                $correoUsuario=$_POST['correousuario'];
                $usuario=$_POST['nombreusuario'];
                $fecha=date("d/m/Y");
                $codigoActivacion=sha1(UserRepository::generarCodigoActivacion(20,false));
                //Tenemos que guardar la contraseña hash generada automáticamente en la base de datos, le pondremos un 0 a usuario validado
                $bd= new MysqliClient();
                $bd->conectar_mysql();
                $sql="INSERT INTO users (id, name, password, role, email, realName, surname, web, validate, counter, date, view, token, observations)  VALUES ( '', '$usuario','$codigoActivacion', '3', '$correoUsuario', ' ', ' ', ' ', '0', 0, '$fecha', 2,'', 'clave generada por defecto') ";
                //$sql="INSERT INTO users (id, name, password, role, email, realName, surname, web, validate, counter, date, observations)  VALUES ( '', 'juan','12345', '3', 'juan@hotmail.com','nombre real', 'Sin apellido', 'Sin web', '0', 0, '12/12/2022', 'clave generada por defecto') ";
                if($bd->ejecutar_sql($sql)==null){
                    $mensaje="Error, no se pudo crear el usuario.";
                }
                $bd->desconectar();
                //Enviamos el mensaje
                $link=" Pincha en este enlace para terminar el registro en gamesdb.tipolisto.es<br>Click on this link to register at tipolisto.es";
                $link .=" ".PATHSERVER."auth/mailValidation"."/".$usuario."/".$codigoActivacion." ";  
                $mensaje=$this->sendMail($link, $correoUsuario);
            }
        }
        $this->view->message=$mensaje;
        $this->view->codigoActivacion=$codigoActivacion;
        $this->view->render("auth/register");    
    }





















    /**
    * Si no hay datos de formulario obtiene la clave sha1 almacenada en la base de datos
    * y la compara con la que viene del GET de clickar en el enlace del correo electrónico
    *
    * @return void
    */
    public function mailValidation($param=null){
        //En el index obtenemos el 
        $nombreUsuario=$param[0];
        $codigoDeActivacion=$param[1];
        $mensaje="";
        if (isset($_POST['submit'])){
            //echo "<h1>Eexiste submit</h1>";
            //Si son distintas las contraseñas las actualizamos en la base de datos, también ponemos que el usuario está validado a 1
            if($_POST['password1']!=$_POST['password2']){
                $mensaje="different password";
            }else{
                $claveUsuario=sha1($_POST['password1']);
                $idUsuario=UserRepository::obteneridusuario($_POST['nombreUsuario']);
                $mensaje="usuario ".$_POST['nombreUsuario']." actualizado.";
                $bd= new MysqliClient();
                $bd->conectar_mysql();
                $sql="update users set password='$claveUsuario', validate=1 where id='$idUsuario'";
                //echo "id ".$idUsuario.", clave: ".$claveUsuario;
                $bd->ejecutar_sql($sql);
                $bd->desconectar();

                $_SESSION['idusuario']=$idUsuario;
                ?>
                <script type='text/javascript'>
                    document.cookie = 'idusuario=<?php echo $idUsuario;?>; expires=Thu, 18 Dec 2080 12:00:00 UTC'; 
                </script>
                <?php
                $_SESSION['nombreusuario']=$_POST['nombreUsuario'];
                $_SESSION['nivelaccesousuario']=UserRepository::obtenerNivelAccesoAtravesDeIdUsuario($idUsuario);
                header('Location: '.PATHSERVER."home");
                if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."home';</script>";
            }

        }else{
            //Comprobamos que el código hash de la url es el mismo que el de la base de datos
            $basededatos= new MysqliClient();
            $basededatos->conectar_mysql();
            $consulta  = "SELECT id, password FROM users WHERE name='".$nombreUsuario."'";
            $resultado=$basededatos->ejecutar_sql($consulta);
            while ($linea = mysqli_fetch_array($resultado )) 
            {
                if($linea['password']==$codigoDeActivacion){
                    $idusuario=$linea['id'];
                    $mensaje="Usuario validado, ahora puedes utilizar la web! ".$nombreUsuario."<br>";
                    $mensaje.="Validated user, now you can use the web!".$nombreUsuario."<br>";
                }
            }
            $basededatos->desconectar();
        }
        $this->view->message=$mensaje;
        $this->view->nombreUsuario=$nombreUsuario;
        $this->view->render("auth/mailValidation");    
    }












    
    public function resetPassword(){
        $mensaje="";
        if (isset($_POST['submit'])){
            if($_POST['password1']!=$_POST['password2']){
                $mensaje="different password";
            }else{
                $claveUsuario=sha1($_POST['password1']);
                $bd= new MysqliClient();
                $bd->conectar_mysql();
                $sql="update users set password='$claveUsuario', validate=1 where id='$_SESSION[idusuario]'";
                $bd->ejecutar_sql($sql);
                $bd->desconectar();
                ?>
                <script type='text/javascript'>
                    document.cookie = 'idusuario=<?php echo $_SESSION['idusuario'];?>; expires=Thu, 18 Dec 2080 12:00:00 UTC'; 
                </script>
                <?php
                header('Location: '.PATHSERVER."user/update");
                if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."user/update';</script>";
            }
        }
        $this->view->message=$mensaje;
        $this->view->render("auth/resetPassword");    
    }
























    public function recoveryPassword(){
        $mensaje="";
        $codigoActivacion=null;
        if (isset($_POST['submit'])){
            $existeCorreo=UserRepository::comprobarSiExisteCoreoYaRegistrado($_POST['email']);
            if ($existeCorreo){
                $correoUsuario=$_POST['email'];
                $usuario=UserRepository::obtenerNombreusuarioAtravesDeCorreo($_POST['email']);
                $fecha=date("d/m/Y");
                $codigoActivacion=sha1(UserRepository::generarCodigoActivacion(20,false));
                //Tenemos que guardar la contraseña hash generada automáticamente en la base de datos, le pondremos un 0 a usuario validado
                $bd= new MysqliClient();
                $bd->conectar_mysql();
                $sql="INSERT INTO users (password)  VALUES ( '$codigoActivacion') ";
                //$sql="INSERT INTO users (id, name, password, role, email, realName, surname, web, validate, counter, date, observations)  VALUES ( '', 'juan','12345', '3', 'juan@hotmail.com','nombre real', 'Sin apellido', 'Sin web', '0', 0, '12/12/2022', 'clave generada por defecto') ";
                if($bd->ejecutar_sql($sql)==null){
                    $mensaje="Error, no se pudo crear el usuario.";
                }
                $bd->desconectar();
                $link = "Pincha en este enlace para recuperar tu cuenta en gamesdb.tipolisto.es<br>Click on this link to recover your account at tipolisto.es";
                $link .= PATHSERVER."auth/mailValidation"."/".$usuario."/".$codigoActivacion." ";      
                $mensaje=$this->sendMail($link, $correoUsuario);
            }else{
                $mensaje="The mail does not exist / Este correo ya existe.";
            }
        }
        $this->view->message=$mensaje;
        $this->view->codigoActivacion=$codigoActivacion;
        $this->view->render("auth/recoveryPassword");    
    }






    private function sendMail($link,$correoUsuario){
        $mensaje="";
        if (PRODUCTION==1){
            /****************************************
                            PRODUCTION                    
            ****************************************/ 
            $subject = "New message from gamesdb.tipolisto.es";   
            if (mail($correoUsuario,$subject,$link)){
                $mensaje="Revisa el correo ".$correoUsuario." para la activación, revisa el correo no deseado.<br>Check the email ".$correoUsuario." for activation, check spam.";
            }else{
                $mensaje= "Mensaje fallido";
            }            
        }else{
            /****************************************
                            DEVELOPMENT                    
            ****************************************/ 
            require_once "./libraries/PHPMailer/Exception.php";
            require_once "./libraries/PHPMailer/PHPMailer.php";
            require_once "./libraries/PHPMailer/SMTP.php";

            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = "smtp.gmail.com";                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = EMAILSERVER;                     //SMTP username
                $mail->Password   = EMAILPASSWORD;                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;        
                //Desde donde se va a enviar
                $mail->setFrom(EMAILSERVER, EMAILUSER);
                //a quien se le va a enviar
                //$usuario=$_POST['nombreusuario'];
                $mail->addAddress($correoUsuario, "User gamedb");    
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject =  "New message from gamesdb.tipolisto.es";
                //$link="<p> <a href='".PATHSERVER."auth/mailValidation"."/".$usuario."/".$codigoActivacion."'>Pincha en este enlace para recuperar tu cuenta en gamesdb.tipolisto.es<br>Click on this link to recover your account at tipolisto.es</a></p>";  
                $mail->Body    = "<html>  
                                    <head> 
                                        <title>gamesdb.tipolisto.es</title>                                 
                                    </head> 
                                    <body>
                                    ".$link."
                                    </body>  
                                </html>";
                $mail->send();
                $mensaje="Revisa el correo ".$correoUsuario." para la activación, revisa el correo no deseado.<br>Check the email ".$correoUsuario." for activation, check spam.";
            } catch (Exception $e) {
                $mensaje= "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }//Fin de si es la versión de desarrollo o producción
        return $mensaje;
    }
}