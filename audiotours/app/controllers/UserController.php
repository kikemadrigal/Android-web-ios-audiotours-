<?php
class UserController extends BaseController{
    function __construct()
    {
        parent::__construct();
    }

    public function update(){
        $this->view->render("user/update");    
    }
    
}