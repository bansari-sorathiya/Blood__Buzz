<?php
try
{
    include './redirect.php';
    include '../Include/connect2.php';
if(isset($_POST['edit']))
{
    $cid=$_REQUEST['cid'];
    $cname=$_POST['cname'];
    $cby=$_POST['cby'];
    $add=$_POST['add'];
    $state=$_POST['state'];
    $city=$_POST['city'];
    $email=$_POST['email'];
    $cno=$_POST['cno'];
    $date=$_POST['date'];
    $stime=$_POST['stime'];
    $etime=$_POST['etime'];
    $update_camp=$connection->prepare("UPDATE camp SET camp_name=?,conducted_by=?,`address`=?,state_id=?,city_id=?,email=?,contact_no=?,`date`=?,start_time=?,end_time=? WHERE camp_id=?");
    $update_camp->execute([$cname,$cby,$add,$state,$city,$email,$cno,$date,$stime,$etime,$cid]);
    if($update_camp->rowCount() > 0)
    {
        $_SESSION['ucamp-message']='Camp Updated Successfully';
    }
    }
}
catch (PDOException $e) 
{
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['ucamp-error-message'] = "Database error: " . $error;
    print_r($_SESSION['ucamp-error-message']);
}
header("location:updateCamp.php");
?>