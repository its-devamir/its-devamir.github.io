-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
<<<<<<< HEAD
-- Generation Time: Feb 04, 2023 at 06:31 PM
=======
-- Generation Time: Jan 31, 2023 at 01:47 PM
>>>>>>> f8d264e28f7b522af4c265b48d328a832d1f925b
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thunder_db`
--

-- --------------------------------------------------------

--
<<<<<<< HEAD
=======
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `slug` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `body` mediumtext COLLATE utf8_persian_ci NOT NULL,
  `views` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pro_id` int NOT NULL,
  `user_id` int NOT NULL,
  `size` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pro_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rate` int NOT NULL,
  `body` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pro_id` int NOT NULL,
  `status` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `cat_id` int NOT NULL,
  `images` varchar(2500) COLLATE utf8_persian_ci NOT NULL,
  `sizes` varchar(2500) COLLATE utf8_persian_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `about` varchar(1000) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `description` varchar(2500) COLLATE utf8_persian_ci NOT NULL,
  `amount` int NOT NULL,
  `price` int NOT NULL,
  `off` int NOT NULL,
  `endOff` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
>>>>>>> f8d264e28f7b522af4c265b48d328a832d1f925b
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `image` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  `api_token` varchar(255) COLLATE utf8_persian_ci NOT NULL,
<<<<<<< HEAD
  `wishlist` varchar(1000) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL DEFAULT '[]',
=======
  `wishlist` varchar(1000) COLLATE utf8_persian_ci NOT NULL,
>>>>>>> f8d264e28f7b522af4c265b48d328a832d1f925b
  `password` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
<<<<<<< HEAD
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `image`, `phone`, `api_token`, `wishlist`, `password`, `created_at`, `updated_at`) VALUES
(1, 'مهدی رسولزاده', '\"assets/images/users/1.jpg\"', '09369488096', 'F3QFXFSCnfOLwUnowQbUU5EYDKSz5U53hW0nFwe7e4VSgppDDXQcE9YkyZxZ', '[1]', '123456', '0000-00-00 00:00:00', '2023-02-04 14:53:55'),
(2, 'نام تستی', '', '09123456789', 'f9kXfkA6m5jD4E2MjYvrxZTrr3rp5VvBCdtq6jVWT3O51oWTkan64MzTLE3y', '[]', '123456', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
=======
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
>>>>>>> f8d264e28f7b522af4c265b48d328a832d1f925b
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
