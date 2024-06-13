<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up</title>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRQLQEDxc7SYhmET8csxmx3LUBiYnSnas"></script>
</head>
<body>
<h1>Sign Up</h1>
<div id="map" style="height: 400px;"></div>
<form id="signupForm">
  <label for="latitude">Latitude:</label>
  <input type="text" id="latitude" name="latitude" readonly><br>
  <label for="longitude">Longitude:</label>
  <input type="text" id="longitude" name="longitude" readonly><br>
  <!-- Other signup form fields go here -->
  <input type="submit" value="Sign Up">
</form>

<script>
let map;
let marker;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 20.5937, lng: 78.9629 },
    zoom: 3,
  });

  marker = new google.maps.Marker({
    position: { lat: 20.5937, lng: 78.9629 },
    map: map,
    draggable: true,
  });

  google.maps.event.addListener(marker, "dragend", function () {
    updateLatLng(marker.getPosition().lat(), marker.getPosition().lng());
  });

  google.maps.event.addListener(map, "click", function (event) {
    marker.setPosition(event.latLng);
    updateLatLng(event.latLng.lat(), event.latLng.lng());
  });
}

function updateLatLng(latitude, longitude) {
  document.getElementById("latitude").value = latitude;
  document.getElementById("longitude").value = longitude;
}

document.getElementById("signupForm").addEventListener("submit", function (event) {
  event.preventDefault();
  // Submit the form data with latitude and longitude
  let formData = new FormData(this);
  formData.append("latitude", document.getElementById("latitude").value);
  formData.append("longitude", document.getElementById("longitude").value);
  // Example: sendFormData(formData);
});
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRQLQEDxc7SYhmET8csxmx3LUBiYnSnas&callback=initMap"></script>
</body>
</html>
