<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];
    $user_id = $_SESSION['user_id'];

    // Remove the item from the cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    if ($stmt->execute()) {
        header('Location: ../frontend/cart.php?status=removed');
        exit();
    } else {
        echo "Error: Could not remove item from cart.";
    }
}
?>