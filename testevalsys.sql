-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2018 at 09:51 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testevalsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `admininfo`
--

CREATE TABLE `admininfo` (
  `username` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admininfo`
--

INSERT INTO `admininfo` (`username`, `name`, `password`) VALUES
('admin1', 'Suras Kumar Nayak', 'surasnayak'),
('admin2', 'Brijesh Kumar', 'brijesh');

-- --------------------------------------------------------

--
-- Table structure for table `assigntable`
--

CREATE TABLE `assigntable` (
  `studentid` varchar(20) NOT NULL,
  `teacherid` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assigntable`
--

INSERT INTO `assigntable` (`studentid`, `teacherid`, `status`) VALUES
('iit2016501', 'phc2016003', 'assigned'),
('iit2016502', 'phc2016002', 'assigned'),
('iit2016503', 'phc2016003', 'assigned'),
('iit2016505', 'phc2016002', 'assigned'),
('iit2016509', 'phc2016001', 'assigned'),
('iit2016510', 'phc2016002', 'assigned'),
('iit2016511', 'phc2016001', 'assigned');

-- --------------------------------------------------------

--
-- Table structure for table `studentans`
--

CREATE TABLE `studentans` (
  `id` int(11) NOT NULL,
  `studid` varchar(20) NOT NULL,
  `examtype` varchar(20) NOT NULL,
  `qno` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `marks` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentans`
--

INSERT INTO `studentans` (`id`, `studid`, `examtype`, `qno`, `image`, `marks`, `remarks`, `status`) VALUES
(1, 'iit2016511', 'midterm', 1, 'profile2.jpg', 5, 'good', 'checked'),
(3, 'iit2016509', 'midterm', 1, 'Screenshot (11).png', 6, 'done', 'checked'),
(4, 'iit2016509', 'midterm', 2, 'Screenshot (10).png', 10, '', 'recheck'),
(5, 'iit2016505', 'midterm', 1, 'Screenshot (17).png', 5, 'good work', 'checked'),
(7, 'iit2016511', 'midterm', 2, 'index.jpg', 4, 'good', 'checked'),
(8, 'iit2016505', 'quiz1', 5, 'Screenshot (28).png', 0, '', 'unchecked'),
(9, 'iit2016509', 'endterm', 1, 'Screenshot (3).png', 0, '', 'checked'),
(10, 'iit2016509', 'quiz2', 1, 'Screenshot (3).png', 12, 'bad', 'checked'),
(11, 'iit2016509', 'quiz1', 1, 'Screenshot (3).png', 5, 'good', 'checked'),
(12, 'iit2016511', 'quiz1', 1, 'Screenshot (33).png', 5, 'bad', 'checked'),
(13, 'iit2016505', 'quiz1', 1, 'Screenshot (33).png', 0, '', 'unchecked'),
(14, 'iit2016501', 'endterm', 2, 'Screenshot (32).png', 0, '', 'unchecked');

-- --------------------------------------------------------

--
-- Table structure for table `studentinfo`
--

CREATE TABLE `studentinfo` (
  `username` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentinfo`
--

INSERT INTO `studentinfo` (`username`, `name`, `password`) VALUES
('iit2016501', 'Neharika Srivastava', 'neharika'),
('iit2016502', 'Satyam Tripathy', 'satyam'),
('iit2016503', 'Nakul Srivastav', 'nakul'),
('iit2016504', 'Manvendra D', 'manvendra'),
('iit2016505', 'Anant Chaturvedi', 'anant'),
('iit2016506', 'Nairit Banerjee', 'nairit'),
('iit2016509', 'Kamal Chaubey', 'kamal'),
('iit2016510', 'Mohammad Aquib', 'aquib'),
('iit2016511', 'Suras Kumar', 'suras');

-- --------------------------------------------------------

--
-- Table structure for table `teacherinfo`
--

CREATE TABLE `teacherinfo` (
  `username` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacherinfo`
--

INSERT INTO `teacherinfo` (`username`, `name`, `password`) VALUES
('phc2016001', 'Kumar Vishvas', 'kumar'),
('phc2016002', 'Prem Ratna', 'prem'),
('phc2016003', 'Ranjan Jain', 'teacher'),
('phc2016004', 'Ridima Singh', 'teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admininfo`
--
ALTER TABLE `admininfo`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `assigntable`
--
ALTER TABLE `assigntable`
  ADD PRIMARY KEY (`studentid`);

--
-- Indexes for table `studentans`
--
ALTER TABLE `studentans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentinfo`
--
ALTER TABLE `studentinfo`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `teacherinfo`
--
ALTER TABLE `teacherinfo`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `studentans`
--
ALTER TABLE `studentans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
