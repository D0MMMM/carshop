// Chart.js script to create a bar chart
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Total Cars', 'Total Users', 'Total Revenue', 'Total Orders'],
    datasets: [{
      label: 'Statistics',
      data: [<?= $total_cars ?>, <?= $total_users ?>, <?= $total_revenue ?>, <?= $total_orders ?>],
      backgroundColor: [
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(153, 102, 255, 0.2)'
      ],
      borderColor: [
        'rgba(75, 192, 192, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(153, 102, 255, 1)'
      ],
      borderWidth: 1
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

// Chart.js script to create a pie chart for sales analytics
const salesCtx = document.getElementById('salesPieChart').getContext('2d');
const salesPieChart = new Chart(salesCtx, {
  type: 'pie',
  data: {
    labels: <?= json_encode($dates) ?>,
    datasets: [{
      label: 'Daily Sales',
      data: <?= json_encode($daily_sales) ?>,
      backgroundColor: [
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(201, 203, 207, 0.2)',
        'rgba(255, 99, 132, 0.2)'
      ],
      borderColor: [
        'rgba(75, 192, 192, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 99, 132, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255, 205, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(201, 203, 207, 1)',
        'rgba(255, 99, 132, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      tooltip: {
        callbacks: {
          label: function(tooltipItem) {
            return '₱ ' + tooltipItem.raw.toLocaleString();
          }
        }
      }
    }
  }
});

// Chart.js script to create a line chart for total users, cars, and orders
const userCarsOrdersCtx = document.getElementById('userCarsOrdersLineChart').getContext('2d');
const userCarsOrdersLineChart = new Chart(userCarsOrdersCtx, {
  type: 'line',
  data: {
    labels: <?= json_encode($user_dates) ?>,
    datasets: [
      {
        label: 'Daily Users',
        data: <?= json_encode($daily_users) ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        fill: true
      },
      {
        label: 'Daily Cars',
        data: <?= json_encode($daily_cars) ?>,
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        fill: true
      },
      {
        label: 'Daily Orders',
        data: <?= json_encode($daily_orders) ?>,
        backgroundColor: 'rgba(255, 206, 86, 0.2)',
        borderColor: 'rgba(255, 206, 86, 1)',
        borderWidth: 1,
        fill: true
      }
    ]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});