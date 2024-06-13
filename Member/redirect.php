<?php 
session_start();
if((!isset($_SESSION['member_email'])))
{
    header("location:loginFirst.php");
    exit(0);
}

?>