<?php
session_start();
require_once '../config/database.php';
require_once '../config/constants.php';
require_once '../includes/functions.php';

if (!is_logged_in()) {
    header('Location: ' . SITE_URL);
    exit();
}

check_role('staff');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_type = $_POST['customer_type'];
    $payment_status = $_POST['payment_status'];
    $total_amount = floatval($_POST['total_amount']);
    
    // Get customer information
    if ($customer_type === 'patient') {
        $user_id = intval($_POST['patient_id']);
        
        // Get patient name
        $sql = "SELECT name, phone FROM users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $customer = mysqli_fetch_assoc($result);
        $customer_name = $customer['name'];
        $customer_phone = $customer['phone'];
    } else {
        $user_id = null;
        $customer_name = clean_input($_POST['guest_name']);
        $customer_phone = clean_input($_POST['guest_phone']);
    }
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Insert bill
        $sql = "INSERT INTO bills (user_id, customer_name, customer_phone, total_amount, payment_status, created_by) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "issdsi", $user_id, $customer_name, $customer_phone, 
                                $total_amount, $payment_status, $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        $bill_id = mysqli_insert_id($conn);
        
        // Insert bill items and update stock
        $medicine_ids = $_POST['medicine_id'];
        $quantities = $_POST['quantity'];
        $prices = $_POST['price'];
        $subtotals = $_POST['subtotal'];
        
        for ($i = 0; $i < count($medicine_ids); $i++) {
            $medicine_id = intval($medicine_ids[$i]);
            $quantity = intval($quantities[$i]);
            $price = floatval($prices[$i]);
            $subtotal = floatval($subtotals[$i]);
            
            // Get medicine name
            $sql = "SELECT name, stock_quantity FROM medicines WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $medicine_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $medicine = mysqli_fetch_assoc($result);
            
            // Check stock
            if ($medicine['stock_quantity'] < $quantity) {
                throw new Exception("Insufficient stock for " . $medicine['name']);
            }
            
            // Insert bill item
            $sql = "INSERT INTO bill_items (bill_id, medicine_id, medicine_name, quantity, price, subtotal) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iisidd", $bill_id, $medicine_id, $medicine['name'], 
                                    $quantity, $price, $subtotal);
            mysqli_stmt_execute($stmt);
            
            // Update stock
            $sql = "UPDATE medicines SET stock_quantity = stock_quantity - ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $quantity, $medicine_id);
            mysqli_stmt_execute($stmt);
        }
        
        // Commit transaction
        mysqli_commit($conn);
        
        // Log activity
        log_activity($conn, $_SESSION['user_id'], 'Create Bill', 
                     'Created bill #' . $bill_id . ' for ' . $customer_name);
        
        $_SESSION['success'] = 'Bill created successfully. Bill ID: ' . $bill_id;
        header('Location: view_bills.php');
        exit();
        
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($conn);
        $_SESSION['error'] = 'Error: ' . $e->getMessage();
        header('Location: billing.php');
        exit();
    }
} else {
    header('Location: billing.php');
    exit();
}
?>


