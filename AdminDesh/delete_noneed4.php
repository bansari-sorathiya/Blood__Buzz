<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$res=mysqli_query($connection,"SELECT m.name, m.email, d.reason, d.created_at FROM members m
JOIN deleted_request d ON m.member_id = d.member_id WHERE d.reason = 'NoNeed'");
if(mysqli_num_rows($res)>0){
    $html='';
    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>Delete Request(noneed) report</h1><table cellspacing=70 cellpadding=70>';
    $html.='<tr><th><b>Member Name</b></th><th><b>Email</b></th><th><b>Reason</b></th><th><b>Created At</b></th></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['name'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['reason'].'</td>
            <td>'.$row['created_at'].'</td></tr>';
    }
    $html.= '</table>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    // $file=time().'.pdf';
    $mpdf->output('Delete Request(noneed) report.pdf','D');
}
else{
    $html='No data found';
}
 echo $html;


?>
