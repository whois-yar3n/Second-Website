-- Satıcı Yönetim Sistemi Veritabanı Tablosu
-- Second Platform - Satıcı Verileri

-- Satıcılar tablosu
CREATE TABLE IF NOT EXISTS `sellers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identity_number` longblob NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Güvenlik Notu: 
-- - identity_number (kimlik numarası) AES-256-CBC ile şifrelenmiş olarak saklanır
-- - password (şifre) bcrypt ile hash'lenmiş olarak saklanır
-- - Kimlik numarası dışarıya asla açılmaz, sadece sistem içinde kullanılır
