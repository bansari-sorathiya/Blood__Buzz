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
$fileName = "totalcamp-data_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('MEMBER NAME', 'CAMP NAME','CONDUCTED BY','ADDRESS','STATE NAME','CITY NAME','EMAIL','CONTACT NO','DATE','START TIME','END TIME', 'CREATED AT'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = $db->query("SELECT m.name, c.*,ci.city_name,s.state_name FROM camp c LEFT JOIN members m ON m.member_id = c.member_id LEFT JOIN states s ON c.state_id = s.state_id LEFT JOIN city ci ON c.city_id = ci.city_id"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['name'], $row['camp_name'], $row['conducted_by'],$row['address'],$row['state_name'],$row['city_name'],$row['email'],$row['contact_no'],$row['date'],$row['start_time'],$row['end_time'], $row['created_at']); 
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