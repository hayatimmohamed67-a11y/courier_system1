<?php
/**
 * packages.php - Bogga lagu soo bandhigo dhammaan baakidhaha (All Packages)
 * Version: 3.0 (PHP 8.2 compatible - htmlspecialchars null fix)
 */

// 1. Magaca bogga
$title = 'All Packages';

// 2. Soo gal config.php (database connection)
require_once 'config.php';

// 3. Soo gal header.php (sidebar + topbar)
require_once 'header.php';

// ============================================================
// Soo saar dhammaan baakidhaha (Packages)
// ============================================================
$packages = [];
$query = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC");

if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $packages[] = $row;
    }
}

// Tirada guud
$total_packages = count($packages);
?>

<!-- ============================================================
CONTENT GA BOGGA (All Packages)
============================================================ -->
<div class="container-fluid px-0">

    <!-- Header + Badhanka "Register New Package" -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">All Packages</h4>
            <p class="text-muted mb-0">Total: <strong><?= $total_packages ?></strong> packages</p>
        </div>
        <a href="register_package.php" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Register New Package
        </a>
    </div>

    <!-- ===== Table-ka Baakidhaha ===== -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-radius: 16px; overflow: hidden;">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Tracking ID</th>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Phone</th>
                            <th>Weight</th>
                            <th>Status</th>
                            <th>Received Date</th>
                            <th class="text-center pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total_packages > 0): ?>
                            <?php $counter = 1; ?>
                            <?php foreach ($packages as $pkg): ?>
                            <tr>
                                <td class="ps-4 fw-semibold text-muted"><?= $counter++ ?></td>
                                <td>
                                    <span class="badge bg-dark bg-opacity-10 text-dark fw-semibold" style="letter-spacing: 0.5px;">
                                        <?= htmlspecialchars($pkg['tracking_id'] ?? '') ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($pkg['sender_name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($pkg['receiver_name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($pkg['receiver_phone'] ?? '') ?></td>
                                <td>
                                    <?php if (!empty($pkg['weight'])): ?>
                                        <?= htmlspecialchars((string)$pkg['weight']) ?> kg
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                    $status_class = 'secondary';
                                    $status_text = $pkg['status'] ?? 'unknown';
                                    if ($status_text == 'delivered') {
                                        $status_class = 'success';
                                        $status_text = 'Delivered';
                                    } elseif ($status_text == 'pending') {
                                        $status_class = 'warning';
                                        $status_text = 'Pending';
                                    } elseif ($status_text == 'in_transit') {
                                        $status_class = 'primary';
                                        $status_text = 'In Transit';
                                    } elseif ($status_text == 'cancelled') {
                                        $status_class = 'danger';
                                        $status_text = 'Cancelled';
                                    }
                                    ?>
                                    <span class="badge bg-<?= $status_class ?> bg-opacity-10 text-<?= $status_class ?> border border-<?= $status_class ?> border-opacity-25 px-3 py-2 fw-semibold">
                                        <?= $status_text ?>
                                    </span>
                                </td>
                                <td><?= date('d M Y, h:i A', strtotime($pkg['created_at'] ?? 'now')) ?></td>
                                <td class="text-center pe-4">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="tracking.php?id=<?= $pkg['id'] ?? 0 ?>" class="btn btn-sm btn-outline-primary" title="Track">
                                            <i class="fas fa-search"></i>
                                        </a>
                                        <a href="edit_package.php?id=<?= $pkg['id'] ?? 0 ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_package.php?id=<?= $pkg['id'] ?? 0 ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this package?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class="fas fa-box-open fa-3x d-block mb-3 opacity-25"></i>
                                    <h5 class="fw-semibold">No packages found</h5>
                                    <p class="mb-0">Click <strong>"Register New Package"</strong> to add your first package.</p>
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