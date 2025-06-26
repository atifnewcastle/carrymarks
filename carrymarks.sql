-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for carrymarks
DROP DATABASE IF EXISTS `carrymarks`;
CREATE DATABASE IF NOT EXISTS `carrymarks` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `carrymarks`;

-- Dumping structure for table carrymarks.class
DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `ClassID` varchar(10) NOT NULL,
  `ClassName` varchar(100) NOT NULL,
  `CourseCode` varchar(20) NOT NULL,
  `LecturerID` varchar(10) DEFAULT NULL,
  `Credits` int(11) DEFAULT NULL,
  `Semester` varchar(20) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  PRIMARY KEY (`ClassID`),
  KEY `LecturerID` (`LecturerID`),
  CONSTRAINT `class_ibfk_1` FOREIGN KEY (`LecturerID`) REFERENCES `lecturer` (`LecturerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table carrymarks.class: ~2 rows (approximately)
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` (`ClassID`, `ClassName`, `CourseCode`, `LecturerID`, `Credits`, `Semester`, `Year`) VALUES
	('MA205', 'Discrete Mathematics', 'MA205', 'L001', 4, 'Fall', 2024),
	('PH101', 'General Physics I', 'PH101', 'L001', 3, 'Spring', 2025);
/*!40000 ALTER TABLE `class` ENABLE KEYS */;

-- Dumping structure for table carrymarks.lecturer
DROP TABLE IF EXISTS `lecturer`;
CREATE TABLE IF NOT EXISTS `lecturer` (
  `LecturerID` varchar(10) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Department` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`LecturerID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table carrymarks.lecturer: ~3 rows (approximately)
/*!40000 ALTER TABLE `lecturer` DISABLE KEYS */;
INSERT INTO `lecturer` (`LecturerID`, `FirstName`, `LastName`, `Email`, `Department`) VALUES
	('L001', 'Alice', 'Smith', 'alice.smith@university.edu', 'Computer Science'),
	('L002', 'Bob', 'Johnson', 'bob.johnson@university.edu', 'Mathematics'),
	('L003', 'Carol', 'Davis', 'carol.davis@university.edu', 'Physics');
/*!40000 ALTER TABLE `lecturer` ENABLE KEYS */;

-- Dumping structure for table carrymarks.marks
DROP TABLE IF EXISTS `marks`;
CREATE TABLE IF NOT EXISTS `marks` (
  `MarkID` int(11) NOT NULL AUTO_INCREMENT,
  `StudentID` varchar(10) NOT NULL,
  `ClassID` varchar(10) NOT NULL,
  `Score` decimal(5,2) DEFAULT NULL,
  `Grade` varchar(2) DEFAULT NULL,
  `MarkDate` date DEFAULT NULL,
  PRIMARY KEY (`MarkID`),
  UNIQUE KEY `StudentID` (`StudentID`,`ClassID`),
  KEY `ClassID` (`ClassID`),
  CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`),
  CONSTRAINT `marks_ibfk_2` FOREIGN KEY (`ClassID`) REFERENCES `class` (`ClassID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table carrymarks.marks: ~0 rows (approximately)
/*!40000 ALTER TABLE `marks` DISABLE KEYS */;
/*!40000 ALTER TABLE `marks` ENABLE KEYS */;

-- Dumping structure for table carrymarks.student
DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `StudentID` varchar(10) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Major` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`StudentID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table carrymarks.student: ~0 rows (approximately)
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
/*!40000 ALTER TABLE `student` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
