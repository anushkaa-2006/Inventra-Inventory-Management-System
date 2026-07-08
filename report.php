<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

$userid = $_SESSION['user_id']; 
$inventry_db = "inventry" . $userid;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Dashboard</title>
    <style>
        :root {
            --primary-color: rgb(93, 1, 252);
            --secondary-color: #2ecc71;
            --background-color: #f4f4f4;
            --text-color: #333;
            --header-footer: #ffb11f;
            --white: #fff;
            --yellow-shadow: rgba(255, 217, 0, 0.6);
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .card {
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            padding: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
            border: 2px solid transparent;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px var(--yellow-shadow);
            border: 2px solid var(--primary-color);
        }

        .card img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border-bottom: 4px solid var(--primary-color);
        }

        .card h3 {
            color: var(--primary-color);
            margin: 10px 0;
        }

        .card p {
            color: var(--text-color);
        }

        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background: var(--secondary-color);
            color: var(--white);
            text-decoration: none;
            border-radius: 5px;
        }

        .card a:hover {
            background: var(--primary-color);
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
    <h1 style="text-align:center; color:var(--header-footer);">Reports Dashboard</h1>
    <div class="card-container">
        <div class="card">
            <img src="images/sales_report.png" alt="Sales Report">
            <h3>Sales Reports</h3>
            <p>View sales reports for daily, weekly, and monthly analysis.</p>
            <a href="sales_report.php?userid=<?= urlencode($userid) ?>">View Report</a>
        </div>
        <div class="card">
            <img src="images/inventory_turnover.png" alt="Inventory Turnover">
            <h3>Inventory Turnover</h3>
            <p>Analyze how quickly inventory is sold and replaced.</p>
            <a href="inventory_turnover.php?userid=<?= urlencode($userid) ?>">View Report</a>
        </div>
        <div class="card">
            <img src="images/most_sold_products.png" alt="Most Sold Products">
            <h3>Most Sold Products</h3>
            <p>Check out the best-selling products.</p>
            <a href="most_sold_products.php?userid=<?= urlencode($userid) ?>">View Report</a>
        </div>
        <div class="card">
            <img src="images/least_sold_products.png" alt="Least Sold Products">
            <h3>Least Sold Products</h3>
            <p>Identify products with low sales volume.</p>
            <a href="least_sold_products.php?userid=<?= urlencode($userid) ?>">View Report</a>
        </div>
    </div>
</div>
        <a class="back-btn" href="index.php">Back to Home</a>
<?php include 'footer.php'; ?>
</body>
</html>
