-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2016 at 10:10 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gallery_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `author` varchar(31) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `photo_id`, `author`, `body`) VALUES
(1, 15, 'Chung', 'This is the first try'),
(6, 19, 'Wow', 'Wowow wo w'),
(7, 38, 'wow', 'you can click the picture to select/change the picture(user_image)'),
(8, 39, 'Wow', 'you can click the picture to select/change the picture(user_image), the selected file properties are shown on the right.');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `filename` varchar(255) NOT NULL,
  `alternate_text` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `title`, `caption`, `description`, `filename`, `alternate_text`, `type`, `size`) VALUES
(22, 'Car 16', '', '', 'images-16.jpg', '', 'image/jpeg', 21133),
(23, 'Car 17', '', '', 'images-17.jpg', '', 'image/jpeg', 22792),
(24, 'Car 18', '', '', 'images-18.jpg', '', 'image/jpeg', 27595),
(26, 'Car 01', '', '', 'images-1.jpg', '', 'image/jpeg', 28947),
(27, 'Car 03', '', '', 'images-3.jpg', '', 'image/jpeg', 18096),
(28, 'Car 05', '', '', 'images-5.jpg', '', 'image/jpeg', 33192),
(29, 'Car 06', '', '', 'images-6.jpg', '', 'image/jpeg', 21886),
(30, 'Car 07', '', '', 'images-7.jpg', '', 'image/jpeg', 24140),
(32, 'Car 09', '', '', 'images-9.jpg', '', 'image/jpeg', 21108),
(33, 'Car 11', '', '', 'images-11.jpg', '', 'image/jpeg', 27916),
(34, '', '', '', 'images-44.jpg', '', 'image/jpeg', 29486),
(35, '', '', '', 'images-43.jpg', '', 'image/jpeg', 27955),
(36, 'Dashboard', '', '', 'Admin_Dashboard.jpg', '', 'image/jpeg', 162034),
(37, 'Users', '', '', 'Users.jpg', '', 'image/jpeg', 166190),
(38, 'edit_user page, you can edit/delete a user''s data entry. Also you can click image to select a photo to replace the current one. ', '', '', 'edit_user.jpg', '', 'image/jpeg', 116978),
(39, 'click the user image shown, it pops up this, then you can change the image', '', '', 'arbitarily_switch_user_image.jpg', '', 'image/jpeg', 224522),
(40, 'When you click delete', '', '', 'delete_confirm.jpg', '', 'image/jpeg', 13950),
(41, 'When you confirm the delete', '', '', 'after_delete_a_user.jpg', '', 'image/jpeg', 169075);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `user_image`) VALUES
(23, 'Robin2', '124', 'Robin1', 'Williams', 'images-14.jpg'),
(24, 'Bill', '123', 'Bill', 'Clinton', 'images-12.jpg'),
(26, 'Albert', '123', 'Albert', 'Einstein', 'images-50.jpg'),
(27, 'Thomas', '123', 'Thomas', 'Edison', 'images-40.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
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
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
