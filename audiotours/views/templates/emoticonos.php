<?php
//function recorrerEmoticonos($path){
	if(!isset($_GET['path'])){
		$path="imagenes/emoticonos/smiley/";
	}else{
		$path=$_GET['path'];
	}
	//echo $path;
	//abrimos el directorio
	$dir = opendir($path);
	//echo "<p>La ruta es: ".$path."</p>";
	//Mostramos las informaciones
	while ($elemento = readdir($dir))
	{ 
		if ($elemento=="." || $elemento=="..") {
				
		}else if(is_dir($elemento))//verificamos si es o no un directorio
		{
			echo "<h1>Hay una carpeta</h1>";
			$directorios[]=strtolower($elemento);
		}else{
			$archivos[]=strtolower($elemento);
		}
	}
		
		
	
		//Cerramos el directorio
		closedir($dir); 
		sort($archivos);  
		// (y mueves el puntero interno del array al principio ..) 
		reset($archivos);  
	
		// Lees tu array de $archivos 
	
		foreach ($archivos as $archivo){ 
			echo "<img src='/".$path.$archivo."' width='30' height='30' onclick='enviaremoticono(this.src)'></img>";
		} 
		foreach ($directorios as $carpeta){ 
			//echo "<a href=index.php?smiley=".$path.$carpeta."><img src=".$path.$archivo."></img>".$carpeta."</a><br />";
		} 
//}//Final de la funcion recorrer emoticonos
?>
