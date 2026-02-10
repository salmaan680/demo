<?php
// Get current page name for active state
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">
    <h2><i class="fas fa-chart-line"></i> BP Tracker</h2>
    <ul>
        <li><a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> Dashboard
        </a></li>
        
        <li><a href="profile.php" class="<?php echo $current_page == 'profile.php' ? 'active' : ''; ?>">
            <i class="fas fa-user-circle"></i> My Profile
        </a></li>
        
        <?php if($_SESSION['role'] === 'admin'): ?>
            <li><a href="users.php" class="<?php echo $current_page == 'users.php' ? 'active' : ''; ?>">
                <i class="fas fa-users-cog"></i> Manage Users
            </a></li>
        <?php endif; ?>
        
        <li><a href="sales.php" class="<?php echo $current_page == 'sales.php' ? 'active' : ''; ?>">
            <i class="fas fa-dollar-sign"></i> Sales Tracking
        </a></li>
        
        <?php if($_SESSION['role'] !== 'staff'): ?>
            <li><a href="expenses.php" class="<?php echo $current_page == 'expenses.php' ? 'active' : ''; ?>">
                <i class="fas fa-wallet"></i> Manage Expenses
            </a></li>
            <li><a href="kpi.php" class="<?php echo $current_page == 'kpi.php' ? 'active' : ''; ?>">
                <i class="fas fa-bullseye"></i> KPI Operations
            </a></li>
            <li><a href="employees.php" class="<?php echo $current_page == 'employees.php' ? 'active' : ''; ?>">
                <i class="fas fa-user-check"></i> Employee Perf.
            </a></li>
            <li><a href="reports.php" class="<?php echo $current_page == 'reports.php' ? 'active' : ''; ?>">
                <i class="fas fa-file-invoice-dollar"></i> Reports
            </a></li>
        <?php endif; ?>
        
        <?php if($_SESSION['role'] === 'admin'): ?>
            <li><a href="logs.php" class="<?php echo $current_page == 'logs.php' ? 'active' : ''; ?>">
                <i class="fas fa-history"></i> System Logs
            </a></li>
        <?php endif; ?>
        
        <li><a href="logout.php">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a></li>
    </ul>
</div>
