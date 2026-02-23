<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Check user role
function check_role($required_role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $required_role) {
        header('Location: ' . SITE_URL);
        exit();
    }
}

// Redirect to dashboard based on role
function redirect_to_dashboard() {
    if (isset($_SESSION['role'])) {
        switch ($_SESSION['role']) {
            case 'admin':
                header('Location: ' . SITE_URL . 'admin/dashboard.php');
                break;
            case 'staff':
                header('Location: ' . SITE_URL . 'staff/dashboard.php');
                break;
            case 'patient':
                header('Location: ' . SITE_URL . 'patient/dashboard.php');
                break;
        }
        exit();
    }
}

// Sanitize input data
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Log activity
function log_activity($conn, $user_id, $action, $description = '') {
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $sql = "INSERT INTO activity_logs (user_id, action, description, ip_address) 
            VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $user_id, $action, $description, $ip_address);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Check login attempts
function check_login_attempts($conn, $email) {
    $lockout_time = LOCKOUT_TIME;
    $max_attempts = MAX_LOGIN_ATTEMPTS;
    
    // Delete old attempts (older than lockout time)
    $sql = "DELETE FROM login_attempts 
            WHERE email = ? AND attempt_time < DATE_SUB(NOW(), INTERVAL ? SECOND)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $email, $lockout_time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    // Count recent attempts
    $sql = "SELECT COUNT(*) as count FROM login_attempts WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    return $row['count'];
}

// Record login attempt
function record_login_attempt($conn, $email) {
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $sql = "INSERT INTO login_attempts (email, ip_address) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $email, $ip_address);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Clear login attempts
function clear_login_attempts($conn, $email) {
    $sql = "DELETE FROM login_attempts WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Get time remaining for lockout
function get_lockout_time_remaining($conn, $email) {
    $sql = "SELECT TIMESTAMPDIFF(SECOND, MAX(attempt_time), DATE_ADD(MAX(attempt_time), INTERVAL ? SECOND)) as remaining
            FROM login_attempts WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    $lockout_time = LOCKOUT_TIME;
    mysqli_stmt_bind_param($stmt, "is", $lockout_time, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    return $row['remaining'] > 0 ? $row['remaining'] : 0;
}

// Format date
function format_date($date) {
    return date('M d, Y', strtotime($date));
}

// Format currency
function format_currency($amount) {
    return 'Rs. ' . number_format($amount, 2);
}

// Check if medicine is expired
function is_medicine_expired($expiry_date) {
    return strtotime($expiry_date) < time();
}

// Check if medicine is low stock
function is_low_stock($quantity) {
    return $quantity <= LOW_STOCK_THRESHOLD;
}

// Send email (simplified - you can integrate PHPMailer for real emails)
function send_email($to, $subject, $message) {
    // For demonstration purposes only
    // In production, use PHPMailer or similar library
    return mail($to, $subject, $message);
}

// Generate OTP
function generate_otp() {
    return sprintf("%06d", mt_rand(1, 999999));
}
?>



