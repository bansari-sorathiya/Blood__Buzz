<?php 
include './redirect.php';
include '../include/connect2.php';
if(isset($_REQUEST['submit']))
{
    
    $email=$_POST['email'];
    $pwd=$_POST['pwd'];
    $confirm_pwd=$_POST['cpwd'];
    $token=md5(rand());

    try
   {
      $check_admin=$connection->prepare("SELECT * FROM admin_login where email= ?");
      $check_admin->execute([$email]);
      $admin=$check_admin->fetch();
      if($check_admin->rowcount() > 0)
      {
         // echo"User Already Exists...!";
         $_SESSION['add-error-message']="Admin Already Exists...!";
      }
      else
      {
         if($pwd==$confirm_pwd)
         {
            if(!empty($_FILES['img']['name']))
            {
                $img=$_FILES['img']['name'];
                $tmp=$_FILES['img']['tmp_name'];
               $add_admin=$connection->prepare("INSERT INTO admin_login (login_id,email,pwd,verify_token,img) VALUES (?,?,?,?,?)");
               $add_admin->execute([null,$email,$pwd,$token,$img]); 
               move_uploaded_file("$tmp","../img/".$img);
            }
            else
            {
               $add_admin=$connection->prepare("INSERT INTO admin_login (login_id,email,pwd,verify_token) VALUES (?,?,?,?)");
               $add_admin->execute([null,$email,$pwd,$token]); 
            }
            //check query
            if($add_admin->rowCount() > 0) 
            {
               $_SESSION['add-message']="Admin added successfully";
               // exit(0);
               // header("refresh:1;url=dashboard.php");
            } 
            else
            {
               $_SESSION['add-error-message']="Failed to add user.";
            }
         }
         else
         {
            $_SESSION['add-error-message']="Confirm Password Should Match.";
         }
      }
   } 
   catch (PDOException $e) 
   {
      // Handle query errors
      $error=$e->getMessage();
      $_SESSION['add-error-message'] = "Database error: " . $error;
   }
   header("location:addAdmin.php");
}
?>
