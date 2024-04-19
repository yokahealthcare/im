-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2024 at 04:31 PM
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
-- Database: `internmatchv2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`username`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `apply`
--

CREATE TABLE `apply` (
  `apply_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `vacancy_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_account`
--

CREATE TABLE `company_account` (
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `about` varchar(10000) NOT NULL,
  `address` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `industry` varchar(100) NOT NULL,
  `founded` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `verified` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_account`
--

INSERT INTO `company_account` (`email`, `password`, `name`, `about`, `address`, `website`, `industry`, `founded`, `size`, `verified`) VALUES
('erwin.yonata@my.sampoernauniversity.ac.id', '$2y$10$CQ4c8XoHc.ErBOHxaTPG8ehMv6M.IQFxVLYywsKQzDGpw6Ci9r6wu', 'Gojek', 'Gojek is Southeast Asia’s leading on-demand platform and pioneer of the multi-service ecosystem with over 2.5 million driver partners across the regions offering a wide range of services such as transportation, food delivery, logistics and more. With its mission to create impact at scale, Gojek is committed to resolving consumer problems and raising standards of living by connecting consumers to the best providers of goods and services in the market.', '', '', 'Software_it_services', '2010', '1000+', 1),
('work.erwinwingyonata@gmail.com', '$2y$10$LIW2mE3643M0BVDlgGwj2u526dbk2yzmcgpPS8dERph/2pMDP0Cwe', 'TugasKita', 'TugasKita is a cutting-edge education application designed to empower students and educators in Jakarta, Indonesia. Our user-friendly platform provides a dynamic and engaging learning experience, catering to the evolving needs of the modern classroom. Hell', 'Lavenue', 'tugaskita.com', 'Hardware_networking', '2021', '0-10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `about` varchar(10000) NOT NULL,
  `address` varchar(100) NOT NULL,
  `verified` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`email`, `password`, `name`, `about`, `address`, `verified`) VALUES
('erwinwingyonata@gmail.com', '$2y$10$OF01o1NL.I.77iWyWX0EQuUfIEljM4QlYgQt0n3MKV0O3LZ.TkUpa', 'Erwin Yonata', 'Computer Science student with 2 years’ experience as an AI Engineer & Researcher. Experience in the field of computer vision and deep learning and highly interested to have apprenticeship in areas of artificial intelligence, machine learning, deep learning, and docker system architecture.\r\n\r\nI enjoy connecting with new people and exploring exciting opportunities.\r\nFeel free to reach me at\r\nwork.erwinwingyonata@gmail.com', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vacancy`
--

CREATE TABLE `vacancy` (
  `id` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `workplace_type` varchar(100) NOT NULL,
  `job_type` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `company_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vacancy`
--

INSERT INTO `vacancy` (`id`, `title`, `location`, `description`, `workplace_type`, `job_type`, `status`, `company_id`) VALUES
('6621477d39644', 'AR/VR Intern | Summer 2024', 'Baltimore, MD', 'Gain Real-World Experience: Apply your AR/VR skills to a cutting-edge AI product and build an impressive portfolio.\r\n', 'On-site', 'Temporary', 'Close', 'erwin.yonata@my.sampoernauniversity.ac.id'),
('66215fbd603b5', 'Co-Op/Intern Software Engineer, AI Platform', 'Toronto, ON 123', 'In 1984, we started out as a team of three engineers. Today, we have grown to become a global organization with over 2000 employees around the world, with a brand-new HQ based in Kanata North in Ottawa. As one of Canada’s Top Employers for Young People (2024), we want to help you take the first step in crafting your career journey.\r\n\r\nAt Kinaxis, we power the world’s supply chains to help preserve the planet’s resources and enrich the human experience. As a global leader in end-to-end supply chain management, we enable supply chain excellence for all industries, with more than 40,000 users in over 100 countries. We are expanding our team as we continue to innovate and revolutionize how we support our customers.', 'On-site', 'Full-time', 'Open', 'erwin.yonata@my.sampoernauniversity.ac.id'),
('66227959ddf4b', 'Education Specialist', 'Jakarta, Indonesia', 'TugasKita is a leading education application company in Jakarta, Indonesia. We are searching for a talented and enthusiastic Education Specialist to join our growing team. In this role, you will play a vital part in developing and implementing creative learning materials and strategies for our educational platform.\r\n\r\nResponsibilities:\r\n\r\nCollaborate with instructional designers and curriculum developers to craft compelling and informative content for TugasKita educational app.\r\nResearch and develop effective teaching methods that leverage the unique affordances of our digital platform.', 'Hybrid', 'Full-time', 'Open', 'work.erwinwingyonata@gmail.com'),
('662279b96f4c8', 'Machine Learning Engineer Intern', 'Poway, CA', 'General Atomics Aeronautical Systems, Inc. (GA-ASI), an affiliate of General Atomics, is a world leader in proven, reliable remotely piloted aircraft and tactical reconnaissance radars, as well as advanced high-resolution surveillance systems.\r\n\r\nThis position is available for undergraduate students to participate in supervised practical training in a professional technical field, such as Computer Sciences, including Software Development/Engineering, Information Technology, Manufacturing, etc. Assists in the completion of routine and non-routine tasks; assists in the analysis, investigation and solution of problems; and assists in developing electronic and hard copy documentation as required. Under general supervision, working on routine projects with general instruction and non-routine projects with detailed instructions.', 'Hybrid', 'Internship', 'Open', 'work.erwinwingyonata@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `apply`
--
ALTER TABLE `apply`
  ADD PRIMARY KEY (`apply_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vacancy_id` (`vacancy_id`);

--
-- Indexes for table `company_account`
--
ALTER TABLE `company_account`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `vacancy`
--
ALTER TABLE `vacancy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apply`
--
ALTER TABLE `apply`
  ADD CONSTRAINT `apply_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`email`),
  ADD CONSTRAINT `apply_ibfk_2` FOREIGN KEY (`vacancy_id`) REFERENCES `vacancy` (`id`);

--
-- Constraints for table `vacancy`
--
ALTER TABLE `vacancy`
  ADD CONSTRAINT `vacancy_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company_account` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
