<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Thai Fabric</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="product.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cart</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Your Cart</h1>
        <?php
        if (!empty($_SESSION['cart'])) {
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Image</th>';
            echo '<th>Name</th>';
            echo '<th>Price</th>';
            echo '<th>Quantity</th>';
            echo '<th>Actions</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($_SESSION['cart'] as $id => $product) {
                echo '<tr>';
                if (isset($product['image'])) {
                    echo '<td><img src="' . $product['image'] . '" class="img-fluid" style="max-width: 100px;"></td>';
                } else {
                    echo '<td>No image available</td>';
                }
                if (isset($product['name'])) {
                    echo '<td>' . $product['name'] . '</td>';
                } else {
                    echo '<td>No name available</td>';
                }
                if (isset($product['price'])) {
                    echo '<td>' . $product['price'] . '</td>';
                } else {
                    echo '<td>No price available</td>';
                }
                if (isset($product['quantity'])) {
                    echo '<td>' . $product['quantity'] . '</td>';
                } else {
                    echo '<td>No quantity available</td>';
                }
                echo '<td>';
                echo '<form action="add_to_cart.php" method="post" style="display:inline-block;">';
                echo '<input type="hidden" name="product_id" value="' . $id . '">';
                echo '<input type="hidden" name="action" value="add">';
                echo '<button type="submit" class="btn btn-success btn-sm">+</button>';
                echo '</form>';
                echo '<form action="add_to_cart.php" method="post" style="display:inline-block;">';
                echo '<input type="hidden" name="product_id" value="' . $id . '">';
                echo '<input type="hidden" name="action" value="remove">';
                echo '<button type="submit" class="btn btn-warning btn-sm">-</button>';
                echo '</form>';
                echo '<form action="add_to_cart.php" method="post" style="display:inline-block;">';
                echo '<input type="hidden" name="product_id" value="' . $id . '">';
                echo '<input type="hidden" name="action" value="delete">';
                echo '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Your cart is empty.</p>';
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>