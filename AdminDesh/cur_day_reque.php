<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "currentdayrequest-data_" . date('Y-m-d') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('REQUEST ID','MEMBER NAME', 'PATIENT NAME','BLOOD ID', 'CREATED AT'); 

// Fetch records from database and store in an array 
$query = $db->query("SELECT m.name, r.*  FROM requester r  JOIN members m ON r.member_id = m.member_id 
WHERE DATE(r.created_at) = CURDATE()"); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['request_id'],$row['name'], $row['patient_name'], $row['blood_id'], $row['created_at']); 
        $excelData[] = $lineData; 
    } 
} 
 
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>
