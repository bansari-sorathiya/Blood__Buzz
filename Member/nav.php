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

<?php
include '../Include/connect2.php';
$get_requester=$connection->prepare("SELECT count(*) AS total FROM requester");
$get_requester->execute();
$data=$get_requester->fetch();

$get_camp=$connection->prepare("SELECT count(*) AS camp FROM camp WHERE `status`=?");
$get_camp->execute(['1']);
$camp=$get_camp->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Blood Buzz</title> -->
    <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="../img/logo.png" />

  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <!-- Icon Font Css -->
  <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
  <!-- icon  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Slick Slider  CSS -->
  <link rel="stylesheet" href="plugins/slick-carousel/slick/slick.css">
  <link rel="stylesheet" href="plugins/slick-carousel/slick/slick-theme.css">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css">
  <script src="../File/js/bootstrap.min.js"></script>
  <style>
    .header-top-bar{
        background: #b22222 ;
        margin-top:-30px;
    }
        /* Keyframes for rainbow colors */
        @keyframes rainbow {
            0% { color: red; }
            16% { color: orange; }
            100% { color: yellow; }
            50% { color: green; }
            33% { color: white; }
        }

        /* Blinking animation */
        @keyframes blink {
            50% { opacity: 0; }
        }

        /* Styling for the message */
        .blink-text {
            font-size: 25px;
            font-weight: bolder;
            animation: rainbow 4s infinite alternate, blink 1s infinite steps(1);
            /* margin-left:90px; */
        }
  </style>
</head>
<body id="top">
    <header>
        <div class="header-top-bar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <ul class="top-bar-info list-inline-item pl-0 mb-0">
                            <li class="list-inline-item"><a href="mailto:support@gmail.com"><i class="icofont-support-faq mr-2"></i>bloodbuzz@gmail.com</a></li>
                            <li class="list-inline-item"><a href="./donate_blood.php" class="blink-text"><?php echo $data['total']; ?>&nbsp;Requesters</a></li>
                            <li class="list-inline-item"><a href="#camp" class="blink-text"><?php echo $camp['camp']; ?>&nbsp;Camps</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-lg-right top-right-bar mt-2 mt-lg-0">
                            <a href="tel:+23-345-67890" >
                                <span>Call Now : </span>
                                <span class="h6">(+91) 12345 54321</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navigation" id="navbar">
            <div class="container">
                  <a class="navbar-brand" href="http://localhost/Blood/Member/index.php" >
                  <h2 style="width: 140; color:darkred;margin-left:-150px">
                <img src="../img/logo.png" alt="LOGO" style="width:60px;height:70px;margin-left:100px;">
              Blood Buzz
                </h2>
                  </a>
    
                  <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarmain" aria-controls="navbarmain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icofont-navigation-menu"></span>
              </button>
          
              <div class="collapse navbar-collapse" id="navbarmain">
                <ul class="navbar-nav ml-auto">
                  <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                  </li>
                     <!-- <li class="nav-item"><a class="nav-link" href="service.html">Request</a></li> -->
    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="department.html" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Request<i class="icofont-thin-down"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown02">
                            <li><a class="dropdown-item" href="./requestBlood.php">Make Request</a></li>
                            <li><a class="dropdown-item" href="./myRequest.php">My Request</a></li>
                        </ul>
                      </li>
    
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="doctor.html" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Donate<i class="icofont-thin-down"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="./donate_blood.php">Donate Blood</a></li>
                            <li><a class="dropdown-item" href="./nearestRequester.php">Same Pincode Requester</a></li>
                            <li><a class="dropdown-item" href="./nearestLatLong.php">Nearest Requester</a></li>
                            <li><a class="dropdown-item" href="./matchingBlood.php">Same Blood Group Requester</a></li>
                        </ul>
                      </li> 

                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="doctor.html" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Camps<i class="icofont-thin-down"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="./camps.php">Register Camp</a></li>
                            <li><a class="dropdown-item" href="./mycamp.php">My Camps</a></li>
                            
                        </ul>
                      </li> 

                    <!-- <li class="nav-item"><a class="nav-link" href="./contactUS.php">Contact Us</a></li> -->
                    <li class="nav-item"><a class="nav-link" href="./feedback.php">Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="./faq.php">FAQs</a></li>

                    <li>
                      <?php

                    if(isset($_SESSION['member_email']))
                    {
                        echo  " <div class='dropdown'>
                    <button class='btn dropdown' type='button' data-bs-toggle='dropdown'
                    aria-expanded='false' style='border: hidden; background-color: #F8F9FA; display: flex;background-color:#fed4d2;border:2px solid #ffa5a1;'>";
                        echo"<i class='fa fa-user-circle me-2' style='font-size:23px;font-weight:600;color:red;'></i> 
                        " . "&nbsp;" . $user["name"] . "</button>
                    <ul class='dropdown-menu'>
                        <li><a href='./update.php' class='dropdown-item'>Update Profile</a></li>
                        <li><a href='./donation_history.php' class='dropdown-item'>Donation History</a></li>
                        <li><a class='dropdown-item' href='./logout.php' name='logout'>Logout</a></li>
                    </ul></div>";
                    }
                    else
                    {
                        echo  " <div class='dropdown'>
                    <button class='btn dropdown' type='button' data-bs-toggle='dropdown'
                    aria-expanded='false' style='border: hidden; background-color: #F8F9FA; display: flex;background-color:#fed4d2;border:2px solid #ffa5a1;'>";
                        echo"<i class='fa fa-user-circle me-2' style='font-size:23px;font-weight:600;color:red;'></i> 
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
</body>
</html>