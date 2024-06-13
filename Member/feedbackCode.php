<?php 
session_start();
include '../Include/connect2.php';
?>


<?php
$email=$_SESSION['member_email'];
try
{
    $get_info=$connection->prepare("SELECT * FROM members WHERE email=?");
    $get_info->execute([$email]);
    if($get_info->rowCount() > 0)
    {
        $data=$get_info->fetch();
        //feedback code
        if(isset($_POST['feedback']))
        {
            $feed=$_POST['msg'];
            date_default_timezone_set('Asia/Kolkata');
			$datetime=date('Y/m/d h:i:s');
            $insert_feed=$connection->prepare("INSERT INTO feedback (member_id,feedback,created_at) VALUES(?,?,?)");
            $insert_feed->execute([$data['member_id'],$feed,$datetime]);
            if($insert_feed->rowCount() > 0)
            {
                $_SESSION['feedback-message'] = "Feedback Inserted Successfully";
                header("location:feedback.php");
            }   
            else
            {
                $_SESSION['feedback-error-message'] = "Failed to Submitting Feedback";
            }
        }

    }
    else
    {
        $_SESSION['error-message'] = "Failed to fetch data";
    }
}
catch (PDOException $e) 
{
      // Handle query errors
      $error=$e->getMessage();
      $_SESSION['error-message'] = "Database error: " . $error;
}



?>

