<?php include_once("./views/templates/document-start.php"); 
//Obtenemos las imágenes del usuario activo
$contador=0;

echo "<br><a href='".PATHSERVER."Media/insertForm' class='btn btn-success m-4'>Insert new multimedia</a>";
//echo "<h3>Medias</h3>";



?>
<div><?php if (!empty($this->message)) echo $this->message ?></div>
 

<nav class="m-4">
	<div class="nav nav-tabs" id="nav-tab" role="tablist">
		<button class="nav-link active" id="nav-images-tab" data-bs-toggle="tab" data-bs-target="#nav-images" type="button" role="tab" aria-controls="nav-images" aria-selected="true">Images</button>
		<button class="nav-link" id="nav-audios-tab" data-bs-toggle="tab" data-bs-target="#nav-audios" type="button" role="tab" aria-controls="nav-audios" aria-selected="false">Audios</button>
	</div>
</nav>

<div class="tab-content" id="nav-tabContent">

  <div class="tab-pane fade show active" id="nav-images" role="tabpanel" aria-labelledby="nav-images-tab">
  	<table class="table table-striped">
		<thead> 
			<tr>
				<th scope="col">Name</th>
				<th scope="col">Image</th>
				<th scope="col">Tour</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if($this->images!=null){
				foreach ($this->images as $posicion=>$image){
					if ($image->getId()!=1){	
						echo "<tr>";
							echo "<td>";
								if(PRODUCTION==1) echo "<a href='".PATHSERVER."Media/updateFormImage/".$image->getId()."'>";
								else echo "<a href='".PATHSERVER."Media/updateFormImage/".$image->getId()."'>";
									if(PRODUCTION==1)$imageFile=PATHSERVERSININDEX.$image->getPath()."/".$image->getName();
									else $imageFile=PATHSERVER.$image->getPath()."/".$image->getName();
									echo "<img src=".$imageFile." width='100px' /><br>";
								echo "</a>";
							echo "</td>";
							echo "<td>".$image->getName()."</td>";
							$tour=TourRepository::getById($image->getTourId());
							echo "<td>".$tour->getName()."</td>";
							/*
							echo "<td>";
								//Delete image    
								echo "<form method='post' action='".PATHSERVER."Media/deleteImage' >";
								echo "<input type='hidden' name='id' id='id' value='".$image->getId()."' />";
								echo "<button class='btn btn-danger' type='submit' name='submit' >Delete</button> ";
								echo "</form>";
							echo "</td>";
							*/
						echo "</tr>";
					}
				}
			}else{
				 echo "<tr><td>Without images</td></tr>";
			}
			?>
		</tbody>
	</table> 

	
  	</div>
  	<div class="tab-pane fade" id="nav-audios" role="tabpanel" aria-labelledby="nav-audios-tab">
  		<table class="table table-striped">
			<thead> 
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Image</th>
					<th scope="col">Tour</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($this->audios!=null){
					foreach ($this->audios as $posicion=>$audio){
						if ($audio->getId()!=1){	
							echo "<tr>";
								echo "<td>";
								if(PRODUCTION==1) echo "<a href='".PATHSERVER."Media/updateFormAudio/".$audio->getId()."'>";
								else echo "<a href='".PATHSERVER."Media/updateFormAudio/".$audio->getId()."'>Update   ";
										if(PRODUCTION==1)$audioFile=PATHSERVERSININDEX.$audio->getPath()."/".$audio->getName();
										else $audioFile=PATHSERVER.$audio->getPath()."/".$audio->getName();
										echo "<audio src=".$audioFile." width='100px' controls></audio>";
									echo "</a>";
								echo "</td>";
								echo "<td>".$audio->getName()."</td>";
								$tour=TourRepository::getById($audio->getTourId());
								echo "<td>".$tour->getName()."</td>";
								/*
								echo "<td>";
								//Delete audio    
								echo "<form method='post' action='".PATHSERVER."Media/deleteAudio' >";
									echo "<input type='hidden' name='id' id='id' value='".$audio->getId()."' />";
									echo "<button class='btn btn-danger' type='submit' name='submit' >Delete</button> ";
								echo "</form>";
								echo "</td>";
								*/
							echo "</tr>";
						}
					}
				}else{
					echo "<tr><td>Without audios</td></tr>";
			   	}
				?>
			</tbody>
		</table>
  	</div>
	  
</div>
















<?php include_once("./views/templates/document-end.php"); ?>