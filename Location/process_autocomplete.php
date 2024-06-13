<?php
// Replace with your API key
$api_key = "AIzaSyBRQLQEDxc7SYhmET8csxmx3LUBiYnSnas";

if (isset($_GET["place_id"])) {
    $place_id = $_GET["place_id"];
    $details_url = "https://maps.googleapis.com/maps/api/place/details/json?placeid=$place_id&key=$api_key";
    $response = file_get_contents($details_url);
    $data = json_decode($response, true);

    // Process the data as needed (e.g., extract location details)

    // Example: Get the formatted address
    $formatted_address = $data["result"]["formatted_address"];

    // Return the data (e.g., formatted address) back to the frontend
    echo "<p>Formatted Address: $formatted_address</p>";
}
?>