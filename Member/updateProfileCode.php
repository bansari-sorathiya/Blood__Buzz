<?php
ob_start();
include './redirect.php';


try
{
    include '../Include/connect2.php';

    if(isset($_POST['updateProfile']))
    {
        if(empty($_POST['city']) && ($_POST['city'])==null)
        {
            $_SESSION['state-error-message']="Kindly Select State and City again";
        }
        else
        {
            $session_email=$_SESSION['member_email'];
            $fname=$_POST['fname'];
            $lname=$_POST['lname'];
            $fullname=$fname." ".$lname;
            $cno=$_POST['cno'];
            $gen=$_POST['gen'];
            $email=$_POST['email'];
            $dob=$_POST['dob'];
            $add=$_POST['add'];
            $state=$_POST['state'];
            $city=$_REQUEST['city'];
            $pin=$_POST['pin'];
            // echo $fname.$lname.$cno.$gen.$email.$dob.$add.$state.$city.$pin;

            $update=$connection->prepare("UPDATE members SET name=?,contact_no=?,gender=?,email=?,dob=?,address=?,state=?,city=?,pincode=? WHERE email=?");
            $update->execute([$fullname,$cno,$gen,$email,$dob,$add,$state,$city,$pin,$session_email]);
            if($update->rowCount() > 0)
            {
                $_SESSION['member_email']=$email;
                $_SESSION['profile-message'] = "Profile Updated Successfully.";
            }
            else
            {
                $_SESSION['profile-error-message'] = "Something Went Wrong";
                // echo"Something Went Wrong";
            }
        }
    }
}
catch (PDOException $e) 
{
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['profile-error-message'] = "Database error: " . $error;
}
header("location:update.php");
?>