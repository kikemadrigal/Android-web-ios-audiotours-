<?php
	header('Content-Type: application/json');
	header("access-control-allow-origin: *");
    require_once("../app/database/MysqliClient.php");
    require_once("../app/config/env.php");

    Class TourApi {}
	$tours=array();
    if(isset($_GET['maxMarkers'])) $end=$_GET['maxMarkers'];
    if(isset($_GET['lat'])) $lat=$_GET['lat'];
    if(isset($_GET['lng'])) $lng=$_GET['lng'];
    else $end=200;
	//$tours=TourRepository::getAll(0,200);
    $basededatos= new MysqliClient();
    $basededatos->conectar_mysql();
    $consulta  = "SELECT id, name, X(coordinates) as latitude, Y(coordinates) as longitude ,type,media, image, address, phone, web, blogUrl, description, date, userId, ST_Distance_Sphere(coordinates, POINT('".$lat."', '".$lng."'), 6378000) as distance FROM tours WHERE id<>1 ORDER BY distance ASC";
    //$consulta  = "SELECT id, name, X(coordinates) as latitude,  Y(coordinates) as longitude ,type,media, image, blogUrl, description, date, userId FROM tours limit 0, ".$end."";
    //$consulta  = "SELECT * FROM tours limit ".$start .", ".$end."";
    $resultado=$basededatos->ejecutar_sql($consulta);
    while ($linea = mysqli_fetch_array($resultado)) 
    {
        $tour=new TourApi();
        $tour->id=$linea['id'];
        $tour->name=$linea['name'];
        $tour->latitude=$linea['latitude'];
        $tour->longitude=$linea['longitude'];
        $tour->type=$linea['type'];
        $tour->media=$linea['media'];
        $tour->image=$linea['image'];
        $tour->blogUrl=$linea['blogUrl'];
        $tour->description=$linea['description'];
        $tour->date=$linea['date'];
        $tour->userId=$linea['userId'];
        $tour->distance=$linea['distance'];
        $tours[]=$tour;
    }
    $basededatos->desconectar();
	if($tours!=null){
        //$data = array("id" => 1, "name" => "ejemplo1", "email" => "email1");
        //echo json_encode($data);  

		echo json_encode($tours);	
	}
?>