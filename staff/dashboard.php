<?php
$page_title = 'Staff Dashboard';
include '../includes/header.php';
check_role('staff');

// Get statistics
$sql = "SELECT COUNT(*) as count FROM users WHERE role = 'patient'";
$total_patients = mysqli_fetch_assoc(mysqli_query($conn, $sql))['count'];

$sql = "SELECT COUNT(*) as count FROM medicines";
$total_medicines = mysqli_fetch_assoc(mysqli_query($conn, $sql))['count'];

$sql = "SELECT COUNT(*) as count FROM bills WHERE created_by = " . $_SESSION['user_id'];
$my_bills = mysqli_fetch_assoc(mysqli_query($conn, $sql))['count'];

$sql = "SELECT COUNT(*) as count FROM medicines WHERE stock_quantity <= " . LOW_STOCK_THRESHOLD;
$low_stock_count = mysqli_fetch_assoc(mysqli_query($conn, $sql))['count'];
?>



<div class="staff-wrap">

    <div class="staff-header">
        <h1>
            <svg class="header-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 14v4M11 10v8M15 6v12"/>
            </svg>
            Staff Overview
        </h1>
        <span>Dashboard & recent activity</span>
    </div>

    <!-- KPI PANEL -->
    <div class="kpi-panel">
        <div class="kpi-row">
            <svg class="kpi-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <circle cx="12" cy="7" r="4"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.5 21a6.5 6.5 0 0113 0"/>
            </svg>
            <div class="kpi-title">Total Patients</div>
            <div class="kpi-value"><?php echo $total_patients; ?></div>
            <div class="kpi-status">Active</div>
        </div>

        <div class="kpi-row">
            <svg class="kpi-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <rect x="4" y="4" width="16" height="16" rx="3"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/>
            </svg>
            <div class="kpi-title">Total Medicines</div>
            <div class="kpi-value"><?php echo $total_medicines; ?></div>
            <div class="kpi-status">Inventory</div>
        </div>

        <div class="kpi-row">
            <svg class="kpi-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <circle cx="12" cy="12" r="9"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12"/>
            </svg>
            <div class="kpi-title">My Bills</div>
            <div class="kpi-value"><?php echo $my_bills; ?></div>
            <div class="kpi-status info">Created</div>
        </div>

        <div class="kpi-row">
            <svg class="kpi-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 19h14l-7-14-7 14z"/>
            </svg>
            <div class="kpi-title">Low Stock Items</div>
            <div class="kpi-value"><?php echo $low_stock_count; ?></div>
            <div class="kpi-status warning">Attention</div>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="main-grid">

        <!-- ACTION PANEL -->
        <div class="action-panel">
            <h2>
                <svg class="action-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6"/>
                </svg>
                Quick Actions
            </h2>
            <div class="action-list">
                <a href="billing.php">
                    <svg class="action-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/>
                    </svg>
                    Create Bill
                </a>
                <a href="add_patient.php">
                    <svg class="action-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="7" r="4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.5 21a6.5 6.5 0 0113 0"/>
                    </svg>
                    Add Patient
                </a>
                <a href="add_medicine.php">
                    <svg class="action-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="4" y="4" width="16" height="16" rx="3"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/>
                    </svg>
                    Add Medicine
                </a>
                <a href="view_bills.php">
                    <svg class="action-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6m4 6V7m4 10V11"/>
                    </svg>
                    View Bills
                </a>
            </div>
        </div>

        <!-- RECENT ACTIVITY -->
        <div class="activity-panel">
            <h2>
                <svg class="action-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                    <circle cx="12" cy="12" r="9"/>
                </svg>
                Recent Activity
            </h2>

            <?php
            $sql = "SELECT activity_logs.*, users.name 
                    FROM activity_logs 
                    LEFT JOIN users ON activity_logs.user_id = users.id 
                    WHERE activity_logs.user_id = " . $_SESSION['user_id'] . "
                    ORDER BY activity_logs.created_at DESC 
                    LIMIT 5";
            $result = mysqli_query($conn, $sql);
            ?>

            <div class="activity-feed">
                <?php while ($log = mysqli_fetch_assoc($result)): ?>
                    <div class="activity-item">
                        <svg class="activity-icon" fill="none" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13"/>
                            <circle cx="3" cy="6" r="1"/>
                            <circle cx="3" cy="12" r="1"/>
                            <circle cx="3" cy="18" r="1"/>
                        </svg>

                        <div class="activity-content">
                            <strong><?php echo htmlspecialchars($log['name'] ?? 'System'); ?></strong>
                            <span><?php echo htmlspecialchars($log['action']); ?></span>
                            <small><?php echo date('M d, Y H:i', strtotime($log['created_at'])); ?></small>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

    </div>
</div>
<link rel="stylesheet" href="../assets/css/staff-dashboard.css">


<?php include '../includes/footer.php'; ?>
