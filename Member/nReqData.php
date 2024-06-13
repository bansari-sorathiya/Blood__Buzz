<link rel="icon" href="../img/logo.png" type="image/x-icon"/>
<title>Blood Buzz-Nearest Requester</title>
<style type="text/css">
    .own
    {
        margin-top:40px;
    }
    .msg
    {
        color:green;
    }
    .location
    {
        color:red;
    }
    .envelop
    {
        color:#4B0082;
    }
    .msg:hover,.envelop:hover,.location:hover{
        text-decoration:none;
    }
    .m-b-30
    {
        margin-bottom: 30px;
    }
    p
    {
    color: #8A98AC;    
    }
    .table-borderless td
    {
        border: 0 !important;
    }
    .table td
    {
        color: #8A98AC;
        vertical-align: middle;
        border-top: 1px solid rgba(0, 0, 0, 0.03);
        padding: 0.6rem;
    }
    .card
    {
        border: none;
        border-radius: 3px;
        background-color: #ffffff;
    }
     .pagination
    {
    display: inline-block;
    margin-left:199px;
    }
    #email,#msg
    {
        border:1px solid black;
        background-color:#f0f0f0;
        font-size:medium;
    }
    .form-inline
    {
        margin-top:35px;
        margin-bottom:-20px;
        margin-left:189px;
    }
</style>


<?php
include '../Include/connect2.php';
if((isset($_REQUEST['lat'])) && ($_REQUEST['long']))
{
$lat = base64_decode($_REQUEST['lat']);
$long = base64_decode($_REQUEST['long']);
}
elseif((isset($_REQUEST['mlat'])) && (isset($_REQUEST['mlong'])))
{
    session_start();
    $lat=base64_decode($_REQUEST['mlat']);
    $long=base64_decode($_REQUEST['mlong']);
}
else
{
    header("location:./nearestLatLong.php");  
}
$range = 5; // Range in kilometers

// Earth's mean radius in kilometers
$earthRadiusKm = 6371;
include './nav.php';

// Prepare and execute the SQL query
$check_donor = $connection->prepare("SELECT m.*,r.*,l.member_id, l.lat, l.longe,
    (:earthRadius * acos(cos(radians(:myLatitude)) * cos(radians(l.lat)) * cos(radians(l.longe) - radians(:myLongitude)) + sin(radians(:myLatitude)) * sin(radians(l.lat)))) AS distance
    FROM `location` l
    JOIN members m ON m.member_id=l.member_id 
    JOIN requester r ON r.member_id=m.member_id
    HAVING distance <= :range
    ORDER BY distance ASC");

$check_donor->bindParam(':earthRadius', $earthRadiusKm, PDO::PARAM_INT);
$check_donor->bindParam(':myLatitude', $lat, PDO::PARAM_STR);
$check_donor->bindParam(':myLongitude', $long, PDO::PARAM_STR);
$check_donor->bindParam(':range', $range, PDO::PARAM_INT);
$check_donor->execute();
$donors=$check_donor->fetchAll(PDO::FETCH_ASSOC);
// Process the result
if ($check_donor->rowCount() > 0) {
    ?>

    <div class="own">
    <div class="container">
    <div class="row"> 

    <?php
    foreach ($donors as $row) {
    ?>
       



    <div class="col-lg-6">
    <div class="card m-b-30">
    <div class="card-body py-5"> 
    <div class="row">
    <div class="col-lg-3 text-center">

    <?php 
        if($row['img']==null)
        {
        echo"<img src='../img/user.png' class='img-fluid mb-3' alt='user'>";
        }
        else
        {
            echo "<img src='../img/{$row['img']}' class='img-fluid mb-3' alt='user'>";
        }
    ?>

    </div>

    <div class="col-lg-9">
    <h4><?php echo "Patient Name :&nbsp;".$row['patient_name']; ?></h4>
    
    <!-- email btn -->
    <div class="button-list mt-4 mb-3">
    <button type="button" id="email" class="btn btn-primary-rgba"><a class="envelop" href="mailto:<?php echo $row['email']; ?>"><i class="bi bi-envelope"></i>&nbsp;Email</a></button>

    <!-- whatsapp btn -->
    <?php $cno="91". $row['contact_no']; ?>
    <button type="button" id="msg" class="btn btn-success-rgba"><a href="https://api.whatsapp.com/send?phone=<?php echo $cno; ?>" class="msg"><i class="bi bi-whatsapp"></i>&nbsp;Message</a></button>

    <!-- location btn -->
    <button type="button" id="msg" class="btn btn-success-rgba"><a href="./userMap.php?mid=<?php echo $row['member_id'];?>" class="location"><i class="bi bi-geo-alt-fill"></i>&nbsp;Location</a></button>
    </div>

    <div class="table-responsive">
    <table class="table table-borderless mb-0">
    <tbody>
    <tr>
    <th scope="row" class="p-1">Address :</th>
    <td  style="height:100px;" class="p-1"><?php echo $row['address']; ?></td>
    </tr>
    <tr>
    <?php
    //fetch state
    $sid=$row['state'];
    $state=$connection->prepare("SELECT DISTINCT state_name FROM states WHERE state_id=?");
    $state->execute([$sid]);
    $sname=$state->fetchColumn();
    // echo $sname;
    ?>
    <th scope="row" class="p-1">State :</th>
    <td style="height:10px;" class="p-1"><?php echo $sname; ?></td>
    </tr>



    <tr>
    <?php
    //fetch state
    $cid=$row['city'];
    $city=$connection->prepare("SELECT DISTINCT city_name FROM city WHERE city_id=?");
    $city->execute([$cid]);
    $cname=$city->fetchColumn();
    ?>
    <th scope="row" class="p-1">City :</th>
    <td style="height:10px;" class="p-1"><?php echo $cname; ?></td>
    </tr>



    <tr>
    <?php
    //fetch state
    $bid=$row['blood_id'];
    $blood=$connection->prepare("SELECT DISTINCT blood_grp FROM blood_group WHERE blood_id=?");
    $blood->execute([$bid]);
    $blood_group=$blood->fetchColumn();
    ?>
    <th scope="row" class="p-1">Require Blood:</th>
    <td style="height:10px;" class="p-1"><?php echo $blood_group; ?></td>
    </tr>

    <tr>
    <th scope="row" class="p-1">Kilometer:</th>
    <td style="height:10px;" class="p-1"><?php echo $row['distance']; ?></td>
    </tr>
    </tbody>
    </table>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>

    <?php
    }
} 
else
{
    echo "No users found within the specified range.";
}
?>
<?php include './footer.php'; ?>
