var map = L.map('map').setView([-7.79898677945525, 110.37426800776367], 10);
var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">Map</a>'
}).addTo(map);


getPoint($('body').attr('data-asset-path') + 'map_geojson');

function getPoint(url) {
    $.ajax({
        'type': "GET",
        'url': url,
        'data': null,
        'success': function(data) {
            //console.log(data);
            loadGeojsonCluster(data);
        }
    });
}

function loadGeojsonCluster(str) {
    geojson = new L.geoJson(str, {
        style: style,
        onEachFeature: onEachFeature
    });
    var markers = L.markerClusterGroup();
    markers.addLayer(geojson);
    map.addLayer(markers);
    props = null;
    //map.setView([-2.7235830833483856, 112.50000000000001], 5.0);
    $(".info").text('Informasi');
}

function onEachFeature(feature, layer) {
    layer.on('click', function(e) {
        //infoKonten.update('<img src="http://localhost:8080/img/loading.gif">');
        if (feature.geometry['type'] != 'Point') {
            map.fitBounds(layer.getBounds());
            if(feature.properties.Provinsi != null){
                //getKonten();
            }else{
                //infoKonten.update('');
            }
        }else{
            //getKontenP();
        }
    });
}

function style(feature) {
    return {
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.6,
        fillColor: feature.properties.fillcolor
    };
}