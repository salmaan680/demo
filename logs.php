<?php
require 'includes/auth_session.php';
require 'config/db.php';
$pageTitle = "System Logs";
require 'includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    die("Access Denied");
}

$logs = $conn->query("SELECT l.*, u.email FROM system_logs l LEFT JOIN users u ON l.user_id = u.id ORDER BY l.created_at DESC LIMIT 50")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
    <h3>Audit Trail (Last 50 Actions)</h3>
    <table>
        <thead>
            <tr>
                <th>Time</th>
                <th>User (Email)</th>
                <th>Action</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?php echo $log['created_at']; ?></td>
                <td><?php echo $log['email'] ? $log['email'] : 'System'; ?></td>
                <td><?php echo $log['action']; ?></td>
                <td><?php echo $log['details']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require 'includes/footer.php'; ?>
