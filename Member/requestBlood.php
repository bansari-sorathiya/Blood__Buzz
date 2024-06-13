<?php 
include './redirect.php';
include '../Include/connect2.php';
//get blood groups
$get_group=$connection->prepare("SELECT DISTINCT * FROM blood_group ORDER BY blood_grp");
$get_group->execute();
$group=array();
while($row=$get_group->fetch(PDO::FETCH_ASSOC))
{
    $group[$row['blood_id']] = $row['blood_grp'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Blood Buzz-Request Blood</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="icon" href="../img/logo.png" type="image/x-icon" />


<style type="text/css">
    
    .account-block {
        padding: 0;
        background-image: url(../img/donation.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        height: 100%;
        position: relative;
    }
    .account-block .overla {
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.4);
    }
    .account-block .account-testimonial {
        text-align: center;
        /* color: #fff; */
        position: absolute;
        margin: 0 auto;
        padding: 0 1.75rem;
        bottom: 3rem;
        left: 0;
        right: 0;
    }
    
    .text-theme {
        color: red !important;
    }

    .submit {
        margin-top: 0.6em;
        padding:8px 0;
        background-color:red;
        color:white;
        width:90%;
        font-size:large;
        border-radius:10px;
    }
    .p-5
    {
        border:1px solid grey;
    }
    .own{
        margin-top:30px;
        margin-bottom:40px;
    }
    </style>
</head>
<body>

<?php //include './header2.php';
include './nav.php';
?>


<?php
if(isset($_SESSION['request-error-message'])) {
    echo "<script>
            swal({
              icon: 'error',
              title: 'Error',
              text: '{$_SESSION['request-error-message']}'
            });
          </script>";
    unset($_SESSION['request-error-message']);
}

elseif(isset($_SESSION['request-message'])) {
    echo "<script>
            swal({
              icon: 'success',
              title: 'Success',
              text: '{$_SESSION['request-message']}',
              timer: 2000,
              showConfirmButton: false
            }).then(function() {
                window.location.href = 'requestBlood.php';
            });
          </script>";
    unset($_SESSION['request-message']);
}
?>





<div class="own">
<div id="main-wrapper" class="container">
<div class="row justify-content-center">
<div class="col-xl-10">
<div class="card border-0">
<div class="card-body p-0">
<div class="row no-gutters">
<div class="col-lg-6">
<div class="p-5">
<div class="mb-5">
<h3 class="h4 font-weight-bold text-theme">Request Blood</h3>
</div>
<form method="post" action="requestBloodCode.php">
<div class="form-group">
<label for="exampleInputEmail1">Patient Name</label>
<input required type="text" name="name" class="form-control" id="exampleInputEmail1">
</div>
<div class="form-group mb-5">
<label for="exampleInputPassword1">Select Blood Group</label>
<select name="blood_group" class="form-control" id="exampleInputPassword1" required>
<option selected disabled>Patient Blood Group</option>
        <?php 
        foreach ($group as $gid => $gname)
        {
        echo "<option value='$gid'>$gname</option>";
        }        
        ?>
        </select></div>

<button type="submit" class="submit" name="request">Request</button><br><br>
</form>
</div>
</div>
<div class="col-lg-6 d-none d-lg-inline-block">
<div class="account-block rounded-right">
<div class="overla rounded-right"></div>
<div class="account-testimonial">
<h4 class="text-white mb-4">Hope this will be helpful.</h4>
<p class="lead text-white">"Every few seconds, someone, somewhere, needs blood."</p>
<p>- Blood Buzz</p>
</div>
</div>
</div>
</div>
</div>

</div>
<p style='color:red;font-weight:bold'>Note: <a href="./myRequest.php">DELETE YOUR REQUEST</a> IF IT IS FULFILLED OR NO NEEDED<br> AS SOON AS POSSIBLE. SO BLOOD BUZZ WILL NOT FIND DONOR<br> FOR YOUR REQUEST.&nbsp;</p>

</div>

</div>

</div>
</div>

<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	
</script>
<?php include './footer.php'; ?>
</body>
</html>