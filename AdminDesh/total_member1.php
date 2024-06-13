<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "totalmember-data_" . date('Y-m-d') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('MEMBER ID', 'IMAGE','EMAIL','PASSWORD','VERIFY TOKEN','MEMBER NAME','CONTACT NO','GENDER','DATE OF BIRTH','ADDRESS','CITY NAME','STATE NAME','LANDMARK','PINCODE','CREATED AT'); 

// Fetch records from database and store in an array 
$query = $db->query("SELECT c.city_name , s.state_name , m.* FROM members m JOIN city c ON c.city_id = m.city JOIN states s ON s.state_id = m.state"); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['member_id'], $row['img'], $row['email'], $row['pwd'], $row['verify_token'], $row['name'],
            $row['contact_no'], $row['gender'], $row['dob'], $row['address'], $row['city_name'], $row['state_name'], $row['landmark'], $row['pincode'], $row['created_at']); 
        $excelData[] = $lineData; 
    } 
} 
 
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>
