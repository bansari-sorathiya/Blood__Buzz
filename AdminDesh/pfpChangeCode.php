<?php 
include './redirect.php';
try
{
    include '../Include/connect2.php';
    if(isset($_POST['upload']))
    {
        $email=$_SESSION['email'];
        
        if((isset($_FILES['img']['name'])) && (!empty($_FILES['img']['name'])))
        {
            $img=$_FILES['img']['name'];
            $tmp=$_FILES['img']['tmp_name'];
            $change_pic=$connection->prepare("UPDATE admin_login SET img=? WHERE email=?");
            $change_pic->execute([$img,$email]);
            if($change_pic->rowCount()>0)
            {
                move_uploaded_file($tmp, "../img/".$img);
            }
        }
        else
        {
            $_SESSION['profile-error-message'] = "Please Select Image";
        }
    }

    elseif(isset($_POST['remove']))
    {
        $email=$_SESSION['email'];
        $remove_pic=$connection->prepare("UPDATE admin_login SET img=NULL WHERE email=?");
        $remove_pic->execute([$email]);
        if($remove_pic->rowCount() > 0)
        {
            header("location:update_profile.php");
        }
        else
        {
            echo $error;
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