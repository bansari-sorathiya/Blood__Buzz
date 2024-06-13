<?php
ob_start();
session_start();
// include(__DIR__."/../include/connect.php");
include '../Include/connect2.php';

//recover password
if(isset($_REQUEST['reset']))
{
	header("location:forgot_pwd.php");
}

//login validation
try
{
	if((isset($_REQUEST['login'])) && (!empty($_REQUEST['pwd'])) && (!empty($_REQUEST['email'])))
	{
		$email=$_POST['email'];
		$pwd=$_POST['pwd'];
		$updated_token=md5(rand());
		
		//first check whether user exists or not.

		$check_email=$connection->prepare("SELECT * FROM admin_login WHERE email=? AND pwd=?");
		$check_email->execute([$email,$pwd]);
		
		if($check_email->rowCount()>0)
		{
			//if user found than update the token

			$update_token=$connection->prepare("UPDATE admin_login SET verify_token=? WHERE email=?");
			$update_token->execute([$updated_token,$email]);
			
			if($update_token->rowCount() > 0)
			{
			//if token is updated than maintain login history.

				$get_login_id=$connection->prepare("SELECT login_id FROM admin_login WHERE email=?");
				$get_login_id->execute([$email]);
				if($get_login_id->rowCount() > 0)
				{
					$fetch=$get_login_id->fetchALL(PDO::FETCH_ASSOC);
					foreach($fetch as $row){}

					$login_id=$row['login_id'];
					$host_address=$_SERVER['SERVER_ADDR'];
					$host_name=$_SERVER['SERVER_NAME'];
					date_default_timezone_set('Asia/Kolkata');
					$datetime=date('Y/m/d h:i:s');
					// echo $datetime;

					//update login history

					$history=$connection->prepare("INSERT INTO login_history VALUES(null,?,?,?,?)");
					$history->execute([$login_id,$host_address,$host_name,$datetime]);
					

					if($history->rowCount() > 0)
					{
						$_SESSION['email']=$_POST['email'];

							$oneMonthAgo = date('Y-m-d', strtotime('-1 month'));
							// echo $oneMonthAgo;
							// Prepare and execute the SQL query to select records older than one month
							$deleteMonth = $connection->prepare("SELECT history_id FROM login_history WHERE created_at < ?");
							$deleteMonth->execute([$oneMonthAgo]);

							// Fetch the results and store them in a variable
							$olderThanOneMonth = $deleteMonth->fetchAll(PDO::FETCH_ASSOC);

							// Output the results
							foreach ($olderThanOneMonth as $row) {
								// echo "History ID: " . $row['history_id'] . "<br>";
							}
							if($row['history_id'])
							{
							$deleteIt=$connection->prepare("DELETE FROM login_history WHERE history_id=?");
							$deleteIt->execute([$row['history_id']]);
							}

						header("location:dashboard.php");
						
					}
					else
                    {
                        $_SESSION['login-error-message'] = "Login History Not Inserted...! ";
						// echo"";
					}

				}
				else
				{
                    $_SESSION['login-error-message'] = "Failed to get login Id!";
					// echo"<script>alert('Invalid User....! OR Check Password')</script>";
				}

			}
			else
			{
				header("location:index.php");
			}
			
		}
		else
		{
            $_SESSION['login-error-message'] = "Invalid User....! OR Check Password ";
		}
	}

    
}
catch (PDOException $e) 
{
	// Handle query errors
	$error=$e->getMessage();
	$_SESSION['login-error-message'] = "Database error: " . $error;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Blood Buzz-Admin Log In</title>
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
if(isset($_SESSION['login-error-message'])) {
    echo "<script>
            swal({
              icon: 'error',
              title: 'Error',
              text: '{$_SESSION['login-error-message']}'
            });
          </script>";
    unset($_SESSION['login-error-message']);
}
?>

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
                            <a href="#" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMIN</h3>
                            </a>
                            <h3>Sign In</h3>
                        </div>

                        <form autocomplete="off" action="" method="post">
                            <input type="hidden" id="action" value="login">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email"
                            value="<?php
							if(!empty($_REQUEST['pwd'])){
                			if(isset($_REQUEST['login'])){
                			echo"$email";}
							 } ?>">
                            <label for="floatingInput">Email address</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" name="pwd" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <!-- <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" name="remember" for="exampleCheck1">Remember Me</label>
                            </div> -->
                            <a href="forgot_pwd.php">Forgot Password</a>
                            <!-- <p class="text-center"><input type="submit" value="Forgot Password ?" name="reset" id="recover" data-toggle="tab">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->

                        </div>
                        <button type="submit" name="login" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                        <!-- <p class="text-center mb-0">Don't have an Account? <a href="">Sign Up</a></p> -->
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