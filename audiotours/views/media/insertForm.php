<?php
include_once("./views/templates/document-start.php"); 
//$mensaje=$this->mensaje;
?>
<br /><div>
    <p>Tenga en cuenta que cuando se borra un tour, se borran las imágenes asociadas a ese tour</p>
    <p>Please note that when a tour is deleted, the images associated with that tour will be deleted.</p>
<div>
<a href="https://www.google.es/imghp?hl=es&ogbl" class='btn btn-success m-4' target="_blanck" >Search images on google </a><br>
<form method='post' action='<?php echo PATHSERVER."Media/insert"; ?>' class='form-horizontal' enctype='multipart/form-data'>
    <div class="text-center">
        <div class='form-group m-4' >
            <label for='file' class='control-label'>Multimedia file: </label> 
            <?php
            if(PRODUCTION==1) echo "<input type='file' class='form-control' name='file' id='file' onChange=readURL(this,'".PATHSERVERSININDEX."') />";
            else  echo "<input type='file' class='form-control' name='file' id='file' onChange=readURL(this,'".PATHSERVER."') />";
            
            echo "<label for='tourId' class='control-label'>Associate with Tour: </label> ";
            echo "<select class='m-4' name='tourId' id='tourId' class='form-control' /> ";
            echo "<option value='1' >Without tour</option>";
            if($this->tours!=null){
                foreach ($this->tours as $posicion=>$tour){
                    if($tour->getId()!=1) //kitamos el 1 que es imagen vacía
                        echo "<option value='".$tour->getId()."'>".$tour->getName()."</option>";
                } 
            }
            echo "</select>";
            
            if($this->tours==null) echo "tours es null";
            
            
            ?>
            <br />
            <div id="divImageFile" name="divImageFile">
            <?php
                if(PRODUCTION==1) echo "<img src='".PATHSERVERSININDEX."media/prohibited.png' id='imageFile' name='imageFile' class='max-height300'  /><br>";
                else echo "<img src='".PATHSERVER."media/prohibited.png' id='imageFile' name='imageFile' class='max-height300'  /><br>";
            ?> 
            </div>
        </div>
        <div class='form-group m-4' > 
            <div class='col col-md-offset-2' >
                <input type='submit' name='submit'  id='submit' value='Insert' class='btn btn-primary' ></input>
            </div>
        </div> 
    </div>
</form> 




<!-- Validaciones:  Mostramos errores por HTML -->  
<div class='text-center bg-warning' >    
    <?php        
    if (isset($this->errors)&& count($this->errors)>0){
        foreach ($this->errors as $error) {
            echo '<p>' . $error . '</p>';
        } 
    }
    ?> 
</div>  
<!--Fin de validaciones -->
<?php include_once("./views/templates/document-end.php"); ?>