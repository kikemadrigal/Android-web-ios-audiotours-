<?php
//https://anexsoft.com/ejemplo-de-sqlite-con-php-y-pdo
class PdoSQLiteClient {
    private static $db = null;
    
    public static function initialize() {
        if(empty(self::$db)) {
            try {
                self::$db = new PDO('sqlite:RomDB.db');
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    public static function getInstance() {
        return self::$db;
    }
    /******************************ROMINFO ****************************/
    public static function getAllFromMsxdbRominfo(){
        $games=array();
        $sql="SELECT * FROM msxdb_rominfo";
        $PDOStatement=self::$db->prepare($sql);
        $PDOStatement->execute();
        $games = $PDOStatement->fetchAll();
        $PDOStatement->closeCursor();
        return $games;
    } 
    public static function getAllFromMsxdbRominfoWitnNameCompany(){
        $games=array();
        //Unimos las tablas msxdb_rominfo y msxdb_company!!!!
        $sql="Select i.GameID,i.GenMSXId,i.GameName,i.Year,c.shortname,i.Platform from msxdb_rominfo i LEFT OUTER JOIN msxdb_company c ON i.CompanyID1=c.company_id";
        $PDOStatement=self::$db->prepare($sql);
        $PDOStatement->execute();
        $games = $PDOStatement->fetchAll();
        $PDOStatement->closeCursor();
        return $games;
    } 
    public static function getAllFromMsxdbRominfoWitnNameCompanyAndCountry(){
        $games=array();
        //$sql="SELECT * FROM msxdb_rominfo";
        $sql="Select i.GameID,i.GenMSXId,i.GameName,i.Year,c.shortname,c.country,i.Platform from msxdb_rominfo i LEFT OUTER JOIN msxdb_company c ON i.CompanyID1=c.company_id";
        $PDOStatement=self::$db->prepare($sql);
        $PDOStatement->execute();
        $games = $PDOStatement->fetchAll();
        $PDOStatement->closeCursor();
        return $games;
    } 
    public static function getAllFromMsxdbRominfo4(){
        $games=array();
        //$sql="SELECT * FROM msxdb_rominfo";
        $sql="Select i.GameID,i.GenMSXId,i.GameName,i.Year,c.shortname,c.country,i.Platform,d.RomType from msxdb_rominfo i INNER JOIN msxdb_company c ON i.CompanyID1=c.company_id INNER JOIN msxdb_romdetails d ON i.GameID=d.GameID";
   
        /*$sql="Select i.GameID,i.GenMSXId,i.GameName,i.Year,i.CompanyID1,d.RomType,i.Platform from msxdb_rominfo i 
                INNER JOIN msxdb_romdetails d ON i.GameID=d.GameID";*/
            //INNER JOIN msxdb_company c ON i.CompanyID1=c.company_id";
            //
        $PDOStatement=self::$db->prepare($sql);
        $PDOStatement->execute();
        $games = $PDOStatement->fetchAll();
        $PDOStatement->closeCursor();
        return $games;
    } 
    /**********************COMPANY***************************/
    public static function getAllFromMsxdbCompany(){
        $publishers=array();
        $sql="SELECT * FROM msxdb_company";
        $PDOStatement=self::$db->prepare($sql);
        $PDOStatement->execute();
        $publishers = $PDOStatement->fetchAll();
        $PDOStatement->closeCursor();
        return $publishers;
    }

}


?>