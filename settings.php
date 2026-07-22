<?php
/**
 * settings.php - Bogga Settings (Settings/Configuration)
 * Version: 3.0 (Beautiful UI with Bootstrap 5 & Dark Mode support)
 */

// 1. Magaca bogga
$title = 'Settings';

// 2. Soo gal config.php (database connection)
require_once 'config.php';

// 3. Soo gal header.php (sidebar + topbar)
require_once 'header.php';

// ============================================================
// Process form submissions (save settings)
// ============================================================
$success_message = '';
$error_message = '';

// Simple settings array (in real app, store in database or file)
$settings = [
    'system_name' => 'CourierPro Management System',
    'company_email' => 'info@courierpro.so',
    'phone_number' => '+252 61 234 5678',
    'currency' => 'SOS (Sh)',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_settings'])) {
        // Here you would save to database or file
        // For demonstration, we just show success message
        $success_message = 'Settings saved successfully!';
        // Update the array (in real app, you'd update database)
        $settings['system_name'] = $_POST['system_name'] ?? $settings['system_name'];
        $settings['company_email'] = $_POST['company_email'] ?? $settings['company_email'];
        $settings['phone_number'] = $_POST['phone_number'] ?? $settings['phone_number'];
        $settings['currency'] = $_POST['currency'] ?? $settings['currency'];
    }

    if (isset($_POST['update_password'])) {
        $username = $_POST['username'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($username) || empty($new_password) || empty($confirm_password)) {
            $error_message = 'Please fill in all password fields.';
        } elseif ($new_password !== $confirm_password) {
            $error_message = 'Passwords do not match.';
        } elseif (strlen($new_password) < 6) {
            $error_message = 'Password must be at least 6 characters.';
        } else {
            // Here you would update the password in database
            $success_message = 'Password updated successfully for user: ' . htmlspecialchars($username);
        }
    }
}
?>

<!-- ============================================================
CONTENT GA BOGGA (Settings)
============================================================ -->
<div class="container-fluid px-0">

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold mb-0"><i class="fas fa-cog text-primary me-2"></i>System Settings</h4>
        <p class="text-muted mb-0">Configure your courier system preferences and account</p>
    </div>

    <!-- Alerts -->
    <?php if ($success_message): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($success_message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($error_message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- ===== COLUMN 1: System Settings ===== -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-sliders-h text-primary me-2"></i> General Settings
                </h5>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="system_name" class="form-label fw-semibold">
                            <i class="fas fa-building text-muted me-1"></i> System Name
                        </label>
                        <input type="text" class="form-control form-control-lg" id="system_name" name="system_name" 
                               value="<?= htmlspecialchars($settings['system_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="company_email" class="form-label fw-semibold">
                            <i class="fas fa-envelope text-muted me-1"></i> Company Email
                        </label>
                        <input type="email" class="form-control form-control-lg" id="company_email" name="company_email" 
                               value="<?= htmlspecialchars($settings['company_email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label fw-semibold">
                            <i class="fas fa-phone text-muted me-1"></i> Phone Number
                        </label>
                        <input type="text" class="form-control form-control-lg" id="phone_number" name="phone_number" 
                               value="<?= htmlspecialchars($settings['phone_number']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="currency" class="form-label fw-semibold">
                            <i class="fas fa-dollar-sign text-muted me-1"></i> Currency
                        </label>
                        <input type="text" class="form-control form-control-lg" id="currency" name="currency" 
                               value="<?= htmlspecialchars($settings['currency']) ?>" required>
                    </div>
                    <button type="submit" name="save_settings" class="btn btn-primary btn-lg w-100 py-3 fw-semibold rounded-4">
                        <i class="fas fa-save me-2"></i> Save Settings
                    </button>
                </form>
            </div>
        </div>

        <!-- ===== COLUMN 2: Account Settings ===== -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-user-lock text-primary me-2"></i> Account Security
                </h5>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">
                            <i class="fas fa-user text-muted me-1"></i> Username
                        </label>
                        <input type="text" class="form-control form-control-lg" id="username" name="username" 
                               value="admin" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label fw-semibold">
                            <i class="fas fa-key text-muted me-1"></i> New Password
                        </label>
                        <input type="password" class="form-control form-control-lg" id="new_password" name="new_password" 
                               placeholder="Enter new password (min 6 chars)">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label fw-semibold">
                            <i class="fas fa-check-circle text-muted me-1"></i> Confirm Password
                        </label>
                        <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" 
                               placeholder="Confirm new password">
                    </div>
                    <button type="submit" name="update_password" class="btn btn-warning btn-lg w-100 py-3 fw-semibold rounded-4">
                        <i class="fas fa-key me-2"></i> Update Password
                    </button>
                </form>
                <div class="mt-3 text-muted small">
                    <i class="fas fa-info-circle me-1"></i> Password must be at least 6 characters.
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Row 2: Extra options (optional) ===== -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1"><i class="fas fa-info-circle text-primary me-2"></i>System Information</h5>
                        <p class="text-muted mb-0">CourierPro Management System v2.0 | PHP 8.2 | MySQL</p>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Running
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
// 4. Soo gal footer.php (haddii aad leedahay)
// require_once 'footer.php';
?>