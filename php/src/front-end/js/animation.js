document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.add-to-cart');
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productImage = this.getAttribute('data-image');
            addToCart(productId, productName, productImage);
            
            // Create animation div
            const animationDiv = document.createElement('div');
            animationDiv.classList.add('cart-animation');
            this.appendChild(animationDiv);
            
            // Remove animation div after animation ends
            animationDiv.addEventListener('animationend', () => {
                animationDiv.remove();
            });
        });
    });
});

function addToCart(productId, productName, productImage) {
    // Your existing add to cart functionality
    console.log(`Added ${productName} to cart.`);
}
