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
$fileName = "eligible-data_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('ELIGIBLE ID','MEMBER NAME', 'AGE','WEIGHT','TATTOO_TEST','HIV_TEST','BLOOD GROUP', 'MEDICAL_CONDITION','DONATION_STATUS'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = $db->query("SELECT m.name, e.*, d.donation_status,b.blood_grp FROM eligibility e JOIN donors d ON e.member_id = d.member_id JOIN members m ON e.member_id = m.member_id JOIN blood_group b ON b.blood_id = e.blood_id
WHERE d.donation_status = '1'"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['eligible_id'],$row['name'], $row['age'],  $row['weight'] ,$row['tattoo_test'], $row['hiv_test'],$row['blood_grp'], $row['medical_condition'], $row['donation_status']); 
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