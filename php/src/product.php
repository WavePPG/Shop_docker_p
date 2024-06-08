<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="./css/product.css">
    <title>Thai Fabric</title>
</head>
<body>
    <nav>
        <?php include('./front-end/navbar.php'); ?>
    </nav>

    <div class="main-content">
        <section class="hero">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="hero.jpg" alt="Image 1">
                        <h1></h1>
                        <p></p>
                    </div>
                    <div class="swiper-slide">
                        <img src="โปรโมชั่น.jpg" alt="Image 2">
                        <h1></h1>
                        <p></p>
                    </div>
                    <div class="swiper-slide">
                        <img src="path/to/your/image3.jpg" alt="Image 3">
                        <h1>Craftsmanship at Its Best</h1>
                        <p>Experience the finest quality of Thai fabrics, crafted with care and precision. Your satisfaction is our priority.</p>
                        <button>Shop Now</button>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>
        
        <section id='test'>
            <h1>Menu</h1>
        </section>
        
        <section class="products">
            <?php 
            include('server.php'); 

            // Fetch and display data from the product table
            $sql_select = "SELECT * FROM product";
            $result_select = mysqli_query($conn, $sql_select);

            if (mysqli_num_rows($result_select) > 0) {
                while($row = mysqli_fetch_assoc($result_select)) {
                    echo "<div class='product'>
                            <img src='./image/{$row['image']}' alt='{$row['pro_name']}'>
                            <h3>{$row['pro_name']}</h3>
                            <button class='add-to-cart' data-id='{$row['id']}' data-name='{$row['pro_name']}' data-image='./image/{$row['image']}'>Add to Cart</button>
                          </div>";
                }
            } else {
                echo "<p>No products found.</p>";
            }

            mysqli_close($conn);
            ?>
        </section>
    </div>

    <footer>
        <?php include('./front-end/footer.php');?>
    </footer>
    
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>

</body>
</html>
