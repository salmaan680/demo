<?php
require 'includes/auth_session.php';
require 'config/db.php';
require 'includes/functions.php';
$pageTitle = "Expense Management";
require 'includes/header.php';

// Check permissions
if ($_SESSION['role'] == 'staff') {
    echo "<div class='alert error'>Access Denied. Managers and Admins only.</div>";
    require 'includes/footer.php';
    exit();
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $category = sanitizeInput($_POST['category']);
    $date = $_POST['date'];
    $desc = sanitizeInput($_POST['description']);
    $user_id = $_SESSION['user_id'];

    if (!empty($amount) && !empty($date)) {
        $stmt = $conn->prepare("INSERT INTO expenses (user_id, amount, category, description, expense_date) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$user_id, $amount, $category, $desc, $date])) {
            logAction($conn, $user_id, "Add Expense", "Added expense of $$amount for $category");
            echo "<script>alert('Expense added successfully!'); window.location.href='expenses.php';</script>";
        } else {
            echo "<div class='alert error'>Error adding expense.</div>";
        }
    }
}

// Fetch Expenses
$expenses = $conn->query("SELECT e.*, u.full_name as added_by FROM expenses e JOIN users u ON e.user_id = u.id ORDER BY e.expense_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="fab-container">
    <button class="btn-primary" onclick="openModal()">
        <i class="fas fa-plus"></i> Add New Expense
    </button>
</div>

<div class="card">
    <h3>Expense History</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Added By</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expenses as $expense): ?>
            <tr>
                <td><?php echo $expense['expense_date']; ?></td>
                <td><span style="background: #eee; padding: 2px 8px; border-radius: 4px; font-size: 12px;"><?php echo $expense['category']; ?></span></td>
                <td><strong style="color: #e74c3c;"><?php echo '$' . number_format($expense['amount'], 2); ?></strong></td>
                <td><?php echo $expense['added_by']; ?></td>
                <td><small><?php echo $expense['description']; ?></small></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal-overlay" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Expense</h3>
            <button class="close-modal" onclick="closeModal()"><i class="fas fa-times"></i></button>
        </div>
        <form action="" method="POST" style="box-shadow: none; padding: 0;">
            <label>Amount ($)</label>
            <input type="number" step="0.01" name="amount" required placeholder="0.00">

            <label>Category</label>
            <select name="category">
                <option value="Operational">Operational</option>
                <option value="Marketing">Marketing</option>
                <option value="Salaries">Salaries</option>
                <option value="Utilities">Utilities</option>
                <option value="Other">Other</option>
            </select>

            <label>Date</label>
            <input type="date" name="date" required value="<?php echo date('Y-m-d'); ?>">

            <label>Description</label>
            <textarea name="description" placeholder="Why was this spent?"></textarea>

            <button type="submit" class="btn-primary" style="width: 100%;">Save Expense</button>
            <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('addModal');

    function openModal() {
        modal.classList.add('active');
    }

    function closeModal() {
        modal.classList.remove('active');
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
</script>

<?php require 'includes/footer.php'; ?>
