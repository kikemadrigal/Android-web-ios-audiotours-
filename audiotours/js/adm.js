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
let cartelPosicion;
let directionService;
let directionDisplay;
let servicePlace;
//Geolocalización
let watchID;
let geoLoc;
let latitud;
let longitud;
let posMadrid={lat:40.41651308290394, lng:-3.6785247648211117};

/**
 * Esta función es llamada en el <script async defer src="https://maps.googleapis.com/maps/api/js?key=APY_KEY=initMap"></script>
 */
function initMap() {
    //Creamos el mapa en una ubicación cualkiera
    const posMurcia={lat: 37.9805949, lng: -1.162194};
    var mapOptions = {
        center: posMurcia,
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
    const image = PATHSERVER+"media/walking.png";
    marker = new google.maps.Marker({
        position: posMurcia,
        map: map,
        icon: image
    });
    cartelPosicion = new google.maps.InfoWindow();
    getPosition();


    /**
     * Directions
     */
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
            calcRoute();
        }else{
            console.log("algun campo esta vacio");
        }
    });

    /**
     * Places
     */
    var inputPlaces=document.getElementById("textPlaces");
    var autoComplete3= new google.maps.places.Autocomplete(inputPlaces, options);
    servicePlace = new google.maps.places.PlacesService(map);
    var buttonPlaces=document.getElementById("btnPlaces");
    buttonPlaces.addEventListener("click", function(){

        //if(inputPlaces.value.length!=0){
            //getPlaces();
            getRestaurants();
        //}else{
           // console.log("algun campo esta vacio");
        //}
    });

    eventsAdm();
    cargarTours(200);
}


function getPosition(){
    if (navigator.geolocation) {
        //Ejecuta cada 60000 milisegundos (60 segundos, 1 minuto)
        var options={timeout:60000}
        geoLoc=navigator.geolocation;
        console.log(geoLoc);
        //Con wachPosition vigilamos constantemente la localización
        watchID=geoLoc.watchPosition(showLocationOnMap, errorHandler, options);
    }else{
        const outPut=document.querySelector('#output');
        outPut.innerHTML="<div class='alert-info'>Enable geolocation to find the closest tours<br />Ve a Ajustes->Configuración-></div>";
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
}

function errorHandler(err){
    if(err.code==1){
        //alert("Error: Acceso denegado");
    }else if(err.code==2){
        alert("Error: La posicion no existe o nose encuentra");
    }
}


/**
 * Directions service
 */




function calcRoute(){
    //WALKING , BYCLYCLING AND TRANSIST
    var request= {
        origin: document.getElementById("from").value,
        destination: document.getElementById("to").value,
        travelMode: google.maps.TravelMode.WALKING, 
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


var eventsAdm=function(){

    google.maps.event.addListener(map, "click", function(evento) {
        var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
            keyboard: false
        })
        //var modal=document.getElementById("myModal")
        myModal.show();
        //var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        //var recipient = button.getAttribute('data-bs-whatever')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        //var modalTitle = exampleModal.querySelector('.modal-title')
        //var modalBodyInput = exampleModal.querySelector('.modal-body input')

        //modalTitle.textContent = 'New message to ' + recipient
        //modalBodyInput.value = recipient
	});
    
    google.maps.event.addListener(map, "mousemove", function(evento) {
        lat = evento.latLng.lat();
       lng = evento.latLng.lng();
       //console.log("lat :"+lat+", long: "+lng);
       if(lat!=null && lng!=null){
           document.getElementById("showCoordinates").innerHTML =lat+", "+lng;	
           document.getElementById("modalCoordinatesLat").value =lat;
           document.getElementById("modalCoordinatesLng").value =lng;
       }
   });
    
}

var cargarTours=function (maxMarkers){
    let url=PATHSERVER+"api/getAllTours.php?maxMarkers="+maxMarkers;
    fetch(url)
        .then(response=>response.json())
        .then(markers=>{
            var infoWindow = new google.maps.InfoWindow();
			for (var i = 0; i < markers.length; i++) {
				var data = markers[i];
				console.log(data.name);
				var myLatlng = new google.maps.LatLng(data.latitude, data.longitude);
				var image = "http://audiotours.es/media/audiotourflag.png";
				var marker = new google.maps.Marker({
					position: myLatlng,
					label: data.name,
					map: map,
					title: data.description,
					animation: google.maps.Animation.DROP,
					icon: image
				});
				//markersArray.push(marker);
				//(function (marker, data) {
				//	google.maps.event.addListener(marker, "click", function (e) {
				//		var rutaImagen=data.path+"/"+data.name;
				//		infoWindow.setContent("<div style = 'width:100px;min-height:40px'><a href=https://www.fotomapa.es/photos/show/"+data.text+"><b>"+data.type.substring(0,26)+"</b><br><img src="+rutaImagen+" width=100px alt="+rutaImagen+"></img><br>"+data.text.substring(0,50)+"<br>" + data.timeStamp + "</a></div>");
				//		infoWindow.open(map, marker);
				//	});
				//})(marker, data);
			}
        })
        .catch (error=>console.log(error));
}

/*var cargarTours=function (maxMarkers){
	//console.log("marcadores maximos: "+maxMarkers);
	$.ajax({
		type: 'GET',
		url: PATHSERVER+"api/getAllTours.php?maxMarkers="+maxMarkers
	}).done(function(info){
			markers=info;
            console.log(markers);
    		var infoWindow = new google.maps.InfoWindow();
			for (var i = 0; i < markers.length; i++) {
				var data = markers[i];
				console.log(data.name);
				var myLatlng = new google.maps.LatLng(data.latitude, data.longitude);
				var image = "http://audiotours.es/media/audiotourflag.png";
				var marker = new google.maps.Marker({
					position: myLatlng,
					label: data.name,
					map: map,
					title: data.description,
					animation: google.maps.Animation.DROP,
					icon: image
				});
				//markersArray.push(marker);
				//(function (marker, data) {
				//	google.maps.event.addListener(marker, "click", function (e) {
				//		var rutaImagen=data.path+"/"+data.name;
				//		infoWindow.setContent("<div style = 'width:100px;min-height:40px'><a href=https://www.fotomapa.es/photos/show/"+data.text+"><b>"+data.type.substring(0,26)+"</b><br><img src="+rutaImagen+" width=100px alt="+rutaImagen+"></img><br>"+data.text.substring(0,50)+"<br>" + data.timeStamp + "</a></div>");
				//		infoWindow.open(map, marker);
				//	});
				//})(marker, data);
			}
	
	});
}*/


/*window.onload = function () {
    console.log("Cargado mapa");
}*/


window.initMap = initMap;