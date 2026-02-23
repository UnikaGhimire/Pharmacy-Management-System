<?php
$page_title = 'Add Medicine';
include '../includes/header.php';
check_role('staff');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name']);
    $category = clean_input($_POST['category']);
    $price = floatval($_POST['price']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $expiry_date = $_POST['expiry_date'];
    
    if (empty($name) || empty($category) || $price <= 0) {
        $error = 'Please fill all required fields correctly.';
    } else {
        $sql = "INSERT INTO medicines (name, category, price, stock_quantity, expiry_date) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdis", $name, $category, $price, $stock_quantity, $expiry_date);
        
        if (mysqli_stmt_execute($stmt)) {
            log_activity($conn, $_SESSION['user_id'], 'Add Medicine', 'Added new medicine: ' . $name);
            $_SESSION['success'] = 'Medicine added successfully.';
            header('Location: manage_medicines.php');
            exit();
        } else {
            $error = 'Failed to add medicine.';
        }
    }
}
?>

<div class="content-wrapper">
    <div class="page-header">
        <h1>Add New Medicine</h1>
        <a href="manage_medicines.php" class="btn btn-secondary">Back</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="form-container">
        <form action="" method="POST" class="standard-form">
            <div class="form-group">
                <label for="name">Medicine Name *</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="category">Category *</label>
                <input type="text" id="category" name="category" required 
                       placeholder="e.g., Pain Relief, Antibiotic, Supplement">
            </div>

            <div class="form-group">
                <label for="price">Price (Rs.) *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required>
            </div>

            <div class="form-group">
                <label for="stock_quantity">Stock Quantity *</label>
                <input type="number" id="stock_quantity" name="stock_quantity" min="0" required>
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" id="expiry_date" name="expiry_date">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add Medicine</button>
                <a href="manage_medicines.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>


