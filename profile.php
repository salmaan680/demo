<?php
require 'includes/auth_session.php';
require 'config/db.php';
require 'includes/functions.php';
$pageTitle = "My Profile";
require 'includes/header.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $full_name = sanitizeInput($_POST['full_name']);
    $new_password = $_POST['new_password'];

    if (!empty($new_password)) {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET full_name = ?, password = ? WHERE id = ?");
        if ($stmt->execute([$full_name, $hash, $user_id])) {
            $message = "<div class='alert success'>Profile updated successfully!</div>";
            // Update session
            $_SESSION['full_name'] = $full_name;
        } else {
            $message = "<div class='alert error'>Error updating profile.</div>";
        }
    } else {
        $stmt = $conn->prepare("UPDATE users SET full_name = ? WHERE id = ?");
        if ($stmt->execute([$full_name, $user_id])) {
            $message = "<div class='alert success'>Profile updated successfully!</div>";
            $_SESSION['full_name'] = $full_name;
        } else {
            $message = "<div class='alert error'>Error updating profile.</div>";
        }
    }
}

// Fetch current user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h3>Edit Profile</h3>
    <?php echo $message; ?>
    <form action="" method="POST">
        <label>Email Address</label>
        <?php 
            // Handle display
            $displayEmail = isset($user['email']) ? $user['email'] : 'N/A';
        ?>
        <input type="text" value="<?php echo $displayEmail; ?>" disabled style="background-color: #f0f0f0;">

        <label>Full Name</label>
        <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required>

        <label>New Password (Leave blank to keep current)</label>
        <input type="password" name="new_password" placeholder="New Password">

        <label>Role</label>
        <input type="text" value="<?php echo ucfirst($user['role']); ?>" disabled style="background-color: #f0f0f0;">

        <button type="submit">Update Profile</button>
    </form>
</div>

<?php require 'includes/footer.php'; ?>
