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

        // Define how many results you want per page
        $resultsPerPage = 5;

        // Get the total number of contact us messages
        $totalMessagesQuery = $connection->query("SELECT COUNT(*) AS total FROM contact_us");
        $totalMessages = $totalMessagesQuery->fetchColumn();

        // Calculate the total number of pages
        $totalPages = ceil($totalMessages / $resultsPerPage);

        // Get the current page number
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $startIndex = ($page - 1) * $resultsPerPage;

        try {
            // Fetch contact us messages for the current page
            $stmt = $connection->prepare("
                SELECT *
                FROM contact_us
                WHERE status='1'
                ORDER BY created_at DESC 
                LIMIT :startIndex, :resultsPerPage
            ");
            $stmt->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
            $stmt->bindParam(':resultsPerPage', $resultsPerPage, PDO::PARAM_INT);
            $stmt->execute();
            $contact_us = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle query errors
            $error = $e->getMessage();
            $_SESSION['error-message'] = "Database error: " . $error;
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Buzz-All Contact Us</title>
    <link rel="icon" href="../img/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../File/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- for icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .accordion-item {
            width: 80%; /* Adjust the width as needed */
            margin: auto; /* Center the accordion items */
            margin-top:30px;
        }
        .pagination
        {
            margin-left:160px;
        }
    </style>
    
    <style>
        .card-img-top{
            width:120px;
            height:120px;
            margin-left:365px;
            margin-top:-80px;
            margin-bottom:9px;
        }
        .row
        {
            margin-top:20px;
        }
        body
        {
            background-color:#ebe9eb;
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
                    <a href="dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="manageBlood.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Manage Blood</a>
                    <a href="./addAdmin.php" class="nav-item nav-link"><i class="bi bi-person-fill-add"></i>Add Admin</a>
                    <a href="./seeContactUs.php" class="nav-item nav-link active"><i class="bi bi-envelope-paper-fill"></i>View all contact us</a>
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


<div class="accordion accordion-flush" id="accordionFlushExample">
    <?php
        foreach($contact_us as $key => $allCU) {
    ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading-<?php echo $key; ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-<?php echo $key; ?>" aria-expanded="false" aria-controls="flush-collapse-<?php echo $key; ?>">
                    <?php echo "Reason&nbsp;" .$key + 1 ; echo "]"." ".$allCU['reason']; ?>
                </button>
            </h2>
            <div id="flush-collapse-<?php echo $key; ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading-<?php echo $key; ?>" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <p><?php echo "<b>Name: </b>".$allCU['name']; ?></p>
                    <a role="button" class="btn btn-outline-success" href="mailto:<?php echo $allCU['email']; ?>"><i class="bi bi-envelope"></i>&nbsp;Email</a>
                    <a href="./deletecontact.php?cid=<?php echo $allCU['contactus_id']; ?>" role="button" class="btn btn-outline-danger"><i class="bi bi-trash"></i>&nbsp;Delete</a>
                    <!-- Display the contact message here -->
                </div>
            </div>
        </div>
    <?php
        }
    ?>
    </div>
    
    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-left mt-5">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
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
