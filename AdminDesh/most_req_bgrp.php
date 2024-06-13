<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "mostreqbgrp-data_" . date('Y-m-d') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('REQUEST ID','MEMBER NAME', 'PATIENT NAME', 'CREATED AT','BLOOD GROUP'); 

// Fetch records from database and store in an array 
$query = $db->query("SELECT r.request_id, m.name, r.patient_name, r.created_at, bg.blood_grp FROM requester r JOIN members m ON r.member_id = m.member_id 
JOIN blood_group bg ON r.blood_id = bg.blood_id JOIN ( SELECT bg.blood_grp, COUNT(*) AS request_count FROM requester r JOIN blood_group bg ON r.blood_id = bg.blood_id 
GROUP BY bg.blood_grp ORDER BY request_count DESC LIMIT 1 ) AS most_requested ON bg.blood_grp = most_requested.blood_grp"); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['request_id'],$row['name'], $row['patient_name'], $row['created_at'], $row['blood_grp']); 
        $excelData[] = $lineData; 
    } 
} 
 
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>
