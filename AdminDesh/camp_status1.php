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
$fileName = "OngoingCamps_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('CAMP ID','MEMBER NAME', 'CAMP NAME','CONDUCTED BY','ADDRESS','STATE','CITY','EMAIL','CONTACT NO','DATE','START TIME','END TIME', 'CREATED AT'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = $db->query("SELECT * ,m.name, s.state_name,ci.city_name FROM camp c JOIN members m On m.member_id = c.member_id JOIN states s ON s.state_id = c.state_id JOIN city ci ON ci.city_id = c.city_id WHERE status = '1'"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['camp_id'],$row['name'], $row['camp_name'], $row['conducted_by'], $row['address'], $row['state_name'],$row['city_name'], $row['email'], $row['contact_no'],$row['date'],$row['start_time'],$row['end_time'], $row['created_at']); 
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