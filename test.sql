-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2025 at 05:47 AM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `sno` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `concern` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`sno`, `name`, `email`, `date`, `concern`) VALUES
(1, 'Anil Khant', 'test123@gmail.com', '2025-06-10', 'This is first note'),
(2, 'Sachin', 'sachin111@gmail.com', '2010-01-01', 'Hello Sachin'),
(17, 'Meet', 'jeet345@gmail.com', '2025-06-10', 'Hello jeet bro...'),
(18, 'Jp', 'jp333@gmail.com', '2025-06-01', 'Where are you from?'),
(19, 'Rohit', 'rrr234@gmail.com', '2025-06-08', 'Why here'),
(21, 'Stewart Ayers', 'napovil@mailinator.com', '2018-02-04', 'Amet nostrum qui ve');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name`) VALUES
(1, 'India'),
(2, 'USA');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `sno` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`sno`, `title`, `description`, `timestamp`) VALUES
(1, 'Buy Books', 'Going to buy a books', '2025-06-10 14:55:36'),
(2, 'Cricket', 'Playing with 11 player', '2025-06-10 15:18:27'),
(3, 'NASA', 'The full form of NASA is National Aeronautics and Space Administration', '2025-06-10 15:21:35'),
(6, 'Birds', 'Birds are flying in the sky2', '2025-06-10 15:45:31'),
(8, 'Quam necessitatibus ', 'Quidem enim eos earu', '2025-06-10 15:49:26'),
(9, 'Quam necessitatibus ', 'Quidem enim eos earu', '2025-06-10 15:49:52'),
(14, 'Quam necessitatibus ', 'Quidem enim eos earu', '2025-06-10 15:56:05'),
(31, 'Quam necessitatibus ', 'Quidem enim eos earu', '2025-06-10 17:51:09'),
(37, 'Hi', 'Non et at aut a blan', '2025-06-11 09:59:06'),
(41, 'Molestiae ', 'Velit nobis ducimus', '2025-06-11 10:27:46'),
(42, 'Molestiae ut animi ', 'Velit nobis ducimus', '2025-06-11 10:41:30'),
(43, 'Molestiae ut animi ', 'Velit nobis ducimus', '2025-06-11 10:42:16'),
(49, 'Nostrum ullam tempor', 'Tenetur dolor aut es', '2025-06-11 10:51:17'),
(50, 'Nostrum ullam tempor', 'Tenetur dolor aut es', '2025-06-11 10:51:24'),
(51, 'Nostrum ullam tempor', 'Tenetur dolor aut es', '2025-06-11 10:51:33'),
(52, 'Nostrum ullam tempor', 'Tenetur dolor aut es', '2025-06-11 10:53:15'),
(53, 'Amet perferendis no', 'Vero praesentium par', '2025-06-11 11:21:36'),
(54, 'Voluptate dolor iste', 'Magni iure voluptate', '2025-06-11 11:32:00'),
(55, 'Voluptate dolor iste', 'Magni iure voluptate', '2025-06-11 11:33:04');

-- --------------------------------------------------------

--
-- Table structure for table `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `age` int(11) NOT NULL CHECK (`age` >= 18),
  `phone` varchar(12) NOT NULL,
  `city` varchar(20) NOT NULL DEFAULT 'Bhavnagar'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `personal`
--

