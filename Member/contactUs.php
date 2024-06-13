
<?php 
session_start();
ob_start();
?>


<?php 

try
{
    include '../Include/connect2.php';
    if(isset($_POST['submit']))
    {

        $name=$_POST['name'];
        $email=$_POST['email'];
        $pno=$_POST['phone_no'];
        $msg=$_POST['message'];
        date_default_timezone_set('Asia/Kolkata');
        $datetime=date('Y/m/d h:i:s');

        $insert_msg=$connection->prepare("INSERT INTO contact_us VALUES(null,?,?,?,?,?,?)");
        $insert_msg->execute([$name,$pno,$email,$msg,'1',$datetime]);
        if($insert_msg->rowCount() > 0)
        {
            $_SESSION['cno-message']="We will reach you soon!";
        }
        else
        {
            $_SESSION['cno-error-message']="Database error...!" . $e;
        }
    }
}
catch (PDOException $e) 
{
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['cno-error-message'] = "Database error: " . $error;
}

?>












<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">

<title>Blood Buzz-Contact Us</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="../img/logo.png" type="image/x-icon" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- <script src="../File/jquery.js"></script>
  <script src="../File/js/bootstrap.min.js"></script> -->
  <link rel="stylesheet" href="../File/css/bootstrap.min.css">
<style type="text/css">
    body
    {
        margin-top:30px;
        background:#eee;
    }
    .contact-area 
    {
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
    }

    @media only screen and (max-width:768px) 
    {
        .contact {
            margin-bottom: 60px;
        }
    }

    .contact input 
    {
        background: #fff;
        border: 1px solid grey;
        border-radius: 10px;
        -webkit-box-shadow: none;
        box-shadow: none;
        color: #232434;
        font-size: 16px;
        height: 60px;
        padding: 10px;
        width: 100%;
        font-family: 'poppins', sans-serif;
        padding-left: 30px;
        /* -webkit-transition: all 0.3s ease 0s; */
        /* -o-transition: all 0.3s ease 0s;
        transition: all 0.3s ease 0s; */
    }

    .contact textarea 
    {
        background: #fff;
        border: 1px solid grey;
        border-radius: 10px;
        -webkit-box-shadow: none;
        box-shadow: none;
        color: #232434;
        font-size: 16px;
        padding: 10px;
        width: 100%;
        font-family: 'poppins', sans-serif;
        padding-left: 30px;
        -webkit-transition: all 0.3s ease 0s;
        -o-transition: all 0.3s ease 0s;
        transition: all 0.3s ease 0s;
    }

    .contact input:focus 
    {
        background: #fff;
        border: 1px solid black;
        color: #232434;
        -webkit-box-shadow: 2;
        box-shadow: none;
        outline: 0 none;
    }

    .contact textarea:focus 
    {
        background: #fff;
        border: 1px solid black;
        color: #232434;
        -webkit-box-shadow: none;
        box-shadow: none;
        outline: 0 none;
    }

    .btn-contact-bg 
    {
        border-radius: 30px;
        color: #fff;
        outline: medium none !important;
        padding: 15px 27px;
        text-transform: capitalize;
        -webkit-transition: all 0.3s ease 0s;
        -o-transition: all 0.3s ease 0s;
        transition: all 0.3s ease 0s;
        background: red;
        font-family: 'poppins', sans-serif;
        cursor: pointer;
        width: 100%;
    }

    #submitButton
    {
        background-color:red;
        color:white;
        cursor:pointer;
        border-radius:20px;
        font-size:bold;
        margin-bottom:100px;
        height:50px;
    }
    /*START ADDRESS*/

    .single_address 
    {
        overflow: hidden;
        margin-bottom: 10px;
        padding-left: 40px;
    }

    @media only screen and (max-width:768px) 
    {
        .single_address {
            padding-left: 0px;
        }
    }

    .single_address i
    {
        background: #f6f6f6;
        color: red;
        border-radius: 30px;
        width: 60px;
        height: 60px;
        line-height: 60px;
        text-align: center;
        float: left;
        margin-right: 14px;
        font-size: 22px;
        -webkit-box-shadow: 0 5px 30px 0 rgba(0, 0, 0, 0.1);
        box-shadow: 0 5px 30px 0 rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        -webkit-transition: all 0.3s ease 0s;
        -o-transition: all 0.3s ease 0s;
        transition: all 0.3s ease 0s;
    }

    .single_address:hover i
    {
        background: red;
        color: white;
    }

    .single_address h4
    {
        font-size: 18px;
        margin-bottom: 0px;
        overflow: hidden;
        font-weight: 600;
    }

    .single_address p
    {
        overflow: hidden;
        margin-top: 5px;
    }

    .section-title h1
    {
        font-size: 44px;
        font-weight: 500;
        margin-top: 60px;
        position: relative;
        text-transform: capitalize;
        margin-bottom: 15px;
    }
    .section-title p 
    {
        padding: 0 10px;
        width: 70%;
        margin: auto;
        letter-spacing: 1px;
    }
    .section-title 
    {
        margin-bottom: 60px;
    }
    .text-center 
    {
        text-align: center!important;
    }

    input::placeholder 
    {
    color: black; /* Change to the desired color */
    }
      
