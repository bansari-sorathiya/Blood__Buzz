<?php 
ob_start();
include './redirect.php';
//include './header2.php'; 
include './nav.php';
?>


<?php
try
{
    if(isset($_SESSION['member_email']))
    {
        // include(__DIR__."/../include/connect.php");

        include '../Include/connect2.php';
        $email=$_SESSION['member_email'];

        //get email
        $get_email=$connection->prepare("SELECT * FROM members WHERE email=?");
        $get_email->execute([$email]);
        if($get_email->rowCount() > 0)
        {
            $data=$get_email->fetch();
        }

        //get state for dropdown
        $get_state=$connection->prepare("SELECT state_id,state_name FROM states");
        $get_state->execute();
            $states=array();
            while($row=$get_state->fetch(PDO::FETCH_ASSOC))
            {
                $states[$row['state_id']] = $row['state_name'];
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




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

<title>Blood Buzz-Update Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="../File/js/bootstrap.min.js"></script>
<script src="../File/jquery.js"></script>
<link rel="icon" href="../img/logo.png" type="image/x-icon" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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

<link rel="stylesheet" href="./css/updateProfile.css">
</head>
<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />


<?php
 
if(isset($_SESSION['profile-error-message'])) {
    echo "<script>
            swal({
              icon: 'error',
              title: 'Error',
              text: '{$_SESSION['profile-error-message']}'
            });
          </script>";
    unset($_SESSION['profile-error-message']);
}

elseif(isset($_SESSION['profile-message'])) {
    echo "<script>
            swal({
              icon: 'success',
              title: 'Success',
              text: '{$_SESSION['profile-message']}',
              timer: 3000,
              showConfirmButton: false
            }).then(function() {
                window.location.href = 'index.php';
            });
          </script>";
    unset($_SESSION['profile-message']);
}

elseif(isset($_SESSION['state-error-message'])) {
    echo "<script>
            swal({
              icon: 'warning',
              title: 'Required',
              text: '{$_SESSION['state-error-message']}'
            });
          </script>";
    unset($_SESSION['state-error-message']);
}
?>




<div class="container">
<div class="row">
<div class="col-12">

<div class="my-5">
<h3>My Profile</h3>
<hr>
</div>

<form action="./updateProfileCode.php" method="post" autocomplete="off">
<div class="row mb-5 gx-5">

<div class="col-xxl-8 mb-5 mb-xxl-0">
<div class="bg-secondary-soft px-4 py-5 rounded">
<div class="row g-3">
<h4 class="mb-4 mt-0">Contact detail</h4>


<!-- split user name -->
    <?php
    $fullname=$data['name'];
    $split_name=explode(" ",$fullname);
    ?>
<div class="col-md-6">
<label class="form-label">First Name *</label>
<input type="text" class="form-control" placeholder aria-label="First name" value="<?php  print_r($split_name[0]); ?>" required name="fname">
</div>

<div class="col-md-6">
<label class="form-label">Last Name *</label>
<input type="text" class="form-control" placeholder aria-label="Last name" value="<?php  print_r($split_name[1]); ?>" required name="lname">
</div>

<div class="col-md-6">
<label class="form-label">Phone number *</label>
<input type="text" class="form-control" maxlength="10" pattern="[0-9]{10}" placeholder aria-label="Phone number" value="<?php echo $data['contact_no']; ?>" required name="cno">
</div>

<div class="col-md-6">
<label class="form-label">Gender *</label>
<?php 
    $currentGender=$data['gender'];
    $gender=array("Male","Female","Others","Prefer Not to say");
    echo "<select name='gen' class='form-control' required>";
    foreach ($gender as $option)
    {
        // Check if the current option matches the user's current gender
        $selected = ($option == $currentGender) ? "selected" : "";
        echo "<option value='$option' $selected>$option</option>";
    }
    echo "</select>";
    ?>
</div>

<div class="col-md-6">
<label for="inputEmail4" class="form-label">Email *</label>
<input type="email" class="form-control" id="inputEmail4" value="<?php echo $data['email']; ?>" required name="email">
</div>

<div class="col-md-6">
<label class="form-label">Date of Birth *</label>
<input type="date" class="form-control" value="<?php echo $data['dob']; ?>" required name="dob">
</div>

<div class="col-md-6">
<label class="form-label">Address *</label>
<textarea class="form-control" placeholder aria-label="Address" required name="add"><?php echo $data['address']; ?></textarea>
</div>

<div class="col-md-6">
<label class="form-label">State *</label>
<?php 
    $current_state=$data['state'];
    echo "<select name='state' class='state form-control' required>";
    foreach ($states as $stateId => $stateName) {
        // Check if the current state matches the user's current state
        $selected = ($stateId == $current_state) ? "selected" : "";
        echo "<option value='$stateId' $selected>$stateName</option>";
    }
    echo "</select>";                       
    ?>
</div>

<div class="col-md-6">
<label class="form-label">City *</label>
<select name="city" class="city form-control">
<option disabled selected>Select City</option>
<p id="place_city"></p> 
</select>

</div>

<div class="col-md-6">
<label class="form-label">Pincode *</label>
<input type="text" id="pcode" name="pin" class="form-control" pattern=[0-9]{6} required value="<?php echo$data['pincode']; ?>">
</div>

<button type="submit" name="updateProfile" class="btn btn-danger btn-lg">Edit profile</button>
<center><h6><a href="./changePwd.php" class="link">Change Password</a></h6></center>
</div> 
</div>
</div>
</form>

<div class="col-xxl-4 file-upload">
<div class="bg-secondary-soft px-4 py-5 rounded">
<div class="row g-3">
<h4 class="mb-4 mt-0">Upload your profile photo</h4>
<div class="text-center">

<div class="square position-relative display-2 mb-3">
<?php if(isset($_SESSION['member_email'])){
            if($data['img']==null)
            {
            echo"<img src='../img/user.png' class='avatar img-circle img-thumbnail' alt='avatar' width=180 height=180 style='margin-top:33px;'>";
            }
            else
            {
                echo"<img src='../img/{$data['img']}' alt='error' width=180 height=180 style='margin-top:33px;'>";
            }
        }//session 
?>
</div>

<input type="file" id="customFile" name="file" hidden>
<form action="./changePicCode.php" method="post" autocomplete="off" enctype="multipart/form-data">
<input type="file" name="img" id="" accept="image/*"><br><br>
<button type="submit" name="upload" class="btn btn-success">Upload</button>
<button type="submit" name="remove" class="btn btn-danger">Remove</button>
</form>

<p class="text-muted mt-3 mb-0"><span class="me-1">Note:</span>Minimum size 300px x 300px</p>
</div>
</div>
</div>
</div>
</div> 



</div>
</div>
</div>
</div>

<!-- for hr -->
<div class="separator">
        <hr>
        <span class="separator-text">Danger Zone</span>
        <hr>
</div>

<!-- <div class="gap-3 d-md-flex justify-content-md-end text-center"> -->
<form action="" method="post" autocomplete="off" onclick="confirmDelete()">
<button type="submit" name="delete" style="margin-left:705px;margin-top:20px;" class="btn btn-outline-danger btn">Delete profile</button>
</form>

<!-- </div> -->

</div>
</div>
</div><br><br>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	
</script>
</body>
</html>


<?php include './footer.php'; ?>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    // JavaScript function to handle deletion confirmation
    function confirmDelete() {
        event.preventDefault();
        // Display SweetAlert confirmation dialog
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover your profile!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            // If the user confirms deletion
            if (willDelete) {
                // Redirect to a PHP script to delete the profile
                window.location.href = "deleteProfileCode.php";
            } else {
                // If the user cancels deletion
                swal("Your profile is safe!", {
                    icon: "success",
                });
            }
        });
    }
</script>