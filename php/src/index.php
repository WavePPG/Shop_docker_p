<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCW Home</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="/component/navbar.css">
    <!-- Swiper CDN -->
    <link rel="stylesheet" href="/swiperCDN/swiper-bundle.min.css">
    <!-- Font awesome -->
    <link rel="stylesheet" href="/fontawesomeCDN/fontawesome.min.css">
    <!-- Font awesome ฉุกเฉิน -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
<nav>
<?php include("navbar.php") ?>
</nav>
<div class="container mt-5">
    <div class="row">
        <?php 
        include('server.php'); 
        
        // Fetch and display data from the product table
        $sql_select = "SELECT * FROM product";
        $result_select = mysqli_query($conn, $sql_select);

        if (mysqli_num_rows($result_select) > 0) {
            $count = 0;
            while($row = mysqli_fetch_assoc($result_select)) {
                if ($count % 4 == 0 && $count != 0) {
                    echo "</div><div class='row mt-4'>";
                }
                echo "<div class='product-category'>
                    <div class='product-category-row'>
                        <div class='product-category-col'>
                            <div class='image'><img src='./image/{$row['image']}' alt='{$row['pro_name']}'></div>
                                <div class='content'>
                                    <h2><a href=''>{$row['pro_name']} <br>Price: {$row['price']} <br> Amount: {$row['amount']}</a></h2>
                                </div>
                            </div>
                        </div>
                    </div>";
                    
                $count++;
            }
            echo "</div>";
        } else {
            echo "<p>No products found.</p>";
        }

        mysqli_close($conn);
        ?>
    </div>
</div>
    <!-- Product category -->
    <section class="product-category">
        <div class="product-category-row">

            <div class="product-category-col">
                <div class="image"><img src="/shopImage/show-2.jpg" alt=""></div>
                <div class="content">
                    <h2><a href="">MEN <br>FASHION</a></h2>
                </div>
            </div>

            <div class="product-category-col">
                <div class="image"><img src="/shopImage/show-3.jpg" alt=""></div>
                <div class="content">
                    <h2><a href="">WOMEN <br>FASHION</a></h2>
                </div>
            </div>

            <div class="product-category-col">
                <div class="image"><img src="/shopImage/show-1.jpg" alt=""></div>
                <div class="content">
                    <h2><a href="">OTHER <br>FASHION</a></h2>
                </div>
            </div>

        </div>
    </section>

    <!-- Popular section -->
    <section class="popular">

        <div class="container">

            <div class="header-content">
                <h2>Popular Product</h2>
                <p>Lorem, adipisicing elit. Unde ab aut consequuntur quos rem nostrum.</p>
            </div>


            <div class="popular-row">
                <!-- <div class="popular-col">
                <div class="image"><img src="/shopImage/product-01.jpg" alt=""></div>
                <div class="content">
                    <h2 class="pouular-name"></h2>
                    <p class="pouular-priice"></p>
                </div>
            </div> -->
            </div>

            <div class="vm">
                <a href="shop.html" class="viewMore">View More</a>
            </div>


        </div>

    </section>
