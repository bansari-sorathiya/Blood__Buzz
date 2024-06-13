<?php
//include './header2.php';
include './nav.php';
include '../Include/connect2.php';

try {
    $stmt = $connection->query("
        SELECT m.name, m.img, f.feedback,f.created_at
        FROM feedback AS f
        JOIN members AS m ON f.member_id = m.member_id
    ");
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} 
catch (PDOException $e) {
    // Handle query errors
    $error = $e->getMessage();
    $_SESSION['error-message'] = "Database error: " . $error;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content here -->
    
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="../File/js/bootstrap.min.js"></script>
    <!-- JavaScript code for Swiper -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    
    <style>
        .card-img-topp{
            width:120px;
            height:120px;
            margin-left:355px;
            margin-top:-80px;
            margin-bottom:9px;
        }
        .row
        {
            margin-top:20px;
        }
        .swiper-container
        {
            margin-top:40px;
        }
    </style>
</head>
<body>

<div class="swiper-container reviews-slider">
    <div class="swiper-wrapper">
        <?php 
        // Chunk the feedback array into sets of three
        $feedbackChunks = array_chunk($feedbacks, 6);
        
        // Iterate over each set of feedback chunks
        foreach ($feedbackChunks as $chunk): 
        ?>
        <div class="swiper-slide">
            <div class="row">
                <?php foreach ($chunk as $feedback): ?>
                <div class="col-md-4 pb-3">
                    <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $feedback['name']; ?></h5>
                            <p class="card-text"><?php echo substr($feedback['feedback'], 0, 80); ?><?php echo strlen($feedback['feedback']) > 80 ? '...' : ''; ?></p>
                            <!-- <div class="mt-auto"></div> Pushes card content to the bottom                             -->
                            <p class="card-text"><b>Datetime:</b>&nbsp;<?php echo $feedback['created_at']; ?></p>
                        </div>
                        <?php
                                if($feedback['img']==null)
                                {
                                echo"<img src='../img/user.png' class='card-img-topp' alt='Profile Picture'>";
                                }
                                else
                                {
                                    echo"<img src='../img/{$feedback['img']}' class='card-img-topp' alt='error'>";
                                }
                        ?>  
                        
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <!-- <div class="swiper-pagination"></div> -->
</div>

<script>
        var swiper = new Swiper('.reviews-slider', {
            direction: 'horizontal',
            loop: true,
            navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
            pagination: {
                el: '.swiper-pagination',
            },
        });
    </script>

<?php include_once './footer.php'; ?>
</body>
</html>
