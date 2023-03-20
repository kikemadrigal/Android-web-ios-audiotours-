/*********************************************************
 *                      Google Maps API
 * geo: te permite buscar através del código postal una coordenada geográfica
 * direccion: calcula la ruta de un punto a a un punto b
 * route: te permite ver información de carreteras como la velocidad máxima, el número de carriles
 * places: te brinda información sobre los puntos de interés más cercanos a una coordenada
 * 
 * 
 * Distance nmatrix API: tiempo de viaje y distancia entre 2 puntos
 * Directions API: rutas entre 2 puntos: https://developers.google.com/maps/documentation/directions/get-directions?hl=es-419
 * Places API: Obtenga información detallada sobre 100 millones de lugares: https://developers.google.com/maps/documentation/javascript/places?hl=es-419
/*********************************************************/
/**--
 license
 Copyright 2023 tipolisto.es. All Rights Reserved.
 SPDX-License-Identifier: Apache-2.0
*/
const PATHSERVER="https://audiotours.es/";
//Variables globales
let map;
let marker;
let directionService;
let directionDisplay;
let servicePlace;
//Geolocalización
let watchID;
let geoLoc;
let latitud;
let longitud;
let posMadrid={lat:40.41651308290394, lng:-3.6785247648211117};
let seguimiento=true;
var primeraVezSolicitaTour=true;

const styles = {
    default: [],
    hide: [
        {
        featureType: "poi.business",
        stylers: [{ visibility: "off" }],
        },
        {
        featureType: "transit",
        elementType: "labels.icon",
        stylers: [{ visibility: "off" }],
        },
    ],
};

/**
 * Esta función es llamada en el <script async defer src="https://maps.googleapis.com/maps/api/js?key=APY_KEY=initMap"></script>
 */
