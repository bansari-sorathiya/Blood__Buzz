<?php
include './redirect.php';
try
{
    include '../Include/connect2.php';
    if(isset($_POST['submit']))
    {
        //get member id
        $session_email=$_SESSION['member_email'];
        $get_user=$connection->prepare("SELECT member_id FROM members WHERE email=?");
        $get_user->execute([$session_email]);
        $data=$get_user->fetch(PDO::FETCH_ASSOC);

        $cname=$_POST['cname'];
        $cby=$_POST['conductedBy'];
        $add=$_POST['add'];
        $state=$_POST['state']; 
        $city=$_POST['city'];
        $email=$_POST['email'];
        $cno=$_POST['cno'];
        $date=$_POST['date'];
        $stime=$_POST['stime'];
        $etime=$_POST['etime'];  
        date_default_timezone_set('Asia/Kolkata');
        $datetime=date('Y/m/d h:i:s');
        $mid=$data['member_id'];
        
        //insert camp
        $reg_camp=$connection->prepare("INSERT INTO camp VALUES(null,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $reg_camp->execute([$mid,$cname,$cby,$add,$state,$city,$email,$cno,$date,$stime,$etime,'1',$datetime]);

        if($reg_camp->rowCount() > 0)
        {
            $_SESSION['camp-message']="Camp Registered Successfully.";
        }
        else
        {
            $_SESSION['camp-error-message']="Something Went Wrong";
        }
    }
}
catch (PDOException $e) 
{
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['camp-error-message'] = "Database error: " . $error;
} 
// print_r($_SESSION['camp-error-message']);      
header("Location:camps.php");
exit;
?>