<?php
require_once 'config.php';

// Giriş kontrolü
if (!isSellerLoggedIn()) {
    header('Location: seller-login.php');
    exit;
}

$sellerId = $_SESSION['seller_id'];
$seller = getSellerInfo($sellerId);

if (!$seller) {
    logoutSeller();
    header('Location: seller-login.php');
    exit;
}

// Çıkış işlemi
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logoutSeller();
    header('Location: seller-login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satıcı Paneli - Second</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <h1>Second</h1>
        <p class="tagline">2. el elektronik alım-satım'da yeni devir.</p>
    </header>

    <main class="layout">
        <nav class="side-nav">
            <h2>Menü</h2>
            <ul>
                <li><a href="index.html">Anasayfa</a></li>
                <li><a class="active" href="seller-dashboard.php">Satıcı Paneli</a></li>
                <li><a href="seller-dashboard.php?action=logout">Çıkış Yap</a></li>
            </ul>
        </nav>

        <section class="content">
            <header class="content-header">
                <div class="content-header-top">
                    <h2>Satıcı Paneli</h2>
                    <p>Hoş geldiniz, <strong><?php echo htmlspecialchars($seller['name']); ?></strong>!</p>
                </div>
            </header>

            <article class="content-article">
                <div class="info-grid">
                    <div class="account-card">
                        <h3>Hesap Bilgileri</h3>
                        <ul class="feature-list">
                            <li><strong>Ad Soyad:</strong> <?php echo htmlspecialchars($seller['name']); ?></li>
                            <li><strong>E-posta:</strong> <?php echo htmlspecialchars($seller['email']); ?></li>
                            <li><strong>Telefon:</strong> <?php echo htmlspecialchars($seller['phone']); ?></li>
                            <li><strong>Kayıt Tarihi:</strong> <?php echo date('d.m.Y H:i', strtotime($seller['created_at'])); ?></li>
                        </ul>
                    </div>

                    <div class="account-card">
                        <h3>İstatistikler</h3>
                        <ul class="feature-list">
                            <li><strong>Aktif İlanlar:</strong> 0</li>
                            <li><strong>Satılan Ürünler:</strong> 0</li>
                            <li><strong>Toplam Kazanç:</strong> 0 TL</li>
                            <li><strong>Puan:</strong> ⭐⭐⭐⭐⭐</li>
                        </ul>
                    </div>
                </div>

                <h3 style="margin-top: 20px;">İşlemler</h3>
                <div class="info-grid">
                    <div class="info-box">
                        <h4>Yeni İlan Ekle</h4>
                        <p>Satmak istediğiniz ürünleri ekleyip fotoğraf yükleyin.</p>
                        <button class="btn" disabled>Çok Yakında Açılacak</button>
                    </div>

                    <div class="info-box">
                        <h4>İlanlarım</h4>
                        <p>Aktif ve sonlandırılan ilanlarınızı yönetin.</p>
                        <button class="btn" disabled>Çok Yakında Açılacak</button>
                    </div>

                    <div class="info-box">
                        <h4>Satış Geçmişi</h4>
                        <p>Yaptığınız satışların detaylarını görüntüleyin.</p>
                        <button class="btn" disabled>Çok Yakında Açılacak</button>
                    </div>

                    <div class="info-box">
                        <h4>Profil Ayarları</h4>
                        <p>Hesap bilgilerinizi güncelleyin.</p>
                        <button class="btn" disabled>Çok Yakında Açılacak</button>
                    </div>
                </div>

                <div class="info-box" style="margin-top: 20px;">
                    <h4>Güvenlik Bilgisi</h4>
                    <p>Kimlik bilgileriniz tamamen güvenlidir:</p>
                    <ul class="feature-list">
                        <li>✓ Kimlik numaranız AES-256 ile şifrelenmiştir</li>
                        <li>✓ Şifreniz bcrypt ile hash'lenmiştir</li>
                        <li>✓ Hiçbir dış uygulama ile paylaşılmaz</li>
                        <li>✓ Sadece sistem yöneticileri erişebilir</li>
                        <li>✓ Düzenli olarak güvenlik denetimi yapılır</li>
                    </ul>
                </div>
            </article>
        </section>

        <aside class="sidebar">
            <h2>Hızlı Bağlantılar</h2>
            <ul>
                <li><a href="seller-dashboard.php?action=logout">Çıkış Yap</a></li>
                <li><a href="index.html">Ana Sayfa</a></li>
            </ul>

            <h2>Destek</h2>
            <ul>
                <li><a href="contact.html">İletişim</a></li>
                <li>Email: seller@second.com</li>
            </ul>
        </aside>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 Second. Tüm hakları saklıdır.</p>
    </footer>
</body>
</html>
