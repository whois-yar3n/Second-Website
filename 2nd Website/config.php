<?php
// Session başlat
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Veritabanı bağlantısı ve yapılandırma
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'second_db');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    // Veritabanı yoksa otomatik oluştur (kullanıcı ekranda hata görmesin).
    $msg = $e->getMessage();
    $isUnknownDb = (strpos($msg, "Unknown database") !== false) || ((string)$e->getCode() === "1049");

    if ($isUnknownDb) {
        try {
            // DB'siz bağlanıp DB oluştur
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

            $dbNameEscaped = str_replace('`', '', DB_NAME);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbNameEscaped` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            // DB'ye yeniden bağlan
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

            // Tabloyu da otomatik oluştur (setup.php ile aynı amaç)
            $sql = "CREATE TABLE IF NOT EXISTS sellers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                phone VARCHAR(20) NOT NULL,
                password VARCHAR(255) NOT NULL,
                identity_number LONGBLOB NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
        } catch (PDOException $e2) {
            // Kullanıcıya hata mesajını göstermeden güvenli şekilde devam etmek için logla.
            error_log("DB bootstrap hatası: " . $e2->getMessage());
            $pdo = null;
        }
    } else {
        error_log("Veritabanı bağlantı hatası: " . $e->getMessage());
        $pdo = null;
    }
}

// Satıcı oturumu kontrolü
function isSellerLoggedIn() {
    return isset($_SESSION['seller_id']) && !empty($_SESSION['seller_id']);
}

function getSellerInfo($sellerId) {
    global $pdo;
    if (!$pdo) return null;
    $stmt = $pdo->prepare("SELECT id, email, name, phone, created_at FROM sellers WHERE id = ?");
    $stmt->execute([$sellerId]);
    return $stmt->fetch();
}

function logoutSeller() {
    session_unset();
    session_destroy();
}
?>
