<?php 
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
  header("Location: ../index.php");
  exit();
}
?>

<?php
// Fetch total revenue for today
$today_revenue_query = "SELECT SUM(total_amount) AS today_revenue FROM orders WHERE payment_status = 'paid' AND DATE(created_at) = CURDATE()";
$today_revenue_result = $conn->query($today_revenue_query);
$today_revenue = $today_revenue_result->fetch_assoc()['today_revenue'];

// Fetch total revenue for the current month
$monthly_revenue_query = "SELECT SUM(total_amount) AS monthly_revenue FROM orders WHERE payment_status = 'paid' AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
$monthly_revenue_result = $conn->query($monthly_revenue_query);
$monthly_revenue = $monthly_revenue_result->fetch_assoc()['monthly_revenue'];

// Fetch daily revenue for the current month for the line chart
$daily_revenue_query = "
    SELECT DATE(created_at) AS date, SUM(total_amount) AS daily_revenue 
    FROM orders 
    WHERE payment_status = 'paid' AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())
    GROUP BY DATE(created_at)
    ORDER BY DATE(created_at)
";
$daily_revenue_result = $conn->query($daily_revenue_query);

$dates = [];
$daily_revenues = [];
while ($row = $daily_revenue_result->fetch_assoc()) {
    $dates[] = $row['date'];
    $daily_revenues[] = $row['daily_revenue'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Revenue Dashboard</title>
  <link rel="stylesheet" href="../asset/style.css">
  <link rel="stylesheet" href="../../font-awesome/css/all.css">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <?php include "../include/sidebar.php"?>
  <main class="p-6 md:p-10">
    <h1 class="text-3xl font-bold mb-3"><i class="fa-solid fa-chart-simple"></i> REVENUE DASHBOARD</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold">TODAY'S REVENUE <i class="fa-solid fa-chart-line"></i></h2>
        <p class="text-3xl mt-4">₱<?= number_format($today_revenue, 2) ?></p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold">MONTHLY REVENUE <i class="fa fa-bar-chart"></i></h2>
        <p class="text-3xl mt-4">₱<?= number_format($monthly_revenue, 2) ?></p>
      </div>
    </div>
    <div class="mt-10 bg-white p-6 rounded-lg shadow-md">
      <div class="mt-10 flex justify-start overflow-hidden">
        <div class="w-full md:w-2/3 lg:w-1/2">
          <canvas id="revenueChart"></canvas>
        </div>
      </div>
    </div>
  </main>
  <script src="../asset/app.js"></script>
  <script>
    // Chart.js script to create a line chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?= json_encode($dates) ?>,
        datasets: [{
          label: 'Daily Revenue',
          data: <?= json_encode($daily_revenues) ?>,
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1,
          fill: true
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>
</html>