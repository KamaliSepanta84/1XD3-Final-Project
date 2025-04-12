-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 12, 2025 at 11:12 PM
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
  `macID` varchar(100) DEFAULT NULL,
  `filename` varchar(200) NOT NULL,
  `filetitle` varchar(200) NOT NULL,
  `coursecode` varchar(100) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `rating` float DEFAULT NULL,
  `download-number` int(11) DEFAULT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mfiles`
--

INSERT INTO `mfiles` (`id`, `macID`, `filename`, `filetitle`, `coursecode`, `filesize`, `filetype`, `description`, `rating`, `download-number`, `upload_time`) VALUES
(19, NULL, 'A4.pdf', 'assignment 4', '1XC3', 173763, 'application/pdf', 'hv;k;gug hoih\'oi', NULL, NULL, '2025-04-04 03:13:10'),
(20, 'adam3', 'Lecture_Notes_Week1.pdf', 'Lecture Notes Week 1', '1XC3', 2112453, 'application/pdf', 'Covers intro concepts.', 4.3, 122, '2025-02-01 19:32:10'),
(21, 'bell6', 'Assignment1_Solutions.pdf', 'Assignment 1 Solutions', '1ZA3', 3095233, 'application/pdf', 'Official solutions.', 4.7, 241, '2025-02-03 14:12:33'),
(22, 'chas9', 'Lab_Manual_Week3.zip', 'Lab Manual Week 3', '1DM3', 4023452, 'application/zip', 'Includes all lab files.', 4.2, 311, '2025-01-29 16:44:55'),
(23, 'dian7', 'Study_Guide_Midterm.pdf', 'Midterm Study Guide', '1ZB3', 2778102, 'application/pdf', 'Helpful for revision.', 4.9, 356, '2025-03-02 21:03:14'),
(24, 'emil1', 'Tutorial_Solutions_Week5.pdf', 'Tutorial Week 5', '1B03', 1553124, 'application/pdf', 'Solved problems.', 3.8, 198, '2025-01-23 18:23:05'),
(25, 'feli8', 'Project_Template.zip', 'Project Template', '1XD3', 3250893, 'application/zip', 'Starter files included.', 4, 140, '2025-02-17 15:30:00'),
(26, 'gwen2', 'Lecture_Review_Slides.pdf', 'Review Slides', '1JC3', 1729044, 'application/pdf', 'Good visual summaries.', 4.5, 284, '2025-02-19 20:44:50'),
(27, 'harr7', 'Weekly_Recap_Notes.pdf', 'Weekly Recap Notes', '1MD3', 2120473, 'application/pdf', 'Nice condensed version.', 4.1, 160, '2025-03-01 22:20:30'),
(28, 'ivan4', 'Bonus_Assignment.pdf', 'Bonus Assignment', '1ZA3', 3864002, 'application/pdf', 'Extra practice.', 4.4, 103, '2025-03-11 13:18:00'),
(29, 'juli3', 'Quiz_Preparation_Guide.pdf', 'Quiz Prep Guide', '1XC3', 2960241, 'application/pdf', 'Summarized questions.', 4.6, 189, '2025-03-11 00:11:12'),
(30, 'karl6', 'Final_Review_Package.pdf', 'Final Review Package', '1ZB3', 4311284, 'application/pdf', 'Must-have for finals.', 4.9, 351, '2025-04-01 17:40:00'),
(31, 'lian0', 'Textbook_Summaries.zip', 'Textbook Summaries', '1DM3', 3032881, 'application/zip', 'Condensed textbook notes.', 4.3, 212, '2025-02-20 20:22:44'),
(32, 'milo7', 'Syntax_Practice_Problems.pdf', 'Syntax Practice', '1JC3', 1492456, 'application/pdf', 'Syntax-heavy questions.', 3.9, 134, '2025-02-08 23:10:40'),
(33, 'nate5', 'Assignment3_Hints.pdf', 'Assignment 3 Hints', '1MD3', 1932871, 'application/pdf', 'Helpful for hard parts.', 4.2, 201, '2025-02-28 01:30:00'),
(34, 'oliv9', 'Lab6_Resources.zip', 'Lab 6 Resources', '1B03', 3372131, 'application/zip', 'Everything for Lab 6.', 4.1, 172, '2025-03-05 13:00:00'),
(35, 'pete3', 'Midterm_Review.pdf', 'Midterm Review Notes', '1XD3', 2991842, 'application/pdf', 'Class-approved content.', 4.7, 293, '2025-02-15 22:21:19'),
(36, 'quin8', 'Slides_Week10.pdf', 'Slides Week 10', '1XC3', 2300123, 'application/pdf', 'Used by prof.', 4.3, 221, '2025-03-20 16:15:45'),
(37, 'roby6', 'Assignment4_Complete.pdf', 'Assignment 4', '1ZA3', 3200341, 'application/pdf', 'Fully solved.', 4.6, 311, '2025-03-22 17:00:00'),
(38, 'sara1', 'TA_Notes_Week2.pdf', 'TA Notes Week 2', '1DM3', 1812204, 'application/pdf', 'Well structured.', 3.7, 108, '2025-01-30 14:45:23'),
(39, 'tom3', 'Exam_Tips_Guide.pdf', 'Exam Tips', '1ZB3', 3542087, 'application/pdf', 'Written by 3rd-year.', 4.8, 379, '2025-04-01 12:08:08'),
(40, 'ulla2', 'Assignment_2_Worksheet.pdf', 'Assignment 2 Worksheet', '1JC3', 2698810, 'application/pdf', 'TA-recommended practice.', 4.2, 199, '2025-02-12 17:00:00'),
(41, 'vera5', 'Reference_Code_Snippets.zip', 'Code Snippets', '1MD3', 3124022, 'application/zip', 'For debugging.', 4, 144, '2025-02-25 20:32:01'),
(42, 'will9', 'Lecture_9_PDF.pdf', 'Lecture 9 Slides', '1B03', 1459822, 'application/pdf', 'Nice layout.', 4.3, 188, '2025-02-14 16:00:00'),
(43, 'xavi4', 'Recap_Week_11.pdf', 'Week 11 Recap', '1XD3', 2076400, 'application/pdf', 'Fast to review.', 3.9, 166, '2025-03-13 17:10:10'),
(44, 'yana0', 'Lab_Answers_Week4.zip', 'Lab 4 Answers', '1XC3', 3928042, 'application/zip', 'Answers explained.', 4.5, 218, '2025-03-04 15:20:00'),
(45, 'zack2', 'Reading_List_Summary.pdf', 'Reading Summary', '1ZA3', 2783201, 'application/pdf', 'For quiz prep.', 4, 147, '2025-01-27 17:34:00'),
(46, 'alec5', 'Debugging_Tips.pdf', 'Debugging Tips', '1DM3', 2512090, 'application/pdf', 'Very useful.', 4.6, 232, '2025-02-18 19:14:14'),
(47, 'bree3', 'Final_Project_Notes.zip', 'Project Notes', '1JC3', 3441287, 'application/zip', 'For capstone.', 4.1, 178, '2025-03-16 21:30:00'),
(48, 'cal7', 'Week7_Highlights.pdf', 'Week 7 Highlights', '1MD3', 1982002, 'application/pdf', 'Good for skimming.', 3.8, 127, '2025-03-02 15:45:30'),
(49, 'dian1', 'Notes_Merge_All.pdf', 'All Notes Merged', '1ZB3', 4220081, 'application/pdf', 'Compiled all terms.', 4.7, 294, '2025-04-02 19:20:00'),
(50, 'edw4', 'Formula_Sheet_Final.pdf', 'Final Formula Sheet', '1XC3', 2001344, 'application/pdf', 'Everything in one page.', 4.9, 352, '2025-03-28 23:55:00'),
(51, 'fran8', 'Tutorial_3_Solutions.zip', 'Tutorial 3 Solns', '1XD3', 1892301, 'application/zip', 'Checked by TA.', 4.2, 154, '2025-02-09 15:11:10'),
(52, 'gina6', 'Assignment 5.pdf', 'Assignment 5 Submission', '1DM3', 2770040, 'application/pdf', '100% scored.', 4.4, 207, '2025-03-19 18:33:00'),
(53, 'hana5', 'Slides_Set_6.pdf', 'Lecture Set 6', '1JC3', 2398421, 'application/pdf', 'Visual heavy.', 4, 182, '2025-03-06 16:18:00'),
(54, 'ines7', 'Practice_Midterm.zip', 'Midterm Practice Set', '1ZA3', 3782219, 'application/zip', 'Multiple choice.', 4.3, 260, '2025-02-26 14:00:00'),
(55, 'jack0', 'CodeLab_Solutions.pdf', 'CodeLab Answers', '1ZB3', 2330890, 'application/pdf', 'Straight from lab.', 4.6, 221, '2025-03-07 18:01:00'),
(56, 'kyle2', 'TA_Review_Week8.pdf', 'Week 8 Review', '1B03', 2934012, 'application/pdf', 'Concise and clear.', 4.4, 198, '2025-02-21 15:44:00'),
(57, 'luca4', 'Assignment7_Draft.pdf', 'Draft of Assignment 7', '1MD3', 2130083, 'application/pdf', 'Unsubmitted version.', 3.7, 91, '2025-03-08 17:12:00'),
(58, 'maya3', 'LabFiles_Week9.zip', 'Week 9 Lab Files', '1JC3', 3462011, 'application/zip', 'Includes diagrams.', 4.2, 204, '2025-03-15 20:40:00'),
(59, 'niko6', 'Ref_Sheet_CheatSheet.pdf', 'Ref Sheet', '1XD3', 2804561, 'application/pdf', 'Compact format.', 4.5, 230, '2025-03-18 17:13:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mfiles`
--
ALTER TABLE `mfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `macID` (`macID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mfiles`
--
ALTER TABLE `mfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
