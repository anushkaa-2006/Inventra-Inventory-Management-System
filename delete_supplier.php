<?php
session_start();
include 'db.php'; // Database connection


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supplier_id'])) {
    $supplier_id = intval($_POST['supplier_id']);

    // Retrieve user ID from session to determine the correct database
    $userid = $_SESSION['user_id']; // Ensure user ID is stored in the session
    $inventry_db = "inventry" . $userid;

    // Specify the database explicitly in the query
    $sql = "DELETE FROM $inventry_db.suppliers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $supplier_id);

    if ($stmt->execute()) {
        header("Location: suppliers.php");
        exit();
    } else {
        echo "Error deleting supplier: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
