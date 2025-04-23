//cart features

document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        
        // Send to server via AJAX
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&action=add`
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Update cart counter if you have one
                const cartCount = document.getElementById('cart-count');
                if(cartCount) {
                    cartCount.textContent = data.cart_count;
                }
                alert('Product added to cart!');
            }
        });
    });
});