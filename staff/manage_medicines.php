<?php 
$page_title = 'Manage Medicines';
include '../includes/header.php';
check_role('staff');

// Get all medicines
$sql = "SELECT * FROM medicines ORDER BY name ASC";
$medicines_result = mysqli_query($conn, $sql);
?>

<div class="staff-page">

    <div class="page-header">
        <h1>Manage Medicines</h1>
        <a href="add_medicine.php" class="btn btn-primary">Add New Medicine</a>
    </div>

    <!-- Success Alert -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

 <!-- Filters -->
<div class="table-filters">
    <div class="filter-group">
        <label for="statusFilter">Status:</label>
        <select id="statusFilter">
            <option value="all">All</option>
            <option value="available">Available</option>
            <option value="low stock">Low Stock</option>
            <option value="expired">Expired</option>
        </select>
    </div>

    <div class="filter-group">
        <label for="categoryFilter">Category:</label>
        <select id="categoryFilter">
            <option value="all">All</option>
            <?php
            // Get unique categories from the medicines table
            $cat_sql = "SELECT DISTINCT category FROM medicines ORDER BY category ASC";
            $cat_result = mysqli_query($conn, $cat_sql);
            while($cat = mysqli_fetch_assoc($cat_result)) {
                echo '<option value="'.htmlspecialchars(strtolower($cat['category'])).'">'.htmlspecialchars($cat['category']).'</option>';
            }
            ?>
        </select>
    </div>

    <div class="filter-group">
        <label for="searchFilter">Search Medicine:</label>
        <input type="text" id="searchFilter" placeholder="Type name...">
    </div>
</div>

    <!-- Medicines Table -->
    <div class="table-card">
        <?php if(mysqli_num_rows($medicines_result) > 0): ?>
        <table class="data-table" id="medicinesTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
           <tbody>
<?php while ($medicine = mysqli_fetch_assoc($medicines_result)): ?>
    <?php
        // Determine status
        if (is_medicine_expired($medicine['expiry_date'])) {
            $status = 'expired';
            $status_class = 'badge-danger';
        } elseif (is_low_stock($medicine['stock_quantity'])) {
            $status = 'low stock';
            $status_class = 'badge-warning';
        } else {
            $status = 'available';
            $status_class = 'badge-success';
        }
    ?>
    <tr data-status="<?= $status; ?>" data-category="<?= strtolower(htmlspecialchars($medicine['category'])); ?>">
        <td><?= $medicine['id']; ?></td>
        <td><?= htmlspecialchars($medicine['name']); ?></td>
        <td><?= htmlspecialchars($medicine['category']); ?></td>
        <td><?= format_currency($medicine['price']); ?></td>
        <td><?= $medicine['stock_quantity']; ?></td>
        <td><?= format_date($medicine['expiry_date']); ?></td>
        <td>
            <span class="badge <?= $status_class; ?>">
                <?= ucfirst($status); ?>
            </span>
        </td>
        <td class="action-buttons">
            <a href="edit_medicine.php?id=<?= $medicine['id']; ?>" class="btn-view">Edit</a>
            <a href="delete_medicine.php?id=<?= $medicine['id']; ?>" class="btn-danger" onclick="return confirm('Are you sure you want to delete this medicine?')">Delete</a>
        </td>
    </tr>
<?php endwhile; ?>
</tbody>

        </table>
        <?php else: ?>
            <div class="empty-state">No medicines found.</div>
        <?php endif; ?>
    </div>

</div>

<link rel="stylesheet" href="../assets/css/medicines.css">
<script src="../assets/js/manage_medicines.js" defer></script>
<?php include '../includes/footer.php'; ?>
