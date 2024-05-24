<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/product.css">
    <title>Thai Fabric</title>
</head>
<body>
    <header>
        <nav>
        <div class="logo">
            <p>BoboYum</p>
        </div>

            <div class="nav-links">
                <a href="#">Home</a>
                <a href="#">About Us</a>
                <a href="#">Products</a>
                <a href="#">Contact</a>
            </div>
        </nav>
    </header>
    <div class="main-content">
        <section class="hero">
            <h1>ร้าน BoboYum</h1>
            <p>Welcome to BoboYums, your premier destination for exquisite Thai fabrics. Discover the beauty and craftsmanship of our unique collection, perfect for your home.</p>
            <button>Shop Now</button>
        </section>
        <section class="products">
            <?php 
            include('server.php'); 

            // Fetch and display data from the product table
            $sql_select = "SELECT * FROM product";
            $result_select = mysqli_query($conn, $sql_select);
            $product_count = 0; // Initialize counter

            if (mysqli_num_rows($result_select) > 0) {
                while($row = mysqli_fetch_assoc($result_select)) {
                    if ($product_count < 4) { // Display maximum 4 products
                        echo "<div class='product'>
                                <img src='./image/{$row['image']}' alt='{$row['pro_name']}'>
                                <h3>{$row['pro_name']}</h3>

                                
                              </div>";
                        $product_count++; // Increment counter
                    }
                }
            } else {
                echo "<p>No products found.</p>";
            }

            mysqli_close($conn);
            ?>
        </section>
    </div>
    <footer>
        <p>&copy; 2024 Thai Fabric. All rights reserved.</p>
    </footer>
</body>
</html>
