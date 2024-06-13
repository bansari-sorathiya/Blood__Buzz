<?php
try {
    ob_start();
    session_start();
    include '../Include/connect2.php';
    $currentMonth = date('m');
    $currentYear = date('Y');
    date_default_timezone_set('Asia/Kolkata');

    if (!$connection) {
        throw new Exception("Database connection failed.");
    }

    $get_requester = $connection->prepare("
        SELECT COUNT(*) AS requester_count, MONTH(created_at) AS month
        FROM requester
        WHERE YEAR(created_at) = :year 
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ");
    $get_requester->bindParam(':year', $currentYear);
    $get_requester->execute();
    $requesterData = $get_requester->fetchAll(PDO::FETCH_ASSOC);

    $get_donor = $connection->prepare("
        SELECT COUNT(*) AS donor_count, MONTH(created_at) AS month
        FROM eligibility
        WHERE YEAR(created_at) = :year 
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ");
    $get_donor->bindParam(':year', $currentYear);
    $get_donor->execute();
    $donorData = $get_donor->fetchAll(PDO::FETCH_ASSOC);

    $combinedData = [];
    foreach ($requesterData as $r) {
        $month = intval($r['month']);
        $combinedData[$month]['requester'] = intval($r['requester_count']);
    }
    foreach ($donorData as $d) {
        $month = intval($d['month']);
        $combinedData[$month]['donor'] = intval($d['donor_count']);
    }

    $dataPointsReceived = [];
    $dataPointsSent = [];

    for ($month = 1; $month <= 12; $month++) {
        $dataPointsReceived[] = ['x' => $month, 'y' => $combinedData[$month]['requester'] ?? 0];
        $dataPointsSent[] = ['x' => $month, 'y' => $combinedData[$month]['donor'] ?? 0];
    }
    
    $jsonReceived = json_encode($dataPointsReceived);
    $jsonSent = json_encode($dataPointsSent);
} catch (PDOException $e) {
    $error = $e->getMessage();
    $_SESSION['error-message'] = "Database error: " . $error;
    print_r($_SESSION);
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</head>

<body>
    <div id="chartContainer" style="height: 500px; width: 100%;"></div>
    <script>
        window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                exportEnabled: true,
                axisX: {
                    title:"Month",
                    valueFormatString: "### Mon"
                    
                },
                axisY: {
                    title: "Count",
                    interval: 1
                },
                legend: {
                    verticalAlign: "top",
                    horizontalAlign: "right",
                    dockInsidePlotArea: false
                },
                toolTip: {
                    shared: true
                },
                data: [{
                        name: "Requester",
                        showInLegend: true,
                        legendMarkerType: "square",
                        type: "spline",
                        xValueFormatString: "### Mon",
                        color: "rgba(40,175,101,0.6)",
                        markerSize: 0,
                        dataPoints: <?php echo $jsonReceived ?? '[]'; ?>
                    },
                    {
                        name: "Donor",
                        showInLegend: true,
                        legendMarkerType: "square",
                        type: "spline",
                        color: "rgba(0,75,141,0.7)",
                        markerSize: 0,
                        dataPoints: <?php echo $jsonSent ?? '[]'; ?>
                    }
                ]
            });
            chart.render();
            function toggleDataSeries(e){
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                }
                else{
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        }
    </script>
</body>

</html>


