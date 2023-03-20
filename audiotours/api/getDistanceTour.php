<?php
header('Content-Type: application/json');
header("access-control-allow-origin: *");
include_once("../app/database/MysqliClient.php");
require_once("../app/config/env.php");

Class DistanceApi {}

if(isset($_GET['id'])) $id=$_GET['id'];
if(isset($_GET['latitude'])) $latitude=$_GET['latitude'];
if(isset($_GET['longitude'])) $longitude=$_GET['longitude'];

$distance=0;
$basededatos= new MysqliClient();
$basededatos->conectar_mysql();
$consulta  = "SELECT  ST_Distance_Sphere(coordinates, POINT('".$latitude."', '".$longitude."'), 6378000) as distance FROM tours ORDER BY distance ASC";
$resultado=$basededatos->ejecutar_sql($consulta);
while ($linea = mysqli_fetch_array($resultado)) 
{
    $distance=new DistanceApi();
    $distance->distance=$linea['distance'];

}
$basededatos->desconectar();

echo json_encode($distance);

?>


