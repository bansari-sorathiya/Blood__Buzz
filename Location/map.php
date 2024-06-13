<?php

require_once '../vendor/autoload.php';

use yidas\googleMaps\Client;
use yidas\googleMaps\Geocoding;

// // Example 1: Geocoding (Address to Coordinates)

// Initialize the Google Maps client with your API key
$apiKey = 'AIzaSyBRQLQEDxc7SYhmET8csxmx3LUBiYnSnas';
// $client = new \yidas\googleMaps\Client(['key' => 'AIzaSyBRQLQEDxc7SYhmET8csxmx3LUBiYnSnas']);
// $address = 'Ramkrupa Society Punagam Saroli Road Surat-395010';
// $geocodeResult = Geocoding::geocode($client, $address);
// print_r($geocodeResult);
// if ($geocodeResult['status'] === 'OK' && !empty($geocodeResult['results'])) {
//     $latitude = $geocodeResult['results'][0]['geometry']['location']['lat'];
//     $longitude = $geocodeResult['results'][0]['geometry']['location']['lng'];

//     echo "Geocoding Result: Latitude = $latitude, Longitude = $longitude\n";
// } else {
//     echo "Geocoding failed.\n";
// }


//Example 2: For neaeby location
// Initialize the Google Maps client
$mapsClient = new \yidas\googleMaps\Client(['key' => 'AIzaSyBRQLQEDxc7SYhmET8csxmx3LUBiYnSnas']);
// Get user's address from the database
$userAddress = "ramkrupa society punagam sarli road surat,Gujarat-395010"; // Replace with actual user address

// Geocode the user's address to get its latitude and longitude
$geocodeResponse = $mapsClient->geocode($userAddress);
print_r($geocodeResponse);
$location = $geocodeResponse->first();

if ($location) {
    $latitude = $location->geometry->location->lat;
    $longitude = $location->geometry->location->lng;

    // Search for nearby hospitals
    $placesResponse = $mapsClient->placesNearby(
        ['location' => [$latitude, $longitude], 'type' => 'hospital']
    );

    // Output nearby hospitals
    $results = $placesResponse->results;
    foreach ($results as $result) {
        echo $result->name . ": " . $result->vicinity . "<br>";
    }
} else {
    echo "User address not found.";
}
?>

