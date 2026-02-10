<?php
require 'includes/auth_session.php';
require 'config/db.php';
$pageTitle = "Dashboard";
require 'includes/header.php';

// Fetch quick stats
$total_sales = 0;
$total_expenses = 0;
$net_profit = 0;

// Sales
$stmt = $conn->query("SELECT SUM(amount) as total FROM sales");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_sales = $row['total'] ? $row['total'] : 0;

// Expenses
$stmt = $conn->query("SELECT SUM(amount) as total FROM expenses");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_expenses = $row['total'] ? $row['total'] : 0;

$net_profit = $total_sales - $total_expenses;

// Monthly Data for Chart
$months = [];
$sales_data = [];
$expenses_data = [];

for ($i = 5; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i months"));
    $months[] = date('M Y', strtotime("-$i months"));
    
    // Sales for this month
    $stmt = $conn->prepare("SELECT SUM(amount) as total FROM sales WHERE DATE_FORMAT(sale_date, '%Y-%m') = ?");
    $stmt->execute([$month]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sales_data[] = $row['total'] ? $row['total'] : 0;

    // Expenses for this month
    $stmt = $conn->prepare("SELECT SUM(amount) as total FROM expenses WHERE DATE_FORMAT(expense_date, '%Y-%m') = ?");
    $stmt->execute([$month]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $expenses_data[] = $row['total'] ? $row['total'] : 0;
}
?>

<div class="cards-container">
    <div class="card">
        <h3>Total Sales</h3>
        <p style="color: green;"><?php echo '$' . number_format($total_sales, 2); ?></p>
    </div>
    <div class="card">
        <h3>Total Expenses</h3>
        <p style="color: red;"><?php echo '$' . number_format($total_expenses, 2); ?></p>
    </div>
    <div class="card">
        <h3>Net Profit</h3>
        <p style="color: <?php echo $net_profit >= 0 ? 'blue' : 'orange'; ?>;"><?php echo '$' . number_format($net_profit, 2); ?></p>
    </div>
</div>

<div class="chart-container" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <canvas id="performanceChart"></canvas>
</div>

<script>
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Sales',
                data: <?php echo json_encode($sales_data); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Expenses',
                data: <?php echo json_encode($expenses_data); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
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
</script>

<?php require 'includes/footer.php'; ?>
