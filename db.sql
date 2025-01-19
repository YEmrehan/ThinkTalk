-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 30 Ara 2024, 17:43:08
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `forum`
--
CREATE DATABASE IF NOT EXISTS `forum` DEFAULT CHARACTER SET utf8 COLLATE utf8_turkish_ci;
USE `forum`;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `konular`
--

CREATE TABLE `konular` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `konular`
--

INSERT INTO `konular` (`id`, `baslik`, `aciklama`, `kullanici_id`, `created_at`) VALUES
(3, 'Üniversitemiz de kulüplere yeterince bütçe ayrılmıyor', 'Arkadaşlar Kulüpler için bütçenin artırılmasını istiyoruz. Birlik olursak bu durumu değiştirebiliriz', 1, '2024-11-02 12:52:45'),
(4, 'PHP ve SQL hakkında', 'Arkadaşlar PhpMyAdmin\' e bağlanamıyorum yardımcı olur musunz ?', 3, '2024-11-02 12:54:52');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `parola` varchar(255) NOT NULL,
  `cinsiyet` enum('erkek','kadın') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `yetki` tinyint(1) NOT NULL DEFAULT 0,
  `hakkinda` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kullanici_adi`, `email`, `parola`, `cinsiyet`, `created_at`, `yetki`, `hakkinda`) VALUES
(1, 'emrehan', 'emrehan@gmail.com', '$2y$10$G/aQ9S3hMCg8Lg4FUS.uHOV3UzUeP9wX5j.M2wTI5acaqKj2RsVMC', 'erkek', '2024-10-29 23:08:00', 2, 'web developer'),
(2, 'esma', 'esma@gmail.com', '$2y$10$gpR1sB14Ez1xfEn4Osv.tORKY9LlFGIZe8JJwlERavDZaAla2qMM.', 'kadın', '2024-10-30 10:24:52', 0, 'kastamonuluyum.'),
(3, 'bora', 'bora@gmail.com', '$2y$10$oqY91kX4sRkfpgPRgwlJN.wnzwUxto/aPwNDU9SYE8vcqiY.7s7GC', 'erkek', '2024-11-02 12:54:14', 0, NULL),
(4, 'mehmet', 'mehmet@gmail.com', '$2y$10$TXFzNuTIzBnKF16IPrbCzOidi1EvVdVlhGpzZlkUtGBMet4eM03Ke', 'erkek', '2024-11-02 12:55:16', 0, NULL),
(11, 'merve', 'merve@gmail.com', '$2y$10$iA41AqxWw0XDcVX9QPLYROsfA.yy9U7Cca21SN5O8GI5YM2GHfRKG', 'kadın', '2024-11-07 15:02:43', 0, 'Ben Merve, benimle konuşun.');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` int(11) NOT NULL,
  `konu_id` int(11) NOT NULL,
  `yorum` text NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`id`, `konu_id`, `yorum`, `kullanici_id`, `created_at`) VALUES
(4, 4, '// Veritabanı bağlantı bilgilerini tanımla $servername = \"localhost\"; // Veritabanı sunucusunun adresi (localhost, sunucu IP\'si vb.) $username = \"root\"; // Veritabanı kullanıcı adı $password = \"\"; // Veritabanı parolası $dbname = \"forum\"; // Kullanılacak veritabanı adı', 4, '2024-11-02 12:56:26'),
(5, 4, 'teşekkür ederim :)', 3, '2024-11-02 12:57:02');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `konular`
--
ALTER TABLE `konular`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `konu_id` (`konu_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `konular`
--
ALTER TABLE `konular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
