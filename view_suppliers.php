<?php 
session_start();
include 'db.php'; // Database connection
include 'header.php'; 
include 'header_content.php';// Include header

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
$dbname = "inventry$user_id";
$conn->select_db($dbname);

// Fetch suppliers from the database
$suppliers = $conn->query("SELECT * FROM suppliers");

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
            --light-gray: #bcbcbc;
            --primary-color: #102A71;
            --background-color: #f4f4f4;
            --text-color: #333;
            --white: #fff;
            --hover-color: #F5C400;
            --button-color: #F5C400;
            --button-hover: #102A71;
            --shadow-color: rgba(245, 196, 0, 0.5);
        }

        body {
            font-family: Arial, sans-serif;
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
            box-shadow: 0 5px 15px var(--shadow-color);
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
            background-color: var(--primary-color);
            color: var(--white);
        }

        .delete-btn {
            background: red;
            color: var(--white);
            padding: 7px;
            border-radius: 3px;
            border: none;
        }

        .edit-btn:hover {
            background: var(--secondary-color);
        }

        .btn-primary:hover, .btn-delete:hover {
            background-color: var(--button-hover);
            color: var(--white);
            box-shadow: 0 0 10px var(--shadow-color);
        }

        .menu-item:hover {
            color: var(--hover-color);
        }

        .footer {
            text-align: center;
            padding: 10px;
            color: var(--text-color);
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
    <h2>Supplier Management</h2>

    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Supplier ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $suppliers->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['contact']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <form method="POST" action="delete_supplier.php" style="display:inline;">
                                <input type="hidden" name="supplier_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_supplier" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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
