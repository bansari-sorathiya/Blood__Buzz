<?php 
session_start();
ob_start();
include './redirect.php';
include '../Include/connect2.php';
try
{
    $member_email=$_SESSION['member_email'];
    $get_mid=$connection->prepare("SELECT member_id,dob FROM members WHERE email=? LIMIT 1");
    $get_mid->execute([$member_email]);
    //in array format
    $mid_row=$get_mid->fetch(PDO::FETCH_ASSOC);



    //main code
    if(isset($_REQUEST['request']))
    {
        if(empty($_POST['blood_group']))
        {
        $_SESSION['request-error-message']="Please Enter Blood Group";
        header("Location:requestBlood.php");
        }
        else
        {
            $mid=$mid_row['member_id'];
            $name=$_REQUEST['name'];
            $grp=$_REQUEST['blood_group'];
            date_default_timezone_set('Asia/Kolkata');
	        $datetime=date('Y/m/d h:i:s');

            $request=$connection->prepare("INSERT INTO requester VALUES(null,?,?,?,?)");
            $request->execute([$mid,$name,$grp,$datetime]);

            if($request->rowCount() > 0)
            {
                $_SESSION['request-message']="Request Sent Successfully.";
            }
            else
            {
                $_SESSION['request-error-message']="Database Error" . $e;
            }
        }
    }


}
catch (PDOException $e) 
{
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['error-message'] = "Database error: " . $error;
}
header("location:requestBlood.php");
?> 