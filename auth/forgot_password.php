<?php
session_start();
require_once '../config/database.php';
require_once '../config/constants.php';
require_once '../config/email.php';
require_once '../includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } else {

        // Check if user exists
        $stmt = mysqli_prepare($conn, "SELECT name FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {

            // Remove old OTPs
            $del = mysqli_prepare($conn, "DELETE FROM password_reset_tokens WHERE email = ?");
            mysqli_stmt_bind_param($del, "s", $email);
            mysqli_stmt_execute($del);
            mysqli_stmt_close($del);

            // Generate OTP
            $otp = random_int(100000, 999999);
            $expiry = date('Y-m-d H:i:s', time() + (OTP_EXPIRY_MINUTES * 60));

            // Save OTP
            $ins = mysqli_prepare(
                $conn,
                "INSERT INTO password_reset_tokens (email, token, expires_at) VALUES (?, ?, ?)"
            );
            mysqli_stmt_bind_param($ins, "sss", $email, $otp, $expiry);

            if (mysqli_stmt_execute($ins)) {
                send_otp_email($email, $otp, $user['name']);

                $_SESSION['reset_email'] = $email;
                unset($_SESSION['verified_otp'], $_SESSION['otp_token']);

                header('Location: verify_otp.php');
                exit();
            } else {
                $error = 'Failed to generate OTP.';
            }

            mysqli_stmt_close($ins);

        } else {
            $error = 'Email not found.';
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/css/forgot-password.css">
</head>
<body>

<!-- Background animation -->
<div class="bg-animation">
    <span></span>
    <span></span>
</div>

<div class="auth-container">
    <div class="auth-header">
        <h1>Forgot Password</h1>
        <p>Enter your email address to receive a one-time password (OTP).</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required autofocus>
        </div>
        <button type="submit" class="btn">Send OTP</button>
    </form>

    <div class="auth-footer">
        <a href="<?php echo SITE_URL; ?>">Back to login</a>
    </div>
</div>

</body>
</html>
