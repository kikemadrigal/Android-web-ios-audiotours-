<?php
class StringManager {
    public static function getLastWordFromPath($path){
        if ($path==null || empty($path)) return "";
        $lengh=strlen($path);
        //Encuentra la posición númerica de la última aparición de needle (aguja) en el string haystack (pajar).
        //strrpos(string $haystack, mixed $needle, int $offset = 0): int
        $lastSlashPosition=strrpos($path, "/");
        //Devuelve una parte del string definida por los parámetros start y length.
        //substr(string $string, int $start, int $length = ?): string
        //https://www.php.net/manual/es/function.substr
        $substring=substr($path, $lastSlashPosition+1, $lengh);
        return $substring;
    }
}