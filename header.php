<?php
/**
 * header.php - Header-ka Dashboard-ka (Sidebar + Topbar)
 * Waa in lagu soo galaa index.php ama bog kasta oo dashboard ah
 */

// Hubi in config.php la soo galay
if (!isset($conn)) {
    require_once __DIR__ . '/config.php';
}

// Haddii aan la soo gelin, deji $title
if (!isset($title)) {
    $title = 'Dashboard';
}

// ============================================================
// Tirada guud ee baakidhaha (loogu talagalay Badge-ka Sidebar)
// ============================================================
$total_packages = 0;
$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'packages'");
if ($check_table && mysqli_num_rows($check_table) > 0) {
    $count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM packages");
    if ($count_query) {
        $row = mysqli_fetch_assoc($count_query);
        $total_packages = $row['total'];
    }
}
?>
<!DOCTYPE html>
<html lang="so">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourierPro - <?= htmlspecialchars($title) ?></title>

    <!-- ============================================================
    CSS & FONTS (Bootstrap, FontAwesome, Inter, Custom)
    ============================================================ -->

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 (Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Google Font (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- ============================================================
    CUSTOM CSS (Sidebar, Topbar, Dark Mode, Stat Cards)
    ============================================================ -->
    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6fa;
            color: #1a1a2e;
            display: flex;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* ===== SIDEBAR (Bidix) ===== */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            padding: 25px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            transition: all 0.3s;
        }
        .sidebar .logo {
            font-size: 24px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar .logo i {
            color: #3b82f6;
            font-size: 28px;
        }
        .sidebar .logo span {
            color: #3b82f6;
        }
        .sidebar .nav {
            list-style: none;
            flex: 1;
            padding: 0;
        }
        .sidebar .nav li {
            margin-bottom: 6px;
        }
        .sidebar .nav li a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.2s;
            font-size: 15px;
        }
        .sidebar .nav li a i {
            width: 20px;
            font-size: 18px;
            text-align: center;
        }
        .sidebar .nav li a:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }
        .sidebar .nav li a.active {
            background: #3b82f6;
            color: #fff;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }
        .sidebar .nav li a .badge-count {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            font-size: 11px;
            padding: 2px 10px;
            border-radius: 50px;
        }
        .sidebar .user-info {
            border-top: 1px solid rgba(255,255,255,0.06);
            padding-top: 20px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar .user-info img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 2px solid #3b82f6;
            object-fit: cover;
        }
        .sidebar .user-info .name {
            color: #fff;
            font-weight: 600;
            font-size: 14px;
        }
        .sidebar .user-info .role {
            color: #94a3b8;
            font-size: 12px;
        }

        /* ===== MAIN CONTENT (Dhanka midig) ===== */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 0 30px 30px 30px;
            width: calc(100% - 260px);
        }

        /* ===== TOPBAR (Sare) ===== */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 25px;
            background: transparent;
        }
        .topbar .page-title h1 {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
        }
        .topbar .page-title p {
            color: #64748b;
            font-size: 14px;
            margin-top: 2px;
        }
        .topbar .actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .topbar .actions .icon-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: none;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            color: #1e293b;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: 0.2s;
        }
        .topbar .actions .icon-btn:hover {
            background: #f1f5f9;
        }
        .topbar .actions .icon-btn .dot {
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            position: absolute;
            top: 8px;
            right: 8px;
        }
        .topbar .profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            padding: 6px 16px 6px 10px;
            border-radius: 50px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .topbar .profile img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            object-fit: cover;
        }
        .topbar .profile .info .name {
            font-weight: 600;
            font-size: 14px;
            color: #0f172a;
        }
        .topbar .profile .info .role {
            font-size: 12px;
            color: #64748b;
        }

        /* ===== DARK MODE TOGGLE ===== */
        .dark-toggle-btn {
            background: #1e293b;
            color: #f1f5f9;
            border: none;
            border-radius: 50px;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            font-weight: 500;
        }
        .dark-toggle-btn i {
            margin-right: 6px;
        }

        /* ===== DARK MODE STYLES ===== */
        body.dark-mode {
            background: #0f0f1a;
            color: #e5e7eb;
        }
        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #0a0a1a 0%, #1a1a3a 100%);
        }
        body.dark-mode .topbar {
            border-bottom-color: #1a1a3a;
        }
        body.dark-mode .topbar .page-title h1 {
            color: #f1f5f9;
        }
        body.dark-mode .topbar .page-title p {
            color: #94a3b8;
        }
        body.dark-mode .topbar .actions .icon-btn {
            background: #1a1a2e;
            color: #e5e7eb;
            box-shadow: none;
        }
        body.dark-mode .topbar .profile {
            background: #1a1a2e;
            box-shadow: none;
        }
        body.dark-mode .topbar .profile .info .name {
            color: #f1f5f9;
        }
        body.dark-mode .topbar .profile .info .role {
            color: #94a3b8;
        }
        body.dark-mode .dark-toggle-btn {
            background: #f1f5f9;
            color: #0f0f1a;
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            transition: transform 0.2s, box-shadow 0.2s;
            border: none !important;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08) !important;
        }
        body.dark-mode .stat-card {
            background: #1a1a2e !important;
            color: #e5e7eb;
        }
        body.dark-mode .stat-card .text-muted {
            color: #94a3b8 !important;
        }
        body.dark-mode .card {
            background: #1a1a2e !important;
            color: #e5e7eb;
        }
        body.dark-mode .table-light {
            background: #0f0f2a !important;
        }
        body.dark-mode .table-light th {
            color: #e5e7eb;
        }
        body.dark-mode .list-group-item {
            background: #1a1a2e;
            color: #e5e7eb;
            border-color: #0f0f2a;
        }
        body.dark-mode .bg-light {
            background: #0f0f2a !important;
        }
        body.dark-mode .form-control {
            background: #0f0f1a;
            color: #e5e7eb;
            border-color: #333;
        }
        body.dark-mode .form-control:focus {
            background: #0f0f1a;
            color: #e5e7eb;
            border-color: #3b82f6;
        }
        body.dark-mode .form-label {
            color: #e5e7eb;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                padding: 15px 10px;
            }
            .sidebar .logo span,
            .sidebar .nav li a span,
            .sidebar .user-info .info,
            .sidebar .nav li a .badge-count {
                display: none;
            }
            .sidebar .nav li a {
                justify-content: center;
                padding: 12px;
            }
            .sidebar .logo {
                justify-content: center;
                font-size: 20px;
            }
            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
                padding: 0 15px 15px 15px;
            }
            .topbar .page-title p {
                display: none;
            }
        }
    </style>

    <!-- ============================================================
    JAVASCRIPT (Dark Mode)
    ============================================================ -->
    <script>
        // Dark mode haddii hore loo kaydiyay localStorage
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
            }
        });

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
            } else {
                localStorage.setItem('darkMode', 'disabled');
            }
        }
    </script>
