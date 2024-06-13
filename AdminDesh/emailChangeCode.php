<?php
include './redirect.php';

try
{

    include '../Include/connect2.php';
    $session_email=$_SESSION['email'];
    // echo $session_email;
    if(isset($_POST['update']))
    {
        $email=trim($_POST['email']);
        // echo $email;
        $update_email=$connection->prepare("UPDATE admin_login SET email=? WHERE email=?");
        $update_email->execute([$email,$session_email]);
        if($update_email->rowCount()>0)
        {
            $_SESSION['email']=$email;
            if($_SESSION['email']==$email)
            {
                $_SESSION['profile-message'] = "Email Changed Successfully";
            }
            else
            {
                $_SESSION['profile-error-message'] = "Session Not Updated";   
            }
        }
        else
        {
            $_SESSION['profile-error-message'] = "Failed To Update Email";   
        }
    }
    
}
catch (PDOException $e) 
{
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['profile-error-message'] = "Database error: " . $error;
}
header("location:updateProfile.php");
?>