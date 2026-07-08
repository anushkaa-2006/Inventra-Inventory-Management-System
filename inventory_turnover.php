<?php
include 'db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userid = $_SESSION['user_id'];
$inventry_db = "inventry" . $userid;

// Fetch Inventory Turnover Data
function getInventoryTurnover($conn, $inventry_db, $interval) {
    $query = "SELECT product_name, 
                 SUM(quantity) AS total_sold,
                 SUM(cost_price * quantity) AS total_cost,
                 (SELECT SUM(quantity) FROM $inventry_db.products WHERE name = sales.product_name) 
                 + SUM(quantity) AS initial_stock
          FROM $inventry_db.sales
          WHERE sale_date >= DATE_SUB(CURDATE(), INTERVAL $interval)
          GROUP BY product_name 
          ORDER BY total_sold DESC";


    $result = $conn->query($query);

    if (!$result) {
        die("SQL Error: " . $conn->error); // Debugging: Print SQL error if query fails
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $row['ending_inventory'] = $row['initial_stock'] - $row['total_sold'];
        $row['inventory_turnover'] = ($row['total_cost'] > 0) ? round($row['total_cost'] / max(1, (($row['initial_stock'] + $row['ending_inventory']) / 2)), 2) : 0;
        $data[] = $row;
    }
    return $data;
}



// Fetch data for the selected interval
$interval = isset($_GET['interval']) ? $_GET['interval'] : '1 MONTH'; 
$inventoryTurnoverData = getInventoryTurnover($conn, $inventry_db, $interval);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Turnover</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-blue: #102A71; /* Dark Blue */
            --hover-yellow: #F5C400; 
            --primary-color: #102A71;
            --secondary-color: #2ecc71;
            --background-color: #f4f4f4;
            --text-color: #333;
            --header-footer: #ffb11f;
            --white: #fff;
        }
        body {
            font-family: Arial, sans-serif;
            background: var(--background-color);
            color: var(--text-color);
        }
        .container {
            width: 80%;
            margin: auto;
            text-align: center;
        }
        .card {
            background: var(--white);
            padding: 20px;
            margin: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 4px var(--hover-yellow);
            text-align: left;
        }
        .header {
            background: var(--header-footer);
            padding: 10px;
            font-size: 24px;
            color: var(--white);
            text-align: center;
            border-radius: 5px;
        }
        .chart-container {
            width: 100%;
            max-width: 600px;
            height: 300px;
            margin: auto;
            
        }
        .btn-group {
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 15px;
            margin: 5px;
            border: none;
            background: var(--hover-yellow);
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background: var(--primary-blue);
        }
        .back-btn {
            display: inline-block;
            text-align: center;
            align-self: center;
            width: 200px;
            margin: 20px;
            padding: 10px 20px;
            background: #F5C400;
            color: #FFFF;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-btn:hover {
            background: #102A71;
        }
    </style>
</head>
<body>
<?php include 'header.php'; 
    include "header_content.php";
    ?>

    <div class="container">
        <h2>Inventory Turnover Report</h2>

        <!-- Time Period Buttons -->
        <div class="btn-group">
            <button class="btn" onclick="changeInterval('1 WEEK')">Weekly</button>
            <button class="btn" onclick="changeInterval('1 MONTH')">Monthly</button>
            <button class="btn" onclick="changeInterval('3 MONTH')">Quarterly</button>
            <button class="btn" onclick="changeInterval('1 YEAR')">Yearly</button>
        </div>

        <?php if (empty($inventoryTurnoverData)) { ?>
            <p>No sales data available.</p>
        <?php } else { ?>
            <?php foreach ($inventoryTurnoverData as $item) { ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                    <p><strong>Total Stock Available at Start:</strong> <?php echo $item['initial_stock']; ?></p>
                    <p><strong>Total Stock Sold:</strong> <?php echo $item['total_sold']; ?></p>
                    <p><strong>Ending Inventory:</strong> <?php echo $item['ending_inventory']; ?></p>
                    <p><strong>Inventory Turnover Ratio:</strong> <?php echo $item['inventory_turnover']; ?></p>
                </div>
            <?php } ?>

            <!-- Chart Section -->
            <div class="chart-container">
                <canvas id="inventoryChart"></canvas>
            </div>
        <?php } ?>
    </div>

    <script>
        function changeInterval(interval) {
            window.location.href = "inventory_turnover.php?interval=" + interval;
        }

        // Inventory Chart
        const labels = <?php echo json_encode(array_column($inventoryTurnoverData, 'product_name')); ?>;
        const stockSold = <?php echo json_encode(array_column($inventoryTurnoverData, 'total_sold')); ?>;
        const stockReceived = <?php echo json_encode(array_column($inventoryTurnoverData, 'total_received')); ?>;

        const ctx = document.getElementById('inventoryChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Stock Sold',
                        data: stockSold,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        fill: true
                    },
                    {
                        label: 'Stock Received',
                        data: stockReceived,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
        <a class="back-btn" href="report.php">Back to Report</a>
    <?php include 'footer.php'; ?>

</body>
</html>
