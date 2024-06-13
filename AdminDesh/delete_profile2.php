<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "DeleteProfileRecord-data_" . date('Y-m-d') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('MEMBER NAME', 'CONTACT NO','EMAIL','CITY NAME', 'STATE NAME'); 

// Fetch records from database and store in an array 
$query = $db->query("SELECT d.*,c.city_name,s.state_name FROM  deleted_profile d JOIN city c ON c.city_id = d.city JOIN states s ON s.state_id = d.state"); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['member_name'], $row['contact_us'], $row['email'],$row['city_name'], $row['state_name']); 
        $excelData[] = $lineData; 
    } 
} 
 
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>
