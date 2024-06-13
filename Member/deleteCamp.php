<?php
include './redirect.php';
try
{
if(isset($_REQUEST['cid']))
{
    $cid=base64_decode($_REQUEST['cid']);
    include '../Include/connect2.php';
    $delete_camp=$connection->prepare("UPDATE camp SET `status`=? WHERE camp_id=?");
    $delete_camp->execute(['2',$cid]);
}
}
catch (PDOException $e) 
{
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['error-message'] = "Database error: " . $error;
}
header("location:mycamp.php");
?>