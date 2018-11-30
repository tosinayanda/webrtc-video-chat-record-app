-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2018 at 04:00 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `tags` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `tags`) VALUES
(1, 'Blouse', '{\"colour\": \"white\"}');

-- --------------------------------------------------------

--
-- Table structure for table `conversation`
--

CREATE TABLE `conversation` (
  `Id` int(11) NOT NULL,
  `SenderId` int(11) NOT NULL,
  `ReceiverId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `conversation`
--

INSERT INTO `conversation` (`Id`, `SenderId`, `ReceiverId`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 2, 3),
(4, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `Id` int(11) NOT NULL,
  `convId` int(11) NOT NULL,
  `body` varchar(1024) DEFAULT NULL,
  `created_at` varchar(150) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `delivered` tinyint(1) DEFAULT '0',
  `authorId` int(11) NOT NULL,
  `author` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`Id`, `convId`, `body`, `created_at`, `deleted`, `delivered`, `authorId`, `author`) VALUES
(1, 1, 'The Only wAY To Start A Chat is Surely With a big giant Hello \r\n\r\nWorld!', '20181010', 0, 1, 1, 'phild'),
(2, 1, 'The Only wAY To Start A Chat is Surely With a big giant Hello \r\n\r\nWorld!', '20181010', 0, 1, 1, 'phild'),
(3, 1, 'The Only wAY To Start A Chat is Surely With a big giant Hello \r\n\r\nWorld!', '20181010', 0, 1, 2, 'maryd'),
(4, 2, 'The Only wAY To Start A Chat is Surely With a big giant Hello \r\n\r\nWorld!', '20181010', 0, 1, 1, 'phild'),
(5, 2, 'The Only wAY To Start A Chat is Surely With a big giant Hello \r\n\r\nWorld!', '20181010', 0, 1, 3, 'bobd'),
(6, 3, 'The Only wAY To Start A Chat is Surely With a big giant Hello \r\n\r\nWorld!', '20181010', 0, 1, 2, 'maryd'),
(7, 1, 'Living Things', '20181011', 0, 0, 0, 'maryd'),
(1735, 1, 'Do you know what this is', '20181101', 0, 0, 0, 'phild'),
(1736, 1, 'I do know what this is ,Dear Husband', '20181101', 0, 0, 0, 'maryd'),
(1737, 1, 'It ', '20181101', 0, 0, 0, 'maryd'),
(1738, 1, 'is ', '20181101', 0, 0, 0, 'maryd'),
(1739, 1, 'a hy', '20181101', 0, 0, 0, 'maryd'),
(1740, 1, 'B', '20181101', 0, 0, 0, 'maryd'),
(1741, 1, 'ut', '20181101', 0, 0, 0, 'maryd'),
(1742, 1, 'S', '20181101', 0, 0, 0, 'maryd'),
(1743, 1, 'erio', '20181101', 0, 0, 0, 'maryd'),
(1744, 1, 'u', '20181101', 0, 0, 0, 'maryd'),
(1745, 1, 's', '20181101', 0, 0, 0, 'maryd'),
(1746, 1, 'l', '20181101', 0, 0, 0, 'maryd'),
(1747, 1, 'y', '20181101', 0, 0, 0, 'maryd'),
(1748, 1, 'I know', '20181101', 0, 0, 0, 'phild'),
(1749, 1, 'Nope', '20181101', 0, 0, 0, 'phild'),
(1750, 1, 'dkd', '20181101', 0, 0, 0, 'phild'),
(1751, 1, 'gdg', '20181101', 0, 0, 0, 'phild'),
(1752, 1, 'but', '20181101', 0, 0, 0, 'phild'),
(1753, 1, 'slcc;c;s;', '20181101', 0, 0, 0, 'phild'),
(1754, 1, 'kdkddld', '20181101', 0, 0, 0, 'phild'),
(1755, 1, 'Brethren', '20181101', 0, 0, 0, 'phild'),
(1756, 2, 'Sorry Bro', '20181101', 0, 0, 0, 'phild'),
(1757, 2, 'I anint got nothinh', '20181101', 0, 0, 0, 'phild'),
(1758, 1, 'no', '20181101', 0, 0, 0, 'phild'),
(1759, 1, 'What do you mean', '20181101', 0, 0, 0, 'phild');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Id`, `Name`, `Username`) VALUES
(1, 'Phil UnderWood', 'phild'),
(2, 'Mary UnderWood', 'maryd'),
(3, 'Bob UnderWood', 'bobd'),
(4, 'Joe UnderWood', 'joed'),
(5, 'Julio Cesar', 'julio'),
(6, 'Bruno Cesar', 'bruno'),
(7, 'Cleopatra Cesar', 'cleopat'),
(8, 'Brutus Aurelio', 'brutus');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `author` (`author`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1760;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
