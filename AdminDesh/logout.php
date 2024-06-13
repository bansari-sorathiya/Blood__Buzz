<?php
session_start();
unset($_SESSION['email']);
header("location:index.php");
// print_r($_SESSION['email']);
?>