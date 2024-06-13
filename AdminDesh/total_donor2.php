<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "totaldonor-data_" . date('Y-m-d') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('DONOR ID', 'MEMBER NAME','DONATION STATUS'); 

// Fetch records from database and store in an array 
$query = $db->query("SELECT m.name, d.* FROM donors d LEFT JOIN members m ON m.member_id = d.member_id"); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['donor_id'], $row['name'], $row['donation_status']); 
        $excelData[] = $lineData; 
    } 
} 
 
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>
