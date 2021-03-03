-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 01 May 2020, 16:45:27
-- Sunucu sürümü: 10.4.11-MariaDB
-- PHP Sürümü: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `db_kutup`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kitap`
--

CREATE TABLE `kitap` (
  `id` int(11) NOT NULL,
  `isbn` bigint(11) NOT NULL,
  `ismi` text COLLATE utf8_unicode_ci NOT NULL,
  `yazar` text COLLATE utf8_unicode_ci NOT NULL,
  `kullanim` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `id` int(11) NOT NULL,
  `isim` text COLLATE utf8_unicode_ci NOT NULL,
  `sifre` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`id`, `isim`, `sifre`) VALUES
(1, 'rezzan', 'rezzan'),
(2, 'kullanici1', 'kullanici1'),
(3, 'kullanici2', 'kullanici2'),
(4, 'kullanici3', 'kullanici3'),
(5, 'kullanici4', 'kullanici4');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sahip`
--

CREATE TABLE `sahip` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `sayisi` int(11) NOT NULL,
  `isbn_1` bigint(11) NOT NULL,
  `isbn_2` bigint(11) NOT NULL,
  `isbn_3` bigint(11) NOT NULL,
  `tarih_1` date NOT NULL,
  `tarih_2` date NOT NULL,
  `tarih_3` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `sahip`
--

INSERT INTO `sahip` (`id`, `kullanici_id`, `sayisi`, `isbn_1`, `isbn_2`, `isbn_3`, `tarih_1`, `tarih_2`, `tarih_3`) VALUES
(1, 1, 0, 0, 0, 0, '2020-04-01', '2020-04-24', '0000-00-00'),
(2, 2, 0, 0, 0, 0, '2020-04-24', '2020-04-24', '2020-04-22'),
(3, 3, 0, 0, 0, 0, '0000-00-00', '0000-00-00', '0000-00-00'),
(4, 4, 0, 0, 0, 0, '2020-04-23', '2020-04-24', '2020-04-14'),
(5, 5, 0, 0, 0, 0, '2020-04-23', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yonetici`
--

CREATE TABLE `yonetici` (
  `id` int(11) NOT NULL,
  `isim` text COLLATE utf8_unicode_ci NOT NULL,
  `sifre` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `yonetici`
--

INSERT INTO `yonetici` (`id`, `isim`, `sifre`) VALUES
(1, 'yonetici1', 'yonetici1'),
(2, 'yonetici2', 'yonetici2');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `kitap`
--
ALTER TABLE `kitap`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sahip`
--
ALTER TABLE `sahip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Tablo için indeksler `yonetici`
--
ALTER TABLE `yonetici`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `kitap`
--
ALTER TABLE `kitap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `sahip`
--
ALTER TABLE `sahip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `yonetici`
--
ALTER TABLE `yonetici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `sahip`
--
ALTER TABLE `sahip`
  ADD CONSTRAINT `sahip_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanici` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
