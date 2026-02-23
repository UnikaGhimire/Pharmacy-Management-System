<?php
$page_title = 'Add Patient';
include '../includes/header.php';
check_role('staff');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $phone = clean_input($_POST['phone']);
    $password = $_POST['password'];
    
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Name, email, and password are required.';
    } else {
        // Check if email exists
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $error = 'Email already exists.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, 'patient')";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $hashed_password);
            
            if (mysqli_stmt_execute($stmt)) {
                log_activity($conn, $_SESSION['user_id'], 'Add Patient', 'Added new patient: ' . $name);
                $_SESSION['success'] = 'Patient added successfully.';
                header('Location: manage_patients.php');
                exit();
            } else {
                $error = 'Failed to add patient.';
            }
        }
    }
}
?>

<div class="content-wrapper">
    <div class="page-header">
        <h1>Add New Patient</h1>
        <a href="manage_patients.php" class="btn btn-secondary">Back</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="form-container">
        <form action="" method="POST" class="standard-form">
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone">
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required minlength="6">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add Patient</button>
                <a href="manage_patients.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<link rel="stylesheet" href="../assets/css/manage_patients.css">
<?php include '../includes/footer.php'; ?>