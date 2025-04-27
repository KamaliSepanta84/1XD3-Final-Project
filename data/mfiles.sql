-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 27, 2025 at 05:57 AM
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
  `macID` varchar(100) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `filetitle` varchar(200) NOT NULL,
  `coursecode` varchar(100) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `download-number` int(11) NOT NULL DEFAULT 0,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating1` int(11) NOT NULL DEFAULT 0,
  `rating2` int(11) NOT NULL DEFAULT 0,
  `rating3` int(11) NOT NULL DEFAULT 0,
  `rating4` int(11) NOT NULL DEFAULT 0,
  `rating5` int(11) NOT NULL DEFAULT 0,
  `count` int(11) NOT NULL DEFAULT 0,
  `rating` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mfiles`
--

INSERT INTO `mfiles` (`macID`, `filename`, `filetitle`, `coursecode`, `filesize`, `filetype`, `description`, `download-number`, `upload_time`, `rating1`, `rating2`, `rating3`, `rating4`, `rating5`, `count`, `rating`) VALUES
('kamals19', 'A4.pdf', 'Assignment 4 1XC3', '1XC3', 173763, 'application/pdf', 'This is my assignment 4 for the course CompSci 1XC3, which I got a 60% on.', 2, '2025-04-27 09:18:10', 0, 0, 1, 0, 1, 2, 4),
('maden', 'AI and Data_kamals19.pdf', 'AI and Data', '1JC3', 130943, 'application/pdf', 'This is an essay for the course CompSci 1JC3, about AI and Data, which I got 80% on.', 0, '2025-04-27 09:26:08', 0, 0, 0, 1, 0, 1, 4),
('kamals19', 'Assignment-3-Discrete-Math.pdf', 'Assignment 3 Discrete', '1DM3', 2349040, 'application/pdf', 'This is my assignment 3 for the course discrete math, which I got a 90% on.', 0, '2025-04-27 09:18:47', 0, 0, 0, 1, 0, 1, 4),
('kamals19', 'Assignment1.pdf', 'Assignment 1 1XC3', '1XC3', 156967, 'application/pdf', 'This is the assignment 1 for the course CompSci 1XC3, which I got a 87% on.', 0, '2025-04-27 09:34:24', 0, 0, 0, 1, 0, 1, 4),
('maden', 'Assignment3.pdf', 'Assignment 3 1XC3', '1XC3', 306747, 'application/pdf', 'This is my assignment 3 for the course CompSci 1XC3, which I got a 59% on.', 0, '2025-04-27 09:28:30', 0, 0, 1, 0, 0, 1, 3),
('maden', 'Chapter3.pdf', 'Chapter 3 Discrete', '1DM3', 2286641, 'application/pdf', 'This is a pdf of the chapter 3 of the discrete math textbook. I found it useful.', 2, '2025-04-27 09:29:37', 0, 0, 1, 0, 1, 2, 4),
('kamals19', 'childsmath.png', 'Calculus Assignment ', '1ZB3', 122657, 'image/png', 'This is a question on this week\'s calc assignment on childsmath, which was hard.', 0, '2025-04-27 09:21:54', 0, 0, 0, 0, 1, 1, 5),
('kamals19', 'Discrete-Math-Assignment-5.pdf', 'Assignment 5 Discrete', '1DM3', 4973645, 'application/pdf', 'This is my assignment 5 for the course discrete math, which I got a 100% on.', 2, '2025-04-27 09:19:47', 0, 0, 0, 1, 1, 2, 4.5),
('kamals19', 'file1.txt', 'Javascript Text File', '1XD3', 3257, 'text/plain', 'This is just text of my javascript code, which I did for one of my assignments.', 1, '2025-04-27 09:21:08', 0, 0, 0, 2, 0, 2, 4),
('maden', '[Book] Discrete mathematics and its applications (2019)_0.pdf', 'Discrete Math Book', '1DM3', 8729085, 'application/pdf', 'This is a pdf version of the discrete math textbook for this semester, which I found online.', 0, '2025-04-27 09:25:01', 0, 0, 0, 1, 0, 1, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mfiles`
--
ALTER TABLE `mfiles`
  ADD PRIMARY KEY (`filename`),
  ADD KEY `macID` (`macID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
