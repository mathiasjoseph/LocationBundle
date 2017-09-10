var map;
var marker = new google.maps.Marker();
function initializeAutocomplete(id) {
    var element = document.getElementById(id);
    if (element) {
        var autocomplete = new google.maps.places.Autocomplete(element, {types: ['geocode']});
        google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
    }
}

function initializeMap() {
    var mapCanvas = document.getElementById("map");
    if (document.getElementById("lat").value != null) {
        var mapOptions = {
            center: new google.maps.LatLng(document.getElementById("lat").value, document.getElementById("lng").value),
            zoom: 16
        }
        map = new google.maps.Map(mapCanvas, mapOptions);
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(document.getElementById("lat"), document.getElementById("lng")),
            map: map
        });
    } else {
        var mapOptions = {
            center: new google.maps.LatLng(1, 1),
            zoom: 16
        }
        map = new google.maps.Map(mapCanvas, mapOptions);
    }

}
function onPlaceChanged() {
    var place = this.getPlace();

    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();

    if (lng != null && lat != null) {
        map.setCenter(new google.maps.LatLng(lat, lng));
        marker.setMap(null);
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            map: map
        });
        document.getElementById("lat").value = lat;
        document.getElementById("lng").value = lng;
    }
    for (var i in place.address_components) {
        var component = place.address_components[i];
        for (var j in component.types) {  // Some types are ["country", "political"]
            var type_element = document.getElementById(component.types[j]);
            if (type_element) {
                type_element.value = component.long_name;
            }
            var type_element_short = document.getElementById(component.types[j] + "_short");
            if (type_element_short) {
                type_element_short.value = component.short_name;
            }
        }
    }
}


google.maps.event.addDomListener(window, 'load', function () {
    initializeMap();
    initializeAutocomplete('user_input_autocomplete_address');
});