function initMap() {
   
    //Creamos el mapa en una ubicación cualkiera
    //const posMurcia={lat: 37.9805949, lng: -1.162194};
    var mapOptions = {
        center: posMadrid,
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
    const image = PATHSERVER+"media/walking.png";
    marker = new google.maps.Marker({
        position: posMadrid,
        map: map,
        icon: image
    });
    getPosition();
    /**
     * Estilos en mapa: https://developers.google.com/maps/documentation/javascript/examples/hiding-features
     */
     // Add controls to the map, allowing users to hide/show features.
    const styleControl = document.getElementById("style-selector-control");
    //map.controls[google.maps.ControlPosition.TOP_LEFT].push(styleControl);
    // Apply new JSON when the user chooses to hide/show features.
    document.getElementById("hide-poi").addEventListener("click", () => {
      map.setOptions({ styles: styles["hide"] });
    });
    document.getElementById("show-poi").addEventListener("click", () => {
      map.setOptions({ styles: styles["default"] });
    });

    




    /**
     * Directions
     */
  //https://developers.google.com/maps/documentation/javascript/directions?_gl=1*1wd2g39*_ga*MTM2MDgxMDYwMC4xNjc4NzQyMTM4*_ga_NRWSTWS78N*MTY3OTExOTExNS4xMi4xLjE2NzkxMjI5NjIuMC4wLjA.&hl=es-419
    directionService=new google.maps.DirectionsService();
    directionDisplay=new google.maps.DirectionsRenderer();
    directionDisplay.setMap(map);


    //Create autocomplete objects for all input
    //para ver los tipos aplicables al autocompletado de google places: https://developers.google.com/maps/documentation/places/web-service/supported_types?hl=es-419
    var options ={
       // types: ['(cities)']
       types:[ ('address') ]
    }
    var input1=document.getElementById("from");
    var autoComplete1= new google.maps.places.Autocomplete(input1, options);

    var input2=document.getElementById("to");
    var autoComplete2= new google.maps.places.Autocomplete(input2, options);

    var buttonDirections=document.getElementById("btnDirections");
    buttonDirections.addEventListener("click", function(){
        if(input1.value.length!=0 && input2.value.length!=0){
            var valueFrom=document.getElementById("from").value;
            var valueTo=document.getElementById("to").value;
            calcRoute(valueFrom,valueTo);
        }else{
            console.log("algun campo esta vacio");
        }
    });

    /**
     * Places
     */
    //var inputPlaces=document.getElementById("textPlaces");
    //var autoComplete3= new google.maps.places.Autocomplete(inputPlaces, options);
    //servicePlace = new google.maps.places.PlacesService(map);
    //var buttonPlaces=document.getElementById("btnPlaces");
    //buttonPlaces.addEventListener("click", function(){

        //if(inputPlaces.value.length!=0){
            //getPlaces();
            //getRestaurants();
        //}else{
           // console.log("algun campo esta vacio");
        //}
    //});



    
    /**
     * Segumiento
     */
    var miCheckbox = document.getElementById('enableTrackingCheckBox');
    var msg = document.getElementById('output');
    miCheckbox.addEventListener('click', function() {
    if(!miCheckbox.checked) {
        msg.innerText = 'El seguimiento está desactivado';
        msg.classList.add("bg-warning");
        seguimiento=false;
    } else {
        msg.innerText = '';
        msg.classList.remove("bg-warning");
        seguimiento=true;
    }
    });

    /**
     * Si se presiona el botón se muestra las opciones de configuraión SE OCULTA O MUESTRA EL DIV DE CONFIGURACIÓN
     */
    var divShowCoordinates = document.getElementById('showCoordinates');
    divShowCoordinates.style.display = "inline";
    var btnConfigration = document.getElementById('btnConfigurationMap');
    var panelConfiguration = document.getElementById('configurationMapHideShow');
    panelConfiguration.style.display = "none";
    btnConfigration.addEventListener('click', function() {
        if (panelConfiguration.style.display === "none") {
            panelConfiguration.style.display = "block";
            btnConfigration.innerHTML="-";
        } else {
            panelConfiguration.style.display = "none";
            btnConfigration.innerHTML="+";
        }
    });




    /**
     * Actualización peticiones tours
     */
    //
    var selectInterval = document.getElementById("selectInterval");
    setInterval(intervalLoadTours,10000);
    var intervalID=0;
    selectInterval.addEventListener("change", function() {
        var valueSelectInterval = selectInterval.value;
        //console.log("Cambiado item interval a "+valueSelectInterval);
        clearInterval(intervalID);
        intervalID = setInterval(intervalLoadTours,valueSelectInterval);
    });




    /**
     * Obtenemos todos los tours y dividimos entre 10 para la paginación
     */
    let urlCountTours=PATHSERVER+"api/getCountAllTours.php";
    fetch(urlCountTours)
    .then(response=>response.json())
    .then(data=>{
        console.log("data obtenida "+data);
        let pages=data/10;
        //let lastPages=data-pages*10;
        let number=0;
        var content="<nav aria-label='Page navigation example'><ul class='pagination'>";
        content+="<li class='page-item' onclick='cargarTours(0, "+latitud+", "+longitud+")' ><a class='page-link' href='#'>First</a></li>";
        for(var i=0; i<data;i+=10){
            //api/getAllTours.php?page="+page+"&lat="+latitud+"&lng="+longitud
            content+="<li class='page-item' onclick='cargarTours("+number+", "+latitud+", "+longitud+")'><a class='page-link' href='#'>"+number+"</a></li>"; 
            number++;
        }    
        content+="<li class='page-item'  onclick='cargarTours("+pages+", "+latitud+", "+longitud+")' ><a class='page-link' href='#'>Last</a></li>";
        content+="</ul></nav>";
        document.getElementById("divPagination").innerHTML=content;
    })
    .catch (error=>console.log(error));
    
}

function intervalLoadTours(){
    //console.log("Cargado con interval");
    //cargarTours(página_actual, latitud, longitud)
    if(seguimiento)cargarTours(0, latitud, longitud);
}


function getPosition(){
    if (navigator.geolocation) {
        //Ejecuta cada 60000 milisegundos (60 segundos, 1 minuto)
        // 300000 -5 segundos
        //3600000 - 60 segundos
        var options={timeout:300000}
        geoLoc=navigator.geolocation;
        //console.log("obtenida geolocalizacion: "+geoLoc);
        //Con wachPosition vigilamos constantemente la localización
        watchID=geoLoc.watchPosition(showLocationOnMap, errorHandler, options);
    }else{
        const outPut=document.querySelector('#output');
        outPut.innerHTML="<div class='alert-info'>No es posible acceder su localización</div>";
        //console.log("No se obtuvo geolocalizacion");
    }
}

//El parámetro position es obtenida directamente del explorador
function showLocationOnMap(position){
    latitud=position.coords.latitude;
    longitud=position.coords.longitude;
    //console.log("laitutd "+latitud+", longitud "+longitud);
    //Le seteamos al marker y al mapa la posición nueva
    myLatLng={lat: latitud, lng: longitud};
    marker.setPosition(myLatLng);
    map.setCenter(myLatLng);
    if(primeraVezSolicitaTour) {
        intervalLoadTours();
        primeraVezSolicitaTour=false;
    }
    document.getElementById("showCoordinates").innerHTML=latitud+", "+longitud;
}

function errorHandler(err){
    if(err.code==1){
        //alert("Error: Acceso denegado");
    }else if(err.code==2){
        //alert("Error: La posicion no existe o nose encuentra");
        const outPut=document.querySelector('#output');
        outPut.innerHTML="<div class='alert-info'>No es posible acceder su localización</div>";
    }
}


/**
 * Directions service
 */




function calcRoute(valueFrom, valueTo){
    //console.log("recibido: de "+valueFrom+" a: "+valueTo);
    //WALKING , BYCLYCLING AND TRANSIST
    var selectDirections = document.getElementById("selectDirections");
    //eSTO DARÁ 
    var valueSelectDirections = selectDirections.value;
    //var textSelectDirections = selectDirections.options[selectDirections.selectedIndex].text;
    var googleTravelMode=google.maps.TravelMode.WALKING;
    switch(valueSelectDirections){
        case "DRIVING":
            googleTravelMode=google.maps.TravelMode.DRIVING;
        break;
        case "BYCYCLING":
            googleTravelMode=google.maps.TravelMode.BICYCLING;
        break;
        case "TRANSIT":
            googleTravelMode=google.maps.TravelMode.TRANSIT;
        break;
        case "WALKING":
            googleTravelMode=google.maps.TravelMode.WALKING;
        break;
    }
    //destination: El ID del lugar, la dirección o el valor textual de latitud/longitud hacia el que desea calcular las direcciones. Las opciones para el parámetro de destino son las mismas que para el parámetro de origen.
    var request= {
        origin: valueFrom,
        destination: valueTo,
        travelMode: googleTravelMode, 
        unitSystem: google.maps.UnitSystem.IMPERIAL
    }

    //Pass the request to the route method
    directionService.route(request,(result, status)=>{
        if(status== google.maps.DirectionsStatus.OK){
            //get distance and time
            const outPut=document.querySelector('#output');
            outPut.innerHTML="<div class='alert-info'> from: "+ document.getElementById("from").value+ ".<br />To: "+document.getElementById("to").value+".<br /> Driving distance <i class='fa-solid fa-road'></i>: "+result.routes[0].legs[0].distance.text+".<br />Duration<i class='fa-solid fa-clock'></i>:"+ result.routes[0].legs[0].duration.text+".</div>";
            //Display route
            directionDisplay.setDirections(result);
        }else{
            //Delete route from map
            directionDisplay.setDirections({routes: []});
            //Center map in spain
            map.setCenter(posMadrid);

            //Show error message
            outPut.innerHTML="<div class='alert-danger'><i class='fa-regular fa-triangle-exclamation'></i>Could not retrieve driving distance</div>";
        }
    });
}

/**
 * Place services
 */
function getPlaces(){
    console.log("hasentrado en getPlaces");
    var request = {
        query: document.getElementById("textPlaces").value,
        fields: ['name', 'geometry','icon'],
    };
    photos=[];
    servicePlace.findPlaceFromQuery(request, function(results, status) {
        console.log("hasentrado en resultado");
        if (status === google.maps.places.PlacesServiceStatus.OK) {
            console.log("resultados: "+results.length);
          for (var i = 0; i < results.length; i++) {
            marker = new google.maps.Marker({
                position: results[i].geometry.location,
                map: map,
                icon: results[i].icon,
                title: results[i].name
            });
            let content="<h3>"+results[i].name+"</h3>"+" <h4>"+results[i].vicinity+"</h4> Rating: "+results[i].rating;
            var infoWindow=new google.maps.InfoWindow({
                content:content
            });
            bindInfoWindow(marker,infoWindow,content);
          }
          map.setCenter(results[0].geometry.location);
        }else{
            console.log("Sin reslutados");
        }
    });
}

function bindInfoWindow(marker, infoWindow, html){
    marker.addListener('click', function(){
        infoWindow.setContent(html);
        infoWindow.open(map, this);
    });

}
function getRestaurants(){
    if (navigator.geolocation) {
        var mylatLong= new google.maps.LatLng(37.969436430231,-1.199436714461175);

        var request = {
            location: mylatLong,
            radius: '15000',
            type: ['restaurant']
        }
        servicePlace.nearbySearch(request,function(results, status) {
            console.log("vamos a ver los restaurabntes cercanos a la localizacion "+latitud+", "+longitud);
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                console.log("resultados: "+results.length);
                for (var i = 0; i < results.length; i++) {
                    var marker = new google.maps.Marker({
                        position: results[i].geometry.location,
                        map: map,
                        icon: results[i].icon
                    });
                    let content="<h3>"+results[i].name+"</h3>"+" <h4>"+results[i].vicinity+"</h4> Rating: "+results[i].rating;
                    var infoWindow=new google.maps.InfoWindow({
                        content:content
                    });
                    bindInfoWindow(marker,infoWindow,content);
              }
              map.setCenter(results[0].geometry.location);
            }else{
                console.log("Sin reslutados");
            }
        });
    }
}





