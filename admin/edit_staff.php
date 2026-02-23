<?php
$page_title = 'Edit Staff';
include '../includes/header.php';
check_role('admin');

$staff_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$error = '';

// Get staff details
$sql = "SELECT * FROM users WHERE id = ? AND role = 'staff'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $staff_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$staff = mysqli_fetch_assoc($result);

if (!$staff) {
    $_SESSION['error'] = 'Staff member not found.';
    header('Location: manage_staff.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $phone = clean_input($_POST['phone']);
    
    // Check if email is taken by another user
    $sql = "SELECT id FROM users WHERE email = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $email, $staff_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $error = 'Email already exists.';
    } else {
        // Update staff
        $sql = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $staff_id);
        
        if (mysqli_stmt_execute($stmt)) {
            log_activity($conn, $_SESSION['user_id'], 'Edit Staff', 'Updated staff: ' . $name);
            $_SESSION['success'] = 'Staff member updated successfully.';
            header('Location: manage_staff.php');
            exit();
        } else {
            $error = 'Failed to update staff member.';
        }
    }
}
?>

<!-- Link the same CSS as Add Staff -->
<link rel="stylesheet" href="../assets/css/add_staff.css">

<div class="add-staff-page">
    <div class="page-header">
        <h1>Edit Staff</h1>
        <a href="manage_staff.php" class="btn btn-secondary">Back</a>
    </div>

    <?php if ($error): ?>
        <div class="alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="form-card form-grid">
        <form action="" method="POST" class="staff-form">
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($staff['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($staff['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($staff['phone']); ?>">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Staff</button>
                <a href="manage_staff.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
