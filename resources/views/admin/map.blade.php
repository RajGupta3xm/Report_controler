<!DOCTYPE html>
<html>
<head>
    <title>Map</title>
    <style>
        #map {
            height: 100%;
        }
    </style>
</head>
<body>
<div class="container">
<div id="map" style="width:100%;height:500px;">

</div>

    <script>
         var map;
var marker;
        function initMap() {
            // Initialize the map
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: {lat: 20.5937, lng: 78.9629}
            });

            @foreach ($drivers as $driver)
            var marker = new google.maps.Marker({
                position: {lat: {{ $driver->latitude }}, lng: {{ $driver->longitude }}},
                map: map,
                title:  '{{ $driver->name }}'
             }); 
             @endforeach

           
        }
    </script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMN2qx9sNSiaYyJkSFb6vSRI83oLHPIkg&libraries=places&callback=initMap">
    </script>
</body>
</html>
