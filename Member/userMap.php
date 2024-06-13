
<?php 
include './redirect.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Buzz-User Location</title>
    <link rel="stylesheet" href="../File/css/bootstrap.min.css">
    <link rel="icon" href="../img/logo.png" type="image/x-icon" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    
    #info
    {
        margin-top:40px;
        margin-left:150px;
    }
    #location
    {
        color:red;
    }
    p
    {
        font-size:large;
    }
    #direction
    {
        color:#6495ED;
    }
  </style>
</head>
<body>
    <?php //include './header2.php';
    include './nav.php'; ?>
    <div id="info">
    
    <p style=""><i class="bi bi-text-indent-left"></i>&nbsp;Double Click On
    <i id="location" class="bi bi-geo-alt-fill"></i>
    To Zoom In
    </p>
    <p><i class="bi bi-text-indent-left"></i>&nbsp;Click On 
    <i id="direction" class="bi bi-sign-turn-slight-right-fill"></i>
    To get directions
    </p>
    </div><br><br>

<?php 
    try
    {
        include '../Include/connect2.php';
        $email=$_SESSION['member_email'];
        $mid=$_REQUEST['mid'];
        $get_address=$connection->prepare("SELECT member_id,address FROM members WHERE member_id=? LIMIT 1");
        $get_address->execute([$mid]);
        if($get_address->rowCount() > 0) 
        {
            $row=$get_address->fetch(PDO::FETCH_ASSOC);
            $address=$row['address'];
        }
?>
    <center>
    <iframe style="margin-top:-50px;" width="80%" height="450" src="https:\\maps.google.com/maps?q=<?php echo $address; ?>&output=embed"></iframe>
    </center>
<?php
    }
    catch (PDOException $e) 
    {
        // Handle query errors
        $error=$e->getMessage();
        $_SESSION['error-message'] = "Database error: " . $error;
    }

?>
<?php include './footer.php'; ?>
</body>

</html>
