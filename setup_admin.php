<?php
require 'config/db.php';

// Create Admin User
$email = 'admin@example.com';
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
$full_name = 'System Administrator';
$role = 'admin';

try {
    // Check if table column is 'username' or 'email' to handle re-runs
    // But this script assumes we want to INSERT into 'email'.
    // If migration hasn't run, this might fail with "Unknown column 'email'".
    // So we should ideally run migration first.
    
    $stmt = $conn->prepare("INSERT INTO users (email, password, full_name, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$email, $hash, $full_name, $role]);
    echo "Admin user created successfully.<br>";
    echo "Email: <strong>$email</strong><br>";
    echo "Password: <strong>$password</strong><br>";
    echo "<a href='index.php'>Go to Login</a>";
} catch (PDOException $e) {
    echo "Error (User might already exist): " . $e->getMessage();
}
?>
