<?php
class TourController extends BaseController{
    private $validateInput;
    function __construct()
    {
        parent::__construct();
        
    }


    public function index(){
        $tours=TourRepository::getAll(0,2000);
        $this->view->tours=$tours;
        $this->view->render("tour/showAll"); 
    }
    public function showAllByUser(){
        $tours=TourRepository::getAllByUser($_SESSION['idusuario'],0,2000);
        $this->view->tours=$tours;
        $this->view->render("tour/showAllByUser");
    }
    public function show($param=null){
        $tour=TourRepository::getById($param[0]);
        $this->view->tour=$tour;
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            $this->view->render("tour/show");  
        }else{
            $this->view->render("tour/show");
        }
    }
    public function showAll($param=null){
        $tours=TourRepository::getAll(0,2000);
        $this->view->tours=$tours;
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            $this->view->render("tour/showAllAdm");
        }else{
            $this->view->render("tour/showAll");
        }
    }


    public function showUser($param = null){
        $this->view->param=$param;
        $this->view->render("tour/showUser");
    }
    public function search($search = null){
        $this->view->param=$search[0];
        $this->view->render("tour/search");
    }
    public function searchUser($search = null){
        $this->view->param=$search[0];
        $this->view->render("tour/search");
    }



    public function insertForm(){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            $this->view->render("tour/insertForm");  
        }else{
            if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Error';</script>";       
            else header('Location: '.PATHSERVER."Error");
        }
    }
    public function insert(){
        $this->validateInput=new ValidateInput();
        //El 1 es el tour vacío
        $tourId=1;
        $date=date("d-m-Y-H-i-s");
        $lastAudioId=1;
        $lastImageId=1;
        $reload=false;
        $countTours=TourRepository::getCountAutoincrement();
        $isHeader=0;
        if (isset($_POST['submit'])){
            $tour=new Tour(0);
			$tour->setName($_POST['name']);
			$tour->setLatitude($_POST['latitude']);
			$tour->setLongitude($_POST['longitude']);
			$tour->setType($_POST['type']);
            $tour->setBlogUrl($_POST['blogUrl']);
            $tour->setAddress($_POST['address']);
            $tour->setPhone($_POST['phone']);
            $tour->setWeb($_POST['web']);
			$tour->setDescription($_POST['description']);
			$tour->setDate('');
			$tour->setUserId($_SESSION['idusuario']);
            //Todos los que vengan del nsert o el update tendrán un campo hidden con isHeader para ue no se puedan borrar las fotos
            if(isset($_POST['isHeader']))$isHeader=1;
            


           




            /*********************************/
            /*****      Validaciones      ****/
            /*********************************/
            $this->validateInput->validar_requerido("Name",$tour->getName());
            $this->validateInput->validar_tamano_entre_2_a_254("Name",$tour->getName());
            $this->validateInput->validar_requerido("Type",$tour->getType());
            $this->validateInput->validar_tamano_entre_2_a_254("Type",$tour->getType());
            $this->validateInput->validar_requerido("Latitude",$tour->getLatitude());
            $this->validateInput->validar_float("Latitude",$tour->getLatitude());
            $this->validateInput->validar_coordenada("Latitude",$tour->getLatitude());   
            $this->validateInput->validar_requerido("Longitude",$tour->getLongitude());
            $this->validateInput->validar_float("Latitude",$tour->getLongitude());
            $this->validateInput->validar_coordenada("Longitude",$tour->getLongitude());  
            /*
            $this->validateInput->validar_tipo_de_archivo_audio($_FILES);
            $this->validateInput->validar_tipo_de_archivo_imagen($_FILES);
            */
            if(count($this->validateInput->getErrors())>0){   
                $this->view->tour=$tour;
                $this->view->errors=$this->validateInput->getErrors();
                $this->view->render("tour/insertForm");  
                die();
            }
            /*********************************/
            /***** Fin de Validaciones    ****/
            /*********************************/











            $isImageFile=false;
            $isImageFile = $_FILES['file']['type']; 
            $isAudioFile=false;
            $isAudioFile=strpos($_FILES['fileMp3']['type'], "mpeg");
            if (!(strpos($isImageFile, "gif") || strpos($isImageFile, "jpeg") || strpos($isImageFile, "jpg") || strpos($isImageFile, "png"))) 
            {
                //echo "no es una imagen";
                $isImageFile=false;
            }
            if ($_FILES['file']['size']>0 && $isImageFile==false){
                $this->validateInput->setErrors("El archivo de imagen subido, no es un archivo de imagen, vuelva a subir los dos.");
                $this->view->tour=$tour;
                $this->view->errors=$this->validateInput->getErrors();
                $this->view->render("tour/insertForm");  
                die();
            }
            if ($_FILES['fileMP3']['size']>0 && $isAudioFile=false){
                $this->validateInput->setErrors("El archivo de audio subido, no es un archivo de audio, vuelva a subir los dos.");
                $this->view->tour=$tour;
                $this->view->errors=$this->validateInput->getErrors();
                $this->view->render("tour/insertForm");  
                die();
            }

           
            //Si el archivo no está vacio y se ha encontrado mpeg en el texto del tipo del archivo
            if( $_FILES['fileMp3']['name'] != "" && $isAudioFile ){
                $name = $_FILES['fileMp3']['name']; 
                //echo "se ha subido un archivo ".$encontradoPalabraMP3." type: ".$_FILES['fileMp3']['type'];
                //1.Formateamos el nombre de la imagen
                $nameOnServer=Util::formatearTexto($name);
                $path="media/tours";
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $extension=strtolower($extension);
                //El 6 es el id de los audios en la tabla mediaTypes
                $typeId=6;
                $tourId=1;   
                $date=date("d-m-Y-H-i-s");
                $fileOnServer=$path."/".$countTours."-".$nameOnServer;
                $success=move_uploaded_file($_FILES['fileMp3']['tmp_name'],$fileOnServer);
                //`id`, `name`, `path`, `date`, `typeId`, `userId`, `tourid`
                $lastAudioId=MediaRepository::insertAudio($countTours."-".$nameOnServer, $path, $isHeader ,$date ,$typeId , $_SESSION['idusuario'], $tourId);  
                
            //Si no se ha subido ningú archivo o el archivo no es un audio hacemos una copia de uno vacío que hay en media/withoutAudio.mp3 	
            }else{
                // echo "<h1>El archivo está vacío o no es un mp3</h1>".$encontradoPalabraMP3." type: ".$_FILES['fileMp3']['type'];
                $mediaAudioSelect=MediaRepository::getAudio(1); 
                //Copiamos el withoutImage que lo tenemos en "media/" por seguridad
                $fileOnServer="media/tours/".$countTours."-".$mediaAudioSelect->getName();
                if (!copy($mediaAudioSelect->getPath()."/".$mediaAudioSelect->getName(), $fileOnServer)) {
                    echo "Error al copiar ".$mediaAudioSelect->getPath()."/".$mediaAudioSelect->getName();
                }else{
                    //Si es el 1 Modifocamos la ruta de la neva imagen
                    if($mediaAudioSelect->getId()==1)$mediaAudioSelect->setPath($mediaAudioSelect->getPath()."/tours");
                    $lastAudioId=MediaRepository::insertAudio($countTours."-".$mediaAudioSelect->getName(), $mediaAudioSelect->getPath(), $isHeader,'' ,$mediaAudioSelect->getTypeId() , $_SESSION['idusuario'], $tourId);
                } 
            }
            $tour->setMedia($lastAudioId);




            if( $_FILES['file']['name'] != "" && $isImageFile){
                $name = $_FILES['file']['name']; 
                //1.Formateamos el nombre de la imagen
                $nameOnServer=Util::formatearTexto($name);
                $path="media/tours";
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $extension=strtolower($extension);
                if( $extension=="png")$typeId=2;
                else if( $extension=="jpg")$typeId=3;
                else if( $extension=="jpeg")$typeId=4;
                else if( $extension=="gif")$typeId=5;
                else $typeId=1;
                $fileOnServer=$path."/".$countTours."-".$nameOnServer;
                $success=move_uploaded_file($_FILES['file']['tmp_name'], $fileOnServer);
                $lastImageId=MediaRepository::insertImage($countTours."-".$nameOnServer, $path, $isHeader ,$date ,$typeId , $_SESSION['idusuario'], $tourId);
            //Si no se ha subido ningún archivo le hacemos una copia de la imagen vacía
            } else{

                
                $mediaImageSelect=MediaRepository::getImage(1); 
                //Copiamos el withoutImage que lo tenemos en "media/" por seguridad
                $fileOnServer="media/tours/".$countTours."-".$mediaImageSelect->getName();
                if (!copy($mediaImageSelect->getPath()."/".$mediaImageSelect->getName(), $fileOnServer)) {
                    echo "Error al copiar ".$mediaImageSelect->getPath()."/".$mediaImageSelect->getName();
                }else{
                    //Si es el 1 Modifocamos la ruta de la neva imagen
                    if($mediaImageSelect->getId()==1)$mediaImageSelect->setPath($mediaImageSelect->getPath()."/tours");
                    $lastImageId=MediaRepository::insertImage($countTours."-".$mediaImageSelect->getName(), $mediaImageSelect->getPath(), $isHeader,'' ,$mediaImageSelect->getTypeId() , $_SESSION['idusuario'], $tourId);
                }
            
            }
            $tour->setImage($lastImageId);
            

















           
            $lastId=TourRepository::insert($tour);
            $mediaImage=MediaRepository::getImage($lastImageId); 
            //Actalizamos el tourId de la imagen con este
            $mediaImage->setTourId($lastId);
            //$mediaImage->setName($mediaImage->getName()."-".$lastId);
            //$renameImage=rename($mediaImage->getName()."/".$mediaImage->getName(), $mediaImage->getName()."/".$mediaImage->getName()."-".$lastId);
            $successMediaImageUpdate=MediaRepository::updateImage($mediaImage);
            //Actualizamos el tourId del audio con este
            $mediaAudio=MediaRepository::getAudio($lastAudioId); 
            $mediaAudio->setTourId($lastId);
            //$mediaAudio->setName($mediaAudio->getName()."-".$lastId);
            //$renameAudio=rename($mediaAudio->getName()."/".$mediaAudio->getName(), $mediaAudio->getName()."/".$mediaAudio->getName()."-".$lastId);
            $successMediaAudioUpdate=MediaRepository::updateAudio($mediaAudio);
            if($lastId>0 && $successMediaAudioUpdate && $successMediaImageUpdate){
                //if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Tour/showAll';</script>";       
                //else header("location: ".PATHSERVER."Tour/showAll");
            }else{
               echo "Insert could not be completed"; 
            }
        }// Fin del if (isset($_POST['submit']))
    }





    public function updateForm($param=null){
        $tour=TourRepository::getById($param[0]);
        $this->view->tour=$tour;
        //var_dump($tour);
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            $this->view->render("tour/updateForm"); 
        } else{
            if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Error';</script>";       
            else header('Location: '.PATHSERVER."Error");
        }      
    } 

    public function update($param=null){
        $this->validateInput=new ValidateInput();
        $date=date("d-m-Y-H-i-s");
        //Le ponemos 1 o 0 dependiendo si una imagen que se puede o no borrar (de cabcera)
        $count=$_POST['id'];

        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1){ 
            if (isset($_POST['submit']) && $_POST['id']!=1){
                //echo "Se encontro el file en el servidor<br>";
                $tour=new Tour($_POST['id']);
                $tour->setName($_POST['name']);
                $tour->setLatitude($_POST['latitude']);
                $tour->setLongitude($_POST['longitude']);
                $tour->setType($_POST['type']);
                $tour->setBlogUrl($_POST['blogUrl']);
                $tour->setAddress($_POST['address']);
                $tour->setPhone($_POST['phone']);
                $tour->setWeb($_POST['web']);
                $tour->setDescription($_POST['description']);
                $tour->setDate('');
                $tour->setUserId($_SESSION['idusuario']);
                $isHeader=0;
                if(isset($_POST['isHeader']))$isHeader=1;








                $isAudioFile=strpos($_FILES['fileMp3']['type'], "mpeg");

                if( $_FILES['fileMp3']['name'] != "" && $isAudioFile){
                    $name = $_FILES['fileMp3']['name']; 
                    //1.Formateamos el nombre de la imagen
                    $nameOnServer=Util::formatearTexto($name);
                    $path="media/tours";
                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                    $extension=strtolower($extension);
                    //El 6 es el id de los audios en la tabla mediaTypes
                    $typeId=6;
                    MediaRepository::deleteAudio($tour->getMedia());
                    $success=move_uploaded_file($_FILES['fileMp3']['tmp_name'], $path."/".$count."-".$nameOnServer);
                    //`id`, `name`, `path`, `date`, `typeId`, `userId`, `tourid`
                    $lastMediaId=MediaRepository::insertAudio($count."-".$nameOnServer, $path, $isHeader,'' ,$typeId , $_SESSION['idusuario'], $_POST['id']);
                    if($lastMediaId>0){
                        $audio=MediaRepository::getAudio($_POST['media']);
                        MediaRepository::deleteAudio($_POST['media']);
                        unlink('media/tours/'.$audio->getName());
                    } 
                    $tour->setMedia($lastMediaId);
                //Si no es un archivo audio y no está vacio  	 	
                }else{
                   // if($_FILES['file']['name'] == ""){
                        $tour->setMedia($_POST['media']);
                    /*} else {
                        $this->validateInput->setErrors("El archivo de audio subido, no es un archivo de audio");
                        $tour->setImage($_POST['image']);
                        $tour->setMedia($_POST['media']);
                        $this->view->tour=$tour;
                        $this->view->errors=$this->validateInput->getErrors();
                        $this->view->render("tour/updateForm");  
                    }*/
                }

                
                
                
                
                
                
                
                
                
                $isImage=false;
                $tipo_archivo = $_FILES['file']['type']; 
                if (strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png")) 
                {
                    $isImage=true;
                }
    
                
                
                if( $_FILES['file']['name'] != "" && $isImage){
                    $name = $_FILES['file']['name']; 
                    //1.Formateamos el nombre de la imagen
                    $nameOnServer=Util::formatearTexto($name);
                    $path="media/tours";
                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                    $extension=strtolower($extension);
                    if( $extension=="png")$typeId=2;
                    else if( $extension=="jpg")$typeId=3;
                    else if( $extension=="jpeg")$typeId=4;
                    else if( $extension=="gif")$typeId=5;
                    else if( $extension=="mp3")$typeId=6;
                    else if( $extension=="jpg")$typeId=7;
                    else $typeId=1;
                    $success=move_uploaded_file($_FILES['file']['tmp_name'], $path."/".$count."-".$nameOnServer);
                    //`id`, `name`, `path`, `date`, `typeId`, `userId`, `tourid`
                    $lastId=MediaRepository::insertImage($count."-".$nameOnServer, $path, $isHeader,'' ,$typeId , $_SESSION['idusuario'], $_POST['id']);
                    if($lastId>0){
                        $image=MediaRepository::getImage($_POST['image']);
                        MediaRepository::deleteImage($_POST['image']);
                        unlink('media/tours/'.$image->getName());
                    } 
                    $tour->setImage($lastId); 		
                //Si es un archivo que noes imagen y no está vacío	
                } else{
                    //Puede ser que sea un archivo que no es mp3, entonces le ponemos que el archivo no es mp3
                    //if($_FILES['file']['name'] == ""){
                        $tour->setImage($_POST['image']);
                    /*} else{
                        $this->validateInput->setErrors("El archivo de imagen subido, no es un archivo de imagen válido");
                        $tour->setImage($_POST['image']);
                        $this->view->tour=$tour;
                        $this->view->errors=$this->validateInput->getErrors();
                        $this->view->render("tour/updateForm");  
                        die();
                    }  */
                }

                





            /*********************************/
            /*****      Validaciones      ****/
            /*********************************/
            $this->validateInput->validar_requerido("Name",$tour->getName());
            $this->validateInput->validar_tamano_entre_2_a_254("Name",$tour->getName());
            $this->validateInput->validar_requerido("Type",$tour->getType());
            $this->validateInput->validar_tamano_entre_2_a_254("Type",$tour->getType());
            $this->validateInput->validar_requerido("Latitude",$tour->getLatitude());
            $this->validateInput->validar_float("Latitude",$tour->getLatitude());
            $this->validateInput->validar_coordenada("Latitude",$tour->getLatitude());  
            $this->validateInput->validar_requerido("Longitude",$tour->getLongitude());
            $this->validateInput->validar_float("Latitude",$tour->getLongitude());
            $this->validateInput->validar_coordenada("Longitude",$tour->getLongitude());   
            /*
            $this->validateInput->validar_tipo_de_archivo_audio($_FILES);
            $this->validateInput->validar_tipo_de_archivo_imagen($_FILES);
            */
            if(count($this->validateInput->getErrors())>0){   
                $this->view->tour=$tour;
                $this->view->errors=$this->validateInput->getErrors();
                $this->view->render("tour/updateForm");  
                die();
            }
            /*********************************/
            /***** Fin de Validaciones    ****/
            /*********************************/
    











                $success=TourRepository::update($tour);
                if($success>0){
                    if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Tour/showAll';</script>";       
                    else header("location: ".PATHSERVER."Tour/showAll");
                }else{
                    echo "Update could not be completed".$success; 
                }

            }
        } else{
            if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Error';</script>";       
            else header('Location: '.PATHSERVER."Error");
        }      
    }
    public function delete($id=null){
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==1 && $_POST['id']!=1){ 
            //Para poder borrar un tour primero tenenemos que borrar la imagen de cabecera y el archivo de audio
            //echo "Vamos a borrar el tour ".$id;
            $tour=TourRepository::getById($_POST['id']);    
          
            /**Borramos todos los archivos de las imágenes que tiene ese tour */
            $images=MediaRepository::getAllImagesByTour($_POST['id']);
            foreach ($images as $image){
                MediaRepository::deleteImage($image->getId());
                unlink($image->getPath()."/".$image->getName());
            }
            /*
            $image=MediaRepository::getImage($tour->getImage());
            MediaRepository::deleteImage($image->getId());
            unlink('media/tours/'.$image->getName());
            */
            $audios=MediaRepository::getAllAudiosByTour($_POST['id']);
            foreach ($audios as $audio){
                MediaRepository::deleteAudio($audio->getId());
                unlink($audio->getPath()."/".$audio->getName());
            }
            /*
            $audio=MediaRepository::getAudio($tour->getMedia());
            MediaRepository::deleteAudio($audio->getId());
            unlink('media/tours/'.$audio->getName());
            */


            TourRepository::delete($_POST['id']);
            //echo "Borrando el tour ".$_POST['id'];
            
            if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Tour/showAll';</script>";
            else header("location: ".PATHSERVER."Tour/showAll");
        }else{
            if ( PRODUCTION==1 ) echo "<script type='text/javascript'>location.href='".PATHSERVER."Error';</script>";       
            else header('Location: '.PATHSERVER."Error");
        }
    }




}