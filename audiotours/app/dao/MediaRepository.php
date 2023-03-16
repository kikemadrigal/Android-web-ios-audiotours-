<?php

class MediaRepository{

    public static function getAllImages(){
		$medias=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM images WHERE isHeader=0';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			if($linea['name'] != "." || $linea['name'] != ".."){
				/*
				if(PRODUCTION==1)$mediaFile=PATHSERVERSININDEX.$linea['path']."/".$linea['name'];
				else $mediaFile=PATHSERVER.$linea['path']."/".$linea['name'];
				$extension=pathinfo($mediaFile, PATHINFO_EXTENSION);
				*/
				$media=new Media($linea['id']);
				$media->setName($linea['name']);
				$media->setPath($linea['path']);
				$media->setIsHeader($linea['isHeader']);
				$media->setDate($linea['date']);
				$media->setTypeId($linea['typeId']);
				$media->setUserId($linea['userId']);
				$media->setTourId($linea['tourId']);
				$medias[]=$media;
			}
		}
		$basededatos->desconectar();
		return $medias;
	}
	public static function getAllAudios(){
		$medias=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = 'SELECT * FROM audios WHERE isHeader=0';
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			if($linea['name'] != "." || $linea['name'] != ".."){
				/*
				if(PRODUCTION==1)$mediaFile=PATHSERVERSININDEX.$linea['path']."/".$linea['name'];
				else $mediaFile=PATHSERVER.$linea['path']."/".$linea['name'];
				$extension=pathinfo($mediaFile, PATHINFO_EXTENSION);
				*/
				$media=new Media($linea['id']);
				$media->setName($linea['name']);
				$media->setPath($linea['path']);
				$media->setIsHeader($linea['isHeader']);
				$media->setDate($linea['date']);
				$media->setTypeId($linea['typeId']);
				$media->setUserId($linea['userId']);
				$media->setTourId($linea['tourId']);
				$medias[]=$media;
				
			}
		}
		$basededatos->desconectar();
		return $medias;
	}
	public static function getCountImagesAutoincrement(){
		$toursAutoincrement=0;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME   = 'images'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$toursAutoincrement=$linea['AUTO_INCREMENT'];
		}
		$basededatos->desconectar();
		return $toursAutoincrement;
		
	}
	public static function getCountAudiosAutoincrement(){
		$toursAutoincrement=0;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME   = 'audios'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$toursAutoincrement=$linea['AUTO_INCREMENT'];
		}
		$basededatos->desconectar();
		return $toursAutoincrement;
		
	}

	/**
	 * Esta función aparece en 
	 * 
	 */
	public static function getAllImagesByTour($tourId){
		$images=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		//Rypes=1 images, audios, videos
		$consulta  = "SELECT * FROM images WHERE tourId='".$tourId."' ORDER BY name";
		$resultado=$basededatos->ejecutar_sql($consulta);
		if($resultado==null) return null;
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$image=new Media($linea['id']);
			$image->setName($linea['name']);
			$image->setPath($linea['path']);
			$image->setIsHeader($linea['isHeader']);
			$image->setDate($linea['date']);
			$image->setTypeId($linea['typeId']);
			$image->setUserId($linea['userId']);
			$image->setTourId($linea['tourId']);
			$images[]=$image;
		}
		$basededatos->desconectar();
		return $images;
	}
	public static function getAllAudiosByTour($tourId){
		$audios=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		//Rypes=1 images, audios, videos
		$consulta  = "SELECT * FROM audios WHERE tourId='".$tourId."' ORDER BY name";
		$resultado=$basededatos->ejecutar_sql($consulta);
		if($resultado==null) return null;
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$audio=new Media($linea['id']);
			$audio->setName($linea['name']);
			$audio->setPath($linea['path']);
			$audio->setIsHeader($linea['isHeader']);
			$audio->setDate($linea['date']);
			$audio->setTypeId($linea['typeId']);
			$audio->setUserId($linea['userId']);
			$audio->setTourId($linea['tourId']);
			$audios[]=$audio;
		}
		$basededatos->desconectar();
		return $audios;
	}

	/**
	* Esta función es llamaa en views/
	*/
	public static function getImage($id){
		$image=1;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM images WHERE id='".$id."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$image=new Media($linea['id']);
			$image->setName($linea['name']);
			$image->setPath($linea['path']);
			$image->setIsHeader($linea['isHeader']);
			$image->setDate($linea['date']);
			$image->setTypeId($linea['typeId']);
			$image->setUserId($linea['userId']);
			$image->setTourId($linea['tourId']);
		}
		$basededatos->desconectar();
		return $image;
	}
	public static function getAudio($id){
		$audio=1;
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM audios WHERE id='".$id."'";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$audio=new Media($linea['id']);
			$audio->setName($linea['name']);
			$audio->setPath($linea['path']);
			$audio->setIsHeader($linea['isHeader']);
			$audio->setDate($linea['date']);
			$audio->setTypeId($linea['typeId']);
			$audio->setUserId($linea['userId']);
			$audio->setTourId($linea['tourId']);
		}
		$basededatos->desconectar();
		return $audio;
	}
	public static function insertImage($name, $path, $isHeader, $date ,$typeId, $userId, $tourId){
		$lastId=0;
		$basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
		//echo $name."-".$path."-".$date."-".$typeId."-".$userId."-".$tourId;
        $sql="INSERT INTO `images` ( `name`, `path`, `isHeader`, `date`, `typeId`,`userId`, `tourId`) VALUES 
        ( '$name', '$path', ".$isHeader.",'' ,'$typeId', '$userId', '$tourId') ";
		//echo "INSERT INTO `images` ( `name`, `path`, `isHeader`, `date`, `typeId`,`userId`, `tourId`) VALUES  ( '$name', '$path', '$isHeader','' ,'$typeId', '$userId', '$tourId') ";
        $basededatos->ejecutar_sql($sql);
		$lastId=$basededatos->getLastId();
        $basededatos->desconectar();
		return $lastId;
	}
	public static function insertAudio($name, $path, $isHeader, $date ,$typeId, $userId, $tourId){
		$lastId=0;
		//echo $name."-".$path."-".$date."-".$typeId."-".$userId."-".$tourId;
		$sql="INSERT INTO `audios` ( `name`, `path`, `isHeader`, `date`, `typeId`,`userId`, `tourId`) VALUES 
		( '$name', '$path', ".$isHeader.",'' ,'$typeId', '$userId', '$tourId') ";
		//echo "INSERT INTO `audios` ( `name`, `path`, `isHeader`, `date`, `typeId`,`userId`, `tourId`) VALUES ( '$name', '$path', '$isHeader','' ,'$typeId', '$userId', '$tourId') ";
		$basededatos= new MysqliClient();
        $basededatos->conectar_mysql();
        $basededatos->ejecutar_sql($sql);
		$lastId=$basededatos->getLastId();
        $basededatos->desconectar();
		return $lastId;
	}
	public static function updateImage($media){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
		//echo $name."-".$path."-".$date."-".$typeId."-".$userId."-".$tourId;
		$sql="update `images` set name='".$media->getName()."', path='".$media->getPath()."', isHeader=".$media->getIsHeader().", date='".$media->getDate()."', typeId='".$media->getTypeId()."', userId='".$media->getUserId()."', tourId='".$media->getTourId()."' WHERE id='".$media->getId()."'";
        $success=$bd->ejecutar_sql($sql);
        $bd->desconectar();
		return $success;
    }
	public static function updateAudio($media){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
		//echo $name."-".$path."-".$date."-".$typeId."-".$userId."-".$tourId;
		$sql="update `audios` set name='".$media->getName()."', path='".$media->getPath()."', isHeader=".$media->getIsHeader().", date='".$media->getDate()."', typeId='".$media->getTypeId()."', userId='".$media->getUserId()."', tourId='".$media->getTourId()."' WHERE id='".$media->getId()."'";
        $success=$bd->ejecutar_sql($sql);
        $bd->desconectar();
		return $success;
    }
	/**
 	* Esta dunción es llamada en views/media/
 	*/
	public static function deleteImage($id){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="DELETE FROM images WHERE id='".$id."' LIMIT 1";
        $success=$bd->ejecutar_sql($sql);
        $bd->desconectar();
		return $success;
    }
	public static function deleteAudio($id){
        $bd= new MysqliClient();
        $bd->conectar_mysql();
        $sql="DELETE FROM audios WHERE id='".$id."' LIMIT 1";
        $success=$bd->ejecutar_sql($sql);
        $bd->desconectar();
		return $success;
    }
}

?>