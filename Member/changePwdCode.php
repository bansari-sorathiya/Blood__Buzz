<?php
include './redirect.php';

try
{
    include '../Include/connect2.php';
    if(isset($_POST['changepwd']))
    {
        $session_email=$_SESSION['member_email'];
        $old_pwd=$_POST['old_pwd'];
        $new_pwd=$_POST['new_pwd'];
        $cfm_pwd=$_POST['cfm_pwd'];
        // echo $email.$old_pwd.$new_pwd.$cfm_pwd;

        //get password from database
        $get_old_pwd=$connection->prepare("SELECT pwd FROM members WHERE email=?");
        $get_old_pwd->execute([$session_email]);
        $row=$get_old_pwd->fetch(PDO::FETCH_ASSOC);
        $db_old_pwd=$row['pwd'];

        if($old_pwd==$db_old_pwd)
        {
            if($new_pwd==$cfm_pwd)
            {
              $update_pwd=$connection->prepare("UPDATE members SET pwd=? WHERE email=?");
              $update_pwd->execute([$new_pwd,$session_email]);
              if($update_pwd->rowCount() > 0)
              {
                $_SESSION['pwd-message'] = "Password Changed Successfully ";
              } 
              else
              {
                $_SESSION['pwd-error-message'] = "Database error: " . $error;
              } 
            }
            else
            {
                $_SESSION['pwd-error-message'] = "Confirm Password Should Match"; 
            }
        }
        else
        {
            $_SESSION['pwd-error-message'] = "Enter Correct Old Password"; 
        }

    }
}
catch (PDOException $e) 
{
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['pwd-error-message'] = "Database error: " . $error;
}
header("location:./changePwd.php");

?>