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
while ($row = $result->fetch_assoc()) {
    $total_payment += $row['price'] * $row['quantity'];
}

// Here you would typically process the payment and create an order record in the database

// Clear the cart after checkout
$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

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
    <title>Checkout</title>
</head>
<body>
    <?php include "../user-includes/header.php" ?>
    
    <div class="checkout-container">
        <h2>Checkout Complete</h2>
        <p>Thank you for your purchase! Your total payment is ₱<?= number_format($total_payment, 2) ?>.</p>
        <a href="../frontend/dashboard.php" class="btn">Continue Shopping</a>
    </div>

    <?php //include '../includes/footer.php' ?>
</body>
</html>