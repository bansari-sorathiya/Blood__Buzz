<!-- <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Location Picker</title>
<style>
  #map {
    height: 400px;
    width: 100%;
  }
</style>
</head>
<body>
<h1>Location Picker</h1>
<input type="text" id="locationInput" placeholder="Enter a location">
<div id="map"></div>
<div id="latlongDisplay"></div>

<script>
let map;
let marker;
let autocomplete;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 20.5937, lng: 78.9629 }, // Default center (India)
    zoom: 5,
  });

  marker = new google.maps.Marker({
    map: map,
    draggable: true,
  });

  autocomplete = new google.maps.places.Autocomplete(document.getElementById("locationInput"));

  autocomplete.addListener("place_changed", function () {
    let place = autocomplete.getPlace();
    if (!place.geometry) {
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }

    marker.setPosition(place.geometry.location);
    updateLatLng(place.geometry.location.lat(), place.geometry.location.lng());
  });

  google.maps.event.addListener(marker, "dragend", function () {
    updateLatLng(marker.getPosition().lat(), marker.getPosition().lng());
  });

  google.maps.event.addListener(map, "click", function (event) {
    marker.setPosition(event.latLng);
    updateLatLng(event.latLng.lat(), event.latLng.lng());
  });

  // Listen for keyup event on the input for real-time updates
  document.getElementById("locationInput").addEventListener("keyup", function () {
    let inputText = this.value.trim();
    if (inputText !== '') {
      geocodeAddress(inputText);
    }
  });
}

function updateLatLng(latitude, longitude) {
  document.getElementById("latlongDisplay").innerHTML = `Latitude: ${latitude}<br>Longitude: ${longitude}`;
}

function geocodeAddress(address) {
  let geocoder = new google.maps.Geocoder();
  geocoder.geocode({ address: address }, function (results, status) {
    if (status === "OK" && results[0]) {
      let location = results[0].geometry.location;
      map.setCenter(location);
      map.setZoom(17);
      marker.setPosition(location);
      updateLatLng(location.lat(), location.lng());
    } else {
      window.alert("Geocode was not successful for the following reason: " + status);
    }
  });
}
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRQLQEDxc7SYhmET8csxmx3LUBiYnSnas&libraries=places&callback=initMap"></script>
</body>
</html> -->

<!DOCTYPE html>
<html>

<head>
  <title>Google Places Autocomplete</title>
</head>

<body>
  <h1>Google Places Autocomplete</h1>
  <input type="text" id="place-input" placeholder="Enter a location">
  <div id="results"></div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRQLQEDxc7SYhmET8csxmx3LUBiYnSnas&libraries=places"></script>
  <script>
    function initialize() {
      var input = document.getElementById('place-input');
      var autocomplete = new google.maps.places.Autocomplete(input);

      autocomplete.addListener('place_changedb', function () {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
          return;
        }

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            var resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = this.responseText;
          }
        };

        xhr.open("GET", "process_autocomplete.php?place_id=" + place.place_id, true);
        xhr.send();
      });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
  </script>
</body>

</html>
