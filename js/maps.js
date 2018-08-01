var googleMapsAddress;

function prepare() {
    if(googleMapsAddresses.length) {
        jQuery.each(googleMapsAddresses, function(index, address) {
            // googleMapAddress = address;
            useAddress(index);
        });
    }
}

function useAddress(i) {
    var geocoder = new google.maps.Geocoder();
    var index = i;

    geocoder.geocode(
        { "address": googleMapsAddresses[index].address },
        function ( results, status ) {
            if ( status == google.maps.GeocoderStatus.OK ) {
                initialize(index, results[0].geometry.location);
            }
        }
    );
}

function initialize(index, position) {
    var googleMapAddress = googleMapsAddresses[index];
    var mapOptions = {
        zoom     : parseInt( googleMapAddress.zoom ),
        center   : position,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    googleMapAddress.map = new google.maps.Map( document.getElementById(googleMapAddress.container), mapOptions );

    var marker = {
        map     : googleMapAddress.map,
        title   : googleMapAddress.title,
        position: position
    };

    if ( 'undefined' !== googleMapAddress.pin_url && googleMapAddress.pin_url ) {
        marker.icon = googleMapAddress.pin_url;
    }
    new google.maps.Marker(marker);
}

// var script = document.createElement('script');
// script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyClMBaqKEYIBPwZN2KipIRCIzNsTnl0pu0&callback=prepare';
// document.head.appendChild(script);
