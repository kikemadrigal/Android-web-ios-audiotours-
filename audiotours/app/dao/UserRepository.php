<?php

class UserRepository{
	public static function obtenerTodos(){
		$users=array();
		PdoMySQLClient::initialize();
		$sql="SELECT * FROM users";
		$users=PdoMySQLClient::execute($sql);
		if(empty($users)){
			return null;
		}
		PdoMySQLClient::close();
		return $users;
	}
	/**
	 * Esta función aparece en game/showByUser.php
	 */
	public static function getALLUsers(){
		$users=array();
		$user=null;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM users";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			$user=new User($linea['id']);
			$user->setName($linea['name']);
			//$user->setPassword($linea['password']);
			//$user->setRole($linea['role']);
			$user->setEmail($linea['email']);
			$user->setRealName($linea['realName']);
			$user->setSurname($linea['surname']);
			$user->setWeb($linea['web']);
			//$user->setValidate($linea['validate']);
			//$user->setCounter($linea['counter']);
			//$user->setDate($linea['date']);
			//$user->setView($linea['view']);
			//$user->setObservations($linea['observations']);
			$users[]=$user;
		}
		$basededatos->desconectar();
		return $users;
	}
	/**
	 * Esta función es utilizada em user/update
	 * tambien aparece en view/game/showAll.php
	 */
	public static function getUser($id){
		$user=null;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM users WHERE id='".$id."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			$user=new User($linea['id']);
			$user->setName($linea['name']);
			$user->setPassword($linea['password']);
			$user->setRole($linea['role']);
			$user->setEmail($linea['email']);
			$user->setRealName($linea['realName']);
			$user->setSurname($linea['surname']);
			$user->setWeb($linea['web']);
			$user->setValidate($linea['validate']);
			$user->setCounter($linea['counter']);
			$user->setDate($linea['date']);
			$user->setView($linea['view']);
			$user->setObservations($linea['observations']);
		}
		$basededatos->desconectar();
		return $user;
	}


	function obtenerNombreusuario($idusuario){
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT nombreusuario FROM users WHERE idusuario='".$idusuario."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['nombreusuario'];
		}
		$basededatos->desconectar();
	}
	public static function obteneridusuario($nombreusuario){
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT id FROM users WHERE name='".$nombreusuario."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['id'];
		}
		$basededatos->desconectar();
	}
	/**
	 * Esta función es utulizada en view/game/showUser
	 */
	public static function getViewUser($idUser){
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT view FROM users WHERE id='".$idUser."' LIMIT 1";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['view'];
		}
		$basededatos->desconectar();
	}
	/**
	 * Esta función aparece en auth/recoverPassword
	 */
	public static function obtenerNombreusuarioAtravesDeCorreo($email){
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT name FROM users WHERE email='".$email."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['name'];
		}
		$basededatos->desconectar();
		
	}
	function obtenerIdUsuarioAtravesDeCorreo($email){
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT idusuario FROM users WHERE email='".$email."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['idusuario'];
		}
		$basededatos->desconectar();
		
	}
	public static function obtenerNivelAccesoAtravesDeIdUsuario($idusuario){
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT role FROM users WHERE id='".$idusuario."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado )) 
		{
			return $linea['role'];
		}
		$basededatos->desconectar();
		
	}
	public static function enviarCorreoAlAdministrador($mensaje){
		$personaAEnviarCorreo="kikemadrigal@hotmail.com";
		$subject = "Nuevo mensaje de gestorwebs.tipolisto.es";
		$txt = "<html> <head> <title>gestorwebs.tipolisto.es</title> </head> <body><p>".$mensaje."</p></body></html>";
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: adm@gestorwebs.tipolisto.es" . "\r\n" ."CC: ";
		mail($personaAEnviarCorreo,$subject,$txt,$headers);
	}
	public static function generarCodigoActivacion($longitud,$especiales){
		// Array con los valores a escoger
		$clave="";
		$semilla = array();
		$semilla[] = array('a','e','i','o','u');
		$semilla[] = array('b','c','d','f','g','h','j','k','l','m','n','p','q','r','s','t','v','w','x','y','z');
		$semilla[] = array('0','1','2','3','4','5','6','7','8','9');
		$semilla[] = array('A','E','I','O','U');
		$semilla[] = array('B','C','D','F','G','H','J','K','L','M','N','P','Q','R','S','T','V','W','X','Y','Z');
		$semilla[] = array('0','1','2','3','4','5','6','7','8','9');
	
		// si puede contener caracteres especiales, aumentamos el array $semilla
		if ($especiales) { 
			$semilla[] = array('$','#','%','&amp;','@','-','?','¿','!','¡','+','-','*');
		}
	
		// creamos la clave con la longitud indicada
		for ($bucle=0; $bucle<$longitud; $bucle++)
		{
			// seleccionamos un subarray al azar
			$valor = mt_rand(0, count($semilla)-1);
			// selecccionamos una posición al azar dentro del subarray
			$posicion = mt_rand(0,count($semilla[$valor])-1);
			// cogemos el carácter y lo agregamos a la clave
			$clave .= $semilla[$valor][$posicion];
		}
		// devolvemos la clave
		return $clave;
	}
	//Esta función aparece en views/adm/user/showAll.php
	public static function obtenerTodosLosusers(){
		$users=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM users';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$usuario=new usuario($linea['idusuario']);
			$usuario->setNombreusuario($linea['nombreusuario']);
			$usuario->setClaveUsuario($linea['claveusuario']);
			$usuario->setNivelAccesoUsuario($linea['nivelaccesousuario']);
			$users[]=$usuario;
		}
		$basededatos->desconectar();
		return $users;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	/************************************************Acciones de registrar nuevo usuario y confirmar activacion por correo (acciones del 10 al 19)*************************************************************************************************************************************/	
		

	public static function crearNuevousuario(){
		?>
		<div class="row">
			<div class="panel panel-default text-center">
				<div class="panel-heading">
					<h3 class="panel-title">
						New user
					</h3>
				</div>
				<div class="panel panel-body">
					<form class="form-horizontal col-lg-6 offset-lg-3" method=post action="<?php echo PATHSERVER."register"?>">
						<div class="form-group">
							<label for="nombreusuario">Nombre de usuario<small>(requerido)</small></label>
							<input name="nombreusuario"  class="form-control" type="text" id="nombreusuario" value=""  required />
						</div>
						<div class="form-group">
							<label for="email" >Correo electr&oacutenico <small>(requerido)</small> </label>
							<input name="email" class="form-control" type="email" id="email" value="" required />
						</div>
						<div class="form-group">
							<label for="nombrerealusuario">Nombre </label>
							<input name="nombrerealusuario" class="form-control"  type="text" id="nombrerealusuario" value="" />
						</div>
						<div class="form-group">
							<label for="apellidosusuario">Apellidos </label>
							<input name="apellidosusuario"  class="form-control" type="text" id="apellidosusuario" value="" />
						</div>
						<div class="form-group">
							<label for="url">Web</label>
							<input name="webusuario"  class="form-control"  type="text" id="webusuario" />
						</div>
						<div class="form-group">
							<label for="claveusuario">Contraseña<small>(requerido)</small></label>
							<input name="claveusuario"  class="form-control" type="password" id="claveusuario" autocomplete="off"  required="required"/>
						</div>	
						<div class="form-group">
							<label for="clavedosusuario">Confirmar Contraseña <small>(requerido)</small></label>
							<input name="clavedosusuario"  class="form-control" type="password" id="clavedosusuario" autocomplete="off" />
						</div>		
						<div>Seguridad de la contraseña</div>
						<p><small>Un consejo: La contraseña debe tener, al menos, siete caracteres de longitud. Para hacerla más fuerte, utiliza mayúsculas y minúsculas, números y símbolos como ! " ? $ % ^ &amp; ).</small></p>
						¿Enviar Contraseña?
						<label for="enviarclave"><input type="checkbox" name="enviarclave" id="enviarclave" value="1"  /> Enviar esta contraseña al nuevo usuario por correo electrónico.</label></td>
						<input type="submit" name="submit" class="btn btn-default btn-primary" value="A&ntilde;adir nuevo usuario" >
					</form>
				</div><!--Final del panel body-->
			</div><!-- Final del panel -->
	
		</div><!--Final del row-->
        <?php
	}
	












	/**
	 * Esta función es utilizada en user/update
	 * también aparece en views/user/showAll.php
	 */
	
 	public static function updateUser($user){
		$bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="update users set name='".$user->getName()."', email='".$user->getEmail()."', realName='".$user->getRealName()."', surname='".$user->getSurname()."', web='".$user->getWeb()."', view='".$user->getView()."' where id='".$user->getId()."'";
        $bd->ejecutar_sql($sql);
        $bd->desconectar();	
		//echo "holaaaaa ";	
		//echo $user->getId();
	}
	

	
	
		
	/**
	 * Esta función aparece en auth/register y en auth/recoveryPassword
	 */
	public static function comprobarSiExisteCoreoYaRegistrado($correo){
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT email FROM users WHERE email='".$correo."' ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		$numeroFilas=mysqli_num_rows($resultado);
		if($numeroFilas==false){
			return false;	
		}else{
			return true;
		}
		$basededatos->desconectar();
	}	


		
	/***************************************************************Fin de acciones registrar nuevo usuario (del 10 al 19)******************************************************************/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
		
		
		
		
		
		
		
		/**************************************mostrar y actualizar*******************************************************************************************/
		//Esta función aparece en views/adm/user/show.php
		//Devuelve un usuario apartir de un idUsuario
		public static function mostrarUsuario($idusuario){
			$basededatos= new MysqliClient();
			$basededatos->conectar_mysql();
			$consulta  = "SELECT * FROM users WHERE idusuario='$idusuario' ";
			$resultado=$basededatos->ejecutar_sql($consulta);
			$bgcolor='#BBFFFF';
			while ($linea = mysqli_fetch_array($resultado )) 
			{
				/*
				private $idUsuario;
				private $nombreUsuario;
				private $claveUsuario;
				private $nivelAccesoUsuario;
				private $correoUsuario;
				private $nombreRealUsuario;
				private $apellidosUsuario;
				private $webUsuario;
				private $validadoUsuario;
				private $contadorUsuario;
				private $fechaRegistroUsuario;
				private $datosUsuario;
				*/
				$usuario=new Usuario($linea['idusuario']);
				$usuario->setNombreUsuario($linea['nombreusuario']);
				$usuario->setCorreoUsuario($linea['email']);
				$usuario->setNombreRealUsuario($linea['nombrerealusuario']);
				$usuario->setApellidosUsuario($linea['apellidosusuario']);
				$usuario->setWebUsuario($linea['webusuario']);
				$usuario->setValidadoUsuario($linea['validadousuario']);
				$usuario->setContadorUsuario($linea['contadorusuario']);
				$usuario->setFechaRegistroUsuario($linea['fechausuario']);
				$usuario->setDatosUsuario($linea['datosusuario']);
			}
			$basededatos->desconectar();
			return $usuario;
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		
		
		
		
		function aplicarActualizacionusuario($idusuario){
			$_POST[claveusuarioactualizar]=sha1($_POST[claveusuarioactualizar]);
			$mensaje="usuario ".obtenerNombreusuario($idusuario)." actualizado.";
			$bd= new MysqliClient();
			$bd->conectar_mysql();
			$sql="update users set claveusuario='$_POST[claveusuarioactualizar]', email='$_POST[email]', nombrerealusuario='$_POST[nombrerealusuario]', apellidosusuario='$_POST[apellidosusuario]', webusuario='$_POST[webusuario]' where idusuario='$idusuario'";
			$bd->ejecutar_sql($sql);
			$bd->desconectar();
			echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/$pagina?mensaje=$mensaje';</script>";
		}
		
		
		
		
		/************************************Fin demostrar y actualizar users*******************************************************************************/
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
	/*************************************También está el botón de acceder, para que acceda un usuario registrado (acciones del 20 al 29)*************************************************/

	public static function controlUsuarios($usuario, $clave){ //Accion 21
			//$clave=sha1($clave);
			//$pagina=$_POST['pagina'];
			include_once("./app/MysqliClient.php");
			$basededatos= new MysqliClient();
			$basededatos->conectar_mysql();
			
			$consulta  = "SELECT * FROM users WHERE nombreusuario='".$usuario."' ";
			$resultado=$basededatos->ejecutar_sql($consulta);
			$total_registros = mysqli_num_rows ($resultado);
			if($total_registros==false){
				$mensaje= "El nombre de usuario no existe.";
				echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/gestionarusers.php?mensaje=$mensaje&accion=20'</script>";
			}else{
				while ($linea = mysqli_fetch_array($resultado )) 
				{
							if($linea['nombreusuario']==$usuario){
								if($linea['claveusuario']==sha1($clave)){
									if( $linea['validadousuario'] == '0'){
										$_SESSION['nombreusuario']=$linea['nombreusuario'];
										$_SESSION['claveusuario']=$linea['claveusuario'];
										$_SESSION['idusuario']=$linea['idusuario'];
										$_SESSION['validadousuario']=$linea['validadousuario'];
										$_SESSION['nivelaccesousuario']=$linea['nivelaccesousuario'];
										$idusuario=$linea['idusuario'];
										$mensaje="Usuario: ".$_SESSION['nombreusuario'].", clave ".$linea['claveusuario'];
										echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/gestionarusers.php?idusuario=$idusuario&accion=15&mensaje=$mensaje'</script>";
									//Si el usurio está ya validado...
									}else{
										$_SESSION['claveusuario']=$linea['claveusuario'];
										$_SESSION['idusuario']=$linea['idusuario'];
										 ?>
										<script type='text/javascript'>
											document.cookie = 'idusuario=<?php echo $linea['idusuario'];?>; expires=Thu, 18 Dec 2020 12:00:00 UTC'; 
										</script>
										<?php
										$_SESSION['nombreusuario']=$linea['nombreusuario'];
										$_SESSION['nivelaccesousuario']=$linea['nivelaccesousuario'];
										$_SESSION['validadousuario']=$linea['validadousuario'];
										$mensaje="¡Hola!: ".$usuario;
										//echo "<script type='text/javascript'>location.href='index.php?mensaje=$mensaje'</script>";
										header('Location: '.$_SERVER['PHP_SELF']);
									}
								}else{
									$mensaje= "La clave del usuario ".$usuario." es incorrecta.";
									echo "<script type='text/javascript'>location.href='gestionarusers.php?mensaje=$mensaje&accion=20'</script>";
								}
							}else{
								echo "";
							}
				}
			}
			$basededatos->desconectar();
			return $mensaje;
		}
		
	/***********************************************Fin de acceder users ya registrado (acciones del 20 al 29)********************************************************************************/
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/************************************Menu si se le olvido la clave (del 30 al 39)*******************************************************************************************/
		function enviarMensajeConNuevaClavePorOlvidoDeClave(){ //accion 30, se gnera un nuevo código de activación y se envía el correo por olvido de clave
			/*$codigoActivacion=sha1(generarCodigoActivacion(20,false));
			$personaAEnviarCorreo="kikemadrigal@hotmail.com";
			$subject = "Nuevo mensaje de gestorwebs.tipolisto.es";
			$txt = "<html> <head> <title>gestorwebs.tipolisto.es</title> </head> <body><p>".$mensaje."</p></body></html>";
			$headers = "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			$headers .= "From: adm@gestorwebs.tipolisto.es" . "\r\n" ."CC: ";
			mail($personaAEnviarCorreo,$subject,$txt,$headers);*/
			?>
		
			<form name="lostpasswordform" id="lostpasswordform" action="gestionarusers.php" method="post">
				<p>
				<label for="email">Correo electr&oacute;nico:<br>
				<input type="email" name="email" id="email" title="Introduzca un correo válido" required /></label>
				</p>
				<input type="hidden" name="accion" id="accion" value=31  />
				<input type="hidden" name="codigodeactivacion" id="codigodeactivacion" value='<?php echo $codigoActivacion; ?>'/ >
				<p><input type="submit" class="btn btn-primary btn-large" value="Obtener una contrase&ntilde;a nueva" /></p>
			</form>
		<?php
		}
		
		
		
		
		
		
		
		
		
		
		
		
		function mailActivationPorOlvidoDeClave($email, $codigoactivacion)//accion 31, obtenemos a través del correo el idusuario y el nombreusuario, le enviamos un email y le actualizamos la clave y el validadousuario a cero para que l epida cambiar contraseña
		{
				$existeCorreo=comprobarSiExisteCoreoYaRegistrado($email);
				if($existeCorreo==false){
					echo "<a href=$pagina?accion=30>Este correo no existe. Volver.</a>";
				}else{
					$idusuario=obtenerIdUsuarioAtravesDeCorreo($email);
					$nombreusuario=obtenerNombreusuarioAtravesDeCorreo($email);
	
	
					$codigoActivacion=generarCodigoActivacion(20,false);
					$bd= new MysqliClient();
					$bd->conectar_mysql();
					$sql="update users set claveusuario='$codigoactivacion', validadousuario='0' where idusuario='$idusuario'";
					$bd->ejecutar_sql($sql);
					$bd->desconectar();
	
	
	
					$subject = "Mensaje para recuperar clave en gestorwebs.tipolisto.es";
					$txt = "<html> <head> <title>gestorwebs.tipolisto.es</title> </head> <body><a href=http://www.gestorwebs.tipolisto.es/gestionarusers.php?accion=15&idusuario=$idusuario&claveusuario=$codigoactivacion&nombreusuario=$nombreusuario&mensaje=$mensaje>Recupera tu cuenta con Gestorpaginasweb.tipolisto.es pinchando aqu&iacute;.</a></body></html>";
					$headers = "MIME-Version: 1.0\r\n"; 
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
					$headers .= "From: adm@gestorwebs.tipolisto.es" . "\r\n" ."CC: ";
					mail($email,$subject,$txt,$headers);
	
					echo "<a href=gestionarusers.php?accion=20>Mensaje enviado a: ".$email.", id: ".$idusuario.", nombre: ".$nombreusuario." revisa tu correo. Volver.</a>";
					
					/*$subject = "Mensaje para recuperar clave en gestorwebs.tipolisto.es";
					$mensaje="Usuario:".$nombreusuario.",clave:".$codigoactivacion;
					$txt = "<html> <head> <title>Gestorpaginasweb.tipolisto.es</title> </head> <body><p>Usuario: ".$nombreusuario."</p><p>Contrase&ntilde;a: ".$codigoactivacion." </p><p><a href=http://www.gestorwebs.tipolisto.es/gestionarusers.php?accion=15&idusuario=$idusuario&codigoactivacion=$codigoactivacion&nombreusuario=$nombreusuario&mensaje=$mensaje>Recupera tu cuenta con Gestorpaginasweb.tipolisto.es pinchando aqu&iacute;.</a></p></body></html>";
					$headers = "MIME-Version: 1.0\r\n"; 
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
					$headers .= "From: ada@gestorwebs.tipolisto.es" . "\r\n" .
					"CC: ";
					mail($email,$subject,$txt,$headers);*/
					
				}
					
		}
		
		
		
		
		
		/************************************Fin de menu de olvido de clave*******************************************************************************************************/
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
		
	
	
	
	
	/*****************Estas dos acciones pueden ser utilizadas tanto por el menu de usuario nuevo que viene de registrase como por un o que se le olvido la contraseña*************************/
		
		
		
		function actualizarusuarioQueVieneDeRegistrarse($idusuario){ //accion 15
		?>
			
			 <p class='bg-danger'>Por favor, modifica tu contrase&ntilde;a: que se asign&oacute; por defecto.</p> 
			
			 <!-- <form class='form-horizontal' method='post' id='formulariorepitecontrasena' name='formulariorepitecontrasena'  > -->
			  <form  id='formulariorepitecontrasena' name='formulariorepitecontrasena' class='form-horizontal' method='post' action="gestionarusers.php" onsubmit="return validar()" > 
				  <div class='form-group' > 
						  <label for='claveusuario' class='control-label col-md-4'>Contrase&ntilde;a nueva</label>
						<div class='col-md-6'>
				
						   
						<!--  <input type='password'  class='form-control' id='claveusuario' name='claveusuario'  title='Debe contener 1 letra mayúscula, 1 letra minúscula, 1 número, minimo 5 caracteres' placeholder="Contrase&ntilde;a:" pattern="(?=^.{5,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$  " required="required" ></input>   -->
						 <input type='password'  class='form-control' id='claveusuario' name='claveusuario'  title='Minimo 5 caracteres, máximo 15' placeholder="Contrase&ntilde;a:" pattern="[a-zA-Z0-9\d_]{5,15}" required ></input> 
						</div>
				 </div>  
						
				 <div class='form-group' >   
							<label for='claveusuariodos' class='control-label col-md-4'>Repita la nueva contrase&ntilde;a:</label>
						   <div class='col-md-6'>
							<!--   <input type='password' class='form-control' id='claveusuariodos' name='claveusuariodos'  title='Debe contener 1 letra mayúscula, 1 letra minúscula, 1 número, minimo 5 caracteres' pattern="(?=^.{5,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$  " placeholder="Repite contrase&ntilde;a:" required="required"></input> --> 
							  <input type='password' class='form-control' id='claveusuariodos' name='claveusuariodos'  title='Minimo 5 caracteres, máximo 15'  placeholder="Repite contrase&ntilde;a:" pattern="[a-zA-Z0-9\d_]{5,15}" required></input>  
						   </div>
						  
				  </div>  
				 
				  <input type='hidden' name=accion value=16 ></input>  
					<input type='hidden' name='idusuario' value='<?php echo $idusuario; ?>' ></input>  
				   
				 <div class='form-group' > 
					 <div class='col-md-6 col-md-offset-4' >
								  <!-- <input type='button' id='btnEnviarFormularioRepiteContrasena' value='Actualizar'  /> -->
								<input type='submit' value='Actualizar' class="btn btn-primary"  />
					 </div>
				 </div> 
			  
			   </form>  
			   <div id="textoClave">&nbsp;</div>
			<?php
			
		}
		
		
		
		
		
		function validarusuario($idusuario,$claveusuario){ //accion 16, esta función recibo el formulario de cambio de contraseña y modifica a usuario validado, encripta la clave de usuario, y almacena la clave de usuario sin encriptar
			$nombreusuario=obtenerNombreusuario($idusuario);
			$nivelaccesousuario=obtenerNivelAccesoAtravesDeIdUsuario($idusuario);
			$claveusersha1=sha1($claveusuario);
			$bd= new MysqliClient();
			$bd->conectar_mysql();
			$sql="update users set validadousuario='1', claveusuario='$claveusersha1', datosusuario='$claveusuario' where idusuario='".$idusuario."'";
			if($bd->ejecutar_sql($sql)==null){
				$mensaje="No se pudo validar el usuario.";
			}else{
				session_start();
				$mensaje="¡Hola!:".$nombreusuario;
				$_SESSION['idusuario']=$idusuario;
				$_SESSION['nombreusuario']=$nombreusuario;
				$_SESSION['nivelaccesousuario']=$nivelaccesousuario;
				$_SESSION['validadousuario']=1;
			}
			$bd->desconectar();
			//echo "ide: "+$idusuario+", clave: "+$claveusuario+", nombre usuario: "+$nombreusuario+", clave sha1: "+$claveusersha1;
			echo "<script type='text/javascript'>location.href='http://www.gestorwebs.tipolisto.es/index.php?mensaje=$mensaje'</script>";
		}
		
		
		
		
	/************************Fin de las dos acciones compartidas porel menu de crear un usuario nuevo o olvido de contraseña*********************************************/
		
		
}

?>
	
	
	
	
	
	
	
	









	



	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	