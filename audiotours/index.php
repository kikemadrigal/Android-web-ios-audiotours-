<?php
//VERSION DEVELOPMENT
/**
 * Para la producción: 
 * 1.Cambia el archivo index.php por la versión producción o desarrollo
 * 2.Cambia la variable de entorno PRODUCTION que está en .env
 * 
 */
/*para trabajr con rutas:
1.Modicamos el archivo de host de windows(abrelo como admimistrador) que están en C:\Windows\System32\drivers\etc\hosts:
#---------------------
#   virtual hosts
#--------------------
127.0.0.1	audiotours.es

2.Modificamos los host virtuales de apache que están en C:\xampp\apache\conf\extra\httpd-vhosts.conf
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/gamedb"
    ServerName freetour.es
</VirtualHost>
*/
//El index hace de enrutador
session_start();

require_once("./app/config/env.php");
require_once("./app/Routes.php");
require_once("./app/controllers/BaseController.php");
require_once("app/controllers/ErrorController.php");
require_once("app/controllers/TourController.php");
require_once("app/controllers/ComentController.php");
require_once("./views/View.php");
require_once("./app/util/ValidateInput.php");

require_once('./app/util/Util.php');
//require_once('./app/util/StringManager.php');
require_once('./app/util/FilesManager.php');
//include_once("./app/util/RegisterValidator.php");

include_once("./app/models/Tour.php");
include_once("./app/models/Comment.php");
include_once("./app/models/User.php");
include_once("./app/models/Media.php");

require_once("./app/dao/UserRepository.php");
require_once("./app/dao/ComentRepositoty.php");
require_once('./app/dao/TourRepository.php');
include_once("./app/dao/MediaRepository.php");

include_once("./app/database/MysqliClient.php");
//include_once("./app/database/SQLiteClient.php");
//include_once("./app/database/PdoSQLiteClient.php");
//include_once("./app/database/PdoMySQLClient.php");


$routes=new Routes();









?>


		

