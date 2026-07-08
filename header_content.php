<?php  
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventra - Inventory Management</title>
    <style>
        :root {
            --primary-color: #102A71;
            --secondary-color: #F5C400;
            --background-color: #FFFFFF;
            --text-color: #102A71;
            --header-footer: #FFF;
            --header-text: #102A71;
            --button-color: #F5C400;
            --white: #fff;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .nav-cont {
            background-color: var(--primary-color);
            color: var(--white);
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px 0;
        }

        .nav-cont ul {
            list-style: none;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px; /* Equal spacing */
            margin: 0;
            padding: 0;
        }

        .nav-cont li {
            margin: 0;
        }

        .nav-cont a {
            color: var(--white);
            text-decoration: none;
            font-weight: bold;
            padding: 10px 20px;
            display: block;
            border-radius: 20px;
            transition: background-color 0.3s, color 0.3s;
            text-align: center;
            margin-top: 0;
        }

        .nav-cont a:hover {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        .hero {
            text-align: center;
            margin: 50px 0;
        }

        .btn {
            display: inline-block;
            background-color: var(--button-color);
            color: var(--text-color);
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 20px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <header>
        <nav class="nav-cont">
            <ul>
                <?php 
                if (isset($_SESSION['email'])): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="suppliers.php">Suppliers</a></li>
                    <li><a href="stock.php">Stock</a></li>
                    <li><a href="report.php">Report</a></li>
                <?php else: ?>
                    <li class="hero">
                        <h2>Welcome to Inventra</h2>
                        <p>Your all-in-one solution for inventory management</p>
                        <a href="signup_form.php" class="btn">Get Started</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>
