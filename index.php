<?php
session_start();
require_once 'config/database.php';
require_once 'config/constants.php';
require_once 'includes/functions.php';

if (is_logged_in()) {
    redirect_to_dashboard();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo SITE_NAME; ?> | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            height: 100vh;
            background: #f6f7f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111;
        }

        .login-container {
            width: 100%;
            max-width: 380px;
            background: #ffffff;
            padding: 36px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            font-size: 22px;
            font-weight: 600;
            letter-spacing: -0.3px;
        }

        .logo p {
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
        }

        .alert {
            font-size: 13px;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
            color: #374151;
        }

        .input {
            display: flex;
            align-items: center;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px 12px;
        }

        .input i {
            font-size: 14px;
            color: #9ca3af;
            margin-right: 8px;
        }

        .input input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 14px;
        }

        .btn {
            width: 100%;
            margin-top: 10px;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #111827;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }

        .btn:hover {
            background: #000;
        }

        .links {
            text-align: center;
            margin-top: 14px;
            font-size: 13px;
        }

        .links a {
            color: #2563eb;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .credentials {
            margin-top: 22px;
            font-size: 12px;
            color: #6b7280;
            line-height: 1.5;
            border-top: 1px solid #e5e7eb;
            padding-top: 14px;
        }
    </style>
</head>
<body>

<div class="login-container">

    <div class="logo">
        <h1><?php echo SITE_NAME; ?></h1>
        <p>Login</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form action="auth/login.php" method="POST">

        <div class="field">
            <label>Email</label>
            <div class="input">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" required>
            </div>
        </div>

        <div class="field">
            <label>Password</label>
            <div class="input">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" required>
            </div>
        </div>

        <button class="btn" type="submit">Sign in</button>

    </form>

    <div class="links">
        <a href="auth/forgot_password.php">Forgot password?</a>
    </div>

    <div class="credentials">
        <strong>Admin:</strong> admin@sunway.com / admin123<br>
        <strong>Staff:</strong> staff@sunway.com / staff123<br>
        <strong>Patient:</strong> patient@example.com / unikaghimire
        <br>
        <br>
        To test the features of forget password, please create a new account with your real email.
        <br>
        <br>
        You can create a new account either directly through database or through admin/staff accounts.
    </div>

</div>

</body>
</html>
