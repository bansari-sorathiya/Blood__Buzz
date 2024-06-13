<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "OngoingCamps_" . date('Y-m-d') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('CAMP ID','MEMBER NAME', 'CAMP NAME','CONDUCTED BY','ADDRESS','STATE','CITY','EMAIL','CONTACT NO','DATE','START TIME','END TIME', 'REQUESTED AT'); 

// Fetch records from database and store in an array 
$query = $db->query("SELECT * ,m.name, s.state_name,ci.city_name FROM camp c JOIN members m On m.member_id = c.member_id JOIN states s ON s.state_id = c.state_id JOIN city ci ON ci.city_id = c.city_id WHERE status = '1'"); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['camp_id'],$row['name'], $row['camp_name'], $row['conducted_by'], $row['address'], $row['state_name'],$row['city_name'], $row['contact_no'],$row['date'],$row['start_time'],$row['end_time'],$row['status'], $row['created_at']); 
        $excelData[] = $lineData; 
    } 
} 
 
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>
