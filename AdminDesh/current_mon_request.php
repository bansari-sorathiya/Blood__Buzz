<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$res=mysqli_query($connection,"SELECT m.name, r.* FROM requester r JOIN members m ON r.member_id = m.member_id WHERE MONTH(r.created_at) = MONTH(CURRENT_DATE) AND YEAR(r.created_at) = YEAR(CURRENT_DATE)");
if(mysqli_num_rows($res)>0){
    $html='';
    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>Current Month request report</h1><table cellspacing=70 cellpadding=70>';
    $html.='<tr><th><b>Request Id</b></th><th><b>Member Name</b></th><th><b>Patient Name</b></th><th><b>Blood Id</b></th><th><b>Created At</b></th></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['request_id'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['patient_name'].'</td>
            <td>'.$row['blood_id'].'</td>
            <td>'.$row['created_at'].'</td></tr>';
    }
    $html.= '</table>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    // $file=time().'.pdf';
    $mpdf->output('Current Month request report.pdf','D');
}
else{
    $html='No data found';
}
 echo $html;


?>
