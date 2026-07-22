<?php
/**
 * register_package.php - Bogga diiwaangelinta baakidhaha (Register Package)
 * Version: 2.0 (Beautiful UI + PHP 8.2 compatible)
 */

// 1. Magaca bogga
$title = 'Register Package';

// 2. Soo gal config.php (database connection)
require_once 'config.php';

// 3. Soo gal header.php (sidebar + topbar)
require_once 'header.php';

// ============================================================
// Process form submission
// ============================================================
$success_message = '';
$error_message = '';
$tracking_id = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_package'])) {
    // Get form data
    $sender_name = trim($_POST['sender_name'] ?? '');
    $receiver_name = trim($_POST['receiver_name'] ?? '');
    $receiver_phone = trim($_POST['receiver_phone'] ?? '');
    $receiver_address = trim($_POST['receiver_address'] ?? '');
    $package_description = trim($_POST['package_description'] ?? '');
    $weight = trim($_POST['weight'] ?? '');

    // Validate
    if (empty($sender_name) || empty($receiver_name)) {
        $error_message = 'Please fill in at least Sender Name and Receiver Name.';
    } else {
        // Generate unique Tracking ID
        do {
            $tracking_id = 'PKG-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $check_query = mysqli_query($conn, "SELECT id FROM packages WHERE tracking_id = '$tracking_id'");
        } while ($check_query && mysqli_num_rows($check_query) > 0);

        // Insert into database using prepared statement
        $stmt = mysqli_prepare($conn, "INSERT INTO packages (tracking_id, sender_name, receiver_name, receiver_phone, receiver_address, package_description, weight, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssss", $tracking_id, $sender_name, $receiver_name, $receiver_phone, $receiver_address, $package_description, $weight);
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Package registered successfully! Tracking ID: <strong>" . htmlspecialchars($tracking_id) . "</strong>";
            } else {
                $error_message = "Database error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error_message = "Failed to prepare the database query.";
        }
    }
}
?>

<!-- ============================================================
CONTENT GA BOGGA (Register Package)
============================================================ -->
<div class="container-fluid px-0">

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold mb-0"><i class="fas fa-plus-circle text-primary me-2"></i>Register Package</h4>
        <p class="text-muted mb-0">Enter the package details to register a new shipment</p>
    </div>

    <!-- Alerts -->
    <?php if ($success_message): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fs-3 me-3 text-success"></i>
                <div><?= $success_message ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle fs-3 me-3 text-danger"></i>
                <div><?= htmlspecialchars($error_message) ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- ===== Main Form Card ===== -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <form method="POST" action="">
                    <div class="row g-4">
                        <!-- Sender Section -->
                        <div class="col-12">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-user me-2"></i>Sender Information</h6>
                        </div>
                        <div class="col-md-6">
                            <label for="sender_name" class="form-label fw-semibold">Sender Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="sender_name" name="sender_name" placeholder="Enter sender name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sender_phone" class="form-label fw-semibold">Sender Phone</label>
                            <input type="text" class="form-control form-control-lg" id="sender_phone" name="sender_phone" placeholder="Enter sender phone">
                        </div>

                        <!-- Receiver Section -->
                        <div class="col-12 mt-3">
                            <h6 class="fw-bold text-success mb-3"><i class="fas fa-user-check me-2"></i>Receiver Information</h6>
                        </div>
                        <div class="col-md-6">
                            <label for="receiver_name" class="form-label fw-semibold">Receiver Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="receiver_name" name="receiver_name" placeholder="Enter receiver name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="receiver_phone" class="form-label fw-semibold">Receiver Phone</label>
                            <input type="text" class="form-control form-control-lg" id="receiver_phone" name="receiver_phone" placeholder="Enter receiver phone">
                        </div>
                        <div class="col-12">
                            <label for="receiver_address" class="form-label fw-semibold">Receiver Address</label>
                            <input type="text" class="form-control form-control-lg" id="receiver_address" name="receiver_address" placeholder="Enter delivery address">
                        </div>

                        <!-- Package Details -->
                        <div class="col-12 mt-3">
                            <h6 class="fw-bold text-warning mb-3"><i class="fas fa-box me-2"></i>Package Details</h6>
                        </div>
                        <div class="col-12">
                            <label for="package_description" class="form-label fw-semibold">Package Description</label>
                            <textarea class="form-control form-control-lg" id="package_description" name="package_description" rows="3" placeholder="Describe the package contents"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="weight" class="form-label fw-semibold">Weight (kg)</label>
                            <input type="number" step="0.01" class="form-control form-control-lg" id="weight" name="weight" placeholder="0.00">
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select class="form-select form-select-lg" id="status" name="status">
                                <option value="pending" selected>Pending</option>
                                <option value="in_transit">In Transit</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tracking ID</label>
                            <div class="bg-light rounded-3 p-3 text-center text-muted">
                                <i class="fas fa-hashtag me-1"></i> Will be generated automatically
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 mt-3">
                            <button type="submit" name="register_package" class="btn btn-primary btn-lg w-100 py-3 fw-semibold rounded-4">
                                <i class="fas fa-save me-2"></i> Register Package
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php
// 4. Soo gal footer.php (haddii aad leedahay)
// require_once 'footer.php';
?>