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
            max-width: 1600px;
            margin: 0 auto; /* Center the container */
            padding: 0 15px; /* Optional padding for spacing */
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
            display: flex;
            justify-content: center; /* Centering the logo */
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
            white-space: nowrap; /* Prevents text wrapping */
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

        header .extra-links a #cart-count {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #ff5722;
            color: #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        /* Ensure consistent padding and margin for body content */
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <p>BoboYum</p>
            </div>
            <div class="nav-links">
                <a href="../product.php">Home</a>
                <a href="#">About Us</a>
                <a href="#">Products</a>
                <a href="#">Contact</a>
            </div>
            <div class="extra-links">
                <a href="../front-end/basket.php" id="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <div id="cart-count">0</div>
                </a>
                <a href="#"><i class="fas fa-user"></i></a>
            </div>
        </nav>
    </header>
    <main>
        <!-- Page specific content goes here -->
    </main>
</body>
</html>
