<?php 
include './redirect.php';
include '../Include/connect2.php';
ob_start();
try
{
    $member_email=$_SESSION['member_email'];
    $get_mid=$connection->prepare("SELECT member_id,dob FROM members WHERE email=? LIMIT 1");
    $get_mid->execute([$member_email]);
    //in array format
    $mid_row=$get_mid->fetch(PDO::FETCH_ASSOC);

    $dob=$mid_row['dob'];
    //get blood groups
    $get_group=$connection->prepare("SELECT DISTINCT * FROM blood_group ORDER BY blood_grp");
    $get_group->execute();
    $group=array();
    while($row=$get_group->fetch(PDO::FETCH_ASSOC))
    {
        $group[$row['blood_id']] = $row['blood_grp'];
    }

    //count age
    // Assuming $birthdate contains the birthdate in 'YYYY-MM-DD' format
    $birthdate = $dob;

    // Create a DateTime object from the birthdate
    $birthDateObj = new DateTime($birthdate);

    // Get the current date
    $currentDateObj = new DateTime();

    // Calculate the difference between the current date and the birthdate
    $ageInterval = $currentDateObj->diff($birthDateObj);

    // Extract the years from the interval
    $age = $ageInterval->y;
    


    $fetch_eli=$connection->prepare("SELECT * FROM eligibility WHERE member_id=?");
    $fetch_eli->execute([$mid_row['member_id']]);
    $data=$fetch_eli->fetch(PDO::FETCH_ASSOC);
    $db_tattoo=$data['tattoo_test'];
    $db_hiv=$data['hiv_test'];
    $today=date('Y-m-d');

    //update the eligibility
    if(isset($_POST['check']))
    {
        $age=$_POST['age'];
        $weight=$_POST['weight'];
        $tattoo=$_POST['tattoo'];
        $hiv=$_POST['hiv'];
        $grp=$_POST['group'];
        $med=$_POST['medcon'];

        //check tattoo
        if($tattoo!="No")
        {
            $_SESSION['elg-error-message']="Not Eligible as had tattoo in past 12 months";
        }

        //check HIV
        elseif($hiv!="No")
        {
            $_SESSION['elg-error-message']="Not Eligible as you had HIV !";
        }   

        //check medical condition
        elseif(($med!=null) && ($med!="no") && ($med!="n"))
        {
            $_SESSION['elg-error-message']="Not Eligible in any medical condition!!";
        }
        else
        {
        $update_eli=$connection->prepare("UPDATE eligibility SET age=?,weight=?,tattoo_test=?,hiv_test=?,blood_id=?,medical_condition=?,created_at=? WHERE member_id=?");
        $update_eli->execute([$age,$weight,$tattoo,$hiv,$grp,$med,$today,$mid_row['member_id']]);
        if($update_eli->rowCount() > 0)
        {
            $_SESSION['elg-message']="You Are Eligible";
        }
        }
        
    }
    
}
catch (PDOException $e) 
{
      // Handle query errors
      $error=$e->getMessage();
      $_SESSION['elg-error-message'] = "Database error: " . $error;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Buzz-Update Eligibility</title>
    <link rel="icon" href="../img/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../ecom/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- for sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        form
        {
            width:310%;
        }
        input[type="radio"]
        {
            transform: scale(1.4); /* Adjust the scale factor as needed */
        }
        input[type="radio"]:checked 
        {
            background-color: red; /* Example background color */
        }
        
    </style>
</head>
<body>


<?php
if(isset($_SESSION['elg-error-message'])) {
    echo "<script>
            swal({
              icon: 'error',
              title: 'Not Eligible!',
              text: '{$_SESSION['elg-error-message']}'
            });
          </script>";
    unset($_SESSION['elg-error-message']);
}

elseif(isset($_SESSION['elg-message'])) {
    echo "<script>
            swal({
              icon: 'success',
              title: 'Eligible!',
              text: '{$_SESSION['elg-message']}',
              timer: 2000,
              showConfirmButton: false
            }).then(function() {
                window.location.href = 'allRequester.php';
            });
          </script>";
    unset($_SESSION['elg-message']);
}

elseif(isset($_SESSION['blood-error-message'])) {
    echo "<script>
            swal({
              icon: 'warning',
              title: 'Required',
              text: '{$_SESSION['blood-error-message']}'
            });
          </script>";
    unset($_SESSION['blood-error-message']);
}
?>


<section class="form-container" style="margin-top:75px;">

<form  method="post" autocomplete="off">
<input type="hidden" id="action" value="login">
   <h3>Are you eligible?</h3>

   <div style="font-size:large;text-align:left;" class="box">Your Age :
   <input  style="font-size:large;" type="text" name="user_age" title="Your Age" disabled value=<?php echo $age;?>>
   <input type="hidden" name="age" value=<?php echo $age; ?>>
    </div>
    <!-- <input type="number" name="age" id="age" class="box" title="Your Age" disabled value=<?php echo $age;?>> -->
    <input type="number" name="weight" id="weight" class="box" title="Your Weight" placeholder="Enter Your Weight( In kg)" min=47 max=110 required>

    <div style="font-size:large;" class="box">Did You Get Tattoo In past 12 Months?*&nbsp;
    <input type="radio" name="tattoo" Value="Yes" <?php echo ($db_tattoo == 'Yes') ? 'checked' : ''; ?>>&nbsp;Yes &nbsp;
    <input type="radio" name="tattoo" Value="No" <?php echo ($db_tattoo == 'No') ? 'checked' : ''; ?>>&nbsp;No &nbsp;</div>

    <div style="font-size:large;" class="box">Have you ever tested positive for HIV ?*
    <input type="radio" name="hiv" Value="Yes" <?php echo ($db_hiv == 'Yes') ? 'checked' : ''; ?>>&nbsp;Yes &nbsp;
    <input type="radio" name="hiv" Value="No" <?php echo ($db_hiv == 'No') ? 'checked' : ''; ?>>&nbsp;No</div>

        <select required id="group"  name="group" class="box" required title="Your Blood Group">
        <option selected disabled>Your Blood Group *</option>
        <?php 
        $currentGroup=$data['blood_id'];
        foreach ($group as $gid => $gname)
        {
        $selected = ($gid == $currentGroup) ? "selected" : "";
        echo "<option value='$gid' $selected>$gname</option>";
        }        
        ?>
        </select>

        <select name="medcon" id="medcon" class="box">
        <option  disabled value="">Select Medical Condition</option>
        <option value="Blood Pressure">Blood Pressure</option>
        <option value="diabiats">Diabiats</option>
        <option value="Pregnancy">Pregnancy</option>
        <option value="Major surgery if recent">Major surgery if recent</option>
        <option value="Asthma">Asthma</option>
        <option value="Heart disease">Heart disease</option>
        <option value="Flu Sore Throat Cold">Flu Sore Throat Cold</option>
        <option selected value="None">None Of Them</option>
    </select>
    
    <input type="submit" value="Check" class="btn" style="background-color:red;" id="submit" name="check">
   
</form>
</section>
</body>
</html>
