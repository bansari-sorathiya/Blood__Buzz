<?php 
session_start();
//include './header2.php';
include './nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">


<title>Blood Buzz-FAQ Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style type="text/css">
/* body{margin-top:20px;} */
.section_padding_130 {
    padding-top: 130px;
    padding-bottom: 130px;
}
.faq_area {
    position: relative;
    z-index: 1;
    /* background-color:#ffdade; */
    background-image:url('../img/faq.jpg');
    background-repeat:no-repeat;
    background-size:125%;
}

.faq-accordian {
    position: relative;
    z-index: 1;
}
.faq-accordian .card {
    position: relative;
    z-index: 1;
    margin-bottom: 1.5rem;
}
.faq-accordian .card:last-child {
    margin-bottom: 0;
}
.faq-accordian .card .card-header {
    background-color: #ffffff;
    padding: 0;
    border-bottom-color: #ebebeb;
}
.faq-accordian .card .card-header h6 {
    cursor: pointer;
    padding: 1.75rem 2rem;
    color: #3f43fd;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -ms-grid-row-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
}
.faq-accordian .card .card-header h6 span {
    font-size: 1.5rem;
}
.faq-accordian .card .card-header h6.collapsed {
    color: #070a57;
}
.faq-accordian .card .card-header h6.collapsed span {
    -webkit-transform: rotate(-180deg);
    transform: rotate(-180deg);
}
.faq-accordian .card .card-body {
    padding: 1.75rem 2rem;
}
.faq-accordian .card .card-body p:last-child {
    margin-bottom: 0;
}

@media only screen and (max-width: 575px) {
    .support-button p {
        font-size: 14px;
    }
}

.support-button i {
    color: #3f43fd;
    font-size: 1.25rem;
}
@media only screen and (max-width: 575px) {
    .support-button i {
        font-size: 1rem;
    }
}

.support-button a {
    text-transform: capitalize;
    color: #2ecc71;
}
@media only screen and (max-width: 575px) {
    .support-button a {
        font-size: 13px;
    }
}

    </style>
</head>
<body>
<div class="faq_area section_padding_130" id="faq">
<div class="container">
<div class="row justify-content-center">
<div class="col-12 col-sm-8 col-lg-6">
<center><img src="../img/faq.png" style="width:70%;height:70%;margin-top:-80px;" alt="error"></center><br>
<div class="section_heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
<h3><span>Frequently </span> Asked Questions</h3>
<p>Some questions that we have often received via Contact Us.</p>
<div class="line"></div>
</div>
</div>
</div>
<div class="row justify-content-center">

<div class="col-12 col-sm-10 col-lg-8">
<div class="accordion faq-accordian" id="faqAccordion">
<div class="card border-0 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
<div class="card-header" id="headingOne">
<h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">What is Blood Buzz?<span class="lni-chevron-up"></span></h6>
</div>
<div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#faqAccordion">
<div class="card-body">
<p>Blood Buzz helps patients as well as blood banks that require blood in emergencies.</p>
<p>Details about Blood Buzz are available at Blood Buzz <a href="./aboutUs.php" style="color:red;"> About Us </a>Page.</p>
</div>
</div>
</div>



<div class="card border-0 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
<div class="card-header" id="headingTwo">
<h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">How does age affects my ability to donate blood?<span class="lni-chevron-up"></span></h6>
</div>
<div class="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#faqAccordion">
<div class="card-body">
<p>Minimum age for whole blood donation is <b>18 years</b> in India. The maximum age for blood donation depends on the kind of donation.</p>
</div>
</div>
</div>



<div class="card border-0 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
<div class="card-header" id="headingThree">
<h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">I had alcohol before going to donate blood. Is it Okay?<span class="lni-chevron-up"></span></h6>
</div>
<div class="collapse" id="collapseThree" aria-labelledby="headingThree" data-parent="#faqAccordion">
<div class="card-body">
<p>No. We do not take blood from anyone under the influence of alcohol. This is because being intoxicated can affect your ability to understand and answer the donor questionnaire and declaration.</p>
<p>Avoid to drink alcohol before donating blood.</p>
</div>
</div>
</div>



<div class="card border-0 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
<div class="card-header" id="headingFour">
<h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">I am taking antibiotics. Can I donate blood?<span class="lni-chevron-up"></span></h6>
</div>
<div class="collapse" id="collapseFour" aria-labelledby="headingFour" data-parent="#faqAccordion">
<div class="card-body">
<p>It depends on why you are taking the antibiotics and it may also depend after doctor counselling.</p>
</div>
</div>
</div>



<div class="card border-0 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
<div class="card-header" id="headingFive">
<h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">Are there any side effects of Blood donations?<span class="lni-chevron-up"></span></h6>
</div>
<div class="collapse" id="collapseFive" aria-labelledby="headingFive" data-parent="#faqAccordion">
<div class="card-body">
<p>There are no side effects of blood donation. The blood bank staff ensures that your blood donation is a good experience so as to make you a regular blood donor.</p>
<p> There are a number of people who have donated more than 25-100 times in their entire lifetime.</p>
</div>
</div>
</div>



<div class="card border-0 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
<div class="card-header" id="headingSix">
<h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">How often can I donate Blood ?<span class="lni-chevron-up"></span></h6>
</div>
<div class="collapse" id="collapseSix" aria-labelledby="headingSix" data-parent="#faqAccordion">
<div class="card-body">
<p>After every three or four months you can donate blood.</p>
</div>
</div>
</div>


<div class="card border-0 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
<div class="card-header" id="headingSeven">
<h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">What should I eat before blood-donation ?<span class="lni-chevron-up"></span></h6>
</div>
<div class="collapse" id="collapseSeven" aria-labelledby="headingSeven" data-parent="#faqAccordion">
<div class="card-body">
<p>Anything that you normally eat at home. Eating a light snacks and having a soft drink before blood donation is sufficient.</p>
</div>
</div>
</div>

<div class="card border-0 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
<div class="card-header" id="headingEight">
<h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="true" aria-controls="collapseEight">Compatible Blood Type Donors.<span class="lni-chevron-up"></span></h6>
</div>
<div class="collapse" id="collapseEight" aria-labelledby="headingEight" data-parent="#faqAccordion">
<div class="card-body">
<p><img src="../img/cblood.png" alt="error" style="margin-left:90px;"></p>
</div>
</div>
</div>

</div>

<div class="support-button text-center d-flex align-items-center justify-content-center mt-4 wow fadeInUp" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">
<p class="mb-0 px-2" style="font-size:15px;"><strong>Can't find your answers?</strong></p>
<a href="./contactus.php" style="color:red"> Contact us</a>
</div>
</div>
</div>
</div>
</div>

<?php include './footer.php'; ?>

<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	
</script>
</body>
</html>
