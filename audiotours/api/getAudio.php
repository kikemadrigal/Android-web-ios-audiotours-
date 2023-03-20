<?php
header('Content-Type: application/json');
header("access-control-allow-origin: *");
include_once("../app/database/MysqliClient.php");
require_once("../app/config/env.php");

Class AudioApi {}

if(isset($_GET['id'])) $id=$_GET['id'];

$basededatos= new MysqliClient();
$basededatos->conectar_mysql();
$consulta  = "SELECT * FROM audios WHERE id='".$id."'";
$resultado=$basededatos->ejecutar_sql($consulta);
while ($linea = mysqli_fetch_array($resultado)) 
{
    $audio=new AudioApi();
    $audio->id=$linea['id'];
    $audio->name=$linea['name'];
    $audio->path=$linea['path'];
    $audio->date=$linea['date'];
}
$basededatos->desconectar();

echo json_encode($audio);

?>