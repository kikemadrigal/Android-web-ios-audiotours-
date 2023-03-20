<?php
header('Content-Type: application/json');
header("access-control-allow-origin: *");
include_once("../app/database/MysqliClient.php");
require_once("../app/config/env.php");

$count=0;
$basededatos= new MysqliClient();
$basededatos->conectar_mysql();
$consulta  = "SELECT count(*) as count FROM tours";
$resultado=$basededatos->ejecutar_sql($consulta);
while ($linea = mysqli_fetch_array($resultado)) 
{
    $count=$linea['count'];
}
$basededatos->desconectar();
$data = array("count" => $count);
echo json_encode($count);
?>