<?php
require 'config/db.php';

try {
    // Check if 'username' column exists, if so rename it to 'email'
    // This is safer than dropping/adding if data exists.
    // However, if we rename 'admin' (username) to 'admin' (email), it's invalid email.
    // So we need to update the data first or handle it.
    
    // 1. Rename column
    // MySQL 8.0+ syntax: RENAME COLUMN
    // Older MySQL/MariaDB: CHANGE COLUMN
    
    // Let's try to detect if email column exists first or just assume structure from previous steps.
    // I will use a robust approach: Add 'email', copy 'username' (with dummy domain), drop 'username'.
    
    // However, simplest update for a fresh project:
    $sql = "ALTER TABLE users CHANGE COLUMN username email VARCHAR(100) NOT NULL UNIQUE";
    $conn->exec($sql);
    
    // 2. Update the default admin user to a valid email
    $password = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET email = 'admin@example.com', password = ? WHERE email = 'admin'");
    $stmt->execute([$password]);
    
    echo "Database migrated successfully: 'username' changed to 'email'.<br>";
    echo "Default Admin: <strong>admin@example.com</strong> / <strong>admin123</strong><br>";
    echo "<a href='index.php'>Go to Login</a>";
    
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "Unknown column 'username'") !== false) {
        echo "Migration already applied or 'username' column not found.<br>";
        echo "Default Admin: <strong>admin@example.com</strong> / <strong>admin123</strong><br>";
        echo "<a href='index.php'>Go to Login</a>";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>
