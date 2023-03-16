<?php
//Show.php permite visualizar los datos de un juego alamcenado en la tabla games
//La variable param se obtiene en el GameController.php

$tour=$this->tour;
include_once("./views/templates/document-start.php"); 
?>
<!-- Patrones: para campos con números: pattern='[0-9]{1,10000}'-->
<!--<h3>Show user tour </h3>-->


<div class="row text-center">
    <div class="col">
        <!--Obtener foto --> 
        <?php
        $image=MediaRepository::getImage($tour->getImage());
        $audio=MediaRepository::getAudio($tour->getMedia());
        $audioFile="media/withoutAudio.mp3";
        $imageFile="media/withoutImage.png";
        if(PRODUCTION==1){
            $audioFile=PATHSERVERSININDEX.$audio->getPath()."/".$audio->getName();
            $imageFile=PATHSERVERSININDEX.$image->getPath()."/".$image->getName();
          }
          else{
            $audioFile=PATHSERVER.$audio->getPath()."/".$audio->getName();
            $imageFile=PATHSERVER.$image->getPath()."/".$image->getName();
        } 
        if($image!=null) $path=$image->getPath();
        else $path="";
        if(PRODUCTION==1){
            if (file_exists($path)){
                echo "<br /><img class='img-fluid mx-4' src='".$imageFile."' width='200px' />";
                echo "<br /><audio src='".$audioFile."' style='width: 200px;' controls >Your browser does not support the <code>audio</code> element.</audio>";
            }else{
                echo "<br /><img class='img-fluid mx-4' src='".PATHSERVERSININDEX."media/sinImagen.jpg' width='200px' />&nbsp;&nbsp;";
                echo "<audio src='".PATHSERVERSININDEX."media/withoutAudio.mp3' style='width: 200px;' controls >Your browser does not support the <code>audio</code> element.</audio>";
            }
        }else{
            if (file_exists($path)){
                echo "<br /><img class='img-fluid img-fluid mx-4'  src='".$imageFile."' width='200px' />";
                echo "<br /><audio src='".$audioFile."' style='width: 200px;' controls >Your browser does not support the <code>audio</code> element.</audio>";
            }else{
                echo "<br /><img class='img-fluid mx-4' src='".PATHSERVER."media/sinImagen.jpg' width='200px' />&nbsp;&nbsp;";
                echo "<br /><audio src='".PATHSERVER."media/withoutAudio.mp3' style='width: 200px;' controls >Your browser does not support the <code>audio</code> element.</audio>";
            }
        }
        echo "<h4>".$tour->getName()."</h4>";
        ?>  
    </div>
</div>


<nav class="m-4">
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Information</button>
    <button class="nav-link" id="nav-images-tab" data-bs-toggle="tab" data-bs-target="#nav-images" type="button" role="tab" aria-controls="nav-images" aria-selected="false">Images</button>
    <button class="nav-link" id="nav-audios-tab" data-bs-toggle="tab" data-bs-target="#nav-audios" type="button" role="tab" aria-controls="nav-audios" aria-selected="false">audios</button>
   </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
      <p>Name: <?php echo $tour->getName(); ?></p>
      <p>Latitude: <?php echo $tour->getLatitude(); ?></p>
      <p>Longitude: <?php echo $tour->getLongitude(); ?></p>
      <p>Blog Url: <?php echo $tour->getBlogUrl(); ?></p>
      <p>Description: <pre><?php echo $tour->getDescription(); ?></pre></p>
      <p></p>
  </div>
  <div class="tab-pane fade" id="nav-images" role="tabpanel" aria-labelledby="nav-images-tab">
      <p>Images of the tour: 
        <?php 
        echo $idTour=$tour->getId();
        //$imagesFromTour= 
        ?>
        </p>
  </div>
  <div class="tab-pane fade" id="nav-audios" role="tabpanel" aria-labelledby="nav-audios-tab">
      <p>Audios of the tour: 
      <?php 
      echo $tour->getName(); 
      ?>
      </p>
  </div>
  
</div>





<?php include_once("./views/templates/document-end.php"); ?>