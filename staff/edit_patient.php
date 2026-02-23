<?php
$page_title = 'Edit Patient';
include '../includes/header.php';
check_role('staff');

$patient_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$error = '';

// Get patient details
$sql = "SELECT * FROM users WHERE id = ? AND role = 'patient'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $patient_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$patient = mysqli_fetch_assoc($result);

if (!$patient) {
    $_SESSION['error'] = 'Patient not found.';
    header('Location: manage_patients.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $phone = clean_input($_POST['phone']);
    
    // Check if email is taken by another user
    $sql = "SELECT id FROM users WHERE email = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $email, $patient_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $error = 'Email already exists.';
    } else {
        // Update patient
        $sql = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $patient_id);
        
        if (mysqli_stmt_execute($stmt)) {
            log_activity($conn, $_SESSION['user_id'], 'Edit Patient', 'Updated patient: ' . $name);
            $_SESSION['success'] = 'Patient updated successfully.';
            header('Location: manage_patients.php');
            exit();
        } else {
            $error = 'Failed to update patient.';
        }
    }
}
?>

<div class="content-wrapper">
    <div class="page-header">
        <h1>Edit Patient</h1>
        <a href="manage_patients.php" class="btn btn-secondary">Back</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="form-container">
        <form action="" method="POST" class="standard-form">
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($patient['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($patient['phone']); ?>">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Patient</button>
                <a href="manage_patients.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>


