<?php 
if (isset($_POST['submit'])){
	$user=new User($_POST['id']);
	$user->setName($_POST['name']);
	//$user->setPassword($_POST['password']);
	//$user->setRole($_POST['role']);
	$user->setEmail($_POST['email']);
	$user->setRealName($_POST['realName']);
	$user->setSurname($_POST['surname']);
	$user->setWeb($_POST['web']);
	//$user->setValidate($_POST['validate']);
	//$user->setCounter($_POST['counter']);
	//user->setDate($_POST['date']);
	//$user->setObservations($_POST['observations']);
	UserRepository::updateUser($user);
	echo "Updated";

}
$user=UserRepository::getUser($_SESSION['idusuario']);
if(empty($user)){
	echo "No user";
	die();
}
include_once("./views/templates/document-start.php");
?>
<h3>Update User</h3>
<form method=post action='<?php echo PATHSERVER."user/update"?>' class='form-horizontal' enctype='multipart/form-data'>
	<div class='form-group' >
        <label for='name' class='control-label col-md-2'>name:</label>
        <div class='col'>
            <input type='text' class='form-control' name='name' id='name' size=80 name='name is required' value='<?php echo $user->getName(); ?>' required  />
        </div>
    </div> 
	<div class='form-group' >
        <label for='email' class='control-label col-md-2'>email:</label>
        <div class='col'>
            <input type='text' class='form-control' name='emailFake' id='emailFake' size=80 value='<?php echo $user->getEmail(); ?>'  disabled/>
        </div>
    </div> 
	<div class='form-group' >
        <label for='realName' class='control-label col-md-2'>realName:</label>
        <div class='col'>
            <input type='text' class='form-control' name='realName' id='realName' size=80  value='<?php echo $user->getRealName(); ?>'   />
        </div>
    </div> 
	<div class='form-group' >
        <label for='surname' class='control-label col-md-2'>surname:</label>
        <div class='col'>
            <input type='text' class='form-control' name='surname' id='surname' size=80 value='<?php echo $user->getSurname(); ?>'   />
        </div>
    </div> 
	<div class='form-group' >
        <label for='web' class='control-label col-md-2'>web:</label>
        <div class='col'>
            <input type='text' class='form-control' name='web' id='web' size=80  value='<?php echo $user->getWeb(); ?>'   />
        </div>
    </div> 

	<div class='col col-md-offset-2' >
		<input type="hidden" name="id" id="id" value='<?php echo $_SESSION['idusuario'] ?>' />
		<input type="hidden" name="email" id="email" value='<?php echo $user->getEmail() ?>' />
		<input type='submit' name="submit" id="submit" value='Update' class='btn btn-primary' ></input> 
		<a href="<?php echo PATHSERVER."resetPassword";?>" name="resetPassword" id="resetPassword" class='btn btn-warning' >Reset password</a> 
	</div>
</form>
        
<?php include_once("./views/templates/document-end.php");?>