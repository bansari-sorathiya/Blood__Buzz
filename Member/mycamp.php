<?php 
ob_start();
include './redirect.php';
include './nav.php';
?>

<head>
<link rel="stylesheet" href="../File/css/bootstrap.min.css">
<link rel="icon" href="../img/logo.png" type="image/x-icon" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<title>Blood Buzz-User Camps</title>
</head>

<!-- =================for countdown========================= -->
<script>
        function generateRandomValue() {
            return Math.random().toString(36).substr(2, 10); // Example: "0xxyyzzzz"
        }

        function redirectToLogin() {
            var countdownElement = document.getElementById('countdown');
            var countdownValue = 3;

            function updateCountdown() {
                countdownElement.textContent = countdownValue;

                if (countdownValue === 0) {
                    // Redirect to login.php
                    window.location.href = './camps.php';
                } else {
                    countdownValue--;
                    setTimeout(updateCountdown, 1000); // Update every 1000 milliseconds = 1 second
                }
            }

            // Generate a random value for the 'allowRedirect' parameter
            var randomValue = generateRandomValue();

            // Update the URL with the random value
            var newUrl = window.location.href.replace(/\?.*$/, '') + '?allowRedirect=' + randomValue;
            window.history.replaceState(null, null, newUrl);

            // Start the countdown
            updateCountdown();
        }

        // Call the function when the page loads
        window.onload = redirectToLogin;
    </script>

<?php
include '../include/connect2.php'; 
try
{
    $session_email = $_SESSION['member_email'];

    // Get user member id
    $get_info = $connection->prepare("SELECT member_id FROM members WHERE email=?");
    $get_info->execute([$session_email]);
    $mid_row = $get_info->fetch(PDO::FETCH_ASSOC);
    $mid = $mid_row['member_id'];
    
    //========= pagination start=========
    // Define total records per page
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $records_per_page = 3; // Number of records per page
    $offset = ($page - 1) * $records_per_page;

    // Get total number of records
    $total_records_query = "SELECT COUNT(*) AS total FROM camp WHERE member_id=$mid";
    $total_records_result = $connection->query($total_records_query);
    $total_records = $total_records_result->fetch(PDO::FETCH_ASSOC)['total'];

    // Calculate total number of pages
    $total_pages = ceil($total_records / $records_per_page);
    //==============pagination end=============

    // Get camp data
    $get_camps = $connection->prepare("SELECT * FROM camp WHERE member_id=? LIMIT $offset, $records_per_page");
    $get_camps->execute([$mid]); // Pass $mid as an array
    $camps = $get_camps->fetchAll(PDO::FETCH_ASSOC);
    
    if ($camps) 
    {
        
    ?>
    <div class="container mt-5">
    <div class="table-responsive">
        <table class="table table table-hover">
            <thead class="thead-dark">
                <tr>          
                    <th>Camp Name</th>
                    <th>Conducted By</th>
                    <th>Address</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Email</th>
                    <th>Contact No</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
        <?php

        foreach ($camps as $row) {
            //fetch state
            $state=$connection->prepare("SELECT DISTINCT state_name FROM states WHERE state_id=?");
            $state->execute([$row['state_id']]);
            $sname=$state->fetchColumn();

            //fetch city
            $city=$connection->prepare("SELECT DISTINCT city_name FROM city WHERE city_id=?");
            $city->execute([$row['city_id']]);
            $cname=$city->fetchColumn();

            echo "<tr>";
            echo "<td>{$row['camp_name']}</td>";
            echo "<td>{$row['conducted_by']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$sname}</td>";
            echo "<td>{$cname}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['contact_no']}</td>";
            echo "<td>{$row['date']}</td>";
            echo "<td>{$row['start_time']}</td>";
            echo "<td>{$row['end_time']}</td>";
            $ecid=base64_encode($row['camp_id']);
            if($row['status']=='1')
            {
            echo "<td style='width:120px'>
            <a role='button' href='./updateCamp.php?cid=$ecid' class='btn btn-primary text-white' title='Edit'><i class='bi bi-pencil-fill'></i></a>&nbsp;        
            <a role='button'href='./deleteCamp.php?cid=$ecid' class='btn btn-danger text-white' title='Delete'><i class='bi bi-trash3-fill'></i></a>
            </td>";
            }
            elseif($row['status']=='0')
            {
                echo"<td style='color:red;font-weight:bold;'>Closed</td>";
            }
            else
            {
                echo"<td style='color:red;font-weight:bold;'>Deleted</td>"; 
            }
            echo "</tr>";

        }
        ?>
        </tbody>
        </table>
    </div>
    <div class='pagination'>
    
    <!-- Pagination links -->
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
    <!-- End of Pagination links -->
    
</div>
    </div>
    <?php
    } 
    else 
    {
        ?>
        <center>
            <div class="mt-5 mb-5">
                <h1 class="m-b-0">404</h1>
                <h2><p>Zero Camps</p></h2>
                <p class="countdown" style="font-size:20px;">Redirecting To Register  Camp Page<br> In <span id="countdown">3</span> Seconds</p>
                <div class="buttons-con">
                    <div class="action-link-wrap">
                        <a href="./index.php" class="btn btn-custom btn-danger waves-effect waves-light m-t-20">Home</a>
                    </div>
                </div>
            </div>
        </center>
        <?php
    }
     
}
catch (PDOException $e) 
{
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['error-message'] = "Database error: " . $error;
}
    ?>   


<?php
include './footer.php';
?>