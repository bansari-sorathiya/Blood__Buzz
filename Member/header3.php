<?php 
// session_start();
ob_start();
include(__DIR__."/../include/connect.php");
if(isset($_SESSION['member_email'])){
$email = $_SESSION['member_email'];
$get_email="SELECT name FROM members WHERE email='$email'";
$get_email_run=mysqli_query($connection,$get_email);
$user=mysqli_fetch_array($get_email_run);
}
?>

<script src="../File/js/bootstrap.min.js"></script>
<!-- //for icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .nav-item
    {
        padding-left:20px;
        font-weight:bold;
        padding:15px;
    }
    a:hover
    {
        color:darkred;
    }
    .dropdown
    {
        margin-top:13px;
    }
</style>
<nav class="navbar navbar-expand-xxl navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand fw-bold" href="#" style="font-size:large;color:darkred">
    <img src="../img/logo.png" width="36" height="40" class="d-inline-block align-top" alt="logo">
    Blood Buzz</a>        
    <button
            class="navbar-toggler d-lg-none"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsibleNavId"
            aria-controls="collapsibleNavId"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav me-auto mt-2 mt-lg-0">

                
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="requestBlood.php">Request</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="donate_blood.php">Donate</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="faq.php">FAQs</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contactUs.php">Contact Us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="feedback.php">Feedback</a>
                </li>

                <li>
                      <?php
                    
                    if(isset($_SESSION['member_email']))
                    {
                        echo  " <div class='dropdown' style='margin-left:400px;'>
                    <button class='btn dropdown' type='button' data-bs-toggle='dropdown'
                    aria-expanded='false' style='border: hidden; background-color: #F8F9FA; display: flex;background-color:#fed4d2;border:2px solid #ffa5a1;'>";
                        echo"<i class='fa fa-user-circle me-2' style='font-size:23px;padding:3px;padding-left:7px;font-weight:600;color:red;'></i> 
                        " . $user["name"] . "</button>
                    <ul class='dropdown-menu'>
                        <li><a href='./update_profile.php' class='dropdown-item'>
                        Update Profile</a></li>
                        <li><a class='dropdown-item' href='./logout.php' name='logout'>Logout</a></li>
                    </ul></div>";
                    }
                    else
                    {
                        echo  " <div class='dropdown' style='margin-left:400px;'>
                    <button class='btn dropdown' type='button' data-bs-toggle='dropdown'
                    aria-expanded='false' style='border: hidden; background-color: #F8F9FA; display: flex;background-color:#fed4d2;border:2px solid #ffa5a1;'>";
                        echo"<i class='fa fa-user-circle me-2' style='font-size:23px;padding:3px;padding-left:7px;font-weight:600;color:red;'></i> 
                        </button>
                    <ul class='dropdown-menu'>
                        <li><a href='./login.php' class='dropdown-item'>
                        Log In</a></li>
                        <li><a class='dropdown-item' href='./signup.php' name='logout'>Sign Up</a></li>
                    </ul></div>";
                    }
                    ?> 
                  </li>
            </ul>
        </div>
    </div>
</nav>
