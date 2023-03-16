<?php include_once("./views/templates/document-start.php");
echo "<br><br><br>";
PdoMySQLClient::initialize();
$users=PdoMySQLClient::execute("Select * from users");
echo count($users);
foreach ($users as $user){
    //echo print_r($user);
    echo "<p>User: ".$user['id']."</p>";
    echo "<p>Name: ".$user['name']."</p>";
    echo "<p>Password: ".$user['password']."</p>";

}
 
 
include_once("./views/templates/document-end.php");
?>