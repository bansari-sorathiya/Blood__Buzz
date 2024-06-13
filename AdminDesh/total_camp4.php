<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$res=mysqli_query($connection,"SELECT m.name, c.*,ci.city_name,s.state_name FROM camp c LEFT JOIN members m ON m.member_id = c.member_id LEFT JOIN states s ON c.state_id = s.state_id LEFT JOIN city ci ON c.city_id = ci.city_id");
if(mysqli_num_rows($res)>0){
    $html='';
    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>Total camps report</h1><table cellspacing=70 cellpadding=70>';
    $html.='<tr><th><b>Member Name</b></th><th><b>Camp Name</b></th><th><b>Conducted By</b></th><th><b>Address</b></th><th><b>State Name</b></th><th><b>City Name</b></th><th><b>Email</b></th><th><b>Contact No</b></th><th>
    <b>Date</b></th><th><b>Sart Time</b></th><th><b>End Time</b></th><th><b>Created At</b></th></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['name'].'</td>
            <td>'.$row['camp_name'].'</td>
            <td>'.$row['conducted_by'].'</td>
            <td>'.$row['address'].'</td>
            <td>'.$row['state_name'].'</td>
            <td>'.$row['city_name'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['contact_no'].'</td>
            <td>'.$row['date'].'</td>
            <td>'.$row['start_time'].'</td>
            <td>'.$row['end_time'].'</td>
            <td>'.$row['created_at'].'</td></tr>';
    }
    $html.= '</table>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    // $file=time().'.pdf';
    $mpdf->output('Total camp report.pdf','D');
}
else{
    $html='No data found';
}
 echo $html;


?>
