var map;
var service;
var infowindow;


function initMap() {
    if (document.getElementById('coor')) {
        var region = document.getElementById('coor').dataset.region;
        var country = document.getElementById('coor').dataset.country;
        var continent = document.getElementById('coor').dataset.continent;
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'address': region + ',' + country + ',' + continent }, searchPlaces);
    }
}

function searchPlaces(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        var request = {
            location: results[0].geometry.location,
            radius: 500,
            type: ['museum']
        }
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: results[0].geometry.location.lat(), lng: results[0].geometry.location.lng() },
            zoom: 12
        });
        infowindow = new google.maps.InfoWindow();
        service = new google.maps.places.PlacesService(map);
        service.textSearch(request, callback);
    }
}

function callback(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
            var place = results[i];
            createMarker(results[i]);
        }
    }
}

function createMarker(place) {
    var placeLoc = place.geometry.location;
    var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location
    });

    google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent(place.name);
        infowindow.open(map, this);
    });
}
