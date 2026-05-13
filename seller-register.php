<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($pdo) || !$pdo) {
        $error = 'Şu an kayıt işlemi tamamlanamıyor (veritabanı hazır değil). Lütfen daha sonra tekrar deneyin.';
    } else {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    $identity_number = trim($_POST['identity_number'] ?? '');

    // Validasyon
    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($identity_number)) {
        $error = 'Tüm alanları doldurunuz!';
    } elseif (strlen($password) < 6) {
        $error = 'Şifre en az 6 karakter olmalıdır!';
    } elseif ($password !== $confirm_password) {
        $error = 'Şifreler eşleşmiyor!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Geçerli bir e-posta adresi girin!';
    } elseif (strlen($identity_number) !== 11 || !ctype_digit($identity_number)) {
        $error = 'Kimlik numarası 11 haneli sayı olmalıdır!';
    } else {
        // E-posta zaten kayıtlı mı kontrolü
        $check_stmt = $pdo->prepare("SELECT id FROM sellers WHERE email = ?");
        $check_stmt->execute([$email]);

        if ($check_stmt->fetch()) {
            $error = 'Bu e-posta adresi zaten kayıtlı!';
        } else {
            try {
                // Şifre ve kimlik numarasını şifrele
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                // Kimlik numarasını şifrele (openssl_encrypt ile)
                $encrypted_id = openssl_encrypt(
                    $identity_number,
                    'AES-256-CBC',
                    hash('sha256', 'second_secret_key_2026', true),
                    0,
                    hash('md5', 'second_iv_2026', true)
                );

                $insert_stmt = $pdo->prepare(
                    "INSERT INTO sellers (name, email, phone, password, identity_number, created_at) 
                     VALUES (?, ?, ?, ?, ?, NOW())"
                );

                if ($insert_stmt->execute([$name, $email, $phone, $hashed_password, $encrypted_id])) {
                    $success = 'Kayıt başarılı! Lütfen giriş yapın.';
                    header('refresh:2;url=seller-login.php');
                } else {
                    $error = 'Kayıt işlemi başarısız!';
                }
            } catch (Exception $e) {
                $error = 'Bir hata oluştu: ' . $e->getMessage();
            }
        }
    }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satıcı Kayıt - Second</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <h1>Second</h1>
        <p class="tagline">2. el elektronik alım-satım'da yeni devir.</p>
    </header>

    <main class="layout">
        <nav class="side-nav" aria-label="Ana menü">
            <h2>Menü</h2>
            <ul>
                <li><a href="index.html">Anasayfa</a></li>
                <li><a href="products.html">Ürünler</a></li>
                <li><a href="about.html">Hakkımızda</a></li>
                <li><strong style="color: #1e3a8a; margin-top: 10px;">Satıcı İşlemleri</strong></li>
                <li><a href="seller-login.php">Satıcı Girişi</a></li>
                <li><a class="active" href="seller-register.php">Satıcı Kayıt</a></li>
                <li><a href="contact.html">İletişim</a></li>
            </ul>
        </nav>

        <section class="content">
            <header class="content-header">
                <h2>Satıcı Kaydı</h2>
                <p>Second ailesine katılmak için kayıt olun.</p>
            </header>

            <article class="content-article">
                <?php if ($error): ?>
                    <div class="message message-error">
                        <strong>Hata:</strong> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="message message-success">
                        <strong>Başarı:</strong> <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <div class="auth-card">
                    <h3>Kayıt Formu</h3>
                    <form class="auth-form" method="POST">
                        <label>
                            Ad Soyad
                            <input type="text" name="name" required placeholder="Adınız ve soyadınız">
                        </label>

                        <label>
                            E-posta
                            <input type="email" name="email" required placeholder="E-posta adresiniz">
                        </label>

                        <label>
                            Telefon
                            <input type="tel" name="phone" required placeholder="Telefon numaranız">
                        </label>

                        <label>
                            Kimlik Numarası
                            <input type="text" name="identity_number" required placeholder="11 haneli kimlik numaranız" maxlength="11" pattern="[0-9]{11}">
                            <small class="note-small">Kimlik numarası güvenli şekilde şifrelenip saklı tutulur ve 3. parti uygulamalarla paylaşılmaz.</small>
                        </label>

                        <label>
                            Şifre
                            <input type="password" name="password" required placeholder="En az 6 karakter">
                        </label>

                        <label>
                            Şifreyi Onayla
                            <input type="password" name="confirm_password" required placeholder="Şifreyi tekrar girin">
                        </label>

                        <div class="auth-actions">
                            <button type="submit" class="btn">Kayıt Ol</button>
                            <a href="seller-login.php" class="btn-link">Zaten kayıtlı mısınız?</a>
                        </div>
                    </form>
                </div>

                <div class="info-box" style="margin-top: 20px;">
                    <h4>Güvenlik Notası</h4>
                    <p>Kimlik numaranız:</p>
                    <ul>
                        <li>Güvenli şekilde şifrelenip veritabanında saklanır</li>
                        <li>Sadece hesap doğrulama için kullanılır</li>
                        <li>3. parti uygulamalar ile hiçbir zaman paylaşılmaz</li>
                        <li>İçeriği sadece sistem yöneticileri görebilir</li>
                    </ul>
                </div>
            </article>
        </section>

        <aside class="sidebar">
            <h2>İletişim</h2>
            <ul>
                <li>Email: <a href="mailto:seller@second.com">seller@second.com</a></li>
                <li>Telefon: +90 223 123 45 67</li>
            </ul>

            <h2>Bize Katılın</h2>
            <ul>
                <li><a href="index.html">Ana Sayfa</a></li>
                <li><a href="seller-login.php">Giriş Yap</a></li>
            </ul>
        </aside>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 Second. Tüm hakları saklıdır.</p>
    </footer>
</body>
</html>
