<?php
$mapa = htmlentities($_GET['mapa']);
$address = urlencode($mapa);
$url = "https://maps.google.com/maps/api/geocode/json?sensor=true&address=".$address;
$response = file_get_contents($url);
$json = json_decode($response,true);
$lat = $json['results'][0]['geometry']['location']['lat'];
$lng = $json['results'][0]['geometry']['location']['lng'];
/*echo $lat;
echo "<br>";
echo $lng;*/
 ?>

<!DOCTYPE html>
<html>
  <head>
  <style media="screen">
    html, body{
      height: 100%;
      margin:  0;
      padding: 0;
    }
    #map{
      height: 100%;
    }
  </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      function initMap() {
        var myLatLng = {lat: <?php echo $lat?>, lng: <?php echo $lng ?>};
        //  var myLatLng = {lat:22.174423, lng: -102.5128187};


        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('map'), {
          center: myLatLng,
          zoom: 18
        });

        // Create a marker and set its position.
        var marker = new google.maps.Marker({
          map: map,
          position: myLatLng,
          title: 'Hello World!'
        });
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuqo8z3gp-uUgQfPz6Z9F52l7csXGCxME&callback=initMap"
        async defer></script>
  </body>
</html>
