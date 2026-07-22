<?php
/**
 * register_customer.php - Bogga diiwaangelinta macaamiil cusub (Register Customer)
 * Version: 2.0 (Beautiful UI + PHP 8.2 compatible)
 */

// 1. Magaca bogga
$title = 'Register Customer';

// 2. Soo gal config.php (database connection)
require_once 'config.php';

// 3. Soo gal header.php (sidebar + topbar)
require_once 'header.php';

// ============================================================
// Process form submission
// ============================================================
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_customer'])) {
    // Get form data
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Validate
    if (empty($name)) {
        $error_message = 'Please enter the customer\'s name.';
    } else {
        // Check if email already exists (optional)
        if (!empty($email)) {
            $check_query = mysqli_query($conn, "SELECT id FROM customers WHERE email = '$email'");
            if ($check_query && mysqli_num_rows($check_query) > 0) {
                $error_message = 'This email is already registered.';
            }
        }

        if (empty($error_message)) {
            // Insert into database using prepared statement
            $stmt = mysqli_prepare($conn, "INSERT INTO customers (name, phone, email, address, created_at) VALUES (?, ?, ?, ?, NOW())");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $name, $phone, $email, $address);
                if (mysqli_stmt_execute($stmt)) {
                    $success_message = "Customer <strong>" . htmlspecialchars($name) . "</strong> registered successfully!";
                } else {
                    $error_message = "Database error: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                $error_message = "Failed to prepare the database query.";
            }
        }
    }
}
?>

<!-- ============================================================
CONTENT GA BOGGA (Register Customer)
============================================================ -->
<div class="container-fluid px-0">

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold mb-0"><i class="fas fa-user-plus text-primary me-2"></i>Register Customer</h4>
        <p class="text-muted mb-0">Enter the customer details to add a new customer</p>
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
                        <!-- Customer Details -->
                        <div class="col-12">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-user me-2"></i>Customer Information</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Enter customer name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="text" class="form-control form-control-lg" id="phone" name="phone" placeholder="Enter customer phone">
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Enter customer email">
                        </div>

                        <div class="col-md-6">
                            <label for="address" class="form-label fw-semibold">Address</label>
                            <input type="text" class="form-control form-control-lg" id="address" name="address" placeholder="Enter customer address">
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 mt-3">
                            <button type="submit" name="register_customer" class="btn btn-primary btn-lg w-100 py-3 fw-semibold rounded-4">
                                <i class="fas fa-save me-2"></i> Register Customer
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