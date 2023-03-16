<?php include_once("./views/templates/document-start.php");?>


<div class="row text-center m-2">
    <div class="col-md-3 offset-md-2 ">
        <div class="card">
            <a href="<?php echo PATHSERVER;?>Tour/showAll">
                <img src="<?php echo PATHIMAGES ?>tour-management.PNG" width="200px" alt="">
                <h4 >Tours </h4>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <a href="<?php echo PATHSERVER;?>User/showAll">
                <img src="<?php echo PATHIMAGES ?>user-management.PNG" width="200px" alt="">
                <h4 >Admins </h4>
            </a>
        </div>   
    </div>

    <div class="col-md-3  ">
        <div class="card">
            
            <a href="<?php echo PATHSERVER;?>Media/showAll">

                <img  src="<?php echo PATHIMAGES ?>media-management.PNG" width="200px" alt="">
                <h4 >Media </h4>
            </a>
        </div>   
    </div>
</div>



<div class="row text-center m-2">

    <div class="col-md-3 offset-md-2">
        <div class="card">
            <a href="">
                <img  src="<?php echo PATHIMAGES ?>comments-management.PNG" width="200px" alt="">
                <h4 >Coments </h4>
                </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <a href="<?php echo PATHSERVER;?>Adm/tools">
                <img  src="<?php echo PATHIMAGES ?>tools-management.PNG" width="200px" alt="">
                <h4 >Tools </h4>
                </a>
        </div>
    </div>
</div>


<?php include_once("./views/templates/document-end.php");?>