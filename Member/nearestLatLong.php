
<?php 
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lat&Long</title>
</head>
<body>
    <script>
        function requestLocation() 
        {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function successCallback(position)
        {
            var lat = position.coords.latitude;
            var long = position.coords.longitude;
            document.cookie="lat="+lat;
            document.cookie="long="+long;
        }


        function handleResponse(response) 
        {
            if (response.status === 'success') {
                console.log(response.message);
            } else {
                console.error('Error:', response.message);
            }
        }

        function errorCallback(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("Location permission denied by user. Please enable location to access this site.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("Request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred while getting user location.");
                    break;
            }
        }

        window.onload = function() {
            requestLocation();
        };
    </script>
</body>
</html>

<?php 
session_start();
ob_end_flush();
?>
<?php
$input_data = file_get_contents('php://input');
$data = json_decode($input_data, true);

try
{
    if (isset($_COOKIE['lat']) && (isset($_COOKIE['long']))) 
    {
        $lat = $_COOKIE['lat'];
        $long = $_COOKIE['long'];
        // echo $lat;
        // echo $long;
    
        if(isset($_SESSION['member_email']))
        {
            include '../Include/connect2.php';
            // fetch user
            $email=$_SESSION['member_email'];
            $fetch_user=$connection->prepare("SELECT member_id FROM members WHERE email=?");
            $fetch_user->execute([$email]);
            $user=$fetch_user->fetch(PDO::FETCH_ASSOC);
            $mid=$user['member_id'];
        
            $fetch_from_latlong=$connection->prepare("SELECT member_id FROM `location` WHERE member_id=?");
            $fetch_from_latlong->execute([$mid]);
            if($fetch_from_latlong->rowCount() > 0)
            {
                $update=$connection->prepare("UPDATE `location` SET lat=?, longe=? WHERE member_id=?");
                $update->execute([$lat,$long,$mid]);
                $elat=base64_encode($lat);
                $elong=base64_encode($long);
                $url="http://localhost/Blood/Member/nReqData.php?mlat=$elat&mlong=$elong";
                header("location:$url");
            }
            else
            {
                $insert=$connection->prepare("INSERT INTO `location` VALUES(null,?,?,?)");
                $insert->execute([$mid,$lat,$long]);
                $elat=base64_encode($lat);
                $elong=base64_encode($long);
                $url="http://localhost/Blood/Member/nReqData.php?mlat=$elat&mlong=$elong";
                header("location:$url");
            }
        }
        else
        {
            $elat=base64_encode($lat);
            $elong=base64_encode($long);
            $url="http://localhost/Blood/Member/nReqData.php?lat=$elat&long=$elong";
            header("location:$url");
        }
    }   
}
catch (PDOException $e) 
    {
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['error-message'] = "Database error: " . $error;
    }
?>

