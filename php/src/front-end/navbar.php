<?php
session_start();
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product) {
        $cart_count += $product['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoboYum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
    }

    header {
        background-color: #ffffff;
        padding: 20px 40px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }

    header nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    header .logo {
        flex: 1;
    }

    header .logo p {
        font-size: 24px;
        font-weight: bold;
        color: #ff5722;
    }

    header .nav-links {
        display: flex;
        justify-content: flex-end;
        flex: 2;
    }

    header .nav-links a {
        text-decoration: none;
        color: #333;
        padding: 0 15px;
        font-size: 18px;
    }

    header .nav-links a:hover {
        color: #ff5722;
    }

    header .extra-links {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    header .extra-links a {
        text-decoration: none;
        color: #333;
        font-size: 18px;
        position: relative;
    }

    header .extra-links a:hover {
        color: #ff5722;
    }

    #cart-count {
        position: absolute;
        top: -8px;
        right: -10px;
        background: red;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
    }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <p>BoboYum</p>
            </div>
            <div class="nav-links">
                <a href="/product.php">Home</a>
                <a href="/about.php">About Us</a>
                <a href="/products.php">Products</a>
                <a href="/contact.php">Contact</a>
            </div>
            <div class="extra-links">
                <a href="/cart.php" id="cart-icon"><i class="fas fa-shopping-cart"></i>
                    <div id="cart-count"><?php echo $cart_count; ?></div>
                </a>
                <a href="/profile.php"><i class="fas fa-user"></i></a>
            </div>
        </nav>
    </header>
</body>

</html>