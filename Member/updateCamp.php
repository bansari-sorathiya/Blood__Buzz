<?php include './redirect.php'; ?>

<title>Blood Buzz-Update Camp</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../File/js/bootstrap.min.js"></script>
<script src="../File/jquery.js"></script>
<link rel="icon" href="../img/logo.png" type="image/x-icon" />
<style>
    input[type="text"],
input[type="email"],
input[type="date"],
input[type="time"],
textarea {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 10px;
}

select {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 10px;
}

.table-responsive {
    overflow-x: auto;
}

table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
    border-collapse: collapse;
}

th,
td {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}

thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
.table-responsive{margin-bottom:70px;}
</style>

<?php
try
{
    if(isset($_REQUEST['cid']))
    {
    $cid=base64_decode($_REQUEST['cid']);
    include './nav.php';
    $get_camps = $connection->prepare("SELECT * FROM camp WHERE camp_id=?");
    $get_camps->execute([$cid]); // Pass $mid as an array
    $camps = $get_camps->fetchAll(PDO::FETCH_ASSOC);
?>
        <script type="text/javascript">
                $(document).ready(function()
                {
                    $(".state").change(function()
                    {
                        var state_id=$(this).val();
                        $.ajax({
                                url:"statecity.php",
                                method:"POST",
                                data:{state_id:state_id},
                                success:function(data)
                                {
                                    $(".city").html(data);
                                }
                            });
                    }); 
                });
        </script> 

        <script>
            $(document).ready(function() {
            $("form[name='updateCamp']").submit(function(e) {
                var selectedCity = $("select[name='city']").val();
                if (selectedCity == null || selectedCity.trim() === '') {
                    e.preventDefault(); // Prevent form submission
                    swal({
                        icon: 'warning',
                        title: 'Required',
                        text: 'Please Select State and City Again.'
                    });
                }
            });
        });

        </script>

        <div class="container mt-5">
        <div class="table-responsive">
        <form method='POST' name='updateCamp' action='updateCampCode.php?cid=<?php echo $cid; ?>'>
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

        //get state for dropdown
        $get_state=$connection->prepare("SELECT state_id,state_name FROM states");
        $get_state->execute();
        $states=array();
        while($stat=$get_state->fetch(PDO::FETCH_ASSOC))
        {
            $states[$stat['state_id']] = $stat['state_name'];
        }

        
    echo "<tr>";

    echo "<td>
    <input type='text' name='cname' value='{$row['camp_name']}'>
    </td>";

    echo "<td>
    <input type='text' name='cby' id='' value='{$row['conducted_by']}'>
    </td>";

    echo "<td>
    <textarea name='add'>{$row['address']}</textarea>
    </td>";

    $current_state=$row['state_id'];
    echo "<td><select name='state' class='state'>";
    foreach ($states as $stateId => $stateName) {
        // Check if the current state matches the user's current state
        $selected = ($stateId == $current_state) ? "selected" : "";
        echo "<option value='$stateId' $selected>$stateName</option>";
    }
    echo "</select></td>";
                      

    echo '<td>
    <select name="city" class="city">
    <option disabled selected>Select City</option>
    <p id="place_city"></p> 
    </select></td>';

    echo "<td>
    <input type='email' name='email' id='' value='{$row['email']}'>
    </td>";

    echo "<td>
    <input type='text' name='cno' value='{$row['contact_no']}' pattern='[0-9]{10}' maxlength='10' id=''>
    </td>";
    $today=date('Y-m-d');
    echo "<td>
    <input type='date' name='date' min=$today value='{$row['date']}'>
    </td>";
    echo "<td>
    <input type='time' name='stime' min='09:00' max='06:00' id='' value='{$row['start_time']}'>
    </td>";
    echo "<td>    
    <input type='time' name='etime' min='09:00' max='06:00' value='{$row['end_time']}'>
    </td>";
    echo"<td><button type='submit' name='edit' class='btn btn-success'>Edit</button></form></td>";
    echo "</tr>";
}
?>
            </tbody>
        </table>
    </div>
    </div>
        <?php 
        include './footer.php';
        }
        else
        {
            header("location:mycamp.php");
        }
    }
    catch (PDOException $e) 
    {
        // Handle query errors
        $error=$e->getMessage();
        $_SESSION['error-message'] = "Database error: " . $error;
    }

?>