</style>
</head>
<body>

    <?php //include './header2.php';
    // include './nav.php'; ?>


    

<?php
if(isset($_SESSION['cno-error-message'])) {
    echo "<script>
            swal({
              icon: 'error',
              title: 'Error',
              text: '{$_SESSION['cno-error-message']}'
            });
          </script>";
    unset($_SESSION['cno-error-message']);
}

elseif(isset($_SESSION['cno-message'])) {
    echo "<script>
            swal({
              icon: 'success',
              title: 'Success',
              text: '{$_SESSION['cno-message']}',
              timer: 3000,
              showConfirmButton: false
            }).then(function() {
                window.location.href = 'index.php';
            });
          </script>";
    unset($_SESSION['cno-message']);
}
?>


<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<div id="contact" class="contact-area section-padding">
<div class="container">
<div class="section-title text-center">
<h1>Contact us</h1>
<p>Feel Free to drop your queries. We will try our best to reach you as soon as possible.</p>
</div>
<div class="row">
<div class="col-lg-7">
<div class="contact">
<form class="form" method="POST">
<div class="row">
<div class="form-group col-md-6">
<input type="text" name="name" class="form-control"  placeholder="Name" required="required">
</div>
<div class="form-group col-md-6">
<input type="email" name="email" class="form-control" placeholder="Email" required="required">
</div>
<div class="form-group col-md-12">
<input type="text" name="phone_no" class="form-control" pattern="[0-9]{10}" placeholder="+91 1234554321" maxlength="10" required="required">
</div>
<div class="form-group col-md-12">
<textarea rows="6" name="message" class="form-control" placeholder="Your Message" required="required"></textarea>
</div>
<div class="col-md-12 text-center">
<button type="submit" value="Send message" name="submit" id="submitButton" class="form-control" title="Submit Your Message!">Send Message</button>
</div>
</div>
</form>
</div>
</div>
<div class="col-lg-5">
<div class="single_address">
<i class="fa fa-map-marker"></i>
<h4>Our Address</h4>
<p>A-1 / Veer Palace, ABC Road , Surat 395004, Gujarat, India</p>
</div>
<div class="single_address">
<i class="fa fa-envelope"></i>
<h4>Send your message</h4>
<p><a href="mailto:bansarisorathiya74@gmail.com">[Drop Your Mail]</a></p>
</div>
<div class="single_address">
<i class="fa fa-phone"></i>
<h4>Call us on</h4>
<p>(+91) 12345 54321</p>
</div>
<!-- <div class="single_address">
<i class="fa fa-clock-o"></i>
<h4>Work Time</h4>
<p>Mon - Fri: 08.00 - 16.00. <br>Sat: 10.00 - 14.00</p>
</div> -->
</div>
</div>
</div>
</div>
<!-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	
</script>

<?php //include './footer.php'; ?>
</body>
</html>



