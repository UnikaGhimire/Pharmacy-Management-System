<?php
$page_title = 'Patient Dashboard';
include '../includes/header.php';
check_role('patient');

$user_id = $_SESSION['user_id'];

// Get statistics
$sql = "SELECT COUNT(*) as count FROM bills WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_bills = mysqli_fetch_assoc($result)['count'];

$sql = "SELECT SUM(total_amount) as total FROM bills WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_spent = mysqli_fetch_assoc($result)['total'] ?? 0;

// Get recent bills
$sql = "SELECT * FROM bills WHERE user_id = ? ORDER BY created_at DESC LIMIT 5";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$recent_bills = mysqli_stmt_get_result($stmt);
?>

<div class="content-wrapper">
    <div class="page-header">
        <h1>Patient Dashboard</h1>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">🧾</div>
            <div class="stat-info">
                <h3><?php echo $total_bills; ?></h3>
                <p>Total Purchases</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-info">
                <h3><?php echo format_currency($total_spent); ?></h3>
                <p>Total Amount Spent</p>
            </div>
        </div>
    </div>

    <div class="dashboard-sections">
        <div class="section-card">
            <h2>Recent Purchases</h2>
            <?php if (mysqli_num_rows($recent_bills) > 0): ?>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Bill ID</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($bill = mysqli_fetch_assoc($recent_bills)): ?>
                                <tr>
                                    <td>#<?php echo $bill['id']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($bill['created_at'])); ?></td>
                                    <td><?php echo format_currency($bill['total_amount']); ?></td>
                                    <td>
                                        <?php if ($bill['payment_status'] === 'paid'): ?>
                                            <span class="badge badge-success">Paid</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Unpaid</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <a href="billing_history.php" class="btn btn-secondary">View All Purchases</a>
            <?php else: ?>
                <p>No purchase history yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/patient-dashboard.css">
<script src="<?php echo SITE_URL; ?>assets/js/patient-dashboard.js"></script>
<?php include '../includes/footer.php'; ?>
