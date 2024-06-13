<?php 
session_start();
ob_start();
?>


<?php

try
{
	include('../Include/connect2.php');
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	//fullname
	$fullname=$fname.' '.$lname;
	$email=$_POST['email'];
	$pwd=$_POST['pwd'];
	$token=md5(rand());
	$cpwd=$_POST['cpwd'];
	$cno=$_POST['cno'];
	$gen=$_POST['gen'];
	$dob=$_POST['dob'];
	$add=$_POST['add'];
	$city=$_POST['city'];
	$state=$_POST['state'];
	$ldmk=$_POST['ldmk'];
	$pin=$_POST['pin'];

	$check_user = $connection->prepare("SELECT email FROM members WHERE email=? AND member_status  IN (?) LIMIT 1");
	$check_user->execute([$email,'1']);

	$check_status=$connection->prepare("SELECT email FROM members WHERE email=? AND member_status=? LIMIT 1");
	$check_status->execute([$email,'2']);
	
	if($check_user->rowCount() > 0)
	{
		$_SESSION['signup-error-message'] = "User Already Exists";
	}
	elseif($check_status->rowCount() > 0)
	{
		$_SESSION['signup-error-message'] = "This Email Id was prohibated due to violation";
	}
	
	elseif(!preg_match('/[A-Z]/', $pwd)) {
        $_SESSION['signup-error-message'] = "Password must contain at least one uppercase letter.";
    }
	// Check if password contains at least one special character
	elseif(!preg_match('/[!@#$%^&*()_+\-=\[\]{};\\|,.<>\/?]/', $pwd)) {
		$_SESSION['signup-error-message'] = "Password must contain at least one special character.";
	}
	else
	{
		if($pwd!=$cpwd)
		{
			$_SESSION['signup-error-message'] = "Confirm Password Should Match";
		}
		else
		{
			date_default_timezone_set('Asia/Kolkata');
	        $datetime=date('Y/m/d h:i:s');

			if((isset($_FILES['pfp']['name'])) && (isset($_FILES['pfp']['name'])!=null))
			{
				$img=$_FILES['pfp']['name'];
				$tmp=$_FILES['pfp']['tmp_name'];
				$insert_user=$connection->prepare("INSERT INTO members VALUES(null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$insert_user->execute([$img,$email,$pwd,$token,$fullname,$cno,$gen,$dob,$add,$city,$state,$ldmk,$pin,'1',$datetime]);
				move_uploaded_file($tmp,"../img/".$img);
			}
			else
			{
				$insert_user=$connection->prepare("INSERT INTO members VALUES(null,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$insert_user->execute([$email,$pwd,$token,$fullname,$cno,$gen,$dob,$add,$city,$state,$ldmk,$pin,'1',$datetime]);
			}

			if($insert_user->rowCount() > 0)
			{
				$_SESSION['signup-message'] = "Sign Up Successfully";
			}
			else
			{
				$_SESSION['signup-error-message'] = "Database Error" . $e;
			}
		}
	}

}
catch (PDOException $e) 
{
	// Handle query errors
	$error=$e->getMessage();
	$_SESSION['signup-error-message'] = "Database error: " . $e;
	print_r($_SESSION);
}

header("Location:signup.php");
?>