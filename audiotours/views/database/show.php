<?php 

include_once("./views/templates/document-start.php");
$active=array();
//Llena un array con num entradas del valor del parámetro value, las keys inician en el parámetro start_index.
//array_fill(int $start_index, int $num, mixed $value): array
//https://www.php.net/manual/es/function.array-fill
$active=array_fill(0,4,"");
$active[0]="active";
include_once("./views/templates/barDatabase.php");
?>


<?php
    //Si no existen la estrutura de directorios y los archivos, los creamos
    FilesManager::createDirectoryTreeDatabase($_SESSION['idusuario']);
    $path="media/users/user".$_SESSION['idusuario']."/database/database.txt";
    $zipFile="media/users/user".$_SESSION['idusuario']."/database/database.zip";
    //Obtenemos todos los juegos
    $games=GameUserRepository::getAllGamesByUser($_SESSION['idusuario'], 0, 10000);
    FilesManager::WriteFile($path, $games);
    $zip = new ZipArchive();
    $zip->open($zipFile, ZipArchive::CREATE);
    $zip->addFile($path, 'database.txt');
    $zip->close();
    if(PRODUCTION==1){
        echo "<a href='".PATHSERVERSININDEX.$zipFile."' class='btn btn-outline-primary'>Download TXT</a><br>";
    }else{
        echo "<a href='".$zipFile."' class='btn btn-outline-primary'>Download TXT</a><br>";
    }
    


    $contenido="";
    $fichero=fopen($path,"r");
    for ($i = 0; $i < filesize($path); $i++) {
        $contenido=fgets($fichero,8192);
        $contenido.="<br>";
        echo $contenido;
    }
    fflush($fichero);
    fclose($fichero);



?>

<?php include_once("./views/templates/document-end.php");?>