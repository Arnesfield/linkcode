-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2018 at 10:56 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linkcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `content`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Best Thesis', '[{\"criterion\":\"Introduction\",\"weight\":10},{\"criterion\":\"Objectives\\/Criteria\",\"weight\":10},{\"criterion\":\"Methodology\",\"weight\":10},{\"criterion\":\"Presentation\",\"weight\":10},{\"criterion\":\"Results\\/Findings\",\"weight\":10},{\"criterion\":\"Flow\\/Balance\",\"weight\":10},{\"criterion\":\"Impact Factor\",\"weight\":10},{\"criterion\":\"Conclusion\",\"weight\":10},{\"criterion\":\"Quest\\/Answer Session\",\"weight\":10}]', 1528391451, 1528391451, 1),
(2, 'Best Mobile Application', '[{\"criterion\":\"Something\",\"weight\":10}]', 1528391451, 1528391451, 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `group_name` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `group_name`, `description`, `created_at`, `updated_at`, `status`) VALUES
(1, 'FORGE: Online Syllabus Generator', '</code>', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sollicitudin egestas eros. Curabitur ac libero ac sapien malesuada congue. Morbi mollis accumsan urna et ultrices. Fusce aliquet sodales fringilla. Fusce tempus, urna ut ullamcorper interdum, libero ante lobortis erat, vitae ullamcorper felis sem id elit. Integer non pellentesque arcu, ut tempor tortor. Aenean iaculis accumsan malesuada. Donec posuere efficitur purus sed consectetur. Ut in neque id dolor sagittis commodo nec eu arcu. Integer diam tortor, varius ac nulla at, ultrices pulvinar ante. Ut pulvinar turpis et felis luctus, sed vulputate augue ullamcorper.', 1528398556, 1528398556, 1),
(2, 'PetEx', 'JC and da boyz', 'Sed accumsan consequat metus eu vestibulum. Vestibulum nec nisl pharetra lacus suscipit mattis. Sed orci libero, feugiat ac ex eu, feugiat rhoncus lectus. Praesent tristique vestibulum justo eu suscipit. Praesent sem lacus, sollicitudin ac consectetur in, pulvinar sed tellus. Donec vel metus metus. Pellentesque tempus massa vel arcu tristique suscipit. Curabitur sollicitudin nisi non augue congue, sit amet pellentesque erat vulputate. Fusce efficitur ut enim in elementum.', 1528398556, 1528398556, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `auth`, `created_at`, `updated_at`, `status`) VALUES
(1, 'John Doeest', 'user1', '$2y$10$gCUowmgbNc/p0JaZON2QZ.7cKXVxn17XH52EaYdAFF.bnU8iqR2PS', '[3]', 0, 1528404370, 1),
(2, 'Admin', 'admin', '$2y$10$bkpoxPsGV9rI/jqY68v2muyEb42Zow9Lfn1/cGNVZQadDx/BoxCW2', '[1]', 0, 0, 1),
(3, 'John Doe', 'user2', '$2y$10$bkpoxPsGV9rI/jqY68v2muyEb42Zow9Lfn1/cGNVZQadDx/BoxCW2', '[3]', 1528403890, 1528403890, 1),
(5, 'Jane Doexx', 'user3', '$2y$10$5VqjCIo2aRRyGB9qPXltpOhL9uBthxYsic3M308diTUJSy20WR6D2', '[3]', 1528404529, 1528404932, 1);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `project_id`, `content`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 1, '[{\"id\":\"1\",\"name\":\"Best Thesis\",\"content\":[{\"criterion\":\"Introduction\",\"weight\":10,\"value\":{\"text\":9}},{\"criterion\":\"Objectives/Criteria\",\"weight\":10,\"value\":{\"text\":10}},{\"criterion\":\"Methodology\",\"weight\":10,\"value\":{\"text\":9}},{\"criterion\":\"Presentation\",\"weight\":10,\"value\":{\"text\":9}},{\"criterion\":\"Results/Findings\",\"weight\":10,\"value\":{\"text\":10}},{\"criterion\":\"Flow/Balance\",\"weight\":10,\"value\":{\"text\":8}},{\"criterion\":\"Impact Factor\",\"weight\":10,\"value\":{\"text\":8}},{\"criterion\":\"Conclusion\",\"weight\":10,\"value\":{\"text\":6}},{\"criterion\":\"Quest/Answer Session\",\"weight\":10,\"value\":{\"text\":6}}],\"created_at\":\"0\",\"updated_at\":\"0\",\"status\":\"1\"}]', 1528372178, 1528372522, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `FULLTEXT_INDEX` (`name`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `projects` ADD FULLTEXT KEY `FULLTEXT_INDEX` (`name`,`group_name`,`description`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);
ALTER TABLE `users` ADD FULLTEXT KEY `FULLTEXT_INDEX` (`name`,`username`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
