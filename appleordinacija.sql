-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 17, 2015 at 01:40 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=101 ;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`id`, `vijest`, `autor`, `datum`, `tekst`, `email`) VALUES
(48, 2, 'Gost', '2015-05-28 00:19:23', 'sgfhdfghf', ''),
(67, 2, 'test', '2015-06-12 04:48:42', 'wfasd', 'wtest'),
(68, 2, 'safkl', '2015-06-12 05:30:41', 'io', 'lskf'),
(69, 2, 'elma', '2015-06-12 05:41:55', 'askdf', 'askdlf'),
(70, 2, 'bezemail', '2015-06-12 05:44:24', 'asdlkfwieo', ''),
(71, 2, 'memi', '2015-06-12 06:03:15', 'ldskf', 'asldkf'),
(72, 2, 'eee', '2015-06-12 06:03:23', 'weoif', 'aslkd'),
(73, 2, 'dslf', '2015-06-12 06:03:29', 'asdl', ''),
(74, 2, ' ', '2015-06-12 06:19:18', 'false', ' '),
(75, 2, ' ', '2015-06-12 06:19:26', 'test', ' '),
(76, 2, 'memi', '2015-06-12 06:24:17', 'aslkf', 'email'),
(77, 2, 'memi', '2015-06-12 06:25:00', 'skld', 'email'),
(78, 2, 'memi', '2015-06-12 06:25:27', 'awioef', 'email'),
(80, 1, 'memi', '2015-06-12 06:28:55', 'kkkk', 'email@email.com'),
(81, 3, ' ', '2015-06-12 06:29:30', 'test', ' '),
(84, 1, '', '2015-06-12 06:37:06', 'alkdf', ''),
(85, 1, 'ask', '2015-06-12 06:37:13', 'eiof', 'weoif'),
(99, 1, 'test', '2015-06-15 19:44:48', 'test', 'wte'),
(100, 1, 'w', '2015-06-15 19:45:08', 'mmmmm', 'kf');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `username`, `password`, `email`, `administrator`) VALUES
(-1, 'memi', 'memi', 'memi@etf.unsa.ba', 1),
(19, 'test', 'test', 'test@gmail.com', 1),
(28, 'korisnik1', 'korisnik1', 'korisnik1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `poruka`
--

CREATE TABLE IF NOT EXISTS `poruka` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `korisnik` text COLLATE utf8_slovenian_ci NOT NULL,
  `email` text COLLATE utf8_slovenian_ci NOT NULL,
  `telefon` text COLLATE utf8_slovenian_ci NOT NULL,
  `poruka` text COLLATE utf8_slovenian_ci NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `procitana` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `poruka`
--

INSERT INTO `poruka` (`id`, `korisnik`, `email`, `telefon`, `poruka`, `datum`, `procitana`) VALUES
(1, 'Korisnik1', 'email1@gmail.com', '38761 938 384', 'poruka1', '2015-06-17 13:35:54', 1),
(2, 'korisnik2', 'korisnik2@gmail.com', '38761 930 382', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ', '2015-06-17 13:35:54', 1),
(3, 'korisnik2', 'korisnik2@gmail.com', '38761 930 382', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ', '2015-06-17 13:33:45', 1),
(4, 'Elma Gazetic', 'email@gmail.com', '23454 333 222', 'Testna poruka. Hi :)  ', '2015-06-17 13:35:54', 1),
(5, 'Elma Gazetic', 'egazetic1@etf.unsa.ba', '12343 555 444', 'Opet ja :)  ', '2015-06-17 13:37:13', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `vijest`
--

INSERT INTO `vijest` (`id`, `naslov`, `datum`, `tekst`, `detaljnije`, `autor`, `slika`) VALUES
(1, 'naslov1', '2015-06-12 02:55:44', 'test1', 'detaljnije1', 'autor1', 'https://www.google.ba/images/srpr/logo11w.png'),
(2, 'naslov2', '2015-06-15 16:04:20', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora', 'detaljnije2', 'autor2', 'http://www.jpl.nasa.gov/spaceimages/images/mediumsize/PIA17011_ip.jpg'),
(3, 'veve', '2015-06-12 02:55:38', 'bezdetaljnijeg', '', 'huehue', '');

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
