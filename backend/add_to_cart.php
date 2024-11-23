<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $car_id = isset($_POST['car_id']) ? (int)$_POST['car_id'] : '';
    
    // Enhanced debugging
    error_log("POST data: " . print_r($_POST, true));
    error_log("User ID: " . $user_id);
    error_log("Car ID: " . $car_id);

    if (empty($car_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Car ID is required.']);
        exit();
    }

    try {
        // Check if the car exists - Fix: Match column name
        $check_car = $conn->prepare("SELECT id FROM cars WHERE id = ?");
        $check_car->bind_param("i", $car_id);
        $check_car->execute();
        $car_result = $check_car->get_result();

        if ($car_result->num_rows === 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid car selected.']);
            exit();
        }

        // Check if car is already in cart
        $check_cart = $conn->prepare("SELECT cart_id, quantity FROM cart WHERE user_id = ? AND car_id = ?");
        $check_cart->bind_param("ii", $user_id, $car_id);
        $check_cart->execute();
        $cart_result = $check_cart->get_result();

        if ($cart_result->num_rows > 0) {
            // Update quantity if car already in cart
            $update_stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND car_id = ?");
            $update_stmt->bind_param("ii", $user_id, $car_id);
            $update_stmt->execute();
        } else {
            // Add new item to cart
            $insert_stmt = $conn->prepare("INSERT INTO cart (user_id, car_id, quantity) VALUES (?, ?, 1)");
            $insert_stmt->bind_param("ii", $user_id, $car_id);
            $insert_stmt->execute();
        }

        echo json_encode(['status' => 'success', 'message' => 'Car added to cart successfully.']);
        exit();

    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An error occurred.']);
        exit();
    }
}
?>