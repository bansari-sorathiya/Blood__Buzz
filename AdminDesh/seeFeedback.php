<?php
include './redirect.php';
include '../Include/connect2.php';
    $session_email=$_SESSION['email'];
    $get_admin=$connection->prepare("SELECT * FROM admin_login WHERE email=?");
    $get_admin->execute([$session_email]);
    if($get_admin->rowCount() > 0)
    {
       $data=$get_admin->fetch(PDO::FETCH_ASSOC);
    }
try {
    $stmt = $connection->query("
        SELECT m.name, m.img, f.feedback,f.created_at
        FROM feedback AS f
        JOIN members AS m ON f.member_id = m.member_id
    ");
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle query errors
    $error = $e->getMessage();
    $_SESSION['error-message'] = "Database error: " . $error;
}

?>
<?php
// Include your database connection or query logic here
// include '../Include/connect2.php';

// Pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10; // Number of records per page
$offset = ($page - 1) * $records_per_page;

// Sorting
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'feedback_id';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'ASC'; // Default sorting order

// Fetch feedbacks from the database with pagination and sorting
$sql = "SELECT f.feedback_id, f.feedback, m.name, m.email
        FROM feedback f
        JOIN members m ON f.member_id = m.member_id
        ORDER BY $sort_column $sort_order
        LIMIT $offset, $records_per_page";
$stmt = $connection->query($sql);
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count total records for pagination
$total_stmt = $connection->query("SELECT COUNT(*) AS total FROM feedback");
$total_rows = $total_stmt->fetchColumn();
$total_pages = ceil($total_rows / $records_per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content here -->
    <link rel="stylesheet" href="../File/css/bootstrap.min.css">
    <title>Blood Buzz-All Feedbacks</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- for icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* .card-img-top{
            width:120px;
            height:120px;
            margin-left:365px;
            margin-top:-80px;
            margin-bottom:9px;
        }
       /* .row
        {
            margin-top:20px;
        }
        body
        {
            background-color:black;
        } */
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
                    <a href="./seeContactUs.php" class="nav-item nav-link"><i class="bi bi-envelope-paper-fill"></i>View all contact us</a>
                    <a href="./seeFeedback.php" class="nav-item nav-link active"><i class="bi bi-chat-left-text-fill"></i>View All Feedback</a>
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

        <!-- Blank Start -->
        <div class="container mt-5">
    <h1 class="mb-4">Feedbacks</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><a href="?sort=feedback_id&order=<?php echo ($sort_column == 'feedback_id' && $sort_order == 'ASC') ? 'DESC' : 'ASC'; ?>">ID</a></th>
                <th><a href="?sort=feedback&order=<?php echo ($sort_column == 'feedback' && $sort_order == 'ASC') ? 'DESC' : 'ASC'; ?>">Feedback</a></th>
                <th><a href="?sort=name&order=<?php echo ($sort_column == 'name' && $sort_order == 'ASC') ? 'DESC' : 'ASC'; ?>">Name</a></th>
                <th><a href="?sort=email&order=<?php echo ($sort_column == 'email' && $sort_order == 'ASC') ? 'DESC' : 'ASC'; ?>">Email</a></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($feedbacks as $feedback): ?>
            <tr>
                <td><?php echo $feedback['feedback_id']; ?></td>
                <td><?php echo $feedback['feedback']; ?></td>
                <td><?php echo $feedback['name']; ?></td>
                <td><?php echo $feedback['email']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination links -->
    <nav aria-label="Feedbacks Pagination">
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
    <!-- End of Pagination links -->

    <!-- Sorting links -->
    <div class="mb-3">
        <a href="?sort=feedback_id&order=ASC" class="btn btn-sm btn-secondary">Sort by ID</a>
        <a href="?sort=feedback&order=ASC" class="btn btn-sm btn-secondary">Sort by Feedback</a>
        <a href="?sort=name&order=ASC" class="btn btn-sm btn-secondary">Sort by Name</a>
        <a href="?sort=email&order=ASC" class="btn btn-sm btn-secondary">Sort by Email</a>
    </div>
</div>
            <!-- Blank End -->

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
<!-- JavaScript code for Swiper -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.reviews-slider', {
        direction: 'horizontal',
        loop: true,
        pagination: {
            el: '.swiper-pagination',
        },
    });
</script>

</body>
</html>
