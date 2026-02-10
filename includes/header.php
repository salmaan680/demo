<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Performance Tracker</title>
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <header>
            <h1>
                <i class="<?php 
                    // Set icon based on page title
                    if(strpos($pageTitle, 'Dashboard') !== false) echo 'fas fa-home';
                    elseif(strpos($pageTitle, 'Sale') !== false) echo 'fas fa-chart-line';
                    elseif(strpos($pageTitle, 'Expense') !== false) echo 'fas fa-wallet';
                    elseif(strpos($pageTitle, 'KPI') !== false) echo 'fas fa-bullseye';
                    elseif(strpos($pageTitle, 'Report') !== false) echo 'fas fa-file-alt';
                    elseif(strpos($pageTitle, 'User') !== false) echo 'fas fa-users-cog';
                    elseif(strpos($pageTitle, 'Log') !== false) echo 'fas fa-history';
                    elseif(strpos($pageTitle, 'Profile') !== false) echo 'fas fa-user-circle';
                    else echo 'fas fa-columns';
                ?>"></i> 
                <?php echo isset($pageTitle) ? $pageTitle : 'Dashboard'; ?>
            </h1>
            <div class="user-info">
                <span>
                    <i class="fas fa-user"></i> 
                    <?php echo $_SESSION['full_name']; ?> 
                    <small style="color: #999; font-weight: normal;">(<?php echo ucfirst($_SESSION['role']); ?>)</small>
                </span>
                <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </header>
        <div class="content">
