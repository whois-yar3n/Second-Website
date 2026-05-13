<?php
require __DIR__ . '/auth.php';

if (is_logged_in()) {
    header('Location: account.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kullaniciadi = trim($_POST['username'] ?? '');
    $sifre = trim($_POST['password'] ?? '');

    if (isset($users[$kullaniciadi]) && $users[$kullaniciadi]['password'] === $sifre) {
        $_SESSION['user'] = [
            'username' => $kullaniciadi,
            'full_name' => $users[$kullaniciadi]['full_name'],
            'email' => $users[$kullaniciadi]['email']
        ];

        header('Location: account.php');
        exit;
    }

    $error = 'Kullanıcı adı veya şifre hatalı.';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oturum Aç</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <h1>Second</h1>
        <p class="tagline">2. el elektronik alım-satım'da yeni devir.</p>
    </header>

    <main class="layout">
        <nav class="side-nav" aria-label="Ana menu">
            <h2>Menu</h2>
            <ul>
                <li><a href="index.html">Anasayfa</a></li>
                <li><a href="products.html">Urunler</a></li>
                <li><a href="phone.html">Telefon</a></li>
                <li><a href="pc.html">Bilgisayar</a></li>
                <li><a href="tablet.html">Tablet</a></li>
                <li><a href="extensions.html">Ek Parcalar</a></li>
                <li><a href="homepieces.html">Ev Parcalari</a></li>
                <li><a href="about.html">Hakkimizda</a></li>
                <li><a href="contact.html">Iletisim</a></li>
                <li><a class="active" href="login.php">Hesabim</a></li>
            </ul>
        </nav>

        <section class="content">
            <header class="content-header">
                <div class="content-header-top">
                    <h2>Oturum Aç</h2>
                </div>
                <p>Hesabına giriş yaparak baktığın cihazları tekrar görebilir, oturumunu yönetebilirsin.</p>
            </header>

            <article class="content-article">
                <?php if ($error !== ''): ?>
                    <div class="message message-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>

                <section class="auth-card">
                    <h3>Giriş Bilgileri</h3>
                    <form class="auth-form" method="post" action="login.php">
                        <label>
                            Kullanıcı adı
                            <input type="text" name="username" placeholder="örnek: yaren" required>
                        </label>
                        <label>
                            Şifre
                            <input type="password" name="password" placeholder="Şifrenizi girin" required>
                        </label>
                        <div class="auth-actions">
                            <button class="btn" type="submit">Giriş Yap</button>
                            <a class="btn" href="index.html">Ana Sayfaya ön</a>
                        </div>
                    </form>
                </section>
            </article>

            <footer class="content-footer">
                <small>Demo hesaplar: Cansu / second123 ve demo / demo123</small>
            </footer>
        </section>

        <aside class="sidebar">
            <h2>Hesap Avantajları</h2>
            <ul>
                <li>Oturum bazlı hesap erişimi</li>
                <li>Çerezlerden cihaz geçmişi görüntüleme</li>
                <li>Tek tıkla çıkış yapma</li>
            </ul>

            <h2>Not</h2>
            <ul>
                <li>Cihaz geçmişin, sayfalarda "İncele" butonuna tıklandıkça kaydedilir.</li>
            </ul>
        </aside>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 Second. Tüm  hakları saklıdır.</p>
    </footer>
</body>
</html>
