<?php
require 'includes/auth_session.php';
require 'config/db.php';
$pageTitle = "Performance Reports";
require 'includes/header.php';

// Generate simulated report data
$month = date('m');
$year = date('Y');

if (isset($_GET['month'])) $month = $_GET['month'];
if (isset($_GET['year'])) $year = $_GET['year'];

// Fetch for specific month
$stmt = $conn->prepare("SELECT SUM(amount) as total_sales FROM sales WHERE YEAR(sale_date) = ? AND MONTH(sale_date) = ?");
$stmt->execute([$year, $month]);
$sales = $stmt->fetch()['total_sales'] ?? 0;

$stmt = $conn->prepare("SELECT SUM(amount) as total_expenses FROM expenses WHERE YEAR(expense_date) = ? AND MONTH(expense_date) = ?");
$stmt->execute([$year, $month]);
$expenses = $stmt->fetch()['total_expenses'] ?? 0;

$profit = $sales - $expenses;
?>

<div class="card" style="margin-bottom: 20px;">
    <h3>Generate Report</h3>
    <form method="GET" style="display: flex; gap: 10px; align-items: center; background: none; box-shadow: none; padding: 0;">
        <select name="month" style="margin: 0; width: auto;">
            <?php for($m=1; $m<=12; $m++): ?>
                <option value="<?php echo $m; ?>" <?php if($m==$month) echo 'selected'; ?>><?php echo date('F', mktime(0,0,0,$m, 1)); ?></option>
            <?php endfor; ?>
        </select>
        <select name="year" style="margin: 0; width: auto;">
            <?php for($y=2023; $y<=2030; $y++): ?>
                <option value="<?php echo $y; ?>" <?php if($y==$year) echo 'selected'; ?>><?php echo $y; ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit" style="width: auto;">View Report</button>
        <button type="button" onclick="window.print()" style="width: auto; background-color: #333;">Print / Export PDF</button>
    </form>
    
    <div style="margin-top: 15px; display: flex; gap: 10px;">
        <form action="export.php" method="POST" target="_blank" style="padding: 0; box-shadow: none; background: none;">
            <input type="hidden" name="export_type" value="sales">
            <button type="submit" style="background-color: #28a745; width: auto;">Export Sales (CSV)</button>
        </form>
        <form action="export.php" method="POST" target="_blank" style="padding: 0; box-shadow: none; background: none;">
            <input type="hidden" name="export_type" value="expenses">
            <button type="submit" style="background-color: #dc3545; width: auto;">Export Expenses (CSV)</button>
        </form>
    </div>
</div>

<div class="card" id="report-content">
    <h3>Monthly Performance Report: <?php echo date('F Y', mktime(0,0,0,$month, 1, $year)); ?></h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-top: 20px;">
        <div style="padding: 20px; background: #e8f5e9; border-radius: 8px;">
            <h4>Total Revenue</h4>
            <p style="font-size: 24px; color: green; font-weight: bold;"><?php echo '$' . number_format($sales, 2); ?></p>
        </div>
        <div style="padding: 20px; background: #ffebee; border-radius: 8px;">
            <h4>Total Expenses</h4>
            <p style="font-size: 24px; color: red; font-weight: bold;"><?php echo '$' . number_format($expenses, 2); ?></p>
        </div>
        <div style="padding: 20px; background: #e3f2fd; border-radius: 8px;">
            <h4>Net Profit</h4>
            <p style="font-size: 24px; color: <?php echo $profit >= 0 ? 'blue' : 'orange'; ?>; font-weight: bold;"><?php echo '$' . number_format($profit, 2); ?></p>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
