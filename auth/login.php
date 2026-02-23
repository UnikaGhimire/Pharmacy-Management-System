<?php
session_start();
require_once '../config/database.php';
require_once '../config/constants.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];
    
    // Check login attempts
    $attempts = check_login_attempts($conn, $email);
    
    if ($attempts >= MAX_LOGIN_ATTEMPTS) {
        $time_remaining = get_lockout_time_remaining($conn, $email);
        $_SESSION['error'] = "Too many failed login attempts. Please wait " . $time_remaining . " seconds.";
        header('Location: ../index.php');
        exit();
    }
    
    // Query user
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($user = mysqli_fetch_assoc($result)) {
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password correct - clear login attempts
            clear_login_attempts($conn, $email);
            
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            // Log activity
            log_activity($conn, $user['id'], 'Login', 'User logged in successfully');
            
            // Redirect to dashboard
            redirect_to_dashboard();
        } else {
            // Wrong password - record attempt
            record_login_attempt($conn, $email);
            log_activity($conn, null, 'Login Failed', 'Failed login attempt for email: ' . $email);
            
            $remaining_attempts = MAX_LOGIN_ATTEMPTS - ($attempts + 1);
            if ($remaining_attempts > 0) {
                $_SESSION['error'] = "Invalid email or password. $remaining_attempts attempts remaining.";
            } else {
                $_SESSION['error'] = "Too many failed attempts. Account locked for " . LOCKOUT_TIME . " seconds.";
            }
        }
    } else {
        // User not found - still record attempt
        record_login_attempt($conn, $email);
        log_activity($conn, null, 'Login Failed', 'Failed login attempt for non-existent email: ' . $email);
        $_SESSION['error'] = "Invalid email or password.";
    }
    
    mysqli_stmt_close($stmt);
    header('Location: ../index.php');
    exit();
}
?>

