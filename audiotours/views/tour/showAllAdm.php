<?php include_once("./views/templates/document-start.php"); ?>


<script src="<?php echo PATHJS; ?>adm.js"></script>
	

<br />
<div class="row">
    <div class="col-md-10">
        <div id="dvMap" style="width: 100%; height:400px;" data-bs-toggle="modal" data-bs-target="#exampleModal"></div>
    </div>
    <div class="col-md-2 border">
		<br />
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


<div><a href="<?php echo PATHSERVER;?>Tour/insertForm" class="btn btn-outline-primary btn-sm">New blank tour</a></div>
<table class="table">
  <thead> 
    <tr>
      <th scope="col"><i class="fa-solid fa-pen"></i> Update</i></th>
      <th scope="col"><i class="fa-solid fa-eye"></i> Show</th>
	    <th scope="col"><i class="fa-solid fa-headphones"></i></th>
	    <th scope="col"><i class="fa-solid fa-image"></i></th>
      <th scope="col"><i class="fa-solid fa-location-pin"></i> Latitude</th>
	    <th scope="col"><i class="fa-solid fa-location-pin"></i> Longitude</th>
      <th scope="col"><i class="fa-solid fa-link"></i> blog url</th>
      <th scope="col"><i class="fa-solid fa-people-arrows"></i> Distance</th>
      <th scope="col"><i class="fa-light fa-gear"></i> Actions</th>
    </tr>
  </thead>
  <tbody>
	<?php
	if($this->tours==NULL) echo "Without tours";
	else{
		foreach ($this->tours as $posicion=>$tour){
      if ($tour->getId()!=NULL && $tour->getId()!=1){
        $image=MediaRepository::getImage($tour->getImage());
        $audio=MediaRepository::getAudio($tour->getMedia());
        $audioFile="media/withoutAudio.mp3";
        $imageFile="media/withoutImage.png";
        if($audio!=null && $image!=null){
          if(PRODUCTION==1){
            $audioFile=PATHSERVERSININDEX.$audio->getPath()."/".$audio->getName();
            $imageFile=PATHSERVERSININDEX.$image->getPath()."/".$image->getName();
          }
          else{
            $audioFile=PATHSERVER.$audio->getPath()."/".$audio->getName();
            $imageFile=PATHSERVER.$image->getPath()."/".$image->getName();
          } 
        }

					echo "<tr>";
						echo "<th scope='row'><a href='".PATHSERVER."Tour/updateForm/".$tour->getId()."'>".Util::cutText($tour->getName(),50)."</a></th>";
						echo "<td><a href='".PATHSERVER."Tour/show/".$tour->getId()."'><i class='fa-solid fa-eye'></i><a></td>";
            echo "<td>";
              if(PRODUCTION==1) echo "<a href='".PATHSERVER."Media/show/".$tour->getMedia()."'>";
              else echo "<a href='".PATHSERVER."Media/show/".$tour->getMedia()."'>";
                echo "<audio src='".$audioFile."' controls >Your browser does not support the <code>audio</code> element.</audio>";
                echo "</a>";
            echo "</td>";
						echo "<td>";
            echo "<img src=".$imageFile." width='50px' />";
            echo"</td>";
						echo "<td>".Util::cutText($tour->getLatitude(),7)."</td>";
						echo "<td>".Util::cutText($tour->getLongitude(),7)."</td>";
						echo "<td>".Util::cutText($tour->getBlogUrl(),10)."</td>";
						$distanceM=TourRepository::getDistance($tour->getLatitude(),$tour->getLongitude());
						$distanceKm=$distanceM/1000;
						//echo "<td>".$distance." m - ".$distance/1000." km</td>";
						echo "<td>".Util::cutText($distanceM,7)." m - ".Util::cutText($distanceKm,7)." km</td>";
            echo "<td><input type='button' class='btn btn-outline-primary btn-sm' value='Go!'></nutton></td>";
					echo "</tr>";
			}
		}	
    
	}
	?>
  </tbody>
</table>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo KEYMAP; ?>&libraries=places&callback=initMap"></script>

<!--Este es un componente modal de boostrap 5: https://getbootstrap.com/docs/5.0/components/modal/
Solo es clicable si se asocia a través de javascript con un evento on click -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New tour</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		    <p>Are you sure you want to create a new tour?</p>
      </div>
      <div class="modal-footer">
			<form method="post" action='<?php echo PATHSERVER; ?>Tour/insertForm'>
				<input type="hidden" id="modalCoordinatesLat" name="modalCoordinatesLat" />
				<input type="hidden" id="modalCoordinatesLng" name="modalCoordinatesLng" />
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type='submit' id="buttonModalCoordinates" name="buttonModalCoordinates" class="btn btn-primary">Go!</button>
      </form>

      </div>
    </div>
  </div>
</div>



<?php include_once("./views/templates/document-end.php");?>




		

