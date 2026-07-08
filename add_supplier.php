<?php  
include 'db.php';
$userid = $_SESSION['user_id']; 
$inventry_db = "inventry" . $userid;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $contact = trim($_POST["contact"]);
    $email = trim($_POST["email"]);

    // Specify database name before the table name
    $sql = "INSERT INTO $inventry_db.suppliers (name, contact, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $name, $contact, $email);
        if ($stmt->execute()) {
            header("Location: suppliers.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}
?>
