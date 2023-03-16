<?php include_once("./views/templates/document-start.php");
$media=$this->media;
$deleteForm="";
echo "<br />";
echo "<div class='text-center'>";
		echo "<a href='".PATHSERVER."Media/show/".$media->getId()."'>";
			if(PRODUCTION==1)$mediaFile=PATHSERVERSININDEX.$media->getPath()."/".$media->getName();
			else $mediaFile=PATHSERVER.$media->getPath()."/".$media->getName();
			$extension=pathinfo($mediaFile, PATHINFO_EXTENSION);
			if($extension=="mp3"){
                echo "<audio src='".$mediaFile."' controls >Your browser does not support the <code>audio</code> element.</audio>";
				$deleteForm="deleteAudio";
				$updateForm="updateAudio";
			}else{
				echo "<img src=".$mediaFile." height='300px'/><br>";
				$deleteForm="deleteImage";
				$updateForm="updateImage";
			}
			echo $media->getName()."<br>";
		echo "</a><br>";
		$tourId=$media->getTourId();
		$tour=TourRepository::getById($tourId);
        $tours=TourRepository::getAll(0,2000);
		//Update media 
		if (PRODUCTION==1) echo "<form method='post' action='".PATHSERVERSININDEX."Media/".$updateForm."' >";
		else echo "<form method='post' action='".PATHSERVER."Media/".$updateForm."' >";
			echo "<label for='tourId' class='control-label'>Associate with Tour: </label> ";
			echo "<select class='m-4' name='tourId' id='tourId' class='form-control' /> ";
			if ($tour==null) echo "<option value='1' >Without tour</option>";
			else {
				echo "<option value='".$tour->getId()."' >".$tour->getName()."</option>";
				foreach ($tours as $posicion=>$tour){
					if($tour->getId()!=1) //kitamos el 1 que es imagen vacía
						echo "<option value='".$tour->getId()."'>".$tour->getName()."</option>";
				} 
			}
			echo "</select>";
			?>
			<input type="hidden" name="id" id="id" value="<?php echo $media->getId();?>" />
			<button class="btn btn-warning" type="submit" name="submit" >Update</button> 
		</form>
		    <!--Delete media -->     
            <button class="btn btn-danger" type="submit" name="submit"  data-bs-toggle="modal" data-bs-target="#exampleModal"  >Delete</button> 
	</div>





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
			<form method="post" action='<?php echo PATHSERVER; ?>Media/<?php echo $deleteForm; ?>' >
				<input type="hidden" name="id" id="id" value="<?php echo $media->getId();?>" />
				<button type="submit" class="btn btn-danger">Remove!!</button>
			</form>
		</div>
		</div>
	</div>
	</div>
<?php
include_once("./views/templates/document-end.php"); ?>