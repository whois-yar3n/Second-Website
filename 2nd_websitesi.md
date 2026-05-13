# Second - İkinci El Elektronik Alım-Satım Platformu

## 📋 İçindekiler
1. [Kullanım Amacı](#kullanım-amacı)
2. [Kullanım Şekli](#kullanım-şekli)
3. [Kullanılan Diller ve Teknolojiler](#kullanılan-diller-ve-teknolojiler)
4. [Kaynakçası](#kaynakçası)

---

## 🎯 Kullanım Amacı

**Second**, güvenilir ikinci el elektronik ürünlerin alım-satımını daha şeffaf, hızlı ve ulaşılabilir hale getirmek amacıyla kurulmuş bir web platformudur.

### Platform Hedefleri:
- **Güvenli Alışveriş**: Satıcı doğrulaması ve güvenlik protokolleri ile kullanıcı güvenliğini sağlamak
- **Adil Fiyatlandırma**: İkinci el elektronik ürünlerde gereksiz zam ve kötü sürprizlere son koymak
- **Geniş Ürün Yelpazesi**: Telefonlar, bilgisayarlar, tabletler, ek parçalar ve ev parçaları gibi çeşitli kategorilerde ürün sunmak
- **Kullanıcı Dostu Arayüz**: Kolay arama ve filtreleme özelikleri ile müşteri memnuniyetini artırmak
- **Satıcı ve Alıcı Yönetimi**: Hem satıcı hem de alıcı perspektifinden tam teşekküllü bir e-ticaret çözümü sağlamak

### Hedef Kullanıcı Grubu:
- İkinci el elektronik ürün satın almak isteyen müşteriler
- Eski cihazlarını satmak isteyen bireysel satıcılar
- Toplu satış yapmak isteyen satıcı işletmeler

---

## 💡 Kullanım Şekli

### Alıcı Perspektifi:

1. **Ürün Browsing (Tarama)**
   - Ana sayfadan veya kategorilerden ürünleri görüntüleme
   - Kategoriler: Telefon, Bilgisayar, Tablet, Ek Parçalar, Ev Parçaları
   - Arama fonksiyonu ile özel ürün araması (örn: "iPhone 12", "RTX 3060")

2. **Ürün İnceleme**
   - Ürün detaylarını görüntüleme
   - Satıcı bilgileri ve değerlendirmelerini kontrol etme
   - Ürün kalite kontrolü ve durumu hakkında bilgi alma

3. **Hesap Yönetimi**
   - Üye olarak hesap açma
   - Giriş yapma ve profil yönetimi
   - Satın alma geçmişini takip etme

4. **İletişim**
   - Satıcı ile doğrudan iletişim kurma
   - Kontakt formunu kullanarak destek talepleri

### Satıcı Perspektifi:

1. **Satıcı Kaydı**
   - Satıcı kaydı ve hesap oluşturma
   - Kimlik doğrulaması (güvenlik için)
   - Profil bilgilerini tamamlama

2. **Ürün Yönetimi**
   - Ürün ekleme ve yayınlama
   - Ürün bilgilerini güncelleme
   - Ürün silme ve deaktive etme

3. **Satıcı Paneli (Dashboard)**
   - Satış geçmişi ve istatistikler
   - Aktif ürünler yönetimi
   - Müşteri mesajlarını takip etme
   - Satıcı durumu ve ratingi izleme

4. **Güvenlik**
   - Kimlik numarası (identity_number) ile satıcı doğrulaması
   - Şifreli veri saklama (AES-256-CBC enkripsiyon)
   - Bcrypt ile güvenli şifre yönetimi

---

## 🛠️ Kullanılan Diller ve Teknolojiler

### Frontend (İstemci Tarafı):

| Teknoloji | Versiyon | Kullanım Amacı |
|-----------|----------|----------------|
| **HTML5** | - | Sayfa yapısı ve semantik işaretleme |
| **CSS3** | - | Stil tasarımı ve responsive (duyarlı) tasarım |
| **JavaScript (Vanilla)** | ES6+ | Dinamik etkileşimler ve kullanıcı deneyimi iyileştirmesi |

### Backend (Sunucu Tarafı):

| Teknoloji | Versiyon | Kullanım Amacı |
|-----------|----------|----------------|
| **PHP** | 7.4+ | Sunucu tarafı programlama ve iş mantığı |
| **MySQL** | 5.7+ | İlişkisel veri tabanı yönetimi |
| **PDO (PHP Data Objects)** | - | Veritabanı sorgularına güvenli erişim (SQL Injection koruması) |

### Veritabanı Şeması:

**Sellers (Satıcılar) Tablosu:**
- `id` - Satıcı kimliği (otomatik artan)
- `name` - Satıcı adı
- `email` - E-posta adresi (benzersiz)
- `phone` - Telefon numarası
- `password` - Şifreler (bcrypt ile hashlenmiş)
- `identity_number` - Kimlik numarası (AES-256-CBC ile şifrelenmiş)
- `created_at` - Hesap oluşturma tarihi
- `updated_at` - Son güncelleme tarihi

### Güvenlik Özellikleri:

```
✓ PDO (Parametrized Queries) - SQL Injection koruması
✓ bcrypt - Şifre hashing ve güvenliği
✓ AES-256-CBC - Kimlik numarası enkripsionu
✓ UTF-8 Charset - Türkçe karakter desteği (utf8mb4)
✓ Session Management - Oturum yönetimi
✓ HTTPS Ready - HTTPS desteği için hazır yapı
```

### Dil Desteği:

- **Kullanıcı Arayüzü**: Türkçe (tr)
- **Kodlama**: UTF-8 (Türkçe ve diğer diller)
- **Locale**: tr_TR (Türk yerel ayarları)

---

## 📚 Kaynakçası

### Teknik Belgelendirme:

1. **PHP Resmi Dokümantasyonu**
   - URL: https://www.php.net/manual/
   - Kullanılan: PDO, Session, Security Best Practices

2. **MySQL/MariaDB Dokümantasyonu**
   - URL: https://dev.mysql.com/doc/
   - Kullanılan: CREATE TABLE, Charset UTF8MB4, InnoDB Engine

3. **HTML5 Spesifikasyonu**
   - URL: https://html.spec.whatwg.org/
   - Kullanılan: Semantic HTML, Form Elements, Meta Tags

4. **CSS3 ve Responsive Design**
   - URL: https://www.w3.org/Style/CSS/
   - Kullanılan: Flexbox, Grid, Media Queries

5. **JavaScript (MDN Web Docs)**
   - URL: https://developer.mozilla.org/en-US/docs/Web/JavaScript/
   - Kullanılan: DOM Manipulation, Event Handling, Fetch API

### Güvenlik Kaynakları:

6. **OWASP (Open Web Application Security Project)**
   - URL: https://owasp.org/
   - Kullanılan: SQL Injection Prevention, Password Security, Session Management

7. **PHP Security Guide - bcrypt ve Password Hashing**
   - URL: https://www.php.net/manual/en/faq.passwords.php
   - Kullanılan: Password Hashing Best Practices

8. **Character Encoding ve UTF-8**
   - URL: https://en.wikipedia.org/wiki/UTF-8
   - Kullanılan: Turkish Character Support, Multilingual Database

### Web Standartları:

9. **W3C Accessibility Guidelines (WCAG)**
   - URL: https://www.w3.org/WAI/WCAG21/quickref/
   - Kullanılan: Aria Labels, Semantic Navigation

10. **Mobile-First Responsive Design**
    - URL: https://www.google.com/webmasters/
    - Kullanılan: Viewport Meta Tags, Mobile Optimization

### Platform Bileşenleri:

| Bileşen | Kaynak | Açıklama |
|---------|--------|----------|
| Session Management | PHP.net | Server-side session handling |
| PDO Database Layer | PHP.net | Database abstraction layer |
| Password Hashing | PHP.net (password_hash) | Secure password storage |
| Responsive Layout | CSS3 Spec | Mobile-friendly design |
| Form Validation | HTML5 + JavaScript | Client-side validation |

---

## 📝 Notlar

- **Veritabanı Şeması**: `database.sql` dosyasında tam tanımlanmıştır
- **Yapılandırma**: `config.php` dosyasında merkezi yapılandırma sağlanmaktadır
- **Türkçe Dil Desteği**: Tüm arayüz ve veritabanı Türkçe karakterleri desteklemek için optimize edilmiştir
- **Otomatik Veritabanı Oluşturma**: Sistem ilk kullanımda veritabanını otomatik olarak oluşturabilir

---

**Son Güncellenme**: 2026-05-02

**Platform Adı**: Second - 2. el elektronik alım-satım'da yeni devir.

**Hedef Kitle**: Türkçe konuşan ülkeler, özellikle Türkiye

**Bilgi Kaynakçası**: PHP Türkiye(Youtube), PHP Academy(Youtube), Grok(Fikir Alımı), Google Developers

**Hazırlayan**: Cansu Güneş
