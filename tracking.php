<?php
/**
 * tracking.php - Bogga lagu raadiyo baakidhaha (Tracking)
 * Version: 2.0 (PHP 8.2 compatible - sax column names)
 */

// 1. Magaca bogga
$title = 'Tracking';

// 2. Soo gal config.php (database connection)
require_once 'config.php';

// 3. Soo gal header.php (sidebar + topbar)
require_once 'header.php';

// ============================================================
// Raadi baakidhaha (Search Package)
// ============================================================
$search_result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tracking_id'])) {
    $tracking_id = trim($_POST['tracking_id']);
    if (!empty($tracking_id)) {
        // Isticmaal prepared statement si looga fogaado SQL Injection
        $stmt = mysqli_prepare($conn, "SELECT * FROM packages WHERE tracking_id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $tracking_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $search_result = mysqli_fetch_assoc($result);
            if (!$search_result) {
                $error = "No package found with Tracking ID: " . htmlspecialchars($tracking_id);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Database error occurred.";
        }
    } else {
        $error = "Please enter a Tracking ID.";
    }
}

// ============================================================
// Soo saar baakidhaha ugu dambeeya (Recent Packages - 10)
// ============================================================
$recent_packages = [];
$query = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC LIMIT 10");
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $recent_packages[] = $row;
    }
}
$total_recent = count($recent_packages);
?>

<!-- ============================================================
CONTENT GA BOGGA (Tracking)
============================================================ -->
<div class="container-fluid px-0">

    <!-- Header + Search Form -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <h4 class="fw-bold mb-0">Tracking</h4>
            <p class="text-muted mb-0">Track your packages using the Tracking ID</p>
        </div>
        <div class="col-lg-4">
            <form method="POST" action="" class="d-flex gap-2">
                <input type="text" name="tracking_id" class="form-control form-control-lg" placeholder="Enter Tracking ID (e.g. PKG-001)" required>
                <button type="submit" class="btn btn-primary btn-lg px-4">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- ===== Natiijada Raadinta (Search Result) ===== -->
    <?php if ($error): ?>
        <div class="alert alert-danger rounded-4 shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($search_result): ?>
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-box text-primary me-2"></i> Package Details
                    </h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-3 py-2">
                        <?= htmlspecialchars($search_result['tracking_id'] ?? '') ?>
                    </span>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="bg-light rounded-3 p-3 h-100">
                            <p class="text-muted small mb-1">Sender</p>
                            <h6 class="fw-bold mb-0"><?= htmlspecialchars($search_result['sender_name'] ?? 'N/A') ?></h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light rounded-3 p-3 h-100">
                            <p class="text-muted small mb-1">Receiver</p>
                            <h6 class="fw-bold mb-0"><?= htmlspecialchars($search_result['receiver_name'] ?? 'N/A') ?></h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded-3 p-3">
                            <p class="text-muted small mb-1">Phone</p>
                            <p class="fw-semibold mb-0"><?= htmlspecialchars($search_result['receiver_phone'] ?? 'N/A') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded-3 p-3">
                            <p class="text-muted small mb-1">Weight</p>
                            <p class="fw-semibold mb-0"><?= !empty($search_result['weight']) ? htmlspecialchars((string)$search_result['weight']) . ' kg' : 'N/A' ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded-3 p-3">
                            <p class="text-muted small mb-1">Status</p>
                            <?php 
                            $status_class = 'secondary';
                            $status_text = $search_result['status'] ?? 'unknown';
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
                                <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                <?= $status_text ?>
                            </span>
                        </div>
                    </div>
                    <?php if (!empty($search_result['delivery_address'])): ?>
                    <div class="col-12">
                        <div class="bg-light rounded-3 p-3">
                            <p class="text-muted small mb-1">Delivery Address</p>
                            <p class="fw-semibold mb-0"><?= htmlspecialchars($search_result['delivery_address'] ?? 'N/A') ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-12 text-muted small">
                        <i class="far fa-calendar-alt me-1"></i> Registered: <?= date('d M Y, h:i A', strtotime($search_result['created_at'] ?? 'now')) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ===== Recent Packages Table ===== -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="fas fa-history text-primary me-2"></i>Recent Packages</h5>
                <a href="packages.php" class="btn btn-outline-primary btn-sm">View All</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Tracking ID</th>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total_recent > 0): ?>
                            <?php $counter = 1; ?>
                            <?php foreach ($recent_packages as $pkg): ?>
                            <tr>
                                <td class="ps-4 fw-semibold text-muted"><?= $counter++ ?></td>
                                <td>
                                    <span class="badge bg-dark bg-opacity-10 text-dark fw-semibold">
                                        <?= htmlspecialchars($pkg['tracking_id'] ?? '') ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($pkg['sender_name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($pkg['receiver_name'] ?? '') ?></td>
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
                                <td><?= date('d M Y', strtotime($pkg['created_at'] ?? 'now')) ?></td>
                                <td class="text-center pe-4">
                                    <a href="tracking.php" class="btn btn-sm btn-outline-primary" title="Track">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-box-open fa-3x d-block mb-3 opacity-25"></i>
                                    <h5 class="fw-semibold">No packages found</h5>
                                    <p class="mb-0">Register a package to start tracking.</p>
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