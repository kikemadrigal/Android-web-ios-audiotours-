<?php include_once("./views/templates/document-start.php");
$active=array();
//Esto es para ponerle colorines a los botones
//Llena un array con num entradas del valor del parámetro value, las keys inician en el parámetro start_index.
//array_fill(int $start_index, int $num, mixed $value): array
//https://www.php.net/manual/es/function.array-fill
$active=array_fill(0,4,"");
$active[2]="active";
include_once("./views/templates/barDatabase.php");


$content="";
$mySqliClient=new MysqliClient();
$mySqliClient->conectar_mysql();
$tables=$mySqliClient->getTables();
foreach($tables as $posicion=>$table){
    if ($table=="gamesUsers" || $table=="gamesusers"){
        echo "--Table gamesUsers<br>";
        $content=$mySqliClient->getStringInsertTableGamesUsers();
    }
}
echo $content;







 include_once("./views/templates/document-end.php");?>