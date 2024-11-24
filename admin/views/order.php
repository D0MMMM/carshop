<?php
include "../config/db.php";
include "../backend/orders.php";

// if(!isset($_SESSION['admin'])) {
//     header('Location: ../login.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/style.css">
    <link rel="stylesheet" href="../asset/view-css/orders.css">
    <link rel="stylesheet" href="../lib/datatable/DataTables.css" defer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/bad2460ef5.js" crossorigin="anonymous"></script>
    <title>Orders Management</title>
</head>
<body>
    <?php include "../include/sidebar.php" ?>
    <main>
        <div class="orders-container">
            <h2>Orders Management</h2>
            <div class="filter-section">
                <select id="statusFilter">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            
            <table id="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Products</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $orders_query = "SELECT o.*, u.username 
                                   FROM orders o 
                                   JOIN user u ON o.user_id = u.id 
                                   ORDER BY o.created_at DESC";
                    $orders_result = mysqli_query($conn, $orders_query);
                    
                    while($order = mysqli_fetch_assoc($orders_result)):
                    ?>
                    <tr>
                        <td>#<?= $order['order_id'] ?></td>
                        <td><?= htmlspecialchars($order['contact_name']) ?></td>
                        <td>
                            <?= htmlspecialchars($order['contact_phone']) ?><br>
                            <?= htmlspecialchars($order['contact_email']) ?>
                        </td>
                        <td>
                            <?php
                            $items_query = "SELECT c.make, c.model, oi.quantity 
                                          FROM order_items oi 
                                          JOIN cars c ON oi.car_id = c.id 
                                          WHERE oi.order_id = ?";
                            $items_stmt = $conn->prepare($items_query);
                            $items_stmt->bind_param("i", $order['order_id']);
                            $items_stmt->execute();
                            $items_result = $items_stmt->get_result();
                            
                            while($item = $items_result->fetch_assoc()) {
                                echo htmlspecialchars($item['make'] . ' ' . $item['model'] . ' x' . $item['quantity']) . "<br>";
                            }
                            ?>
                        </td>
                        <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                        <td>
                            <select class="status-select" data-order-id="<?= $order['order_id'] ?>">
                                <option value="pending" <?= $order['order_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="processing" <?= $order['order_status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                <option value="shipped" <?= $order['order_status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                <option value="delivered" <?= $order['order_status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                <option value="cancelled" <?= $order['order_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </td>
                        <td><?= date('Y-m-d H:i', strtotime($order['created_at'])) ?></td>
                        <td>
                            <button class="view-btn" onclick="viewOrder(<?= $order['order_id'] ?>)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/datatable/DataTables.js"></script>
    <script>
        $(document).ready(function() {
            const ordersTable = $('#orders-table').DataTable({
                "order": [[6, "desc"]], // Sort by date descending
                "pageLength": 10
            });

            // Status filter
            $('#statusFilter').on('change', function() {
                ordersTable.column(5).search(this.value).draw();
            });

            // Status update handler
            $('.status-select').on('change', function() {
                const orderId = $(this).data('order-id');
                const newStatus = $(this).val();

                $.post('../backend/update_order_status.php', {
                    order_id: orderId,
                    status: newStatus
                })
                .done(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Updated',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                })
                .fail(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: 'Please try again'
                    });
                });
            });
        });

        function viewOrder(orderId) {
            // Implement order details view
            window.location.href = `order_details.php?id=${orderId}`;
        }
    </script>
    <script src="../asset/app.js"></script>
</body>
</html>