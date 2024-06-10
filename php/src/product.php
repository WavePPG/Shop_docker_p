<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="./css/product.css">
    <!-- Include FontAwesome for the cart icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Thai Fabric</title>
</head>

<body>
    <nav>
        <?php include('./front-end/navbar.php'); ?>
    </nav>

    <div class="product-container">
        <?php 
        include('server.php'); 
        
        // คิวรี่ข้อมูลจากฐานข้อมูล
        $query = "SELECT * FROM product";
        $result = mysqli_query($conn, $query);
        
        while($row = mysqli_fetch_assoc($result)) {
            $imagePath = './image/' . $row['image'];
            echo '<div class="product">';
            echo '<img src="'.$imagePath.'" alt="'.$row['pro_name'].'">';
            echo '<h2>'.$row['pro_name'].'</h2>';
            echo '<p>Price: '.$row['price'].'</p>';
            echo '<p>Amount: '.$row['amount'].'</p>';
            echo '<form action="add_to_cart.php" method="post">';
            echo '<input type="hidden" name="product_id" value="'.$row['id'].'">';
            echo '<input type="hidden" name="action" value="add">';
            echo '<button type="submit" class="add-to-cart-btn">ADD to cart</button>';
            echo '</form>';
            echo '</div>';
        }
        ?>
    </div>

    <footer>
        <?php include('./front-end/footer.php'); ?>
    </footer>
</body>

</html>