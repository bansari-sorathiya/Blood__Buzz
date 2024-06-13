<?php
ob_start();
ob_end_flush();
include './redirect.php';

$member_email=$_SESSION['member_email'];
include '../Include/connect2.php';

try
{
    $get_mid=$connection->prepare("SELECT member_id FROM members WHERE email=? LIMIT 1");
    $get_mid->execute([$member_email]);
    //in array format
    $mid_row=$get_mid->fetch(PDO::FETCH_ASSOC);
    //in string
    $mid=$mid_row['member_id'];

    
    $check_donor=$connection->prepare("SELECT member_id,donation_status FROM donors WHERE member_id=?");
    $check_donor->execute([$mid]);


    //if user not exist then enter record in donors and redirect to eligibility test
    if($check_donor->rowCount() > 0)
    {
        $status_row=$check_donor->fetch(PDO::FETCH_ASSOC);
        $status=$status_row['donation_status'];


        //for status 2
        if($status=='2')
        {
            //check if user is eligible
            try{
            $check_eli=$connection->prepare("SELECT eligible_id FROM eligibility WHERE member_id=?");
            $check_eli->execute([$mid]);
            if($check_eli->rowCount() > 0)
            {
                $delete_eli=$connection->prepare("DELETE FROM eligibility WHERE member_id=?");
                $delete_eli->execute([$mid]);
                header("location:eligibility_check.php");
            }
            else
            {
                header("location:eligibility_check.php");
            }
            }
            catch (PDOException $e) 
            {
                // Handle query errors
                $error=$e->getMessage();
                $_SESSION['error-message'] = "Database error: " . $error;
            }
        }



        //see if status is one that means user has completed eligibility test
        if($status=='1')
        {
            $sixMonthAgo = date('Y-m-d', strtotime('-6 month'));
            $check_last_eli=$connection->prepare("SELECT created_at FROM eligibility WHERE created_at <= ?");
            $check_last_eli->execute([$sixMonthAgo]);
            if($check_last_eli->rowCount() >0)
            {
            header("location:updateEli.php");
            }
            else
            {
            header("Location:allRequester.php");
            // echo "r";
            }
        }
        else
        {
            header("Location:eligibility_check.php");
            //echo "e";
        }    
    }
    else
    {
        //echo "not found";
        $insert_donor=$connection->prepare("INSERT INTO donors VALUES(null,?,?)");
        $insert_donor->execute([$mid,0]);
    }
      
}
catch (PDOException $e) 
{
      // Handle query errors
      $error=$e->getMessage();
      $_SESSION['error-message'] = "Database error: " . $error;
}

?>