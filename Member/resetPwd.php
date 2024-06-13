<?php
session_start();
ob_start();
// include(__DIR__."/../include/connect.php");
include '../include/connect.php';



if(isset($_REQUEST['token'])==null)
{
    header("location:index.php");
    exit(0);
}
else
{
    if(isset($_REQUEST['reset']))
    {
        $email=mysqli_real_escape_string($connection,$_REQUEST['email']);
        $new_pwd=mysqli_real_escape_string($connection,$_POST['new_pwd']);
        $confirm_pwd=mysqli_real_escape_string($connection,$_POST['confirm_pwd']);
        $token=mysqli_real_escape_string($connection,$_REQUEST['token']);
        if(!empty($_REQUEST['token']))
        {
            if((!empty($_POST['new_pwd'])) && (!empty($_POST['confirm_pwd'])))
            {
                if($new_pwd!==$confirm_pwd)
                {
                    //sweetalert
                    $_SESSION['reset-error-message']="Confirm Password Should Match";
                }
                else
                {
                    $reset_password="UPDATE members SET pwd='$new_pwd' WHERE email='$email' AND verify_token='$token'";
                    $reset_password_run=mysqli_query($connection,$reset_password);
                    if($reset_password_run)
                    {
                       //sweetalert
                       $_SESSION['reset-message']="Password Changed Successfully";
                        // header("location:index.php");
                    }
                    else
                    {
                        header("location:new.php");
                        echo"something went wrong".mysqli_error($connection);
                    }
                }
            }
        }
    }
}//else



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Blood Buzz-Reset Password</title>
   <link rel="icon" href="../img/logo.png" type="image/x-icon" />
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../../ecom/css/style.css">

   <script src="../File/js/bootstrap.min.js"></script>

   <!-- for sweetalert -->
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <style>
      #submit
      {
         background-color:red;
         color:white;
         font-size:large;
      }
      #submit:hover
      {
         background-color:white;
         color:red;
         font-weight:bold;
         border:1px solid black;
         font-size:large;
      }
      
   </style>
</head>
<body>
<?php

if(isset($_SESSION['reset-error-message'])) {
    echo "<script>
            swal({
              icon: 'error',
              title: 'Error',
              text: '{$_SESSION['reset-error-message']}'
            });
          </script>";
    unset($_SESSION['reset-error-message']);
}

elseif(isset($_SESSION['reset-message'])) {
    echo "<script>
            swal({
              icon: 'success',
              title: 'Success',
              text: '{$_SESSION['reset-message']}',
              timer: 2000,
              showConfirmButton: false
            }).then(function() {
                window.location.href = './login.php';
            });
          </script>";
    unset($_SESSION['reset-message']);
}

?>
<section class="form-container" style="margin-top:175px;">

   <form action="" method="post" autocomplete="off">
   <input type="hidden" id="action" value="<?php echo $_REQUEST['token']; ?>">
      <h3>Reset Your Password</h3>
      <input type="password" name="new_pwd" placeholder="Enter New Password" maxlength="20"  class="box">
      <input type="password" name="confirm_pwd" placeholder="Enter Confirm Password" maxlength="20"  class="box">
      <input type="submit" value="Change Password" class="btn" id="submit" name="reset">
      </form>
</section>

