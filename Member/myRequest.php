<?php 
include './redirect.php';
include './nav.php';
?>
<head>
<link rel="stylesheet" href="../File/css/bootstrap.min.css">
<link rel="icon" href="../img/logo.png" type="image/x-icon" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<title>Blood Buzz-User Request</title>
</head>
<br>

<style>
    .pagination
    {
    display: inline-block;
    margin-left:199px;
    margin-top:40px;
    /* margin-bottom:40px; */
    }

    .pagination a
    {
    color: white;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    background-color:#ed2939;
    font-weight:bold;
    margin-left:1px;
    }
    .pagination a:hover
    {
        background-color: #fa8072;
        text-decoration:none;
    }
    .own
    {
        margin-left:200px;
        margin-top:70px;
    }
    .error-message,.message
      {
         margin-bottom: 20px;
         font-size:medium;
         font-weight:bold;
         width:500px;
         height:40px;
         padding:8px;
         padding-bottom:5px;
         padding-left:25px;
         display: inline-block;
         color: white;
      }
      .message
      {
        background-color:green;
        border: 2px solid green;
      }
      .error-message
      {
        background-color:#cc0000;
        border: 2px solid #cc0000; 
      }
        input[type="radio"]
        {
            transform: scale(1.4); 
        }
        .reason
        {
            margin-left:90px;
            text-align:left;
        }
</style>

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
                    window.location.href = './requestBlood.php';
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
 

<body>
    <?php
   // Display error message if it exists
   if(isset($_SESSION['dr-error-message']))
   {
      echo '<center><div class="error-message">' . $_SESSION['dr-error-message'] . '</div></center>';
      unset($_SESSION['dr-error-message']);
   }

   if (isset($_SESSION['dr-message']) =="Success")
   {
      // Display the success message
      echo '<center><div class="message">' . $_SESSION['dr-message'] . '</div></center>';
  
      // Unset the session variable to clear the message
      unset($_SESSION['dr-message']);
      header("refresh:2;url=requestBlood.php");
  }
?>



<?php
include '../include/connect2.php'; 
try
{
    //get user
    $email=$_SESSION['member_email'];
    $get_info=$connection->prepare("SELECT * FROM members WHERE email=?");
    $get_info->execute([$email]);
    if($get_info->rowCount() > 0)
    {
        $data=$get_info->fetch();

//==== =====================Pagination==========================
        // Define total records per page
        $records_per_page = 2;

        // Get current page number from URL parameter, default is 1
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

        // Calculate offset for SQL query
        $offset = ($current_page - 1) * $records_per_page;

        // Get total number of records
        $total_records_query=$connection->prepare("SELECT COUNT(*) AS total FROM requester WHERE member_id=?");
        $total_records_query->execute([$data['member_id']]);
        $total_records = $total_records_query->fetch(PDO::FETCH_ASSOC)['total'];

        // Calculate total number of pages
        $total_pages = ceil($total_records / $records_per_page);
//======================End of pagination==========================




        //find if user had requested or not
        $query = "SELECT requester.*, members.* 
            FROM requester 
            INNER JOIN members ON requester.member_id = members.member_id 
            WHERE requester.member_id =? LIMIT $offset, $records_per_page";

            $result = $connection->prepare($query);
            $result->execute([$data['member_id']]);

        if ($result->rowCount() > 0) 
        {
        echo "<div class='own'>";
        echo" <div class='row'>";
        while($row = $result->fetch(PDO::FETCH_ASSOC)) 
            { ?>
            <div class="col-sm-5">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo "Patient Name :&nbsp;".$row['patient_name']; ?></h5><hr>
                <a style="color:red" href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a>
                <input type="hidden" name="rid" value="<?php echo $row['request_id']; ?>">
                <p class="card-text"><?php echo "<b>Address :&nbsp;</b>".$row['address']; ?></p>
                <?php
                    //fetch state
                    $bid=$row['blood_id'];
                    $blood=$connection->prepare("SELECT DISTINCT blood_grp FROM blood_group WHERE blood_id=?");
                    $blood->execute([$bid]);
                    $blood_group=$blood->fetchColumn();
                    ?>
                <p class="card-text"><?php echo "<b>Blood Group :&nbsp;</b>".$blood_group; ?></p>
                <button type="submit" onclick="confirmDelete()" name="delete" class="btn btn-danger"><i class="bi bi-trash3-fill"></i>&nbsp;Delete</button>
            </div>
            </div>
            </div>

            <?php 
            //set cuz needed to delete
        $_SESSION['deleted_request_id']=$row['request_id'];
        $_SESSION['deleted_member_id']=$data['member_id'];

            }//while
        echo"</div></div>";

        // Display pagination links

        // Calculate the previous and next page numbers
        $prev_page = ($current_page > 1) ? $current_page - 1 : 1;
        $next_page = ($current_page < $total_pages) ? $current_page + 1 : $total_pages;

        echo "<br><br><div class='pagination'>
        <a href='?page=1'>&laquo;</a>
        <a href='?page=$prev_page'>&lt;</a>";
            
        for ($i = 1; $i <= $total_pages; $i++)
        {
            echo "<a href='?page=$i' class='" . (($i == $current_page) ? 'active' : '') . "'>$i</a>";
        }
        echo "<a href='?page=$next_page'>&gt;</a>"; // Next page button
        echo "<a href='?page=$total_pages'>&raquo;</a>"; // Last page button
        echo "</div>";

        }
        else
        {
           ?>
           <center><div class="mt-5 mb-5"><h1 class="m-b-0">404</h1>
           <h2><p>Zero Requests</p></h2>
           <p class="countdown" style="font-size:20px;">Redirecting To Request Page In <span id="countdown">3</span> Seconds</p>
           <div class="buttons-con">
           <div class="action-link-wrap">
           <a href="./index.php" class="btn btn-custom btn-danger waves-effect waves-light m-t-20">Go Back</a></div></center>
           <?php
        }
    }
    

    $fetchDonors = $connection->prepare("SELECT m.name,d.member_id FROM donors d JOIN members m ON d.member_id = m.member_id WHERE d.donation_status = ?");
    $fetchDonors->execute([1]);
    $donors = $fetchDonors->fetchAll(PDO::FETCH_ASSOC);

    // $donorNames = [];
    // $donorMemberID= [];
    // foreach ($donors as $donor)
    // {
    //     $donorNames[] = $donor['name'];
    //     $donorMemberID[]=$donor['member_id'];
    // }
    
    
}
catch (PDOException $e) 
   {
      // Handle query errors
      $error=$e->getMessage();
      $_SESSION['error-message'] = "Database error: " . $error;
   }


