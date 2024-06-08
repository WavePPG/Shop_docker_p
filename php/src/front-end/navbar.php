<!DOCTYPE html>
< lang="en">
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

        #cart-count {
            position: absolute;
            top: -8px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }

        .cart {
            position: fixed;
            top: 0;
            right: -100%;
            width: 450px;
            height: 100%;
            background-color: #fff;
            box-shadow: -2px 0 5px rgba(0,0,0,0.5);
            overflow-y: auto;
            transition: right 0.3s ease;
            z-index: 2000;
        }

        .cart.open {
            right: 0;
        }

        .cart-header {
            padding: 20px;
            background-color: #f5f5f5;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-content {
            padding: 20px;
        }

        .cart-item {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-item img {
            max-width: 50px;
            margin-right: 10px;
        }

        .cart-item-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-grow: 1;
        }

        .cart-item h4 {
            margin: 0;
        }

        .cart-item .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cart-item .quantity-controls button {
            background: #ff5722;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .cart-footer {
            padding: 20px;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: center;
        }
        .cart {
    position: fixed;
    top: 0;
    right: -450px; /* Adjusted to fully hide the cart off-screen */
    width: 450px;
    height: 100%;
    background-color: #fff;
    box-shadow: -2px 0 5px rgba(0,0,0,0.5);
    overflow-y: auto;
    transition: right 0.3s ease-in-out; /* Smooth transition effect */
    z-index: 2000;
}

.cart.open {
    right: 0;
}

    </style>
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
                <a href="">Contact</a>
            </div>
            <div class="extra-links">
                <a href="#" id="cart-icon"><i class="fas fa-shopping-cart"></i><div id="cart-count">0</div></a>
                <a href="#"><i class="fas fa-user"></i></a>
            </div>
        </nav>
    </header>

    <div class="cart" id="cart">
        <div class="cart-header">
            <h2>Your Cart</h2>
        </div>
        <div class="cart-content" id="cart-content">
            <!-- Cart items will be displayed here -->
        </div>
        <div class="cart-footer">
            <button type="button" class="btn btn-danger" onclick="closeCart()">Close</button>
        </div>
    </div>

<script>
    document.getElementById('cart-icon').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link action
        document.getElementById('cart').classList.toggle('open');
    });

    function closeCart() {
        document.getElementById('cart').classList.remove('open');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        function updateCartUI() {
            const cartContent = document.getElementById('cart-content');
            cartContent.innerHTML = ''; // Clear previous content
            cart.forEach((item, index) => {
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <div class="cart-item-details">
                        <img src="${item.image}" alt="${item.name}">
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

            const cartCount = document.getElementById('cart-count');
            cartCount.textContent = cart.reduce((total, product) => total + product.quantity, 0);
        }

        window.addToCart = function(productId, productName, productImage) {
            const existingProduct = cart.find(product => product.id === productId);
            if (existingProduct) {
                existingProduct.quantity++;
            } else {
                cart.push({ id: productId, name: productName, image: productImage, quantity: 1 });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
        };

        window.updateQuantity = function(index, change) {
            if (cart[index].quantity + change > 0) {
                cart[index].quantity += change;
            } else {
                    cart.splice(index, 1);
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
        };

        window.removeFromCart = function(index) {
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
        };

        updateCartUI();
    });
</script>

</body>
</html>
