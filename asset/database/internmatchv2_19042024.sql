-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 08:01 PM
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
('erwin.yonata@my.sampoernauniversity.ac.id', '$2y$10$CQ4c8XoHc.ErBOHxaTPG8ehMv6M.IQFxVLYywsKQzDGpw6Ci9r6wu', 'Gojek', 'Gojek is Southeast Asia’s leading on-demand platform and pioneer of the multi-service ecosystem with over 2.5 million driver partners across the regions offering a wide range of services such as transportation, food delivery, logistics and more. With its mission to create impact at scale, Gojek is committed to resolving consumer problems and raising standards of living by connecting consumers to the best providers of goods and services in the market.', '', '', 'Software_it_services', '2010', '1000+', 1);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(100) NOT NULL,
  `recipient_id` varchar(100) NOT NULL,
  `admin_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('erwinwingyonata@gmail.com', '$2y$10$OF01o1NL.I.77iWyWX0EQuUfIEljM4QlYgQt0n3MKV0O3LZ.TkUpa', 'Erwin Yonata', '', '', 1);

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
('6621441a94f8e', 'Data Science (Computer Vision) Intern', 'Jakarta, Indonesia', 'We are looking for a dynamic, energetic intern who is eager to solve a variety of practical deep learning and computer vision tasks arising from different businesses in GoTo Financial. You will be working closely with the KYC data science team and attend daily standups. You will be involved in live production projects and assisting prototype development. THX', 'On-site', 'Full-time', 'Open', 'erwin.yonata@my.sampoernauniversity.ac.id'),
('66214718dcd73', 'Machine Learning Intern', 'Toronto, ON', 'As a Machine Learning Intern, You Will Contribute To Building ML Models Leveraging a Range Of Data Types Including Vision And Other Omics That Will Power a Diverse Range Of Use Cases In Drug Discovery\r\n\r\nThe Team You’ll Join\r\n\r\nYou will be joining Inception Labs, a research and development team within Recursion. This team is a cross-functional group of exceptional biologists, engineers, product managers, machine learning scientists, computational biologists, and data scientists. Together, we are working to prove out novel technologies including new biological assays and data modalities, statistical and ML techniques, and computational approaches for multimodal data. This team works rapidly on a project-by-project basis to either prove or disprove the value and feasibility of these new ideas and approaches.', 'Remote', 'Internship', 'Open', 'erwin.yonata@my.sampoernauniversity.ac.id'),
('6621477d39644', 'AR/VR Intern | Summer 2024', 'Baltimore, MD', 'Gain Real-World Experience: Apply your AR/VR skills to a cutting-edge AI product and build an impressive portfolio.\r\n', 'On-site', 'Temporary', 'Close', 'erwin.yonata@my.sampoernauniversity.ac.id'),
('66215fbd603b5', 'Co-Op/Intern Software Engineer, AI Platform', 'Toronto, ON', 'In 1984, we started out as a team of three engineers. Today, we have grown to become a global organization with over 2000 employees around the world, with a brand-new HQ based in Kanata North in Ottawa. As one of Canada’s Top Employers for Young People (2024), we want to help you take the first step in crafting your career journey.\r\n\r\nAt Kinaxis, we power the world’s supply chains to help preserve the planet’s resources and enrich the human experience. As a global leader in end-to-end supply chain management, we enable supply chain excellence for all industries, with more than 40,000 users in over 100 countries. We are expanding our team as we continue to innovate and revolutionize how we support our customers.', 'Remote', 'Internship', 'Open', 'erwin.yonata@my.sampoernauniversity.ac.id');

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
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

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
