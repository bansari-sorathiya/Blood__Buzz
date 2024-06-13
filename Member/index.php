

<?php
session_start();
error_reporting(0);
include('../include/connect.php');

//if logged in then reminder and deactivate
if($_SESSION['member_email'])
{
	include './deactivateRequest.php';
}


?>
<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="description" content="Orbitor,business,company,agency,modern,bootstrap4,tech,software">
  <meta name="author" content="themefisher.com">

  <title>Blood Buzz</title>
  <script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="../img/logo.png" />

  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <!-- Icon Font Css -->
  <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
  <!-- Slick Slider  CSS -->
  <link rel="stylesheet" href="plugins/slick-carousel/slick/slick.css">
  <link rel="stylesheet" href="plugins/slick-carousel/slick/slick-theme.css">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css">
		<style type="text/css">
			h1{
				color:#b22222;
			}
			.text-color{
				color:#b22222;
			}
			.banner {
				position: relative;
				overflow: hidden;
				background: #fff;
				background: url(../img/slider-bg-1.webp) no-repeat;
				background-size: cover;
				min-height: 550px;
			}
		</style>

		<!-- chatbot -->
		<script>
		window.embeddedChatbotConfig = {
		chatbotId: "gmfAkIeKqf6Q6Rut1Sb1u",
		domain: "www.chatbase.co"
		}
		</script>
		<script
		src="https://www.chatbase.co/embed.min.js"
		chatbotId="gmfAkIeKqf6Q6Rut1Sb1u"
		domain="www.chatbase.co"
		defer>
		</script>


</head>

<body id="top">
<?php 
// include('./header.php');
//include './header2.php';
include './nav.php';
?> 
	



<!-- Slider Start -->
<section class="banner">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-12 col-xl-7">
				<div class="block">
					<div class="divider mb-3"></div>
					<b><span class="text-uppercase text-sm letter-spacing" >Donate Blood! Give Life!</span></b>
					<h6><p class="mb-3 mt-3" style="color:#FAA0A0">Your blood can give a life to someone</p></h6>
					
					<h5><p class="mb-4 pr-5 text-white" >After donating blood, the body works to replenish the blood loss. This stimulates the production of new blood cells and in turn, helps in maintaining good health.</p></h5>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="features">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="feature-block d-lg-flex">
					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<i class="icofont-blood-drop" style="color:#b22222"></i>
						</div>
						<span>24 Hours Service</span>
						<h4 class="mb-3" style="color:#b22222">Request Blood</h4>
						<p class="mb-4">Get All time support for emergency.We have introduced the principle of family donate blood.</p>
						<a href="./requestBlood.php" class="btn btn-main btn-round-full">Make a Request</a>
					</div>
				
					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<i class="icofont-blood-test" style="color:#b22222"></i>
						</div>
						<span>Donating blood</span>
						<h4 class="mb-3" style="color:#b22222">Learn about donating blood</h4>
						<p>Learn about every step in our simple blood donation process and what to expect.</p>
					</div>
				
					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<i class="icofont-support" style="color:#b22222"></i>
						</div>
						<span>Eemergency Cases</span>
						<h4 class="mb-3" style="color:#b22222">(+91) 12345 54321</h4>
						<p>Get ALl time support for emergency.We have introduced the principle of family donated blood.Get Conneted with us for any urgency .</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include './viewcamps.php'; ?>

<section><img src="../img/tips.png" alt="tips" style="width:1500px;"></section>
<!-- <section class="cta-section ">
	<div class="container" >
		<div class="cta position-relative">
			<div class="row" >
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="counter-stat" >
						<i class="icofont-doctor"></i>
						<span class="h3">80</span>K
						<p>Happy People</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="counter-stat">
						<i class="icofont-flag"></i>
						<span class="h3">700</span>+
						<p>Blood Donated</p>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="counter-stat">
						<i class="icofont-badge"></i>
						<span class="h3">500</span>+
						<p>Blood Request</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="counter-stat">
						<i class="icofont-globe"></i>
						<span class="h3">40</span>+
						<p>Blood Bank</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->


