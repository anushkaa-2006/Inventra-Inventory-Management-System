<?php
include 'db.php'; // Include database connection

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company = $_POST['company'];
    $email = $_POST['email'];
    $password =$_POST['password'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $phone = $_POST['phone'];

    // Use the `invetra_admin` database explicitly in queries
    $checkUser = $conn->prepare("SELECT id FROM invetra_admin.users WHERE email = ?");
    $checkUser->bind_param("s", $email);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows > 0) {
        echo "<script>alert('User Already Exists'); window.location.href='login_form.php';</script>";
    } else {
        // Insert user into invetra_admin database
        $insertUser = $conn->prepare("INSERT INTO invetra_admin.users (company, email, password, country, state, phone) VALUES (?, ?, ?, ?, ?, ?)");
        $insertUser->bind_param("ssssss", $company, $email, $password, $country, $state, $phone);
        
        if ($insertUser->execute()) {
            $user_id = $conn->insert_id;
            $dbName = "inventry" . $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $user_id;

            // Create new inventory database for the user
            $createDB = "CREATE DATABASE `$dbName`";
            if ($conn->query($createDB) === TRUE) {
                // Create tables in the new database
                $createTables = [
                    "CREATE TABLE `$dbName`.orders (
                        id INT AUTO_INCREMENT PRIMARY KEY, 
                        product_name VARCHAR(255), 
                        user_id INT, 
                        quantity INT, 
                        status VARCHAR(50), 
                        customer VARCHAR(255), 
                        date DATE
                    )",
                    "CREATE TABLE `$dbName`.products (
                        id INT AUTO_INCREMENT PRIMARY KEY, 
                        name VARCHAR(255), 
                        category VARCHAR(100), 
                        selling_price DECIMAL(10,2), 
                        quantity INT, 
                        supplier_name VARCHAR(255), 
                        cost_price DECIMAL(10,2)
                    )",
                    "CREATE TABLE `$dbName`.sales (
                        id INT AUTO_INCREMENT PRIMARY KEY, 
                        order_id INT, 
                        product_name VARCHAR(255), 
                        quantity INT, 
                        cost_price DECIMAL(10,2), 
                        selling_price DECIMAL(10,2), 
                        product_profit DECIMAL(10,2), 
                        sale_date DATE, 
                        total_profit DECIMAL(10,2)
                    )",
                    "CREATE TABLE `$dbName`.suppliers (
                        id INT AUTO_INCREMENT PRIMARY KEY, 
                        name VARCHAR(255), 
                        contact VARCHAR(50), 
                        email VARCHAR(255)
                    )"
                ];

                foreach ($createTables as $query) {
                    if ($conn->query($query) !== TRUE) {
                        echo "Error creating table: " . $conn->error . "<br>";
                    }
                }
                header("Location: index.php");
            } else {
                echo "Error creating database: " . $conn->error;
            }
        } else {
            echo "Error signing up: " . $conn->error;
        }
    }

    $checkUser->close();
    $insertUser->close();
}
?>