</head>
<body>

<!-- ============================================================
SIDEBAR (Bidix)
============================================================ -->
<aside class="sidebar">
    <div class="logo">
        <i class="fas fa-box"></i>
        Courier<span>Pro</span>
    </div>
    <ul class="nav">
        <li>
            <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                <i class="fas fa-th-large"></i> <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="packages.php" class="<?= basename($_SERVER['PHP_SELF']) == 'packages.php' ? 'active' : '' ?>">
                <i class="fas fa-boxes"></i> <span>All Packages</span>
                <span class="badge-count"><?= $total_packages ?></span>
            </a>
        </li>
        <li>
            <a href="drivers.php" class="<?= basename($_SERVER['PHP_SELF']) == 'drivers.php' ? 'active' : '' ?>">
                <i class="fas fa-truck"></i> <span>Drivers</span>
            </a>
        </li>
        <li>
            <a href="customers.php" class="<?= basename($_SERVER['PHP_SELF']) == 'customers.php' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> <span>Customers</span>
            </a>
        </li>
        <li>
            <a href="tracking.php" class="<?= basename($_SERVER['PHP_SELF']) == 'tracking.php' ? 'active' : '' ?>">
                <i class="fas fa-search"></i> <span>Tracking</span>
            </a>
        </li>
        <li>
            <a href="reports.php" class="<?= basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : '' ?>">
                <i class="fas fa-chart-bar"></i> <span>Reports</span>
            </a>
        </li>
        <li>
            <a href="settings.php" class="<?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>">
                <i class="fas fa-cog"></i> <span>Settings</span>
            </a>
        </li>
    </ul>
    <div class="user-info">
        <img src="https://i.pravatar.cc/100?img=10" alt="Hayat">
        <div class="info">
            <div class="name">Hayat</div>
            <div class="role">Administrator</div>
        </div>
    </div>
</aside>

<!-- ============================================================
MAIN CONTENT (Dhanka Midig) - Halkaan waxa soo gala index.php
============================================================ -->
<main class="main-content">

    <!-- ===== TOPBAR (Sare) ===== -->
    <div class="topbar">
        <div class="page-title">
            <h1><?= htmlspecialchars($title) ?></h1>
            <p><?= date('l, F j, Y') ?></p>
        </div>
        <div class="actions">
            <!-- Dark Mode Button -->
            <button class="icon-btn" onclick="toggleDarkMode()" title="Dark Mode">
                <i class="fas fa-moon"></i>
            </button>
            <!-- Notification Button -->
            <button class="icon-btn" title="Notifications">
                <i class="fas fa-bell"></i>
                <span class="dot"></span>
            </button>
            <!-- Profile -->
            <div class="profile">
                <img src="https://i.pravatar.cc/100?img=10" alt="Hayat">
                <div class="info">
                    <div class="name">Hayat</div>
                    <div class="role">Administrator</div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===== TOPBAR DHAMAAD ===== -->

    <!-- ============================================================
    HALKAN WAXA KA BILAABMAYA CONTENT-GA BOGGA (index.php wuxuu ku dari doonaa hoose)
    ============================================================ -->