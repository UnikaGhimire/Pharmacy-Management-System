<?php
session_start();
require_once '../config/database.php';
require_once '../config/constants.php';
require_once '../includes/functions.php';

// Must come from forgot_password.php
if (!isset($_SESSION['reset_email'])) {
    header('Location: forgot_password.php');
    exit();
}

$email = $_SESSION['reset_email'];
$error = '';

// Handle OTP submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = trim($_POST['otp'] ?? '');

    // Basic validation
    if (!preg_match('/^\d{6}$/', $otp)) {
        $error = 'Invalid OTP format.';
    } else {
        // Get latest OTP for this email
        $sql = "SELECT token, expires_at
                FROM password_reset_tokens
                WHERE email = ?
                ORDER BY created_at DESC
                LIMIT 1";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if (!$row) {
            $error = 'No OTP found. Please request a new one.';
        } elseif (strtotime($row['expires_at']) < time()) {
            $error = 'OTP expired. Please request a new one.';
        } elseif ((string)$row['token'] !== (string)$otp) {
            $error = 'Invalid OTP.';
        } else {
            // OTP verified
            $_SESSION['verified_otp'] = true;
            $_SESSION['otp_token'] = $otp;

            header('Location: reset_password.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Verify OTP</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/css/otp-style.css">
</head>
<body>

<div class="login-container">
    <div class="logo">
        <h1>Verify OTP</h1>
        <p>Please enter the 6-digit OTP sent to your email.</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="field">
            <label for="otp">OTP</label>
            <div class="input">
                <input type="text" id="otp" name="otp" maxlength="6" placeholder="Enter 6-digit OTP" required autofocus>
            </div>
        </div>

        <button type="submit" class="btn">Verify OTP</button>
    </form>

    <div class="links">
        <a href="forgot_password.php">Request new OTP</a>
    </div>
</div>

</body>
</html>
