<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <style>
        :root {
            --primary-color: #102A71;
            --secondary-color: #F5C400;
            --background-color: #FFFDF0;
            --text-color: #102A71;
            --header-footer: #FFF;
            --white: #fff;
        }

        body {
            background: var(--background-color);
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            gap: 30px;
            flex: 1;
        }

        .card {
            background: var(--white);
            padding: 20px;
            width: 280px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, border 0.3s;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .card:hover {
            transform: scale(1.05);
            border: 2px solid var(--secondary-color);
        }

        .card img {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }

        .card h3 {
            margin-bottom: 10px;
            color: var(--white);
            font-size: 1.2em;
        }

        .card p {
            font-size: 14px;
            color: var(--white);
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

        .add-product { background: var(--primary-color); color: var(--white); }
        .view-products { background: var(--secondary-color); color: var(--white); }
        .view-category { background: var(--primary-color); color: var(--white); border: 2px solid var(--secondary-color); }
    </style>
</head>
<body>
<?php include 'header.php'; 
    include "header_content.php";
    ?>
    
    <div class="container">
        <div class="card add-product" onclick="location.href='add_order_form.php';">
            <img src="images/add_order.png" alt="Add Orders">
            <h3>Add New Order</h3>
            <p>Add new orders to your inventory easily.</p>
        </div>
        <div class="card view-products" onclick="location.href='view_orders.php';">
            <img src="images/view_all_orders.png" alt="View all orders">
            <h3>View All Orders</h3>
            <p>Browse and manage all available orders.</p>
        </div>
    </div>
        <a class="back-btn" href="index.php">Back to Home</a>
    <?php include "footer.php"; ?>
</body>
</html>
