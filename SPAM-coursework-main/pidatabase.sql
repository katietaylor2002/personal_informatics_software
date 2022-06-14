-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 24, 2022 at 05:03 PM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pidatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `alcohol`
--

CREATE TABLE `alcohol` (
  `AlcoholType` varchar(25) NOT NULL,
  `UnitsPerMl` double NOT NULL,
  `AlcoholID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alcohol`
--

INSERT INTO `alcohol` (`AlcoholType`, `UnitsPerMl`, `AlcoholID`) VALUES
('4% Beer/Lager/Cider', 0.004092958, 1),
('4.5% Beer/Lager/Cider', 0.00457746478, 2),
('5% Beer/Lager/Cider', 0.00515151515, 3),
('5.5% Beer/Lager/Cider', 0.00545454545, 4),
('Alcopop', 0.00545454545, 5),
('Champagne', 0.012, 6),
('Shot', 0.04, 7),
('Wine', 0.012, 8);

-- --------------------------------------------------------

--
-- Table structure for table `alcoholconsumed`
--

CREATE TABLE `alcoholconsumed` (
  `ConsumeID` int(255) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `UnitsDrunk` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `facts`
--

CREATE TABLE `facts` (
  `FactID` int(255) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `GoalID` int(255) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `DateSet` date NOT NULL,
  `GoalType` varchar(15) NOT NULL,
  `GoalValue` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sleep`
--

CREATE TABLE `sleep` (
  `SleepID` int(255) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `TimeSleep` time NOT NULL,
  `TimeWake` time NOT NULL,
  `NumberOfWakes` int(11) NOT NULL,
  `Quality` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Name` varchar(15) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Email`, `Password`, `Name`, `DateOfBirth`, `Weight`) VALUES
('nick', '$2y$10$Wb44NKb/GoQZJGlMJTI5/OUDQJtcq4ht0wQLh6JdhRcWBOPw0rZ7S', 'nick', '2022-03-24', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alcohol`
--
ALTER TABLE `alcohol`
  ADD PRIMARY KEY (`AlcoholID`);

--
-- Indexes for table `alcoholconsumed`
--
ALTER TABLE `alcoholconsumed`
  ADD PRIMARY KEY (`ConsumeID`);

--
-- Indexes for table `facts`
--
ALTER TABLE `facts`
  ADD PRIMARY KEY (`FactID`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`GoalID`);

--
-- Indexes for table `sleep`
--
ALTER TABLE `sleep`
  ADD PRIMARY KEY (`SleepID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alcohol`
--
ALTER TABLE `alcohol`
  MODIFY `AlcoholID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `alcoholconsumed`
--
ALTER TABLE `alcoholconsumed`
  MODIFY `ConsumeID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facts`
--
ALTER TABLE `facts`
  MODIFY `FactID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goals`
--
ALTER TABLE `goals`
  MODIFY `GoalID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sleep`
--
ALTER TABLE `sleep`
  MODIFY `SleepID` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
