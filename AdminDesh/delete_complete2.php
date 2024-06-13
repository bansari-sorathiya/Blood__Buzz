<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "DeleteRequest(Complete)-data_" . date('Y-m-d') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('REQUEST ID','MEMBER NAME', 'PATIENT NAME','BLOOD ID', 'CREATED AT'); 

// Fetch records from database and store in an array 
$query = $db->query("SELECT m.name, m.email, d.reason, d.created_at FROM members m
JOIN deleted_request d ON m.member_id = d.member_id WHERE d.reason = 'completed'"); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['name'], $row['email'], $row['reason'], $row['created_at']); 
        $excelData[] = $lineData; 
    } 
} 
 
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>
