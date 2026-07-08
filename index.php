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
            --background-color: #FFFDF0;
            --text-color: #102A71;
            --header-footer: #FFF;
            --white: #fff;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .hero {
            background-color: var(--primary-color);
            color: var(--white);
            text-align: center;
            padding: 50px 20px;
        }

        .hero h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background-color: var(--secondary-color);
            color: var(--white);
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .features {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 40px 20px;
            flex-wrap: wrap;
        }

        .feature-box {
            background: var(--white);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 30%;
            min-width: 250px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, border 0.3s;
            border: 2px solid transparent;
        }

        .feature-box:hover {
            transform: scale(1.05);
            border: 2px solid var(--secondary-color);
        }

        .feature-box h3 {
            color: var(--primary-color);
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .about {
            text-align: left;
            padding: 40px;
            background-color: var(--white);
            color: var(--text-color);
        }

        .about img {
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .card-img{
            height: 150px;
        }
        .about-container{
            width: 100%;
            display: flex;
            flex-direction: center;
        }
        .about-container p{
            padding-top: 140px;
            width: 50%;
        }

        .testimonials {
            padding: 40px;
            text-align: center;
            background-color: var(--primary-color);
            color: var(--white);
        }

        .testimonials p {
            font-style: italic;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; 
    include 'header_content.php'; 
    ?>
    
    <section class="features">
        <div class="feature-box">
            <img class="card-img" src="images/real_time_tracking.png" alt="real time tracking image">
            <h3>Real-Time Product Tracking</h3>
            <p>Track stock levels and avoid shortages.</p>
        </div>
        <div class="feature-box">
            <img class="card-img" src="images/order_mgn.png" alt="order management image">
            <h3>Supplier & Order Management</h3>
            <p>Seamless tracking of all supplier transactions.</p>
        </div>
        <div class="feature-box">
            <img class="card-img" src="images/auto_update.png" alt="Auto update image">
            <h3>Automated Updates</h3>
            <p>Inventory updates in real-time.</p>
        </div>
        <div class="feature-box">
            <img class="card-img" src="images/user_friendly.png" alt="User Friendly image">
            <h3>User-Friendly</h3>
            <p>makes it easier to perform tasks</p>
        </div>
        <div class="feature-box">
            <img class="card-img" src="images/stock_manipulation.png" alt="Stock Manipulation image">
            <h3>Stock Manipulate</h3>
            <p>Stock updating, deleting and entries</p>
        </div>
        <div class="feature-box">
            <img class="card-img" src="images/all_report.png" alt="Report generation image">
            <h3>Report Generation</h3>
            <p>Generating Sales report, Inventory turnover, most and least sold products</p>
        </div>
    </section>
    
    <section class="about">
    <h2>About Inventra</h2>
        <div class="about-container">
            <p>Inventra is an advanced inventory management system designed to simplify stock control, sales tracking, and supplier management. Whether you're a small business or a large enterprise, Inventra helps you stay organized with real-time product tracking, automated stock updates, and insightful reports. With its user-friendly interface and powerful features, you can efficiently manage your inventory, prevent stock shortages, and optimize profitability. Inventra ensures that every transaction is recorded accurately, providing you with valuable analytics to make informed decisions. Say goodbye to manual tracking and experience seamless inventory management with Inventra!</p>
            <img src="images/new_inventory.png" alt="Inventory Management Illustration">
        </div>
    </section>

    <section class="testimonials">
        <h2>What Our Clients Say</h2>
        <p>"Inventra has streamlined our stock management and saved us hours of manual work! Highly recommended." - Jane D.</p>
        <p>"Managing suppliers and orders has never been easier. Inventra is a game-changer!" - Michael R.</p>
    </section>
    
    <?php include 'footer.php'; ?>
</body>
</html>
