<?php
$page_title = 'Edit Medicine';
include '../includes/header.php';
check_role('staff');

$medicine_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$error = '';

// Get medicine details
$sql = "SELECT * FROM medicines WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $medicine_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$medicine = mysqli_fetch_assoc($result);

if (!$medicine) {
    $_SESSION['error'] = 'Medicine not found.';
    header('Location: manage_medicines.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name']);
    $category = clean_input($_POST['category']);
    $price = floatval($_POST['price']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $expiry_date = $_POST['expiry_date'];
    
    if (empty($name) || empty($category) || $price <= 0) {
        $error = 'Please fill all required fields correctly.';
    } else {
        $sql = "UPDATE medicines SET name = ?, category = ?, price = ?, stock_quantity = ?, expiry_date = ? 
                WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdisi", $name, $category, $price, $stock_quantity, $expiry_date, $medicine_id);
        
        if (mysqli_stmt_execute($stmt)) {
            log_activity($conn, $_SESSION['user_id'], 'Edit Medicine', 'Updated medicine: ' . $name);
            $_SESSION['success'] = 'Medicine updated successfully.';
            header('Location: manage_medicines.php');
            exit();
        } else {
            $error = 'Failed to update medicine.';
        }
    }
}
?>

<div class="content-wrapper">
    <div class="page-header">
        <h1>Edit Medicine</h1>
        <a href="manage_medicines.php" class="btn btn-secondary">Back</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="form-container">
        <form action="" method="POST" class="standard-form">
            <div class="form-group">
                <label for="name">Medicine Name *</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($medicine['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="category">Category *</label>
                <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($medicine['category']); ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price (Rs.) *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo $medicine['price']; ?>" required>
            </div>

            <div class="form-group">
                <label for="stock_quantity">Stock Quantity *</label>
                <input type="number" id="stock_quantity" name="stock_quantity" min="0" value="<?php echo $medicine['stock_quantity']; ?>" required>
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" id="expiry_date" name="expiry_date" value="<?php echo $medicine['expiry_date']; ?>">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Medicine</button>
                <a href="manage_medicines.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>