<section class="section testimonial-2">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-7">
				<div class="section-title text-center">
					<?php
					include '../Include/connect2.php';
					$com=$connection->prepare("SELECT count(*) AS total FROM deleted_request WHERE reason='completed' AND method='ourSite'");
					$com->execute();
					$com_req=$com->fetch();
					?>
					<h2 style="color:#b22222">We served over <?php echo $com_req['total'] -1 ."+" ; ?> Patients</h2>
					<div class="divider mx-auto my-4" style="color:white"></div>
					<span>Blood is needed by women with complications during pregnancy and childbirth, children with severe anaemia, often resulting from malaria or malnutrition, accident victims and surgical and cancer patients.</span>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12 testimonial-wrap-2">
				<div class="testimonial-block style-2  gray-bg">
					<i class="icofont-quote-right"></i>
					<div class="client-info ">
						<img src="images\team\a.jpg" alt="" width="500" height="260" align ="center">
					</div>
				</div>

				<div class="testimonial-block style-2  gray-bg">
					
				<div class="client-info">
						<img src="images\team\b.jpg" alt="" width="500" height="260" align ="center">
					</div>
					
					<i class="icofont-quote-right"></i>
				</div>

				<div class="testimonial-block style-2  gray-bg">
					
					<div class="client-info">
						<img src="images\team\c.jpg" alt="" width="500" height="260" align ="center">
					</div>
					
					<i class="icofont-quote-right"></i>
				</div>

				<div class="testimonial-block style-2  gray-bg">
			
					<div class="client-info">
						<img src="images\team\d.jpg" alt="" width="500" height="260" align ="center">
					</div>
					<i class="icofont-quote-right"></i>
				</div>

				<div class="testimonial-block style-2  gray-bg">

					<div class="client-info">
						<img src="images\team\5.jpg" alt="" width="500" height="260" align ="center">
					</div>
					<i class="icofont-quote-right"></i>
				</div>
				
				<div class="testimonial-block style-2  gray-bg">

					<div class="client-info">
						<img src="images\team\6.jpg" alt="" width="500" height="260" align ="center">
					</div>
					<i class="icofont-quote-right"></i>
				</div>

				<div class="testimonial-block style-2  gray-bg">

					<div class="client-info">
						<img src="images\team\7.jpg" alt="" width="500" height="260" align ="center">
					</div>
					<i class="icofont-quote-right"></i>
				</div>
			</div>
		</div>
		<?php include './contactUs.php'; ?>
	</div>
</section>
<!-- footer Start -->
<?php include('./footer.php')?>

<!-- chatbot -->
<iframe
src="https://www.chatbase.co/chatbot-iframe/gmfAkIeKqf6Q6Rut1Sb1u"
title="Red Drop Assistant "
width="0"
style="height: 0; min-height:0"
frameborder="0"></iframe>




   

    <!-- 
    Essential Scripts
    =====================================-->

    
    <!-- Main jQuery -->
    <script src="plugins/jquery/jquery.js"></script>
    <!-- Bootstrap 4.3.2 -->
    <script src="plugins/bootstrap/js/popper.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/counterup/jquery.easing.js"></script>
    <!-- Slick Slider -->
    <script src="plugins/slick-carousel/slick/slick.min.js"></script>
    <!-- Counterup -->
    <script src="plugins/counterup/jquery.waypoints.min.js"></script>
    
    <script src="plugins/shuffle/shuffle.min.js"></script>
    <script src="plugins/counterup/jquery.counterup.min.js"></script>
    <!-- Google Map -->
    <!-- <script src="plugins/google-map/map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeLMlsiwzp6b3Gnaxd86lvakimwGA6UA&callback=initMap"></script>     -->
    
    <script src="js/script.js"></script>
    <script src="js/contact.js"></script>


  </body>
  </html>
   