
<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$sql="SELECT r.request_id, m.name, r.patient_name, r.created_at, bg.blood_grp FROM requester r JOIN members m ON r.member_id = m.member_id 
JOIN blood_group bg ON r.blood_id = bg.blood_id JOIN ( SELECT bg.blood_grp, COUNT(*) AS request_count FROM requester r JOIN blood_group bg ON r.blood_id = bg.blood_id 
GROUP BY bg.blood_grp ORDER BY request_count DESC LIMIT 1 ) AS most_requested ON bg.blood_grp = most_requested.blood_grp";
$res=mysqli_query($connection,$sql);
if(mysqli_num_rows($res)>0){
    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>Most Requested blood group report</h1><table cellspacing=70 cellpadding=70 align="center" >';
    $html.='<tr><th><b>Request Id</b></th><th><b>Member Name</b></th><th><b>Patient Name</b></th><th><b>Created At</b></th><th><b>Blood Group</b></th></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['request_id'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['patient_name'].'</td>
            <td>'.$row['created_at'].'</td>
            <td>'.$row['blood_grp'].'</td></tr>';
    }
    $html.= '</table>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    // $file=time().'.pdf';
    $mpdf->output('Most Requested blood group report.pdf','D');
}
else{
    $html='No data found';
}
// echo $html;


?>
