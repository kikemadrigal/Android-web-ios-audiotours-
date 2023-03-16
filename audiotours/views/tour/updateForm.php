<?php 






//El objeto tour es obtenido en el controlador
include_once("./views/templates/document-start.php"); 
?>





<!--<h3>Update Tour </h3>-->
<?php
    $tour=$this->tour;
    //echo "<h4>".$tour->getId()."</h4>";
?>


<!----------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------ FORMULARIO ACTUALIZAR------------------------------------------------->
<!----------------------------------------------------------------------------------------------------------------------->
<!-- Patrones: para campos con números: pattern='[0-9]{1,10000}'-->
<br /><form method=post action='<?php echo PATHSERVER."Tour/update"?>' class='form-horizontal background-pink' enctype='multipart/form-data'>
    



    <!--Cover -->  
    <div class='text-center' > 
        <div class='col'>
            <?php
            //Si tenía una foto, la obtenemos
            $image=MediaRepository::getImage($tour->getImage());
            if($image==null){
                if(PRODUCTION==1)echo "<img src='".PATHSERVERSININDEX."media/sinImagen.jpg' name='imageFile' id='imageFile' class='max-height300' /><br>";
                else echo "<img src='".PATHSERVER."media/sinImagen.jpg' name='imageFile' id='imageFile' class='max-height300' /><br>";
            }else{
                if(PRODUCTION==1)echo "<img src=".PATHSERVERSININDEX.$image->getPath()."/".$image->getName()." name='imageFile' id='imageFile' class='max-height300' /><br>";
                else echo "<img src=".PATHSERVER.$image->getPath()."/".$image->getName()." name='imageFile'id='imageFile' width='200px' /><br>";
            }
            echo "<br />".$image->getName()."<br />";
            //Ponemos para que pueda subir una foto
            if(PRODUCTION==1) echo "<input type='file' class='button-input' name='file' id='file' onChange=readImage(this,'".PATHSERVERSININDEX."') />";
            else  echo "<input type='file' class='button-input' name='file'  id='file' onChange=readImage(this,'".PATHSERVER."') />";
            ?>
            <br />
            <a href='<?php echo PATHSERVER;?>Media/showAll' target='_blanck' >Management</a><br>   
            <?php   
            /*
            //Puede elegir una de las almacenadas     
             $images=MediaRepository::getAllImages();
             if(PRODUCTION==1) echo "<select class='m-4' name='image' id='image' onchange=setOnImageFilePictureBlanck('".PATHSERVERSININDEX."') /> ";
             else echo "<select class='m-4' name='image' id='image' onchange=setOnImageFilePictureBlanck('".PATHSERVER."') /> ";
             
                if ($image==null) echo "<option value='1' >Sin imagen</option>";
                else echo "<option value='".$image->getId()."' >".$image->getName()."</option>";
                    
                foreach ($images as $posicion=>$image){
                    if($image->getId()!=1) //kitamos el 1 que es imagen vacía
                        echo "<option value='".$image->getId()."'>".$image->getName()."</option>";
                }
            echo "</select>";
            */
            ?>
            <input type='hidden' name='image' id='image' title='image' value='<?php echo $tour->getImage(); ?>'  />
                 
        </div>

    </div>
    <!-- Fin cover -->  




    <!-- Validaciones:  Mostramos errores por HTML -->  
    <div class='text-center bg-warning' >             
     <?php if (isset($this->errors)&& count($this->errors)>0): ?>
        <?php 
        foreach ($this->errors as $error) {
            echo '<p>' . $error . '</p>';
        } 
        ?> 
    <?php endif; ?>
    </div>  
    <!-- Fin de validaciones -->        








    <div class='form-group m-4' >  
        <label for='name' class='control-label '>Name:</label> 
        <div class='col'>
            <input type='text' class='form-control' name='name' id='name' title='name' value='<?php echo $tour->getName(); ?>'  />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='latitude' class='control-label '>Latitude:</label> 
        <div class='col'>
            <input type='text' class='form-control' name='latitude' id='latitude' title='latitude' value='<?php echo $tour->getLatitude(); ?>'  />
        </div>
    </div> 
    <div class='form-group m-4' >
        <label for='longitude' class='control-label '>Longitude:</label> 
        <div class='col'>
            <input type='text' class='form-control' name='longitude' id='longitude' title='longitude' value='<?php echo $tour->getLongitude(); ?>'  />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='address' class='control-label '>Address:</label> 
        <div class='col'>
            <input type='text' class='form-control' name='address' id='address' title='address' value='<?php echo $tour->getAddress(); ?>'  />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='phone' class='control-label '>Phone:</label> 
        <div class='col'>
            <input type='text' class='form-control' name='phone' id='phone' title='phone' value='<?php echo $tour->getPhone(); ?>'  />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='web' class='control-label '>Web:</label> 
        <div class='col'>
            <input type='text' class='form-control' name='web' id='web' title='web' value='<?php echo $tour->getWeb(); ?>'  />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='type' class='control-label '>Type: Museo, plaza, playa, etc</label> 
        <div class='col'>
            <input type='text' class='form-control' name='type' id='type' title='type' value='<?php echo $tour->getType(); ?>'  />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='media' class='control-label '>Audio: </label> 
        <div class='col'>
           <!-- <input type='number' class='form-control' name='media' id='media' title='media' ?>'  />-->
       
        <?php 
            //1.Le ponemos el audio asignado
            $audio=MediaRepository::getAudio($tour->getMedia());

            if(PRODUCTION==1) echo "<audio src=".PATHSERVERSININDEX.$audio->getPath()."/".$audio->getName()." controls name='audioMp3' id='audioMp3'></audio><br>";
            else  echo "<audio src=".PATHSERVER.$audio->getPath()."/".$audio->getName()." controls name='audioMp3' id='audioMp3' ></audio><br>";
            echo "<br />".$audio->getName()."<br />";
            //2.Le ponemos que pueda subir un mp3
            if(PRODUCTION==1) echo "<input type='file' class='button-input' name='fileMp3' id='fileMp3' onChange=readAudio(this,'".PATHSERVERSININDEX."') />";
            else  echo "<input type='file' class='button-input' name='fileMp3'  id='fileMp3' onChange=readAudio(this,'".PATHSERVER."') />";
            ?>
            <input type='hidden' class='form-control' name='media' id='media' title='audio' value='<?php echo $tour->getMedia(); ?>' />
            </div>   
    </div> 
   

    <div class='form-group m-4' >  
        <label for='blogUrl' class='control-label '>Blog url:</label> 
        <div class='col'>
            <input type='text' class='form-control' name='blogUrl' id='blogUrl' title='blogUrl' value='<?php echo $tour->getBlogUrl(); ?>'  />
        </div>
    </div> 

    <div class='form-group m-4' >  
        <label for='description' class='control-label '>Description:</label> 
        <div class='col'>
            <!--<input type='text' class='form-control' name='description' id='description' title='description' value='<?php echo $tour->getDescription(); ?>'  />-->
            <textarea class='form-control' rows="10" name='description' id='description' title='description'><?php echo $tour->getDescription(); ?></textarea>
        </div>
    </div> 
    <!--<div class='form-group m-4' >  
        <label for='date' class='control-label '>date: </label> 
        <div class='col'>
            <input type='text' class='form-control' name='date' id='date' title='date' value=' />
        </div>
    </div> -->
    <div class='form-group m-4' >  
        <label for='userId' class='control-label '></label> 
        <div class='col'>
            <input type='hidden' class='form-control' name='userId' id='userId' value='<?php echo $tour->getUserId(); ?>'  />
        </div>
    </div> 
  
    
    <div class='form-group m-4 text-center' > 
        <div class='col col-md-offset-2' >
            <input type="hidden" name="id" id="id" value='<?php echo $tour->getId(); ?>' />
            <input type="hidden" name="isHeader" id="isHeader" value='1' />
            <input type='submit' name="submit" id="submit" value='Update' class='btn btn-primary' ></input> 
            <input type='button' name="remove" id="remove" value='Remove' class='btn btn-danger' data-bs-toggle="modal" data-bs-target="#exampleModal" ></input>
            <!--<a href="" class="btn btn-danger" data-toggle="modal" data-target="#deleteTourModal">   Delete   </a>-->
        </div>
    </div> 
</form>
<!----------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------FINAL DEL FORMULARIO ACTUALIZAR------------------------------------------------->
<!----------------------------------------------------------------------------------------------------------------------->


<!-- Modal: https://getbootstrap.com/docs/5.0/components/modal/ -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete tour</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete the tour?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <form method="post" action="<?php echo PATHSERVER;?>Tour/delete">
            <input type="hidden" name="id" id="id" value='<?php echo $tour->getId(); ?>' />
            <button type="submit" class="btn btn-danger">Remove!!</button>
        </form>
      </div>
    </div>
  </div>
</div>






<?php include_once("./views/templates/document-end.php"); ?>

