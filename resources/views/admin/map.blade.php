@extends('admin.layout.master')
@section('content')
    <div class="admin_main">
        <div class="admin_main_inner">
            <div class="admin_panel_data height_adjust">
                <div class="row area-slot-management justify-content-center">
                    <div class="col-12">
                        <div class="row mx-0">
                            <div class="col-12 design_outter_comman shadow">
                                <div class="row">
                                    <div class="col-12 px-0 comman_tabs">
                                      <div id="map" style="width:100%;height:500px;">

                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMN2qx9sNSiaYyJkSFb6vSRI83oLHPIkg&libraries=places&callback=initMap">
    </script>
    <script>
         var map;
var marker;
        function initMap() {
            // Initialize the map
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
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

@endsection
