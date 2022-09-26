-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 16, 2022 at 09:42 PM
-- Server version: 5.6.13
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project1`
--
CREATE DATABASE IF NOT EXISTS `project1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `project1`;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `PatientID` int(11) NOT NULL AUTO_INCREMENT,
  `PatientAge` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `StagesOfTreatment` int(11) NOT NULL,
  `StageData` date NOT NULL,
  `Result` text,
  `Accuracy` text,
  PRIMARY KEY (`PatientID`),
  KEY `test` (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`PatientID`, `PatientAge`, `UserID`, `StagesOfTreatment`, `StageData`, `Result`, `Accuracy`) VALUES
(1, 63, 55, 3, '2022-07-26', 'PCR', '81'),
(10, 55, 3, 3, '2022-07-26', 'nonPCR', '92'),
(30, 50, 101, 3, '2022-06-01', 'nonPCR', '95'),
(33, 60, 101, 2, '2022-07-12', 'PCR', '81');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `FirstName` varchar(20) NOT NULL,
  `MiddleName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Age` int(11) NOT NULL,
  `PhoneNumbber` int(11) NOT NULL,
  `Email` text NOT NULL,
  `Password` text NOT NULL,
  `Gender` varchar(20) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=106 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`FirstName`, `MiddleName`, `LastName`, `UserID`, `Age`, `PhoneNumbber`, `Email`, `Password`, `Gender`) VALUES
('eman', 'mostafa', 'mohamed', 3, 32, 2147483647, 'eman@gmail.com', '55566533', 'Female'),
('haydey', 'ali', 'khalil', 55, 29, 1118118476, 'haydey@gmail.com', '1234567', 'Female'),
('Ibrahim', 'Adel', 'Mahmoud', 101, 22, 1223355, 'ibrahimadel@gmail.com', '011111123', 'Male'),
('ibrahimm', 'adell', 'Elashafeii', 105, 43, 111252627, 'iaha@gmail.com', '22511222', 'male');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `FK` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
