<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "eligible-data_" . date('Y-m-d') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('ELIGIBLE ID','MEMBER NAME', 'AGE','WEIGHT','TATTOO_TEST','HIV_TEST','BLOOD GROUP', 'MEDICAL_CONDITION','DONATION_STATUS'); 

// Fetch records from database and store in an array 
$query = $db->query("SELECT m.name, e.*, d.donation_status,b.blood_grp FROM eligibility e JOIN donors d ON e.member_id = d.member_id JOIN members m ON e.member_id = m.member_id JOIN blood_group b ON b.blood_id = e.blood_id
WHERE d.donation_status = '1'"); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['eligible_id'],$row['name'], $row['age'],  $row['weight'] ,$row['tattoo_test'], $row['hiv_test'],$row['blood_grp'], $row['medical_condition'], $row['donation_status']); 
        $excelData[] = $lineData; 
    } 
} 
 
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>
