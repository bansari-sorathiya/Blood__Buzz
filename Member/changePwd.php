
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />

<link rel="stylesheet" href="./css/updateProfile.css">
<!-- change pwd -->

<style>
    body
    {
        color:black;
    }
    form
    {
        margin-left:500px;
        margin-top:160px;
    }
    
</style>

<form action="./changePwdCode.php" method="post" autocomplete="off">
<div class="col-xxl-6">
<div class="bg-secondary-soft px-4 py-5 rounded">
<div class="row g-3">
<h4 class="my-4">Change Password</h4>

<div class="col-md-6">
<label for="exampleInputPassword1" class="form-label">Old password *</label>
<input type="password" name="old_pwd" required autocomplete="off" class="form-control" id="exampleInputPassword1">
</div>

<div class="col-md-6">
<label for="exampleInputPassword2" class="form-label">New password *</label>
<input type="password" name="new_pwd" required autocomplete="off" class="form-control" id="exampleInputPassword2">
</div>

<div class="col-md-12">
<label for="exampleInputPassword3" class="form-label">Confirm Password *</label>
<input type="password" name="cfm_pwd" required autocomplete="off" class="form-control" id="exampleInputPassword3">
</div>
<button type="submit" name="changepwd" class="btn btn-success btn-lg">Change Password</button>
<center><h6><a href="./update.php" class="link">Back To Update Profile</a></h6></center>
</form> 


<?php
include './redirect.php';

if(isset($_SESSION['pwd-error-message'])) {
    echo "<script>
            swal({
              icon: 'error',
              title: 'Error',
              text: '{$_SESSION['pwd-error-message']}'
            });
          </script>";
    unset($_SESSION['pwd-error-message']);
}

elseif(isset($_SESSION['pwd-message'])) {
    echo "<script>
            swal({
              icon: 'success',
              title: 'Success',
              text: '{$_SESSION['pwd-message']}',
              timer: 3000,
              showConfirmButton: false
            }).then(function() {
                window.location.href = './update.php';
            });
          </script>";
    unset($_SESSION['pwd-message']);
}
?>