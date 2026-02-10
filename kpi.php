<?php
require 'includes/auth_session.php';
require 'config/db.php';
require 'includes/functions.php';
$pageTitle = "KPI Tracking";
require 'includes/header.php';

// Handle Add KPI
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['metric_name'])) {
    $metric = sanitizeInput($_POST['metric_name']);
    $target = $_POST['target_value'];
    $period = $_POST['period'];
    $role = $_POST['assigned_role'];
    
    $stmt = $conn->prepare("INSERT INTO kpis (metric_name, target_value, period, assigned_role) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$metric, $target, $period, $role])) {
        echo "<script>alert('KPI Target Set!'); window.location.href='kpi.php';</script>";
    }
}

// Fetch KPIs
$kpis = $conn->query("SELECT * FROM kpis")->fetchAll(PDO::FETCH_ASSOC);

function getActualValue($conn, $metric_name, $period) {
    $currentMonth = date('m');
    $currentYear = date('Y');
    $check_metric = strtolower($metric_name);
    
    if (strpos($check_metric, 'sales') !== false) {
        if ($period == 'monthly') {
            $stmt = $conn->prepare("SELECT SUM(amount) as total FROM sales WHERE MONTH(sale_date) = ? AND YEAR(sale_date) = ?");
            $stmt->execute([$currentMonth, $currentYear]);
        } else { 
            $stmt = $conn->prepare("SELECT SUM(amount) as total FROM sales WHERE YEAR(sale_date) = ?");
            $stmt->execute([$currentYear]);
        }
        return $stmt->fetch()['total'] ?? 0;
    } 
    elseif (strpos($check_metric, 'expense') !== false) {
        if ($period == 'monthly') {
            $stmt = $conn->prepare("SELECT SUM(amount) as total FROM expenses WHERE MONTH(expense_date) = ? AND YEAR(expense_date) = ?");
            $stmt->execute([$currentMonth, $currentYear]);
        } else {
            $stmt = $conn->prepare("SELECT SUM(amount) as total FROM expenses WHERE YEAR(expense_date) = ?");
            $stmt->execute([$currentYear]);
        }
        return $stmt->fetch()['total'] ?? 0;
    }
    return 0;
}
?>

<div class="fab-container">
    <button class="btn-primary" onclick="openModal()">
        <i class="fas fa-bullseye"></i> Set New Target
    </button>
</div>

<div class="card">
    <h3>KPI Performance</h3>
    <table>
        <thead>
            <tr>
                <th>Metric</th>
                <th>Target</th>
                <th>Actual</th>
                <th>Period</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kpis as $kpi): 
                $actual = getActualValue($conn, $kpi['metric_name'], $kpi['period']);
                $is_expense = (strpos(strtolower($kpi['metric_name']), 'expense') !== false);
                if ($is_expense) {
                    $on_track = ($actual <= $kpi['target_value']);
                } else {
                    $on_track = ($actual >= $kpi['target_value']);
                }
            ?>
            <tr>
                <td><?php echo $kpi['metric_name']; ?></td>
                <td><?php echo number_format($kpi['target_value']); ?></td>
                <td><?php echo number_format($actual); ?></td>
                <td><?php echo ucfirst($kpi['period']); ?></td>
                <td><?php echo ucfirst($kpi['assigned_role']); ?></td>
                <td>
                    <?php if($on_track): ?>
                        <span style="color: green; font-weight: bold;"><i class="fas fa-check-circle"></i> On Track</span>
                    <?php else: ?>
                        <span style="color: red; font-weight: bold;"><i class="fas fa-exclamation-triangle"></i> Attention</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal-overlay" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Set KPI Target</h3>
            <button class="close-modal" onclick="closeModal()"><i class="fas fa-times"></i></button>
        </div>
        <form action="" method="POST" style="box-shadow: none; padding: 0;">
            <label>Metric Name</label>
            <select name="metric_name">
                <option value="Total Sales">Total Sales</option>
                <option value="Total Expenses">Total Expenses</option>
                <option value="Productivity Index">Productivity Index (Manual)</option>
            </select>

            <label>Target Value</label>
            <input type="number" step="0.01" name="target_value" required placeholder="e.g. 10000">

            <label>Period</label>
            <select name="period">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>

            <label>Assigned Role</label>
            <select name="assigned_role">
                <option value="staff">Staff</option>
                <option value="manager">Manager</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" class="btn-primary" style="width: 100%;">Set Target</button>
            <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('addModal');
    function openModal() { modal.classList.add('active'); }
    function closeModal() { modal.classList.remove('active'); }
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
</script>

<?php require 'includes/footer.php'; ?>
