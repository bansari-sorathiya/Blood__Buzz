<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "totalcamp-data_" . date('Y-m-d') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('MEMBER NAME', 'CAMP NAME','CONDUCTED BY','ADDRESS','STATE NAME','CITY NAME','EMAIL','CONTACT NO','DATE','START TIME','END TIME', 'CREATED AT'); 

// Fetch records from database and store in an array 
$query = $db->query("SELECT m.name, c.*,ci.city_name,s.state_name FROM camp c LEFT JOIN members m ON m.member_id = c.member_id LEFT JOIN states s ON c.state_id = s.state_id LEFT JOIN city ci ON c.city_id = ci.city_id"); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['name'], $row['camp_name'], $row['conducted_by'],$row['address'],$row['state_name'],$row['city_name'],$row['email'],$row['contact_no'],$row['date'],$row['start_time'],$row['end_time'], $row['created_at']); 
        $excelData[] = $lineData; 
    } 
} 
 
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>
