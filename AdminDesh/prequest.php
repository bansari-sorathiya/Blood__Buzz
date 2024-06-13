
<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$sql="SELECT m.pincode, m.name,b.blood_grp, r.* FROM members m JOIN requester r ON m.member_id = r.member_id JOIN blood_group b ON b.blood_id = r.blood_id
ORDER BY m.pincode ASC";
$res=mysqli_query($connection,$sql);
if(mysqli_num_rows($res)>0){
    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>Pincode wise request report</h1><table cellspacing=70 cellpadding=70 align="center" >';
    $html.='<tr><th><b>Request Id</b></th><th><b>Member Name</b></th><th><b>Patient Name</b></th><th><b>Blood Group</b></th><th><b>Created At</b></th><th><b>Pincode</b></th></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['request_id'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['patient_name'].'</td>
            <td>'.$row['blood_grp'].'</td>
            <td>'.$row['created_at'].'</td>
            <td>'.$row['pincode'].'</td></tr>';
    }
    $html.= '</table>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    // $file=time().'.pdf';
    $mpdf->output('Pincode rise request report.pdf','D');
}
else{
    $html='No data found';
}
// echo $html;


?>
