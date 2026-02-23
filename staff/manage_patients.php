<?php
$page_title = 'Manage Patients';
include '../includes/header.php';
check_role('staff');

// Get all patients
$sql = "SELECT * FROM users WHERE role = 'patient' ORDER BY created_at DESC";
$patients_result = mysqli_query($conn, $sql);
?>

<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header">
        <h1>Manage Patients</h1>
        <a href="add_patient.php" class="btn btn-primary">Add New Patient</a>
    </div>

    <!-- Success Alert -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="table-filters">
        <div class="filter-group">
            <label for="searchFilter">Search Name/Email:</label>
            <input type="text" id="searchFilter" placeholder="Type name or email...">
        </div>
    </div>

    <!-- Patients Table -->
    <div class="table-card">
        <?php if(mysqli_num_rows($patients_result) > 0): ?>
        <table class="data-table" id="patientsTable">
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
                <?php while ($patient = mysqli_fetch_assoc($patients_result)): ?>
                    <tr>
                        <td><?= $patient['id']; ?></td>
                        <td><?= htmlspecialchars($patient['name']); ?></td>
                        <td><?= htmlspecialchars($patient['email']); ?></td>
                        <td><?= htmlspecialchars($patient['phone']); ?></td>
                        <td><?= format_date($patient['created_at']); ?></td>
                        <td class="action-buttons">
                            <a href="edit_patient.php?id=<?= $patient['id']; ?>" class="btn-view">Edit</a>
                            <a href="delete_patient.php?id=<?= $patient['id']; ?>" 
                               class="btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this patient?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="empty-state">No patients found.</div>
        <?php endif; ?>
    </div>

</div>

<link rel="stylesheet" href="../assets/css/manage_patients.css">
<script src="../assets/js/manage_patients.js" defer></script>
<?php include '../includes/footer.php'; ?>
