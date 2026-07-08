<?php
session_start();
require 'header.php';
require 'db.php';
require "header_content.php";

$userid = $_SESSION['user_id']; // Ensure user ID is stored in session
$inventry_db = "inventry" . $userid;

$suppliers = $conn->query("SELECT id, name FROM $inventry_db.suppliers");
$products = $conn->query("SELECT * FROM $inventry_db.products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Categories</title>
    <link rel="stylesheet" href="styles.css">
    
    <style>
        :root {
            --primary-color: #102A71; /* Deep Blue */
            --secondary-color: #50E3C2;
            --background-color: #F9FAFB;
            --text-color: #333;
            --card-bg: #FFFFFF;
            --shadow: rgba(245, 196, 0, 0.2); /* Thin yellow shadow */
            --hover-shadow: rgba(245, 196, 0, 0.4); /* Stronger yellow on hover */
            --yellow-bg: #F5C400; /* Yellow hover background */
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--background-color);
            margin: 0;
            padding: 0;
        }

        /* Changed text color to deep blue */
        h1 {
            color: var(--primary-color);
            text-align: center;
            margin-top: 20px;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1100px;
            margin: 20px auto;
        }

        .card {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 6px var(--shadow); /* Thin yellow shadow */
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            cursor: pointer;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px var(--hover-shadow); /* Stronger yellow shadow */
        }

        .card img {
            width: 100px;
            height: 100px;
            margin-bottom: 15px;
        }

        /* Changed category text color to blue */
        .card h3 {
            color: var(--primary-color);
            font-size: 18px;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 14px;
            color: #666;
        }

        /* Yellow background effect when hovering over menu items */
        .menu-item:hover, nav a:hover {
            background: var(--yellow-bg) !important;
            color: black !important; /* Ensure good contrast */
            transition: background 0.3s ease-in-out, color 0.3s ease-in-out;
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

<h1>Product Categories</h1>
<div class="container">
    <?php
    $categories = [
        "Stationary" => "stationary.png",
        "Electronics" => "electronics.png",
        "Clothing" => "clothing.png",
        "Beauty" => "beauty.png",
        "Food" => "food.png",
        "Books" => "books.png",
        "Furniture" => "furniture.png",
        "Beverages" => "beverages.png",
        "Household Essentials" => "household.png"
    ];

    foreach ($categories as $category => $image) :
    ?>
        <div class="card" onclick="location.href='view_products.php?cat=<?= urlencode($category) ?>';">
            <img src="images/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($category) ?>">
            <h3><?= htmlspecialchars($category) ?></h3>
            <p>Explore our collection of <?= htmlspecialchars($category) ?>.</p>
        </div>
    <?php endforeach; ?>
</div>
        <a class="back-btn" href="products.php">Back to Products</a>
<?php require 'footer.php'; ?>

</body>
</html>
