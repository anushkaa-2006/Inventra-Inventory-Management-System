<?php 
session_start();
include 'header.php';
include 'header_content.php';  
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

// Get user-specific database name
$userDatabase = "inventry" . $_SESSION['user_id'];

// Fetch orders with product names using JOIN
$sql = "SELECT o.id AS order_id, p.name AS product_name, o.quantity, o.status 
        FROM `$userDatabase`.orders o
        JOIN `$userDatabase`.products p ON o.product_name = p.name";

$result = $conn->query($sql);

// Fetch products for the dropdown
$productQuery = "SELECT name FROM `$userDatabase`.products";
$productResult = $conn->query($productQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <style>
        /* Color Theme */
        :root {
            --primary-color: #102A71; /* Deep Blue */
            --secondary-color: #F5C400; /* Yellow */
            --background-color: #FFFDF0; /* Light Yellow */
            --text-color: #333;
            --card-bg: #FFFFFF;
            --shadow: rgba(245, 196, 0, 0.2); /* Thin yellow shadow */
            --hover-shadow: rgba(245, 196, 0, 0.4); /* Stronger yellow shadow */
        }

        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            width: 70%;
            margin: 40px auto;
            background: var(--card-bg);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px var(--shadow);
            flex-grow: 1;
        }

        h2, h3 {
            color: var(--primary-color);
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        input, select {
            width: 80%;
            padding: 10px;
            border: 1px solid var(--primary-color);
            border-radius: 5px;
            font-size: 16px;
        }

        /* Styled Buttons */
        button {
            background: var(--secondary-color);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 2px 6px var(--shadow);
            transition: background 0.3s, box-shadow 0.3s, color 0.3s;
        }

        button:hover {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px var(--hover-shadow);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid var(--primary-color);
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: var(--primary-color);
            color: var(--card-bg);
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: var(--primary-color);
            color: var(--card-bg);
            margin-top: auto;
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
        <a class="back-btn" href="orders.php">Back to Orders</a>

    </style>
</head>
<body>

<div class="container">
    <h2>Add New Order</h2>

    <form action="add_order.php" method="post">
        <input type="text" name="customer" placeholder="Enter Customer Name" required>
        <select name="product_name" required>
            <option value="">Select a product</option>
            <?php while ($product = $productResult->fetch_assoc()) { ?>
                <option value="<?= htmlspecialchars($product['name']) ?>">
                    <?= htmlspecialchars($product['name']) ?>
                </option>
            <?php } ?>
        </select>
        <input type="number" name="quantity" placeholder="Enter Quantity" required>
        <button type="submit">Place Order</button>
    </form>
</div>
<a class="back-btn" href="orders.php">Back to Orders</a>
<?php include 'footer.php'; ?>  <!-- Footer included only once -->

</body>
</html>

<?php
$conn->close();
?>