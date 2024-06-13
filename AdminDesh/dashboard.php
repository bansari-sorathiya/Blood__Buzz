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

<?php
//for bar chart
try
{
    $donors = $connection->prepare("SELECT count(*) AS donor FROM donors WHERE donation_status!=?");
    $donors->execute(['2']);
    $donorsCount = $donors->fetch(PDO::FETCH_ASSOC);
    
    $eligible = $connection->prepare("SELECT count(*) AS eligible FROM donors WHERE donation_status=?");
    $eligible->execute(['1']);
    $eligibleCount = $eligible->fetch(PDO::FETCH_ASSOC);
    
    $non = $connection->prepare("SELECT count(*) AS non FROM donors WHERE donation_status=?");
    $non->execute(['0']);
    $nonCount = $non->fetch(PDO::FETCH_ASSOC);
    
    // Prepare data for the bar chart
    $barChartData = [
        ['label' => 'Total Donors', 'y' => intval($donorsCount['donor'])],
        ['label' => 'Eligible Donors', 'y' => intval($eligibleCount['eligible'])],
        ['label' => 'Non-eligible Donors', 'y' => intval($nonCount['non'])]
    ];
    
    $chartJson1 = json_encode($barChartData);

}
catch (PDOException $e) 
{
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['error-message'] = "Database error: " . $error;
}
?>


