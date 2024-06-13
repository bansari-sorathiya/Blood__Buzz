<?php
include './redirect.php';

try
{

    if(isset($_GET['status']))
    {
    include '../Include/connect2.php';

    $rid=$_SESSION['deleted_request_id'];
    $mid=$_SESSION['deleted_member_id'];
    $status=$_REQUEST['status'];
        

    date_default_timezone_set('Asia/Kolkata');
    $datetime=date('Y/m/d h:i:s');
        // echo $rid.$status.$mid.$datetime;
    // delete reuest from requester table
    $delete_request=$connection->prepare("DELETE FROM requester WHERE request_id=?");
    $delete_request->execute([$rid]);
    if($delete_request->rowCount() > 0)
    {
        // echo "deleted";
        $_SESSION['dr-message']="Deleted";
    }
    else
    {
        $_SESSION['dr-error-message']="Failed To Delete";
    } 
    // echo $status.$rid,$mid,$datetime;
    if (isset($_REQUEST['method']))
    {
        $method = $_REQUEST['method'];
        if (isset($_REQUEST['donor'])) 
        {
            $donor = $_REQUEST['donor'];
            if(isset($_REQUEST['emailSent']))
            {
            $insert_delete_req = $connection->prepare("INSERT INTO deleted_request(request_id, member_id, reason, method, donor_member_id,certifide, created_at) VALUES(?, ?, ?, ?, ?, ?, ?)");
            $insert_delete_req->execute([$rid, $mid, $status, $method, $donor,'Yes', $datetime]);
            }
            else
            {
            $insert_delete_req = $connection->prepare("INSERT INTO deleted_request(request_id, member_id, reason, method,donor_member_id, created_at) VALUES(?, ?, ?, ?, ?, ?)");
            $insert_delete_req->execute([$rid, $mid, $status, $method, $donor, $datetime]);
            }
        } 
        else 
        {
            $insert_delete_req = $connection->prepare("INSERT INTO deleted_request(request_id, member_id, reason, method, created_at) VALUES(?, ?, ?, ?, ?)");
            $insert_delete_req->execute([$rid, $mid, $status, $method, $datetime]);
        }
    } 
    else 
    {
        $insert_delete_req = $connection->prepare("INSERT INTO deleted_request(request_id, member_id, reason, created_at) VALUES(?, ?, ?, ?)");
        $insert_delete_req->execute([$rid, $mid, $status, $datetime]);
    }
    
    

    if($insert_delete_req->rowCount() <= 0)
    {
    // echo $status;
    $_SESSION['dr-error-message']="Failed To Insert";
    }
    
}
}
catch (PDOException $e) 
   {
      // Handle query errors
      $error=$e->getMessage();
      $_SESSION['dr-error-message'] = "Database error: " . $error;
      print_r($_SESSION['dr-error-message']);
   }
header("Location:myRequest.php");
?>