<?php
class View{
    /*protected $image;
    protected $audio;
    protected $images;
    protected $audios;
    protected $message;*/
    function __construct(){
        /*$this->image=new Media(0);
        $this->audio=new Media(0);
        $this->images=[];
        $this->audios=[];
        $this->message="";
        */
    }
    function render($name){
        //$name=strtolower($name);
        require 'views/'.$name.'.php';
        //require './views/tour/insertForm.php';
    }
}