<!-- for pie chart -->
<?php
$countRequester = $connection->prepare("SELECT bg.blood_id, bg.blood_grp, COUNT(r.request_id) AS requester_count
    FROM blood_group bg
    LEFT JOIN requester r ON bg.blood_id = r.blood_id
    GROUP BY bg.blood_id, bg.blood_grp");
$countRequester->execute();

$piedata = [];
while ($row = $countRequester->fetch(PDO::FETCH_ASSOC)) {
    $piedata[$row['blood_grp']] = $row['requester_count'];
}

// Prepare data for Chart.js
$labels = array_keys($piedata);
$values = array_values($piedata);
$chartData = [
    'labels' => $labels,
    'values' => $values
];
$chartJson = json_encode($chartData);
?>

<!-- for cross hair chart -->
<?php
try {
    // Get the current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    $fetchUser = $connection->prepare("SELECT MONTH(created_at) AS month, COUNT(*) AS user_count
                                    FROM members
                                    WHERE YEAR(created_at) = :year AND member_status='1'
                                    GROUP BY MONTH(created_at)
                                    ORDER BY MONTH(created_at)");
    $fetchUser->bindParam(':year', $currentYear);
    $fetchUser->execute();

    // Fetch data from the query result
    $dataPoints = array();
    while ($row = $fetchUser->fetch(PDO::FETCH_ASSOC)) {
        // Format the data into the required format for the chart
        $month = intval($row['month']);
        $userCount = intval($row['user_count']);
        $dataPoints[] = array('label' => date("M", mktime(0, 0, 0, $month, 1)), 'y' => $userCount);
    }
} 
catch (PDOException $e) {
    // Handle database connection errors
    echo "Error: " . $e->getMessage();
}
?>

<?php
// ==========for spline chart================
try {
    $currentMonth = date('m');
    $currentYear = date('Y');
    date_default_timezone_set('Asia/Kolkata');

    $get_requester = $connection->prepare("
        SELECT COUNT(*) AS requester_count, MONTH(created_at) AS month
        FROM requester
        WHERE YEAR(created_at) = :year 
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ");
    $get_requester->bindParam(':year', $currentYear);
    $get_requester->execute();
    $requesterData = $get_requester->fetchAll(PDO::FETCH_ASSOC);

    $get_donor = $connection->prepare("
        SELECT COUNT(*) AS donor_count, MONTH(created_at) AS month
        FROM eligibility
        WHERE YEAR(created_at) = :year 
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ");
    $get_donor->bindParam(':year', $currentYear);
    $get_donor->execute();
    $donorData = $get_donor->fetchAll(PDO::FETCH_ASSOC);

    $combinedData = [];
    foreach ($requesterData as $r) {
        $month = intval($r['month']);
        $combinedData[$month]['requester'] = intval($r['requester_count']);
    }
    foreach ($donorData as $d) {
        $month = intval($d['month']);
        $combinedData[$month]['donor'] = intval($d['donor_count']);
    }

    $dataPointsReceived = [];
    $dataPointsSent = [];

    for ($month = 1; $month <= 12; $month++) {
        $dataPointsReceived[] = ['x' => $month, 'y' => $combinedData[$month]['requester'] ?? 0];
        $dataPointsSent[] = ['x' => $month, 'y' => $combinedData[$month]['donor'] ?? 0];
    }
    
    $jsonReceived = json_encode($dataPointsReceived);
    $jsonSent = json_encode($dataPointsSent);
} catch (PDOException $e) {
    $error = $e->getMessage();
    $_SESSION['error-message'] = "Database error: " . $error;
    print_r($_SESSION);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Blood Buzz-Admin Dashboard</title>
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

    <script>
        window.onload = function() {

            // Bar chart data
            var barChartData = <?php echo $chartJson1; ?>;
            var dataPoints = barChartData.map(function(item) {
                return { label: item.label, y: item.y };
            });

            // Bar chart configuration
            var barChart = new CanvasJS.Chart("donorsChartContainer", {
                animationEnabled: true,
                exportEnabled: true,
                theme: "light2",
                axisY: {
                    title: "Count",
                    titleFontSize: 24,
                    includeZero: true,
                },
                toolTip: {
                shared: true
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,### Units",
                    dataPoints: dataPoints
                }],
            });

            // Pie chart data
            var chartData = <?php echo $chartJson; ?>;
            console.log(chartData);
            // Pie chart configuration
            var pieChart = new CanvasJS.Chart("piechartContainer", {
                theme: "light1",
                exportEnabled: true,
                animationEnabled: true,
                data: [{
                    type: "pie",
                    startAngle: 25,
                    showInLegend: "true",
                    legendText: "{label}",
                    indexLabelFontSize: 16,
                    indexLabel: "{label} - {y}%",
                    dataPoints: chartData.labels.map((label,index) => ({
                        y: chartData.values[index],
                        label: label
                    })),
                    toolTipContent: "<b>{label}</b>: {y}%"
                }]
            });

            //Cross Hair Chart configuration
            var crosshairchart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            axisX:{
                title:"Months",
                valueFormatString: "MM",
                crosshair: {
                enabled: true,
                snapToDataPoint: true,
                }
            },
            axisY: {
            title: "User Count",
            valueFormatString: "00",
            interval: 1, 
            minimum: 0, 
            crosshair: {
                enabled: true,
                snapToDataPoint: true,
                labelFormatter: function(e) {
                    return  CanvasJS.formatNumber(e.value, "00 Member");
                }
            }
        },
            data: [{
                type: "area",
                xValueFormatString: "MM",
		        yValueFormatString: "00 Member",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        
        //spline chart
                var splineChart = new CanvasJS.Chart("SplinechartContainer", {
                animationEnabled: true,
                exportEnabled: true,
                axisX: {
                    title:"Month",
                    valueFormatString: "### Mon"
                    
                },
                axisY: {
                    title: "Count",
                    interval: 1
                },
                legend: {
                    verticalAlign: "bottom",
                    horizontalAlign: "center",
                    dockInsidePlotArea: false
                },
                toolTip: {
                    shared: true
                },
                data: [{
                        name: "Requester",
                        showInLegend: true,
                        legendMarkerType: "square",
                        type: "spline",
                        xValueFormatString: "### Mon",
                        color: "rgba(40,175,101,0.6)",
                        markerSize: 0,
                        dataPoints: <?php echo $jsonReceived ?? '[]'; ?>
                    },
                    {
                        name: "Donor",
                        showInLegend: true,
                        legendMarkerType: "square",
                        type: "spline",
                        color: "rgba(0,75,141,0.7)",
                        markerSize: 0,
                        dataPoints: <?php echo $jsonSent ?? '[]'; ?>
                    }
                ]
            });


            // Render both charts
            barChart.render();
            pieChart.render();
            crosshairchart.render();
            splineChart.render();
        }
    </script>

    <script>
    // Function to fetch and update last login time using AJAX
    function updateLastLoginTime() {
        $.ajax({
            url: 'get_last_login_time.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Update the displayed time difference on the page
                $('#lastLoginTime').text(response.formattedOutput);
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
        });
    }

    // Call the function initially
    updateLastLoginTime();

    // Set interval to update every 60 seconds (adjust as needed)
    setInterval(updateLastLoginTime, 60000); // Update every 60 seconds
    </script>
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
                <p style ="margin-left:34px;" title="Last Login Time" id="lastLoginTime">Loading...</p>
                    <a href="dashboard.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="manageBlood.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Manage Blood</a>
                    <a href="./addAdmin.php" class="nav-item nav-link"><i class="bi bi-person-fill-add"></i>Add Admin</a>
                    <a href="./seeContactUs.php" class="nav-item nav-link"><i class="bi bi-envelope-paper-fill"></i>View Contact us</a>
                    <a href="./seeFeedback.php" class="nav-item nav-link"><i class="bi bi-chat-left-text-fill"></i>View Feedback</a>
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


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="bi bi-person-fill-check fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Members</p>
                                <?php 
                                $fetch_members=$connection->prepare("SELECT count(*) AS total FROM members WHERE member_status=?");
                                $fetch_members->execute(['1']);
                                $mem=$fetch_members->fetch();
                                ?>
                                <h6 class="mb-0"><?php echo $mem['total'];  ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="bi bi-person-fill-dash fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Deleted Profile</p>
                                <?php 
                                $fetch_delete_pro=$connection->prepare("SELECT count(*) AS total FROM members WHERE member_status=?");
                                $fetch_delete_pro->execute(['0']);
                                $dp=$fetch_delete_pro->fetch();
                                ?>
                                <h6 class="mb-0"><?php echo $dp['total'];  ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="bi bi-clipboard-plus-fill fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Ongoing Camps</p>
                                <?php
                                $fetch_camps=$connection->prepare("SELECT count(*) AS total FROM camp WHERE `status`=?");
                                $fetch_camps->execute([1]);
                                $camp=$fetch_camps->fetch();
                                ?>
                                <h6 class="mb-0"><?php echo $camp['total']; ?></h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="bi bi-calendar2-check-fill fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Completed Request</p>
                                <?php 
                                $fetch_req=$connection->prepare("SELECT count(*) AS total FROM deleted_request WHERE method='ourSite' ");
                                $fetch_req->execute();
                                $completed=$fetch_req->fetch();
                                ?>
                                <h6 class="mb-0"><?php echo $completed['total']; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->


            <!-- bar chart start -->
             <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">All Donors including Eligible and Non-eligible</h6>
                                <a href="total_donor3.php">Show All</a>
                            </div>
                            <div id="donorsChartContainer" style="height: 370px; width: 100%;"></div>
                        </div>
                    </div>
            <!-- bar chart end -->

            <!-- pie chart start -->
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Requests according to blood group</h6>
                                <a href="total_request3.php">Show All</a>
                            </div>
                            <div id="piechartContainer" style="height: 370px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- pie Chart End -->



            <!-- cross hair start -->
             <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Member Count per month</h6>
                                <a href="total_member3.php">Show All</a>
                            </div>
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        </div>
                    </div> 
            <!-- cross hair chart end -->

            <!-- pie chart start -->
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Requester Vs Donors</h6>
                                <!-- <a href="total_request3.php">Show All</a> -->
                            </div>
                            <div id="SplinechartContainer" style="height: 370px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- pie Chart End -->

        

            <!-- Recent Donors Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Top 3 Donors</h6>
                        <a href="">Show All</a>
                    </div>
                    <?php
                   $get_donors = $connection->prepare("
                   SELECT m.email, m.name, m.gender, m.contact_no, COUNT(d.donor_member_id) AS count_donations,d.certifide
                   FROM deleted_request d 
                   JOIN members m ON d.donor_member_id = m.member_id 
                   WHERE d.donor_member_id IS NOT NULL 
                   GROUP BY d.donor_member_id
                   ORDER BY count_donations DESC
                   LIMIT 3
               ");

                    $get_donors->execute();
                    $data=$get_donors->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">Donor Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Contact No.</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Appriciated</th>
                                    <!-- <th scope="col">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data as $donors): ?>
                                <tr>
                                    <td><?php echo $donors['name']; ?></td>
                                    <td><?php echo $donors['email']; ?></td>
                                    <td><?php echo $donors['contact_no']; ?></td>
                                    <td><?php echo $donors['gender']; ?></td>
                                    <td><?php 
                                    if($donors['certifide']=='Yes'){echo "Yes";}else{echo "No";} 
                                    ?></td>
                                    <!-- <td><a class="btn btn-sm btn-primary" href="">Detail</a></td> -->
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Donors End -->


            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Calender</h6>
                                <!-- <a href="">Show All</a> -->
                            </div>
                            <div id="calender"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Widgets End -->


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