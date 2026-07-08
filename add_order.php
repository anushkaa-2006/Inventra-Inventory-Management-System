<?php
session_start();
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

// Get user-specific database name
$userDatabase = "inventry" . $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer = mysqli_real_escape_string($conn, $_POST['customer']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $quantity = (int) $_POST['quantity']; // Ensure quantity is an integer
    $status = "Pending";
    $date = date("Y-m-d"); // Corrected date format

    // Insert order into the user-specific database
    $sql = "INSERT INTO `$userDatabase`.orders (customer, product_name, quantity, status, date) 
            VALUES ('$customer', '$product_name', $quantity, '$status', '$date')";

    if ($conn->query($sql) === TRUE) {
        header("Location: orders.php");
        exit();
    } else {
        echo "<script>alert('Error placing order: " . $conn->error . "'); window.history.back();</script>";
    }

    $conn->close();
} else {
    echo "Invalid request!";
}
?>
