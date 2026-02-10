<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    // 1. Create Connection without DB
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 2. Create Database
    $conn->exec("CREATE DATABASE IF NOT EXISTS bp_tracking");
    echo "Database 'bp_tracking' checked/created.<br>";
    
    // 3. Connect to Database directly
    $conn->exec("USE bp_tracking");
    
    // 4. Create Users Table (Directly with email now)
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        role ENUM('admin', 'manager', 'staff') NOT NULL DEFAULT 'staff',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($sql);
    echo "Table 'users' created.<br>";

    // 5. Create Other Tables
    $sql = "CREATE TABLE IF NOT EXISTS sales (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        customer_name VARCHAR(100),
        description TEXT,
        sale_date DATE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    $conn->exec($sql);
    echo "Table 'sales' created.<br>";

    $sql = "CREATE TABLE IF NOT EXISTS expenses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        category VARCHAR(50) NOT NULL,
        description TEXT,
        expense_date DATE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    $conn->exec($sql);
    echo "Table 'expenses' created.<br>";

    $sql = "CREATE TABLE IF NOT EXISTS kpis (
        id INT AUTO_INCREMENT PRIMARY KEY,
        metric_name VARCHAR(100) NOT NULL,
        target_value DECIMAL(10, 2) NOT NULL,
        period ENUM('monthly', 'yearly') NOT NULL DEFAULT 'monthly',
        assigned_role ENUM('admin', 'manager', 'staff') DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($sql);
    echo "Table 'kpis' created.<br>";

    $sql = "CREATE TABLE IF NOT EXISTS employee_performance (
        id INT AUTO_INCREMENT PRIMARY KEY,
        employee_id INT NOT NULL,
        reviewer_id INT NOT NULL,
        rating INT CHECK (rating BETWEEN 1 AND 5),
        comments TEXT,
        review_date DATE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (employee_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    $conn->exec($sql);
    echo "Table 'employee_performance' created.<br>";

    $sql = "CREATE TABLE IF NOT EXISTS system_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        action VARCHAR(255) NOT NULL,
        details TEXT,
        ip_address VARCHAR(45),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($sql);
    echo "Table 'system_logs' created.<br>";

    // 6. Create Default Admin if not exists
    $admin_email = 'admin@example.com';
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$admin_email]);
    
    if ($stmt->rowCount() == 0) {
        $pass = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (email, password, full_name, role) VALUES (?, ?, ?, 'admin')");
        $stmt->execute([$admin_email, $pass, 'System Administrator']);
        echo "Default admin user created.<br>";
    } else {
        echo "Admin user already exists.<br>";
    }
    
    echo "<h3>Installation Complete!</h3>";
    echo "<p>Login: <strong>admin@example.com</strong> / <strong>admin123</strong></p>";
    echo "<a href='index.php'>Go to Login</a>";

} catch(PDOException $e) {
    echo "Installation Failed: " . $e->getMessage();
}
?>
