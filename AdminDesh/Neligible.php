<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$sql="SELECT m.name, e.*, d.donation_status,b.blood_grp FROM eligibility e JOIN donors d ON e.member_id = d.member_id JOIN members m ON e.member_id = m.member_id JOIN blood_group b ON b.blood_id = e.blood_id
WHERE d.donation_status = '0'";
$res=mysqli_query($connection,$sql);
if(mysqli_num_rows($res)>0){

    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>Non-Eligible donors report</h1><table cellspacing=70 cellpadding=70>';
    $html.='<tr><th><b>Eligible Id</b></h><th><b>Member Name</b></th><th><b>Age</b></th><th><b>Weight</b></th><th><b>Tattoo Test</b></th>
<th><b>Hiv Test</b></th><th><b>Blood Group</b></th><th><b>Medical Condition</b></th><th><b>Donation Status</b></th></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['eligible_id'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['age'].'</td>
            <td>'.$row['weight'].'</td>
            <td>'.$row['tattoo_test'].'</td>
            <td>'.$row['hiv_test'].'</td>
            <td>'.$row['blood_grp'].'</td>
            <td>'.$row['medical_condition'].'</td>
            <td>'.$row['donation_status'].'</td></tr>';
    }
    $html.= '</table>';

    
}
else
{
    $html='No Request Found...';
}
echo $html;

$mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    // $file=time().'.pdf';
    $mpdf->output('Non-Eligible donors report.pdf','D');
?>
