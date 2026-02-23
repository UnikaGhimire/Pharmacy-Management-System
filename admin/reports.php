<?php
$page_title = 'Reports';
include '../includes/header.php';
check_role('admin');

// Date filter (default last 30 days)
$from_date = $_GET['from_date'] ?? date('Y-m-d', strtotime('-30 days'));
$to_date   = $_GET['to_date'] ?? date('Y-m-d');

// Sales report
$sql = "SELECT DATE(created_at) as date, COUNT(*) as total_bills, SUM(total_amount) as total_sales
        FROM bills 
        WHERE DATE(created_at) BETWEEN '$from_date' AND '$to_date'
        GROUP BY DATE(created_at) 
        ORDER BY date DESC";
$sales_result = mysqli_query($conn, $sql);

// Low stock medicines
$sql = "SELECT * FROM medicines WHERE stock_quantity <= " . LOW_STOCK_THRESHOLD . " ORDER BY stock_quantity ASC";
$low_stock_result = mysqli_query($conn, $sql);

// Expired medicines
$sql = "SELECT * FROM medicines WHERE expiry_date < CURDATE() ORDER BY expiry_date ASC";
$expired_result = mysqli_query($conn, $sql);
?>

<div class="reports-wrap">

    <div class="reports-header">
        <svg class="header-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6m4 6V7m4 10V11"/>
        </svg>
        <h1>Reports</h1>
    </div>

    <!-- SALES REPORT -->
    <div class="report-block">
        <h2>
            <svg class="icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 14v4M11 10v8M15 6v12"/>
            </svg>
            Sales Report
        </h2>

        <!-- FILTER -->
        <form method="GET" class="filter-form">
            <div>
                <label>From</label>
                <input type="date" name="from_date" value="<?php echo $from_date; ?>">
            </div>
            <div>
                <label>To</label>
                <input type="date" name="to_date" value="<?php echo $to_date; ?>">
            </div>
            <button type="submit">Apply</button>
        </form>

        <div class="table-wrap">
            <?php if(mysqli_num_rows($sales_result) > 0): ?>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total Bills</th>
                        <th>Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_sales_sum = 0;
                    while ($sale = mysqli_fetch_assoc($sales_result)):
                        $total_sales_sum += $sale['total_sales'];
                    ?>
                        <tr>
                            <td><?php echo format_date($sale['date']); ?></td>
                            <td><?php echo $sale['total_bills']; ?></td>
                            <td><?php echo format_currency($sale['total_sales']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <tr class="total-row">
                        <td>Total</td>
                        <td></td>
                        <td><?php echo format_currency($total_sales_sum); ?></td>
                    </tr>
                </tbody>
            </table>
            <?php else: ?>
                <div class="empty-state">No sales found for the selected date range.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- LOW STOCK -->
    <div class="report-block">
        <h2>
            <svg class="icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 19h14l-7-14-7 14z"/>
            </svg>
            Low Stock Medicines
        </h2>

        <div class="table-wrap">
            <?php if(mysqli_num_rows($low_stock_result) > 0): ?>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($medicine = mysqli_fetch_assoc($low_stock_result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($medicine['name']); ?></td>
                            <td><?= htmlspecialchars($medicine['category']); ?></td>
                            <td><?= $medicine['stock_quantity']; ?></td>
                            <td><span class="badge badge-warning">Low Stock</span></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="empty-state">No low stock medicines found.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- EXPIRED -->
    <div class="report-block">
        <h2>
            <svg class="icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Expired Medicines
        </h2>

        <div class="table-wrap">
            <?php if(mysqli_num_rows($expired_result) > 0): ?>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($medicine = mysqli_fetch_assoc($expired_result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($medicine['name']); ?></td>
                            <td><?= htmlspecialchars($medicine['category']); ?></td>
                            <td><?= $medicine['stock_quantity']; ?></td>
                            <td><?= format_date($medicine['expiry_date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="empty-state">No expired medicines found.</div>
            <?php endif; ?>
        </div>
    </div>

</div>

<link rel="stylesheet" href="../assets/css/reports.css">
<script src="../assets/js/reports.js" defer></script>

<?php include '../includes/footer.php'; ?>
