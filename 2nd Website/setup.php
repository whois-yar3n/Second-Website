<?php
// Veritabanı kurulum dosyası
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'second_db';

try {
    // MySQL'e bağlan (veritabanı olmadan)
    $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass);
    
    // Veritabanı oluştur
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    // Veritabanını seç
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    
    // Satıcı tablosu oluştur
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
    
    echo "✓ Veritabanı başarıyla kuruldu!<br>";
    echo "✓ Satıcılar tablosu oluşturuldu!<br>";
    echo "<br>Kurulum başarılı. <a href='seller-register.php'>Satıcı kayıt sayfasına git</a>";
    
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>
