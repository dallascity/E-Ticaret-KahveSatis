-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 18 Ara 2023, 11:31:20
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `kahveci`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orderdetail`
--

CREATE TABLE `orderdetail` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `price` float NOT NULL,
  `totalprice` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `orderdetail`
--

INSERT INTO `orderdetail` (`order_id`, `user_id`, `products_id`, `weight`, `count`, `price`, `totalprice`) VALUES
(70, 1, 29, 250, 5, 250, 1250),
(70, 1, 30, 500, 3, 1000, 3000),
(70, 1, 30, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `promotions` varchar(10) DEFAULT NULL,
  `price` float NOT NULL,
  `cargoprice` float NOT NULL,
  `decprice` float NOT NULL,
  `totalprice` float NOT NULL,
  `totalcount` float NOT NULL,
  `create_date` date NOT NULL,
  `status` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `promotions`, `price`, `cargoprice`, `decprice`, `totalprice`, `totalcount`, `create_date`, `status`) VALUES
(70, 1, 'TEST', 4250, 0, 1062.5, 3187.5, 8, '2023-12-18', b'1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `photo` text NOT NULL,
  `name` varchar(35) NOT NULL,
  `description` text DEFAULT NULL,
  `price` varchar(8) NOT NULL,
  `weight` varchar(10) NOT NULL,
  `weight_type` varchar(15) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` bit(1) NOT NULL,
  `photo_type` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`product_id`, `photo`, `name`, `description`, `price`, `weight`, `weight_type`, `stock`, `status`, `photo_type`) VALUES
(29, 'as.jpg', 'TÜRK KAHVESI', '', '250', '250', 'Gram', 495, b'0', b'1'),
(30, 'https://schuilcoffee.com/cdn/shop/products/Mocha_Latte.png?v=1543953783', 'LATTE', 'Yerli ve Milli Latte', '1000', '500', 'Gram', 997, b'0', b'0');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `promotions`
--

CREATE TABLE `promotions` (
  `promotions` varchar(10) NOT NULL,
  `create_date` date NOT NULL,
  `finish_date` date NOT NULL,
  `count` int(11) NOT NULL,
  `status` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `promotions`
--

INSERT INTO `promotions` (`promotions`, `create_date`, `finish_date`, `count`, `status`) VALUES
('85TTT73TTT', '2023-12-16', '2023-12-30', 555, b'1'),
('test', '2023-12-15', '2023-12-30', 47, b'1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `city` varchar(20) NOT NULL,
  `adress` text NOT NULL,
  `mail` varchar(70) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `authority` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `city`, `adress`, `mail`, `pass`, `phone`, `authority`) VALUES
(1, 'eymen', 'navdar', 'bursa', 'a mah. b sokak no:6 d:5 nilufer/bursa', 'a@gmail.com', '530363a9f0d81d2c08f23a834cd11eac', '123123123', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Tablo için indeksler `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`promotions`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
