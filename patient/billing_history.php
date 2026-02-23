<?php
$page_title = 'Purchase History';
include '../includes/header.php';
check_role('patient');

$user_id = $_SESSION['user_id'];

// Filters
$filter = $_GET['filter'] ?? 'all';
$from_date = $_GET['from_date'] ?? '';
$to_date = $_GET['to_date'] ?? '';

$filter_sql = " AND 1=1 ";
if ($filter === 'paid') $filter_sql .= " AND payment_status='paid'";
elseif ($filter === 'unpaid') $filter_sql .= " AND payment_status='unpaid'";
if ($from_date) $filter_sql .= " AND created_at >= ?";
if ($to_date) $filter_sql .= " AND created_at <= ?";

$sql = "SELECT * FROM bills WHERE user_id = ? $filter_sql ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $sql);

// Dynamic params
$params = [$user_id];
$types = "i";
if ($from_date) { $params[] = $from_date; $types .= "s"; }
if ($to_date) { $params[] = $to_date; $types .= "s"; }

mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$bills_result = mysqli_stmt_get_result($stmt);
?>

<div class="purchase-page">

    <h1 class="page-title">Purchase History</h1>

    <!-- Filters Toolbar -->
    <div class="filter-card">
        <form method="GET" class="filter-form">
            <div class="filter-item">
                <label>Status</label>
                <select name="filter">
                    <option value="all" <?php if($filter==='all') echo 'selected'; ?>>All</option>
                    <option value="paid" <?php if($filter==='paid') echo 'selected'; ?>>Paid</option>
                    <option value="unpaid" <?php if($filter==='unpaid') echo 'selected'; ?>>Unpaid</option>
                </select>
            </div>

            <div class="filter-item">
                <label>From</label>
                <input type="date" name="from_date" value="<?php echo htmlspecialchars($from_date); ?>">
            </div>

            <div class="filter-item">
                <label>To</label>
                <input type="date" name="to_date" value="<?php echo htmlspecialchars($to_date); ?>">
            </div>

            <div class="filter-item filter-button">
                <button type="submit">Apply Filters</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <?php if (mysqli_num_rows($bills_result) > 0): ?>
        <div class="table-card">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Bill ID</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($bill = mysqli_fetch_assoc($bills_result)): ?>
                        <tr>
                            <td>#<?php echo $bill['id']; ?></td>
                            <td><?php echo date('M d, Y H:i', strtotime($bill['created_at'])); ?></td>
                            <td><?php echo format_currency($bill['total_amount']); ?></td>
                            <td>
                                <?php if ($bill['payment_status'] === 'paid'): ?>
                                    <span class="badge badge-paid">Paid</span>
                                <?php else: ?>
                                    <span class="badge badge-unpaid">Unpaid</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="view_purchase.php?id=<?php echo $bill['id']; ?>" class="btn-view">View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <p>No purchases found for the selected filter.</p>
        </div>
    <?php endif; ?>

</div>

<link rel="stylesheet" href="../assets/css/purchase_history.css">
<?php include '../includes/footer.php'; ?>
