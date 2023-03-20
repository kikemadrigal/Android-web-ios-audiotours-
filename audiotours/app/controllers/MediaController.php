<?php
class MediaController extends BaseController{
    private $validateInput;
    function __construct()
    {
        parent::__construct(); 
        $this->validateInput=new ValidateInput();
    }

    public function index(){
        $this->view->render("media/showAll");    
    }

    public function show($media=null){
        $media=MediaRepository::getImage($media[0]);
        $this->view->media=$media;
        $this->view->render("media/show");
    }

    
    public function showAll($media=null){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){
            $images=MediaRepository::getAllImages();
            $audios=MediaRepository::getAllAudios();
            $this->view->images=$images;
            $this->view->audios=$audios;
            $this->view->render("media/showAll");   
        }else{ 
            if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Error';</script>";
            header('Location: '.PATHSERVER."Error");
        }
    }



    public function insert(){
        if (isset($_POST['submit'])){
            $date=date("d-m-Y-H-i-s");
            $countImages=MediaRepository::getCountImagesAutoincrement();
            $countAudios=MediaRepository::getCountAudiosAutoincrement();
            //El 1 es el tour vacío
            $tourId=1;
            $tourId=$_POST['tourId'];
            //Le ponemos que no es un audio de cabecera para que se pueda boorar
            $isHeader=0;
            //$text=$_POST['text'];
            $name = $_FILES['file']['name']; 
            $tipo_archivo = $_FILES['file']['type']; 
            $tamano_archivo = $_FILES['file']['size']; 
            if (!(strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png")|| strpos($tipo_archivo, "mp3") || $tamano_archivo > 900000)) 
            {
                $this->validateInput->setErrors("La foto o el audio no tiene el formato o el tam&ntilde;o correcto, solo se aceptan mp3, jpg o png menores de 90Mb.");
            }else
            { 
                //1.Formateamos el nombre de la imagen
                $nameOnServer=Util::formatearTexto($name);
                $path="media/medias";
                $extension = FilesManager::getExtension($name);
                $extension=strtolower($extension);
                if( $extension=="png")$typeId=2;
                else if( $extension=="jpg")$typeId=3;
                else if( $extension=="jpeg")$typeId=4;
                else if( $extension=="gif")$typeId=5;
                else if( $extension=="mp3")$typeId=6;
                else $typeId=1;


                
                //`id`, `name`, `path`, `date`, `typeId`, `userId`, `tourid`
                if($extension=="mp3"){
                    move_uploaded_file($_FILES['file']['tmp_name'], $path."/".$countAudios."-".$nameOnServer);
                    $lastId=MediaRepository::insertAudio($countAudios."-".$nameOnServer, $path, $isHeader,'' ,$typeId , $_SESSION['idusuario'], $tourId);    
                } 
                else{
                    move_uploaded_file($_FILES['file']['tmp_name'], $path."/".$countImages."-".$nameOnServer);
                    $lastId=MediaRepository::insertImage($countImages."-".$nameOnServer, $path, $isHeader,'' ,$typeId , $_SESSION['idusuario'], $tourId);
                } 
                if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                else header('Location: '.PATHSERVER."Media/showAll");
            } 				
        } 
    }

    //El insert contiene un select para asociar la foto a un tour
    public function insertForm(){
        $tours=TourRepository::getAll(0,2000);
        $this->view->tours=$tours;
        $this->view->render("media/insertForm");    
    }

    public function updateFormImage($image=null){
        $media=MediaRepository::getImage($image[0]);
        $this->view->media=$media;
        $this->view->render("media/update");
        //echo "vamos a  ver la imagen ".$image[0];
    }
    public function updateFormAudio($audio=null){
        $media=MediaRepository::getAudio($audio[0]);
        $this->view->media=$media;
        $this->view->render("media/update");
    }
    public function updateImage($media=null){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            if (isset($_POST['submit'])){
                $media=MediaRepository::getImage($_POST['id']);
                $media->setTourId($_POST['tourId']);
                MediaRepository::updateImage($media);
                
                if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                else header('Location: '.PATHSERVER."Media/showAll");
            }
        }
    }
    public function updateAudio($media=null){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            if (isset($_POST['submit'])){
                $media=MediaRepository::getAudio($_POST['id']);
                $media->setTourId($_POST['tourId']);
                MediaRepository::updateAudio($media);
                if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                else header('Location: '.PATHSERVER."Media/showAll");
            }
        }
    }
    public function deleteImage(){
        if(isset($_POST['id']) && $_POST['id']!=1) {
            $idMedia=$_POST['id']; 
            if(empty($idMedia)) $this->validateInput->setErrors("idMedia not exits");
            else{
                $media=MediaRepository::getImage($idMedia);
                $success=MediaRepository::deleteImage($idMedia);
                if($success){
                    //Borramos el media si existe
                    $successDelete=unlink($media->getPath()."/".$media->getName());
                    if($successDelete){
                        if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                        else header('Location: '.PATHSERVER."Media/showAll");
                    }else{
                        $this->validateInput->setErrors("It could not be erased on the server");
                    }
                }
                else{
                    $this->validateInput->setErrors("It does not exist in database");
                }
            } 
        }else{
            $this->validateInput->setErrors("idMedia not send");
        }
    }

    public function deleteAudio(){
        if(isset($_POST['id']) && $_POST['id']!=1) {
            $idMedia=$_POST['id']; 
            if(empty($idMedia)) $this->validateInput->setErrors("idMedia not exits");
            else{
                $media=MediaRepository::getAudio($idMedia);
                $success=MediaRepository::deleteAudio($idMedia);
                if($success){
                    //Borramos el media si existe
                    $successDelete=unlink($media->getPath()."/".$media->getName());
                    if($successDelete){
                        if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Media/showAll';</script>";
                        else header('Location: '.PATHSERVER."Media/showAll");
                    }else{
                        $this->validateInput->setErrors("It could not be erased on the server");
                    }
                }
                else{
                    $this->validateInput->setErrors("It does not exist in database");
                }
            } 
        }else{
            $this->validateInput->setErrors("idMedia not send");
        }
    }
}