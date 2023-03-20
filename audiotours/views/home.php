<?php include_once("./views/templates/document-start.php");?>
<script src="<?php echo PATHJS; ?>map.js"></script>
<br />


<div class="row">
    <div class="col-md-12" >
        <div id="showCoordinates">Coordinates</div>
        <i class="fa-solid fa-screwdriver-wrench"></i>
        <button class="btn btn-info text-center" name="btnConfigurationMap" id="btnConfigurationMap"> + </button>
    </div>
    <div class="col-md-12" name="configurationMapHideShow" id="configurationMapHideShow">
        <div id="style-selector-control">
            <p>Mostrar marcadores de google</p>
            <input type="radio"  name="show-hide" id="hide-poi" class="selector-control" />
            <label for="hide-poi">Hide</label>
            <input type="radio" name="show-hide" id="show-poi" class="selector-control" checked="checked" />
            <label for="show-poi">Show</label>
        </div>
        Intervalo de actualización:<i class="fa-solid fa-upload"></i>
        <select id="selectInterval" name="selectInterval">
            <option value='10000'> 10 segundos</option>
            <option value='1000'> 1 segundo</option>
            <option value='2000'> 2 segundos</option>
            <option value='100000'> 100 segundos público</option>
        </select>
        <div class="form-check p-4"><input type="checkbox" id="enableTrackingCheckBox" name="enableTrackingCheckBox" class="form-check-input" checked><label for="scales" class="form-check-label"> Actualización</label></div> 
        <p>Trazar ruta a un lugar</p>
        Transporte:<i class="fa-solid fa-car"></i>   <i class="fa-solid fa-person-biking"></i><i class="fa-solid fa-person-walking"></i>
        <select id="selectDirections" name="selectDirections">
            <option value="WALKING"> Andando</option>
            <option value="DRIVING"> Vehículo</option>
            <option value="BYCYCLING"> Bicicleta</option>
            <option value="TRANSIT"> Transporte público</option>
        </select>
        <i class="far fa-dot-circle"></i><input type="text" id="from" placeholder="origin" class="form-control">
        <i class="fa-solid fa-diamond-turn-right"></i><input type="text" id="to" placeholder="Destination" class="form-control">
        <button class="btn btn-info text-center btn-lg" id="btnDirections"><i class="fas fa-map-marker-alt"></i></button>
    </div>

</div>



<div class="row">
    <div class="col-md-12">
        <div id="dvMap" style="width: 100%; height:400px;"></div>
    </div> 
    <!--
    <i class="fa-solid fa-diamond-turn-right"></i><input type="text" id="textPlaces" placeholder="Focus on this place" class="form-control">
    <label for="selectPlaces" class="text-end col-form-label "></label>
    <select id="selectPlaces" name="selectPlaces">
        <option value="Restaurant">Restaurant</option>
        <option value="" ></option>
        <option value=""></option>
    </select>
    <br />
    <button class="btn btn-warning text-center btn-lg" id="btnPlaces"><i class="fas fa-map-marker-alt"></i></button>
    -->
</div>
<div class="container-fluid ">
    <div id="output" class="bg-warning"></div>
</div>
<br />
<!--Esta fila es para mostrar la paginación-->
<div class="row">
    <div class="col-md-12">
        <div id="divPagination"></div>
    </div> 
</div>
<div class="row" id="container-cards" name="container-cards">
       
</div>


  

<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo KEYMAP; ?>&libraries=places&callback=initMap"></script>

<?php include_once("./views/templates/document-end.php");?>

		






















			



