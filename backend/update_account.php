<?php
session_start();
include "../config/db.php";

if (isset($_POST['update'])) {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // Update user information
    $query = "UPDATE user SET username = ?, email = ?, contact_number = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $username, $email, $contact, $user_id);

    if ($stmt->execute()) {
        header("Location: ../frontend/account_info.php?update=success");
    } else {
        header("Location: ../frontend/account_info.php?update=failed");
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>