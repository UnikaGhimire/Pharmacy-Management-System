<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once dirname(__DIR__) . '/includes/PHPMailer.php';
require_once dirname(__DIR__) . '/includes/SMTP.php';
require_once dirname(__DIR__) . '/includes/Exception.php';

define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your email'); // Add your email here
define('SMTP_PASSWORD', 'addyourpasswordhere'); // Add your app password here
define('SMTP_FROM_EMAIL', 'ghimire.unika505@gmail.com');
define('SMTP_FROM_NAME', 'Sunway Pharmacy');

/**
 * Send email using Gmail SMTP
 */
function send_smtp_email($to, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        // Recipients
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = strip_tags($message);

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Email Error: " . $mail->ErrorInfo);
        return false;
    }
}

/**
 * Send OTP email
 */
function send_otp_email($to, $otp, $user_name) {
    $subject = "Password Reset OTP - " . SITE_NAME;

    $message = "
    <h2>Hello " . htmlspecialchars($user_name) . "</h2>
    <p>Your OTP is:</p>
    <h1>{$otp}</h1>
    <p>This OTP expires in " . OTP_EXPIRY_MINUTES . " minutes.</p>
    ";

    return send_smtp_email($to, $subject, $message);
}
