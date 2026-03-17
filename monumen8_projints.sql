-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2026 at 09:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monumen8_projints`
--
CREATE DATABASE IF NOT EXISTS `monumen8_projints` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `monumen8_projints`;

-- --------------------------------------------------------

--
-- Table structure for table `interest`
--

DROP TABLE IF EXISTS `interest`;
CREATE TABLE IF NOT EXISTS `interest` (
  `personId` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  UNIQUE KEY `idx_person_project` (`personId`,`projectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `interest`:
--

--
-- Dumping data for table `interest`
--

INSERT INTO `interest` (`personId`, `projectId`) VALUES
(1, 1),
(1, 2),
(1, 9),
(1, 15),
(2, 1),
(2, 5),
(2, 20),
(5, 11),
(5, 15),
(5, 16),
(33, 9),
(33, 16);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `person`:
--

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `email`, `lname`, `fname`, `pwd`) VALUES
(1, 'mark.zeiger@gmail.com', 'Zeiger', 'Mark', ''),
(2, 'mdmfoley@comcast.net', 'Foley', 'Dave', ''),
(5, 'bobharrigan@me.com', 'Harrigan', 'Bob', ''),
(11, 'zm8032@gmail.com', 'Zeiger', 'Zoe', ''),
(33, 'diane.zeiger@gmail.com', 'Zeiger', 'Diane', '');

--
-- Triggers `person`
--
DROP TRIGGER IF EXISTS `delete_interest_when_person_deleted`;
DELIMITER $$
CREATE TRIGGER `delete_interest_when_person_deleted` AFTER DELETE ON `person` FOR EACH ROW BEGIN
    DELETE FROM interest WHERE interest.personId = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectPosition` int(11) NOT NULL,
  `projectName` varchar(30) NOT NULL,
  `projectHead` varchar(30) NOT NULL,
  `projectDescription` text NOT NULL DEFAULT '\'\'',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_projectName` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `project`:
--

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `projectPosition`, `projectName`, `projectHead`, `projectDescription`) VALUES
(1, 1, 'Empty Bowls', 'Dave Bailey', 'An evening event where the club provides soup and desserts from local restaurants and entrants can pick up a bowl made by local artists.'),
(2, 2, 'Parade', 'Frank Delalla', 'A July 4th parade in downtown Monumwent. Needed are parade marshals, lineup marshals, and judges for the event.'),
(5, 3, 'Stars of Tomorrow', 'Rich Strom', 'A Sunday afternoon three hour event. Needed are ushers, judges, and ticket takers.'),
(6, 4, 'SLP', 'Mike LuginBuhl', 'To be filled in'),
(9, 5, 'K-News', 'Rich Hicks', 'The K-News is a weekly publication by the club that is a recap of Saturday\'s meeting.'),
(11, 20, 'Peaches', 'Terry McMullen', 'This Saturday peach sale to the public is held at the beginning of August. Needed are people for traffic control, loaders, and checkout persons.'),
(12, 40, 'Rocky Mtn Youth Leadership', 'RF Smith', 'To be filled in'),
(15, 50, 'Harvest of Love', 'Chuck Leggario', 'To be filled in'),
(16, 60, 'Senior Meals', 'Jim Murphy', 'To be filled in'),
(19, 70, 'Salvation Army Bell Ringing', 'Jeff Baker', 'To be filled in'),
(20, 80, 'Sports Pools', 'Dan Lopez', 'To be filled in');

--
-- Triggers `project`
--
DROP TRIGGER IF EXISTS `delete_interest_when_project_deleted`;
DELIMITER $$
CREATE TRIGGER `delete_interest_when_project_deleted` AFTER DELETE ON `project` FOR EACH ROW BEGIN
    DELETE FROM interest WHERE interest.projectId = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_project_person`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_project_person`;
CREATE TABLE IF NOT EXISTS `v_project_person` (
`interest_personId` int(11)
,`interest_projectId` int(11)
,`projectId` int(11)
,`projectName` varchar(30)
,`projectHead` varchar(30)
,`projectPosition` int(11)
,`projectDescription` text
,`personId` int(11)
,`email` varchar(50)
,`lname` varchar(30)
,`fname` varchar(20)
,`pwd` varchar(200)
);

-- --------------------------------------------------------

--
-- Structure for view `v_project_person`
--
DROP TABLE IF EXISTS `v_project_person`;

DROP VIEW IF EXISTS `v_project_person`;
CREATE VIEW `v_project_person`  AS SELECT `interest`.`personId` AS `interest_personId`, `interest`.`projectId` AS `interest_projectId`, `project`.`id` AS `projectId`, `project`.`projectName` AS `projectName`, `project`.`projectHead` AS `projectHead`, `project`.`projectPosition` AS `projectPosition`, `project`.`projectDescription` AS `projectDescription`, `person`.`id` AS `personId`, `person`.`email` AS `email`, `person`.`lname` AS `lname`, `person`.`fname` AS `fname`, `person`.`pwd` AS `pwd` FROM ((`interest` left join `project` on(`project`.`id` = `interest`.`projectId`)) left join `person` on(`interest`.`personId` = `person`.`id`)) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
