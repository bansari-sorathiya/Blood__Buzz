<?php

require_once __DIR__ . '/../vendor/autoload.php';
include(__DIR__."/../include/connect.php");

$res=mysqli_query($connection,"SELECT c.city_name , s.state_name , m.* FROM members m JOIN city c ON c.city_id = m.city JOIN states s ON s.state_id = m.state");
if(mysqli_num_rows($res)>0){
    $html='';
    $html='<head>
    <link rel="stylesheet" href="rcss.css">
  </head><h1>Total Member report</h1><table cellspacing=70 cellpadding=70>';
    $html.='<tr><th><b>Member Id</b></th><th><b>Image</b></th><th><b>Email</b></th><th><b>Password</b></th><th><b>Verify Token</b></th><th><b>Member Name</b></th>
    <th><b>Contact No</b></th><th><b>Gender</b></th><th><b>Date of Birth</b></th><th><b>Address</b></th><th><b>City Name</b></th>
    <th><b>State Name</b></th><th><b>Landmark</b></th><th><b>Pincode</b></th><th><b>Created At</b></th></tr>';
    while($row=mysqli_fetch_assoc($res)){
        $html.='<tr><td>'.$row['member_id'].'</td>
            <td>'.$row['img'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['pwd'].'</td>
            <td>'.$row['verify_token'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['contact_no'].'</td>
            <td>'.$row['gender'].'</td>
            <td>'.$row['dob'].'</td>
            <td>'.$row['address'].'</td>
            <td>'.$row['city_name'].'</td>
            <td>'.$row['state_name'].'</td>
            <td>'.$row['landmark'].'</td>
            <td>'.$row['pincode'].'</td>
            <td>'.$row['created_at'].'</td></tr>';
    }
    $html.= '</table>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    // $file=time().'.pdf';
    $mpdf->output('Total member report.pdf','D');
}
else{
    $html='No data found';
}
 echo $html;


?>
