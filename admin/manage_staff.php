<?php
$page_title = 'Manage Staff';
include '../includes/header.php';
check_role('admin');

// Filters
$search = $_GET['search'] ?? '';
$from_date = $_GET['from_date'] ?? '';
$to_date = $_GET['to_date'] ?? '';

$filter_sql = " WHERE role='staff' ";
$params = [];
$types = "";

if ($search) {
    $filter_sql .= " AND (name LIKE ? OR email LIKE ?) ";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= "ss";
}
if ($from_date) {
    $filter_sql .= " AND created_at >= ? ";
    $params[] = $from_date;
    $types .= "s";
}
if ($to_date) {
    $filter_sql .= " AND created_at <= ? ";
    $params[] = $to_date;
    $types .= "s";
}

// Prepare statement
$sql = "SELECT * FROM users $filter_sql ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$staff_result = mysqli_stmt_get_result($stmt);
?>

<div class="staff-page">
    <div class="page-header">
        <h1>Manage Staff</h1>
        <a href="add_staff.php" class="btn btn-primary">Add New Staff</a>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <form method="GET" class="filter-form">
            <div class="filter-item">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Name or Email">
            </div>

            <div class="filter-item">
                <label for="from_date">From</label>
                <input type="date" name="from_date" id="from_date" value="<?php echo htmlspecialchars($from_date); ?>">
            </div>

            <div class="filter-item">
                <label for="to_date">To</label>
                <input type="date" name="to_date" id="to_date" value="<?php echo htmlspecialchars($to_date); ?>">
            </div>

            <div class="filter-button">
                <button type="submit">Apply Filters</button>
            </div>
        </form>
    </div>

    <?php if (mysqli_num_rows($staff_result) > 0): ?>
    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($staff = mysqli_fetch_assoc($staff_result)): ?>
                <tr>
                    <td><?php echo $staff['id']; ?></td>
                    <td><?php echo htmlspecialchars($staff['name']); ?></td>
                    <td><?php echo htmlspecialchars($staff['email']); ?></td>
                    <td><?php echo htmlspecialchars($staff['phone']); ?></td>
                    <td><?php echo format_date($staff['created_at']); ?></td>
                    <td>
                        <a href="edit_staff.php?id=<?php echo $staff['id']; ?>" class="btn btn-view">Edit</a>
                        <a href="delete_staff.php?id=<?php echo $staff['id']; ?>" 
                           class="btn btn-danger" 
                           onclick="return confirm('Are you sure you want to delete this staff member?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="empty-state">
            <p>No staff members found.</p>
        </div>
    <?php endif; ?>
</div>

<link rel="stylesheet" href="../assets/css/manage_staff.css">
<script src="../assets/js/manage_staff.js"></script>
<?php include '../includes/footer.php'; ?>
