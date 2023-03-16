<?php
//https://phpdelusions.net/pdo_examples/connect_to_mysql
class PdoMySQLClient {
    private static $db = null;
   
   
    public static function initialize() {
        if(empty(self::$db)) {
            try {
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false
                ];
                $charset = 'utf8mb4';
                
                $dsn = "mysql:host=".SERVER.";dbname=".DATABASE.";charset=$charset;port=3306";
                self::$db = new PDO($dsn, USER, PASSWORD, $options );
                self::$db->exec( 'SET CHARACTER SET UTF8' );
                //$db = new PDO('mysql:host  =' . SERVER . ';dbname  =' . DATABASE . ';charset =' . $charset ,  USER  ,  PASSWORD);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    public static function getInstance() {
        return self::$db;
    }

    public static function execute($sql){
        $PDOStatement=self::$db->prepare($sql);
        $PDOStatement->execute();
        $array = $PDOStatement->fetchAll();
        $PDOStatement->closeCursor();
        return $array;
    }


    public static function setAllMsxdbRominfo($games){
        foreach ($games as $posicion=>$game){
            if($game->CompanyID1==NULL) $game->CompanyID1="Desconocido";
            if($game->CompanyID2==NULL) $game->CompanyID2="Desconocido";
        
            //INSERT query with named placeholders
            $sql = "INSERT INTO games (id,title,cover,publisher,developer,year,system,user)  VALUES (?,?,?,?,?,?,?,92)";
            $stmt= self::$db->prepare($sql);
            $stmt->execute([$game->GameID, $game->GameName, $game->GenMSXId,$game->CompanyID1,$game->CompanyID2,$game->Year,$game->Platform]);
        
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
        }
    }
    public static function setAllMsxdbCompany($publishers){
        foreach ($publishers as $posicion=>$publisher){
            $sql = "INSERT INTO publishers (id,shortname,website,amateur,country,fullname,notes) VALUES (?,?,?,?,?,?,?)";
            $stmt= self::$db->prepare($sql);
            $stmt->execute([$publisher->company_id, $publisher->shortname, $publisher->website,$publisher->amateur,$publisher->country,$publisher->fullname,$publisher->notes]);
        }
    }
    public static function setAllMsxdbRominfoWithNameCompany($games){
        foreach ($games as $posicion=>$game){
            if($game->shortname==NULL) $game->shortname="unknown";
            $sql = "INSERT INTO games (id,title,cover,publisher,country,year,system,user)  VALUES (?,?,?,?,?,?,?,92)";
            $stmt= self::$db->prepare($sql);
            $stmt->execute([$game->GameID, $game->GameName, $game->GenMSXId,$game->shortname,$game->Year,$game->Platform]);
    
        }
    }
    public static function setAllMsxdbRominfoWithNameCompanyAndCountry($games){
        foreach ($games as $posicion=>$game){
            if($game->shortname==NULL) $game->shortname="unknown";
            if($game->country==NULL) $game->country="unknown";
           
            $sql = "INSERT INTO games (id,title,cover,publisher,country,year,system,user)  VALUES (?,?,?,?,?,?,?,92)";
            $stmt= self::$db->prepare($sql);
            $stmt->execute([$game->GameID, $game->GameName, $game->GenMSXId,$game->shortname,$game->country,$game->Year,$game->Platform]);
        }
    }
    public static function setAllMsxdbRominfo4($games){
        foreach ($games as $posicion=>$game){
            if($game->shortname==NULL) $game->shortname="unknown";
            if($game->country==NULL) $game->country="unknown";
            $sql = "INSERT INTO games (title,cover,publisher,country,format,year,system,user)  VALUES (?,?,?,?,?,?,?,92)";
            $stmt= self::$db->prepare($sql);
            $stmt->execute([$game->GameName, $game->GenMSXId,$game->shortname,$game->country,$game->RomType,$game->Year,$game->Platform]);
        }
    }
    public static function close(){
        self::$db->close();
    }


}


?>