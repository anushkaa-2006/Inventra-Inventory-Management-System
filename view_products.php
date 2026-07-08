<?php 
session_start();
include 'db.php';

$category = isset($_GET['cat']) ? $_GET['cat'] : '';
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
$dbname = "inventry$user_id";
$conn->select_db($dbname);

if ($category) {
    $stmt = $conn->prepare("SELECT name, cost_price, selling_price, quantity FROM products WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <style>
        :root {
            --dark-color: #281e32;
            --light-gray: #bcbcbc;
            --primary-color: rgb(93, 1, 252);
            --secondary-color: #2ecc71;
            --background-color: #f4f4f4;
            --text-color: #333;
            --header-footer: #ffb11f;
            --white: #fff;
        }

        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            background: var(--background-color);
            text-align: center;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        table {
            width: 80%;
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
            background: var(--primary-color);
            color: var(--white);
        }

        .back-btn {
            display: inline-block;
            width: 200px;
            margin: 20px;
            padding: 10px 20px;
            background: var(--secondary-color);
            color: var(--white);
            text-decoration: none;
            border-radius: 5px;
        }

        .back-btn:hover {
            background: var(--dark-color);
        }


        footer {
            background: var(--header-footer);
            color: var(--text-color);
            padding: 10px;
            text-align: center;
        }

    </style>
</head>
<body>

<?php 
include "header.php";
include 'header_content.php';
?>

<main>
    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Cost Price</th>
                <th>Selling Price</th>
                <th>Quantity</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>Rs. <?php echo htmlspecialchars($row['cost_price']); ?></td>
                    <td>Rs. <?php echo htmlspecialchars($row['selling_price']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No products found in this category.</p>
    <?php endif; ?>
        <a class="back-btn" href="view_by_category.php">Back to Categories</a>
</main>
<?php include 'footer.php'; ?>
</body>
</html>

<?php 
$stmt->close(); 
$conn->close(); 
?>