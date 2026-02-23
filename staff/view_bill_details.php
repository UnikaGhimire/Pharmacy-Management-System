<?php
$page_title = 'Bill Details';
include '../includes/header.php';
check_role('staff');

$bill_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get bill details
$sql = "SELECT bills.*, users.name as staff_name 
        FROM bills 
        LEFT JOIN users ON bills.created_by = users.id 
        WHERE bills.id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $bill_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$bill = mysqli_fetch_assoc($result);

if (!$bill) {
    $_SESSION['error'] = 'Bill not found.';
    header('Location: view_bills.php');
    exit();
}

// Get bill items
$sql = "SELECT * FROM bill_items WHERE bill_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $bill_id);
mysqli_stmt_execute($stmt);
$items_result = mysqli_stmt_get_result($stmt);
?>

<div class="content-wrapper">
    <div class="page-header">
        <h1>Bill Details - #<?php echo $bill['id']; ?></h1>
        <a href="view_bills.php" class="btn btn-secondary btn-back">← Back to Bills</a>
    </div>

    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <h2><?php echo SITE_NAME; ?></h2>
            <p class="invoice-subtitle">Invoice</p>
        </div>

        <!-- Info Sections -->
        <div class="invoice-info">
            <div class="info-section">
                <h3>Bill Information</h3>
                <p><strong>Bill ID:</strong> #<?php echo $bill['id']; ?></p>
                <p><strong>Date:</strong> <?php echo date('M d, Y H:i', strtotime($bill['created_at'])); ?></p>
                <p><strong>Created By:</strong> <?php echo htmlspecialchars($bill['staff_name']); ?></p>
            </div>

            <div class="info-section">
                <h3>Customer Information</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($bill['customer_name']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($bill['customer_phone']); ?></p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="invoice-items">
            <h3>Items</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Medicine Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($items_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['medicine_name']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo format_currency($item['price']); ?></td>
                            <td><?php echo format_currency($item['subtotal']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3"><strong>Total Amount</strong></td>
                        <td><strong><?php echo format_currency($bill['total_amount']); ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong>Payment Status</strong></td>
                        <td>
                            <?php if ($bill['payment_status'] === 'paid'): ?>
                                <span class="badge badge-paid">Paid</span>
                            <?php else: ?>
                                <span class="badge badge-unpaid">Unpaid</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Print Button -->
        <div class="print-button-container">
            <button onclick="window.print()" class="btn-print">Print Invoice</button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="../assets/css/view_purchase.css">
<?php include '../includes/footer.php'; ?>
