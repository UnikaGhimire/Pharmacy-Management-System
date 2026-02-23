<?php
session_start();
require_once '../config/database.php';
require_once '../config/constants.php';
require_once '../includes/functions.php';

// Must come from verified OTP
if (!isset($_SESSION['reset_email'], $_SESSION['verified_otp']) || $_SESSION['verified_otp'] !== true) {
    $_SESSION['error'] = 'Unauthorized access. Please restart password reset.';
    header('Location: forgot_password.php');
    exit();
}

$email = $_SESSION['reset_email'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if (!$password || !$confirm_password) {
        $error = 'All fields are required.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);

        if (mysqli_stmt_execute($stmt)) {

            // Delete old tokens
            $sql2 = "DELETE FROM password_reset_tokens WHERE email=?";
            $stmt2 = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt2, "s", $email);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);

            log_activity($conn, null, 'Password Reset', 'Password reset for ' . $email);

            unset($_SESSION['reset_email'], $_SESSION['verified_otp'], $_SESSION['otp_token']);
            $success = 'Password reset successful. Redirecting to login...';
        } else {
            $error = 'Password reset failed. Database error: ' . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password - <?php echo SITE_NAME; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/css/reset-password.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-header">
        <h1>Reset Password</h1>
        <p><strong><?php echo htmlspecialchars($email); ?></strong></p>
    </div>

    <?php if($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif($success): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success); ?>
            <br>
            <span id="countdown">Redirecting in 5 seconds...</span>
        </div>

        <script>
        // Countdown timer
        let seconds = 5;
        const countdownEl = document.getElementById('countdown');
        const interval = setInterval(() => {
            seconds--;
            if (seconds > 0) {
                countdownEl.innerText = `Redirecting in ${seconds} second${seconds > 1 ? 's' : ''}...`;
            } else {
                clearInterval(interval);
                window.location.href = '../index.php';
            }
        }, 1000);
        </script>
    <?php endif; ?>

    <?php if(!$success): ?>
    <form method="POST" id="resetForm">
        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" minlength="6" required>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" minlength="6" required>
        </div>
        <button type="submit" class="btn" id="resetBtn">Reset Password</button>
    </form>
    <?php endif; ?>
</div>

<script>
document.getElementById('resetForm')?.addEventListener('submit', function() {
    const btn = document.getElementById('resetBtn');
    btn.disabled = true;
    btn.innerText = 'Processing...';
});
</script>

</body>
</html>