?>

<br><br><br>


</body>
<!-- </form> -->
<?php include './footer.php'; ?>



<!--=========================== Sweetalert============================ -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> <!-- Include SweetAlert 2 library -->

<script>
function confirmDelete() {
    // Display SweetAlert with form
    Swal.fire({
        title: 'Why?',
        icon: 'question',
        html: `
            <form id="deleteForm" method="POST">
                <div class="reason">
                    <input type="radio" id="completed" name="status" value="completed">
                    <label for="completed">My request got completed</label><br>
                    <input type="radio" id="notNeeded" name="status" value="NoNeed">
                    <label for="notNeeded">No more needed</label><br>
                </div>
            </form>
        `,
        showCancelButton: true,
        showConfirmButton: true,
        focusConfirm: true,
        preConfirm: () => {
            // Handle form submission
            const status = document.querySelector('input[name="status"]:checked');
            if (!status) {
                Swal.showValidationMessage('Please select an option');
            } else {
                return { status: status.value };
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show message based on selected option
            if (result.value.status === 'completed') {
                showCompletionModal();
            } else {
                // Redirect to PHP page with selected status
                window.location.href = 'deleteRequest.php?status=' + result.value.status;
            }   
        }
    });
}

function showCompletionModal() {
    // Display SweetAlert modal for completion details
    Swal.fire({
        title: 'How was your request fulfilled?',
        icon: 'question',
        html: `
            <div>
                <label for="fulfillmentMethod">Select method:</label>
                <select id="fulfillmentMethod" class="form-control">
                    <option value="ourSite">Blood Buzz</option>
                    <option value="relatives">Relatives</option>
                    <option value="hospital">Hospital</option>
                    <option value="bloodBank">Blood Bank</option>
                </select>
            </div>
        `,
        showCancelButton: true,
        showConfirmButton: true,
        focusConfirm: true,
        preConfirm: () => {
            const method = document.getElementById('fulfillmentMethod').value;
            return { method: method };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const method = result.value.method;
            if (method === 'ourSite') {
                showDonorsModal();
            } else {
                // Redirect to PHP page with completion details
                window.location.href = `deleteRequest.php?status=completed&method=${method}`;
            }
        }
    });
}


function showDonorsModal() {
    // Build the options for the donor select list dynamically
    let options = '';
    <?php foreach ($donors as $donorData): ?>
        options += `<option value="<?php echo $donorData['member_id']; ?>"><?php echo $donorData['name']; ?></option>`;
    <?php endforeach; ?>

    // Display SweetAlert modal for donor selection
    Swal.fire({
        title: 'Select a donor',
        icon: 'question',
        html: `
            <div>
                <label for="donorList">Select a donor:</label>
                <select id="donorList" class="form-control">
                    ${options}
                </select>
            </div><br>
            <div id="actionButtons">
                <button id="appreciateBtn" class="btn btn-primary">Appreciate</button>
                <button id="noNeedBtn" class="btn btn-danger">No Need</button>
            </div>
        `,
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
    });

    // Add event listeners for the buttons
    document.getElementById('appreciateBtn').addEventListener('click', () => {
    const selectedDonorId = document.getElementById('donorList').value; //for member_id
    const selectedDonorName = document.getElementById('donorList').options[document.getElementById('donorList').selectedIndex].text; // Get the donor's name
    showAppreciationModal(selectedDonorId, selectedDonorName); //both member_id and name
    });


    document.getElementById('noNeedBtn').addEventListener('click', () => {
        const selectedDonor = document.getElementById('donorList').value;
        window.location.href = `deleteRequest.php?status=completed&method=ourSite&donor=${selectedDonor}`;
    }); 
}

function showAppreciationModal(donorId,donorName) {
    // Display SweetAlert modal for appreciation details
    Swal.fire({
        title: 'Appreciation',
        icon: 'info',
        text: 'Do you want to appreciate this donor?',
        showCancelButton: true,
        showConfirmButton: true,
        focusConfirm: true,
    }).then((result) => {
        if (result.isConfirmed) {
            // Handle appreciation action
            window.location.href = `generate_certificate.php?donor=${encodeURIComponent(donorName)}&memberId=${encodeURIComponent(donorId)}`;
        }
    });
}


</script>

<!--===========================End Of Sweetalert============================ -->
