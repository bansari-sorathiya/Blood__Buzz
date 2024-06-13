<?php 
include './redirect.php';

include '../Include/connect2.php';

if(isset($_REQUEST['insert']) && !empty(trim($_REQUEST['group'])))
{
    try
    {
        $blood_grp=trim($_REQUEST['group']);
        
        $fetch_group=$connection->prepare("SELECT blood_grp FROM blood_group WHERE blood_grp=? LIMIT 1");
        $fetch_group->execute([$blood_grp]);
        if($fetch_group->rowCount() > 0)
        {
            $_SESSION['error-message']="Blood Group Already Exist..!";
        }
        else
        {
            $insert_group=$connection->prepare("INSERT INTO blood_group(blood_grp) VALUES(?)");
            $insert_group->execute([$blood_grp]);
            if($insert_group->rowCount() > 0)
            {
                $_SESSION['message']="Blood Group Inserted Successfully.";
            }
            else 
            {
                $_SESSION['error-message']="Failed To Insert Blood Group..!";
            }
        }
    }
    catch (PDOException $e) 
    {
      // Handle query errors
      $error=$e->getMessage();
      $_SESSION['error-message'] = "Database error: " . $error;
    }
}

header("location:manageBlood.php");

?>