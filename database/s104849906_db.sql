-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: ictstu-db1.cc.swin.edu.au
-- Generation Time: Apr 03, 2025 at 02:17 PM
-- Server version: 5.5.68-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s104849906_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `make` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `yom` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `make`, `model`, `price`, `yom`) VALUES
(1, 'Holden', 'Astra', 14000.00, 2009),
(2, 'BMW', 'X3', 35000.00, 2010),
(3, 'Ford', 'Falcon', 39000.00, 2013),
(4, 'Toyota', 'Corolla', 20000.00, 2012),
(5, 'Holden', 'Commodore', 28000.00, 2009);

-- --------------------------------------------------------

--
-- Table structure for table `EOI`
--

CREATE TABLE `EOI` (
  `EOInumber` int(11) NOT NULL,
  `jobRef` char(5) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `dob` varchar(10) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `address` varchar(40) NOT NULL,
  `suburb` varchar(40) NOT NULL,
  `state` varchar(10) NOT NULL,
  `postcode` char(4) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `skills` text,
  `otherSkills` text,
  `status` enum('New','Current','Final') NOT NULL DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `EOI`
--

INSERT INTO `EOI` (`EOInumber`, `jobRef`, `firstName`, `lastName`, `dob`, `gender`, `address`, `suburb`, `state`, `postcode`, `email`, `phone`, `skills`, `otherSkills`, `status`) VALUES
(1, 'CS456', 'Kien', 'Vu', '19/01/2005', 'Male', 'Kieu Mai', 'Hanoi', 'NSW', '1001', 'hashing.bump@gmail.com', '0784758412', 'JavaScript, Others', 'Nodejs', 'New'),
(2, 'CS666', 'Loc', 'Do', '10/02/2005', 'Male', 'Long Bien', 'Ha Noi', 'VIC', '3002', 'locdo@gmail.com', '0945656767', 'HTML, CSS', '', 'Current'),
(3, 'PR123', 'Nam', 'Luu', '15/03/2005', 'Female', 'Tran Binh', 'Hanoi', 'NSW', '2619', 'namluu@gmail.com', '0383874893', 'HTML, CSS', '', 'New'),
(4, 'CS666', 'Hieu', 'Nguyen', '29/05/2005', 'Male', 'Kim Giang', 'Hanoi', 'SA', '5001', 'hieunguyen@gmail.com', '0978452563', 'CSS, Others', 'Reactjs', 'New'),
(5, 'CS456', 'Linh', 'Mai', '10/02/2005', 'Female', 'Thanh Xuan', 'Hanoi', 'TAS', '7005', 'linhmai@gmail.com', '0379846580', 'JavaScript', '', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `jobref` varchar(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `salary` varchar(50) NOT NULL,
  `reports_to` varchar(255) NOT NULL,
  `responsibilities` text NOT NULL,
  `skills` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`jobref`, `title`, `description`, `salary`, `reports_to`, `responsibilities`, `skills`) VALUES
('CS456', 'Cybersecurity Analyst', 'The Cybersecurity Analyst will monitor threats, conduct security audits, and implement protective measures to safeguard systems and data.', '$80,000 - $110,000 per year', 'Security Director', 'Monitor security threats and vulnerabilities\nConduct security audits and assessments\nImplement security protocols and practices\nSecurity Implementation and Maintenance', 'Experience with SIEM tools\nKnowledge of penetration testing\nUnderstanding of encryption methods\nCompliance, Security audits, testing'),
('CS666', 'Web Developer', 'The Web Developer will design, develop, and maintain websites, ensuring responsiveness and security while staying updated with new technologies.', '$75,000 - $120,000 per year', 'Project Manager', 'Develop and maintain responsive web applications\nOptimize website performance and usability\nCollaborate with designers and backend developers\nStay updated with the latest web technologies and trends', 'Proficiency in HTML, CSS, and JavaScript\nUnderstanding of version control systems\nExperience with front-end frameworks/libraries\nAbility to troubleshoot and debug web applications'),
('PR123', 'Software Engineer', 'The Software Engineer will be responsible for designing, developing, and maintaining web applications. This role requires strong problem-solving skills and collaboration with cross-functional teams to deliver high-quality software solutions.', '$60,000 - $80,000 per year', 'Software Development Manager', 'Develop and maintain web applications\nCollaborate with cross-functional teams\nWrite clean, maintainable code\nProgramming languages', 'Proficient in JavaScript and Python\nExperience with frontend frameworks\nKnowledge of RESTful APIs\nContinuous learning');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `attempts` int(11) DEFAULT '0',
  `last_attempt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `username`, `attempts`, `last_attempt`) VALUES
(1, 'Æ°qe', 1, '2025-03-31 16:37:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `full_name`) VALUES
('duongtam', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'Duong Tam'),
('kienvu', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'vu trung kien'),
('luunam', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'Luu Nam'),
('mailinh', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'Mai Linh'),
('Manh', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'Manh'),
('tienloc', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Do Tien Loc'),
('vukien', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'Vu Trung Kien');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `EOI`
--
ALTER TABLE `EOI`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`jobref`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `EOI`
--
ALTER TABLE `EOI`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
