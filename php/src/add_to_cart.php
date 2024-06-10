<?php
session_start();
include('server.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id']) && isset($_POST['action'])) {
        $product_id = $_POST['product_id'];
        $action = $_POST['action'];

        if ($action == 'add') {
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += 1;
            } else {
                $query = "SELECT * FROM product WHERE id = $product_id";
                $result = mysqli_query($conn, $query);
                $product = mysqli_fetch_assoc($result);

                $_SESSION['cart'][$product_id] = [
                    "name" => $product['pro_name'],
                    "price" => $product['price'],
                    "quantity" => 1,
                    "image" => './image/' . $product['image']
                ];
            }
        } elseif ($action == 'remove') {
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] -= 1;
                if ($_SESSION['cart'][$product_id]['quantity'] <= 0) {
                    unset($_SESSION['cart'][$product_id]);
                }
            }
        } elseif ($action == 'delete') {
            if (isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
        header("Location: cart.php");
        exit();
    } else {
        // Redirect to the cart page if product_id or action is missing
        header("Location: cart.php");
        exit();
    }
} else {
    // Redirect to the cart page if not a POST request
    header("Location: cart.php");
    exit();
}
?>