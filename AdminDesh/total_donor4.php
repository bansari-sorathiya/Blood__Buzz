<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$res=mysqli_query($connection,"SELECT m.name, d.* FROM donors d LEFT JOIN members m ON m.member_id = d.member_id");
if(mysqli_num_rows($res)>0){
    $html='';
    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>Total donor report</h1><table cellspacing=70 cellpadding=70>';
    $html.='<tr><th><b>Donor Id</b></th><th><b>Member Name</b></th><th><b>Donation Status</b></th></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['donor_id'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['donation_status'].'</td></tr>';
    }
    $html.= '</table>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    // $file=time().'.pdf';
    $mpdf->output('Total donor report.pdf','D');
}
else{
    $html='No data found';
}
 echo $html;


?>
