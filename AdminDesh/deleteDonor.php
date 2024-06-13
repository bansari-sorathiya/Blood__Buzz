<?php
ob_start();
ob_end_flush();
include './redirect.php';

try
{
    if(isset($_REQUEST['did']))
    {
        $did=base64_decode($_REQUEST['did']);

        include '../Include/connect2.php';
        $update_donation_status=$connection->prepare("UPDATE donors SET donation_status=? WHERE donor_id=?");
        $update_donation_status->execute(['2',$did]);
    }
    }
    catch (PDOException $e) 
    {
        // Handle query errors
        $error=$e->getMessage();
        $_SESSION['error-message'] = "Database error: " . $error;
    }
    header("location:manageDonor.php");

?>