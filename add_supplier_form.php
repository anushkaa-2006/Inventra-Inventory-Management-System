<?php 
session_start();
include 'db.php'; // Database connection
include 'header.php'; 
include 'header_content.php';// Include header

// Fetch suppliers from the database
$userid = $_SESSION['user_id']; // Ensure user ID is stored in session
$inventry_db = "inventry" . $userid;
$suppliers = $conn->query("SELECT * FROM $inventry_db.suppliers");

if (!$suppliers) {
    die("Database query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Management</title>
    <style>
        :root {
            --dark-color: #281e32;
            --primary-color: #102A71;
            --secondary-color: #F5C400;
            --text-color: #333;
            --white: #fff;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--white);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            width: 70%;
            margin: 40px auto;
            background: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            flex: 1;
        }

        h2, h3 {
            color: var(--dark-color);
            text-align: center;
        }

        .table-container {
            overflow-x: auto;
            margin-bottom: 20px;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .styled-table th, .styled-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid var(--dark-color);
        }

        .styled-table thead {
            background-color: var(--dark-color);
            color: var(--white);
        }

        .btn-primary, .btn-delete {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
            font-size: 14px;
            background-color: var(--secondary-color);
            color: var(--white);
        }

        .btn-primary:hover, .btn-delete:hover {
            background-color: var(--primary-color);
        }

        .form-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-container form {
            width: 60%;
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--dark-color);
            border-radius: 5px;
            font-size: 16px;
        }

        .success-message, .error-message {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            padding: 10px;
            color: var(--white);
            margin-top: auto;
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

<div class="container">
    <h2>Add New Supplier</h2>

    <div class="form-container">
        <form method="post" action="add_supplier.php">
            <input type="text" name="name" placeholder="Supplier Name" required>
            <input type="text" name="contact" placeholder="Contact Number" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <button type="submit" name="add_supplier" class="btn-primary">Add Supplier</button>
        </form>
    </div>
</div>
        <a class="back-btn" href="suppliers.php">Back to Suppliers</a>
<div class="footer">
    <?php include 'footer.php'; ?>
</div>

<?php 
$conn->close(); 
?>

</body>
</html>