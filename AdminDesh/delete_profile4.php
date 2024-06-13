<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$res=mysqli_query($connection,"SELECT d.*,c.city_name,s.state_name FROM  deleted_profile d JOIN city c ON c.city_id = d.city JOIN states s ON s.state_id = d.state");
if(mysqli_num_rows($res)>0){
    $html='';
    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>Delete Request(noneed) report</h1><table cellspacing=70 cellpadding=70>';
    $html.='<tr><th><b>Member Name</b></th><th><b>Contact NO</b></th><th><b>Email</b></th><th><b>City Name</b></th><th><b>State Name</b></th></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['member_name'].'</td>
            <td>'.$row['contact_no'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['city_name'].'</td>
            <td>'.$row['state_name'].'</td></tr>';
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
