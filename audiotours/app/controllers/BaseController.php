<?php
class BaseController {
    protected $view;
    
    function __construct(){
        $this->view=new View();
        

    }
}