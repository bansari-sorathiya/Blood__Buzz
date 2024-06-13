<?php
// ob_start();
include './redirect.php';
// include './header.php';
?>
<title>Blood Buzz-Update Blood Group</title>
<style>
    #edit
    {
    width:130px;
    height:50px;
    margin-bottom:8px;
    }
    #text
    {
    width:130px;
    height:50px;
    font-size:large;
    border:0.5px solid black;
    padding-left:9px;
    }
</style>

<?php

include '../Include/connect2.php';

    if(isset($_REQUEST['bid']))
    {
        $bid=$_REQUEST['bid'];
        $decrypted_bid=base64_decode($bid);
        // echo $decrypted_bid;

    try
    {
    $fetch_group=$connection->prepare("SELECT blood_grp FROM blood_group WHERE blood_id=?");
    $fetch_group->execute([$decrypted_bid]);
    $data=$fetch_group->fetch();
    $group=$data['blood_grp'];
    }
    catch (PDOException $e) 
    {
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['error-message'] = "Database error: " . $error;
    }
?>

<link rel="stylesheet" href="../File/css/bootstrap.min.css">
    <center>
    <br><br>
    <form method="post"><input type="text" name="group" id="text" value="<?php  echo $group; ?>">
    <button type="submit" id="edit" class="btn btn-outline-success" name="edit">Edit</button></form>
    </center>

<!-- update blood group -->
<?php
if(isset($_REQUEST['edit']) && !empty(trim($_REQUEST['group'])))
{
    try
    {
    $edited_group=trim($_POST['group']);
    $update_blood=$connection->prepare("UPDATE blood_group SET blood_grp=? WHERE blood_id=?");
    $update_blood->execute([$edited_group,$decrypted_bid]);
    if($update_blood->rowCount() > 0)
    {
        $_SESSION['message'] = "Blood Group Updated Successfully";
        header("location:manageBlood.php");
    }
    }
    catch (PDOException $e) 
    {
        // Handle query errors
        $error=$e->getMessage();
        $_SESSION['error-message'] = "Database error: " . $error;
    }
}
}
?>