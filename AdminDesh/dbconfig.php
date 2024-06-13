<?php

$dbHost = "localhost";
$dbUsername = 'root';
$dbPassword = '';
$dbName="blood";

$db=new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
if($db->connect_error){
    die("connection failed...".$db->connect_error);
}

?>