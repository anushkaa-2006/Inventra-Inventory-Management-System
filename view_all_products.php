<?php
session_start();
require 'header.php';
include 'header_content.php';
require 'db.php';

$userid = $_SESSION['user_id']; // Ensure user ID is stored in session
$inventry_db = "inventry" . $userid;

$suppliers = $conn->query("SELECT id, name FROM $inventry_db.suppliers");
$products = $conn->query("SELECT * FROM $inventry_db.products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="styles.css">
    
<style>
    :root {
            --primary-color: #102A71;
            --secondary-color: #F5C400;
            --background-color: #FFFDF0;
            --text-color: #102A71;
            --header-footer: #FFF;
            --white: #fff;
            --alert: #ffcccc;
            --edit-color: #2ecc71;
        }

    body {
        font-family: Arial, sans-serif;
        background: #f8f9fa;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 80%;
        margin: 30px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        color: #333;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0px 0px 8px rgba(245, 196, 0, 0.6); /* Yellow glow effect */
    }
    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background: #102A71; /* Deep Blue */
        color: white;
    }
    tr:nth-child(even) {
        background: #f2f2f2;
    }
    .actions {
        display: flex;
        gap: 5px;
    }
    .edit-btn {
        background: var(--edit-color);
        color: var(--white);
        padding: 7px;
        border-radius: 3px;
        border: none;
    }

        .delete-btn {
            background: red;
            color: var(--white);
            padding: 7px;
            border-radius: 3px;
            border: none;
        }

        .edit-btn:hover {
            background: var(--secondary-color);
        }

        .delete-btn:hover {
            background: darkred;
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
    <div class="container">
        <h2>Manage Products</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Cost Price</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>Supplier</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $products->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= htmlspecialchars($row['cost_price']) ?></td>
                        <td><?= htmlspecialchars($row['selling_price']) ?></td>
                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                        <td><?= htmlspecialchars($row['supplier_name']) ?></td>
                        <td class="actions">
                            <form action="edit_product.php" method="post">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="edit-btn">Edit</button>
                            </form>
                            <form action="delete_product.php" method="post" onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
        <a class="back-btn" href="products.php">Back to Products</a>
    <?php require 'footer.php'; ?>
</body>
</html>
