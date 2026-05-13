<?php
require_once 'config.php';

// Zaten giriş yapılmış ise panoyu aç
if (isSellerLoggedIn()) {
    header('Location: seller-dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($pdo) || !$pdo) {
        $error = 'Şu an giriş işlemi tamamlanamıyor. Daha sonra tekrar deneyin.';
    } else {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = 'E-posta ve şifre gereklidir!';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, password, name FROM sellers WHERE email = ?");
            $stmt->execute([$email]);
            $seller = $stmt->fetch();

            if ($seller && password_verify($password, $seller['password'])) {
                $_SESSION['seller_id'] = $seller['id'];
                $_SESSION['seller_name'] = $seller['name'];
                header('Location: seller-dashboard.php');
                exit;
            } else {
                $error = 'E-posta veya şifre hatalı!';
            }
        } catch (Exception $e) {
            $error = 'Giriş işlemi sırasında bir hata oluştu!';
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
    <title>Satıcı Girişi - Second</title>
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
                <li><a class="active" href="seller-login.php">Satıcı Girişi</a></li>
                <li><a href="seller-register.php">Satıcı Kayıt</a></li>
                <li><a href="contact.html">İletişim</a></li>
            </ul>
        </nav>

        <section class="content">
            <header class="content-header">
                <h2>Satıcı Girişi</h2>
                <p>Satıcı panelınıza giriş yapın.</p>
            </header>

            <article class="content-article">
                <?php if ($error): ?>
                    <div class="message message-error">
                        <strong>Hata:</strong> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <div class="auth-card">
                    <h3>Giriş Formu</h3>
                    <form class="auth-form" method="POST">
                        <label>
                            E-posta
                            <input type="email" name="email" required placeholder="E-posta adresiniz">
                        </label>

                        <label>
                            Şifre
                            <input type="password" name="password" required placeholder="Şifreniz">
                        </label>

                        <div class="auth-actions">
                            <button type="submit" class="btn">Giriş Yap</button>
                            <a href="seller-register.php" class="btn-link">Kayıt olmak istiyorum</a>
                        </div>
                    </form>
                </div>
            </article>
        </section>

        <aside class="sidebar">
            <h2>İletişim</h2>
            <ul>
                <li>Email: <a href="mailto:seller@second.com">seller@second.com</a></li>
                <li>Telefon: +90 223 123 45 67</li>
            </ul>

            <h2>Hesap</h2>
            <ul>
                <li><a href="index.html">Ana Sayfa</a></li>
                <li><a href="seller-register.php">Kayıt Ol</a></li>
            </ul>
        </aside>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 Second. Tüm hakları saklıdır.</p>
    </footer>
</body>
</html>