var cargarTours=function (page, latitud, longitud){
    //console.log("nueva petición");
    let url=PATHSERVER+"api/getAllTours.php?page="+page+"&lat="+latitud+"&lng="+longitud;
    const container=document.querySelector('#container-cards');
    
    countImage=0;
    countAudio=0;
    countDistance=0;
    fetch(url)
        .then(response=>response.json())
        .then(markers=>{
            var markersArray=new Array();
            container.innerHTML="";
            var infoWindow = new google.maps.InfoWindow();
			for (var i = 0; i < markers.length; i++) {
				var data = markers[i];
				//console.log(data.distance);
				var myLatlng = new google.maps.LatLng(data.latitude, data.longitude);
				var image = PATHSERVER+"media/audiotourflag64px.png";
				var marker = new google.maps.Marker({
					position: myLatlng,
					label: data.name,
					map: map,
					title: data.description.substring(0,10),
					animation: google.maps.Animation.DROP,
					icon: image
				});
                //Cremoa una venatana de información por cada marker
                markersArray.push(marker);
				(function (marker, data) {
					google.maps.event.addListener(marker, "click", function (e) {
						const contentString =
                            '<div class="infoWindow">' +
                            "<strong>"+data.name+"</strong>"+
                            "<a href='"+PATHSERVER+"index/Tour/show/"+data.id+"'><img src='"+PATHSERVER+data.pathImage+"/"+data.nameImage+"' width='180' /></a>"+
                            "<p>"+data.description.substring(0,100)+"...<p>"+
                            "</div>";
						infoWindow.setContent(contentString);
						infoWindow.open(map, marker);
					});
				})(marker, data);

                /*var textShowCoordinates=document.getElementById("showCoordinates").innerHTML;
                var positionPlayer=null;
                if(textShowCoordinates!=null){
                    let arrayCoodenates = textShowCoordinates.split(',');
                    
                    var latitude=arrayCoodenates[0];
                    var longitude=arrayCoodenates[1];
                    //positionPlayer = new google.maps.LatLng(latitude, longitude);
                    positionPlayer ={lat: latitude, lng: longitude};
                    console.log("player "+positionPlayer.lat);
                }else{
                    console.log("texcoordinaates es null"); 
                }*/
                //console.log("address "+data.address);
                //positionPlayer = new google.maps.LatLng(37.969436430231,-1.199436714461175);
              
                
                const distance=data.distance;
                //container.innerHTML+="<div class='col-md-3 text-center'><div class='card p-2'>"+data.name+"<br /><a href='"+PATHSERVER+"index/Tour/show/"+data.id+"'><img src='"+PATHSERVER+data.pathImage+"/"+data.nameImage+"'  height='200px' /><br/> Distance: "+distance+"<br /><audio src='"+PATHSERVER+data.pathAudio+"/"+data.nameAudio+"' controls  /></a></div></div>";
                //container.innerHTML+="<div class='col-md-3 text-center'><div class='card p-2'>"+data.name+"<br /><a href='"+PATHSERVER+"index/Tour/show/"+data.id+"'><img src='"+PATHSERVER+data.pathImage+"/"+data.nameImage+"' class='show-picture' /><br/> Distance: "+distance+"</a><button class='btn btn-outline-primary btn-sm px-50' onClick='calcRoute("+data.address+","+myLatlng+")'>Go!</button></div></div>";
                container.innerHTML+="<div class='col-md-3 text-center'><div class='card p-2'>"+data.name+"<br /><a href='"+PATHSERVER+"index/Tour/show/"+data.id+"'><img src='"+PATHSERVER+data.pathImage+"/"+data.nameImage+"' class='show-picture' /><br/> Distance: "+distance+"</a></div></div>";

			}
        })
        .catch (error=>console.log(error));
        
}

/*window.onload = function () {
    console.log("Cargado mapa");
}*/


window.initMap = initMap;