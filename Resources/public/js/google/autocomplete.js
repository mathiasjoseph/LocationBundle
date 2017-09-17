var map;
var marker = new google.maps.Marker();
function initializeAutocomplete(id) {
    var element = $("."+id)[0];
    if (element) {
        var autocomplete = new google.maps.places.Autocomplete(element, {types: ['geocode']});
        google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
    }
}

function initializeMap() {
    var lat_element = $(".lat")[0];
    var lng_element = $(".lng")[0];
    if($(".map").length) {
        var mapCanvas = $(".map")[0];
        if (lat_element.value != null) {
            var mapOptions = {
                center: new google.maps.LatLng(lat_element.value, lng_element.value),
                zoom: 5
            }
            map = new google.maps.Map(mapCanvas, mapOptions);
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat_element, lng_element),
                map: map
            });
        } else {
            var mapOptions = {
                center: new google.maps.LatLng(1, 1),
                zoom: 5
            }
            map = new google.maps.Map(mapCanvas, mapOptions);
        }
    }
}
function onPlaceChanged() {
    var place = this.getPlace();
    var lat_element = $(".lat")[0];
    var lng_element = $(".lng")[0];
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();
    if($(".map").length){
        if (lng != null && lat != null) {
        map.setCenter(new google.maps.LatLng(lat, lng));
        marker.setMap(null);
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            map: map
        });
        $(".lat")[0].value = lat;
        $(".lng")[0] .value = lng;
    }}
    for (var i in place.address_components) {
        var component = place.address_components[i];
        for (var j in component.types) {
            if ($("."+component.types[j]).length) {
                $("."+component.types[j]).val(component.long_name);
            }
            if ($("."+component.types[j]+ "_short").length) {
                $("."+component.types[j]+ "_short").val(component.short_name);
            }
        }
    }
}


google.maps.event.addDomListener(window, 'load', function () {
    initializeMap();
    initializeAutocomplete('gm_autocomplete_address');
});

