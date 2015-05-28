-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 28, 2015 at 08:09 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `appleordinacija`
--
CREATE DATABASE IF NOT EXISTS `appleordinacija` DEFAULT CHARACTER SET utf8 COLLATE utf8_slovenian_ci;
USE `appleordinacija`;

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE IF NOT EXISTS `komentar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vijest` int(11) NOT NULL,
  `autor` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tekst` text COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vijest` (`vijest`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=53 ;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`id`, `vijest`, `autor`, `datum`, `tekst`, `email`) VALUES
(1, 1, 'korisnik1', '2015-05-26 07:42:08', 'Evo jedan komentar od korisnika1 za vijest1 koji je napisao autor1', ''),
(2, 1, 'Ema Cel', '2015-05-26 10:41:03', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', ''),
(8, 2, 'goest', '2015-05-26 23:26:46', 'huehuhe', ''),
(22, 2, 'viviv', '2015-05-27 01:35:56', 'kkk', ''),
(23, 2, 'viviv', '2015-05-27 01:39:07', 'kkkkkkkkkkkk', ''),
(33, 2, 'Elma', '2015-05-27 07:20:56', 'asdfiowedks', 'eee'),
(34, 1, 'kkk', '2015-05-27 07:24:24', 'wioeuqfw', 'www'),
(35, 1, 'kkk', '2015-05-27 07:24:37', 'awiefawoed', 'www'),
(36, 1, '', '2015-05-27 13:10:34', 'aaaaaaaaa', ''),
(37, 1, '', '2015-05-27 23:19:45', 'komentar', 'egazetic1@gmail.com'),
(38, 2, '', '2015-05-27 23:21:10', 'kljlkjklj', 'egazetic1@etf.unsa.ba'),
(39, 1, 'elma', '2015-05-27 23:40:28', 'porukaaa', 'alskf@gmail.com'),
(40, 1, '', '2015-05-27 23:51:11', 'wewewe', ''),
(41, 1, '', '2015-05-27 23:52:16', 'eee', ''),
(43, 1, '', '2015-05-28 00:09:41', 'kkkkkkk', ''),
(44, 2, 'Gost', '2015-05-28 00:10:08', 'lllll', ''),
(45, 2, '', '2015-05-28 00:11:25', 'asdf', ''),
(46, 2, '', '2015-05-28 00:11:55', 'alskdfja', ''),
(47, 2, '', '2015-05-28 00:12:38', 'wwuhgf', ''),
(48, 2, 'Gost', '2015-05-28 00:19:23', 'sgfhdfghf', ''),
(49, 1, 'Gost', '2015-05-28 16:19:44', 'wowowow', ''),
(50, 1, 'ehhehe', '2015-05-28 16:19:53', 'asdfad', ''),
(51, 1, 'ehhehe', '2015-05-28 16:20:06', 'askdfkas', 'asldkf'),
(52, 1, 'Gost', '2015-05-28 20:04:21', 'askldjfwoei', '');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE IF NOT EXISTS `korisnik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_slovenian_ci NOT NULL,
  `password` varchar(20) COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `administrator` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `username`, `password`, `email`, `administrator`) VALUES
(-1, 'memi', 'memi', 'memi@etf.unsa.ba', 1),
(19, 'test', 'test', 'test@gmail.com', 0),
(20, 'korisnik1', 'korisnik1', 'korisnik1@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vijest`
--

CREATE TABLE IF NOT EXISTS `vijest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naslov` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tekst` text COLLATE utf8_slovenian_ci NOT NULL,
  `detaljnije` text COLLATE utf8_slovenian_ci NOT NULL,
  `autor` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `slika` text COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `autor` (`autor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `vijest`
--

INSERT INTO `vijest` (`id`, `naslov`, `datum`, `tekst`, `detaljnije`, `autor`, `slika`) VALUES
(1, 'naslov1', '2015-05-26 07:20:53', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora', 'detaljnije1', 'autor1', 'https://www.google.ba/images/srpr/logo11w.png'),
(2, 'naslov2', '2015-05-26 07:21:41', 'teksasdft2asdkfa sasldkjf iaoweojdkfjjiwoksmd njfijewksm d Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi temporav', 'detaljnije2', 'autor2', 'https://www.google.ba/images/srpr/logo11w.png');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`vijest`) REFERENCES `vijest` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
