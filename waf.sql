-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation time: 12 Paź 2021, 02:28
-- Server Version: 10.1.21-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `waf`
--

-- --------------------------------------------------------

--
-- Table structure for the table `blacklist_clients`
--

CREATE TABLE `blacklist_clients` (
  `id` int(11) NOT NULL,
  `ip` int(11) NOT NULL,
  `reason` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for the table `blacklist_countries`
--

CREATE TABLE `blacklist_countries` (
  `id` int(11) NOT NULL,
  `country` varchar(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for the table `blacklist_sites`
--

CREATE TABLE `blacklist_sites` (
  `id` int(11) NOT NULL,
  `ip` mediumtext COLLATE utf8_bin NOT NULL,
  `hostname` mediumtext COLLATE utf8_bin NOT NULL,
  `domain` mediumtext COLLATE utf8_bin NOT NULL,
  `site_name` mediumtext COLLATE utf8_bin NOT NULL,
  `reason` mediumtext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for the table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `hostname` mediumtext COLLATE utf8_bin NOT NULL,
  `message` mediumtext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Indexes for dumps of tables
--

--
-- Indexes for the table `blacklist_clients`
--
ALTER TABLE `blacklist_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for the table `blacklist_countries`
--
ALTER TABLE `blacklist_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for the table `blacklist_sites`
--
ALTER TABLE `blacklist_sites`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for the table `blacklist_countries`
--
ALTER TABLE `blacklist_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for the table `blacklist_sites`
--
ALTER TABLE `blacklist_sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
