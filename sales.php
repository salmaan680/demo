<?php
require 'includes/auth_session.php';
require 'config/db.php';
require 'includes/functions.php';
$pageTitle = "Sales Tracking";
require 'includes/header.php';

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $customer = sanitizeInput($_POST['customer']);
    $date = $_POST['date'];
    $desc = sanitizeInput($_POST['description']);
    $user_id = $_SESSION['user_id'];

    if (!empty($amount) && !empty($date)) {
        $stmt = $conn->prepare("INSERT INTO sales (user_id, amount, customer_name, description, sale_date) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$user_id, $amount, $customer, $desc, $date])) {
            logAction($conn, $user_id, "Add Sale", "Added sale of $$amount");
            echo "<script>alert('Sale added successfully!'); window.location.href='sales.php';</script>";
        } else {
            echo "<div class='alert error'>Error adding sale.</div>";
        }
    }
}

// Fetch Sales
$sales = $conn->query("SELECT s.*, u.full_name as added_by FROM sales s JOIN users u ON s.user_id = u.id ORDER BY s.sale_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="fab-container">
    <button class="btn-primary" onclick="openModal()">
        <i class="fas fa-plus"></i> Add New Sale
    </button>
</div>

<div class="card">
    <h3>Recent Sales History</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Added By</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sales as $sale): ?>
            <tr>
                <td><?php echo $sale['sale_date']; ?></td>
                <td><?php echo $sale['customer_name']; ?></td>
                <td><strong style="color: var(--primary-color);"><?php echo '$' . number_format($sale['amount'], 2); ?></strong></td>
                <td><?php echo $sale['added_by']; ?></td>
                <td><small><?php echo $sale['description']; ?></small></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal-overlay" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Sale</h3>
            <button class="close-modal" onclick="closeModal()"><i class="fas fa-times"></i></button>
        </div>
        <form action="" method="POST" style="box-shadow: none; padding: 0;">
            <label>Amount ($)</label>
            <input type="number" step="0.01" name="amount" required placeholder="0.00">

            <label>Customer Name</label>
            <input type="text" name="customer" placeholder="Client or Company Name">

            <label>Date</label>
            <input type="date" name="date" required value="<?php echo date('Y-m-d'); ?>">

            <label>Description</label>
            <textarea name="description" placeholder="Optional details..."></textarea>

            <button type="submit" class="btn-primary" style="width: 100%;">Save Record</button>
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

    // Close on click outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });
</script>

<?php require 'includes/footer.php'; ?>
