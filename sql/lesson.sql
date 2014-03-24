-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2014 at 09:08 AM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lesson`
--

-- --------------------------------------------------------

--
-- Table structure for table `activation`
--

CREATE TABLE IF NOT EXISTS `activation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `code` varchar(100) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

--
-- Dumping data for table `activation`
--

INSERT INTO `activation` (`id`, `uid`, `code`, `date`) VALUES
(1, 10, '5ab4d65099f64622f00e72d6e0e3278d', '2014-03-04'),
(2, 11, '3b74737f12aad6595b29aa173e8d3c1d', '2014-03-04'),
(3, 12, '9bf3deee2cdb80bb4e36b1067bf1cc42', '2014-03-04'),
(4, 13, '9447e25df55d6ddfc003a19616fa6e32', '2014-03-04'),
(5, 14, '9a0c6966d998cf8846bb873072ed4a74', '2014-03-04'),
(6, 15, 'ea975a29df1049206d711c7587185502', '2014-03-04'),
(7, 19, 'a52bdc59800bf3cf7aed3695b48b0a76', '2014-03-05');

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `sender` varchar(50) COLLATE utf8_bin NOT NULL,
  `to_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `to_email` varchar(50) COLLATE utf8_bin NOT NULL,
  `subject` varchar(200) COLLATE utf8_bin NOT NULL,
  `body` text COLLATE utf8_bin NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE IF NOT EXISTS `lesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `uid` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`id`, `name`, `description`, `uid`, `order`) VALUES
(1, 'Програмчлалын хэл С', 'Сайн байна уу? Миний хичээлд тавтай морил. Сайн байна уу? Миний хичээлд тавтай морил. Сайн байна уу? Миний хичээлд тавтай морил. Сайн байна уу? Миний хичээлд тавтай морил. Сайн байна уу? Миний хичээлд тавтай морил. Сайн байна уу? Миний хичээлд тавтай морил. Сайн байна уу? Миний хичээлд тавтай морил. Сайн байна уу? Миний хичээлд тавтай морил. ', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `uid`, `lid`, `status`) VALUES
(1, 1, 1, 0),
(2, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `resetpassword`
--

CREATE TABLE IF NOT EXISTS `resetpassword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `code` varchar(40) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `fname` varchar(200) COLLATE utf8_bin NOT NULL,
  `lname` varchar(200) COLLATE utf8_bin NOT NULL,
  `mobilephone` varchar(20) COLLATE utf8_bin NOT NULL,
  `email` varchar(200) COLLATE utf8_bin NOT NULL,
  `password` varchar(200) COLLATE utf8_bin NOT NULL,
  `role` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT 'me',
  `active` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `iuser` varchar(50) COLLATE utf8_bin NOT NULL,
  `ipass` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=20 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fname`, `lname`, `mobilephone`, `email`, `password`, `role`, `active`, `iuser`, `ipass`) VALUES
(1, 'admin', 'Өсөхбаатар', 'Өсөхбаатар', '', 'osohoo02@gmail.com', 'c444858e0aaeb727da73d2eae62321ad', 'users', 'true', 'usukhbaatar', 'leaderofworld'),
(19, 'leader', 'Usukhbaatar', 'Dotgonvanchig', '', 'd.usukhbaatar@gmail.com', 'c444858e0aaeb727da73d2eae62321ad', 'users', 'false', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
