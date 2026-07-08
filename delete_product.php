<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

$userid = $_SESSION['user_id']; 
$inventry_db = "inventry" . $userid;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Specify the database explicitly
    $sql = "DELETE FROM $inventry_db.products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: products.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
