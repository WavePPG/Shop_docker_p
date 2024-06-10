<?php
session_start();

// ฟังก์ชันลบสินค้าออกจากตะกร้า
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
}

// ฟังก์ชันเพิ่มจำนวนสินค้าหรือลดจำนวนสินค้า
if (isset($_POST['action']) && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    if ($_POST['action'] == 'add') {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } elseif ($_POST['action'] == 'remove') {
        $_SESSION['cart'][$product_id]['quantity'] -= 1;
        if ($_SESSION['cart'][$product_id]['quantity'] <= 0) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
}

// รีไดเรกไปที่หน้า cart.php เพื่อหลีกเลี่ยงการส่งฟอร์มซ้ำ
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/cart.css">
    <title>Cart - Thai Fabric</title>
    <style>
    body {
        background-color: #fff;

    }

    .cart-container {
        margin-top: 50px;
    }

    .cart-header,
    .cart-total {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #dee2e6;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-item img {
        width: 100px;
        margin-right: 20px;
    }

    .cart-item h2 {
        font-size: 1.25rem;
    }

    .cart-item p {
        margin: 0;
    }

    .cart-item .quantity {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-item .quantity button {
        margin: 0 5px;
        background-color: transparent;
        border: none;
        font-size: 1.25rem;
    }

    .cart-item .quantity button:hover {
        color: #007bff;
    }

    .cart-item .btn {
        margin-left: 10px;
    }

    .checkout-button {
        margin-top: 20px;
    }

    .coupon {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .coupon input {
        flex: 1;
        margin-right: 10px;
    }

    .cart-total-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .cart-total {
        width: 300px;
    }
    </style>
</head>

<body>
    <nav>
        <?php include('./front-end/navbar.php'); ?>
    </nav>

    <div class="container cart-container">
        <h1 class="text-center">Your Cart</h1>
        <?php
        if (!empty($_SESSION['cart'])) {
            echo '<div class="cart-header row">';
            echo '<div class="col-6">Product</div>';
            echo '<div class="col-2 text-center">Price</div>';
            echo '<div class="col-2 text-center">Quantity</div>';
            echo '<div class="col-2 text-center">Subtotal</div>';
            echo '</div>';

            $total = 0;
            foreach ($_SESSION['cart'] as $product_id => $product) {
                $subtotal = $product['price'] * $product['quantity'];
                $total += $subtotal;
                echo '<div class="cart-item row">';
                echo '<div class="col-6">';
                echo '<img src="'.$product['image'].'" class="img-fluid" alt="'.$product['name'].'">';
                echo '<h2 class="d-inline-block">'.$product['name'].'</h2>';
                echo '</div>';
                echo '<div class="col-2 text-center">'.$product['price'].'</div>';
                echo '<div class="col-2 text-center">';
                echo '<div class="quantity">';
                echo '<form action="cart.php" method="post" class="d-inline">';
                echo '<input type="hidden" name="product_id" value="'.$product_id.'">';
                echo '<button type="submit" name="action" value="remove" class="btn btn-sm">-</button>';
                echo $product['quantity'];
                echo '<button type="submit" name="action" value="add" class="btn btn-sm">+</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-2 text-center">'.$subtotal.'</div>';
                echo '</div>';
            }

            echo '<div class="cart-total-container">';
            echo '<div class="cart-total">';
            echo '<h3>Cart Total</h3>';
            echo '<p>Subtotal: '.$total.'</p>';
            echo '<p>Shipping: Free</p>';
            echo '<p>Total: '.$total.'</p>';
            echo '<a href="checkout.php" class="btn btn-danger btn-block">Proceed to Checkout</a>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<p class="text-center">Your cart is empty.</p>';
        }
        ?>
    </div>

    <footer>
        <?php include('./front-end/footer.php'); ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>