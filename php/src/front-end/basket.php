<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/basket.css">
    <title>Basket</title>
</head>
<body>
    <nav>
        <?php include('navbar.php'); ?>
    </nav>
    
    <div class="main-content">
        <h1>Your Basket</h1>
        <?php
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach($_SESSION['cart'] as $product) {
                echo "<div class='product'>
                        <img src='{$product['image']}' alt='{$product['name']}'>
                        <h3>{$product['name']}</h3>
                      </div>";
            }
        } else {
            echo "<p>Your basket is empty.</p>";
        }
        ?>
    </div>
    
    <footer>
        <?php include('.footer.php'); ?>
    </footer>
</body>
</html>
