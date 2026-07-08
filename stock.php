<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
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
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            width: 90%;
            margin: 30px auto;
            background: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            overflow-x: auto;
            flex: 1;
        }

        .main-content h2 {
            color: var(--text-color);
            font-size: 28px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: center;
            white-space: nowrap;
        }

        thead {
            background: var(--primary-color);
            color: var(--white);
        }

        th, td {
            padding: 10px;
            border: 1px solid var(--secondary-color);
        }

        tbody tr:nth-child(even) {
            background: #f2f2f2;
        }

        tbody tr:hover {
            background: rgb(204, 213, 255);
            transition: 0.3s;
        }

        .low-stock {
            background-color: var(--alert) !important;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .actions button {
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .edit-btn {
            background: var(--edit-color);
            color: var(--white);
        }

        .delete-btn {
            background: red;
            color: var(--white);
        }

        .edit-btn:hover {
            background: var(--secondary-color);
        }

        .delete-btn:hover {
            background: darkred;
        }

        @media screen and (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
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

    <section class="main-content">
        <h2>Product Management</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Cost Price</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>Supplier Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $userid = $_SESSION['user_id']; 
                $inventry_db = "inventry" . $userid;
                $query = "SELECT products.id, products.name, products.category, products.cost_price, selling_price, 
                          products.quantity, COALESCE(suppliers.name, '-') AS supplier_name 
                          FROM $inventry_db.products
                          LEFT JOIN $inventry_db.suppliers ON $inventry_db.products.supplier_name = $inventry_db.suppliers.id
                          ORDER BY $inventry_db.products.quantity ASC";
                
                $result = $conn->query($query);
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $rowClass = ($row['quantity'] < 30) ? "class='low-stock'" : "";
                    ?>
                    <tr <?= $rowClass ?>>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td>Rs<?= number_format($row['cost_price'], 2) ?></td>
                        <td>Rs<?= number_format($row['selling_price'], 2) ?></td>
                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                        <td><?= htmlspecialchars($row['supplier_name']) ?></td>
                        <td class="actions">
                            <form action="edit_product.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="edit-btn">Edit</button>
                            </form>
                            <form action="delete_product.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </section>
        <a class="back-btn" href="index.php">Back to Home</a>
    <?php include 'footer.php'; ?>
</body>
</html>
