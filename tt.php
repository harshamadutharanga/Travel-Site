<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Distances Between Two Cities App</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="App.css" rel="stylesheet" />
    <style>
        #googleMap {
            height: 400px; /* Adjust as necessary */
            width: 100%;
        }
    </style>
</head>
<body>
<div class="jumbotron">
    <div class="container-fluid">
        <div class="relative">
        <h1>Find The Distance To visit Your Want.</h1>
        <p>This App Will Help You Calculate Your Travelling Distances.</p>
        </div>
        <form class="form-horizontal">
            <div class="form-group">
                <label for="from" class="col-md-2 control-label"><i class="far fa-dot-circle"></i> From:</label>
                <div class="col-md-2">
                    <input type="text" id="from" placeholder="Origin" class="form-control" >
                </div>
            </div>
            <div class="form-group">
                <label for="to" class="col-md-2 control-label"><i class="fas fa-map-marker-alt"></i> To:</label>
                <div class="col-md-2">
                    <input type="text" id="to" placeholder="Destination" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="mode" class="col-md-2 control-label"><i class="fas fa-shuttle-van"></i></label>
                <div class="col-md-2">
                    <select id="mode" class="form-control">
                        <option value="DRIVING">Car</option>
                        <option value="BICYCLING">Bike</option>
                        <option value="WALKING">Walking</option>
                    </select>
                </div>
            </div>
            <div class="col-md-offset-4 col-md-8">
                <button type="button" class="btn btn-info btn-lg" onclick="calcRoute();"><i class="fas fa-map-signs"></i> Calculate Route</button>
            </div>
        </form>
    </div>
    <div class="container-fluid">
        <div id="googleMap"></div>
        <div id="output"></div>
    </div>
</div>


    <!-- Load Google Maps API and Initialize the Map -->
    <script>
        var map, directionsService, directionsDisplay, destinationMarker;
        var myLatLng = { lat: 6.364039977799532, lng: 80.40625906382867 };
        var Deniyaya = { lat: 6.342485, lng: 80.559658 }; 

        function initMap() {
            var mapOptions = {
                center: myLatLng,
                zoom: 9,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
            directionsService = new google.maps.DirectionsService();
            directionsDisplay = new google.maps.DirectionsRenderer();
            directionsDisplay.setMap(map);

            var options = { types: ['(cities)'] };
            var input1 = document.getElementById("from");
            var autocomplete1 = new google.maps.places.Autocomplete(input1, options);
            var input2 = document.getElementById("to");
            var autocomplete2 = new google.maps.places.Autocomplete(input2, options);

            // Set the "From" input to the city name from the URL
            var params = new URLSearchParams(window.location.search);
            var city = params.get('city');
            if (city) {
                input2.value = city;
                var data = document.getElementById("output");
                data.innerHTML = city;
            }

            // Create a marker for the destination
            destinationMarker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE, // Red circle
                    fillColor: 'red',
                    fillOpacity: 0.6,
                    strokeWeight: 0, // No border
                    scale: 15 // Adjust the size as necessary
                }
            });

            // New Edit: Add geocoding to set the marker's position based on the city name and update URL
            function setDestinationMarker(cityCoordinates) {
                var cityLatLng = new google.maps.LatLng(cityCoordinates.lat, cityCoordinates.lng);

                if (!destinationMarker) {
                    destinationMarker = new google.maps.Marker({
                        position: cityLatLng,
                        map: map,
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE, // Blue circle
                            fillColor: 'blue',
                            fillOpacity: 0.6,
                            strokeWeight: 0, // No border
                            scale: 15 // Adjust the size as necessary
                        }
                    });
                } else {
                    destinationMarker.setPosition(cityLatLng);
                }
            }

            // URL city coordinates
            var cityCoordinates = {
                "Deniyaya": { lat: 6.342485, lng: 80.559658 },
                "Yala National Park": { lat: 6.280029, lng: 81.402006 }
            };



            // Parse city name from URL
            var urlParams = new URLSearchParams(window.location.search);
            var cityName = urlParams.get('city');

            // Check if city name exists in the URL
            if (cityName && cityCoordinates[cityName]) {
                // Set destination marker based on city coordinates
                setDestinationMarker(cityCoordinates[cityName]);

                // Create a marker for the origin
                var originMarker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE, // Blue circle
                        fillColor: 'blue',
                        fillOpacity: 0.6,
                        strokeWeight: 0, // No border
                        scale: 15 // Adjust the size as necessary
                    }
                });
            } else {
                alert('City coordinates not found in URL.');
            }
        }

        function calcRoute() {
            var travelModeSelected = document.getElementById("mode").value;
            var request = {
                origin: document.getElementById("from").value,
                destination: document.getElementById("to").value,
                travelMode: travelModeSelected === "BICYCLING" ? google.maps.TravelMode.BICYCLING : google.maps.TravelMode[travelModeSelected],
                unitSystem: google.maps.UnitSystem.IMPERIAL
            };

            directionsService.route(request, function (result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    // Set polyline options based on travel mode
                    var polylineOptions = {
                        strokeColor: 'blue',
                        strokeOpacity: 0.8,
                        strokeWeight: 2
                    };

                    if (travelModeSelected === "WALKING") {
                        polylineOptions = {
                            strokeColor: 'blue',
                            strokeOpacity: 0,
                            strokeWeight: 2,
                            icons: [{
                                icon: {
                                    path: google.maps.SymbolPath.CIRCLE,
                                    fillOpacity: 1,
                                    scale: 3
                                },
                                offset: '0',
                                repeat: '10px'
                            }]
                        };
                    }

                    directionsDisplay.setOptions({
                        polylineOptions: polylineOptions
                    });

                    directionsDisplay.setDirections(result);

                    const output = document.querySelector('#output');
                    output.innerHTML = "<div class='alert-info'>From: " + document.getElementById("from").value + ".<br />To: " + document.getElementById("to").value + ".<br /> " + travelModeSelected + " distance <i class='fas fa-road'></i> : " + result.routes[0].legs[0].distance.text + ".<br />Duration <i class='fas fa-hourglass-start'></i> : " + result.routes[0].legs[0].duration.text + ".</div>";
                } else {
                    // Handle no route found
                    directionsDisplay.setDirections({ routes: [] });
                    map.setCenter(myLatLng);
                    const output = document.querySelector('#output');
                    output.innerHTML = "<div class='alert-danger'><i class='fas fa-exclamation-triangle'></i> Could not retrieve driving distance.</div>";
                }
            });
        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHZJjA4WH--aPUGgf3nLc5HSAUBzhrdY4&callback=initMap&libraries=places&v=weekly" async defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHZJjA4WH--aPUGgf3nLc5HSAUBzhrdY4&callback=initMap&libraries=&v=weekly" async></script>
</body>
</html>
