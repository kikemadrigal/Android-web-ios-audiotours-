<?php include_once("./views/templates/document-start.php");?>
<script src="<?php echo PATHJS; ?>search.js"></script>
<br />



<!--Esta fila es para mostrar la paginación-->
<div class="row">
    <div class="col-md-12">
        <div id="divPagination"></div>
    </div> 
</div>
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
  


<?php include_once("./views/templates/document-end.php");?>
