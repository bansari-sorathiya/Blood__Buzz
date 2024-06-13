
<?php
// Include Composer's autoloader
include './redirect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';

$donorName = isset($_REQUEST['donor']) ? urldecode($_REQUEST['donor']) : 'Anonymous Donor';
$memberId=isset($_REQUEST['memberId']) ? urldecode($_REQUEST['memberId']) : 'Anonymous Donor';

// Create new mPDF instance
$mpdf = new \Mpdf\Mpdf();

// Set document properties
$mpdf->SetTitle('Certificate of Appreciation');
$mpdf->SetAuthor('Your Organization');
$mpdf->SetSubject('Certificate');
$mpdf->SetKeywords('Certificate, Appreciation');

// Start output buffering
ob_start();

// HTML content for the certificate
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Certificate of Appreciation</title>
<style>
    body { font-family: Arial, sans-serif;background:url(../img/bh2.jpg); }
    .container { width: 100%; text-align: center; }
    .certificate { border: 2px solid #333; padding: 20px; margin: 20px auto; max-width: 600px; }
    .header { margin-bottom: 20px; }
    .logo { width: 100px; }
    .thank-you { color: red; font-weight: bold;font-size:30px; }
    .paragraph { text-align: justify; margin-bottom: 20px; }
    .footer{text-align: right;color:red;font-weight: bold;}

    /* Responsive styles */
    @media only screen and (max-width: 600px)
    {
        .container
        {
            padding: 10px;
        }
    }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="../img/logo.png" alt="Blood Buzz Logo" class="logo"><br>
        <h1>Blood Buzz</h1>
    </div>
    <div class="certificate">
        <div class="thank-you">Thank you</div>
        <p class="paragraph">
            Dear ' . htmlspecialchars($donorName) . ',<br><br> Thank you for taking out time from your busy schedule to become a valuable part of the small percentage of the world donors.<br><br>
            Blood donation is the act of giving life. Your one hour spent in donating the blood is going to give life to someone in need. Your blood could save anyone from a little baby to an old individual. There\'s no doubt that the need is huge. However, the support of donors like you is helping us to make it possible to help the people in achieving a healthier, happier, and fruitful life.<br><br>In spite of the various reasons, for donating blood and encouraging others to do it, there are only few who actually do it. Thanks for being a part of this group. Your act of noble kindness of volunteering blood donation will serve as an inspiration to other people.<br><br>Have A Nice Rest Day.
        </p>
        <p class="footer">Team Blood Buzz</p>
    </div>
</div>
</body>
</html>
';

// Write HTML content to PDF
$mpdf->WriteHTML($html);

// End buffering and output PDF
ob_end_clean();

$pdfContent = $mpdf->Output('', 'S');
?>


<!-- get email from member id and sent pdf -->
<?php
    include '../Include/connect2.php';
    try
    {
        $getEmail=$connection->prepare("SELECT email FROM members WHERE member_id=?");
        $getEmail->execute([$memberId]);
        $donorEmailId=$getEmail->fetch(PDO::FETCH_ASSOC);

        if ($donorEmailId && isset($donorEmailId['email'])) {
            $recipientEmail = $donorEmailId['email'];

        //send email
        $mail = new PHPMailer(true);

        // Set up SMTP
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com'; // Your SMTP host
        $mail->Username   = 'bansarisorathiya74@gmail.com'; 
		$mail->Password   = "ckll maic lavq gyva";      
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        
        // Set email parameters
        $mail->setFrom('bansarisorathiya74@gmail.com', 'Blood Buzz');
        $mail->addAddress($recipientEmail); // User's email
        $mail->Subject = 'Certificate of Appreciation';
        $mail->Body = 'Dear ' . $donorName . ', please find the attached certificate.';
        $mail->addStringAttachment($pdfContent, 'certificate.pdf'); // Attach PDF content

        // Send email
        $mail->send();

        // Redirect user
        header("Location: deleteRequest.php?status=completed&method=ourSite&donor=$memberId&emailSent=true");
        exit;
    } 
    else 
    {
        // Handle case where email address is not found
        $_SESSION['error-message'] = "Email address not found for member ID: $memberId";
        header("Location: errorPage.php");
        exit;
    }
    }
    catch (PDOException $e) 
    {
        // Handle query errors
        $error=$e->getMessage();
        $_SESSION['error-message'] = "Database error: " . $error;
        print_r($_SESSION['error-message']);
    }


?>