<?php
	header('Content-Type: application/json');
	header("access-control-allow-origin: *");
    require_once("../app/database/MysqliClient.php");
    require_once("../app/config/env.php");

    Class TourApi {}
	$tours=array();
    if(isset($_GET['page'])) $page=$_GET['page'];
    else $page=0;
    if(isset($_GET['lat'])) $lat=$_GET['lat'];
    if(isset($_GET['lng'])) $lng=$_GET['lng'];

    if(!isset($_GET['lat']) || !isset($_GET['lng'])){
        $tour=null;
    }else{
        $start=$page*10;
        $end=($page*10)+10;
        //$tours=TourRepository::getAll(0,200);
        $basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
        //$consulta  = "SELECT id, name, X(coordinates) as latitude, Y(coordinates) as longitude ,type,media, image, address, phone, web, blogUrl, description, date, userId FROM tours WHERE id<>1";
        $consulta  = "SELECT id, name, X(coordinates) as latitude, Y(coordinates) as longitude ,type,media, image, address, phone, web, blogUrl, description, date, userId, ST_Distance_Sphere(coordinates, POINT('".$lat."', '".$lng."'), 6378000) as distance FROM tours WHERE id<>1 ORDER BY distance ASC LIMIT ".$start.",".$end."";
        //$consulta  = "SELECT id, name, X(coordinates) as latitude, Y(coordinates) as longitude ,type,media, image, address, phone, web, blogUrl, description, date, userId, ST_Distance_Sphere(coordinates, POINT('".$lat."', '".$lng."'), 6378000) as distance FROM tours WHERE id<>1 ORDER BY distance ASC";
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
            $consultaAudio  = "SELECT * FROM audios WHERE id=".$linea['media']."";
            $resultadoAudio=$basededatos->ejecutar_sql($consultaAudio);
            while ($lineaAudio = mysqli_fetch_array($resultadoAudio)) 
            {
                $tour->nameAudio=$lineaAudio['name'];
                $tour->pathAudio=$lineaAudio['path'];
            }
            $tour->image=$linea['image'];
            $consultaImage  = "SELECT * FROM images WHERE id=".$linea['image']."";
            $resultadoImage=$basededatos->ejecutar_sql($consultaImage);
            while ($lineaImage = mysqli_fetch_array($resultadoImage)) 
            {
                $tour->nameImage=$lineaImage['name'];
                $tour->pathImage=$lineaImage['path'];
            }
            $tour->blogUrl=$linea['blogUrl'];
            $tour->address=$linea['address'];
            $tour->description=$linea['description'];
            $tour->date=$linea['date'];
            $tour->userId=$linea['userId'];
            $tour->distance=$linea['distance'];
            $tours[]=$tour;
        }
        $basededatos->desconectar();
      
    }
    
    echo json_encode($tours);
	
?>