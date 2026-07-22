<?php
/**
 * customers.php - Bogga lagu soo bandhigo dhammaan macaamiisha (All Customers)
 * Version: 2.0 (PHP 8.2 compatible - htmlspecialchars with null coalescing)
 */

// 1. Magaca bogga
$title = 'All Customers';

// 2. Soo gal config.php (database connection)
require_once 'config.php';

// 3. Soo gal header.php (sidebar + topbar)
require_once 'header.php';

// ============================================================
// Soo saar dhammaan macaamiisha (Customers)
// ============================================================
$customers = [];
$query = mysqli_query($conn, "SELECT * FROM customers ORDER BY id DESC");

if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $customers[] = $row;
    }
}

// Tirada guud
$total_customers = count($customers);
?>

<!-- ============================================================
CONTENT GA BOGGA (All Customers)
============================================================ -->
<div class="container-fluid px-0">

    <!-- Header + Badhanka "Register New Customer" -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">All Customers</h4>
            <p class="text-muted mb-0">Total: <strong><?= $total_customers ?></strong> customers</p>
        </div>
        <a href="register_customer.php" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i> Register New Customer
        </a>
    </div>

    <!-- ===== Table-ka Macaamiisha ===== -->
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
                            <th>Email</th>
                            <th>Address</th>
                            <th>Registered</th>
                            <th class="text-center pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total_customers > 0): ?>
                            <?php $counter = 1; ?>
                            <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td class="ps-4 fw-semibold text-muted"><?= $counter++ ?></td>
                                <td>
                                    <span class="badge bg-dark bg-opacity-10 text-dark fw-semibold">
                                        #<?= htmlspecialchars($customer['id'] ?? '') ?>
                                    </span>
                                </td>
                                <td class="fw-semibold"><?= htmlspecialchars($customer['name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($customer['phone'] ?? '') ?></td>
                                <td><?= htmlspecialchars($customer['email'] ?? '') ?></td>
                                <td><?= htmlspecialchars($customer['address'] ?? '') ?></td>
                                <td><?= date('d M Y, h:i A', strtotime($customer['created_at'] ?? 'now')) ?></td>
                                <td class="text-center pe-4">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="edit_customer.php?id=<?= $customer['id'] ?? 0 ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_customer.php?id=<?= $customer['id'] ?? 0 ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this customer?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="fas fa-users fa-3x d-block mb-3 opacity-25"></i>
                                    <h5 class="fw-semibold">No customers found</h5>
                                    <p class="mb-0">Click <strong>"Register New Customer"</strong> to add your first customer.</p>
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