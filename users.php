<?php
require 'includes/auth_session.php';
require 'config/db.php';
require 'includes/functions.php';
$pageTitle = "User Management";
require 'includes/header.php';

// Access Check
if ($_SESSION['role'] !== 'admin') {
    die("Access Denied");
}

// Add User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = sanitizeInput($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = sanitizeInput($_POST['full_name']);
    $role = $_POST['role'];
    
    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Error: Email already exists!');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (email, password, full_name, role) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$email, $password, $full_name, $role])) {
            echo "<script>alert('User created successfully!'); window.location.href='users.php';</script>";
        }
    }
}

// Delete User
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
    echo "<script>window.location.href='users.php';</script>";
}

$users = $conn->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="fab-container">
    <button class="btn-primary" onclick="openModal()">
        <i class="fas fa-user-plus"></i> Create New User
    </button>
</div>

<div class="card">
    <h3>System Users</h3>
    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Full Name</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?php echo $u['email']; ?></td>
                <td><?php echo $u['full_name']; ?></td>
                <td><span class="badge badge-<?php echo $u['role']; ?>"><?php echo ucfirst($u['role']); ?></span></td>
                <td>
                    <?php if($u['id'] != $_SESSION['user_id']): ?>
                        <a href="?delete=<?php echo $u['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')" style="color: #ef4444;"><i class="fas fa-trash"></i></a>
                    <?php else: ?>
                        <span style="color:grey; font-size: 12px; font-style: italic;">Current User</span>
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
            <h3>Create New User</h3>
            <button class="close-modal" onclick="closeModal()"><i class="fas fa-times"></i></button>
        </div>
        <form action="" method="POST" style="box-shadow: none; padding: 0;">
            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Full Name</label>
            <input type="text" name="full_name" required>

            <label>Role</label>
            <select name="role">
                <option value="staff">Staff</option>
                <option value="manager">Manager</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" class="btn-primary" style="width: 100%;">Create User</button>
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
