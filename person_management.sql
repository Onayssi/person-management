-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2017 at 02:40 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `person_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `code`, `active`) VALUES
(1, 'English', 'EN', 'yes'),
(2, 'French', 'FR', 'yes'),
(3, 'Arabic', 'AR', 'yes'),
(4, 'German', 'de', 'yes'),
(5, 'Afrikaans', 'AF', 'yes'),
(6, 'Zulu', 'ZU', 'yes'),
(7, 'Spanish', 'ES', 'yes'),
(8, 'Italian', 'IT', 'yes'),
(9, 'Dutch', 'NL', 'yes'),
(10, 'Portuguese', 'PT', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('administrator','moderator') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'moderator',
  `active` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `remember_me` tinyint(1) DEFAULT NULL,
  `password_reset_token` timestamp NULL DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `email`, `auth_key`, `password_hash`, `role`, `active`, `remember_me`, `password_reset_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ounayssi', 'mouhamad.ounayssi@gmail.com', 'V4QkPrUK2QN3cj3OJdiHaxSdjTBYbB2N', '$2y$13$Lk/4Mz6GkiwyK/s0im1DdOUyT3SfGFdBDMXqKURhoEioBgDGDlIxG', 'administrator', 'yes', NULL, NULL, 10, '2017-02-07 20:11:28', '2017-02-27 16:43:26'),
(2, 'mouhamad', 'mouhamadounayssi@yahoo.com', '-p310ktsB-lIJSS0XQQKYAsYK4AOkLof', '$2y$13$VgXQNQDS6hdz9U9vifR.JOyZtpQjfg.GVn3P5oKvJ5rwOxY7/jZyy', 'moderator', 'yes', NULL, NULL, 10, '2017-02-08 09:59:15', '0000-00-00 00:00:00'),
(3, 'moe@rsa', 'tps_ounayssi@hotmail.com', 'jgr_h-eCuUFNmuunYMtMhBsdMdPlMqC8', '$2y$13$dxV2LiGIhsusHHs5VDGxuulddQWB7Ytb8xXeitQ4JsQubedj8boIq', 'moderator', 'yes', NULL, NULL, 10, '2017-02-08 10:50:39', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`id`, `first_name`, `last_name`, `mobile`, `email`, `lang`, `date_of_birth`, `created_at`, `updated_at`) VALUES
(1, 'Adam', 'Anderson', '0739522100', 'adam.anderson.pmapp@yahoo.com', 1, '1980-02-03', '2017-02-07 10:13:26', '2017-02-07 11:56:30'),
(2, 'Austin', 'Bailey', '0739872126', 'austin.bailey.pmapp@yahoo.com', 1, '1977-10-11', '2017-02-07 11:46:45', '2017-02-07 12:00:04'),
(3, 'Carl', 'Bower', '0728918712', 'carl.bowe.pmapp@yahoo.com', 1, '1978-09-21', '2017-02-07 11:47:37', '2017-02-07 11:56:50'),
(4, 'Dan', 'Butler', '0729760211', 'dan.bulter.pmapp@yahoo.com', 5, '1980-11-21', '2017-02-07 11:48:42', '2017-02-07 11:57:04'),
(5, 'Edward', 'Clarkson', '07820298871', 'edward.clarkson.pmapp@yahoo.com', 9, '1976-10-10', '2017-02-07 11:49:49', '2017-02-07 11:57:15'),
(6, 'Harry', 'Ellison', '07390817612', 'harry.ellison.pmapp@yahoo.com', 1, '1981-03-16', '2017-02-07 11:50:41', '2017-02-07 11:57:30'),
(7, 'Jacob', 'Fraser', '07367729025', 'jacob.fraser.pmapp@yahoo.com', 7, '1975-02-20', '2017-02-07 11:52:00', '2017-02-07 11:57:43'),
(8, 'Elizabeth', 'Henderson', '07290871152', 'elizabeth.henderson.pmapp@yahoo.com', 10, '1982-06-14', '2017-02-07 11:59:09', '0000-00-00 00:00:00'),
(9, 'Nicolas', 'Bardoux', '0726512988', 'nicolas.bardoux.pmapp@yahoo.com', 2, '1979-01-19', '2017-02-07 14:41:24', '2017-02-07 15:21:18'),
(10, 'Darine', 'Watson', '0738433211', 'darin.watson.pmapp@yahoo.com', 8, '1981-05-08', '2017-02-07 17:22:16', '2017-02-07 17:28:40'),
(31, 'Tracy', 'Doklam', '07378129722', 'tracy.doklam.pmapp@yahoo.com', 4, '1979-09-10', '2017-02-08 14:48:54', '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `persons`
--
ALTER TABLE `persons`
  ADD CONSTRAINT `FK1_PersonsLanguages` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
