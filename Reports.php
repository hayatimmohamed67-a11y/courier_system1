<?php
/**
 * reports.php - Bogga Warbixinnada (Reports)
 * Version: 2.0 (PHP 8.2 compatible - htmlspecialchars with null coalescing)
 */

// 1. Magaca bogga
$title = 'Reports';

// 2. Soo gal config.php (database connection)
require_once 'config.php';

// 3. Soo gal header.php (sidebar + topbar)
require_once 'header.php';

// ============================================================
// Soo saar xogta warbixinnada (Statistics)
// ============================================================

// --- Tirada guud ee baakidhaha (Total Orders) ---
$total_orders = 0;
$query = mysqli_query($conn, "SELECT COUNT(*) as count FROM packages");
if ($query) {
    $row = mysqli_fetch_assoc($query);
    $total_orders = $row['count'];
}

// --- Tirada la gaarsiiyay (Delivered) ---
$delivered = 0;
$query = mysqli_query($conn, "SELECT COUNT(*) as count FROM packages WHERE status = 'delivered'");
if ($query) {
    $row = mysqli_fetch_assoc($query);
    $delivered = $row['count'];
}

// --- Tirada sugaya (Pending) ---
$pending = 0;
$query = mysqli_query($conn, "SELECT COUNT(*) as count FROM packages WHERE status = 'pending'");
if ($query) {
    $row = mysqli_fetch_assoc($query);
    $pending = $row['count'];
}

// --- Tirada waddada ku jira (In Transit) ---
$in_transit = 0;
$query = mysqli_query($conn, "SELECT COUNT(*) as count FROM packages WHERE status = 'in_transit'");
if ($query) {
    $row = mysqli_fetch_assoc($query);
    $in_transit = $row['count'];
}

// --- Tirada la joojiyay (Cancelled) ---
$cancelled = 0;
$query = mysqli_query($conn, "SELECT COUNT(*) as count FROM packages WHERE status = 'cancelled'");
if ($query) {
    $row = mysqli_fetch_assoc($query);
    $cancelled = $row['count'];
}

// --- Tirada darawallada guud ---
$total_drivers = 0;
$query = mysqli_query($conn, "SELECT COUNT(*) as count FROM drivers");
if ($query) {
    $row = mysqli_fetch_assoc($query);
    $total_drivers = $row['count'];
}

// --- Tirada darawallada firfircoon (Active Drivers) ---
$active_drivers = 0;
$query = mysqli_query($conn, "SELECT COUNT(*) as count FROM drivers WHERE status = 'active'");
if ($query) {
    $row = mysqli_fetch_assoc($query);
    $active_drivers = $row['count'];
}

// --- Tirada macaamiisha guud ---
$total_customers = 0;
$query = mysqli_query($conn, "SELECT COUNT(*) as count FROM customers");
if ($query) {
    $row = mysqli_fetch_assoc($query);
    $total_customers = $row['count'];
}

// --- Baakidhaha ugu dambeeya (Recent Packages - 5) ---
$recent_packages = [];
$query = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC LIMIT 5");
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $recent_packages[] = $row;
    }
}
$total_recent = count($recent_packages);
?>

<!-- ============================================================
CONTENT GA BOGGA (Reports)
============================================================ -->
<div class="container-fluid px-0">

    <!-- Header -->
    <div class="mb-4">
        <h4 class="fw-bold mb-0">Reports</h4>
        <p class="text-muted mb-0">Overview of your courier system statistics</p>
    </div>

    <!-- ===== ROW 1: Stat Cards ===== -->
    <div class="row g-4 mb-4">
        <!-- Total Orders -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card p-4 rounded-4 shadow-sm bg-white h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 fw-semibold fs-6">TOTAL ORDERS</p>
                        <h2 class="fw-bold mb-0"><?= $total_orders ?></h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                        <i class="fas fa-box text-primary fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivered -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card p-4 rounded-4 shadow-sm bg-white h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 fw-semibold fs-6">DELIVERED</p>
                        <h2 class="fw-bold mb-0"><?= $delivered ?></h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-3">
                        <i class="fas fa-check-circle text-success fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card p-4 rounded-4 shadow-sm bg-white h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 fw-semibold fs-6">PENDING</p>
                        <h2 class="fw-bold mb-0"><?= $pending ?></h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                        <i class="fas fa-clock text-warning fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Drivers -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card p-4 rounded-4 shadow-sm bg-white h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 fw-semibold fs-6">ACTIVE DRIVERS</p>
                        <h2 class="fw-bold mb-0"><?= $active_drivers ?></h2>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-3">
                        <i class="fas fa-truck text-info fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ROW 2: Status Breakdown + Recent Packages ===== -->
    <div class="row g-4">
        <!-- Left: Status Breakdown -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-3"><i class="fas fa-chart-pie text-primary me-2"></i>Status Breakdown</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Status</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $statuses = [
                                ['label' => 'Delivered', 'count' => $delivered, 'class' => 'success'],
                                ['label' => 'Pending', 'count' => $pending, 'class' => 'warning'],
                                ['label' => 'In Transit', 'count' => $in_transit, 'class' => 'primary'],
                                ['label' => 'Cancelled', 'count' => $cancelled, 'class' => 'danger'],
                            ];
                            $total = $total_orders > 0 ? $total_orders : 1;
                            foreach ($statuses as $status): 
                            ?>
                            <tr>
                                <td>
                                    <span class="badge bg-<?= $status['class'] ?> bg-opacity-10 text-<?= $status['class'] ?> px-3 py-2">
                                        <?= $status['label'] ?>
                                    </span>
                                </td>
                                <td class="fw-semibold"><?= $status['count'] ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar bg-<?= $status['class'] ?>" role="progressbar" 
                                                 style="width: <?= round(($status['count'] / $total) * 100) ?>%;" 
                                                 aria-valuenow="<?= round(($status['count'] / $total) * 100) ?>" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span class="text-muted small"><?= round(($status['count'] / $total) * 100) ?>%</span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Quick Stats -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-3"><i class="fas fa-chart-simple text-primary me-2"></i>Quick Stats</h5>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <p class="text-muted small mb-1">Total Drivers</p>
                            <h3 class="fw-bold mb-0"><?= $total_drivers ?></h3>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <p class="text-muted small mb-1">Active Drivers</p>
                            <h3 class="fw-bold mb-0"><?= $active_drivers ?></h3>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <p class="text-muted small mb-1">Total Customers</p>
                            <h3 class="fw-bold mb-0"><?= $total_customers ?></h3>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <p class="text-muted small mb-1">Total Packages</p>
                            <h3 class="fw-bold mb-0"><?= $total_orders ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ROW 3: Recent Orders ===== -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-list-ul text-primary me-2"></i>Recent Orders</h5>
                    <a href="packages.php" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
                <?php if ($total_recent > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tracking ID</th>
                                    <th>Sender</th>
                                    <th>Receiver</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_packages as $pkg): ?>
                                <tr>
                                    <td><span class="badge bg-dark bg-opacity-10 text-dark"><?= htmlspecialchars($pkg['tracking_id'] ?? '') ?></span></td>
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
                                        <span class="badge bg-<?= $status_class ?> bg-opacity-10 text-<?= $status_class ?> px-3 py-2">
                                            <?= $status_text ?>
                                        </span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($pkg['created_at'] ?? 'now')) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-3">No orders found</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?php
// 4. Soo gal footer.php (haddii aad leedahay)
// require_once 'footer.php';
?>