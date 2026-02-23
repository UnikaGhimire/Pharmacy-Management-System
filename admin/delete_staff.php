<?php
session_start();
require_once '../config/database.php';
require_once '../config/constants.php';
require_once '../includes/functions.php';

if (!is_logged_in()) {
    header('Location: ' . SITE_URL);
    exit();
}

check_role('admin');

$staff_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get staff name for logging
$sql = "SELECT name FROM users WHERE id = ? AND role = 'staff'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $staff_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$staff = mysqli_fetch_assoc($result);

if ($staff) {
    // Delete staff
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $staff_id);
    
    if (mysqli_stmt_execute($stmt)) {
        log_activity($conn, $_SESSION['user_id'], 'Delete Staff', 'Deleted staff: ' . $staff['name']);
        $_SESSION['success'] = 'Staff member deleted successfully.';
    }
}

header('Location: manage_staff.php');
exit();
?>