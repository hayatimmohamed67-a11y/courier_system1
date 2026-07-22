<?php
/**
 * config.php - Faylka isku xirka Database-ka iyo go'aaminta (settings)
 * Version: 2.0 (Error Handling waa la badiyay)
 */

// ============================================================
// 1. Muuji dhammaan qaladka si aad u aragto waxa dhacaya
// ============================================================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ============================================================
// 2. Waqtiga (Timezone) - Sax waqtiga Soomaaliya
// ============================================================
date_default_timezone_set('Africa/Mogadishu');

// ============================================================
// 3. Xadka Waqtiga (Execution Time) - 30 seconds ku filan
//    Haddii aad doonaysid inuu dheerado, beddel 30 oo ku qor 0
// ============================================================
set_time_limit(30);

// ============================================================
// 4. Macluumaadka Database-ka (Halkan ka beddel sida ku habboon)
// ============================================================
$db_host = '127.0.0.1';      // Isticmaal 127.0.0.1 si looga fogaado IPv6
$db_user = 'root';           // Magaca isticmaale (default waa root)
$db_pass = '';               // Password (haddii aad samaysay, ku qor halkan)
$db_name = 'courier_db';     // Magaca Database-kaaga

// Port-ka MySQL (default waa 3306, haddii aad beddeshay ku qor tan)
$db_port = 3306;

// ============================================================
// 5. Ku xidh Database-ka (Connection)
// ============================================================

// Waxaan isku daynaa inaan ku xidhno 3 sekund gudahood
ini_set('default_socket_timeout', 3);

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

// ============================================================
// 6. Hubi haddii xidhiidhku Sax yahay iyo in kale
// ============================================================
if (!$conn) {
    // Halkan ayaa lagu soo bandhigayaa qaladka si cad, si aad u ogaato sababta
    die("<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px; font-family: Arial;'>
            <h3>⚠️ Qalad xidhiidh Database ah (MySQL)</h3>
            <p><strong>Farriinta qaladka:</strong> " . mysqli_connect_error() . "</p>
            <p><strong>Latalin:</strong><br>
            - Fur XAMPP oo riix <b>Start</b> ee ku xusan <b>MySQL</b>.<br>
            - Hubi in magaca database-ka (<code>$db_name</code>) uu yahay <b>'courier_db'</b> ama beddel sida ku habboon.<br>
            - Haddii password-kaagu uusan eber ahayn, ku qor line-ka <code>\$db_pass</code>.<br>
            - Haddii aad isticmaasho <b>localhost</b>, isku day inaad u beddesho <b>127.0.0.1</b>.
            </p>
          </div>");
    exit; // Jooji barnaamijka haddii aan xidhiidh jirin
}

// ============================================================
// 7. Deji Encoding-ka UTF-8 si aad u qorto Af-Soomaali si fiican
// ============================================================
mysqli_set_charset($conn, "utf8mb4");

// ============================================================
// 8. Furaha Sirdoonka (Site Key) - Haddii aad isticmaasho encryption
// ============================================================
if (!defined('SITE_KEY')) {
    define('SITE_KEY', 'your-secret-key-here');
}
// ============================================================
// 9. Bilow Session-ka (hadii aadan ka bilowdin header.php)
//    Laakiin si aad uga hortagto "headers already sent" oo qalad ah,
//    waxaan ku dari doonaa haddii session-ka uusan hore u bilaawmin.
// ============================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================================
// 10. [Tijaabo] Ku qoro farriin si aad u aragto in config-ku shaqaynayo
//     Haddii aad rabto inaad ka saarto, ka dhig mid aan shaqayn
// ============================================================
// echo "✅ Config.php waa shaqaynaa, connection-ku waa sax!"; 
// exit; // Furo haddii aad rabto inaad tijaabiso

// ============================================================
// Dhammaad
// ============================================================






?>