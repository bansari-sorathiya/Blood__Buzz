<?php
include './redirect.php';
include '../Include/connect2.php';
        $get_state=$connection->prepare("SELECT state_id,state_name FROM states");
        $get_state->execute();
        $states=array();
        while($row=$get_state->fetch(PDO::FETCH_ASSOC))
        {
            $states[$row['state_id']] = $row['state_name'];
        }
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">


<title>Blood Buzz-Register Camp</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="icon" href="../img/logo.png" type="image/x-icon" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../File/js/bootstrap.min.js"></script>
<script src="../File/jquery.js"></script>


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



<style type="text/css">
    	body{margin-top:20px;
background-color:#f2f6fc;
color:#69707a;
}
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
}
.card .card-header {
    font-weight: 500;
}
.card-header:first-child {
    border-radius: 0.35rem 0.35rem 0 0;
}
.card-header {
    padding: 1rem 1.35rem;
    margin-bottom: 0;
    background-color: rgba(33, 40, 50, 0.03);
    border-bottom: 1px solid rgba(33, 40, 50, 0.125);
}
.form-control, .dataTable-input {
    display: block;
    width: 100%;
    padding: 0.875rem 1.125rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1;
    color: #69707a;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #c5ccd6;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.own
{
    margin-left:400px;
    margin-top:40px;
    margin-bottom:130px;
}
    </style>
</head>
<body>
    <?php  //include './header2.php';
    include './nav.php'; ?>
<div class="own">
<div class="col-xl-8">

<?php
if(isset($_SESSION['camp-error-message'])) {
    echo "<script>
            swal({
              icon: 'error',
              title: 'Error',
              text: '{$_SESSION['camp-error-message']}'
            });
          </script>";
    unset($_SESSION['camp-error-message']);
}

elseif(isset($_SESSION['camp-message'])) {
    echo "<script>
            swal({
              icon: 'success',
              title: 'Success',
              text: '{$_SESSION['camp-message']}',
              timer: 2000,
              showConfirmButton: false
            }).then(function() {
                window.location.href = 'index.php';
            });
          </script>";
    unset($_SESSION['camp-message']);
}
?>

<div class="card mb-4">
<div class="card-header">Register Camp</div>
<div class="card-body">
<form action="./campCode.php" method="post">

<div class="mb-3">
<label class="small mb-1" for="inputUsername">Camp Name *</label>
<input class="form-control" id="inputUsername" type="text" placeholder="Enter camp name" name="cname" required>
</div>

<div class="row gx-3 mb-3">

<div class="col-md-6">
<label class="small mb-1" for="inputFirstName">Conducted By *</label>
<input class="form-control" id="inputFirstName" type="text" placeholder="Who is condecting the camp" name="conductedBy" required>
</div>

<div class="col-md-6">
<label class="small mb-1" for="inputLastName">Address *</label>
<textarea class="form-control" id="inputLastName" placeholder="Enter camp address" name="add" required></textarea>
</div>
</div>

<div class="row gx-3 mb-3">

<div class="col-md-6">
<label class="small mb-1">State*</label>
<?php 
    echo "<select name='state' class='state form-control' required>
    <option selected disabled>Select State</option>";
    foreach ($states as $stateId => $stateName) {
        echo "<option value='$stateId'>$stateName</option>";
    }
    echo "</select>";                       
    ?>
</div>

<div class="col-md-6">
<label class="small mb-1">City*</label>
<select name="city" class="city form-control" required>
<option disabled selected>Select City</option>
<p id="place_city"></p> 
</select></div>
</div>


<div class="row gx-3 mb-3">

<div class="col-md-6">
<label class="small mb-1" for="inputEmailAddress">Email address*</label>
<input class="form-control" id="inputEmailAddress" type="email" placeholder="abc@gmail.com" name="email" required>
</div>

<div class="col-md-6">
<label class="small mb-1">Contact Number*</label>
<input class="form-control" type="text" placeholder="+91 12345 54321" pattern="[0-9]{10}" maxlength=10 name="cno" required>
</div>
</div>

<div class="row gx-3 mb-3">

<div class="col-md-4">
<label class="small mb-1">Date*</label>
<input class="form-control" id="date" type="date" min="<?php echo date('Y-m-d'); ?>" name="date" required>
</div>

<script>
//=======================It is to display current date in date=======================
function formatDate(date) {
  const year = date.getFullYear();
  let month = date.getMonth() + 1;
  let day = date.getDate();

  // Pad single digit month/day with leading zero
  if (month < 10) {
    month = '0' + month;
  }
  if (day < 10) {
    day = '0' + day;
  }

  return `${year}-${month}-${day}`;
}

// // Get the current date
const currentDate = new Date();


// // Set the value of the input field to the current date
document.getElementById("date").value = formatDate(currentDate);
</script>


<div class="col-md-4">
<label class="small mb-1" >Start Time*</label>
<input class="form-control"  type="time" min="09:00" max="06:00" name="stime" required>
</div>

<div class="col-md-4">
<label class="small mb-1" >End Time*</label>
<input class="form-control"  type="time" min="09:00" max="06:00" name="etime" required>
</div>
</div>

<button class="btn btn-outline-danger" type="submit" name="submit">Register Camp</button>
<button class="btn btn-outline-primary" type="reset">Reset</button>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	
</script>
<?php include './footer.php'; ?>
</body>
</html>


