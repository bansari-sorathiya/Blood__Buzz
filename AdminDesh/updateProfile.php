<?php 
include './redirect.php';   
    include '../Include/connect2.php';
    $session_email=$_SESSION['email'];
    $get_admin=$connection->prepare("SELECT * FROM admin_login WHERE email=?");
    $get_admin->execute([$session_email]);
    if($get_admin->rowCount() > 0)
    {
       $data=$get_admin->fetch(PDO::FETCH_ASSOC);
    //    echo $data['login_id'];
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Blood Buzz-Admin Update Profile</title>
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

    <!-- for icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- for sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- for custom css -->
    <link rel="stylesheet" href="./css/updateProfile.css">
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



<!-- Sidebar Start -->
       
<div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="dashboard.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMIN</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        
                        <?php 
                        if($data['img']==null)
                        {
                        echo"<img src='../img/user.png' class='rounded-circle' alt='avatar' style='width: 40px; height: 40px;'>";
                        }
                        else
                        {
                            echo"<img src='../img/{$data['img']}' class='rounded-circle' alt='error' style='width: 40px; height: 40px;'>";
                        }
                     
                         ?>
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><small><?php echo $data['email']; ?></small></h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="manageBlood.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Manage Blood</a>
                    <a href="./addAdmin.php" class="nav-item nav-link"><i class="bi bi-person-fill-add"></i>Add Admin</a>
                    <a href="./seeContactUs.php" class="nav-item nav-link"><i class="bi bi-envelope-paper-fill"></i>View all contact us</a>
                    <a href="./seeFeedback.php" class="nav-item nav-link"><i class="bi bi-chat-left-text-fill"></i>View All Feedback</a>
                    <a href="./reports.php" class="nav-item nav-link"><i class="bi bi-bar-chart-line-fill"></i>View Reports</a>

                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->



        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="dashboard.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <?php 
                        if($data['img']==null)
                        {
                        echo"<img src='../img/user.png' class='rounded-circle' alt='avatar' style='width: 40px; height: 40px;'>";
                        }
                        else
                        {
                            echo"<img src='../img/{$data['img']}' class='rounded-circle' alt='error' style='width: 40px; height: 40px;'>";
                        }
                     
                         ?>
                            <span class="d-none d-lg-inline-flex"><small><?php echo $data['email']; ?></small></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="./updateProfile.php" class="dropdown-item">Update Profile</a>
                            <!-- <a href="#" class="dropdown-item">Settings</a> -->
                            <a href="./logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Update Profile Start -->
            
            <!-- Toggle buttons -->
  <center><button class="toggle-btn" onclick="toggleForm('profile-form')">Update Profile</button>
  <button class="toggle-btn" onclick="toggleForm('password-form')">Change Password</button></center>
<br><br><br><br>

  <?php
   if(isset($_SESSION['profile-error-message'])) {
       echo "<script>
               swal({
                 icon: 'error',
                 title: 'Error',
                 text: '{$_SESSION['profile-error-message']}'
               });
             </script>";
       unset($_SESSION['profile-error-message']);
   }
   
   elseif(isset($_SESSION['profile-message'])) {
       echo "<script>
               swal({
                 icon: 'success',
                 title: 'Success',
                 text: '{$_SESSION['profile-message']}',
                 timer: 2000,
                 showConfirmButton: false
               }).then(function() {
                   window.location.href = './updateProfile.php';
               });
             </script>";
       unset($_SESSION['profile-message']);
   }
   ?>
    

  <!-- ======================Profile update form design============================= -->
  <div id="profile-form" class="form-container" style="display:none;margin-left:350px;">
          <div class="container">
          <div class="main-body">
          <div class="row">
          <div class="col-lg-4">
          <div class="card">
          <div class="card-body">
          <div class="d-flex flex-column align-items-center text-center">
          <?php
              if($data['img']==null)
              {
                echo"<img src='../img/user.png' class='rounded-circle' width='150' height='150' alt='Profile Picture'>";
              }
              else
              {
                  echo"<img src='../img/{$data['img']}' alt='error' class='rounded-circle' height='150' width='150'>";
              }
            ?>

          <div class="mt-3">
          <div class="small text-muted mb-4">JPG or PNG no larger than 5 MB</div>
          <form autocomplete="off" action="./pfpChangeCode.php" method="POST" enctype="multipart/form-data">
          
          <div class="input-group mb-3">
          <input type="file" name="img" accept="image/*" class="form-control p-1" id="inputGroupFile02">
          </div>
          <button type="submit" name="upload" class="btn btn-outline-success">Upload</button>
          <button type="submit" name="remove" class="btn btn-outline-danger">Remove</button>
          </form>
          </div>

          </div>
          <hr class="my-4">
          </div>
          </div>
          </div>
          <div class="col-lg-6">
          <div class="card mt-5">
          <div class="card-body">

          <div class="row mb-3">
          <div class="col-sm-3">
          <h6 class="mb-0">Email</h6>
          </div>
          <div class="col-sm-9 text-secondary">
          <form action="./emailChangeCode.php" method="POST" autocomplete="off">
          <input type="email" required name="email" class="form-control" value="<?php echo $data['email']; ?>">
          </div>
          </div>


          <div class="row">
          <div class="col-sm-9 text-secondary">
          <input type="submit" name="update" class="btn btn-outline-success px-4" value="Change Email">
          </form>
          </div>
          </div>
          </div>
          </div> 
          </div>
          </div>
          </div>
          </div>
  </div>
  <!--=================== End Of Profile update form design===================== -->


  <!-- ===================Password change form================================== -->
   <div id="password-form" class="form-container" style="display:none;margin-left:350px;">
    <form action="./changePwd.php" method="POST" autocomplete="off">
              
    <div class="container">
    <div class="col-xl-8">

    <div class="card mb-4">
    <div class="card-header">Change Password</div>
    <div class="card-body">
    <div class="row gx-3 mb-3">

    <div class="col-md-6">
    <label class="small mb-1" for="inputFirstName">Old Password*</label>
    <input class="form-control" id="inputFirstName" name="old" type="password" required placeholder="Enter your Old Password" >
    </div>

    <div class="col-md-6">
    <label class="small mb-1" for="inputLastName">New Password*</label>
    <input class="form-control" id="inputLastName" name="new" type="password" required placeholder="Enter your New Password" >
    </div>
    </div>

    <div class="row gx-3 mb-3">

    <div class="col-md-6">
    <label class="small mb-1" for="inputLastName">Confirm Password*</label>
    <input class="form-control" id="inputLastName" name="cfm" type="password" required placeholder="Enter Confirm Password">
    </div>
    </div>
    <button class="btn btn-outline-danger" name="change" type="submit">Save changes</button>

   </div>
    </div>
    </div>
    </div>
    </div>
    </div> 

    </form> 
  </div>
  <!-- ===================End Of Password change form================================== -->


  <script>
    // Function to toggle form visibility
    function toggleForm(formId) {
      const form = document.getElementById(formId);
      const allForms = document.querySelectorAll('.form-container');
      
      // Hide all forms except the selected one
      allForms.forEach(form => {
        form.style.display = 'none';
      });
      form.style.display = 'block';
    }
  </script>
            <!-- Update Profile End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="../member/index.php">Blood Buzz</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="">Blood Buzz Team</a>
                        </br>
                        Distributed By <a class="border-bottom" href="" target="_blank">Blood Buzz Team</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
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