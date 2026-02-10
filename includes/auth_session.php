<?php
// includes/auth_session.php
session_start();
if(!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

// Simple RBAC check function
function checkRole($allowed_roles) {
    if (!in_array($_SESSION['role'], $allowed_roles)) {
        header("Location: dashboard.php?error=Unauthorized");
        exit();
    }
}
?>
