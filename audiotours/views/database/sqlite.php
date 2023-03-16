<?php 
include_once("./views/templates/document-start.php");
$active=array();
//Llena un array con num entradas del valor del parámetro value, las keys inician en el parámetro start_index.
//array_fill(int $start_index, int $num, mixed $value): array
//https://www.php.net/manual/es/function.array-fill
$active=array_fill(0,4,"");
$active[3]="active";
include_once("./views/templates/barDatabase.php");
?> 
<br><br>
<a href='https://www.sqlite.org/download.html' target='_blanck'>https://www.sqlite.org/download.html</a>
es un sistema gestor de bases de datos portable y muy extendido. </p>

<?php
//********Obteniendo los datos con PDO del SQLITE3********** */
//PdoSQLiteClient::initialize();
//$games=array();
//$games=PdoSQLiteClient::getAllFromMsxdbRominfo4();
/***********************Final de SQLITE 3***********************/



/*****************Insertando los datos a MYSQL con PDO*********************/
//PdoMySQLClient::initialize();
//PdoMySQLClient::setAllMsxdbRominfo4($games);
/**********************Fin de insertar los datos ****************************/







include_once("./views/templates/document-end.php");?>
