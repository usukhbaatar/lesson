-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2014 at 09:06 AM
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

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
(7, 19, 'a52bdc59800bf3cf7aed3695b48b0a76', '2014-03-05'),
(8, 20, '8c7289bb79a6ef57dd03b54029df52f3', '2014-04-06');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `lid` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `name`, `sender`, `to_name`, `to_email`, `subject`, `body`, `status`) VALUES
(1, 'ForU.MN', 'service@foru.mn', 'TestFname TestLname', 'test@gmail.com', 'Lesson.ForU.MN', '<h1>Сайн байна уу?</h1> <br/> <h2> Тавтай морил </h2> <br/> Та дараах холбоос дээр дарснаар өөрийн бүртгэлээ идэвхижүүлэх боломжтой. <br /> Холбоос: <a href = "http://lesson.foru.mn/users/active/code/5483ee7b955cdd4a00f9516438b871b5">http://lesson.foru.mn/users/active/code/5483ee7b955cdd4a00f9516438b871b5</a>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(100) COLLATE utf8_bin NOT NULL,
  `extention` varchar(10) COLLATE utf8_bin NOT NULL,
  `name` varchar(200) COLLATE utf8_bin NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=37 ;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `uri`, `extention`, `name`, `uid`) VALUES
(26, '/public/files/8b4acdceea98758bc06f0bd4a44540d6.png', 'png', 'Content image.', 1),
(27, '/public/files/c7d77412e5a42bd9ccbce6685a06da37.png', 'png', 'Content image.', 1),
(28, '/public/files/cba3c265901c9f1bf6642d5cd9cf1477.png', 'png', 'Content image.', 1),
(29, '/public/files/e36887cde80da564df6e674504a9cbee.1', '1', 'Content image.', 1),
(30, '/public/files/fecb96c32b92ed2a0872868579c7442b.1', '1', 'Content image.', 1),
(31, '/public/files/514105f982a8e357437420b52e272c8e.1', '1', 'Content image.', 1),
(32, '/public/files/4339280e6405c990c9146e3f62f835e8.1', '1', 'Content image.', 1),
(33, '/public/files/eba3d4b5b3e2ba52613b933fc53f0b0c.1', '1', 'Content image.', 1),
(34, '/public/files/0d0b9da24d364dcba40be769aa0e1d51.jpg', 'jpg', 'Content image.', 1),
(35, '/public/files/20dda93f4a6ae1f46980a882a11bba3c.jpg', 'jpg', 'Content image.', 1),
(36, '/public/files/89b44ab4456f1e241ed6767dc26ceefc.jpg', 'jpg', 'Content image.', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`id`, `name`, `description`, `uid`, `order`) VALUES
(1, 'Програмчлалын хэл С', 'Сайн байна уу? Миний хичээлд тавтай морил. Сайн байна уу? Миний хичээлд тавтай морил. Сайн байна уу?\r\nМиний хичээлд тавтай морил. Сайн байна уу? Миний хичээлд тавтай морил. Сайн байна уу? Миний хичээлд тавтай\r\nморил. Сайн байна уу? Миний хичээлд тавтай морил. Сайн байна уу? Миний хичээлд тавтай морил. Сайн байна уу?\r\nМиний хичээлд тавтай морил. ', 1, 0),
(2, 'Test lesson', 'King Digital Entertainment Plc (KING:US), the maker of the “Candy Crush” smartphone game that’s trying to raise $533 million in an initial public offering today, is seeking a price-to-sales valuation cheaper than most of its publicly traded peers.\r\n\r\nAt the top of the price range, King would be valued at $7.6 billion, or about 2.9 times projected sales this year, according to a 2014 revenue estimate by Sterne Agee & Leach Inc. By that measure, it’s about half the price of Chinese game developer Giant <span style="font-weight: bold;">Interactive Group Inc., at 6.3, and 43 percent cheaper than Zynga Inc. (ZNGA:US)’s 5.1 times 2014 sales.</span>', 1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `uid`, `lid`, `status`) VALUES
(4, 1, 2, 1),
(5, 1, 1, 1),
(6, 20, 1, 1),
(7, 20, 2, 1);

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
-- Table structure for table `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `lid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `name`, `description`, `content`, `lid`) VALUES
(2, 'Даалгавар-1', '<p><span style="font-weight: bold;">Хичээлээ сайн хийгээрэй хүүхдүүд ээ.</span></p>', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lid` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`id`, `lid`, `name`, `description`, `content`) VALUES
(1, 1, 'Topic-1', 'Topic description here<br><p><br></p>', ''),
(2, 1, 'Topic-2', 'Topic description here.<p><br></p>', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bio` text COLLATE utf8_bin NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=21 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `bio`, `username`, `fname`, `lname`, `mobilephone`, `email`, `password`, `role`, `active`, `iuser`, `ipass`) VALUES
(1, 'Монгол Улсын Их Сургуулийн Хэрэглээний Шинжлэх Ухаан Инженерчлэлийн Сургуулийн сургалтын инженер.\r\n', 'admin', 'Өсөхбаатар', 'Дотгонванчиг', '', 'osohoo02@gmail.com', 'c444858e0aaeb727da73d2eae62321ad', 'admins', 'true', 'usukhbaatar', 'leaderofworld'),
(2, '', 'leader', 'Usukhbaatar', 'Dotgonvanchig', '', 'd.usukhbaatar@gmail.com', 'c444858e0aaeb727da73d2eae62321ad', 'users', 'false', '', ''),
(20, '', 'user', 'TestFname', 'TestLname', '', 'test@gmail.com', 'c444858e0aaeb727da73d2eae62321ad', 'users', 'true', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
