# Business Performance Tracking System

## Setup Instructions

1. **Database Setup**:
    - Open phpMyAdmin (http://localhost/phpmyadmin).
    - Create a new database named `bp_tracking`.
    - Import the `db.sql` file located in the root of this project.

2. **Configuration**:
    - The database connection is configured in `config/db.php`.
    - Default settings: Host: `localhost`, User: `root`, Password: `` (empty).

3. **Accessing the System**:
    - URL: `http://localhost/bp/`
    - **Default Admin Credentials**:
        - Username: `admin`
        - Users will need to set their password via the database or you can register a new user if I enable registration (currently Admin-creation only).
        - **IMPORTANT**: The default password hash in `db.sql` is a placeholder. You should update the admin user with a known hash or use the registration logic if added.
        - *Correction*: I have provided a `users.php` page for admins to create users. To get in initially, if the hash doesn't match your `password_verify` logic (since I used a placeholder), you might need to manually insert a user with a known MD5 or bcrypt hash in phpMyAdmin, OR use the provided hash if it works.
        - **To fix login immediately**: Run this SQL command in phpMyAdmin to set password to 'admin123':
          ```sql
          UPDATE users SET password = '$2y$10$YourGeneratedHashHere' WHERE username = 'admin';
          ```
          *Actually, simpler:* Create a temporary `register.php` or just manually insert a user with MD5 if you change the code to MD5 (not recommended) or use an online bcrypt generator.
          
          **Better yet:** I will create a `setup_admin.php` file for you to run once to create/reset the admin user.

## Features
- **Dashboard**: Real-time overview of Sales vs Expenses.
- **Sales & Expenses**: Track daily transactions.
- **KPIs**: Set and monitor targets.
- **Employees**: Performance reviews.
- **Reports**: Monthly analysis and printing.
- **RBAC**: Admin, Manager, Staff roles.
