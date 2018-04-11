window.onload = charged;
var map;
var markers = [];
var positions = [];
var elems = [];

function charged(){
    if(document.getElementById('map') != null){
        initMap();
    }
    if(window.location.href == "https://dev-21400116.users.info.unicaen.fr/Wildlife_watch/?a=logInVerif"){
        window.location.replace("https://dev-21400116.users.info.unicaen.fr/Wildlife_watch/");
    }
}

function initMap(){
    var map = new google.maps.Map(document.getElementById('map'), {
        center: new google.maps.LatLng(49.183333, -0.35),
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    if(document.querySelectorAll(".animalInfos").length != 0){
        setMarkersOnMap(map);
        google.maps.event.addDomListener(window, 'resize', function() {
            setAverageCenter(map);
        });
    }
    else if(document.querySelectorAll(".animalsHeatmap").length != 0){
        console.log(setHeatmapPoints(map));
        heatmap = new google.maps.visualization.HeatmapLayer({
            data: setHeatmapPoints(map),
            map: map
          });
        heatmap.set('radius',15);
    }
    else{
        map.addListener('click', function(event) {
            addMarker(event.latLng,map);
          });
  
    }
}

function addMarker(location,map) {
    setMapOnAll(null);
    markers = [];
    var marker = new google.maps.Marker({
      position: location,
      map: map
    });
    let locat = location.toString().replace(')','').replace('(','');
    document.getElementById('marker').value = locat;
    markers.push(marker);
  }

function setAverageCenter(map){
    var accLat = 0;
    var accLng = 0;
    for(var i = 0; i < positions.length; i++){
        accLat += positions[i].lat;
        accLng += positions[i].lng;
    }
    var averageLat = accLat/(positions.length);
    var averageLng = accLng/(positions.length);
    var newCenter = new google.maps.LatLng(averageLat,averageLng);
    map.setCenter(newCenter);
}

function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
  }

function showMore(idSpan){
    var firstElem = document.getElementById(idSpan);
    var secondElem = document.getElementById("last_"+idSpan.split('_')[1]);
    firstElem.style.display = 'none';
    secondElem.style.display = 'block';
} 

function showLess(idSpan){
    var firstElem = document.getElementById(idSpan);
    var secondElem = document.getElementById("master_"+idSpan.split('_')[1]);
    firstElem.style.display = 'none';
    secondElem.style.display = 'inline';
}

function redirectURL(string){
    var currentUrl = window.location.href;
    console.log(currentUrl);

    var baseUrl = currentUrl.split('?')[0];
    var newUrl = baseUrl+string;
    console.log(newUrl);

    window.location.href = newUrl;
}

function setHeatmapPoints(map){
    var aList = [];
    var allAnimals = document.querySelectorAll(".animalsHeatmap");
    for (var i = 0;i < allAnimals.length; i++){
        if(allAnimals[i].tagName == 'P'){
            var name = allAnimals[i].textContent.split(',')
            aList.push(new google.maps.LatLng(parseFloat(name[0]),parseFloat(name[1])));
        }
    }
    return aList;
}

function setMarkersOnMap(map){
    var allAnimals = document.querySelectorAll(".animalInfos");
    for(var i = 0; i < allAnimals.length; i++){
        if(allAnimals[i].tagName == 'P'){
            elems.push(allAnimals[i]);
            var name = allAnimals[i].textContent.split(',')[0];
            var fullId = allAnimals[i].id;
            var tabId = fullId.split(' ');
            var latlng = {lat : parseFloat(tabId[0]), lng : parseFloat(tabId[1])};
            positions.push(latlng);
            var marker = new google.maps.Marker({
                position : latlng,
                map : map,
                title : "A "+name+" has been spotted !",
                icon : location.pathname+'/images/paw.png'
            });
            markers.push(marker);
        }
    }

    var oneAnimal = document.querySelectorAll('.animalCoords');
    for(var j = 0; j < oneAnimal.length; j++){
        if(oneAnimal[j].tagName == 'SPAN'){
            elems.push(oneAnimal[j]);
            var tabLatLng = oneAnimal[j].textContent.split(', ');
            var latlng = {lat : parseFloat(tabLatLng[0]), lng : parseFloat(tabLatLng[1])};
            positions.push(latlng);
            var marker = new google.maps.Marker({
                position : latlng,
                map : map,
                title : "It has been spotted here !",
                icon : location.pathname+'/images/paw.png'
            });
            markers.push(marker);
        }
    }

    for(let item of elems){
        item.addEventListener('mouseover',(e) =>{
            if(e.target.tagName == 'P'){
                var index = elems.indexOf(e.target);
                markers[index].icon = location.pathname+'/images/paw2.png';
                setMapOnAll(map);
            }
            else if(e.target.tagName == 'SPAN' || e.target.tagName == 'BUTTON' || e.target.tagName == 'A'){
                var prtNode = e.target.parentNode;
                while(prtNode.tagName != "P"){
                    prtNode = prtNode.parentNode
                }
                var index = elems.indexOf(prtNode);
                markers[index].icon = location.pathname+'/images/paw2.png';
                setMapOnAll(map);
            }
            /*
            setMapOnAll(map);
            var marker = new google.maps.Marker({
                position : positions[index].latlng,
                map : map,
                title : "A "+name+" has been spotted !",    
                icon : location.pathname+'/images/paw2.png'
            });
            */
        });

        item.addEventListener('mouseout',(e) =>{
            if(e.target.tagName == 'P'){
                var index = elems.indexOf(e.target);
                markers[index].icon = location.pathname+'/images/paw.png';
                setMapOnAll(map);
            }
            else if(e.target.tagName == 'SPAN' || e.target.tagName == 'BUTTON' || e.target.tagName == 'A'){
                var prtNode = e.target.parentNode;
                while(prtNode.tagName != "P"){
                    prtNode = prtNode.parentNode
                }
                var index = elems.indexOf(prtNode);
                markers[index].icon = location.pathname+'/images/paw.png';
                setMapOnAll(map);
            }
            /*
            setMapOnAll(null);
            markers = [];
            var marker = new google.maps.Marker({
                position : positions[index].latlng,
                map : map,
                title : "A "+name+" has been spotted !",
                icon : location.pathname+'/images/paw.png'
            });
            markers.push(marker);
            */
            
            
        });
    }
    setAverageCenter(map);
}



