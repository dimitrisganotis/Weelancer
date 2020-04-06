//Autocomplete form address
var map = new google.maps.Map(document.getElementById('mapview'), {
    center: {lat: 39.63523845279954, lng: 22.418949127197266},
    zoom: 13
});
var input = document.getElementById('searchInput');
var autocomplete = new google.maps.places.Autocomplete(input);
autocomplete.bindTo('bounds', map);
var infowindow = new google.maps.InfoWindow();
var marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
});
autocomplete.addListener('place_changed', function () {
    infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
        window.alert("Autocomplete's returned place contains no geometry");
        return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
    } else {
        map.setCenter(place.geometry.location);
    }

    marker.setPosition(place.geometry.location);

    //Location details
    for (var i = 0; i < place.address_components.length; i++) {
        if (place.address_components[i].types[0] == 'postal_code') {
            document.getElementById('postal_code').value = place.address_components[i].long_name;
        }
        if (place.address_components[i].types[0] == 'locality') {
            document.getElementById('locality').value = place.address_components[i].long_name;
        }
        if (place.address_components[i].types[0] == 'route') {
            document.getElementById('route').value = place.address_components[i].long_name;
        }
        if (place.address_components[i].types[0] == 'street_number') {
            document.getElementById('street_number').value = place.address_components[i].long_name;
        }
    }
    document.getElementById('location').value = place.formatted_address;
    document.getElementById('lat1').value = place.geometry.location.lat();
    document.getElementById('lng1').value = place.geometry.location.lng();
});

