<?php
include 'db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userid = $_SESSION['user_id'];
$table_name = "inventry{$userid}.sales";

// Fetch sales data function
function getSalesReport($conn, $table, $interval) {
    $query = "SELECT 
                 COALESCE(SUM(quantity), 0) AS total_sales, 
                 COALESCE(SUM(total_profit), 0) AS total_profit 
              FROM $table 
              WHERE sale_date >= DATE_SUB(CURDATE(), INTERVAL $interval)";
    
    $result = $conn->query($query);
    return $result->fetch_assoc();
}

// Fetch data
$dailySales = getSalesReport($conn, $table_name, '1 DAY');
$weeklySales = getSalesReport($conn, $table_name, '1 WEEK');
$monthlySales = getSalesReport($conn, $table_name, '1 MONTH');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        .tab-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        .tab-buttons button {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #F5C400;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .tab-buttons button:hover {
            background-color: #102A71;
        }
        .tab-content {
            display: none;
        }
        .active {
            display: block;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 20px auto;
        }
        .chart-container {
            width: 100%;
            max-width: 600px;
            height: 300px;
            margin: auto;
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
    <?php include 'header.php'; include "header_content.php"; ?>

    <div class="container">
        <h2>Sales Report</h2>

        <div class="tab-buttons">
            <button onclick="showTab('daily')">Daily Sales</button>
            <button onclick="showTab('weekly')">Weekly Sales</button>
            <button onclick="showTab('monthly')">Monthly Sales</button>
        </div>

        <div id="daily" class="tab-content active">
            <div class="card">
                <h3>Daily Sales</h3>
                <p><strong>Total Sales:</strong> <?php echo number_format($dailySales['total_sales']); ?></p>
                <p><strong>Total Profit:</strong> $<?php echo number_format($dailySales['total_profit'], 2); ?></p>
                <div class="chart-container">
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>
        </div>

        <div id="weekly" class="tab-content">
            <div class="card">
                <h3>Weekly Sales</h3>
                <p><strong>Total Sales:</strong> <?php echo number_format($weeklySales['total_sales']); ?></p>
                <p><strong>Total Profit:</strong> $<?php echo number_format($weeklySales['total_profit'], 2); ?></p>
                <div class="chart-container">
                    <canvas id="weeklyChart"></canvas>
                </div>
            </div>
        </div>

        <div id="monthly" class="tab-content">
            <div class="card">
                <h3>Monthly Sales</h3>
                <p><strong>Total Sales:</strong> <?php echo number_format($monthlySales['total_sales']); ?></p>
                <p><strong>Total Profit:</strong>Rs.<?php echo number_format($monthlySales['total_profit'], 2); ?></p>
                <div class="chart-container">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tab) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.getElementById(tab).classList.add('active');
        }

        function fetchSalesData(interval, canvasId) {
            fetch(`fetch_sales_data.php?interval=${interval}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(row => row.sale_date);
                    const sales = data.map(row => row.total_sales);
                    const profits = data.map(row => row.total_profit);

                    const ctx = document.getElementById(canvasId).getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Total Sales',
                                    data: sales,
                                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Total Profit',
                                    data: profits,
                                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
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
                });
        }

        fetchSalesData('1 DAY', 'dailyChart');
        fetchSalesData('1 WEEK', 'weeklyChart');
        fetchSalesData('1 MONTH', 'monthlyChart');
    </script>
<a class="back-btn" href="report.php">Back to Report</a>
<?php include 'footer.php'; ?>
</body>
</html>