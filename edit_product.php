<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

$userid = $_SESSION['user_id']; 
$inventry_db = "inventry" . $userid;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $query = "SELECT * FROM $inventry_db.products WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $category = $row['category'];
        $cost_price = $row['cost_price'];
        $quantity = $row['quantity'];
        $supplier_name = $row['supplier_name'];
        $selling_price = $row['selling_price'];
    } else {
        echo "<div class='error'>Product not found!</div>";
        exit;
    }
    $stmt->close();
} else {
    echo "<div class='error'>Invalid request!</div>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $cost_price = $_POST['cost_price'];
    $quantity = $_POST['quantity'];
    $supplier_name = $_POST['supplier_name']; 
    $selling_price = $_POST['selling_price'];

    $sql = "UPDATE $inventry_db.products SET name=?, category=?, cost_price=?, quantity=?, supplier_name=?, selling_price=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdissi", $name, $category, $cost_price, $quantity, $supplier_name, $selling_price, $id);

    if ($stmt->execute()) {
        header("Location: view_all_products.php");
        exit;
    } else {
        echo "<div class='error'>Error updating product: " . $conn->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        /* Color Theme */
        :root {
            --blue: #102A71;
            --yellow: #F5C400;
            --dark-color: #281e32;
            --light-gray: #bcbcbc;
            --background-color: #f4f4f4;
            --text-color: #333;
            --white: #fff;
        }

        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 40px auto;
            background: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            color: var(--dark-color);
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        input {
            width: 80%;
            padding: 10px;
            border: 1px solid var(--dark-color);
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background: var(--yellow);
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background: var(--blue);
            color: white;
        }

        .success, .error {
            padding: 10px;
            width: 80%;
            text-align: center;
            margin: 10px auto;
            border-radius: 5px;
            font-weight: bold;
        }

        .success {
            background: green;
            color: var(--white);
        }
63
        .error {
            background: red;
            color: var(--white);
        }
    </style>
</head>
<body>
<?php include 'header.php'; 
    include 'header_content.php'; 
    ?>
<div class="container">
    <h2>Edit Product</h2>
    <form action="edit_product.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <input type="text" name="name" placeholder="Product Name" value="<?php echo htmlspecialchars($name); ?>" required>
        <input type="text" name="category" placeholder="Category" value="<?php echo htmlspecialchars($category); ?>" required>
        <input type="number" name="cost_price" placeholder="Cost Price" value="<?php echo htmlspecialchars($cost_price); ?>" required>
        <input type="number" name="selling_price" placeholder="Selling Price" value="<?php echo htmlspecialchars($selling_price); ?>" required>
        <input type="number" name="quantity" placeholder="Quantity" value="<?php echo htmlspecialchars($quantity); ?>" required>
        <input type="text" name="supplier_name" placeholder="Supplier Name" value="<?php echo htmlspecialchars($supplier_name); ?>" required>
        <button type="submit" name="update">Update Product</button>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
