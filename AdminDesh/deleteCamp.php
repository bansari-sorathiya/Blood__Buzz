<?php
ob_start();
$decryptedCid=base64_decode($_REQUEST['cid']);
// echo $decryptedCid;
include '../Include/connect2.php';
try
{
    $updateIt=$connection->prepare("UPDATE camp SET status=? WHERE camp_id=?");
    $updateIt->execute(['0',$decryptedCid]);
}
catch (PDOException $e) 
{
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['error-message'] = "Database error: " . $error;
}
header("location:manageCamp.php");
?>