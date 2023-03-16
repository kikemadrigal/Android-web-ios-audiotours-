<?php
/**
 * Para poder utilizar SQLite3 debes de modificar el php.ini
 * ;extension=pdo_pgsql
 * extension=pdo_sqlite
 * ;extension=pgsql
 * ;extension=shmop
 * 
 * ; The MIBS data available in the PHP distribution must be installed.
 * ; See http://www.php.net/manual/en/snmp.installation.php
 * ;extension=snmp
 * 
 * ;extension=soap
 * ;extension=sockets
 * ;extension=sodium
 * extension=sqlite3
 * ;extension=tidy
 * ;extension=xsl
 */
class SQLiteClient extends SQLite3 {
    private $pathDB;
    private $db;
    function __construct(){
        $this->open("RomDB.db");
    }
    /*function conectar_sqlite(){
        if($this->db){
            echo "<p>Exito al conectar ".$this->db.".</p>";
        }else{
            echo "<p>Error al conectar ".$this->db.".</p>";
        }
    }*/

    function delete_table_games(){
        
    }
    
}



?>