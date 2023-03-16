<?php
class RegisterValidator {
    private $nombre;
    private $email;

    private $errorNombre;
    private $errorEmail;
    private $errorClave1;
    private $errorClave2;

    public function __construct($nombre, $email, $clave1,$clave2){
        $this->nombre="";
        $this->email="";

        $this->errorNombre=$this->validarNombre($nombre);

    }
    private function variableIniciada($variable){
        if(isset($variable) && ! empty($variable)){
            return true;
        }else{
            return false;
        }
    }

    private function validarNombre($nombre){
        if($this->variableIniciada($nombre)){
            return "Debes escribir un nombre de usuario";
        }else{
            $this->nombre=$nombre;
        }
        if (strlen($nombre)<6){
            return "El nombre debe de ser mas largo de 6 caracteres.";
        }
        if (strlen($nombre)>24){
            return "El nombre no puede ocupar mas de 24 caracteres.";
        }
        return "";
    }
}
?>