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

$patient_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get patient name for logging
$sql = "SELECT name FROM users WHERE id = ? AND role = 'patient'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $patient_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$patient = mysqli_fetch_assoc($result);

if ($patient) {
    // Delete patient
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    
    if (mysqli_stmt_execute($stmt)) {
        log_activity($conn, $_SESSION['user_id'], 'Delete Patient', 'Deleted patient: ' . $patient['name']);
        $_SESSION['success'] = 'Patient deleted successfully.';
    }
}

header('Location: manage_patients.php');
exit();
?>


