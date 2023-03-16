<?php 
/*
if (isset($partesRuta[3])){
    $path="media/users/user".$_SESSION['idusuario']."/database.csv";
    $zipFile="media/users/user".$_SESSION['idusuario']."/database.zip";
    $zip = new ZipArchive();
    $zip->open($zipFile, ZipArchive::CREATE);
    if (is_file($zipfile)) {
        $zip->addFile($path, $zipfile);
    }else{
        echo "zip no generado";
    }
    $zip->close();
   header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.$zipFile);
    header('Content-Length: ' . filesize($zipFile));
    readfile($zipFile);
    
}
*/
include_once("./views/templates/document-start.php");
$active=array();
//Llena un array con num entradas del valor del parámetro value, las keys inician en el parámetro start_index.
//array_fill(int $start_index, int $num, mixed $value): array
//https://www.php.net/manual/es/function.array-fill
$active=array_fill(0,4,"");
$active[1]="active";
include_once("./views/templates/barDatabase.php");
FilesManager::createDirectoryTreeDatabase($_SESSION['idusuario']);
$path="media/users/user".$_SESSION['idusuario']."/database/database.csv";
$pathZipFile="media/users/user".$_SESSION['idusuario']."/database/database.zip";

//Obtenemos todos los juegos de un usuario
$games=GameUserRepository::getAllGamesByUser($_SESSION['idusuario'],0,1000);
//Encabezado del archivo CSV
$titles=array("id","title","cover","instructions","country","publisher","developer","year","format","genre","system","programming","sound","control","players","languages","file","screenshot","video","web","iGoIt","broken","observations");
$fail=FilesManager::createCSVFile($path,$games,$titles);
if($fail){
    echo "Not found $path o $pathZipFile";
}
FilesManager::crearZip($path, $pathZipFile, StringManager::getLastWordFromPath($path));

if(PRODUCTION==1){
   echo "<a href='".PATHSERVERSININDEX.$pathZipFile."' class='btn btn-outline-primary'>Download CSV.zip file</a><br>";
   echo "<a href='".PATHSERVERSININDEX.$path."' class='btn btn-outline-primary'>Download CSV file</a><br>";
}else{
    echo "<a href='".PATHSERVER.$pathZipFile."' class='btn btn-outline-primary'>Download CSV.zip file</a><br>";
    echo "<a href='".PATHSERVER.$path."' class='btn btn-outline-primary'>Download CSV file</a><br>";
}

$content=FilesManager::read_File($path);
echo $content;

include_once("./views/templates/document-end.php");?>
