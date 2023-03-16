<?php

class AdmController extends BaseController{
    function __construct()
    {
        parent::__construct();
    }

    public function index(){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1) {
            $this->view->render("adm/index");
        }else{
            $this->view->render("error");

        }
    }

    public function tools(){
        $this->view->render("adm/tools");
    }
    public function license(){
        $this->view->render("adm/license");
    }

}