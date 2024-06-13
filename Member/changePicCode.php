<?php

include './redirect.php';

try
{
    include '../Include/connect2.php';
    if(isset($_POST['upload']))
    {
        if(empty($_FILES['img']['name']))
        {
            $_SESSION['profile-error-message']="Kindly Select Photo";
        }
        else
        {
            // echo "hello";
            $email=$_SESSION['member_email'];
            $img=$_FILES['img']['name'];
            $tmp=$_FILES['img']['tmp_name'];

            $change_pic=$connection->prepare("UPDATE members SET img=? WHERE email=?");
            $change_pic->execute([$img,$email]);

            if($change_pic->rowCount() > 0)
            {
                if(move_uploaded_file($tmp, "../img/".$img))
                {
                header("location:update.php");
                exit;
                }
                else
                {
                    $_SESSION['profile-error-message']="Database error".$e;
                }
            }
        }
    }

    elseif(isset($_POST['remove']))
    {
        $email=$_SESSION['member_email'];
        
        $remove_pic=$connection->prepare("UPDATE members SET img=NULL WHERE email=?");
        $remove_pic->execute([$email]);
        if($remove_pic->rowCount() > 0)
        {
            header("Location:update.php");
            exit;
        }
        else
        {
            $_SESSION['profile-error-message']="Database error".$e; 
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