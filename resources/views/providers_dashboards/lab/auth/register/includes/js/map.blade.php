<script type="text/javascript"
    src='https://maps.google.com/maps/api/js?language={{ app()->getLocale() }}&libraries=places&key=AIzaSyBn3NtsJ5lgHSIxUJ4AuqAMm2RXldDDjN8'>
</script>

<script>
    class MapContainer {
        constructor(mapContainer) {
            this.map;
            this.marker;
            this.lat = mapContainer.querySelector('.lat');
            this.lng = mapContainer.querySelector('.lng');
            this.address = mapContainer.querySelector('.address')
            this.geocoder = new google.maps.Geocoder();
            this.infowindow = new google.maps.InfoWindow();
            this.mapContainer = mapContainer;

            google.maps.event.addDomListener(window, 'load', MapContainer.initialize(this));

            // if(lat.value !== '' && lng.value !== ''){
            google.maps.event.addDomListener(window, 'load', MapContainer.initMap(null, this));
            // }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((p) => {
                    let LatLng = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);
                    MapContainer.initMap(LatLng, this)
                });
            } else {
                alert('Geo Location feature is not supported in this browser.');
            }
        }

        static initMap(latLng, instance) {
            console.log(instance.mapContainer);
            let myLatlng;
            if (instance.lat.value === '' || instance.lng.value === '') {
                myLatlng = latLng;
            } else {
                myLatlng = new google.maps.LatLng(instance.lat.value, instance.lng.value)
            }
            let mapOptions = {
                zoom: 10,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            let map = new google.maps.Map(instance.mapContainer.querySelector(".map"), mapOptions);
            instance.marker = new google.maps.Marker({
                map: map,
                position: myLatlng,
                draggable: !!({{ $draggable ? 'true' : 'false' }})
            });


            instance.geocoder.geocode({
                'latLng': myLatlng
            }, (results, status) => {

                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        instance.address.value = results[0].formatted_address;
                        instance.lat.value = instance.marker.getPosition().lat();
                        instance.lng.value = instance.marker.getPosition().lng();
                        instance.infowindow.setContent(results[0].formatted_address);
                        instance.infowindow.open(instance.map, instance.marker);
                    }
                }
            });

            google.maps.event.addListener(instance.marker, 'dragend', function() {

                instance.geocoder.geocode({
                    'latLng': instance.marker.getPosition()
                }, (results, status) => {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            instance.address.value = results[0].formatted_address;
                            instance.lat.value = instance.marker.getPosition().lat();
                            instance.lng.value = instance.marker.getPosition().lng();
                            instance.infowindow.setContent(results[0].formatted_address);
                            instance.infowindow.open(instance.map, instance.marker);
                        }
                    }
                });
            });
        }

        static initialize(instance) {
            let input = instance.mapContainer.querySelector('.mapSearch');
            let autocomplete = new google.maps.places.Autocomplete(
                /** @type {HTMLInputElement} */
                (input), {
                    types: ['(cities)'],
                });
            google.maps.event.addListener(autocomplete, 'place_changed', () => {
                let place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
                instance.lat.value = place.geometry.location.lat();
                instance.lng.value = place.geometry.location.lng();
                // initMap();
                let address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name ||
                            ''),
                        (place.address_components[1] && place.address_components[1].short_name ||
                            ''),
                        (place.address_components[2] && place.address_components[2].short_name ||
                            '')
                    ].join(' ');
                }
                instance.initMap(null, instance);
            });

        }
    }


    let mapconts = document.querySelectorAll('.map_container');
    for (let i = 0; i < mapconts.length; i++) {
        new MapContainer(mapconts[i]);
    }
</script>
