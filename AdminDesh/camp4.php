
<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$sql="SELECT * ,m.name, s.state_name,ci.city_name FROM camp c JOIN members m On m.member_id = c.member_id JOIN states s ON s.state_id = c.state_id JOIN city ci ON ci.city_id = c.city_id WHERE status = '0'";
$res=mysqli_query($connection,$sql);
if(mysqli_num_rows($res)>0){
    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>Expired Camps</h1><table cellspacing=70 cellpadding=70 align="center" >';
  $html.='<tr><th><b>Camp Id</b></th><th><b>Member Name</b></th><th><b>Camp Name</b></th><th><b>Conducted By</b></th><th><b>Address</b></th><th><b>State</b></th><th><b>City</b></th>
  <th><b>Email</b></th><th><b>Contact No</b></th><th><b>Date</b></th><th><b>Start Time</b></th><th><b>End Time</b></th><th><b>Status</b></th><th><b>Created At</b></th></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['camp_id'].'</td>
        <td>'.$row['name'].'</td>
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
        <td>'.$row['status'].'</td>
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
    $mpdf->output('Expired Camp Report.pdf','D');
?>

