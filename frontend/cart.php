<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items with car details
$stmt = $conn->prepare("
    SELECT c.id, c.make, c.model, c.price, c.image_path, ct.quantity, ct.cart_id 
    FROM cart ct 
    JOIN cars c ON ct.car_id = c.id 
    WHERE ct.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_payment = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/cart.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../font-awesome/css/all.css">
    <link rel="stylesheet" href="../assets/css/includes-css/footer.css">
    <script src="https://kit.fontawesome.com/bad2460ef5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Shopping Cart</title>
</head>
<body>
    <?php include "../user-includes/header.php" ?>
    
    <div class="cart-container">
        <h2>Your Cart</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php $total_payment += $row['price'] * $row['quantity']; ?>
                <div class="cart-item">
                    <img src="../admin/asset/uploaded_img/<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['model']) ?>">
                    <div class="item-details">
                        <h3><?= htmlspecialchars($row['make']) ?> <?= htmlspecialchars($row['model']) ?></h3>
                        <p class="price">₱<?= number_format($row['price'], 2) ?></p>
                        <div class="quantity-container">
                            <button class="quantity-btn minus-btn" data-cart-id="<?= $row['cart_id'] ?>">-</button>
                            <p class="quantity"><?= htmlspecialchars($row['quantity']) ?></p>
                            <button class="quantity-btn plus-btn" data-cart-id="<?= $row['cart_id'] ?>">+</button>
                        </div>
                        <form action="../backend/remove_from_cart.php" method="POST">
                            <input type="hidden" name="cart_id" value="<?= $row['cart_id'] ?>">
                            <button type="submit" class="remove-btn">Remove</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
            <div class="total-payment">
                <h3>Total Payment: ₱<?= number_format($total_payment, 2) ?></h3>
            </div>
            <div class="checkout-btn-container">
                <form action="checkout.php" method="POST">
                    <button type="submit" class="checkout-btn">Proceed to Checkout</button>
                </form>
            </div>
        <?php else: ?>
            <p class="empty-cart">Your cart is empty</p>
        <?php endif; ?>
    </div>

    <?php //include '../includes/footer.php' ?>

    <script>
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const cartId = this.getAttribute('data-cart-id');
                const action = this.classList.contains('plus-btn') ? 'increase' : 'decrease';
                const quantityElement = this.parentElement.querySelector('.quantity');
                let quantity = parseInt(quantityElement.textContent);

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
                        // Update total payment with comma format
                        document.querySelector('.total-payment h3').textContent = `Total Payment: ₱${parseFloat(data.total_payment).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    } else {
                        alert('Failed to update quantity');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    </script>
</body>
</html>