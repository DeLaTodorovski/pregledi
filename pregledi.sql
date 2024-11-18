-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 08:39 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pregledi`
--

-- --------------------------------------------------------

--
-- Table structure for table `nastavnik`
--

CREATE TABLE `nastavnik` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `ime` varchar(255) NOT NULL,
  `prezime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oceni`
--

CREATE TABLE `oceni` (
  `id` int(11) NOT NULL,
  `ocena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oceni`
--

INSERT INTO `oceni` (`id`, `ocena`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `oddelenie`
--

CREATE TABLE `oddelenie` (
  `id` int(11) NOT NULL,
  `oddelenie` varchar(255) NOT NULL,
  `predmeti` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oddelenie`
--

INSERT INTO `oddelenie` (`id`, `oddelenie`, `predmeti`) VALUES
(1, 'прво', '1,2,3,24,25,10,11,12,26'),
(2, 'второ', '1,2,3,24,25,10,11,12,26'),
(3, 'трето', '1,2,3,24,25,10,11,12,26'),
(4, 'четврто', '1,2,3,24,21,23,10,11,12,20'),
(5, 'петто', '1,2,3,24,21,23,10,11,12,20'),
(6, 'шесто', '1,2,3,16,24,21,23,10,11,12,20'),
(7, 'седмо', '1,2,3,16,5,19,18,8,9,10,11,12,20'),
(8, 'осмо', '1,2,3,16,5,6,7,8,9,10,11,12,13,17'),
(9, 'деветто', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15');

-- --------------------------------------------------------

--
-- Table structure for table `pol`
--

CREATE TABLE `pol` (
  `id` int(11) NOT NULL,
  `pol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pol`
--

INSERT INTO `pol` (`id`, `pol`) VALUES
(1, 'машки'),
(2, 'женски');

-- --------------------------------------------------------

--
-- Table structure for table `predmeti`
--

CREATE TABLE `predmeti` (
  `id` int(11) NOT NULL,
  `predmet` varchar(255) NOT NULL,
  `short` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `predmeti`
--

INSERT INTO `predmeti` (`id`, `predmet`, `short`) VALUES
(1, 'Македонски јазик', 'mak'),
(2, 'Математика', 'mat'),
(3, 'Англиски јазик', 'ang'),
(4, 'Француски јазик', 'fra'),
(5, 'Биологија', 'bio'),
(6, 'Хемија', 'hem'),
(7, 'Физика', 'fiz'),
(8, 'Историја', 'ist'),
(9, 'Географија', 'geo'),
(10, 'Музичко образование', 'muz'),
(11, 'Ликовно образование', 'lik'),
(12, 'Физичко образование', 'fzo'),
(13, 'Граѓанско образование', 'gra'),
(14, 'Вештини за живеење', 'ves'),
(15, 'Иновации', 'ino'),
(16, 'Германски', 'ger'),
(17, 'Нашата татковина', 'nast'),
(18, 'Етика', 'etk'),
(19, 'Информатика', 'inf'),
(20, 'Слободен изборен предмет', 'sip'),
(21, 'Техничко и информатика', 'toii'),
(23, 'Историја и општество', 'isio'),
(24, 'Природни науки', 'prnau'),
(25, 'Општество', 'opst'),
(26, 'Слободни активности', 'slak');

-- --------------------------------------------------------

--
-- Table structure for table `ucenici`
--

CREATE TABLE `ucenici` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `nid` int(11) NOT NULL,
  `sesija` varchar(255) NOT NULL,
  `ime` varchar(255) NOT NULL,
  `prezime` varchar(255) NOT NULL,
  `pol` int(11) NOT NULL,
  `opravdani` int(11) NOT NULL,
  `neopravdani` int(11) NOT NULL,
  `oddelenie` int(11) NOT NULL,
  `oceni` text NOT NULL,
  `slabi` int(11) NOT NULL,
  `prosek` decimal(10,0) NOT NULL,
  `datum` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nastavnik`
--
ALTER TABLE `nastavnik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oceni`
--
ALTER TABLE `oceni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oddelenie`
--
ALTER TABLE `oddelenie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol`
--
ALTER TABLE `pol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predmeti`
--
ALTER TABLE `predmeti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ucenici`
--
ALTER TABLE `ucenici`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nastavnik`
--
ALTER TABLE `nastavnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oceni`
--
ALTER TABLE `oceni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `oddelenie`
--
ALTER TABLE `oddelenie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pol`
--
ALTER TABLE `pol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `predmeti`
--
ALTER TABLE `predmeti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ucenici`
--
ALTER TABLE `ucenici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
