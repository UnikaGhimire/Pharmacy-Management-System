<?php 
$page_title = 'View Bills';
include '../includes/header.php';
check_role('staff');

// Get all bills
$sql = "SELECT bills.*, users.name as staff_name 
        FROM bills 
        LEFT JOIN users ON bills.created_by = users.id 
        ORDER BY bills.created_at DESC";
$bills_result = mysqli_query($conn, $sql);
?>

<div class="content-wrapper">
    <div class="page-header">
        <h1>All Bills</h1>
        <a href="billing.php" class="btn btn-primary">Create New Bill</a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="table-filters">
        <div class="filter-group">
            <label for="statusFilter">Payment Status:</label>
            <select id="statusFilter">
                <option value="all">All</option>
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="searchFilter">Search Customer:</label>
            <input type="text" id="searchFilter" placeholder="Type name...">
        </div>
    </div>

    <div class="table-card">
        <table class="data-table" id="billsTable">
            <thead>
                <tr>
                    <th>Bill ID</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($bill = mysqli_fetch_assoc($bills_result)): ?>
                    <tr>
                        <td>#<?php echo $bill['id']; ?></td>
                        <td><?php echo date('M d, Y H:i', strtotime($bill['created_at'])); ?></td>
                        <td><?php echo htmlspecialchars($bill['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($bill['customer_phone']); ?></td>
                        <td><?php echo format_currency($bill['total_amount']); ?></td>
                        <td>
                            <span class="badge <?php echo $bill['payment_status']==='paid' ? 'badge-success' : 'badge-warning'; ?>">
                                <?php echo ucfirst($bill['payment_status']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($bill['staff_name']); ?></td>
                        <td>
                            <a href="view_bill_details.php?id=<?php echo $bill['id']; ?>" 
                               class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>


<link href="../assets/css/manage_bills.css" rel="stylesheet">
<script src="../assets/js/manage_bills.js"></script>
<?php include '../includes/footer.php'; ?>


