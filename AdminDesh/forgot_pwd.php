<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Blood Buzz-Reset Password</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../img/logo.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- for sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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

?>


    <form autocomplete="off" action="" method="post">
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4" style="width:500px;">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMIN</h3>
                            </a>
                            <h4>Reset Password</h4>
                        </div>
                        <form autocomplete="off" action="" method="post">
                            <input type="hidden" id="action" value="login">
                        <div class="form-group mb-3">
                            <p>Enter your email address , and we'll send you a link to get back into your account.</p>
                                <label class="label" for="floatingInput">Email address</label>
                                <input type="email" id="email" class="form-control" placeholder="Email" name="email" required>
                            </div>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4" name="reset" id="submit">Send Reset Password Link </button>
                        <!-- <p class="text-center mb-0">Don't have an Account? <a href="">Sign Up</a></p> -->
                        <p class="text-center"><a id="back_to_login"data-toggle="tab" href="index.php" class="sign_up">Back To Login</a></p>
                      </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </form>
</body>

</html>


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
		$mail->setFrom('bansarisorathiya74@example.com', 'Blood Buzz');
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
            <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'><a href='http://localhost/Blood/AdminDesh/password_change.php?token=$token&email=$get_email' style='background-color: #c21807; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Reset Password</a></p>
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
	if(isset($_POST['reset']))
	{
		$email=mysqli_real_escape_string($connection,$_POST['email']);
		$token=md5(rand());
		$check_email="SELECT email FROM admin_login WHERE email='$email' LIMIT 1";
		$check_email_run=mysqli_query($connection,$check_email);

		if(mysqli_num_rows($check_email_run) > 0)
		{
			$row=mysqli_fetch_array($check_email_run);
			$get_email=$row['email'];
			$update_token="UPDATE admin_login SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
			$update_token_run=mysqli_query($connection,$update_token);

			if($update_token_run)
			{
				send_password_reset($get_email,$token);
				header("location:mailSent.php"); 
			}
				else
				{
					$_SESSION['reset-error-message']="Token Not Updated";
					//   header("location:index.php");
					exit(0);
				}
		}
		else
		{
			$_SESSION['reset-error-message']="No Email Found !";
			//   header("location:index.php");
			//   exit(0);
		}
	}
}
catch (PDOException $e) 
   {
      // Handle query errors
      $error=$e->getMessage();
      $_SESSION['reset-error-message'] = "Database error: " . $error;
   }
?>