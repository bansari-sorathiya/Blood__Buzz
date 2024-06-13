<?php 
ob_start();

include './redirect.php';

include '../Include/connect2.php';

    try
    {
        $fetch_blood_data = $connection->prepare("SELECT * FROM blood_group");
        $fetch_blood_data->execute();
        $blood_data = $fetch_blood_data->fetchAll(PDO::FETCH_ASSOC);
    } 
    catch (PDOException $e) 
    {
        // Handle database error
        $error_message = "Database error: " . $e->getMessage();
    }

    // include '../Include/connect2.php';
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
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <title>Blood Buzz-Manage Blood</title>
    <link rel="icon" href="../img/logo.png" type="image/x-icon" />
    <!-- <script src="../File/js/bootstrap.min.js"></script> -->
    <!-- <script src="../File/jquery.js"></script> -->
    <!-- <link rel="stylesheet" href="../../ecom/css/admin_style.css"> -->

    <style>
        table
        {
            align-items:center;
        }
        table
        {
            width: 80%;
            border-collapse: collapse;
        }

        th,td
        {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size:large;
        }
        th
        {
            background-color: #f2f2f2;
        }
        .error-message
      {
         background-color:#cc0000;
         color: white;
         margin-bottom: 20px;
         border: 2px solid #cc0000;
         font-size:medium;
         font-weight:bold;
         width:500px;
         height:80px;
         padding:8px;
         padding-bottom:5px;
         padding-left:25px;
         display: inline-block;
      }
      .message
      {
         background-color:green;
         color: white;
         margin-bottom: 20px;
         border: 2px solid white;
         font-size:medium;
         font-weight:bold;
         width:300px;
         height:50px;
         padding:8px;
         padding-bottom:5px;
         padding-left:25px;
         display: inline-block;
      }
      h1
      {
        margin-top:75px;
      }
      #update,#delete,#addBloodGroupBtn,#submit,#edit
      {
        width:150px;
        font-size:medium;
      }
      #delete
      {
        margin-top:10px;
      }
      #bloodGroupInput
      {
        width:400px;
        height:40px;
        border:1px solid black;
        padding:7px;
        font-size:large;
      }
      #insertBtn
      {
        width:200px;
        height:50px;
      }
      #cancelBtn
      {
        background-color:red;
        color:white;
        width:100px;
        font-weight:bold;
        height:40px;
        font-size:medium;
      }
    </style>

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

    <link rel="stylesheet" href="../File/css/bootstrap.min.css">
    
    <!-- for icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                    <a href="manageBlood.php" class="nav-item nav-link active"><i class="fa fa-th me-2"></i>Manage Blood</a>
                    <a href="./addAdmin.php" class="nav-item nav-link"><i class="bi bi-person-fill-add"></i>Add Admin</a>
                    <a href="./seeContactUs.php" class="nav-item nav-link"><i class="bi bi-envelope-paper-fill"></i>View all contact us</a>
                    <a href="./seeFeedback.php" class="nav-item nav-link"><i class="bi bi-chat-left-text-fill"></i>View All Feedback</a>
                    <a href="./reports.php" class="nav-item nav-link"><i class="bi bi-bar-chart-line-fill"></i>View Reports</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-file-earmark-fill me-2"></i>Manage</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="manageMember.php" class="dropdown-item">Members</a>
                            <a href="manageRequester.php" class="dropdown-item">Requester</a>
                            <a href="manageDonor.php" class="dropdown-item">Donor</a>
                            <a href="manageCamp.php" class="dropdown-item">Camp</a>
                        </div>
                    </div>
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
            
    <?php 
    
    // Display error message if it exists
   if(isset($_SESSION['error-message']))
   {
      echo '<center><div class="error-message">' . $_SESSION['error-message'] . '</div></center>';
      unset($_SESSION['error-message']);
   }
   if(isset($_SESSION['message']))
   {
      echo '<center><div class="message" style="background-color:green;class="center-text"">' . $_SESSION['message'] . '</div></center>';
      unset($_SESSION['message']);
   }
    
   ?>
   <br>
    <center><h1>Blood Groups</h1><br>
    <!--insert blood group-->
    <input type="submit" value="Insert Blood Group" class="btn btn-outline-secondary" id="insertBtn" name="add" onclick="toggleBloodGroupInputs()">

    <form id="bloodGroupInputs" style="display: none;" action="addBlood.php">
    <select  id="bloodGroupInput" style="padding: 10px; font-size: 16px; width: 200px; height: 40px;" name="group">
        <option value="" selected disabled>Select Blood Group</option>    
        <option value="O-">O-</option>
        <option value="O+">O+</option>
        <option value="A-">A-</option>
        <option value="A+">A+</option>
        <option value="B-">B-</option>
        <option value="B+">B+</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
    </select>
    <!-- <input type="text" id="" placeholder="Enter Blood Group" > -->
    <button type="button" id="cancelBtn" onclick="cancelBloodGroup()">Cancel</button>
    <button type="submit" id="cancelBtn" style="background-color:#00609C;color:white;cursor:pointer;" name="insert">Add</button>
    </form>

    <script src="../Admin/try.js"></script>
   <!-- End of Insert blood group -->
    <br><br><br></center>
    <?php if(isset($_SESSION['error-message'])): ?>
        <p>
        <?php 
        echo '<center><div class="error-message">' . $_SESSION['error-message'] . '</div></center>';
        unset($_SESSION['error-message']);
       ?>
       </p>

        
    <?php else: ?>
        <center><table >
            <thead class="thead-dark">
                <tr>
                    <th>Blood ID</th>
                    <th>Blood Group</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blood_data as $blood): ?>
                    <tr>
                        <td><?php echo $blood['blood_id']; ?></td>
                        <td><?php echo $blood['blood_grp']; ?></td>
                        <td>
                        <form method="post">
                            <input type="hidden" name="blood_id" value="<?php echo $blood['blood_id']; ?>">
                            <button type="submit" class="btn btn-outline-info" id="update" name="update"><i class="bi bi-pen-fill"></i>&nbsp;&nbsp;Edit</button>
                        </form>
                        <form method="post">
                            <input type="hidden" name="blood_id" value="<?php echo $blood['blood_id']; ?>">
                            <button type="submit" class="btn btn-outline-danger" id="delete" name="delete"><i class="bi bi-trash3-fill"></i>&nbsp;Delete</button>
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table></center>
    <?php endif; ?>
    
   

          
           <!-- Footer Start -->
           <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="../member/index.php">Blood Buzz</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
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

<?php 
if($fetch_blood_data->rowCount() > 0)
{
    if(isset($_REQUEST['update']))
    {
        $encrypted_bid=base64_encode($_POST['blood_id']);
        try
        {
        header("location:updateBlood.php?bid=$encrypted_bid");
        }
        catch (PDOException $e) 
        {
            // Handle query errors
            $error=$e->getMessage();
            $_SESSION['error-message'] = "Database error: " . $error;
        }
    }
    if(isset($_POST['delete']))
    {
        $encrypted_bid=base64_encode($_POST['blood_id']);

        try
        {
        header("location:deleteBlood.php?bid=$encrypted_bid");
        }
        catch (PDOException $e) 
        {
            // Handle query errors
            $error=$e->getMessage();
            $_SESSION['error-message'] = "Database error: " . $error;
        }
    }
}

?>
