<?php
/**
 * index.php - Dashboard-ka ugu weyn (Main Dashboard)
 */

// 1. Magaca bogga
$title = 'Dashboard';

// 2. Soo gal config.php (database connection)
require_once 'config.php';

// 3. Soo gal header.php (sidebar + topbar)
require_once 'header.php';

// ============================================================
// 4. Soo saar xogta (Data) laga soo qaado database-ka
// ============================================================

// --- Tirada guud ee baakidhaha (Total Orders) ---
$total = 0;
$query_total = mysqli_query($conn, "SELECT COUNT(*) as count FROM packages");
if ($query_total) {
    $row = mysqli_fetch_assoc($query_total);
    $total = $row['count'];
}

// --- Tirada la gaarsiiyay (Delivered) ---
$delivered = 0;
$query_delivered = mysqli_query($conn, "SELECT COUNT(*) as count FROM packages WHERE status = 'delivered'");
if ($query_delivered) {
    $row = mysqli_fetch_assoc($query_delivered);
    $delivered = $row['count'];
}

// --- Tirada sugaya (Pending) ---
$pending = 0;
$query_pending = mysqli_query($conn, "SELECT COUNT(*) as count FROM packages WHERE status = 'pending'");
if ($query_pending) {
    $row = mysqli_fetch_assoc($query_pending);
    $pending = $row['count'];
}

// --- Tirada darawallada firfircoon (Active Drivers) ---
$active_drivers = 0;
$query_drivers = mysqli_query($conn, "SELECT COUNT(*) as count FROM drivers WHERE status = 'active'");
if ($query_drivers) {
    $row = mysqli_fetch_assoc($query_drivers);
    $active_drivers = $row['count'];
} else {
    // Haddii table-ka drivers uusan jirin, ku qor tiro macmal ah (ama 0)
    $active_drivers = 3; // Tusaale
}

// --- Baakidhaha ugu dambeeya (Recent Orders) - 5 ugu dambeeya ---
$recent_packages = [];
$query_recent = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC LIMIT 5");
if ($query_recent) {
    while ($row = mysqli_fetch_assoc($query_recent)) {
        $recent_packages[] = $row;
    }
}
?>

<!-- ============================================================
CONTENT GA BOGGA (Dhanka midig ee sidebar ka dambeeya)
============================================================ -->
<div class="container-fluid px-0">

    <!-- ===== ROW 1: 4 Stat Cards (TOTAL ORDERS, DELIVERED, PENDING, ACTIVE DRIVERS) ===== -->
    <div class="row g-4 mb-4">
        <!-- Total Orders -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card p-4 rounded-4 shadow-sm bg-white h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 fw-semibold fs-6">TOTAL ORDERS</p>
                        <h2 class="fw-bold mb-0"><?= $total ?></h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                        <i class="fas fa-box text-primary fs-3"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-success fw-semibold"><i class="fas fa-arrow-up"></i> +12.5%</span>
                    <span class="text-muted ms-2">vs last week</span>
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
                <div class="mt-3">
                    <span class="text-success fw-semibold"><i class="fas fa-arrow-up"></i> +8.2%</span>
                    <span class="text-muted ms-2">vs last week</span>
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
                <div class="mt-3">
                    <span class="text-danger fw-semibold"><i class="fas fa-arrow-down"></i> -3.1%</span>
                    <span class="text-muted ms-2">vs last week</span>
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
                <div class="mt-3">
                    <span class="text-success fw-semibold"><i class="fas fa-arrow-up"></i> +4</span>
                    <span class="text-muted ms-2">this month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ROW 2: Register Package + All Packages ===== -->
    <div class="row g-4">
        <!-- Left: Register Package Form -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3"><i class="fas fa-plus-circle text-primary me-2"></i>Register Package</h5>
                <form action="register_package.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sender Name</label>
                            <input type="text" class="form-control" name="sender_name" placeholder="Sender name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Receiver Name</label>
                            <input type="text" class="form-control" name="receiver_name" placeholder="Receiver name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Receiver Phone</label>
                            <input type="text" class="form-control" name="receiver_phone" placeholder="Phone number">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Weight (kg)</label>
                            <input type="number" step="0.1" class="form-control" name="weight" placeholder="0.0">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Receiver Address</label>
                            <input type="text" class="form-control" name="receiver_address" placeholder="Delivery address">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Package Description</label>
                            <textarea class="form-control" name="package_description" rows="2" placeholder="Describe the package"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                <i class="fas fa-save me-2"></i> Register Package
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: All Packages Table -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-boxes text-primary me-2"></i>All Packages (<?= $total ?>)</h5>
                    <a href="packages.php" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tracking ID</th>
                                <th>Receiver</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($recent_packages) > 0): ?>
                                <?php foreach ($recent_packages as $pkg): ?>
                                <tr>
                                    <td><span class="badge bg-dark"><?= htmlspecialchars($pkg['tracking_id']) ?></span></td>
                                    <td><?= htmlspecialchars($pkg['receiver_name']) ?></td>
                                    <td>
                                        <?php if ($pkg['status'] == 'delivered'): ?>
                                            <span class="badge bg-success">Delivered</span>
                                        <?php elseif ($pkg['status'] == 'pending'): ?>
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= $pkg['status'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No packages found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ROW 3: Recent Orders + Live Tracking ===== -->
    <div class="row g-4 mt-2">
        <!-- Recent Orders List -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-list-ul text-primary me-2"></i>Recent Orders</h5>
                    <a href="orders.php" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
                <?php if (count($recent_packages) > 0): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($recent_packages as $pkg): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-semibold"><?= htmlspecialchars($pkg['sender_name']) ?></span>
                                <span class="text-muted mx-2">→</span>
                                <span><?= htmlspecialchars($pkg['receiver_name']) ?></span>
                                <span class="badge bg-secondary ms-2"><?= htmlspecialchars($pkg['tracking_id']) ?></span>
                            </div>
                            <span class="text-muted small"><?= date('d M Y', strtotime($pkg['created_at'])) ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted text-center py-3">No orders yet</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Live Tracking / Map -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-3"><i class="fas fa-map-marker-alt text-danger me-2"></i>Live Tracking</h5>
                <div class="bg-light rounded-4 p-4 text-center" style="min-height: 150px; background: linear-gradient(135deg, #eef2ff, #e0e7ff) !important;">
                    <i class="fas fa-truck text-primary fs-1 mb-3 d-block"></i>
                    <h3 class="fw-bold"><?= $active_drivers ?></h3>
                    <p class="text-muted mb-0">drivers active now</p>
                    <span class="badge bg-success mt-2"><i class="fas fa-circle me-1"></i> Live</span>
                </div>
                <div class="mt-3 text-center">
                    <button class="btn btn-outline-primary btn-sm w-100">View Full Map</button>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
// 5. Soo gal footer.php (haddii aad leedahay)
// require_once 'footer.php';
?>