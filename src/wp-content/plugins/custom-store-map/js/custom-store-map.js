jQuery(document).ready(function($) {
    var defaultIcon = '/wp-content/plugins/custom-store-map/images/icon-map-store.png';
    var locationCountry = customStoreMapSettings.location_country.split(',');
    var zoomLevel = parseInt(customStoreMapSettings.zoom_level, 10);

    function initMap() {
        var locations = customStoreMapData;
        var location = locations.length > 0 ? locations[0].location.split(',') : locationCountry;
        var map = new google.maps.Map(document.getElementById('custom-map'), {
            zoom: zoomLevel,
            center: { lat: parseFloat(location[0]), lng: parseFloat(location[1]) }
        });
        var markers = [];

        function addMarkers(locations) {
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            locations.forEach(function(location) {
                var icon = location.icon ? location.icon : defaultIcon;
                var marker = new google.maps.Marker({
                    position: { lat: parseFloat(location.location.split(',')[0]), lng: parseFloat(location.location.split(',')[1]) },
                    map: map,
                    title: location.name,
                    icon: {
                        url: icon,
                        scaledSize: new google.maps.Size(50, 50)
                    }
                });

                var infoWindow = new google.maps.InfoWindow({
                    content: `<div>
                                <strong>${location.name}</strong><br>
                                <span>${location.address}</span><br>
                                <a href="${location.page_link}" target="_blank">View Items</a>
                            </div>`
                });

                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });

                markers.push(marker);
            });
        }

        addMarkers(locations);

        $('#store-search').on('input', function() {
            var searchQuery = $(this).val().toLowerCase();
            var filteredLocations = locations.filter(function(location) {
                return location.name.toLowerCase().includes(searchQuery);
            });
            addMarkers(filteredLocations);
            updateStoreList(filteredLocations);
        });

        $('#store-list').on('click', '.store-item', function() {
            $('#store-list .store-item').removeClass('active');
            $(this).addClass('active');

            var location = $(this).data('location').split(',');
            var latLng = new google.maps.LatLng(parseFloat(location[0]), parseFloat(location[1]));
            map.setCenter(latLng);
            map.setZoom(16);
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.store-item').length) {
                $('#store-list .store-item').removeClass('active');
            }
        });

        function updateStoreList(locations) {
            var storeList = $('#store-list');
            storeList.empty();
            locations.forEach(function(location) {
                var icon = location.icon ? location.icon : defaultIcon;
                storeList.append(
                    `<div class="store-item" data-location="${location.location}">
                    <div class="d-flex align-items-center">
                        <img src="${icon}" alt="${location.name}" style="max-width: 50px; max-height: 50px;">
                        <strong>${location.name}</strong></div>
                        <div class="store-address">
                        <span >${location.address}</span>
                        </div>
                    </div>`
                );
            });
        }
        updateStoreList(locations);
    }
    window.addEventListener('load', initMap);
});
