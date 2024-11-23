<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $cart_id = $data['cart_id'];
    $quantity = $data['quantity'];
    $user_id = $_SESSION['user_id'];

    // Update the quantity in the cart
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ? AND user_id = ?");
    $stmt->bind_param("iii", $quantity, $cart_id, $user_id);
    if ($stmt->execute()) {
        // Recalculate total payment
        $stmt = $conn->prepare("
            SELECT SUM(c.price * ct.quantity) AS total_payment
            FROM cart ct
            JOIN cars c ON ct.car_id = c.id
            WHERE ct.user_id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $total_payment = $row['total_payment'];

        echo json_encode(['status' => 'success', 'total_payment' => (float)$total_payment]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update quantity']);
    }
}
?>