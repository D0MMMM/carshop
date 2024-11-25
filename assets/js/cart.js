window.addEventListener("scroll", function() {
    var header = document.querySelector("header");
    header.classList.toggle("sticky", window.scrollY > 0);
});

document.querySelectorAll('.quantity-btn').forEach(button => {
    button.addEventListener('click', function() {
        const cartId = this.getAttribute('data-cart-id');
        const action = this.classList.contains('plus-btn') ? 'increase' : 'decrease';
        const quantityElement = this.parentElement.querySelector('.quantity');
        const itemTotalElement = document.querySelector(`tr[data-cart-id="${cartId}"] .item-total`);
        const priceElement = document.querySelector(`tr[data-cart-id="${cartId}"] .price`);
        let quantity = parseInt(quantityElement.textContent);
        const price = parseFloat(priceElement.textContent.replace('₱', '').replace(/,/g, ''));

        if (action === 'increase') {
            quantity++;
        } else if (action === 'decrease' && quantity > 1) {
            quantity--;
        }

        // Update quantity in the database
        fetch('../backend/update_cart_quantity.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ cart_id: cartId, quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                quantityElement.textContent = quantity;
                // Update item total
                const itemTotal = price * quantity;
                itemTotalElement.textContent = `₱${itemTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                // Update total payment
                updateTotalPayment();
            } else {
                alert('Failed to update quantity');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

function updateTotalPayment() {
    let totalPayment = 0;
    document.querySelectorAll('.item-total').forEach(itemTotalElement => {
        const itemTotal = parseFloat(itemTotalElement.textContent.replace('₱', '').replace(/,/g, ''));
        totalPayment += itemTotal;
    });
    document.querySelector('.total-payment h4').textContent = `Total Payment: ₱${totalPayment.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
}