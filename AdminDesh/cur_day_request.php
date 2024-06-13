<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$res=mysqli_query($connection,"SELECT m.name, r.*  FROM requester r  JOIN members m ON r.member_id = m.member_id 
WHERE DATE(r.created_at) = CURDATE()");
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

    
}
else{
    $html='No data found';
}
 echo $html;

 $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    // $file=time().'.pdf';
    $mpdf->output('Current day request report.pdf','D');

?>
