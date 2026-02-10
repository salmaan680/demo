<?php
require 'includes/auth_session.php';
require 'config/db.php';

if (isset($_POST['export_type'])) {
    $type = $_POST['export_type'];
    $filename = $type . "_report_" . date('Y-m-d') . ".csv";
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    if ($type == 'sales') {
        fputcsv($output, array('ID', 'Date', 'Customer', 'Amount', 'Description', 'Added By'));
        $stmt = $conn->query("SELECT s.id, s.sale_date, s.customer_name, s.amount, s.description, u.full_name FROM sales s JOIN users u ON s.user_id = u.id ORDER BY s.sale_date DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, $row);
        }
    } elseif ($type == 'expenses') {
        fputcsv($output, array('ID', 'Date', 'Category', 'Amount', 'Description', 'Added By'));
        $stmt = $conn->query("SELECT e.id, e.expense_date, e.category, e.amount, e.description, u.full_name FROM expenses e JOIN users u ON e.user_id = u.id ORDER BY e.expense_date DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, $row);
        }
    }
    
    fclose($output);
    exit();
}
?>
