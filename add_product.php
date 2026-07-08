<?php 
session_start();
include 'header.php';
include 'header_content.php';
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

// User-specific database name
$userDatabase = "inventry" . $_SESSION['user_id'];

$suppliersQuery = "SELECT id, name FROM `$userDatabase`.suppliers";
$suppliersResult = $conn->query($suppliersQuery);

$message = "";
$alertClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, trim($_POST["name"]));
    $category = mysqli_real_escape_string($conn, trim($_POST["category"]));
    $cost_price = floatval($_POST["cost_price"]);
    $selling_price = floatval($_POST["selling_price"]);
    $quantity = intval($_POST["quantity"]);
    $supplier_name = mysqli_real_escape_string($conn, trim($_POST["supplier_name"]));

    if (!empty($supplier_name)) {
        // Check if the product already exists in the user's inventory
        $checkQuery = "SELECT id, quantity FROM `$userDatabase`.products WHERE name = ? AND supplier_name = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("ss", $name, $supplier_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Product exists, update the quantity by adding new quantity
            $row = $result->fetch_assoc();
            $newQuantity = $row['quantity'] + $quantity;

            $updateQuery = "UPDATE `$userDatabase`.products SET quantity = ?, cost_price = ?, selling_price = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("iddi", $newQuantity, $cost_price, $selling_price, $row['id']);

            if ($updateStmt->execute()) {
                $message = "Product quantity updated successfully!";
                $alertClass = "success";
            } else {
                $message = "Error updating quantity: " . $conn->error;
                $alertClass = "error";
            }
            $updateStmt->close();
        } else {
            // Product does not exist, insert a new record
            $insertQuery = "INSERT INTO `$userDatabase`.products (name, category, cost_price, selling_price, quantity, supplier_name) VALUES (?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("ssdiss", $name, $category, $cost_price, $selling_price, $quantity, $supplier_name);

            if ($insertStmt->execute()) {
                $message = "Product added successfully!";
                $alertClass = "success";
            } else {
                $message = "Error: " . $conn->error;
                $alertClass = "error";
            }
            $insertStmt->close();
        }

        $stmt->close();
    } else {
        $message = "Please select a supplier.";
        $alertClass = "error";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #fff; 
            margin: 0; 
            padding: 0;
            color: #102A71;
        }
        .main-content { 
            width: 90%; 
            margin: 30px auto; 
            background: #fff; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); 
            text-align: center; 
        }
        form { 
            background: #ffffff; 
            padding: 20px; 
            border-radius: 10px; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            gap: 15px; 
            width: 50%; 
            margin: 20px auto; 
            box-shadow: 0 5px 10px rgba(245, 196, 0, 0.5); /* Yellow shadow effect */
        }
        input, select { 
            width: 95%; 
            padding: 10px; 
            border-radius: 5px; 
            border: 1px solid #102A71; 
            font-size: 16px; 
            color: #102A71;
        }
        button { 
            background: #F5C400; /* Yellow background */
            color: white; 
            padding: 10px 20px; 
            border-radius: 5px; 
            border: none; 
            cursor: pointer; 
            font-size: 16px; 
            transition: background 0.3s ease; 
        }
        button:hover { 
            background: #102A71; /* Blue on hover */
            color: white;
        }
        .alert { 
            width: 90%; 
            padding: 10px; 
            margin: 10px auto; 
            border-radius: 5px; 
            font-size: 16px; 
        }
        .success { 
            background-color: #ccffcc; 
            color: #006600; 
        }
        .error { 
            background-color: #ffcccc; 
            color: #990000; 
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
<section class="main-content">
    <h2>Add or Update Product</h2>
    <?php if ($message): ?>
        <div class="alert <?php echo $alertClass; ?>"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <form action="" method="post">
        <input type="text" name="name" placeholder="Product Name" required>
        <select name="category" required>
            <option value="Stationary">Stationary</option>
            <option value="Electronics">Electronics</option>
            <option value="Clothing">Clothing</option>
            <option value="Beauty">Beauty</option>
            <option value="Food">Food</option>
            <option value="Books">Books</option>
            <option value="Furniture">Furniture</option>
            <option value="Beverages">Beverages</option>
            <option value="Household Essentials">Household Essentials</option>
        </select>
        <input type="number" name="cost_price" placeholder="Cost Price" step="0.01" required>
        <input type="number" name="selling_price" placeholder="Selling Price" step="0.01" required>
        <input type="number" name="quantity" placeholder="Quantity" required>
        <select name="supplier_name" required>
            <option value="">Select Supplier</option>
            <?php while ($row = mysqli_fetch_assoc($suppliersResult)) { echo "<option value='{$row['name']}'>{$row['name']}</option>"; } ?>
        </select>
        <button type="submit">Save Product</button>
    </form>
</section>
        <a class="back-btn" href="products.php">Back to Products</a>
<?php include 'footer.php'; ?>
</body>
</html>