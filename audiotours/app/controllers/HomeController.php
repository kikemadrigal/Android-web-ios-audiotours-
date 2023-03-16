<?php

class HomeController extends BaseController{
    function __construct()
    {
        parent::__construct();
    }

    public function index(){
        
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1) {
            $this->view->render("adm/index");
        }else{
            $tours=TourRepository::getAll(0,2000);
            $this->view->tours=$tours;
            $this->view->render("home");

        }
    }

    public function getPrivacidad(){
        $this->view->render("privacidad");
    }

}