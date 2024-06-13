<?php
session_start();
include '../Include/connect2.php';
//===============for x minutes ago================
    //to fetch admin login id
    $email=$_SESSION['email'];
    $get_loginId=$connection->prepare("SELECT login_id FROM admin_login WHERE email=?");
    $get_loginId->execute([$email]);
    $login=$get_loginId->fetch(PDO::FETCH_ASSOC);

    //for last login time
    $last_login_date=$connection->prepare("SELECT MAX(created_at) AS created_at FROM login_history WHERE login_id=?");
    $last_login_date->execute([$login['login_id']]);
    $date=$last_login_date->fetch(PDO::FETCH_ASSOC);
    // print_r($date);
    //X minutes ago
    
    $dateStr = $date['created_at'];
    $lastLoginTime = new DateTime($dateStr,new DateTimeZone('Asia/Kolkata'));
    $currentTime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
    $timeDifference = $currentTime->diff($lastLoginTime);
//    var_dump($timeDifference);
    
    // Format the output based on the time difference
    if ($timeDifference->d > 0) {
        $formattedOutput = $timeDifference->format('%a day(s) ago');
    } elseif ($timeDifference->h > 0) {
        $formattedOutput = $timeDifference->format('%h hour(s) %i minute(s) ago');
    } elseif ($timeDifference->i > 0) {
        $formattedOutput = $timeDifference->format('%i minute(s) ago');
    } else {
        $formattedOutput = 'Just now';
    }
    // Return the formatted output as JSON
$response = ['formattedOutput' => $formattedOutput];
echo json_encode($response);
?>
