
<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$sql="SELECT b.blood_grp, m.name, r.* FROM members m JOIN requester r ON m.member_id = r.member_id JOIN blood_group b ON r.blood_id = b.blood_id";
$res=mysqli_query($connection,$sql);
if(mysqli_num_rows($res)>0){
    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>Total request report</h1><table cellspacing=70 cellpadding=70 align="center" >';
    $html.='<tr><th><b>Request Id</b></th><th><b>Member Name</b></th><th><b>Patient Name</b></th><th><b>Blood Group</b></th><th><b>Created At</b></th></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['request_id'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['patient_name'].'</td>
            <td>'.$row['blood_grp'].'</td>
            <td>'.$row['created_at'].'</td></tr>';
    }
    $html.= '</table>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    // $file=time().'.pdf';
    $mpdf->output('State rise request report.pdf','D');
}
else{
    $html='No data found';
}
// echo $html;


?>

