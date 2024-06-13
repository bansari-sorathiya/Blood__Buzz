<?php
session_start();
print_r($_SESSION);
unset($_SESSION['member_email']);
header("location:index.php");
?>