<nav class="navbar">
    <div class="nav-container">
        <div class="nav-brand">
            <a href="<?php echo SITE_URL; ?>"><?php echo SITE_NAME; ?></a>
        </div>

        <!-- Hamburger button -->
        <div class="nav-toggle" id="nav-toggle">&#9776;</div>

        <!-- Navigation links -->
        <div class="nav-menu" id="nav-menu">
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="<?php echo SITE_URL; ?>admin/dashboard.php">Dashboard</a>
                <a href="<?php echo SITE_URL; ?>admin/manage_staff.php">Manage Staff</a>
                <a href="<?php echo SITE_URL; ?>admin/activity_logs.php">Activity Logs</a>
                <a href="<?php echo SITE_URL; ?>admin/reports.php">Reports</a>
            <?php elseif ($_SESSION['role'] === 'staff'): ?>
                <a href="<?php echo SITE_URL; ?>staff/dashboard.php">Dashboard</a>
                <a href="<?php echo SITE_URL; ?>staff/manage_patients.php">Patients</a>
                <a href="<?php echo SITE_URL; ?>staff/manage_medicines.php">Medicines</a>
                <a href="<?php echo SITE_URL; ?>staff/billing.php">Billing</a>
                <a href="<?php echo SITE_URL; ?>staff/view_bills.php">View Bills</a>
            <?php elseif ($_SESSION['role'] === 'patient'): ?>
                <a href="<?php echo SITE_URL; ?>patient/dashboard.php">Dashboard</a>
                <a href="<?php echo SITE_URL; ?>patient/profile.php">Profile</a>
                <a href="<?php echo SITE_URL; ?>patient/billing_history.php">Purchase History</a>
            <?php endif; ?>
        </div>

        <div class="nav-user">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
            <a href="<?php echo SITE_URL; ?>logout.php" class="btn-logout">Logout</a>
        </div>
    </div>
</nav>
