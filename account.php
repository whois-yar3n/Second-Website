<?php
require __DIR__ . '/auth.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$kullanici = current_user();
$tarih = viewed_devices();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hesabım</title>
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
                <li><a href="products.html">Ürünler</a></li>
                <li><a href="phone.html">Telefon</a></li>
                <li><a href="pc.html">Bilgisayar</a></li>
                <li><a href="tablet.html">Tablet</a></li>
                <li><a href="extensions.html">Ek Parçalar</a></li>
                <li><a href="homepieces.html">Ev Parçaları</a></li>
                <li><a href="about.html">Hakkımızda</a></li>
                <li><a href="contact.html">İletişim</a></li>
                <li><a class="active" href="account.php">Hesabım</a></li>
            </ul>
        </nav>

        <section class="content">
            <header class="content-header">
                <div class="content-header-top">
                    <h2>Hesabım</h2>
                </div>
                <p>Oturum bilgilerini ve önceki gezinmelerinde incelediğin cihazları bu sayfada görebilirsin.</p>
            </header>

            <article class="content-article">
                <section class="account-card">
                    <h3>Hesap Bilgileri</h3>
                    <p><strong>Ad Soyad:</strong> <?php echo htmlspecialchars($kullanici['full_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Kullanıcı Adı:</strong> <?php echo htmlspecialchars($kullanici['username'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>E-posta:</strong> <?php echo htmlspecialchars($kullanici['email'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <div class="auth-actions">
                        <a class="btn" href="logout.php">Çıkış Yap</a>
                    </div>
                </section>

                <section class="tarih-card">
                    <h3>Önceki Oturumlarda Bakılan Cihazlar</h3>
                    <?php if (count($tarih) > 0): ?>
                        <ol class="tarih-list">
                            <?php foreach ($tarih as $item): ?>
                                <li>
                                    <strong><?php echo htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?></strong><br>
                                    <span class="muted"><?php echo htmlspecialchars($item['meta'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span><br>
                                    <span class="muted">Son bakılma: <?php echo htmlspecialchars($item['viewedAt'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php else: ?>
                        <p>Henüz kaydedilmiş bir cihaz gecmişi yok. Ürün kartlarindaki "Incele" butonlarini kullanarak gecmis olusturabilirsin.</p>
                    <?php endif; ?>
                </section>
            </article>

            <footer class="content-footer">
                <small>Cihaz gecmişi tarayicidaki çerezlerde 30 gün saklanır.</small>
            </footer>
        </section>

        <aside class="sidebar">
            <h2>Hesap Menüsü</h2>
            <ul>
                <li><a href="products.html">Ürünlere Dön</a></li>
                <li><a href="contact.html">Destek Al</a></li>
                <li><a href="logout.php">Oturumu Kapat</a></li>
            </ul>

            <h2>Gecmiş Bilgisi</h2>
            <ul>
                <li>En son baktığınız 8 cihaz kaydedilir.</li>
                <li>Aynı cihaz yeniden incelenirse liste başı güncellenir.</li>
            </ul>
        </aside>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 Second. Tum hakları saklıdır.</p>
    </footer>
</body>
</html>
