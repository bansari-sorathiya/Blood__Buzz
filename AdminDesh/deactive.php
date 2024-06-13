<?php
include './redirect.php';
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

try
{
    include '../Include/connect2.php';
    if(isset($_REQUEST['mid']))
    {
        $decryptedMid=base64_decode($_REQUEST['mid']);
        // echo $decryptedMid;
    
        $get_user = $connection->prepare("SELECT * FROM members WHERE member_id=? LIMIT 1");
        $get_user->execute([$decryptedMid]);
        $data = $get_user->fetch(PDO::FETCH_ASSOC);

        $name = $data['name'];
        $cno = $data['contact_no'];
        $city = $data['city'];
        $state = $data['state'];
        $email=$data['email'];

        // Delete profile
        $delete_profile = $connection->prepare("UPDATE members SET member_status=? WHERE member_id=?");
        $delete_profile->execute(['2',$decryptedMid]);

        if ($delete_profile->rowCount() <= 0) 
        {
            $_SESSION['deactive-profile-error-message'] = "Failed to delete profile";
        } 
        else
        {

            // Send email to user using PHPMailer
            $mail = new PHPMailer(true);
            
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = 'smtp.gmail.com'; // Your SMTP host
            $mail->Username   = 'bansarisorathiya74@gmail.com'; 
            $mail->Password   = "ckll maic lavq gyva";      
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;

            $mail->setFrom('bansarisorathiya74@gmail.com', 'Blood Buzz'); // Sender's email and name
            $mail->addAddress($email, $name);  // Recipient's email and name

            $mail->isHTML(true);
            $mail->Subject = 'Your Profile has been deactivated';

            // Email body with responsive design
            $mail->Body = "<html>
            <head>
                <title>Your Profile Violated Terms and Conditions</title>
                <style>
                    /* Responsive styles */
                    @media only screen and (max-width: 600px) {
                        .container {
                            padding: 10px;
                        }
                    }
                </style>
            </head>
            <body>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; font-family: Arial, sans-serif;'>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <img src='https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcStdj407c7vChyBW5_cHOgdZO6dK3vtp7s6KFeTDXRHfFkgSP_i' alt='Blood Buzz Logo' style='width: 100px; height: 80px;'>
                </div>
                <h1 style='text-align: center; color: #c21807; font-size: 28px; font-weight: bold; margin-bottom: 20px;'>Blood Buzz</h1>
                <h2 style='font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px;'>Profile Violation Notice</h2>
                <hr style='border: 1px solid #ccc; margin-bottom: 20px;' />
                <div style='margin-top: 20px; text-align: justify;'>
                    <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>Hello,</p>
                    <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>We regret to inform you that your Blood Buzz profile has been deleted due to violation of our terms and conditions.</p>
                    <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>If you believe this action was taken in error, please contact support immediately for further assistance.</p>
                    <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>Thank you for your understanding.</p>
                    <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>Blood Buzz Team</p>
                </div>
            </div>
            </body>
            </html>
            ";
            $mail->send();
        }
    }
}
catch (PDOException $e) 
{
    // Handle query errors
    $error=$e->getMessage();
    $_SESSION['deactive-profile-error-message'] = "Database error: " . $error;
}
header("location:manageMember.php");

?>





