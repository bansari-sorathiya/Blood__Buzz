<?php
$sessionLifetime = 86400; // 1 day in seconds
session_set_cookie_params($sessionLifetime);
include './redirect.php';
include '../Include/connect2.php';
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$email=$_SESSION['member_email'];

$get_user=$connection->prepare("SELECT member_id FROM members WHERE email=?");
$get_user->execute([$email]);
$mid=$get_user->fetchColumn();

$get_requests=$connection->prepare("SELECT r.*,m.name,b.blood_grp FROM requester r JOIN members m ON r.member_id=m.member_id JOIN blood_group b ON b.blood_id=r.blood_id WHERE r.member_id=?");
$get_requests->execute([$mid]);
$requests=$get_requests->fetchAll(PDO::FETCH_ASSOC);

try
{
    foreach($requests as $row)
    { 
        $name=$row['name'];
        $patient_name=$row['patient_name'];
        $group=$row['blood_grp'];
        $request_id=$row['request_id'];
        $member_id=$row['member_id'];
        // echo $patient_name;

        // Send email to user using PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com'; // Your SMTP host
        $mail->Username   = 'bansarisorathiya74@gmail.com'; 
        $mail->Password   = "ckll maic lavq gyva";      
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->setFrom('bansarisorathiya74@gmail.com', 'Blood Buzz'); 
        $mail->addAddress($email, $name);  

        $mail->isHTML(true);
        // Given timestamp
        $timestamp = $row['created_at'];
        $date = date_create($timestamp);
        $d=$date->format('Y-m-d');
        
        // Get today's date
        $today = new DateTime();
        // Add 2 days to the extracted date
        // $date->modify('+2 days');
        
        //to subtract days
        $interval = $today->diff($date);
        $daysDifference = $interval->days;
        if ($daysDifference >= 2)
        {        
            if (!isset($_SESSION['reminder_sent'][$request_id]))
            {
            // echo "Today's date is 2 days ahead of the given date.";
            $mail->Subject = 'Blood Request Reminder!!';

            $mail->Body = "
            <html>
            <head>
                <title>Its a reminder of your blood request.</title>
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
            <h2 style='font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px;'>Reminder🔔</h2>

            <hr style='border: 1px solid #ccc; margin-bottom: 20px;' />
            <div style='margin-top: 20px; text-align: justify;'>
                <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>Hello,$name</p>
                <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>Its a friendly reminder about the blood request for $patient_name($group&nbsp;Group)you sent on $d .We are glad and hope your request will fulfill soon.</p>

                <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>Your blood request will be deactivate within <b>7 Days</b> from $d.If your request is satisfied you can<a href='http://localhost/Blood/Member/myRequest.php'> Delete </a>it.Don't worry if your request deactivates you can make same request again.</p>

                <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>Thank you,</p>
                <p style='font-size: 16px; line-height: 1.5; margin-bottom: 0;'>Blood Buzz Team</p>
            </div>
        </div>
            </body>
            </html>
            ";

            $mail->send();
            $_SESSION['reminder_sent'][$request_id] = true;
            }
        }
        else
        {
            if($daysDifference >= 7)
            {
                if (!isset($_SESSION['deactivate_sent'][$request_id]))
                {
                // echo "7 Days Ahead";
                $mail->Subject = 'Blood Request Deactivated';

                $mail->Body = "
                <html>
                <head>
                    <title>Your Blood Request has been Deactivated.</title>
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

                <h2 style='font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px;'>Request Deactivated</h2>
                <hr style='border: 1px solid #ccc; margin-bottom: 20px;' />
                <div style='margin-top: 20px; text-align: justify;'>
                    <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>Hello,$name</p>
                    <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>We regret to inform you that your Blood Request has been deactivated that was created on $d.</p>

                    <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>Your Blood Request for $patient_name($group &nbsp;Group) has been deactivated. We have sent you reminder about it also.If you have any further questions or require assistance, feel free to reach out to us.
                    If your request is not satisfied,you can make same request again.</p>
                    <p style='font-size: 16px; line-height: 1.5; margin-bottom: 20px;'>Thank you,</p>
                    <p style='font-size: 16px; line-height: 1.5; margin-bottom: 0;'>Blood Buzz Team</p>
                </div>
                </div>
                </body>
                </html>
                ";
                $mail->send();
                $_SESSION['deactivate_sent'][$request_id] = true;
                
                //to delete it
                

                $delete_request=$connection->prepare("DELETE FROM requester WHERE request_id=?");
                $delete_request->execute([$request_id]);

                //insert into deleted request
                date_default_timezone_set('Asia/Kolkata');
                $datetime=date('Y/m/d h:i:s');
                $insert_request=$connection->prepare("INSERT INTO deleted_request(request_id,member_id,reason,created_at) VALUES(?,?,?,?)");
                $insert_request->execute([$request_id,$member_id,'deactivate',$datetime]);

                }
            }
        }
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