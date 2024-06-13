<?php 
include './redirect.php';
include '../Include/connect2.php';

try
{
    if(isset($_POST['change']))
    {
        $session_email=$_SESSION['email'];
        $new=trim($_POST['new']);
        $old=trim($_POST['old']);
        $cfm=trim($_POST['cfm']);

        //fetch password
        $fetch_data=$connection->prepare("SELECT * FROM admin_login WHERE email= ?");
        $fetch_data->execute([$session_email]);
        //data from database
        $data=$fetch_data->fetch();
        $pwd=$data['pwd'];


        if($old==$pwd)
        {
            if($new==$cfm)
            {
                $update_pwd=$connection->prepare("UPDATE admin_login SET pwd=? WHERE email=?");
                $update_pwd->execute([$new,$session_email]);
                if($update_pwd->rowCount()>0)
                {
                   $_SESSION['profile-message']="Password Changed Successfully"; 
                }
                else
                {
                    $_SESSION['profile-error-message'] = "Something went wrong";
                }
            }
            else
            {
                $_SESSION['profile-error-message'] = "Confirm Password Should Match";
            }
        }
        else
        {
            $_SESSION['profile-error-message'] = "Please Enter Correct password";
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