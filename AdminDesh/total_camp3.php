<?php
// include '../Include/connect2.php';

$dbHost = "localhost";
$dbUsername = 'root';
$dbPassword = '';
$dbName="blood";

$db=new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
if($db->connect_error){
    die("connection failed...".$db->connect_error);
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
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Jhon Doe</h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="manageBlood.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Manage Blood</a>
                    <!-- <a href="widget.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>
                    <a href="chart.php" class="nav-item nav-link active"><i class="fa fa-chart-bar me-2"></i>Charts</a> -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="index.php" class="dropdown-item">Sign In</a>
                            <a href="signup.php" class="dropdown-item">Sign Up</a>
                            <a href="404.php" class="dropdown-item">404 Error</a>
                            <a href="blank.php" class="dropdown-item">Blank Page</a>
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
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificatin</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">John Doe</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="#" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

    <div class="container">

        <h2>Total camps record</h2>
        <!-- Export Link -->
        <div>
        <form align="center"  method="post">
            <button type="submit" class="btn1" formaction="total_camp4.php"><i class="fa fa-file-pdf-o"></i> PDF</button>
            <button type="submit" class="btn2" formaction="total_camp2.php"><i class="fa fa-file-excel-o"></i> Excel</button>
        </form>
        </div><br>
        <div class="row">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Member Name</th>
                        <th>Camp Name</th>
                        <th>Conducted By</th>
                        <th>Address</th>
                        <th>State Name</th>
                        <th>City Name</th>
                        <th>Emial</th>
                        <th>Contact No</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>

                <?php

                $result=$db->query("SELECT m.name, c.*,ci.city_name,s.state_name FROM camp c LEFT JOIN members m ON m.member_id = c.member_id LEFT JOIN states s ON c.state_id = s.state_id LEFT JOIN city ci ON c.city_id = ci.city_id");
                if($result-> num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?php echo $row['name'];   ?></td>
                            <td><?php echo $row['camp_name'];   ?></td>
                            <td><?php echo $row['conducted_by'];   ?></td>
                            <td><?php echo $row['address'];   ?></td>
                            <td><?php echo $row['state_name'];   ?></td>
                            <td><?php echo $row['city_name'];   ?></td>
                            <td><?php echo $row['email'];   ?></td>
                            <td><?php echo $row['contact_no'];   ?></td>
                            <td><?php echo $row['date'];   ?></td>
                            <td><?php echo $row['start_time'];   ?></td>
                            <td><?php echo $row['end_time'];   ?></td>
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
                            &copy; <a href="#">Your Site Name</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        </br>
                        Distributed By <a class="border-bottom" href="https://themewagon.com" target="_blank">ThemeWagon</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

</body>
</html>

    