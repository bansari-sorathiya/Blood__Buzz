<?php
include './redirect.php';

if(isset($_REQUEST['cid']))
{
    $cid=$_REQUEST['cid'];
    date_default_timezone_set('Asia/Kolkata');
    $datetime=date('Y/m/d h:i:s');
    try
    {
        include '../Include/connect2.php';
        //delete from contact us
        $update_status=$connection->prepare("UPDATE contact_us SET status=? WHERE contactus_id=?");
        $update_status->execute(['0',$cid]);
        
    }
    catch (PDOException $e) 
    {
        // Handle query errors
        $error=$e->getMessage();
        $_SESSION['error-message'] = "Database error: " . $error;
    }
    header("Location:seeContactUs.php");
}


?>