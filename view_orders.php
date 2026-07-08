<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';
include 'header.php';
include 'header_content.php';

$userid = $_SESSION['user_id']; 
$inventry_db = "inventry" . mysqli_real_escape_string($conn, $userid);
$status = $_GET['status'] ?? 'all';

$statusCondition = ($status === 'all') ? '' : "WHERE status = ?";
$query = "SELECT id, customer, product_name, quantity, status FROM $inventry_db.orders $statusCondition";

$stmt = $conn->prepare($query);
if ($status !== 'all') {
    $stmt->bind_param("s", $status);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <style>
        :root {
            --primary-blue: #102A71; /* Deep Blue */
            --light-gray: #bcbcbc;
            --green: #2ecc71;
            --text-color: #333;
            --white: #FFFFFF;
        }

        /* Full white background */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: var(--white);
            text-align: center;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
            padding-bottom: 50px;
        }

        /* Header has no background */
        header {
            background: none !important;
            box-shadow: none;
        }

        table {
            width: 90%;
            max-width: 1000px;
            margin: 20px auto;
            border-collapse: collapse;
            background: var(--white);
        }

        th, td {
            padding: 10px;
            border: 1px solid var(--light-gray);
            text-align: left;
        }

        th {
            background: var(--primary-blue); /* Blue header */
            color: var(--white);
        }

        .filter-buttons {
            margin: 20px;
        }

        .filter-btn {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            color: var(--white);
            display: inline-block;
        }

        .all { background: var(--primary-blue); }
        .completed { background: var(--green); }
        .pending { background: var(--light-gray); color: var(--text-color); }

        .update-btn {
            padding: 5px 10px;
            border: none;
            background: var(--green);
            color: var(--white);
            border-radius: 5px;
            cursor: pointer;
        }

        .update-btn:hover {
            background: #27ae60;
        }

        .filter-btn.active {
            border: 2px solid #fff;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            table {
                width: 100%;
            }

            th, td {
                font-size: 14px;
                padding: 8px;
            }
        }

        /* Footer Styling */
        footer {
            width: 100%;
            padding: 10px 0;
            background: none;
            color: var(--text-color);
            text-align: center;
            position: relative;
            bottom: 0;
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

<div class="content">
    <div class="filter-buttons">
        <a href="view_orders.php?status=all" class="filter-btn all <?= ($status == 'all') ? 'active' : '' ?>">All Orders</a>
        <a href="view_orders.php?status=completed" class="filter-btn completed <?= ($status == 'completed') ? 'active' : '' ?>">Completed Orders</a>
        <a href="view_orders.php?status=pending" class="filter-btn pending <?= ($status == 'pending') ? 'active' : '' ?>">Pending Orders</a>
    </div>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Status</th>
                <?php if ($status === 'pending'): ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['customer']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td><?php echo htmlspecialchars(ucfirst($row['status'])); ?></td>
                    <?php if ($status === 'pending'): ?>
                        <td>
                            <form method="post" action="update_order_status.php" onsubmit="return confirmUpdate()">
                                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                                <input type="hidden" name="quantity" value="<?php echo $row['quantity']; ?>">
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="update-btn">Mark as Completed</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>
        <a class="back-btn" href="orders.php">Back to Orders</a>
<?php include 'footer.php'; ?>

<script>
    function confirmUpdate() {
        return confirm("Are you sure you want to mark this order as completed?");
    }
</script>

</body>
</html>

<?php 
$stmt->close();
$conn->close(); 
?>
