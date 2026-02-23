<?php
$page_title = 'Activity Logs';
include '../includes/header.php';
check_role('admin');

// Get all activity logs
$sql = "SELECT activity_logs.*, users.name 
        FROM activity_logs 
        LEFT JOIN users ON activity_logs.user_id = users.id 
        ORDER BY activity_logs.created_at DESC 
        LIMIT 100";
$logs_result = mysqli_query($conn, $sql);
$logs = [];
while ($row = mysqli_fetch_assoc($logs_result)) {
    $logs[] = $row;
}
?>

<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header">
        <h1>Activity Logs</h1>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="filter-item">
            <label for="filter_date">Date</label>
            <input type="date" id="filter_date">
        </div>
        <div class="filter-item">
            <label for="filter_user">User</label>
            <input type="text" id="filter_user" placeholder="Search user">
        </div>
        <div class="filter-item">
            <label for="filter_action">Action</label>
            <input type="text" id="filter_action" placeholder="Search action">
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <table class="data-table" id="logs_table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody id="logs_body">
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= date('Y-m-d', strtotime($log['created_at'])) ?></td>
                        <td><?= date('H:i:s', strtotime($log['created_at'])) ?></td>
                        <td><?= htmlspecialchars($log['name'] ?? 'System') ?></td>
                        <td><?= htmlspecialchars($log['action']) ?></td>
                        <td><?= htmlspecialchars($log['description']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div id="empty_state" class="empty-state" style="<?= count($logs) ? 'display:none;' : '' ?>">No logs found</div>
    </div>
</div>

<link rel="stylesheet" href="../assets/css/activity_logs.css">
<script src="../assets/js/activity_logs.js"></script>

<?php include '../includes/footer.php'; ?>
