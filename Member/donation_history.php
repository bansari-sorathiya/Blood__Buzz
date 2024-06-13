<link rel="icon" href="../img/logo.png" type="image/x-icon" />
<title>Blood Buzz-Donation History</title>
<?php
ob_start();
include './redirect.php';
include './nav.php';
include '../Include/connect2.php';

$email = $_SESSION['member_email'];

try {
    // Get the member ID of the logged-in user using their email
    $get_member_id = $connection->prepare("SELECT member_id FROM members WHERE email=?");
    $get_member_id->execute([$email]);
    $member_data = $get_member_id->fetch(PDO::FETCH_ASSOC);
    $member_id = $member_data['member_id'];

    // Check if the logged-in user has donation history (donor_member_id)
    $get_donor = $connection->prepare("SELECT donor_member_id FROM deleted_request WHERE donor_member_id=?");
    $get_donor->execute([$member_id]);
    $donor_data = $get_donor->fetch(PDO::FETCH_ASSOC);

    if ($donor_data) {
        // Fetch donation history for the logged-in user with requester counts and latest date
        $get_history = $connection->prepare("SELECT d.member_id, COUNT(d.member_id) as request_count, 
                                                 MAX(d.created_at) as latest_date, m.name, m.email 
                                             FROM deleted_request d 
                                             JOIN members m ON d.member_id = m.member_id 
                                             WHERE d.donor_member_id=?
                                             GROUP BY d.member_id, m.name, m.email");
        $get_history->execute([$member_id]);
        $history_data = $get_history->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // No donation history found for the logged-in user
        $history_data = [];
    }
} catch (PDOException $e) {
    // Handle query errors
    $error = $e->getMessage();
    $_SESSION['error-message'] = "Database error: " . $error;
}

?>

<div class="container">
    <div class="row">
        <div class="col">
            <?php if (!empty($history_data)) : ?>
                <br><h3>Donation History</h3><br>
                <?php foreach ($history_data as $row) : ?>
                    <div class="card mb-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Name: <?php echo $row['name']; ?></h5>
                            <p class="card-text">
                            Email: <?php echo $row['email']; ?>&nbsp;
                            Request Count: 
                            <span class="badge badge-info"><?php echo $row['request_count']; ?></span><br>
                            Latest Donation Date: <?php echo $row['latest_date']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No donation history found for this user.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<p style="margin-left:400px;">
Note : The Donation Date is not the exact date. It is the date when the user deleted their request after it was fulfilled by you
</p>
<?php include './footer.php'; ?>
