<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch order history for the user
$order_stmt = $conn->prepare("
    SELECT o.order_id, o.total_amount, o.order_status, o.payment_status, o.created_at
    FROM orders o
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
");
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/includes-css/cart-footer.css">
    <link rel="stylesheet" href="../assets/css/includes-css/cart-header.css">
    <link rel="stylesheet" href="../assets/css/cart.css">
    <link rel="stylesheet" href="../assets/css/order_history.css">
    <link rel="stylesheet" href="../font-awesome/css/all.css">
    <title>Order History</title>
</head>
<body>
    <?php include "../user-includes/header.php" ?>

    <main>
        <div class="order-history-container">
            <h2>Your Order History</h2>
            <div class="filter-container">
                <label for="filter-status">Filter by Status:</label>
                <select id="filter-status">
                    <option value="all">All</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <label for="sort-date">Sort by Date:</label>
                <select id="sort-date">
                    <option value="desc">Newest First</option>
                    <option value="asc">Oldest First</option>
                </select>
            </div>
            <?php if ($order_result->num_rows > 0): ?>
                <table id="order-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Total Amount</th>
                            <th>Order Status</th>
                            <th>Payment Status</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $order_result->fetch_assoc()): ?>
                            <tr data-status="<?= htmlspecialchars($order['order_status']) ?>">
                                <td><?= htmlspecialchars($order['order_id']) ?></td>
                                <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                                <td><?= htmlspecialchars($order['order_status']) ?></td>
                                <td><?= htmlspecialchars($order['payment_status']) ?></td>
                                <td><?= htmlspecialchars($order['created_at']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You have no orders yet.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../includes/footer.php' ?>
    <script src="../assets/js/order_history.js"></script>
</body>
</html>