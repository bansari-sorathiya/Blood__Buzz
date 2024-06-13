<?php 
session_start();
ob_start();
include(__DIR__."/../include/connect.php");
if(isset($_SESSION['member_email'])){
$email = $_SESSION['member_email'];
$get_email="SELECT name FROM members WHERE email='$email'";
$get_email_run=mysqli_query($connection,$get_email);
$user=mysqli_fetch_array($get_email_run);
}
?>

<!-- <!DOCTYPE html>
<html lang="en"> -->

<!-- <head> -->
  <!-- <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <!-- CSS only -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->
  <!-- icon  -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <!-- animation -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /> -->
  <!-- font-family  -->
  <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost&display=swap" rel="stylesheet"> -->
  <!-- <link rel="icon" href="../img/logo.png" type="image/x-icon" /> -->

  <!-- <link rel="stylesheet" href="../Style/style.css"> -->
  <!-- jquery and javascript -->
  <!-- <script src="../File/jquery.js"></script>-->
  <!-- <script src="../File/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../File/css/bootstrap.min.css">  -->
<style>
    #item
    {
        color:black;
        font-size:larger;
        font-family:helvetica;
        margin-left:-20px;
        padding:12px;
    }
    #item:hover
    {
        color:red;
    }
    .dropdown
    {
        margin-top:7px;
        /* margin-left:90px; */
    }
    .dropdown-item:active
    {
        color:white;
        background-color:red;
    }
</style>
<!-- </head> -->

<!-- <body> -->
  <header class="header bg-light" style="position: sticky;top: 0; z-index: 10;margin-top:-20px;">
      <nav class="navbar navbar-expand-lg navbar-light text-dark" aria-label="Ninth navbar example">
          <div class="container">
              <a class="navbar-brand fw-bold" href='./index.php'>
              <h2 style="width: 150; color:darkred;margin-left:-150px">
                        <img src="../img/logo.png" alt="LOGO" style="width:60px;height:70px;margin-left:100px;">
                            Blood Buzz
                    </h2>
              </a>
              <div class="collapse navbar-collapse" id="navbarsExample07XL" style="margin:0 20% 0 20%;">
                  <ul class="navbar-nav mb-lg-2">
                      <li class="nav-item ms-2 me-2">
                          <a class="nav-link fw-bold" id="item" 
                              target="_self" href='./index.php'>Home</a>
                      </li>
                      <li class="nav-item ms-2 me-2">
                          <a class="nav-link fw-bold" id="item" href='./donate_blood.php' target="_self" style="text-wrap: nowrap;">Donate</a>
                      </li>


                      <li class="nav-item ms-2 me-2" style="font-weight:bold;">
                            <a class="nav-link dropdown-toggle"  id="item" role="button" data-toggle="dropdown" aria-haspopup="true">Request</a>
                            <div class="dropdown" aria-labelledby="item">
                            <ul class="dropdown-menu">
                            <li><a class="dropdown-item"  href='./requestBlood.php'>Send Request</a></li>
                            <li><a class="dropdown-item" href='./myRequest.php'>My Requests</a></li>
                            </ul>
                            </div>
                      </li>

                      <li class="nav-item ms-2 me-2" style="font-weight:bold;">
                            <a class="nav-link dropdown-toggle" href="#" id="item" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Donation Camps</a>
                            <div class="dropdown" aria-labelledby="item">
                            <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./camps.php">Register Camp</a></li>
                            <li><a class="dropdown-item" href="./viewcamps.php">View Camps</a></li>
                            </ul>
                            </div>
                      </li>

                      
                      <li class="nav-item ms-2 me-2">
                          <a class="nav-link fw-bold" id="item" href='./contactUs.php' style="text-wrap: nowrap;"
                              target="_self">Contact US</a>
                      </li>
                      <li class="nav-item ms-2 me-2">
                          <a class="nav-link fw-bold" id="item" href='./feedback.php' style="text-wrap: nowrap;"
                              target="_self">Feedback</a>
                      </li>
                      
                      <li class="nav-item ms-2 me-2">
                          <a class="nav-link fw-bold" id="item" href='./faq.php' style="text-wrap: nowrap;"
                              target="_self">FAQs</a>
                      </li>


                      <li>
                      <?php

                    if(isset($_SESSION['member_email']))
                    {
                        echo  " <div class='dropdown'>
                    <button class='btn dropdown' type='button' data-bs-toggle='dropdown'
                    aria-expanded='false' style='border: hidden; background-color: #F8F9FA; display: flex;background-color:#fed4d2;border:2px solid #ffa5a1;'>";
                        echo"<i class='fa fa-user-circle me-2' style='font-size:23px;padding:3px;padding-left:7px;font-weight:600;color:red;'></i> 
                        " . $user["name"] . "</button>
                    <ul class='dropdown-menu'>
                        <li><a href='./update.php' class='dropdown-item'>
                        Update Profile</a></li>
                        <li><a class='dropdown-item' href='./logout.php' name='logout'>Logout</a></li>
                    </ul></div>";
                    }
                    else
                    {
                        echo  " <div class='dropdown'>
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
              <div class="d-flex">
                  <!-- Display the user's name -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07XL"
              aria-controls="navbarsExample07XL" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          </div>
      </nav>
  </header>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
      integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
      crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
      integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk"
      crossorigin="anonymous"></script>
      
<!-- </body>
</html> -->


