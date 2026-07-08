<?php  
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

$userid = $_SESSION['user_id']; 
$inventry_db = "inventry" . $userid;

// Fetch summary data with explicit database references
$query = [
    "products" => "SELECT COUNT(*) FROM $inventry_db.products",
    "orders" => "SELECT COUNT(*) FROM $inventry_db.orders",
    "suppliers" => "SELECT COUNT(*) FROM $inventry_db.suppliers",
    "shortage" => "SELECT COUNT(*) FROM $inventry_db.products WHERE quantity < 30"
];

$stats = [];
foreach ($query as $key => $sql) {
    $result = $conn->query($sql);
    $stats[$key] = $result ? $result->fetch_row()[0] : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventra</title>
    <style>
        :root {
            --primary-color: #102A71;
            --secondary-color: #F5C400;
            --background-color: #FFF;
            --text-color: #102A71;
            --header-footer: #FFF;
            --white: #fff;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .dashboard-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: var(--text-color);
            font-size: 28px;
            margin-bottom: 20px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }

        .card {
            background: var(--white);
            padding: 20px;
            border-radius: 12px;
            width: 350px;
            height: 200px;
            box-shadow: 0 4px 8px rgba(255, 177, 31, 0.5);
            text-align: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(255, 177, 31, 0.7);
        }

        .card h3 {
            margin: 15px 0;
            font-size: 20px;
            color: var(--text-color);
        }

        .card p {
            font-size: 22px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .shortage-count {
            color: red;
        }

        @media (max-width: 600px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
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

    <div class="dashboard-container">
        <h2>Dashboard Overview</h2>
        <div class="dashboard-grid">
            <div class="card">
                <h3>Total Products</h3>
                <p><?php echo $stats["products"]; ?></p>
            </div>
            <div class="card">
                <h3>Total Orders</h3>
                <p><?php echo $stats["orders"]; ?></p>
            </div>
            <div class="card">
                <h3>Total Suppliers</h3>
                <p><?php echo $stats["suppliers"]; ?></p>
            </div>
            <div class="card">
                <h3>Low Stock Products</h3>
                <p class="shortage-count"><?php echo $stats["shortage"]; ?></p>
            </div>
        </div>
    </div>

    <a class="back-btn" href="index.php">Back to Home</a>
    <?php include 'footer.php'; ?>
    <?php $conn->close(); ?>
</body>
</html>
