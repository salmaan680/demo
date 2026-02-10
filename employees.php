<?php
require 'includes/auth_session.php';
require 'config/db.php';
require 'includes/functions.php';
$pageTitle = "Employee Performance";
require 'includes/header.php';

// Fetch Employees
$employees = $conn->query("SELECT id, full_name, role FROM users WHERE role != 'admin'")->fetchAll(PDO::FETCH_ASSOC);

// Handle Review Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['employee_id'])) {
    $emp_id = $_POST['employee_id'];
    $rating = $_POST['rating'];
    $comments = sanitizeInput($_POST['comments']);
    $reviewer = $_SESSION['user_id'];
    $date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO employee_performance (employee_id, reviewer_id, rating, comments, review_date) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$emp_id, $reviewer, $rating, $comments, $date])) {
        echo "<script>alert('Review Submitted!'); window.location.href='employees.php';</script>";
    }
}

// Fetch Reviews
$reviews = $conn->query("SELECT r.*, e.full_name as employee, x.full_name as reviewer FROM employee_performance r JOIN users e ON r.employee_id = e.id JOIN users x ON r.reviewer_id = x.id ORDER BY r.review_date DESC")->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="fab-container">
    <button class="btn-primary" onclick="openModal()">
        <i class="fas fa-star"></i> Submit New Review
    </button>
</div>

<div class="card">
    <h3>Recent Performance Reviews</h3>
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Reviewer</th>
                <th>Rating</th>
                <th>Date</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reviews as $review): ?>
            <tr>
                <td><strong><?php echo $review['employee']; ?></strong></td>
                <td><?php echo $review['reviewer']; ?></td>
                <td>
                    <?php 
                    for($i=1; $i<=5; $i++) {
                        echo $i <= $review['rating'] ? '<i class="fas fa-star" style="color:gold;"></i>' : '<i class="far fa-star" style="color:#ddd;"></i>';
                    }
                    ?>
                </td>
                <td><?php echo $review['review_date']; ?></td>
                <td><small><?php echo $review['comments']; ?></small></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal-overlay" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Evaluate Employee</h3>
            <button class="close-modal" onclick="closeModal()"><i class="fas fa-times"></i></button>
        </div>
        <form action="" method="POST" style="box-shadow: none; padding: 0;">
            <label>Employee</label>
            <select name="employee_id">
                <?php foreach ($employees as $emp): ?>
                    <option value="<?php echo $emp['id']; ?>"><?php echo $emp['full_name'] . " (" . ucfirst($emp['role']) . ")"; ?></option>
                <?php endforeach; ?>
            </select>

            <label>Rating (1-5)</label>
            <select name="rating">
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Below Average</option>
                <option value="1">1 - Poor</option>
            </select>

            <label>Comments</label>
            <textarea name="comments" placeholder="Strengths, weaknesses..."></textarea>

            <button type="submit" class="btn-primary" style="width: 100%;">Submit Review</button>
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
