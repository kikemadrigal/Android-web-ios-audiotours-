<?php
Class ValidateInput{
    //private $input;
    private $errors;
    function __construct(){
        //$this->input=$input;
        $this->errors=[];
    }



    /**
     * Método que valida si un texto no esta vacío
     * @param {string} - Nombre campo a validar
     * @param {string} - Texto a validar
     * @return {boolean}
     */
    function validar_requerido($campo,string $texto): bool {
        $validate=true;
        if(trim($texto) == '' || strlen($texto)==0 || empty($texto)){
            $this->errors[] = "El campo ".$campo." es obligatorio.";
            $validate=false;
        }
        return $validate;
    }
    function validar_tamano_entre_2_a_254($campo,$texto): bool{
        $validate=true;
        /*if(!preg_match("/^{3,10}$/", $texto) ){
            $this->errors[] = "El tamaño ".$campo." tiene que estar entre 2 y 254, encontrado: ".$texto;
            $validate=false;
        } */
        if(strlen($texto)<3 and strlen($texto)>255){
            $this->errors[] = "El tamaño ".$campo." tiene que estar entre 2 y 254, encontrado: ".$texto;
            $validate=false;
        }
        return $validate;
    }

    /**
     * Método que valida si es un número entero 
     * @param {string} - Número a validar
     * @return {bool}
     */
    function validar_entero(string $campo,string $numero): bool
    {
        $validate=true;
        if(filter_var($numero, FILTER_VALIDATE_INT) === FALSE){
            $this->errors[] = "El campo ".$campo." debe ser un número.";
            $validate=false;
        }
        return $validate;
    }
    /**
     * Método que valida si es un número entero 
     * @param {string} - Número a validar
     * @return {bool}
     */
    function validar_float(string $campo,string $numero): bool
    {
        $validate=true;
        if(filter_var($numero, FILTER_VALIDATE_FLOAT) === FALSE){
            $this->errors[] = "El campo ".$campo." debe ser un número.";
            $validate=false;
        }
        return $validate;
    }
    /**
     * Método que valida si el texto tiene un formato válido de E-Mail
     * @param {string} - Email
     * @return {bool}
     */
    function validar_email(string $texto): bool
    {
        $validate=true;
        //$patronEmail="/[\w._%+-]+@[\w.-]+\.[a-zA-Z]{2,4}/";
        if(filter_var($texto, FILTER_VALIDATE_EMAIL) === FALSE){
            $this->errors[] = 'El campo de Email tiene un formato no válido.';
            $validate=false;
        }
        return $validate;
    }

    function comprobar_url($url){
        $patron="(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?";
        $validate=true;
        if( !preg_match($patron, $url) ){
            $this->errors[] = "No es una url";
            $validate=false;
         } 
        return $validate;
    }
    function validar_coordenada($campo,$coordenada){
        $validar=true;
        if($coordenada>179 || $coordenada<-179){
            $validar=false;
            $this->errors[] = "La coordenada ".$campo."tiene que estar entre -180 y 180";
        }
        return $validar;
    }
    /**
     * Método que valida si el texto solo contiene letras y números
     * @param {string} - input
     * @return {bool}
     */
    function solo_letras_y_numeros($input){
        //[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,64}
        $validate=true;
        if( !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/", $input) ){
           $this->errors[] = "Solo letras y numeros";
           $validate=false;
        } 
        return $validate;
    }

    function validar_tipo_de_archivo_audio($FILES){
        $validate=true;
        if (!(strpos($FILES['fileMp3']['type'], "mpeg"))) {
            //Si no es de tipo audio retornamos falso
            $this->errors[] = "El archivo de audio no es un audio";
            $validate=false;
        }
        return $validate;
    }

    function validar_tipo_de_archivo_imagen($FILES){
        $validate=true;
        if (!(strpos($FILES['fileMp3']['type'], "gif") || strpos($FILES['fileMp3']['type'], "jpeg") || strpos($FILES['fileMp3']['type'], "jpg") || strpos($FILES['fileMp3']['type'], "png"))) 
        {
            //Si no es de tipo audio retornamos falso
            $this->errors[] = "El archivo de imagen no es una imagen";
            $validate=false;
        }
        return $validate;
    }

    function setErrors($message){
        return $this->errors[] = $message;
    }
    function getErrors(){
        return $this->errors;
    }


}



?>