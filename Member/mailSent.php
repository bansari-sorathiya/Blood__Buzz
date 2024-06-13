<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">


<title>Blood Buzz-Mail Sent</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="../img/logo.png" type="image/x-icon" />

<style type="text/css">
    	body{margin-top:20px;}
.mail-seccess {
    text-align: center;
	background: #fff;
	border-top: 1px solid #eee;
}
.mail-seccess .success-inner {
	display: inline-block;
}
.mail-seccess .success-inner h1 {
	font-size: 100px;
	text-shadow: 3px 5px 2px #3333;
	color: #006DFE;
	font-weight: 700;
}
.mail-seccess .success-inner h1 span {
	display: block;
	font-size: 25px;
	color: #333;
	font-weight: 600;
	text-shadow: none;
	margin-top: 20px;
}
.mail-seccess .success-inner p {
	padding: 20px 15px;
    font-size:large;
}
.mail-seccess .success-inner .btn{
	color:#fff;
}
    </style>
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<section class="mail-seccess section">
<div class="container">
<div class="row">
<div class="col-lg-6 offset-lg-3 col-12">

<div class="success-inner">
<h1 style="color:red;margin-top:140px;"><i class="fa fa-envelope"></i><span>Mail Sent Successfully!</span></h1>
<p class="countdown" style="font-size:20px;">Please Check Your Inbox.&nbsp;Redirecting To Forgot Password Page in <span id="countdown">3</span> Seconds</p>
<a href="./login.php" class="btn btn-danger btn-lg">Back To Login</a>
</div>

</div>
</div>
</div>
</section>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	
</script>

<script>
        function generateRandomValue() {
            return Math.random().toString(36).substr(2, 10); // Example: "0xxyyzzzz"
        }

        function redirectToLogin() {
            var countdownElement = document.getElementById('countdown');
            var countdownValue = 3;

            function updateCountdown() {
                countdownElement.textContent = countdownValue;

                if (countdownValue === 0) {
                    // Redirect to login.php
                    window.location.href = 'forgot_pwd.php';
                } else {
                    countdownValue--;
                    setTimeout(updateCountdown, 1000); // Update every 1000 milliseconds = 1 second
                }
            }

            // Generate a random value for the 'allowRedirect' parameter
            var randomValue = generateRandomValue();

            // Update the URL with the random value
            var newUrl = window.location.href.replace(/\?.*$/, '') + '?allowRedirect=' + randomValue;
            window.history.replaceState(null, null, newUrl);

            // Start the countdown
            updateCountdown();
        }

        // Call the function when the page loads
        window.onload = redirectToLogin;
    </script>



</body>
</html>