<?php

class TourRepository{ 



	/**********************************************************************************************
	* 										SELECT
	**********************************************************************************************/

	public static function getById($id){
		$tour=null;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		//$consulta  = "SELECT * FROM tours WHERE id='".$id."' ";
		$consulta  = "SELECT id, name, X(coordinates) as latitude,  Y(coordinates) as longitude ,type,media, image, address, phone, web, blogUrl, description, date, userId FROM tours WHERE id='".$id."' ";
		
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			// $id $name $latitude $longitude	$type $media $description $date	$userId
			$tour=new Tour($linea['id']);
			$tour->setName($linea['name']);
			$tour->setLatitude($linea['latitude']);
			$tour->setLongitude($linea['longitude']);
			$tour->setType($linea['type']);
			$tour->setMedia($linea['media']);
			$tour->setImage($linea['image']);
			$tour->setBlogUrl($linea['blogUrl']);
			$tour->setAddress($linea['address']);
			$tour->setPhone($linea['phone']);
			$tour->setWeb($linea['web']);
			$tour->setDescription($linea['description']);
			$tour->setDate($linea['date']);
			$tour->setUserId($linea['userId']);
		}
		$basededatos->desconectar();
		return $tour;
	}





	/**
	 * Parametros:
	 * start registro de inicio
	 * end: maximos registros a buscar
	 */
	
	public static function getAll($start, $end){
		$tours=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT id, name, X(coordinates) as latitude, Y(coordinates) as longitude ,type,media, image, address, phone, web, blogUrl, description, date, userId, ST_Distance_Sphere(coordinates, POINT('37.97939959510765', '-1.063750001794439'), 6378000) as distances FROM tours ORDER BY distances ASC";
		//$consulta  = "SELECT id, name, X(coordinates) as latitude,  Y(coordinates) as longitude ,type,media, image, address, phone, web, blogUrl, description, date, userId FROM tours limit ".$start .", ".$end."";
		//$consulta  = "SELECT * FROM tours limit ".$start .", ".$end."";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$tour=new Tour($linea['id']);
			$tour->setName($linea['name']);
			$tour->setLatitude($linea['latitude']);
			$tour->setLongitude($linea['longitude']);
			$tour->setType($linea['type']);
			$tour->setMedia($linea['media']);
			$tour->setImage($linea['image']);
			$tour->setBlogUrl($linea['blogUrl']);
			$tour->setAddress($linea['address']);
			$tour->setPhone($linea['phone']);
			$tour->setWeb($linea['web']);
			$tour->setDescription($linea['description']);
			$tour->setDate($linea['date']);
			$tour->setUserId($linea['userId']);
			$tours[]=$tour;
		}
		$basededatos->desconectar();
		return $tours;
	}
	
	public static function getCountAll(){
		$toursCount=0;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT count(*) as count FROM tours";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$toursCount=$linea['count'];
		}
		$basededatos->desconectar();
		return $toursCount;
	}

	public static function getCountAutoincrement(){
		$toursAutoincrement=0;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME   = 'tours'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$toursAutoincrement=$linea['AUTO_INCREMENT'];
		}
		$basededatos->desconectar();
		return $toursAutoincrement;
		
	}

	public static function getAllByUser($idUser, $start, $end){
		$tours=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM tours WHERE userId='".$idUser."' limit ".$start .", ".$end."";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$tour=new Tour($linea['id']);
			$tour->setName($linea['name']);
			$tour->setLatitude($linea['latitude']);
			$tour->setLongitude($linea['longitude']);
			$tour->setType($linea['type']);
			$tour->setMedia($linea['media']);
			$tour->setImage($linea['image']);
			$tour->setBlogUrl($linea['blogUrl']);
			$tour->setAddress($linea['address']);
			$tour->setPhone($linea['phone']);
			$tour->setWeb($linea['web']);
			$tour->setDescription($linea['description']);
			$tour->setDate($linea['date']);
			$tour->setUserId($S);
			$tours[]=$tour;
		}
		$basededatos->desconectar();
		return $tours;
	}
    public static function getDistance($latitude, $longitude){
		//Web que explica como calcular las distancias
		//https://platzi.com/blog/calcula-distancias-con-mysql/
		$distance=0;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		//SELECT ST_Distance_Sphere(coordinates, POINT(37.9841832890429, -1.133493423950421), 6378000)  as distances FROM tours
        $consulta  = "SELECT  ST_Distance_Sphere(coordinates, POINT('".$latitude."', '".$longitude."'), 6378000) as distances FROM tours";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$distance=$linea['distances'];
		}
		$basededatos->desconectar();
		return $distance;
    }
	public static function getAllByName($name){
		$tours=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT id, name, X(coordinates) as latitude, Y(coordinates) as longitude ,type,media, image, address, phone, web, blogUrl, description, date, userId FROM tours WHERE name like '%".$name."%'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$tour=new Tour($linea['id']);
			$tour->setName($linea['name']);
			$tour->setLatitude($linea['latitude']);
			$tour->setLongitude($linea['longitude']);
			$tour->setType($linea['type']);
			$tour->setMedia($linea['media']);
			$tour->setImage($linea['image']);
			$tour->setBlogUrl($linea['blogUrl']);
			$tour->setAddress($linea['address']);
			$tour->setPhone($linea['phone']);
			$tour->setWeb($linea['web']);
			$tour->setDescription($linea['description']);
			$tour->setDate($linea['date']);
			$tour->setUserId($linea['userId']);
			$tours[]=$tour;
		}
		$basededatos->desconectar();
		return $tours;
	}

	/*
	INSERT INTO gamesUsers VALUES ( '', 'title', 'Cove', 'Instructions', 'Country()', 'Publisher', 'Developer', 'Year', 'Format', 'Genre', 'System', 'Programming', 'Sound', 'Control', '1', 'Languages', '1', '1', '1', '1', '1', '0' , 'Observations', '186');
	*/
	public static function insert($tour){
		$bd= new MysqliClient();
		$bd->conectar_mysql();
		if (!$bd->checkExitsToursTable()){
			echo "tours table not exists";
			die();
		} 
		//INSERT INTO tours VALUES ( '', 'aa', POINT('37.98418328904296', '-1.133493423950421'),'0','0', '0', '0', '0','blog', 'description', '', '1') 
		$sql="INSERT INTO tours VALUES ( '', '".$tour->getName()."', POINT('".$tour->getLatitude()."', '".$tour->getLongitude()."'), '".$tour->getLatitude()."', '".$tour->getLongitude()."', '".$tour->getType()."', '".$tour->getMedia()."', '".$tour->getImage()."', '".$tour->getBlogUrl()."', '".$tour->getAddress()."','".$tour->getPhone()."','".$tour->getWeb()."','".$tour->getDescription()."', '".$tour->getdate()."', '".$tour->getUserId()."') ";
		$success=$bd->ejecutar_sql($sql);
		$lastId=$bd->getLastId();
		$bd->desconectar();
		return $lastId;
	}


	public static function update($tour){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        if (!$bd->checkExitsToursTable()){
            echo "Tours table not exists";
            die();
        }
		//update tours set name='un name', coordinates= POINT('37.98418328904296', '-1.133493423950421'), latitude='0', longitude='0', type='0', image='0', media='0', blogUrl='0', description='una descripcion', date='', userId='1' WHERE id='6';
		$sql="update tours set name='".$tour->getName()."', coordinates= POINT('".$tour->getLatitude()."', '".$tour->getLongitude()."'), latitude='".$tour->getLatitude()."', longitude='".$tour->getLongitude()."', type='".$tour->getType()."', media='".$tour->getMedia()."', image='".$tour->getImage()."', blogUrl='".$tour->getBlogUrl()."', address='".$tour->getAddress()."', phone='".$tour->getPhone()."', web='".$tour->getWeb()."', description='".$tour->getDescription()."', date='".$tour->getdate()."', userId='".$tour->getUserId()."' WHERE id='".$tour->getId()."'";
		//echo "update tours set name='".$tour->getName()."', coordinates= POINT('".$tour->getLatitude()."', '".$tour->getLongitude()."'), latitude='".$tour->getLatitude()."', longitude='".$tour->getLongitude()."', type='".$tour->getType()."', media='".$tour->getMedia()."', image='".$tour->getImage()."', blogUrl='".$tour->getBlogUrl()."', description='".$tour->getDescription()."', date='".$tour->getdate()."', userId='".$tour->getUserId()."' WHERE id='".$tour->getId()."'";
		$success=$bd->ejecutar_sql($sql);
        $bd->desconectar();
		return $success;
    }
	public static function updateUrlBlog($blogUrl, $id){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        if (!$bd->checkExitsToursTable()){
            echo "Tours table not exists";
            die();
        }
		//update tours set name='un name', coordinates= POINT('37.98418328904296', '-1.133493423950421'), latitude='0', longitude='0', type='0', image='0', media='0', blogUrl='0', description='una descripcion', date='', userId='1' WHERE id='6';
		$sql="update tours set blogUrl='".$blogUrl."' WHERE id='".$id."'";
		//echo "update tours set name='".$tour->getName()."', coordinates= POINT('".$tour->getLatitude()."', '".$tour->getLongitude()."'), latitude='".$tour->getLatitude()."', longitude='".$tour->getLongitude()."', type='".$tour->getType()."', media='".$tour->getMedia()."', image='".$tour->getImage()."', blogUrl='".$tour->getBlogUrl()."', description='".$tour->getDescription()."', date='".$tour->getdate()."', userId='".$tour->getUserId()."' WHERE id='".$tour->getId()."'";
		$success=$bd->ejecutar_sql($sql);
        $bd->desconectar();
		return $success;
    }

	public static function delete($id){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        if (!$bd->checkExitsToursTable()){
            echo "Tours table not exists";
            die();
        }
		//Para poder borrar un tour primero tenenemos que borrar la imagen de cabecera y el archivo de audio
		//Esto lo hacemos en el controller
        $sql="DELETE FROM tours WHERE id='".$id."' LIMIT 1";
        $success=$bd->ejecutar_sql($sql);
		if(!$success) echo "Hubo un problema y no se pud borrar";
        $bd->desconectar();
    }
}
?>