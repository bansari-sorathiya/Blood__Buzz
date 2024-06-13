
<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$sql="SELECT * FROM requester WHERE MONTH(created_at) = MONTH(CURRENT_DATE) - 1 AND YEAR(created_at) = YEAR(CURRENT_DATE)";
$res=mysqli_query($connection,$sql);
if(mysqli_num_rows($res)>0){
    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>New-user from last month report</h1><table cellspacing=70 cellpadding=70 align="center" >';
    $html.='<tr><td><b>Request_id</b></td><td><b>Member_id</b></td><td><b>Patient_name</b></td><td><b>Blood_id</b></td><td><b>Created_at</b></td></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['request_id'].'</td>
            <td>'.$row['member_id'].'</td>
            <td>'.$row['patient_name'].'</td>
            <td>'.$row['blood_id'].'</td>
            <td>'.$row['created_at'].'</td></tr>';
    }
    $html.= '</table>';

    
}
else{
    $html='No data found';
}
// echo $html;

$mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    // $file=time().'.pdf';
    $mpdf->output('New user from last month report.pdf','D');

?>
