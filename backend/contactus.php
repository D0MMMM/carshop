<?php
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect form inputs
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert data into the database
    $sql = "INSERT INTO `inquire` (`first_name`, `last_name`, `email`, `message`) VALUES ('$first_name', '$last_name', '$email', '$message')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "success"; // Send success response
    } else {
        echo "error"; // Send error response
    }
}
?>
