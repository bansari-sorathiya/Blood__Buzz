<?php
session_start();
//include './header2.php';
// include './nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Blood Buzz-Display Camps</title>
<link rel="icon" href="../img/logo.png" type="image/x-icon" />

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../File/css/bootstrap.min.css">

<style>
    .pagination
    {
    display: inline-block;
    margin-left:102px;
    }   
</style>
</head>
<body>

<div class="container mt-5" id="camp">
    <h2 class="mb-3">Camps</h2>

    <form class="form-inline" method="post">
        <select class="form-control mr-sm-2" name="filter">
            <option value="" selected disabled>Filter Camps</option>
            <option value="Open" style="color:green">Open</option>
            <option value="Closed" style="color:red">Closed</option>
        </select>
    <!-- <input  type="search" placeholder="Search" aria-label="Search"> -->
    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Filter</button><br><br><br>
  </form>

    <div class="table-responsive">
        <table class="table table table-hover">
            <thead class="thead-dark">
                <tr>          
                    <th>
                        <button class="btn btn-link" onclick="sortTable('asc')">▲</button>
                        Camp Name
                        <button class="btn btn-link" onclick="sortTable('desc')">▼</button>
                    </th>
                    <th>Conducted By</th>
                    <th>Address</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Email</th>
                    <th>Contact No</th>
                    <th><button class="btn btn-link" onclick="sortTable('asc')">▲</button>
                        Date
                        <button class="btn btn-link" onclick="sortTable('desc')">▼</button></th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            try
            {
                include '../Include/connect2.php';
                // pagination start
                // Define total records per page
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $records_per_page = 3; // Number of records per page
                $offset = ($page - 1) * $records_per_page;

                // Get total number of records
                $total_records_query = "SELECT COUNT(*) AS total FROM camp ORDER BY `date` DESC";
                $total_records_result = $connection->query($total_records_query);
                $total_records = $total_records_result->fetch(PDO::FETCH_ASSOC)['total'];

                // Calculate total number of pages
                $total_pages = ceil($total_records / $records_per_page);
                //pagination end


                // Query to fetch camps data from the database
                if (isset($_POST['filter'])) 
                {
                    $filter = $_POST['filter'];
                    if ($filter == 'Open') 
                    {
                        $query = "SELECT * FROM camp WHERE `status`='1' AND `status` ORDER BY camp_name ASC LIMIT $offset, $records_per_page";
                    } 
                    elseif ($filter == 'Closed') 
                    {
                        $query = "SELECT * FROM camp WHERE `status`='0' ORDER BY camp_name ASC LIMIT $offset, $records_per_page";
                    } 
                    
                } 
                else 
                {
                    $query = "SELECT * FROM camp WHERE `status` NOT IN('2','0')  ORDER BY camp_name ASC LIMIT $offset, $records_per_page";
                }
                
                // Execute the query
                $result = $connection->query($query);

                // Check if there are any rows in the result
                if ($result->rowCount() > 0) 
                {
                    // Loop through each row of the result
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                    {
                        
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
                        if($row['status']=='1')
                        {
                        echo"<td style='color:green;font-weight:bold;'>Open</td>";
                        }
                        elseif($row['status']=='0')
                        {
                        echo"<td style='color:red;font-weight:bold;'>Closed</td>";
                        }
                        echo "</tr>";
                    }
                    
                } 
                else 
                {
                    // No camps found in the database
                    echo "<tr><td colspan='10'>No camps found</td></tr>";
                }


                //to update the status
            $today = date('Y-m-d');
            // Prepare and execute the SQL query to select records older than one month
            $deleteCamp = $connection->prepare("SELECT camp_id FROM camp WHERE date < ?");
            $deleteCamp->execute([$today]);

            // // Fetch the results and store them in a variable
            $olderThanToday = $deleteCamp->fetchAll(PDO::FETCH_ASSOC);

            // // Output the results
            foreach ($olderThanToday as $row) {
                // echo "Camp ID: " . $row['camp_id'] . "<br>";
            
            if($row['camp_id'])
            {
            $updateIt=$connection->prepare("UPDATE camp SET status=? WHERE camp_id=?");
            $updateIt->execute(['0',$row['camp_id']]);
            }
            }
            }
            catch (PDOException $e) 
            {
                // Handle query errors
                $error=$e->getMessage();
                $_SESSION['error-message'] = "Database error: " . $error;
            }
                ?>
            </tbody>
        </table>
    </div>
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

<?php
// include './footer.php';
?>
</body>
</html>

<script>
function sortTable(order) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.querySelector("table");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("td")[0];
            y = rows[i + 1].getElementsByTagName("td")[0];
            if (order === "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (order === "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}
</script>
