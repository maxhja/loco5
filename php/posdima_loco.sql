-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 23, 2015 at 03:08 AM
-- Server version: 5.5.42-37.1
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `posdima_loco`
--

-- --------------------------------------------------------

--
-- Table structure for table `booze`
--

CREATE TABLE IF NOT EXISTS `booze` (
  `id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `booze_type` int(1) NOT NULL DEFAULT '0' COMMENT '1 for beer, 2 for wine , 3 for drink',
  `bottle_size` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `alcool_percentage` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `booze`
--

INSERT INTO `booze` (`id`, `booze_type`, `bottle_size`, `alcool_percentage`, `date`) VALUES
('10152644896586831', 1, '50', '5.0', '2015-05-17 16:52:01'),
('10152644896586831', 2, '30', '12.0', '2015-05-17 16:52:29'),
('10152644896586831', 3, '6', '40.0', '2015-05-17 16:52:32'),
('10152644896586831', 1, '50', '5.0', '2015-05-18 12:43:41'),
('10152644896586831', 3, '6', '40.0', '2015-05-18 12:43:49'),
('10152644896586831', 3, '6', '40.0', '2015-05-18 12:49:47'),
('10152644896586831', 3, '4', '40.0', '2015-05-18 14:48:43'),
('10152644896586831', 1, '50', '5.0', '2015-05-20 13:33:31'),
('10152644896586831', 3, '6', '40.0', '2015-05-20 13:33:34'),
('10152644896586831', 2, '30', '12.0', '2015-05-20 13:33:38'),
('10155397564430187', 1, '33', '5.0', '2015-05-22 16:22:15');

-- --------------------------------------------------------

--
-- Table structure for table `friendship`
--

CREATE TABLE IF NOT EXISTS `friendship` (
  `id` int(11) NOT NULL,
  `from_id` varchar(200) NOT NULL,
  `to_id` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0 for friend request , 1 for friend approved'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friendship`
--

INSERT INTO `friendship` (`id`, `from_id`, `to_id`, `status`) VALUES
(1, '10155397564430187', '10152644896586831', 1),
(2, '10152644896586831', '102877636713258', 0),
(3, '10155397564430187', '10206521854023862', 1),
(4, '10155397564430187', '10206521854023862', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `party_level` int(10) NOT NULL DEFAULT '0',
  `on_party` int(1) NOT NULL DEFAULT '1' COMMENT '1 for home , 0 for party',
  `date` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `longitude` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `gender` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'male',
  `weight` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `party_level`, `on_party`, `date`, `latitude`, `longitude`, `gender`, `weight`) VALUES
('10155397564430187', 'Max HjÃ¤rtstrÃ¶m', 7, 0, '2015-05-22 20:10:29', '59.3365983', '18.072174', 'male', '1'),
('10152644896586831', 'Jonathan Norman', 7, 0, '2015-05-22 17:11:51', '59.3314963', '18.06814', 'male', '75'),
('102877636713258', 'Calle Nor', 0, 1, '', '0', '0', 'male', '1'),
('10206521854023862', 'Ntwari Shyaka Aime', 0, 0, '2015-05-22 15:50:45', '0', '0', 'male', '1'),
('10206281354615811', 'Alino Manzi', 0, 0, '2015-05-22 16:03:08', '-1.9580473', '30.1045016', 'male', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friendship`
--
ALTER TABLE `friendship`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friendship`
--
ALTER TABLE `friendship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
