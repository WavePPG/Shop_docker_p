<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productImage = $_POST['product_image'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = [
            'name' => $productName,
            'image' => $productImage,
            'quantity' => 1,
        ];
    } else {
        $_SESSION['cart'][$productId]['quantity'] += 1;
    }

    echo json_encode(['success' => true]);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Basket</title>
    <style>
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .cart-item img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }
        .placeholder {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            background-color: #ccc;
            display: inline-block;
            text-align: center;
            line-height: 50px;
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>Your Cart</h1>
    <ul>
        <?php
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $total = 0;
        foreach ($cart as $id => $product):
            $total += $product['quantity'];
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($product['image'], '/'); // Ensure the path is correct
        ?>
            <li class="cart-item">
                <?php if (file_exists($imagePath)): ?>
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <?php else: ?>
                    <div class="placeholder">N/A</div>
                    <!-- Debugging: show image path -->
                    <div><?php echo htmlspecialchars($imagePath); ?></div>
                <?php endif; ?>
                <?php echo $product['name']; ?> - Quantity: <?php echo $product['quantity']; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <h2>Total Items: <?php echo $total; ?></h2>
    <a href="product.php">Continue Shopping</a>
</body>
</html>
