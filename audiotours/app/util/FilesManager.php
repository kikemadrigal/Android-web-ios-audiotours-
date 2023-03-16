<?php 

class FilesManager {
    /*
    r-lectura. Si no existe error.Cruso inicio
    r+-Lectura y escritura.Si no existe:error.Cursor inicio.
    w-Escritura. Si no existe:se creaa, cursor inicio
    w+ lectura y escritura. Si no existe se crea. Cursor inicio
    a-escritura. Si no existe se crea: cursor final
    a+Lectura y escritura. si no existe se crea,cursor final
    */
    public static function read_File($path){
        $chunksize = 1 * (1024 * 1024);
        //$total     = filesize($path);
        $buffer = '';
        $handle    = fopen($path, "r");
        while ( !feof( $handle ) ) {
            $buffer .= fread( $handle, $chunksize );
        }
        fclose( $handle );
        return $buffer;
    }
    public static function writeFile($path,$array){
        $fp = fopen($path, "w");
        //3.Escribimos en el archivo
        foreach ($array as $posicion=>$game){
            fwrite($fp, $game->toString()."\n\r");
        }
        fclose($fp);
    }
    /**
    * 
    * devuelve un tue si no encuentra el path del archivo a comprimir o el path del zip
    */
    public static function crearZip($path, $pathZipFile, $newName){
        if (is_file($path)) {
            return true;
        }
        //https://www.php.net/manual/es/class.ziparchive
        $zip = new ZipArchive();
        //https://www.php.net/manual/es/zip.constants.php#ziparchive.constants.overwrite
        //Si no queremos machacar su contenido pondremos ZipArchive::Crate
        $zip->open($pathZipFile, ZipArchive::OVERWRITE);
        if (is_file($pathZipFile)) {
            //Añade un fichero al archivo ZIP para la ruta dada
            //public ZipArchive::addFile(string $filepath,string $entryname = "")
            //$zip->addFile('/path/to/index.txt', 'newname.txt');
            $zip->addFile($path, $newName);
        }else{
            return true;
        }
        $zip->close();
        return true;
    }
    /**
    * 
    * 
    */
    public static function createCSVFile($path, $arrays, $titles){
        $fp = fopen($path, 'w+');
        fputcsv($fp, $titles,";");
        foreach($arrays as $posicion=>$valor){
            $string= $valor->toStringCSV();
            //Convertimos en un array los string que se ssaparan por un coma ","
            $array=explode("\,",$string);
            //Visualizar contenido
            /*
            $string=str_replace("\,",",",$string);
            echo "id"."   \t title  ".  " \t cover  "."  instructions  "."  country  "."  publisher  "."  developer  "."  year  "."  format  "."  genre  "."  system  "."  programming  "."  sound  "."  control  "."  players  "."  languages  "."  file  "."  screenshot  "."  video  "."  iGoIt  "."  broken  "."  observations"."<br>";
            echo $string."<br>";
            */
            fputcsv($fp, $array,";");
        }
        fclose($fp);
        //Ejemplo para convertir un array en csv:https://www.php.net/manual/es/function.fputcsv
        /*
        $lista = array (array('a1','a2',10), array('b1','b2',20), array('c1','c2',30),array('d1','d2',40));
        $lista1 = array ('a  aa', 'bb  b', 1547, '   dddd');
        $lista2 = array ('aaa', 'bbb', 1547, 'dddd');
        $lista3 = array ('aaa', 'bbb', 1547, 'dddd');
        fputcsv($fp, $lista1,";");
        fputcsv($fp, $lista2,";");
        fputcsv($fp, $lista3,";");
        foreach($lista as $valor){
            //Implode convierte un array en un string
            $texto=implode($valor);
            echo $texto.";";
        }
        echo "<br>";
        */
    }


    public static function createDirectoryTreeDatabase($idUser){
        if (!file_exists("media/users")) {
            mkdir("media/users", 0777, true);
        }
        if (!file_exists("media/users/user".$idUser)) {
            mkdir("media/users/user".$idUser, 0777, true);
        }
        if (!file_exists("media/users/user".$idUser."/database")) {
            mkdir("media/users/user".$idUser."/database", 0777, true);
        }
    }

    public static function getExtension($mediaFile){
       return pathinfo($mediaFile, PATHINFO_EXTENSION);
    }

}