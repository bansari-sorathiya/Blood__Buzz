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
                    echo"<script>alert('Check password')</script>";
                }
                else
                {
                    $reset_password="UPDATE members SET pwd='$new_pwd' WHERE email='$email' AND verify_token='$token'";
                    $reset_password_run=mysqli_query($connection,$reset_password);
                    if($reset_password_run)
                    {
                       //sweetalert
                        header("location:index.php");
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
    <meta charset="utf-8">
    <title>ADMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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
</head>

<body>
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
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMIN</h3>
                            </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <h3>Reset Your Password</h3>
                        </div>
                        <form action="" method="post" autocomplete="off">
                            <input type="hidden" id="action" value="<?php echo $_REQUEST['token']; ?>">
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" name="new_pwd" placeholder="Enter New Password">
                            <label for="floatingPassword">Enter New Password</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" name="confirm_pwd" placeholder="Enter Confirm Password">
                            <label for="floatingPassword">Enter Confirm Password</label>
                        </div>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4" id="submit" name="reset">Change Password</button>
                        <!-- <input type="submit" value="Change Password" class="btn" id="submit" name="reset"> -->
                    </div>
                </div>
            </div>
        </div>
        </form>
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
</body>

</html>