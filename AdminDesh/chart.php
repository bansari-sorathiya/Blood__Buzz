<?php
include '../Include/connect2.php';
try {
    // Get the current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    $fetchUser = $connection->prepare("SELECT MONTH(created_at) AS month, COUNT(*) AS user_count
                                    FROM members
                                    WHERE YEAR(created_at) = :year
                                    GROUP BY MONTH(created_at)
                                    ORDER BY MONTH(created_at)");
    $fetchUser->bindParam(':year', $currentYear);
    $fetchUser->execute();

    // Fetch data from the query result
    $dataPoints = array();
    while ($row = $fetchUser->fetch(PDO::FETCH_ASSOC)) {
        // Format the data into the required format for the chart
        $month = intval($row['month']);
        $userCount = intval($row['user_count']);
        $dataPoints[] = array('label' => date("M", mktime(0, 0, 0, $month, 1)), 'y' => $userCount);
    }
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Count Chart</title>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</head>
<body>
    <div id="chartContainer" style="height: 300px; width: 100%;"></div>

    <script>
        var crosshairchart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            axisX:{
                title:"Months",
                valueFormatString: "MM",
                crosshair: {
                enabled: true,
                snapToDataPoint: true,
                }
            },
        axisY: {
            title: "User Count",
            valueFormatString: "00",
            interval: 1, 
            minimum: 0, 
            crosshair: {
                enabled: true,
                snapToDataPoint: true,
                labelFormatter: function(e) {
                    return  CanvasJS.formatNumber(e.value, "00 Member");
                }
            }
        },
            data: [{
                type: "area",
                xValueFormatString: "MM",
		        yValueFormatString: "00 Member",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });

        crosshairchart.render();
    </script>
</body>
</html>
