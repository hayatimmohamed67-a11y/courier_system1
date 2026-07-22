<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

include 'header.php';

// Handle new package registration
$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $tracking_id = 'TRK-' . strtoupper(uniqid());
    $sender_name = $_POST['sender_name'];
    $sender_phone = $_POST['sender_phone'];
    $receiver_name = $_POST['receiver_name'];
    $receiver_phone = $_POST['receiver_phone'];
    $receiver_address = $_POST['receiver_address'];
    $package_description = $_POST['package_description'];
    $weight = $_POST['weight'] ?? 0;

    $stmt = $conn->prepare("INSERT INTO packages (tracking_id, sender_name, sender_phone, receiver_name, receiver_phone, receiver_address, package_description, weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssd", $tracking_id, $sender_name, $sender_phone, $receiver_name, $receiver_phone, $receiver_address, $package_description, $weight);
    
    if ($stmt->execute()) {
        $success = "✅ Package registered successfully! Tracking ID: <strong>$tracking_id</strong>";
    } else {
        $error = "❌ Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch recent orders (5 latest)
$recent = $conn->query("SELECT * FROM packages ORDER BY created_at DESC LIMIT 5");
$packages = $conn->query("SELECT * FROM packages ORDER BY created_at DESC LIMIT 10");
?>

<!-- ===== STATS ===== -->
<div class="stats">
    <div class="stat-card">
        <i class="fas fa-box stat-icon"></i>
        <div class="label">Total Orders</div>
        <div class="value"><?= $total ?></div>
        <div class="change up"><i class="fas fa-arrow-up"></i> +12.5%</div>
    </div>
    <div class="stat-card">
        <i class="fas fa-check-circle stat-icon"></i>
        <div class="label">Delivered</div>
        <div class="value" style="color:#10B981;"><?= $delivered ?></div>
        <div class="change up"><i class="fas fa-arrow-up"></i> +8.2%</div>
    </div>
    <div class="stat-card">
        <i class="fas fa-clock stat-icon"></i>
        <div class="label">Pending</div>
        <div class="value" style="color:#F59E0B;"><?= $pending ?></div>
        <div class="change down"><i class="fas fa-arrow-down"></i> -3.1%</div>
    </div>
    <div class="stat-card">
        <i class="fas fa-user stat-icon"></i>
        <div class="label">Active Drivers</div>
        <div class="value" style="color:#1E3A8A;">36</div>
        <div class="change up"><i class="fas fa-arrow-up"></i> +4</div>
    </div>
</div>

<!-- ===== ROW 1: FORM + TABLE ===== -->
<div class="row">
    <!-- REGISTER FORM -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-plus-circle"></i> Register Package</h3>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <input type="text" name="sender_name" placeholder="Sender Name" required>
            <input type="text" name="sender_phone" placeholder="Sender Phone" required>
            <input type="text" name="receiver_name" placeholder="Receiver Name" required>
            <input type="text" name="receiver_phone" placeholder="Receiver Phone" required>
            <input type="text" name="receiver_address" placeholder="Receiver Address" required>
            <input type="text" name="package_description" placeholder="Package Description">
            <input type="number" name="weight" placeholder="Weight (kg)" step="0.01" min="0" required>
            <button type="submit" name="register" class="btn btn-block"><i class="fas fa-save"></i> Register</button>
        </form>
    </div>

    <!-- ALL PACKAGES TABLE -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-list"></i> All Packages</h3>
            <span style="font-size:13px; color:#6b7280;">Total: <?= $total ?></span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Tracking ID</th><th>Receiver</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php if ($packages && $packages->num_rows > 0): ?>
                        <?php while ($row = $packages->fetch_assoc()): ?>
                        <tr>
                            <td><span class="tracking-id"><?= htmlspecialchars($row['tracking_id']) ?></span></td>
                            <td>
                                <strong><?= htmlspecialchars($row['receiver_name']) ?></strong><br>
                                <span style="font-size:12px; color:#6b7280;"><?= htmlspecialchars($row['receiver_address']) ?></span>
                            </td>
                            <td><span class="badge <?= $row['status'] ?>"><?= str_replace('_', ' ', $row['status']) ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="empty"><i class="fas fa-box-open"></i> No packages</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ===== ROW 2: RECENT ORDERS + MAP ===== -->
<div class="row">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-clock-rotate-left"></i> Recent Orders</h3>
            <a href="orders.php">View All →</a>
        </div>
        <?php if ($recent && $recent->num_rows > 0): ?>
            <?php while ($row = $recent->fetch_assoc()): ?>
            <div class="order-item">
                <div class="info">
                    <span class="name">#<?= substr($row['tracking_id'], -6) ?> - <?= htmlspecialchars($row['sender_name']) ?></span>
                    <span class="location"><i class="fas fa-location-dot"></i> <?= htmlspecialchars($row['receiver_address']) ?></span>
                </div>
                <span class="badge <?= $row['status'] ?>"><?= str_replace('_', ' ', $row['status']) ?></span>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty"><i class="fas fa-box-open"></i> No orders yet</div>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-map"></i> Live Tracking</h3>
        </div>
        <div class="map-placeholder">
            <i class="fas fa-location-dot"></i>
            <span>3 drivers active now</span>
            <span class="small"><i class="fas fa-route"></i> 12 deliveries in progress</span>
        </div>
        <div style="margin-top:16px;">
            <h4 style="font-size:14px; color:#6b7280; margin-bottom:10px;"><i class="fas fa-users"></i> Active Drivers</h4>
            <div class="driver-list">
                <div class="driver-item">
                    <div class="left">
                        <div class="avatar">A</div>
                        <div class="info">
                            <div class="dname">Ali Hassan</div>
                            <div class="dloc"><i class="fas fa-location-dot"></i> KM4</div>
                        </div>
                    </div>
                    <span class="status-dot available"></span>
                </div>
                <div class="driver-item">
                    <div class="left">
                        <div class="avatar">H</div>
                        <div class="info">
                            <div class="dname">Hassan Omar</div>
                            <div class="dloc"><i class="fas fa-location-dot"></i> Airport</div>
                        </div>
                    </div>
                    <span class="status-dot busy"></span>
                </div>
                <div class="driver-item">
                    <div class="left">
                        <div class="avatar">O</div>
                        <div class="info">
                            <div class="dname">Omar Yusuf</div>
                            <div class="dloc"><i class="fas fa-location-dot"></i> Seaport</div>
                        </div>
                    </div>
                    <span class="status-dot available"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== BANNER ===== -->
<div class="banner">
    <div class="text">
        <h2><i class="fas fa-truck"></i> Samee Delivery degdeg ah!</h2>
        <p>Maanta waxaad leedahay <strong><?= $pending ?></strong> dalab oo sugaya.</p>
    </div>
    <div style="display:flex; align-items:center; gap:20px;">
        <i class="fas fa-truck-fast banner-icon"></i>
        <button class="btn-banner" onclick="document.querySelector('form').scrollIntoView({behavior:'smooth'})">
            <i class="fas fa-plus"></i> New Order
        </button>
    </div>
</div>

<?php include 'footer.php'; ?>