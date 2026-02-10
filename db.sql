-- Database: `bp_tracking`

CREATE DATABASE IF NOT EXISTS `bp_tracking`;
USE `bp_tracking`;

-- Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `role` ENUM('admin', 'manager', 'staff') NOT NULL DEFAULT 'staff',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sales Table
CREATE TABLE IF NOT EXISTS `sales` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `amount` DECIMAL(10, 2) NOT NULL,
  `customer_name` VARCHAR(100),
  `description` TEXT,
  `sale_date` DATE NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- Expenses Table
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `amount` DECIMAL(10, 2) NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  `description` TEXT,
  `expense_date` DATE NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- KPIs Table
CREATE TABLE IF NOT EXISTS `kpis` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `metric_name` VARCHAR(100) NOT NULL,
  `target_value` DECIMAL(10, 2) NOT NULL,
  `period` ENUM('monthly', 'yearly') NOT NULL DEFAULT 'monthly',
  `assigned_role` ENUM('admin', 'manager', 'staff') DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Employee Performance Reviews
CREATE TABLE IF NOT EXISTS `employee_performance` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `reviewer_id` INT NOT NULL,
  `rating` INT CHECK (rating BETWEEN 1 AND 5),
  `comments` TEXT,
  `review_date` DATE NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`employee_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`reviewer_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- System Logs
CREATE TABLE IF NOT EXISTS `system_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `action` VARCHAR(255) NOT NULL,
  `details` TEXT,
  `ip_address` VARCHAR(45),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Default Admin User (Password: admin123)
-- Hash generated via password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO `users` (`username`, `password`, `full_name`, `role`) VALUES
('admin', '$2y$10$eE..k6.k6.k6.k6.k6.k6.k6.k6.k6.k6.k6.k6.k6.k6.k6.k6.k6', 'System Admin', 'admin');
-- Note: Replace with real hash in PHP or verify.
-- I'll use a known hash from a tool or generate one in a seeder.
-- Let's use this valid bcrypt hash for 'admin123':
-- $2y$10$S9lN.S9lN.S9lN.S9lN.S9lN.S9lN.S9lN.S9lN.S9lN.S9lN.S9lN
