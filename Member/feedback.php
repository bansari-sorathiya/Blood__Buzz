<?php
session_start();
if(!isset($_SESSION['member_email']))
{
  header("location:./seeFeedback.php");
    exit(0);
}


include './nav.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">

<title>Blood Buzz-Feedback Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="icon" href="../img/logo.png" type="image/x-icon" />

<style type="text/css">
    
    .credit-card
    {
    background-color: #f4f4f4;
    height: 100vh;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    /* margin-top:-60px; */
    }
    .card-holder
    {
    margin: 2em 0;
    margin-top:-330px;
    /* margin-bottom:-350px; */
    }

    #img 
    {
    padding-top: 20px;    
    display: flex;
    justify-content: center;
    width:70%;
    height:80%;
    /* margin-left:70px; */
    margin-top:60px;
    border-radius:20px;
    }
    .card-box 
    {
    font-weight: 800;
    padding: 1em 1em;
    border-radius: 0.25em;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    margin-top:150px;
    margin-bottom:-180px;
    }
    .bg-news 
    {
    background: -webkit-linear-gradient(70deg, #f54d70 40%, #ffffff 40%);
    background: -o-linear-gradient(70deg, #f54d70 40%, #ffffff 40%);
    background: -moz-linear-gradient(70deg, #f54d70 40%, #ffffff 40%);
    background: linear-gradient(70deg, #f54d70 40%, #ffffff 40%);
    }

    .credit-card form
    {
        background-color: #ffffff;
        padding: 0;
        /* max-width: 600px; */
        margin: auto;
    }

    .credit-card .title
    {
        font-size: 1em;
        color: #2C3E50;
        border-bottom: 1px solid rgba(0,0,0,0.1);
        margin-bottom: 0.8em;
        font-weight: 600;
        padding-bottom: 8px;
        width: 90%;
    }

    .credit-card .card-details label
    {
        /* font-family: 'Abhaya Libre', serif; */
        font-size: 14px;
        font-weight: 400;
        margin-bottom: 15px;
        color: #79818a;
        text-transform: uppercase;
    }

    .credit-card textarea
    {
        font-size: 16px;
        font-weight: 500;
        padding: 10px 10px 10px 5px;
        -webkit-appearance: none;
        display: block;
        background: #fafafa;
        color: #636363;
        border: none;
        border-radius: 0;
        border-bottom: 1px solid #757575;	
    }

    .credit-card .card-details button
    {
        margin-top: 0.6em;
        padding:12px 0;
        background-color:red;
        color:white;
        width:90%;
        font-size:medium;
        border-radius:20px;
    }
    </style>
</head>
<body>

<?php
   // Display error message if it exists
  //  if(isset($_SESSION['feedback-error-message']))
  //  {
  //     echo '<center><div class="error-message">' . $_SESSION['feedback-error-message'] . '</div></center>';
  //     unset($_SESSION['feedback-error-message']);
  //  }

  //  if (isset($_SESSION['feedback-message']))
  //  {
  //     // Display the success message
  //     echo '<center><div class="message">' . $_SESSION['feedback-message'] . '</div></center>';
  
  //     // Unset the session variable to clear the message
  //     unset($_SESSION['feedback-message']);
  // }
?>

<?php
if(isset($_SESSION['feedback-error-message'])) {
    echo "<script>
            swal({
              icon: 'error',
              title: 'Error',
              text: '{$_SESSION['feedback-error-message']}'
            });
          </script>";
    unset($_SESSION['feedback-error-message']);
}

elseif(isset($_SESSION['feedback-message'])) {
    echo "<script>
            swal({
              icon: 'success',
              title: 'Thank You',
              text: '{$_SESSION['feedback-message']}',
              timer: 2000,
              showConfirmButton: false
            }).then(function() {
                window.location.href = 'index.php';
            });
          </script>";
    unset($_SESSION['feedback-message']);
}
?>






<section class="credit-card">
<div class="container">
<div class="card-holder">
<div class="card-box bg-news">
<div class="row">
<div class="col-lg-6">
<div class="img-box">
<img src="../Img/f2.jpg" id="img" style="" class="img-fluid" />
</div>
</div>
<div class="col-lg-6">
<div class="card-details">
<h3 class="title">Give Feedback Here&nbsp;&nbsp;&nbsp;<i class="fas fa-pen"></i></h3><br>

<div class="row">
<div class="form-group col-sm-7">
<div class="inner-addon right-addon">
<form action="feedbackCode.php" method="post">
<!-- <input type="hidden" name="" value="<?php //echo $data['email']; ?>"> -->
<textarea id=""  placeholder="Your Feedback" name="msg" aria-label="Feedback" aria-describedby="basic-addon1" cols="64" rows="7" required title="Pleases Write Your Feedback here"></textarea>
</div>
</div>
<div class="form-group col-sm-12">
<button type="submit message" name="feedback" class="btn btn-block">Submit</button>
</div>
</div> 
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</section>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	
</script>
<?php include './footer.php'; ?>
</body>
</html>