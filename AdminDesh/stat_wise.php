<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "statewise-data_" . date('Y-m-d') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('REQUEST ID','MEMBER NAME', 'PATIENT NAME','BLOOD GROUP', 'CREATED AT','STATE NAME'); 

// Fetch records from database and store in an array 
$query = $db->query("SELECT s.state_name, m.name, b.blood_grp,r.* FROM members m JOIN requester r ON m.member_id = r.member_id JOIN states s ON m.state = s.state_id JOIN blood_group b ON r.blood_id = b.blood_id
ORDER BY s.state_name ASC "); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['request_id'],$row['name'], $row['patient_name'], $row['blood_grp'], $row['created_at'],$row['state_name']); 
        $excelData[] = $lineData; 
    } 
} 
 
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>
