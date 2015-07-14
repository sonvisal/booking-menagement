-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 28, 2015 at 08:33 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `darany`
--
CREATE DATABASE IF NOT EXISTS `darany` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `darany`;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `address`, `description`) VALUES
(4, 'room', 'dsfa', 'sd');

-- --------------------------------------------------------

--
-- Table structure for table `map`
--

CREATE TABLE IF NOT EXISTS `map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lattitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `map`
--

INSERT INTO `map` (`id`, `lattitude`, `longitude`) VALUES
(1, 22.5, 33.4),
(2, 12, 105),
(3, 16, 43),
(4, 23, 5),
(5, 0, 0),
(6, 0, 0),
(7, 0, 0),
(8, 0, 0),
(9, 0, 0),
(10, 0, 0),
(11, 0, 0),
(12, 0, 0),
(13, 0, 0),
(14, 0, 0),
(15, 0, 0),
(16, 0, 0),
(17, 0, 0),
(18, 23, 3),
(19, 53, 53),
(20, 23, 45);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` int(11) NOT NULL,
  `manager` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `floor` int(11) DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `image_name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `location`, `manager`, `name`, `floor`, `description`, `image_name`) VALUES
(1, 1, 1, 'B11', 1, 'B11 Classroom', 'fr.png'),
(2, 1, 1, 'B21', 2, 'B21 Lab', NULL),
(3, 1, 1, 'B22', 2, 'B22 Lab', 'c_mate2.png'),
(10, 1, 0, 'prekas', 2, 'meeting room', 'naissance_de_l_univers___by_michel_de_lorient-d5ozscu.jpg'),
(11, 1, 3, 'n', 1, 'new', NULL),
(12, 1, 0, 'takeo', 22, 'meeting on monday', NULL),
(13, 1, 0, 'bb room', 11, 'meeting on sunday', NULL),
(14, 1, 0, 'MBG', 2, 'meeting on wenesday', NULL),
(15, 3, 0, 'newssssssss', 1, 'as', '1'),
(16, 2, 3, 'pnc1', 1, 'pnc`1', 'screen_329594.png'),
(17, 3, 0, 'goods', 1, 'good', 'c.jpg'),
(18, 3, 3, 'sssssaaaaaaaaa', 1, 'fdaffd', 'b22.jpg'),
(19, 3, 0, 'newsrooms', 1, 'new room', '1.jpg'),
(20, 3, 0, 'room todays', 1, 'dsdf', 'b22.jpg'),
(21, 1, 0, 'visalmylyroom', 34, 'sd', 'trust.jpg'),
(22, 1, 0, 'ddaf', 33, 'adfa', 'fr2.png'),
(23, 1, 0, 'fad', 31, 'adf', 'fr.png'),
(24, 1, 0, 'dafa', 345, 'sg', 'fr.png'),
(25, 1, 0, 'ggdudhgj', 5, 'jhgfjj', 'fr.png'),
(26, 1, 0, 'UKRR', 4, 'FK', 'fr1.png'),
(27, 4, 0, 'b21', 32, 'fdf', 'fr3.png'),
(28, 4, 6, 'b23', 43, 'sad', 'screen_3295941.png'),
(29, 4, 0, 'visaldara', 32, 'saf', 'Desert.jpg'),
(30, 4, 3, 'create by myly', 31, 'sdfa', 'error.jpg'),
(31, 4, 3, 'someroomnew', 21, 'af', 'Hacker_Boy_Stickers.png'),
(32, 4, 3, 'niceroom', 9, 'dkkd', 'logo-four.png'),
(33, 4, 3, 'hello room', 6, 'dad', 'www.png'),
(34, 4, 3, 'ame room', 4, 'da', 'error1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Planned'),
(2, 'Requested'),
(3, 'Accepted'),
(4, 'Rejected'),
(5, 'Prepare');

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

