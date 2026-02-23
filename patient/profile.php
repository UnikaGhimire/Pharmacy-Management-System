<?php
session_start();
require_once '../config/database.php';
require_once '../config/constants.php';
require_once '../includes/functions.php';

// Only patients can access
check_role('patient');

// Make sure user is logged in
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("User not logged in.");
}

$messages = [];

// Fetch current user info
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user) die("User not found.");

// -----------------------------
// PROFILE UPDATE
// -----------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if (empty($name) || empty($email)) {
        $messages[] = ['type' => 'error', 'text' => 'Name and email are required.'];
    } else {
        // Check for email uniqueness
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email=? AND id!=?");
        mysqli_stmt_bind_param($stmt, "si", $email, $user_id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($res) > 0) {
            $messages[] = ['type' => 'error', 'text' => 'Email already in use.'];
            mysqli_stmt_close($stmt);
        } else {
            mysqli_stmt_close($stmt); // close select stmt before update

            // Update user info
            $stmt2 = mysqli_prepare($conn, "UPDATE users SET name=?, email=?, phone=?, updated_at=NOW() WHERE id=?");
            mysqli_stmt_bind_param($stmt2, "sssi", $name, $email, $phone, $user_id);
            if (mysqli_stmt_execute($stmt2)) {
                $user['name'] = $name;
                $user['email'] = $email;
                $user['phone'] = $phone;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;

                $messages[] = ['type' => 'success', 'text' => 'Profile updated successfully.'];
                log_activity($conn, $user_id, 'Profile Update', 'Updated profile info.');
            } else {
                $messages[] = ['type' => 'error', 'text' => 'Database error: ' . mysqli_error($conn)];
            }
            mysqli_stmt_close($stmt2);
        }
    }
}

// -----------------------------
// PASSWORD CHANGE
// -----------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_password'])) {
    $current = trim($_POST['current_password'] ?? '');
    $new = trim($_POST['new_password'] ?? '');
    $confirm = trim($_POST['confirm_password'] ?? '');

    if (!$current || !$new || !$confirm) {
        $messages[] = ['type' => 'error', 'text' => 'All password fields are required.'];
    } elseif (!password_verify($current, $user['password'])) {
        $messages[] = ['type' => 'error', 'text' => 'Current password is incorrect.'];
    } elseif ($new !== $confirm) {
        $messages[] = ['type' => 'error', 'text' => 'New passwords do not match.'];
    } elseif (strlen($new) < 6) {
        $messages[] = ['type' => 'error', 'text' => 'New password must be at least 6 characters.'];
    } else {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $stmt3 = mysqli_prepare($conn, "UPDATE users SET password=?, updated_at=NOW() WHERE id=?");
        mysqli_stmt_bind_param($stmt3, "si", $hashed, $user_id);
        if (mysqli_stmt_execute($stmt3)) {
            $user['password'] = $hashed;
            $messages[] = ['type' => 'success', 'text' => 'Password changed successfully.'];
            log_activity($conn, $user_id, 'Password Change', 'Changed account password.');
        } else {
            $messages[] = ['type' => 'error', 'text' => 'Database error: ' . mysqli_error($conn)];
        }
        mysqli_stmt_close($stmt3);
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="profile-page">
    <h1 class="page-title">My Profile</h1>

    <!-- Messages -->
    <div class="messages">
        <?php foreach ($messages as $msg): ?>
            <div class="alert <?php echo $msg['type']=='success' ? 'alert-success' : 'alert-error'; ?>">
                <?php echo htmlspecialchars($msg['text']); ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Profile Update Card -->
    <div class="card">
        <h2>Update Profile</h2>
        <form method="POST">
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Full Name" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Email" required>
            <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="Phone">
            <button type="submit" class="btn">Update Profile</button>
        </form>
    </div>

    <!-- Password Change Card -->
    <div class="card">
        <h2>Change Password</h2>
        <form method="POST">
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
            <button type="submit" class="btn">Change Password</button>
        </form>
    </div>

    <!-- Account Info Card -->
    <div class="card">
        <h2>Account Information</h2>
        <div class="info-display">
            <p><strong>User ID:</strong> #<?php echo $user['id']; ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'Not set'); ?></p>
            <p><strong>Member Since:</strong> <?php echo format_date($user['created_at']); ?></p>
            <p><strong>Last Updated:</strong> <?php echo format_date($user['updated_at']); ?></p>
        </div>
    </div>
</div>

<link rel="stylesheet" href="../assets/css/profile.css">
<script src="../assets/js/profile.js"></script>

<?php include '../includes/footer.php'; ?>
