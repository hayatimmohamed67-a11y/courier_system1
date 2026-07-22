<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Fetch all data
$total = $conn->query("SELECT COUNT(*) AS count FROM packages")->fetch_assoc()['count'];
$pending = $conn->query("SELECT COUNT(*) AS count FROM packages WHERE status='pending'")->fetch_assoc()['count'];
$transit = $conn->query("SELECT COUNT(*) AS count FROM packages WHERE status='in_transit'")->fetch_assoc()['count'];
$delivered = $conn->query("SELECT COUNT(*) AS count FROM packages WHERE status='delivered'")->fetch_assoc()['count'];
$cancelled = $conn->query("SELECT COUNT(*) AS count FROM packages WHERE status='cancelled'")->fetch_assoc()['count'];

$drivers_count = $conn->query("SELECT COUNT(*) AS count FROM drivers")->fetch_assoc()['count'];
$customers_count = $conn->query("SELECT COUNT(DISTINCT sender_phone) AS count FROM packages")->fetch_assoc()['count'];

// Set headers for PDF download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="CourierPro_Report_' . date('Y-m-d') . '.pdf"');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CourierPro Report</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; background: white; }
        .header { text-align: center; border-bottom: 3px solid #1E3A8A; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #1E3A8A; font-size: 28px; }
        .header p { color: #6b7280; font-size: 14px; }
        .summary { display: flex; gap: 20px; justify-content: center; margin: 25px 0; flex-wrap: wrap; }
        .summary-item { background: #f8fafc; padding: 15px 25px; border-radius: 10px; text-align: center; min-width: 120px; border-left: 4px solid #1E3A8A; }
        .summary-item .num { font-size: 28px; font-weight: 800; }
        .summary-item .label { color: #6b7280; font-size: 13px; }
        .summary-item.delivered { border-left-color: #10B981; }
        .summary-item.pending { border-left-color: #F59E0B; }
        .summary-item.cancelled { border-left-color: #EF4444; }
        .summary-item.transit { border-left-color: #1E3A8A; }
        .info-row { display: flex; gap: 30px; justify-content: center; background: #f8fafc; padding: 12px; border-radius: 10px; margin: 20px 0; }
        h2 { color: #1E3A8A; font-size: 18px; margin: 25px 0 15px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #1E3A8A; color: white; padding: 10px 12px; text-align: left; font-size: 13px; }
        td { padding: 10px 12px; border-bottom: 1px solid #e5e7eb; font-size: 13px; }
        tr:nth-child(even) td { background: #fafbfc; }
        .badge { padding: 3px 12px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; }
        .badge.delivered { background: #d1fae5; color: #065f46; }
        .badge.pending { background: #fef3c7; color: #92400e; }
        .badge.in_transit { background: #dbeafe; color: #1e40af; }
        .badge.cancelled { background: #fee2e2; color: #991b1b; }
        .footer { text-align: center; margin-top: 30px; color: #9ca3af; font-size: 12px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <h1>🚚 CourierPro Report</h1>
        <p>📅 <?= date('F j, Y') ?> | 🕐 <?= date('h:i A') ?></p>
    </div>

    <!-- SUMMARY -->
    <div class="summary">
        <div class="summary-item"><div class="num"><?= $total ?></div><div class="label">📦 Total Orders</div></div>
        <div class="summary-item delivered"><div class="num" style="color:#10B981;"><?= $delivered ?></div><div class="label">✅ Delivered</div></div>
        <div class="summary-item pending"><div class="num" style="color:#F59E0B;"><?= $pending ?></div><div class="label">⏳ Pending</div></div>
        <div class="summary-item transit"><div class="num" style="color:#1E3A8A;"><?= $transit ?></div><div class="label">🚚 In Transit</div></div>
        <div class="summary-item cancelled"><div class="num" style="color:#EF4444;"><?= $cancelled ?></div><div class="label">❌ Cancelled</div></div>
    </div>

    <!-- EXTRA INFO -->
    <div class="info-row">
        <div><strong>👨‍✈️ Drivers:</strong> <?= $drivers_count ?></div>
        <div><strong>👥 Customers:</strong> <?= $customers_count ?></div>
    </div>

    <!-- RECENT ORDERS -->
    <h2>📋 Recent Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Tracking ID</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $recent = $conn->query("SELECT * FROM packages ORDER BY created_at DESC LIMIT 20");
            if ($recent && $recent->num_rows > 0):
                while ($row = $recent->fetch_assoc()):
            ?>
            <tr>
                <td><strong><?= htmlspecialchars($row['tracking_id']) ?></strong></td>
                <td><?= htmlspecialchars($row['sender_name']) ?></td>
                <td><?= htmlspecialchars($row['receiver_name']) ?></td>
                <td><span class="badge <?= $row['status'] ?>"><?= str_replace('_', ' ', $row['status']) ?></span></td>
            </tr>
            <?php endwhile; else: ?>
            <tr><td colspan="4" style="text-align:center; color:#9ca3af;">No orders found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        &copy; <?= date('Y') ?> CourierPro Management System — Built with ❤ in Somalia
    </div>

</body>
</html>