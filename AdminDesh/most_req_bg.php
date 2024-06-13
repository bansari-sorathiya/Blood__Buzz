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
$fileName = "mostreqbgrp-data_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('REQUEST ID','MEMBER NAME', 'PATIENT NAME', 'CREATED AT','BLOOD GROUP'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = $db->query("SELECT r.request_id, m.name, r.patient_name, r.created_at, bg.blood_grp FROM requester r JOIN members m ON r.member_id = m.member_id 
JOIN blood_group bg ON r.blood_id = bg.blood_id JOIN ( SELECT bg.blood_grp, COUNT(*) AS request_count FROM requester r JOIN blood_group bg ON r.blood_id = bg.blood_id 
GROUP BY bg.blood_grp ORDER BY request_count DESC LIMIT 1 ) AS most_requested ON bg.blood_grp = most_requested.blood_grp"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['request_id'],$row['name'], $row['patient_name'], $row['created_at'], $row['blood_grp']); 
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