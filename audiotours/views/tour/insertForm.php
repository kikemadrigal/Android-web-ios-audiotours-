<?php include_once("./views/templates/document-start.php");?>





<?php
if(PRODUCTION==1) echo "<br /><form method='post' action='".PATHSERVER."Tour/insert' class='form-horizontal banckground-yellow' enctype='multipart/form-data'>";
echo "<br /><form method='post' action='".PATHSERVER."Tour/insert' class='form-horizontal banckground-yellow' enctype='multipart/form-data'>";
?>
 
    <!--Cover -->  
    <div class='text-center' > 
        <div class='col'>
            <?php
            echo "<div id='divImageFile'>";
            //Le ponemos la imagen "withoutImage.png"
            if(PRODUCTION==1) echo "<img src='".PATHSERVERSININDEX."media/withoutImage.png' name='imageFile' id='imageFile' class='max-height300' /><br>";
            else echo "<img src='".PATHSERVER."media/withoutImage.png' name='imageFile' id='imageFile' class='max-height300' /><br>";
            echo "</div>";
            //Ponemos para que pueda subir una foto
            if(PRODUCTION==1) echo "<input type='file' class='button-input' name='file' id='file' onChange=readImage(this,'".PATHSERVERSININDEX."') />";
            else  echo "<input type='file' class='button-input' name='file'  id='file' onChange=readImage(this,'".PATHSERVER."') />";
             ?>
            <br />
            <a href='<?php echo PATHSERVER;?>Media/showAll' target='_blanck' >Management</a><br>   
               
        </div>

    </div>
    <!-- Fin cover -->  


    <!-- Validaciones:  Mostramos errores por HTML -->  
    <div class='text-center bg-warning' id="divError">             
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
        <label for='name' class='control-label'>Name:</label> 
        <div class='col'>
            <input type='text' class='form-control' name='name' id='name' title='name' value='<?php if(isset($this->errors)) echo $this->tour->getName()?>' />
        </div>
    </div> 

    <div class='form-group m-4' >
        <label for='latitude' class='control-label'>Latitude:</label> 
        <div class='col'>
            <?php 
            if(isset($_POST['buttonModalCoordinates'])) echo "<input type='text' class='form-control' name='latitude' id='latitude' title='latitude' value='".$_POST['modalCoordinatesLat']."' />";
            else {
                if (isset($this->errors)) echo "<input type='text' class='form-control' name='latitude' id='latitude' title='latitude' value='".$this->tour->getLatitude()."' />";  
                else echo "<input type='text' class='form-control' name='latitude' id='latitude' title='latitude' />";  
            }
            ?>
        </div>
    </div> 
    <div class='form-group m-4' >
        <label for='longitude' class='control-label'>longitude:</label> 
        <div class='col'>
            <?php
            if(isset($_POST['buttonModalCoordinates'])) echo "<input type='text' class='form-control' name='longitude' id='longitude' title='longitude' value='".$_POST['modalCoordinatesLng']."' />";
            else {
                if (isset($this->errors)) echo "<input type='text' class='form-control' name='longitude' id='longitude' title='longitude' value='".$this->tour->getLongitude()."'  />";
                else echo "<input type='text' class='form-control' name='longitude' id='longitude' title='longitude'  />";  
            }
            ?>
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='address' class='control-label'>Address:</label> 
        <div class='col'>
            <input type='text' class='form-control' name='address' id='address' title='address' value='<?php if(isset($this->errors)) echo $this->tour->getAddress()?>' />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='phone' class='control-label'>Phone:</label> 
        <div class='col'>
            <input type='text' class='form-control' name='phone' id='phone' title='phone' value='<?php if(isset($this->errors)) echo $this->tour->getPhone()?>' />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='web' class='control-label'>Web:</label> 
        <div class='col'>
            <input type='text' class='form-control' name='web' id='web' title='web' value='<?php if(isset($this->errors)) echo $this->tour->getWeb()?>' />
        </div>
    </div>
    <div class='form-group m-4' >  
        <label for='type' class='control-label'>Type: escribe Museo, Muralla, castillo, etc. o todas </label> 
        <div class='col'>
            <input type='text' class='form-control' name='type' id='type' title='type' value='<?php if(isset($this->errors)) echo $this->tour->getType()?>' />
        </div>
    </div> 
    







    <div class='form-group m-4' >  
        <label for='media' class='control-label '>Audio: </label> 
        <div class='col'>
           <!-- <input type='number' class='form-control' name='media' id='media' title='media' ?>'  />-->
       
        <?php 
            //1.Le ponemos una imagen de sinMp3
            echo "<div id='divAudioFile'>";
            if(PRODUCTION==1) echo "<img src='".PATHSERVERSININDEX."media/withoutAudio.png' name='imageMp3' id='imageMp3' width='100px'  class='m-4' /><br>";
            else echo "<img src='".PATHSERVER."media/withoutAudio.png' name='imageMp3' id='imageMp3' width='100px'  class='m-4'/><br>";
            //2.Le ponemos que pueda subir un mp3
            echo "</div>";
            echo "<audio  name='audioMp3' id='audioMp3' controls></audio><br>";
            
            if(PRODUCTION==1) echo "<input type='file' class='button-input' name='fileMp3' id='fileMp3' onChange=readAudio(this,'".PATHSERVERSININDEX."') />";
            else  echo "<input type='file' class='button-input' name='fileMp3'  id='fileMp3' onChange=readAudio(this,'".PATHSERVER."') />";
            ?>
            </div>   
    </div> 









    <div class='form-group m-4' >  
        <label for='blogUrl' class='control-label'>Blog url</label> 
        <div class='col'>
            <input type='text' class='form-control' name='blogUrl' id='blogUrl' title='blogUrl' />
        </div>
    </div> 
    <div class='form-group m-4' >  
        <label for='description' class='control-label'>Description:</label> 
        <div class='col'>
            <textarea class="form-control" id="description"  name='description' rows="10"></textarea>
        </div>
    </div> 
    <!--<div class='form-group m-4' >  
        <label for='date' class='control-label'>date: empty to current time</label> 
        <div class='col'>
            <input type='text' class='form-control' name='date' id='date' title='date' />
        </div>
    </div> -->
   



    <div class='form-group m-4 text-center' > 
        <div class='col col-md-offset-2' > 
            <!-- esto es para ponerle a las imágenes y audios que no se pueden borrar -->
            <input type="hidden" name="isHeader" id="isHeader" value='1' />
            <input type='submit' name='submit'  id="submit" value='Insert' class='btn btn-primary' />
        </div>
    </div> 
        
</form>

<?php

include_once("./views/templates/document-end.php");
?>
