<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

if (isset($_SESSION['user_id'])) {
    log_activity($conn, $_SESSION['user_id'], 'Logout', 'User logged out');
}

session_destroy();
header('Location: index.php');
exit();
?>
