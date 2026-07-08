<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Color Scheme */
        :root {
            --primary-blue: #102A71; /* Dark Blue */
            --hover-yellow: #F5C400; /* Hover Yellow */
            --text-color: #333;
            --white: #FFF;
            --dark-color: #281e32;
        }

        /* Reset and global styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Full height layout */
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
            background: var(--white);
        }

        /* Content wrapper */
        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Login Form - Much Bigger */
        .login-form {
            background: var(--white);
            padding: 60px; /* Further Increased Padding */
            border-radius: 14px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            width: 600px; /* Increased width */
        }

        h2 {
            color: var(--primary-blue);
            margin-bottom: 30px;
            font-size: 32px; /* Bigger heading */
        }

        input {
            width: 100%;
            padding: 18px; /* Bigger input size */
            margin: 25px 0; /* Increased spacing */
            border: 2px solid var(--primary-blue);
            border-radius: 8px;
            font-size: 20px;
        }

        /* Login Button */
        button {
            background-color: var(--primary-blue);
            color: var(--white);
            border: none;
            padding: 20px; /* Bigger button */
            width: 100%;
            font-size: 22px; /* Bigger font */
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: var(--hover-yellow);
            color: var(--primary-blue);
        }

        /* Signup Link */
        .signup-link {
            margin-top: 25px;
            font-size: 18px;
        }

        .signup-link a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: bold;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: var(--white);
            text-align: center;
            padding: 20px;
            width: 100%;
            position: sticky;
            bottom: 0;
            font-size: 18px;
        }
    </style>
</head>
<body>
<?php include 'header.php';     ?>

    <div class="container">
        <form action="login.php" method="post" class="login-form">
            <h2>Login</h2>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p class="signup-link">Don't have an account? <a href="signup_form.php">Sign Up</a></p>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
