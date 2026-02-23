<?php
$page_title = 'Add Staff';
include '../includes/header.php';
check_role('admin');


$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $phone = clean_input($_POST['phone']);
    $password = $_POST['password'];
    
    // Validate
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'All fields marked with * are required.';
    } else {
        // Check if email already exists
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $error = 'Email already exists.';
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert staff
            $sql = "INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, 'staff')";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $hashed_password);
            
            if (mysqli_stmt_execute($stmt)) {
                log_activity($conn, $_SESSION['user_id'], 'Add Staff', 'Added new staff: ' . $name);
                $_SESSION['success'] = 'Staff member added successfully.';
                header('Location: manage_staff.php');
                exit();
            } else {
                $error = 'Failed to add staff member.';
            }
        }
    }
}
?>
<link rel="stylesheet" href="../assets/css/add_staff.css">

<div class="add-staff-page">
    <div class="page-header">
        <h1>Add New Staff</h1>
        <a href="manage_staff.php" class="btn btn-secondary">Back to Staff</a>
    </div>

    <?php if ($error): ?>
        <div class="alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="form-card form-grid">
        <form action="" method="POST" class="staff-form">
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" placeholder="Enter full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" placeholder="Enter email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter phone number">
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required minlength="6">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add Staff</button>
                <a href="manage_staff.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
