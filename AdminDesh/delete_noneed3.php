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


<title>Reports</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
body
{
margin-top:20px;
background:#f6f9fc;
}
.hover-lift-light {
    transition: box-shadow .25s ease,transform .25s ease,color .25s ease,background-color .15s ease-in;
}
.text-decoration-none {
    text-decoration: none!important;
}
.py-4 {
    padding-top: 1.5rem!important;
    padding-bottom: 1.5rem!important;
}
.align-items-center {
    align-items: center!important;
}
.border-0 {
    border: 0!important;
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(30,46,80,.09);
    border-radius: 0.25rem;
}

.icon-circle-lg {
    width: 4rem;
    height: 4rem;
}
.icon-circle {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 3.2rem;
    height: 3.2rem;
    border-radius: 50%;
}
.bg-pastel-primary {
    background-color: #e9f3ff!important;
}

.mt-6 {
    margin-top: 4rem!important;
}

.mb-4 {
    margin-bottom: 1.5rem!important;
}

.badge {
    padding: 0.4rem 0.65rem 0.25rem;
}
.text-uppercase-bold-sm {
    text-transform: uppercase!important;
    font-weight: 500!important;
    letter-spacing: 2px!important;
    font-size: .85rem!important;
}
.bg-pastel-primary {
    background-color: #e9f3ff!important;
}

.icon-circle-lg {
    width: 4rem;
    height: 4rem;
}
.icon-circle {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 3.2rem;
    height: 3.2rem;
    border-radius: 50%;
}
.bg-pastel-primary {
    background-color: #e9f3ff!important;
}

.icon-circle[class*=text-] [fill]:not([fill=none]), .icon-circle[class*=text-] svg:not([fill=none]), .svg-icon[class*=text-] [fill]:not([fill=none]), .svg-icon[class*=text-] svg:not([fill=none]) {
    fill: currentColor!important;
}
.icon-circle-lg>svg {
    width: 2rem;
    height: 2rem;
}

.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(35,38,45,.09)!important;
}

.input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3), .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
.input-group-lg>.btn, .input-group-lg>.form-control, .input-group-lg>.form-select, .input-group-lg>.input-group-text {
    padding: 0.5rem 1rem;
    font-size: 1.25rem;
    border-radius: 0.3rem;
}
.border-0 {
    border: 0!important;
}
.input-group-text {
    display: flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #1f2c73;
    text-align: center;
    white-space: nowrap;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
}
.container{
    padding: 20px;
}
table tr th, table tr td{
    font-size: 1rem;
}
.btn1{
                font-size:24px; 
                color:white;
                background-color:red;
                border-radius: 8px;
                border-color:red;
                padding: 5px 10px;
                margin-right: 20px;
            }
            .btn2{
                font-size:24px; 
                color:white;
                background-color:green;
                border-radius: 8px;
                border-color:green;
                padding: 5px 10px;
            }
    </style>
</head>
<body>


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
                    <a href="dashboard.php" class="nav-item nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                    <a href="manageBlood.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Manage Blood</a>
                    <a href="./addAdmin.php" class="nav-item nav-link"><i class="bi bi-person-fill-add"></i>Add Admin</a>
                    <a href="./seeContactUs.php" class="nav-item nav-link"><i class="bi bi-envelope-paper-fill"></i>View all contact us</a>
                    <a href="./seeFeedback.php" class="nav-item nav-link"><i class="bi bi-chat-left-text-fill"></i>View All Feedback</a>
                    <a href="./reports.php" class="nav-item nav-link active"><i class="bi bi-bar-chart-line-fill"></i>View Reports</a>
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
    <div class="container">

        <h2>Not Needed Request Record</h2>
        <!-- Export Link -->
        <div>
        <form method="post" style="margin-left:1000px;">
            <button type="submit" class="btn btn-outline-danger" formaction="delete_complete4.php"><i class="fa fa-file-pdf-o"></i> PDF</button>
            <button type="submit" class="btn btn-outline-success" formaction="delete_complete2.php"><i class="fa fa-file-excel-o"></i> Excel</button>
        </form>
        </div><br>
        <div class="row">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Member Name</th>
                        <th>Email</th>
                        <th>Reason</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                include '../Include/connect.php';
                $result=$connection->query("SELECT m.name, m.email, d.reason, d.created_at FROM members m
                JOIN deleted_request d ON m.member_id = d.member_id WHERE d.reason = 'NoNeed'");
                if($result-> num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?php echo $row['name'];   ?></td>
                            <td><?php echo $row['email'];   ?></td>
                            <td><?php echo $row['reason'];   ?></td>
                            <td><?php echo $row['created_at'];   ?></td>
                        </tr>
                        <?php
                    }
                }else{
                    ?>
                    <tr><td colspan="7">No Request Found...</td></tr>
                    <?php
                }
                
                
                ?>
                </tbody>
                </table>
        </div>

    </div>


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

    