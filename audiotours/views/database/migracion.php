<?php include_once("./views/templates/document-start.php");
dibujarButtons();
?> 
<br><br>
<a href='https://www.sqlite.org/download.html' target='_blanck'>https://www.sqlite.org/download.html</a>
es un sistema gestor de bases de datos portable y muy extendido. </p>







<?php
//********Obteniendo los datos con PDO del SQLITE3********** */
PdoSQLiteClient::initialize();
$bd=PdoSQLiteClient::getInstance();
if($bd){
    echo "<p>Exito al conectar </p>";
}else{
    echo "<p>Error al conectar </p>";
}
$games=array();
//$sql="Select e.id,e.numero,e.nombre,v.matricula,g.nombre, e.empresa,e.estadentro, e.observaciones, e.taquilla, e.telefono, e.telefonodos, e.telefonotres, e.extension, e.sePuedeLlamar, e.tipoAcceso from empleados e LEFT OUTER JOIN grupos g ON e.grupo=g.id LEFT OUTER JOIN vehiculos v ON e.matricula=v.id";
$sql="SELECT * FROM msxdb_rominfo";
$PDOStatement=$bd->prepare($sql);
$PDOStatement->execute();
$games = $PDOStatement->fetchAll();
$PDOStatement->closeCursor();
/***********************Final de SQLITE 3***********************/

 

/*****************Insertando los datos a MYSQL con PDO*********************/
PdoMySQLClient::initialize();
$bd=PdoMySQLClient::getInstance();
if($bd){
    echo "<p>Exito al conectar </p>";
}else{
    echo "<p>Error al conectar </p>";
}
foreach ($games as $posicion=>$game){
    //INSERT query with positional placeholders
    /*
    $sql="INSERT INTO games (id,title,cover,publisher,developer,system,user) VALUES (?,?,?,?,?,?,?,92)";
    $PDOStatement=$bd->prepare($sql);
    $PDOStatement->execute(array('1', $game->GameID));
    $PDOStatement->execute(array('2', $game->GameName));
    $PDOStatement->execute(array('3', $game->GenMSXId));
    $PDOStatement->execute(array('4', $game->CompanyID1));
    $PDOStatement->execute(array('5', $game->CompanyID2));
    $PDOStatement->execute(array('6', $game->Year));
    $PDOStatement->execute(array('7', $game->Platform));
    */
    if($game->CompanyID1==NULL) $game->CompanyID1="Desconocido";
    if($game->CompanyID2==NULL) $game->CompanyID2="Desconocido";

    //INSERT query with named placeholders
    $sql = "INSERT INTO games (id,title,cover,publisher,developer,year,system,user)  VALUES (?,?,?,?,?,?,?,92)";
    $stmt= $bd->prepare($sql);
    $stmt->execute([$game->GameID, $game->GameName, $game->GenMSXId,$game->CompanyID1,$game->CompanyID2,$game->Year,$game->Platform]);
}
/**********************Fin de insertar los datos ****************************/

/*
$bd=new SQLiteClient();
if($bd){
    echo "<p>Exito al conectar </p>";
}else{
    echo "<p>Error al conectar </p>";
}

//$bd->exec('CREATE TABLE kikin (bar STRING)');
//$bd->exec("INSERT INTO kikin (bar) VALUES ('Esto es una prueba')");
$games=array();
$results = $bd->query('SELECT * FROM msxdb_rominfo');
while ($row = $results->fetchArray()) {
    $game=new Game($row['GameID']);
    $game->setTitle($row['GameName']);
    $game->setCover($row['GenMSXId']);
    $game->setPublisher($row['CompanyID1']);
    $game->setDeveloper($row['CompanyID2']);
    $game->setSystem($row['Platform']);
    $games[]=$game;
}
$bd->close();
echo "Obtenidos: ".count($games)."<br>";

foreach ($games as $posicion=>$game){

    $mysqliClient= new MysqliClient();
    $mysqliClient->conectar_mysql();
    $sql="INSERT INTO games (id,title,cover,publisher,developer,system,user) VALUES (
        '".$game->getId()."', 
        '".$game->getTitle()."',
        '".$game->getCover()."',
        '".$game->getPublisher()."',
        '".$game->getDeveloper()."',
        '".$game->getSystem()."',
        '92'
    )";
    //$sql="INSERT INTO games VALUES ('".$game->getId()."', '".$game->getTitle()."', '".$game->getCover()."', '".$game->getInstructions()."', '".$game->getCountry()."', '".$game->getPublisher()."', '".$game->getDeveloper()."', '".$game->getYear()."', '".$game->getFormat()."', '".$game->getGenre()."', '".$game->getSystem()."', '".$game->getProgramming()."', '".$game->getSound()."', '".$game->getControl()."', '".$game->getPlayers()."', '".$game->getLanguages()."', '1', '1', '1', '1', '".$game->getIGoIt()."', '".$game->getBroken()."' , '".$game->getObservations()."', '92')";
    $result=$mysqliClient->insert($sql);
    if($result==null) echo "<p>Error en ".$game->getId()."</p>";
    $mysqliClient->desconectar();
}




*/


function dibujarButtons(){
    ?>
    <a href='<?php echo PATHSERVER ?>database/show' class='btn btn-outline-primary btn-lg '>TXT</a>
    <a href="<?php echo PATHSERVER ?>database/csv" class="btn btn-outline-secondary btn-lg active">CSV</a>
    <a href="<?php echo PATHSERVER ?>database/mysql" class="btn btn-outline-success btn-lg" >MYSQL</a>
    <a href="<?php echo PATHSERVER ?>database/sqlite" class="btn btn-outline-danger btn-lg">sqlite</a>

    <?php
}

include_once("./views/templates/document-end.php");?>
