<?php
header('Content-Type: application/json');
header("access-control-allow-origin: *");
include_once("../app/database/MysqliClient.php");
require_once("../app/config/env.php");

Class ImageApi {}

if(isset($_GET['id'])) $id=$_GET['id'];

$basededatos= new MysqliClient();
$basededatos->conectar_mysql();
$consulta  = "SELECT * FROM images WHERE id='".$id."'";
$resultado=$basededatos->ejecutar_sql($consulta);
while ($linea = mysqli_fetch_array($resultado)) 
{
    $image=new ImageApi();
    $image->id=$linea['id'];
    $image->name=$linea['name'];
    $image->path=$linea['path'];
    $image->date=$linea['date'];
}
$basededatos->desconectar();

echo json_encode($image);

?>