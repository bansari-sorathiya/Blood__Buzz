<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$res=mysqli_query($connection,"SELECT m.name, r.* FROM requester r JOIN members m ON r.member_id = m.member_id JOIN blood_group b ON b.blood_id = r.blood_id WHERE MONTH(r.created_at) = MONTH(CURRENT_DATE) - 1 AND YEAR(r.created_at) = YEAR(CURRENT_DATE)");
if(mysqli_num_rows($res)>0){
    $html='';
    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>Last Month request report</h1><table cellspacing=70 cellpadding=70>';
    $html.='<tr><th><b>Request Id</b></th><th><b>Member Name</b></th><th><b>Patient Name</b></th><th><b>Blood Group</b></th><th><b>Created At</b></th></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['request_id'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['patient_name'].'</td>
            <td>'.$row['blood_grp'].'</td>
            <td>'.$row['created_at'].'</td></tr>';
    }
    $html.= '</table>';
}
else{
    $html='No data found';
}
 echo $html;

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
// $file=time().'.pdf';
$mpdf->output('Last Month request report.pdf','D');
?>
