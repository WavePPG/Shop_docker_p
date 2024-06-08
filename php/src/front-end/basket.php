<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/product.css">
    <title>Your Cart</title>
</head>
<body>
    <nav>
        <?php include('navbar.php'); ?>
    </nav>

    <div class="cart-content" id="cart-content">
        <!-- Cart items will be populated here -->
    </div>

    <footer>
        <?php include('footer.php'); ?>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            function updateCartUI() {
                const cartContent = document.getElementById('cart-content');
                if (cartContent) {
                    cartContent.innerHTML = ''; // Clear previous content
                    if (cart.length === 0) {
                        cartContent.innerHTML = '<p>Your cart is empty.</p>';
                        return;
                    }
                    cart.forEach((item, index) => {
                        const cartItem = document.createElement('div');
                        cartItem.className = 'cart-item';
                        cartItem.innerHTML = `
                            <div class="cart-item-details">
                                <img src="${item.image}" alt="${item.name}" onerror="this.onerror=null;this.src='default-image.jpg';">
                                <h4>${item.name}</h4>
                                <div class="quantity-controls">
                                    <button onclick="updateQuantity(${index}, -1)">-</button>
                                    <span>${item.quantity}</span>
                                    <button onclick="updateQuantity(${index}, 1)">+</button>
                                </div>
                            </div>
                            <button onclick="removeFromCart(${index})">Remove</button>
                        `;
                        cartContent.appendChild(cartItem);
                    });
                }

                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = cart.reduce((total, product) => total + product.quantity, 0);
                }
            }

            window.updateQuantity = function (index, change) {
                if (cart[index].quantity + change > 0) {
                    cart[index].quantity += change;
                } else {
                    cart.splice(index, 1);
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
            };

            window.removeFromCart = function (index) {
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
            };

            updateCartUI();
        });
    </script>
</body>
</html>
