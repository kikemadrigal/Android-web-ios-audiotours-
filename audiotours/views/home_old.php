﻿<?php include_once("./views/templates/document-start.php");?>
<script src="<?php echo PATHJS; ?>map.js"></script>
<br />
<div class="row">
    <div class="col-md-10">
        <div id="dvMap" style="width: 100%; height:400px;"></div>
    </div>
    <div class="col-md-2 border">
        <label for="selectDirections" class="text-end col-form-label"><i class="fa-solid fa-car"></i>   <i class="fa-solid fa-person-biking"></i>   <i class="fa-solid fa-person-walking"></i></label>
        <select id="selectDirections" name="selectDirections">
            <option value="WALKING">WALKING</option>
            <option value="BYCYCLING"> BYCYCLING</option>
            <option value="TRANSIST">TRANSIST</option>
        </select>
        <br />
        <i class="far fa-dot-circle"></i><input type="text" id="from" placeholder="origin" class="form-control">
        <i class="fa-solid fa-diamond-turn-right"></i><input type="text" id="to" placeholder="Destination" class="form-control">
        <button class="btn btn-info text-center btn-lg" id="btnDirections"><i class="fas fa-map-marker-alt"></i></button>
        <br />
        <i class="fa-solid fa-diamond-turn-right"></i><input type="text" id="textPlaces" placeholder="Focus on this place" class="form-control">
        <div id="showCoordinates">Coordinates</div>
        <label for="selectPlaces" class="text-end col-form-label "></label>
        <select id="selectPlaces" name="selectPlaces">
            <option value="Restaurant">Restaurant</option>
            <option value="" ></option>
            <option value=""></option>
        </select>
        <br />
        <button class="btn btn-warning text-center btn-lg" id="btnPlaces"><i class="fas fa-map-marker-alt"></i></button>
    </div>
</div>
<div class="container-fluid ">
    <div id="output" class="bg-warning"></div>
</div>
<br />
<div class="row" >
        <?php
        foreach ($this->tours as $posicion=>$tour){
			if ($tour->getId()!=NULL && $tour->getId()!=1){
                $image=MediaRepository::getImage($tour->getImage());
                $audio=MediaRepository::getAudio($tour->getMedia());
                ?>
                <div class="col-md-3 text-center" >
                    <div class="card p-2" >
                            <?php
                            $audioFile="media/withoutAudio.mp3";
                            $imageFile="media/withoutImage.png";
                            if($audio!=null && $image!=null){
                                if(PRODUCTION==1){
                                    $audioFile=PATHSERVERSININDEX.$audio->getPath()."/".$audio->getName();
                                    $imageFile=PATHSERVERSININDEX.$image->getPath()."/".$image->getName();
                                    echo "<a href='".PATHSERVER."Tour/show/".$tour->getId()."'>";
                                }
                                else{
                                    $audioFile=PATHSERVER.$audio->getPath()."/".$audio->getName();
                                    $imageFile=PATHSERVER.$image->getPath()."/".$image->getName();
                                    echo "<a href='".PATHSERVER."Tour/show/".$tour->getId()."'>"; 
                                } 
                            }
                            echo "<img src=".$imageFile."  height='200px'  />";
                            echo "<audio src='".$audioFile."' style='width: 200px;' controls  >Your browser does not support the <code>audio</code> element.</audio>";
                            ?>
             
                            <h4><?php echo Util::cutText($tour->getName(),50); ?></h4>
                            <input type='button' class='btn btn-outline-primary btn-sm' value='Go!'></nutton>                        </a>
                    </div>   
                </div>
            <?php
            }
        }
        ?>	
</div>


  

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFgSpcBibpRLAtMIX68M_DnUyrHQr2VnY&libraries=places&callback=initMap"></script>

<?php include_once("./views/templates/document-end.php");?>

		






















			



