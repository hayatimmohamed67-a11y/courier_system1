<?php
/**
 * drivers.php - Bogga lagu soo bandhigo dhammaan darawallada (All Drivers)
 * Version: 3.0 (PHP 8.2 compatible - htmlspecialchars with null coalescing)
 */

// 1. Magaca bogga
$title = 'All Drivers';

// 2. Soo gal config.php (database connection)
require_once 'config.php';

// 3. Soo gal header.php (sidebar + topbar)
require_once 'header.php';

// ============================================================
// Soo saar dhammaan darawallada (Drivers)
// ============================================================
$drivers = [];
$query = mysqli_query($conn, "SELECT * FROM drivers ORDER BY id DESC");

if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $drivers[] = $row;
    }
}

// Tirada guud
$total_drivers = count($drivers);
?>

<!-- ============================================================
CONTENT GA BOGGA (All Drivers)
============================================================ -->
<div class="container-fluid px-0">

    <!-- Header + Badhanka "Register New Driver" -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">All Drivers</h4>
            <p class="text-muted mb-0">Total: <strong><?= $total_drivers ?></strong> drivers</p>
        </div>
        <a href="register_driver.php" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i> Register New Driver
        </a>
    </div>

    <!-- ===== Table-ka Darawallada ===== -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-radius: 16px; overflow: hidden;">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Vehicle Type</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th class="text-center pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total_drivers > 0): ?>
                            <?php $counter = 1; ?>
                            <?php foreach ($drivers as $driver): ?>
                            <tr>
                                <td class="ps-4 fw-semibold text-muted"><?= $counter++ ?></td>
                                <td>
                                    <span class="badge bg-dark bg-opacity-10 text-dark fw-semibold">
                                        #<?= htmlspecialchars($driver['id'] ?? '') ?>
                                    </span>
                                </td>
                                <td class="fw-semibold"><?= htmlspecialchars($driver['name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($driver['phone'] ?? '') ?></td>
                                <td><?= htmlspecialchars($driver['vehicle_type'] ?? 'N/A') ?></td>
                                <td>
                                    <?php 
                                    $status_class = 'secondary';
                                    $status_text = $driver['status'] ?? 'inactive';
                                    if ($status_text == 'active') {
                                        $status_class = 'success';
                                        $status_text = 'Active';
                                    } elseif ($status_text == 'inactive') {
                                        $status_class = 'secondary';
                                        $status_text = 'Inactive';
                                    } elseif ($status_text == 'busy') {
                                        $status_class = 'warning';
                                        $status_text = 'Busy';
                                    } elseif ($status_text == 'offline') {
                                        $status_class = 'danger';
                                        $status_text = 'Offline';
                                    }
                                    ?>
                                    <span class="badge bg-<?= $status_class ?> bg-opacity-10 text-<?= $status_class ?> border border-<?= $status_class ?> border-opacity-25 px-3 py-2 fw-semibold">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                        <?= $status_text ?>
                                    </span>
                                </td>
                                <td><?= date('d M Y, h:i A', strtotime($driver['created_at'] ?? 'now')) ?></td>
                                <td class="text-center pe-4">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="edit_driver.php?id=<?= $driver['id'] ?? 0 ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_driver.php?id=<?= $driver['id'] ?? 0 ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this driver?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="fas fa-user-slash fa-3x d-block mb-3 opacity-25"></i>
                                    <h5 class="fw-semibold">No drivers found</h5>
                                    <p class="mb-0">Click <strong>"Register New Driver"</strong> to add your first driver.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php
// 4. Soo gal footer.php (haddii aad leedahay)
// require_once 'footer.php';
?>