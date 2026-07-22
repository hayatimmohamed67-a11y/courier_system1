<?php
/**
 * register_driver.php - Bogga diiwaangelinta darawal cusub (Register Driver)
 * Version: 2.0 (Beautiful UI + PHP 8.2 compatible)
 */

// 1. Magaca bogga
$title = 'Register Driver';

// 2. Soo gal config.php (database connection)
require_once 'config.php';

// 3. Soo gal header.php (sidebar + topbar)
require_once 'header.php';

// ============================================================
// Process form submission
// ============================================================
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_driver'])) {
    // Get form data
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $vehicle_type = trim($_POST['vehicle_type'] ?? 'Car');
    $status = trim($_POST['status'] ?? 'inactive');

    // Validate
    if (empty($name)) {
        $error_message = 'Please enter the driver\'s name.';
    } else {
        // Insert into database using prepared statement
        $stmt = mysqli_prepare($conn, "INSERT INTO drivers (name, phone, vehicle_type, status, created_at) VALUES (?, ?, ?, ?, NOW())");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $name, $phone, $vehicle_type, $status);
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Driver <strong>" . htmlspecialchars($name) . "</strong> registered successfully!";
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
CONTENT GA BOGGA (Register Driver)
============================================================ -->
<div class="container-fluid px-0">

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold mb-0"><i class="fas fa-user-plus text-primary me-2"></i>Register Driver</h4>
        <p class="text-muted mb-0">Enter the driver details to add a new delivery driver</p>
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
                        <!-- Driver Details -->
                        <div class="col-12">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-truck me-2"></i>Driver Information</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Enter driver name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="text" class="form-control form-control-lg" id="phone" name="phone" placeholder="Enter driver phone">
                        </div>

                        <div class="col-md-6">
                            <label for="vehicle_type" class="form-label fw-semibold">Vehicle Type</label>
                            <select class="form-select form-select-lg" id="vehicle_type" name="vehicle_type">
                                <option value="Car">Car</option>
                                <option value="Van">Van</option>
                                <option value="Motorcycle">Motorcycle</option>
                                <option value="Truck">Truck</option>
                                <option value="Bicycle">Bicycle</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select class="form-select form-select-lg" id="status" name="status">
                                <option value="inactive" selected>Inactive</option>
                                <option value="active">Active</option>
                                <option value="busy">Busy</option>
                                <option value="offline">Offline</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 mt-3">
                            <button type="submit" name="register_driver" class="btn btn-primary btn-lg w-100 py-3 fw-semibold rounded-4">
                                <i class="fas fa-save me-2"></i> Register Driver
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