CREATE TABLE IF NOT EXISTS `timeslots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room` int(11) NOT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `note` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `creator` (`creator`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=63 ;

--
-- Dumping data for table `timeslots`
--

INSERT INTO `timeslots` (`id`, `room`, `startdate`, `enddate`, `status`, `creator`, `note`) VALUES
(1, 2, '2015-04-21 00:00:00', '2015-04-21 00:00:00', 4, 1, NULL),
(6, 4, '2015-04-05 04:00:00', '2015-04-29 04:00:00', 3, 3, NULL),
(7, 5, '2015-04-24 02:00:00', '2015-04-25 02:00:00', 3, 3, NULL),
(8, 5, '2015-04-24 05:00:00', '2015-04-30 05:00:00', 3, 3, NULL),
(9, 5, '2015-04-28 04:00:00', '2015-04-28 04:00:00', 3, 3, NULL),
(10, 7, '2015-04-01 03:00:00', '2015-04-30 03:00:00', 3, 3, NULL),
(11, 6, '2015-04-01 00:00:00', '2015-04-30 07:00:00', 3, 3, NULL),
(12, 6, '2015-04-25 00:00:00', '2015-04-30 00:00:00', 3, 3, NULL),
(13, 6, '2015-04-01 00:00:00', '2015-04-30 00:00:00', 2, 3, 'vdfgsg'),
(16, 8, '2015-04-01 07:00:00', '2015-04-01 07:00:00', 4, 3, NULL),
(17, 8, '2015-04-01 00:00:00', '2015-04-01 00:00:00', 2, 3, NULL),
(18, 1, '2015-04-29 00:00:00', '2015-04-29 00:00:00', 3, 3, 'fsdfsdf'),
(19, 1, '2015-04-22 00:00:00', '2015-04-22 00:00:00', 2, 1, 'dsfs'),
(20, 11, '2015-05-01 00:00:00', '2015-05-01 00:00:00', 2, 1, 'viisal'),
(21, 11, '2015-05-27 00:00:00', '2015-05-28 00:00:00', 2, 1, 'test visal'),
(22, 11, '2015-05-30 00:00:00', '2015-05-31 00:00:00', 2, 1, 'test visal'),
(23, 12, '2015-05-14 14:27:00', '2015-05-27 14:27:00', 3, 1, 'new book for visal'),
(24, 12, '2015-05-14 14:27:00', '2015-05-27 14:27:00', 4, 1, 'new book for visal'),
(25, 11, '2015-05-14 14:30:00', '2015-05-21 14:30:00', 2, 3, 'newss'),
(26, 11, '2015-05-14 14:30:00', '2015-05-21 14:30:00', 2, 3, 'newss'),
(27, 11, '2015-05-14 14:33:00', '2015-05-14 14:33:00', 2, 3, 'dfd'),
(28, 12, '2015-05-15 09:26:00', '2015-05-30 09:26:00', 3, 3, 'test email'),
(29, 11, '2015-05-14 09:27:00', '2015-05-30 09:27:00', 3, 3, 'tet mail'),
(30, 14, '2015-05-16 09:35:00', '2015-05-25 09:35:00', 3, 3, 'something'),
(32, 14, '2015-05-18 10:49:00', '2015-05-19 10:49:00', 3, 3, '3'),
(33, 14, '2015-05-18 10:49:00', '2015-05-19 10:49:00', 4, 3, '3'),
(34, 10, '2015-05-19 11:19:00', '2015-05-19 11:22:00', 3, 6, ''),
(35, 10, '2015-05-19 11:19:00', '2015-05-19 11:22:00', 4, 6, ''),
(36, 20, '2015-05-19 11:20:00', '2015-05-19 11:25:00', 3, 6, ''),
(37, 1, '2015-05-22 10:08:00', '2015-05-22 10:30:00', 2, 6, 'dafsd'),
(38, 27, '2015-05-22 10:33:00', '2015-05-22 10:41:00', 3, 6, 'wdasd'),
(39, 28, '2015-05-22 10:35:00', '2015-05-22 10:49:00', 2, 6, 'adafds'),
(40, 27, '2015-05-25 12:21:00', '2015-05-25 12:43:00', 3, 6, ''),
(41, 27, '2015-05-24 12:22:00', '2015-05-24 12:28:00', 3, 6, ''),
(42, 27, '2015-05-24 12:23:00', '2015-05-24 12:31:00', 3, 6, ''),
(43, 27, '2015-05-24 12:25:00', '2015-05-24 12:37:00', 4, 6, ''),
(44, 27, '2015-05-24 12:25:00', '2015-05-24 12:37:00', 4, 6, ''),
(45, 27, '2015-05-24 15:25:00', '2015-05-24 22:25:00', 4, 6, ''),
(46, 29, '2015-05-24 16:51:00', '2015-05-24 16:59:00', 3, 6, ''),
(47, 29, '2015-05-24 16:51:00', '2015-05-24 16:59:00', 4, 6, ''),
(48, 29, '2015-05-24 16:52:00', '2015-05-24 16:55:00', 4, 6, ''),
(49, 29, '2015-05-24 17:00:00', '2015-05-24 17:27:00', 3, 6, ''),
(50, 28, '2015-05-24 17:32:00', '2015-05-24 17:59:00', 3, 6, ''),
(51, 27, '2015-05-25 13:43:00', '2015-05-25 13:48:00', 3, 4, 'painting color'),
(52, 27, '2015-05-25 14:13:00', '2015-05-25 14:29:00', 3, 4, 'booking by myly'),
(53, 27, '2015-05-25 15:14:00', '2015-05-25 15:21:00', 3, 4, 'aaaaaaaa'),
(54, 30, '2015-05-25 15:15:00', '2015-05-25 15:22:00', 3, 3, 'sf'),
(55, 28, '2015-05-25 15:28:00', '2015-05-25 15:32:00', 3, 6, 'new again'),
(56, 28, '2015-05-25 15:32:00', '2015-05-25 15:45:00', 3, 6, 'how new booking'),
(57, 27, '2015-05-26 10:19:00', '2015-05-26 10:31:00', 3, 4, 'e'),
(58, 30, '2015-05-26 13:19:00', '2015-05-26 13:32:00', 3, 6, 'dfaf'),
(59, 31, '2015-05-27 08:34:00', '2015-05-27 08:40:00', 3, 4, 'waD'),
(60, 32, '2015-05-27 08:54:00', '2015-05-27 08:57:00', 3, 4, 'fab'),
(61, 33, '2015-05-27 09:04:00', '2015-05-27 09:20:00', 3, 4, 'ksk'),
(62, 34, '2015-05-27 10:12:00', '2015-05-27 10:24:00', 3, 4, 'booking by visal');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `login` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(512) CHARACTER SET utf8 DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `language` varchar(2) CHARACTER SET utf8 NOT NULL DEFAULT 'en',
  `free` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Availability',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `login`, `email`, `password`, `role`, `language`, `free`) VALUES
(1, 'Benjamin', 'BALET', 'bbalet', 'benjamin.balet@gmail.com', '$2a$08$veoXfsagURNEweM0HWm2a.kxKkr/Ggnyxxl1414QePLrTBOUVRqVu', 1, 'en', 1),
(2, 'John', 'DOE', 'jdoe', 'jdoe@darany.org', '$2a$08$Vk8FdteT25t.3Q9yU6pZWOCkc3rvXYc5jfV4Wq4b3Tg4WwwomeiJO', 2, 'en', 1),
(3, 'son', 'VISAL', 'sonvisal', 'sonvisal10@gmail.com', '$2a$08$jkLiValrlXLyhRr7KZTZbOYm97.3.m90M3uadYz6lSJBGC5VRLKRu', 2, 'en', 0),
(4, 'myly', 'VANN', 'mylyvann', 'mylyvann@gmail.com', '$2a$08$elHbkQCXSvDkDUi.IjaTyeslsAonLNQOjwGWS1JO53G09A.BhRKVq', 1, 'en', 1),
(6, 'kimsan', 'HENG', 'kheng', 'kimsanheng.heng@gmail.com', '$2a$08$klB.uB9JwQlQyHknw/R4SuZGubEFtRgTj8adumLgUnk5od6T63/6y', 1, 'en', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
