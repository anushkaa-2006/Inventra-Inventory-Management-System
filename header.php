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
            font-size: 18px; /* Increased base font size */
        }

        header {
            background-color: var(--header-footer);
            color: var(--header-text);
            padding: 10px; /* Increased padding */
            display: flex;
            margin-bottom: 0;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex; 
            /* align-items: center;  */
            gap: 10px; 
        }

        .logo img {
            margin-top: 0px;
            height: 70px; /* Increased logo size */
            margin-right: 10px;
        }

        .logo h2 {
            color: var(--header-text);
            font-size: 38px; /* Increased font size */
        }

        .nav-container ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .nav-container li {
            margin: 0 15px; /* Increased spacing */
        }

        .nav-container a {
            color: var(--header-text);
            text-decoration: none;
            font-weight: bold;
            padding: 10px 10px; /* Increased padding */
            display: block;
            border: none;
            border-radius: 25px; /* Slightly increased border-radius */
            transition: background-color 0.3s, color 0.3s;
            text-align: center;
            font-size: 20px; /* Increased font size */
        }

        .nav-container a:hover {
            background-color: var(--secondary-color);
            color: var(--white);
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/new_logo.png" alt="Inventra Logo">
            <h2>Inventra</h2>
        </div>
        <nav class="nav-container">
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php 
            if (isset($_SESSION['email'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login_form.php">Login</a></li>
                <li><a href="signup_form.php">Register</a></li>
            <?php endif; ?>
        </ul>
        </nav>
    </header>
</body>
</html>
