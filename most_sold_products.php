<?php
include 'db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

$userid = $_SESSION['user_id']; // Get user ID
$inventry_db = "inventry" . $userid; // Construct user-specific database name

// Fetch the top 10 most sold products
$sql = "SELECT product_name, SUM(quantity) AS total_sold 
        FROM $inventry_db.sales 
        GROUP BY product_name 
        ORDER BY total_sold DESC 
        LIMIT 10";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most Sold Products</title>
    <style>
        :root {
            --primary-color: rgb(93, 1, 252);
            --secondary-color: #2ecc71;
            --background-color: #f4f4f4;
            --text-color: #333;
            --header-footer: #ffb11f;
            --white: #fff;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--background-color);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: var(--primary-color);
        }

        .card {
            width: 700px;
            text-align: center;
            background: var(--white);
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-content {
            flex: 1;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            color: var(--text-color);
        }

        .card-description {
            font-size: 14px;
            color: #666;
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

    <h2>Top 10 Most Sold Products</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <div class="card-content">
                    <div class="card-title"><?= htmlspecialchars($row['product_name']) ?></div>
                    <div class="card-description">Total Sold: <?= htmlspecialchars($row['total_sold']) ?></div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align: center; color: var(--text-color);">No sales data available.</p>
    <?php endif; ?>

</div>
        <a class="back-btn" href="report.php">Back to Report</a>
<?php include 'footer.php'; ?>

</body>
</html>

<?php $conn->close(); ?>
