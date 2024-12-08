<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user information
$user_id = $_SESSION['user_id'];
$query = "SELECT username, email, contact_number FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/includes-css/cart-footer.css">
    <link rel="stylesheet" href="../assets/css/includes-css/cart-header.css">
    <link rel="stylesheet" href="../assets/css/cart.css">
    <link rel="stylesheet" href="../assets/css/account_info.css">
    <link rel="stylesheet" href="../font-awesome/css/all.css">
    <title>My Account</title>
</head>
<body>
    <?php include "../user-includes/header.php"; ?>
    <main>
        <div class="account-info-container" style="margin-top: 10em; max-width: 400px; min-width: 500px">
            <h2>MY ACCOUNT</h2>
            <form id="account-form" action="../backend/update_account.php" method="post">
                <div class="input-container">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="input-container">
                    <i class="fa-solid fa-envelope"></i>
                    <input readonly type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="input-container">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" name="contact" value="<?php echo htmlspecialchars($user['contact_number']); ?>" required>
                </div>
                <input type="submit" value="Update" name="update">
            </form>
        </div>
    </main>
    <?php include "../includes/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Show SweetAlert based on URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('update') && urlParams.get('update') === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Account information updated successfully!'
            });
        } else if (urlParams.has('update') && urlParams.get('update') === 'failed') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Failed to update account information. Please try again.'
            });
        }
    </script>
</body>
</html>