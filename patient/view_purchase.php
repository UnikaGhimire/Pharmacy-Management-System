<?php
$page_title = 'Purchase Details';
include '../includes/header.php';
check_role('patient');

$user_id = $_SESSION['user_id'];
$bill_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get bill details (ensure it belongs to this patient)
$sql = "SELECT * FROM bills WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $bill_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$bill = mysqli_fetch_assoc($result);

if (!$bill) {
    $_SESSION['error'] = 'Purchase not found.';
    header('Location: billing_history.php');
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
        <h1>Purchase Details - #<?php echo $bill['id']; ?></h1>
        <a href="billing_history.php" class="btn btn-secondary btn-back">← Back to History</a>
    </div>

    <div class="invoice-container">

        <!-- Header -->
        <div class="invoice-header">
            <h2><?php echo SITE_NAME; ?></h2>
            <p class="invoice-subtitle">Purchase Receipt</p>
        </div>

        <!-- Info -->
        <div class="invoice-info">
            <div class="info-section">
                <h3>Purchase Information</h3>
                <p><strong>Receipt ID:</strong> #<?php echo $bill['id']; ?></p>
                <p><strong>Date:</strong> <?php echo date('M d, Y H:i', strtotime($bill['created_at'])); ?></p>
            </div>

            <div class="info-section">
                <h3>Customer</h3>
                <p><?php echo htmlspecialchars($bill['customer_name']); ?></p>
                <p><?php echo htmlspecialchars($bill['customer_phone']); ?></p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="invoice-items">
            <h3>Items Purchased</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Qty</th>
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
        <div class="print-button-container">
    <button onclick="window.print()" class="btn-print"> Print Receipt</button>
</div>
    </div>
</div>

<link rel="stylesheet" href="../assets/css/view_purchase.css">
<?php include '../includes/footer.php'; ?>
