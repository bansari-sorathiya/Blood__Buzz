<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "newuserlastmonthrequest-data_" . date('Y-m-d') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('REQUEST ID','MEMBER ID', 'PATIENT NAME','BLOOD ID', 'CREATED AT'); 

// Fetch records from database and store in an array 
$query = $db->query("SELECT * FROM requester where MONTH(created_at) = MONTH(CURRENT_DATE) - 1 AND YEAR(created_at) = YEAR(CURRENT_DATE)"); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['request_id'],$row['member_id'], $row['patient_name'], $row['blood_id'], $row['created_at']); 
        $excelData[] = $lineData; 
    } 
} 
 
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>
