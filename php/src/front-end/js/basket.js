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
                    <img src="./image/${item.image}" alt="${item.name}">
                    <h4>${item.name}</h4>
                    <div class="quantity-controls">
                        <button class="btn btn-custom" onclick="updateQuantity(${index}, -1)">-</button>
                        <span>${item.quantity}</span>
                        <button class="btn btn-custom" onclick="updateQuantity(${index}, 1)">+</button>
                    </div>
                </div>
                <button class="btn btn-custom-remove" onclick="removeFromCart(${index})">Remove</button>
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