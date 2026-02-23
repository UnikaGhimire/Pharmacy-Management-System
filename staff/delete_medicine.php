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

$medicine_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get medicine name for logging
$sql = "SELECT name FROM medicines WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $medicine_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$medicine = mysqli_fetch_assoc($result);

if ($medicine) {
    // Check if medicine is used in any bills
    $sql = "SELECT COUNT(*) as count FROM bill_items WHERE medicine_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $medicine_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_fetch_assoc($result)['count'];
    
    if ($count > 0) {
        $_SESSION['error'] = 'Cannot delete medicine. It has been used in ' . $count . ' bill(s).';
    } else {
        // Delete medicine
        $sql = "DELETE FROM medicines WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $medicine_id);
        
        if (mysqli_stmt_execute($stmt)) {
            log_activity($conn, $_SESSION['user_id'], 'Delete Medicine', 'Deleted medicine: ' . $medicine['name']);
            $_SESSION['success'] = 'Medicine deleted successfully.';
        }
    }
}

header('Location: manage_medicines.php');
exit();
?>


