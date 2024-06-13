<?php 
// Load the database configuration file 
include_once 'dbconfig.php'; 
 
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "currentmonthrequest-data_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('REQUEST ID','MEMBER NAME', 'PATIENT NAME','BLOOD ID', 'CREATED AT'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = $db->query("SELECT m.name, r.* FROM requester r JOIN members m ON r.member_id = m.member_id WHERE MONTH(r.created_at) = MONTH(CURRENT_DATE) AND YEAR(r.created_at) = YEAR(CURRENT_DATE)"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['request_id'],$row['name'], $row['patient_name'], $row['blood_id'], $row['created_at']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;
?>