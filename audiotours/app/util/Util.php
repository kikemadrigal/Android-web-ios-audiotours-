<?php
class Util{


    public static function cutText($cadena,$lengh){
        //Strip_tags: retira las etiquetas HTML y PHP de un String
        //substr($cadena, corta inicio, corta final)
        //strlen: devuelve la longitud de la cadena
        $stringDisplay = substr(strip_tags($cadena), 0, $lengh);
        if (strlen(strip_tags($cadena)) > $lengh)
            $stringDisplay .= ' ...';
        return $stringDisplay;
    }

    public static function formatearCadena($cadena){
        //$arrayDeAsABuscar=array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä');
        //$arrayDeAsSustituidas('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A');
        $cadena=html_entity_decode($cadena);
        $cadena= str_replace(" ", "&nbsp;", $cadena);
        return $cadena;
    }
    public static function quitarEspaciosEnBlancoPrincipioYFinal($cadena){
        $cadenaLimpia=trim($cadena);
        //$cadenaLimpia=urlencode($cadenaLimpia);
        return $cadenaLimpia;
    }
    public static function url_exists($url)
    {
        $file_headers = @get_headers($url);
        if(strpos($file_headers[0],"200 OK")==false)
        {
            echo $file_headers[0];
            $exists = false;
            return false;
        }
        else
        {
            $exists = true;
            return true;
        }
    }
    
    /**
     * Esta funciín quita los espacios y carácteres raros para poder guardar los archivos con esos nombres y que no den
     */
    public static function formatearTexto($name) {
        $except = array('\\', '/', ':', '*', '?', '"', '<', '>', '|', '\'');
        $name=str_replace($except,'',$name);
        //Le quitamos los espacios
        $except = str_replace(" ","-",$name);
        return $except;
    }


    public static function eliminacaracteresEspeciales($name) {
        $except = array('\\', "'", '"', '<', '>', '|', '\'');
        $name=str_replace($except,'',$name);
        return $name;
    }


}
?>