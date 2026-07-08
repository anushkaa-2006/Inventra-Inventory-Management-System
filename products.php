<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <style>
        :root {
            --primary-color: #102A71;
            --secondary-color: #F5C400;
            --background-color: #FFFDF0;
            --text-color: #102A71;
            --header-footer: #FFF;
            --white: #fff;
        }

        body {
            background: var(--background-color);
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            gap: 30px;
            flex: 1;
        }

        .card {
            background: var(--white);
            padding: 20px;
            width: 280px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, border 0.3s;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .card:hover {
            transform: scale(1.05);
            border: 2px solid var(--secondary-color);
        }

        .card img {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }

        .card h3 {
            margin-bottom: 10px;
            color: var(--white);
            font-size: 1.2em;
        }

        .card p {
            font-size: 14px;
        }

        .add-product { background: var(--primary-color); color: var(--white); }
        .view-products { background: var(--secondary-color); color: var(--white); }
        .view-category { background: var(--primary-color); color: var(--white); border: 2px solid var(--secondary-color); }

        footer {
            background: var(--header-footer);
            color: var(--text-color);
            text-align: center;
            padding: 10px;
            font-size: 14px;
            width: 100%;
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
<?php include 'header.php'; 
    include "header_content.php";
    ?>
    
    <div class="container">
        <div class="card add-product" onclick="location.href='add_product.php';">
            <img src="images/add_product.png" alt="Add Product">
            <h3>Add Product</h3>
            <p>Add new products to your inventory easily.</p>
        </div>
        <div class="card view-products" onclick="location.href='view_all_products.php';">
            <img src="images/view_products.png" alt="View Products">
            <h3>View All Products</h3>
            <p>Browse and manage all available products.</p>
        </div>
        <div class="card view-category" onclick="location.href='view_by_category.php';">
            <img src="images/view_products_by_category.png" alt="View by Category">
            <h3>View Products by Category</h3>
            <p>Filter products based on their categories.</p>
        </div>
    </div>
        <a class="back-btn" href="index.php">Back to Home</a>
    <?php include "footer.php"; ?>
</body>
</html>
