<?php 
// $connection=mysqli_connect("localhost","root","","blood") or die("Connection Established...!");
$db_name = 'mysql:host=localhost;dbname=blood';
$user_name = 'root';
$user_password = '';
try
{
    $connection=new PDO($db_name, $user_name, $user_password);
}
catch(PDOException $e)
{
    echo "Connection Failed...!".$e->getMessage();
    exit;
}
?>