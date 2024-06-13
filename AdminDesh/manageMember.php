<?php
ob_start(); 
    include './redirect.php';
    include '../Include/connect2.php';
    $session_email=$_SESSION['email'];
    $get_admin=$connection->prepare("SELECT * FROM admin_login WHERE email=?");
    $get_admin->execute([$session_email]);
    if($get_admin->rowCount() > 0)
    {
       $data=$get_admin->fetch(PDO::FETCH_ASSOC);
    }

   
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Blood Buzz-Manage Member</title>
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

    <!-- for charts -->
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    
    <!-- regular jquery -->
    <!-- <script src="../File/js/bootstrap.min.js"></script> -->
    <script src="../File/jquery.js"></script>

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
                    <a href="./seeContactUs.php" class="nav-item nav-link"><i class="bi bi-envelope-paper-fill"></i>View Contact us</a>
                    <a href="./seeFeedback.php" class="nav-item nav-link"><i class="bi bi-chat-left-text-fill"></i>View Feedback</a>
                    <a href="./reports.php" class="nav-item nav-link"><i class="bi bi-bar-chart-line-fill"></i>View Reports</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i class="bi bi-file-earmark-fill me-2"></i>Manage</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="manageMember.php" class="dropdown-item active">Members</a>
                            <a href="manageRequester.php" class="dropdown-item">Requester</a>
                            <a href="manageDonor.php" class="dropdown-item">Donor</a>
                            <a href="manageCamp.php" class="dropdown-item">Camp</a>
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
                            <a href="./logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->





            <!-- Blank Start -->
            <?php if(isset($_SESSION['deactive-profile-error-message']))
            {
                echo $_SESSION['deactive-profile-error-message'];
                unset($_SESSION['deactive-profile-error-message']);
            }
            ?>
            <div class="container-fluid pt-4 px-4">
                <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                    <th>Member Id</th>
                        <th>Image</th>
                        <th>Email</th>
                        <th>Member Name</th>
                        <th>Contact No</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Landmark</th>
                        <th>Pincode</th>
                        <th>Date & Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                <?php 
                // ===============Pagination====================
                $records_per_page = 5; // Number of records to display per page
                $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1
                $offset = ($page - 1) * $records_per_page; 
                //====================End Of Pagination================
                try
                {
                $get_members=$connection->prepare("SELECT c.city_name , s.state_name , m.* FROM members m JOIN city c ON c.city_id = m.city JOIN states s ON s.state_id = m.state WHERE member_status=? LIMIT $offset,$records_per_page");
                $get_members->execute(['1']);
                $members=$get_members->fetchAll(PDO::FETCH_ASSOC);
                }
                catch (PDOException $e) 
                {
                    // Handle query errors
                    $error=$e->getMessage();
                    $_SESSION['error-message'] = "Database error: " . $error;
                }
                
                $total_records = $connection->query("SELECT COUNT(*) FROM members WHERE member_status='1'")->fetchColumn();
                $total_pages = ceil($total_records / $records_per_page);

                foreach($members as $row)
                {
                ?>
                <tr>
                    <td><?php echo $row['member_id'];   ?></td>
                    <td>
                        <?php 
                        if ($row['img']==null)
                        {
                            echo "<img src='../img/user.png' alt='user' width=100 height=100>";
                        }
                        else{
                            echo "<img src='../img/{$row['img']}' alt='user' width=100 height=100>";
                        }
                        ?>
                    </td>
                        <td><?php echo $row['email'];   ?></td>
                        <td><?php echo $row['name'];   ?></td>
                        <td><?php echo $row['contact_no'];   ?></td>
                        <td><?php echo $row['gender'];   ?></td>
                        <td><?php echo $row['dob'];   ?></td>
                        <td><?php echo $row['address'];   ?></td>
                        <td><?php echo $row['city_name'];   ?></td>
                        <td><?php echo $row['state_name'];   ?></td>
                        <td><?php echo $row['landmark'];   ?></td>
                        <td><?php echo $row['pincode'];   ?></td>
                        <td><?php echo $row['created_at'];   ?></td>
                        <td>
                        <?php $encryptedMid=base64_encode($row['member_id']); ?> 
                        <form action="deactive.php?mid=<?php echo $encryptedMid; ?>" method="post">
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>
                        </form>
                        </td>
                </tr>
                <?php
                }
                ?>
                </tbody>
                </table>
            </div>
           
            <!-- Blank End -->

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Pagination">
            <ul class="pagination">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo ($page <= 1) ? 1 : ($page - 1); ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo ($page >= $total_pages) ? $total_pages : ($page + 1); ?>">Next</a>
            </li>
        </ul>
        </nav>
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