<script type="text/javascript" {{--  src='https://maps.google.com/maps/api/js?language={{ app()->getLocale() }}&libraries=places&key={{ App\Models\SiteSetting::where('key', 'google_places')->first()->value }}'>   --}}
    src='https://maps.google.com/maps/api/js?language={{ app()->getLocale() }}&libraries=places&key=AIzaSyDAcNGRxy3xOCZTxU3TBg-TyUsEgbU1ltU'>
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

            if (Livewire != undefined) {
                Livewire.on('updateMap', () => {
                    MapContainer.initMap(null, this);
                })
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
                draggable: !!({{ isset($draggable) ? 'true' : 'false' }})
            });


            instance.geocoder.geocode({
                'latLng': myLatlng
            }, (results, status) => {

                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        let forematedAddress = '';
                        if (instance.address) {
                            instance.address.value = results[0].formatted_address;
                            forematedAddress = results[0].formatted_address;
                        }
                        instance.lat.value = instance.marker.getPosition().lat();
                        instance.lng.value = instance.marker.getPosition().lng();
                        instance.infowindow.setContent(results[0].formatted_address);
                        instance.infowindow.open(instance.map, instance.marker);
                        if (Livewire != undefined) {
                            Livewire.emit('changeMap', instance.marker.getPosition().lat(),
                                instance.marker.getPosition().lng(), forematedAddress);
                        }

                    }
                }
            });

            google.maps.event.addListener(instance.marker, 'dragend', function() {

                instance.geocoder.geocode({
                    'latLng': instance.marker.getPosition()
                }, (results, status) => {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            let forematedAddress = '';
                            if (instance.address) {
                                instance.address.value = results[0].formatted_address;
                                forematedAddress = results[0].formatted_address;
                            }
                            instance.lat.value = instance.marker.getPosition().lat();
                            instance.lng.value = instance.marker.getPosition().lng();
                            instance.infowindow.setContent(results[0].formatted_address);
                            instance.infowindow.open(instance.map, instance.marker);

                            if (Livewire != undefined) {
                                Livewire.emit('changeMap', instance.marker.getPosition().lat(),
                                    instance.marker.getPosition().lng(), forematedAddress);
                            }
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



{{-- #Maps --}}
{{--  <script>
    $(document).keypress(
    function(event){
        if (event.which == '13') {
            event.preventDefault();
        }
    });

    function initMap() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (p) {

                const myLatlng = {
                    lat: p.coords.latitude,
                    lng: p.coords.longitude
                };
    
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 18,
                    center: myLatlng,
                    mapTypeControl: false,
                    streetViewControl: false,
                });

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(p.coords.latitude, p.coords.longitude),
                    map: map,
                    title: 'Set lat/lon values for this property',
                    draggable: true,
                    streetViewControl: false,
    
                });

                GetAddress(new google.maps.LatLng(p.coords.latitude, p.coords.longitude) , map , marker)

                var autocomplete = new google.maps.places.Autocomplete(document.getElementById('searchTextField'));
    
                document.getElementById("searchTextField").addEventListener("keyup", () => {
                    geocodeAddress(new google.maps.Geocoder() , map , marker);
                });
    
                document.getElementById("searchTextField").addEventListener("change", () => {
                    geocodeAddress(new google.maps.Geocoder() , map , marker);
                });
    
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    GetAddress(new google.maps.LatLng( marker.getPosition().lat(), marker.getPosition().lng()) , map , marker)
                });
    
                google.maps.event.addListener(map, 'click', function(event) {
                    GetAddress(new google.maps.LatLng( event.latLng.lat(), event.latLng.lng()) , map , marker)
                });
            });
        }
    }

    function geocodeAddress(geocoder, map , marker) {
        geocoder.geocode({ address: $('#searchTextField').val() }, (results, status) => {
            if (results != null) {
                GetAddress(new google.maps.LatLng( results[0].geometry.location.lat(), results[0].geometry.location.lng() ) , map , marker)
            }
        });
    }

    function GetAddress(latlng , map , marker) {
        var geocoder = geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'latLng': latlng }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    $("#searchTextField").val(results[1].formatted_address);
                    $('#lat').val(results[0].geometry.location.lat())
                    $('#lng').val(results[0].geometry.location.lng())
                    map.setCenter(results[0].geometry.location);
                    marker.setPosition(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
                    map.setZoom(18);
                }
            }
        });
    }

    
</script>  --}}

{{--  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAcNGRxy3xOCZTxU3TBg-TyUsEgbU1ltU&callback=initMap&libraries=places&language=ar" type="text/javascript"></script>  --}}
{{-- #Maps --}}