INSERT INTO `personal` (`id`, `name`, `age`, `phone`, `city`) VALUES
(1, 'Anil', 32, '1234567890', ''),
(2, 'Sachin', 20, '9876543210', 'Bhavnagar'),
(4, '', 25, '987654111011', 'Bhavnagar'),
(6, '', 25, '987659898988', 'Bhavnagar'),
(7, '', 30, '222222222222', 'Ahmedabad'),
(9, '', 30, '222226662222', 'Ahmedabad'),
(10, '', 88, '99', 'Bhavnagar'),
(13, 'hi', 55, '1265472652', 'Bhavnagar'),
(14, '', 55, '', 'Bhavnagar');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `company`) VALUES
(1, 'Anil', 10000, 'TCS'),
(2, 'Sachin', 22222, 'L&T'),
(3, 'Jeet', 11111, 'Google');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `state_name`) VALUES
(1, 1, 'Maharashtra'),
(2, 1, 'Gujarat'),
(3, 2, 'California'),
(4, 2, 'Texas');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `age`, `gender`, `country`, `created_at`) VALUES
(1, 'Anil Khant', 23, 'Male', 'India', '2025-06-20 05:54:20'),
(2, 'Sachin', 20, 'Male', 'India', '2025-06-20 06:00:27'),
(3, 'Jeet', 22, 'Male', 'India', '2025-06-20 06:03:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `created_at`) VALUES
(1, 'Anil Khant', 'test111@gmail.com', '$2y$10$jTZn3YjXRQSimuQ2W0khhu.elkY6o9WWx01jLeYvoPX/JjFLFU1jm', '2025-06-11 08:17:41'),
(2, 'Sachin', 'test123@gmail.com', '$2y$10$EcfEd8DpWt/yCouvgLTqb.E9g9beu2S8ekEanAhjUlRF5ugSTI44m', '2025-06-11 08:22:31'),
(3, 'jeet', 'jeet123@gmail.com', '$2y$10$ABkqIgASAcSWj6V/N2Q0/uz1HuynF6i0ecaKXkq/Gvlu4ofG1ibYC', '2025-06-11 08:25:09'),
(22, 'Rooney Anthony', 'kymixydew@mailinator.com', '$2y$10$6DdHtuhQ2PAM2Fmh/z4YqufwKeaVirz.6Ar4Sa9p6sSfawmw3u1lq', '2025-06-20 09:35:39'),
(30, 'Jack Cooper', 'timyh@mailinator.com', '$2y$10$15JoJxr/.ce4OEhYtEcw1.bzp7FdOzEasO15n37D6OI5KaYSJYB.O', '2025-06-20 10:11:07'),
(31, 'Skyler Joyce', 'nymebuqico@mailinator.com', '$2y$10$DOrxig9iKy9VUOcp/L/3LuZpSiFrz/krFTTpzVzIyMtibM8ERctUW', '2025-06-20 10:11:13'),
(32, 'Irma Mcfarland', 'dimysohyb@mailinator.com', '$2y$10$KhXmOiAwAmvJm9b2zO/4r.O4AOQ0utrfJlfQh0HmVO472E.VJe1Vm', '2025-06-20 10:11:17'),
(33, 'Ira Britt', 'xexa@mailinator.com', '$2y$10$.xC4WQG8pS00RfELTNfZC.HxqGJAE/0TUsiumNXEMnS9KecMDvBs.', '2025-06-20 10:11:21'),
(34, 'Pearl Mays', 'naqixydywa@mailinator.com', '$2y$10$HGDj504I8kNCeAdudmlT5u8Ux1pfBt9PNNsU8tm/CKVZCP59sjq5y', '2025-06-20 10:11:25'),
(54, 'Samson Collier', 'bacez@mailinator.com', '$2y$10$RqdCQsGKSIeRori2WM2mW.mSXbs8SBiGJ5hEQ8af9shGtMLSHlDma', '2025-06-24 05:22:30'),
(55, 'Venus Harper', 'kame@mailinator.com', '$2y$10$rfd9K7xM5SldEB/TRpWfHuOhtlqvwtdIdXwdVVw3jJnCQ2pmPZtCu', '2025-06-24 12:34:41');

-- --------------------------------------------------------

--
-- Table structure for table `usersdetail`
--

CREATE TABLE `usersdetail` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `usersdetail`
--

INSERT INTO `usersdetail` (`id`, `name`, `email`, `description`, `photo`, `created_at`) VALUES
(30, 'Anil Khant', 'anil13@gmail.com', 'Hello Anil....', 'Test.JPG', '2025-06-23 10:26:49'),
(31, 'Sachin', 'sachin123@gmail.com', 'Hello Brother', 'img3.jpg', '2025-06-23 10:27:39'),
(33, 'Maggy Stanley', 'ryvydygi@mailinator.com', 'Quo in et cillum', 'img7.jpg', '2025-06-23 10:28:52'),
(35, 'Alden Mayo', 'jegugije@mailinator.com', 'Vitae voluptat ips', 'img1.jpg', '2025-06-23 10:30:00'),
(39, 'Harriet Arnold', 'tuzexisalo@mailinator.com', 'Blanditiis harum ab', 'img5.jpg', '2025-06-23 12:34:40'),
(40, 'Cooper Kent', 'fagemyfyni@mailinator.com', 'Error quia laboriosa', 'img2.jpg', '2025-06-24 04:09:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `usersdetail`
--
ALTER TABLE `usersdetail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `usersdetail`
--
ALTER TABLE `usersdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
