
<?php 
session_start();
ob_start();
// include './header2.php';


try 
{
    include(__DIR__."/../include/connect.php");
    //login validation
if((isset($_REQUEST['login'])))
{
	$email=mysqli_real_escape_string($connection,$_REQUEST['email']);
	$pwd=mysqli_real_escape_string($connection,$_REQUEST['pwd']);
	$updated_token=md5(rand());
	
    //remember me
    if(isset($_REQUEST['remember']))
    {
        $expiration = time() + (86400 * 1); // Cookie will expire in 1 days
        $path = "/"; // Cookie is available across the entire domain
        $domain =""; // Cookie is available on all subdomains
        setcookie("email", $email, $expiration, $path, $domain);
        setcookie("pwd", $pwd, $expiration, $path, $domain);
    }

	//first check whether user exists or not.
	$check_email="SELECT email,pwd FROM members WHERE email='$email' AND pwd='$pwd' AND member_status='1'";
	$res=mysqli_query($connection,$check_email);
	if(mysqli_num_rows($res)>0)
   {	
		//if user found than update the token
		$update_token="UPDATE members SET verify_token='$updated_token' WHERE email='$email' AND pwd='$pwd'";
		$update_token_run=mysqli_query($connection,$update_token);
		if($update_token_run)
		{
				$_SESSION['member_email']=$email;
				// header("location:index.php");
                $_SESSION['login-message']="Login Successfully";
		}
		else
		{
         $_SESSION['login-error-message']="Database error".$e;
		}
		
   }
      else
      {
        $_SESSION['login-error-message']="Please Enter Valid Id or Password";
         //sweet alert
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


<title>Blood Buzz-login page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="../img/logo.png" type="image/x-icon" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../File/css/bootstrap.min.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="../File/jquery.js"></script>
<style type="text/css">
body
{
    margin-top:20px;
    background-color:#eee;
}
.social-btn {
    display: inline-block;
    width: 2.25rem;
    height: 2.25rem;
    -webkit-transition: border-color 0.25s ease-in-out,background-color 0.25s ease-in-out,color 0.25s ease-in-out;
    transition: border-color 0.25s ease-in-out,background-color 0.25s ease-in-out,color 0.25s ease-in-out;
    border: 1px solid #e7e7e7;
    border-radius: 50%;
    background-color: #fff;
    color: #545454;
    text-align: center;
    text-decoration: none;
    line-height: 2.125rem;
    vertical-align: middle;
}
.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + 1rem + 2px);
    padding: .5rem 1rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #404040;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #e1e1e1;
    border-radius: 0;
    -webkit-transition: border-color 0.2s ease-in-out,-webkit-box-shadow 0.2s ease-in-out;
    transition: border-color 0.2s ease-in-out,-webkit-box-shadow 0.2s ease-in-out;
    transition: border-color 0.2s ease-in-out,box-shadow 0.2s ease-in-out;
    transition: border-color 0.2s ease-in-out,box-shadow 0.2s ease-in-out,-webkit-box-shadow 0.2s ease-in-out;
}
.input-group>.form-control, .input-group>.form-control-plaintext, .input-group>.custom-select, .input-group>.custom-file {
    position: relative;
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    width: 1%;
    margin-bottom: 0;
}
.input-group-text {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    padding: .5rem 1rem;
    margin-bottom: 0;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #404040;
    text-align: center;
    white-space: nowrap;
    background-color: #fff;
    border: 1px solid #e1e1e1;
}
    </style>
    
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

elseif(isset($_SESSION['login-message'])) {
    echo "<script>
            swal({
              icon: 'success',
              title: 'Valid User',
              text: '{$_SESSION['login-message']}',
              timer: 2000,
              showConfirmButton: false
            }).then(function() {
                window.location.href = 'index.php';
            });
          </script>";
    unset($_SESSION['login-message']);
}
?>




<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container pb-5 mb-sm-4" style="margin-left:775px;">
<div class="row pt-5">
<div class="col-md-6 pt-sm-3">
<div class="card">
<div class="card-body">
<h2 class="h4 mb-1">Log in</h2>
<div class="d-sm-flex align-items-center py-3">
<!-- <h3 class="h6 font-weight-semibold opacity-70 mb-3 mb-sm-2 mr-sm-3">With social account:</h3> -->
<div>
<!-- <a class="social-btn sb-facebook mr-3 mb-0 pt-2" href="#" data-toggle="tooltip" title data-original-title="Sign in with Facebook">
<i class="fa fa-facebook"></i>
</a>
<a class="social-btn sb-twitter mr-2 mb-0 pt-2" href="#" data-toggle="tooltip" title data-original-title="Sign in with Twitter">
<i class="fa fa-twitter"></i>
</a>
<a class="social-btn sb-linkedin mr-2 mb-0 pt-2" href="#" data-toggle="tooltip" title data-original-title="Sign in with LinkedIn">
<i class="fa fa-linkedin"></i>
</a> -->
</div>
</div>
<hr>
<!-- <h3 class="h6 font-weight-semibold opacity-70 pt-4 pb-2">Or using form below</h3> -->
<form method="POST" autocomplete="off">
<div class="input-group form-group">
<div class="input-group-prepend"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></span></div>
<input class="form-control" type="email" name="email" id="email" maxlength="50" placeholder="Email" required 
        value="<?php
                if(!empty($_REQUEST['pwd'])){
                if(isset($_REQUEST['login'])){
                echo"$email";}
               }
               //for cookie
               elseif(isset($_COOKIE['email']))
               { 
                $cemail=$_COOKIE['email'];
                echo $cemail;
                } ?>">
<!-- <div class="invalid-feedback" id="invalid-feedback"></div> -->
</div>
<div class="input-group form-group">
<div class="input-group-prepend"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></span></div>
<input class="form-control" type="password" name="pwd" id="pwd" maxlength="20" placeholder="Password" required 
        value="<?php
                if(isset($_COOKIE['pwd']))
                { 
                 $cpwd=$_COOKIE['pwd'];
                 echo $cpwd;
                }
                ?>">
<!-- <div class="invalid-feedback" id="invalid-feedback"></div> -->
</div>
<div class="d-flex flex-wrap justify-content-between">
<div class="custom-control custom-checkbox">
<input class="custom-control-input" type="checkbox" name="remember"  id="remember_me">
<label class="custom-control-label" for="remember_me">Remember me</label>
</div>
<a class="nav-link-inline font-size-sm" href="forgot_pwd.php">Forgot password?</a>
</div>
<hr class="mt-4">
<div class="text-right pt-4">
<button class="btn btn-danger" style="width:500px;height:45px;" type="submit" id="submit" name="login">Log In</button>
<br><br>
<center>
Not a member ?&nbsp;<a class="nav-link-inline font-size-lg" href="./signup.php">Sign Up</a>
</center>
</div>

</form>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	
</script>


</body>
</html>
<?php include './footer.php'; ?>