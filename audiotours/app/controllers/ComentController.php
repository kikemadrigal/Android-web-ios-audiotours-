<?php
class ComentController extends BaseController{
    function __construct()
    {
        parent::__construct(); 
    }

    public function index(){
        $coment=ComentRepositoty::getAll(0,2000);
        $this->view->coment=$coment;
        $this->view->render("score/showAll");   
    }
    
    public function showAll(){
        $coment=ScoreRepositoty::getAll(0,2000);
        $this->view->coment=$coment;
        $this->view->render("score/showAll");   
    }
    public function insert(){
        $this->view->render("score/insert");    
    }
    public function update(){
        if(isset($_POST['id'])) {
            $idScore=$_POST['id'];
            $this->view->idScore=$idScore;
            $this->view->render("score/update");  
        }else{
            echo "idScore not exists";
        }
          
    }
    public function delete(){
        if(isset($_POST['id'])) {
            $idScore=$_POST['id'];
            $this->view->idScore=$idScore;
            $this->view->render("score/delete");    
        }else{
            echo "idScore not exists";
        }

    }
}