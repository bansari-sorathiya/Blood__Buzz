<?php
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
    //in string

    if(isset($_POST['check']))
    {
        if(empty($_POST['group']))
        {
            $_SESSION['blood-error-message']="Please Enter Blood Group";
            header("location:eligibility_check.php");
        }
        else
        {
        $mid=$mid_row['member_id'];
        $age=$_POST['age'];
        $weight=$_POST['weight'];
        $tattoo=$_POST['tattoo'];
        $hiv=$_POST['hiv'];
        $grp=$_POST['group'];
        $med=$_POST['medcon'];
        $today = date('Y-m-d');
            // echo $age.$weight.$tattoo.$hiv.$grp.$med;

        // check whether record is exist or not...
        $check_eligibility=$connection->prepare("SELECT member_id FROM eligibility WHERE member_id=?");
        $check_eligibility->execute([$mid]);

        if($check_eligibility->rowCount() > 0)
        {
        $_SESSION['elg-error-message']="You Have Already Completed Eligibility Test.";
        }
        else
        {
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
            elseif($med!="None")
            {
                $_SESSION['elg-error-message']="Not Eligible in any medical condition!!";
            }
            else 
            {
                $insert_eligibility=$connection->prepare("INSERT INTO eligibility VALUES(null,?,?,?,?,?,?,?,?)");
                $insert_eligibility->execute([$mid,$age,$weight,$tattoo,$hiv,$grp,$med,$today]);
                if($insert_eligibility->rowCount() > 0)
                {
                    $_SESSION['elg-message']="You Are Eligible";
                    $update_status=$connection->prepare("UPDATE donors SET donation_status=? WHERE member_id=?");
                    $update_status->execute([1,$mid]);
                }
            }
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
header("location:eligibility_check.php");

?>