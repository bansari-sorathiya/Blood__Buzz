
<?php 
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="../img/logo.png" type="image/x-icon" />
   <title>Blood Buzz-forgot password</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../../ecom/css/style.css">

   <script src="../File/js/bootstrap.min.js"></script>
   <!-- <link rel="stylesheet" href="../File/css/bootstrap.min.css"> -->

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
      #back_to_login
      {
         font-size:large;
      }
      #back_to_login:hover
      {
         font-size:large;
         cursor: pointer;
         font-weight:bold;
      }
      p
      {
			font-size:20px;
            text-align:justify;
            text-justify:inter-word;
      }
      
   </style>
</head>

<body>

<?php
if(isset($_SESSION['error-message'])) {
    echo "<script>
            swal({
              icon: 'error',
              title: 'Error',
              text: '{$_SESSION['error-message']}'
            });
          </script>";
    unset($_SESSION['error-message']);
}
?>


<section class="form-container" id="form" style="margin-top:160px;width:600px;" autocomplete="off">

   <form action="" method="post">
   <input type="hidden" id="action" value="">
      <h3>Reset Password</h3><br>
      <p>Enter your email address, and we'll send you a link to get back into your account.</p><br>
      <input type="email" name="email" required placeholder="Enter Email Address" maxlength="50"  class="box">
      <input type="submit" value="send password link" class="btn" id="submit" name="forgot"><br><br>
      <a href="login.php" id="back_to_login">Back To Login</a>
   </form>
</section>


<?php
include '../Include/connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';


function send_password_reset($get_email,$token)
	{
		$mail = new PHPMailer(true);
		//Server settings
		// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->SMTPAuth   = true;  

		$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		//Enable SMTP authentication
		$mail->Username   = 'bansarisorathiya74@gmail.com';                     //SMTP username
		$mail->Password   = "ckll maic lavq gyva";                               //SMTP password

		// $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		$mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
		$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	
		//Recipients
		$mail->setFrom('bansarisorathiya74@gmail.com', 'Blood Buzz');
		$mail->addAddress($get_email);     //Add a recipient

		$mail->isHTML(true);    
		$mail->Subject = 'Reset Your Password';

		$email_template = "
      <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; font-family: Arial, sans-serif;'>
      <div style='text-align: center; margin-bottom: 20px;'>
          <img src='https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcStdj407c7vChyBW5_cHOgdZO6dK3vtp7s6KFeTDXRHfFkgSP_i' alt='Blood Buzz Logo' style='width: 100px; height: 80px;'>
      </div>
      <h1 style='text-align: center; color: #c21807; font-size: 28px; font-weight: bold; margin-bottom: 20px;'>Blood Buzz</h1>
      <h2 style='font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px;'>Reset Password</h2>
      <hr style='border: 1px solid #ccc; margin-bottom: 20px;' />
      <div style='margin-top: 20px; text-align: justify;'>
          <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>Dear $name,</p>
          <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>You can reset your Blood Buzz password by clicking the link below:</p>
          <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'><a href='http://localhost/Blood/Member/resetPwd.php?token=$token&email=$get_email' style='background-color: #c21807; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Reset Password</a></p>
          <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>If you didn't request this, please ignore this email.</p>
          <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>Thank you,</p>
          <p style='font-size: 16px; line-height: 1.5; margin-bottom: 0;'>Blood Buzz Team</p>
      </div>
  </div>
";



    	$mail->Body= $email_template;
		$mail->send();
	}
try
{
   if(isset($_POST['forgot'])){
     $email=mysqli_real_escape_string($connection,$_POST['email']);
     $token=md5(rand());
     $check_email="SELECT email FROM members WHERE email='$email' LIMIT 1";
     $check_email_run=mysqli_query($connection,$check_email);
  
     if(mysqli_num_rows($check_email_run) > 0)
     {
        $row=mysqli_fetch_array($check_email_run);
        $get_email=$row['email'];
        $update_token="UPDATE members SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
        $update_token_run=mysqli_query($connection,$update_token);
  
        if($update_token_run)
        {
            send_password_reset($get_email,$token);
            header("location:mailSent.php"); 
        }
  
        else
        {
            $_SESSION['error-message']="Token Not Updated";
            //   header("location:index.php");
            exit(0);
        }
     }
     else
     {
        $_SESSION['error-message']="No Email Found !";
      //   header("location:index.php");
      //   exit(0);
     }
  }
}
catch (PDOException $e) 
{
   // Handle query errors
   $error=$e->getMessage();
   $_SESSION['error-message'] = "Database error: " . $error;
}


