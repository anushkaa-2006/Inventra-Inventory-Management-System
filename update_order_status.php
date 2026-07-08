<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

$userid = $_SESSION['user_id']; 
$inventry_db = "inventry" . $userid;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = intval($_POST['order_id']);
    
    // Debugging: Print received POST data
    error_log("POST Data: " . print_r($_POST, true));

    if (!isset($_POST['product_name']) || empty($_POST['product_name'])) {
        die("<script>alert('Error: Product name is missing.'); window.location.href='view_orders.php';</script>");
    }

    $product_name = $_POST['product_name']; // Now keeping it as string
    error_log("Product Name: " . $product_name);

    $quantity = intval($_POST['quantity']);
    $status = $_POST['status'];

    $conn->begin_transaction();

    try {
        // Update order status
        $update_order_sql = "UPDATE $inventry_db.orders SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($update_order_sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("si", $status, $order_id);
        if (!$stmt->execute()) {
            throw new Exception("Execution failed: " . $stmt->error);
        }
        $stmt->close();

        if ($status === 'completed') {
            // Deduct quantity from products table using product name
            $update_stock_sql = "UPDATE $inventry_db.products SET quantity = quantity - ? WHERE name = ?";
            $stmt = $conn->prepare($update_stock_sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("is", $quantity, $product_name);
            if (!$stmt->execute()) {
                throw new Exception("Execution failed: " . $stmt->error);
            }
            $stmt->close();

            // Fetch product cost price and selling price for sales calculations
            $fetch_price_sql = "SELECT cost_price, selling_price FROM $inventry_db.products WHERE name = ?";
            $stmt = $conn->prepare($fetch_price_sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("s", $product_name);
            if (!$stmt->execute()) {
                throw new Exception("Execution failed: " . $stmt->error);
            }
            $stmt->bind_result($cost_price, $selling_price);
            if (!$stmt->fetch()) {
                throw new Exception("Fetch failed: No product found with name " . $product_name);
            }
            $stmt->close();

            // Calculate profit per product
            $product_profit = ($selling_price - $cost_price) * $quantity;
            $sale_date = date("Y-m-d");

            // Insert record into sales table
            $insert_sales_sql = "INSERT INTO $inventry_db.sales (order_id, product_name, quantity, cost_price, selling_price, product_profit, sale_date, total_profit) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_sales_sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("isiddssd", $order_id, $product_name, $quantity, $cost_price, $selling_price, $product_profit, $sale_date, $product_profit);
            if (!$stmt->execute()) {
                throw new Exception("Execution failed: " . $stmt->error);
            }
            $stmt->close();
        }

        $conn->commit();
        header("Location: view_orders.php?status=pending");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Error: " . $e->getMessage());
        echo "<script>alert('Error updating order: " . $e->getMessage() . "'); window.location.href='view_orders.php';</script>";
    }
}

$conn->close();
?>
