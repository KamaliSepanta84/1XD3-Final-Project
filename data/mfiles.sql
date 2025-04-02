-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 03, 2025 at 12:59 AM
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
-- Database: `kamals19_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `mfiles`
--

CREATE TABLE `mfiles` (
  `id` int(11) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `filetitle` varchar(200) NOT NULL,
  `coursecode` varchar(100) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mfiles`
--

INSERT INTO `mfiles` (`id`, `filename`, `filetitle`, `coursecode`, `filesize`, `filetype`, `description`, `upload_time`) VALUES
(15, 'myImg1.png', 'My Photo', '1JC3', 195465, 'image/png', 'vneknvek;nv[ ejv\'whpev ejvpwjehv njebvu ehiueghiuf h ejgwijeh. dgci egvwu', '2025-04-02 09:42:03'),
(16, 'A4.pdf', 'assignment 4', '1XC3', 173763, 'application/pdf', 'this is the raw file of assignment 4 in 1XC3', '2025-04-02 10:51:44'),
(17, 'A4.pdf', 'kivepnvp', 'knveknvkeneknkevnkenkvnekneknkvnk', 173763, 'application/pdf', 'emv\r\nenm\r\nlnve', '2025-04-02 10:57:59'),
(18, 'AI and Data_kamals19.pdf', 'my research', '1C03', 130943, 'application/pdf', 'jdsg;jwe\'vhwe hfoihe\'if\r\npwoeju', '2025-04-02 11:25:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mfiles`
--
ALTER TABLE `mfiles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mfiles`
--
ALTER TABLE `mfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
