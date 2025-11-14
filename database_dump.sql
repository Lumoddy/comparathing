-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2025 at 11:30 AM
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
-- Database: `comparathing`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(32) NOT NULL,
  `image_file` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `background` enum('auto','white','black') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `short_name`, `image_file`, `description`, `background`) VALUES
(15290733, 'Toothpick', 'Toothpick', 'toothpick.png', '', 'white'),
(55015215, '20 Dollars', '$20', '20_dollars.png', '', 'white'),
(57380155, 'Samsung S19 (Smart Phone)', 'Samsung S19', 'samsung_s19.png', '', 'white'),
(150830650, 'Mars (Planet)', 'Mars', 'mars.png', '', 'black'),
(165234191, 'Bananas (Normal)', 'Bananas', 'bananas.png', '', 'white'),
(193262856, 'Grain of Salt (Mineral)', 'Grain of Salt', 'grain_of_salt.png', '', 'auto'),
(273947253, 'Volume Slider (UI Control)', 'Volume Slider', 'slider.png', '', 'white'),
(316164750, 'Bananas (Ripe)', 'Ripe Bananas', 'ripe_bananas.png', '', 'white'),
(514367050, 'Computer (Quantum)', 'Quantum Computer', 'quantum_computer.png', '', 'auto'),
(645012791, 'Earth (Planet)', 'Earth', 'earth_planet.png', '', 'black'),
(649875880, 'Pen Ink', 'Pen Ink', 'pen_ink.png', '', 'auto'),
(698109385, 'Cocomelon', 'Cocomelon', 'cocomelon.png', '', 'white'),
(786498073, 'Mercury (Element)', 'Mercury', 'mercury_element.png', '', 'auto'),
(811582339, 'Grass', 'Grass', 'grass.png', '', 'auto'),
(903571351, 'Google (Company)', 'Google', 'google.png', '', 'white'),
(935548063, 'Time', 'Time', 'time.png', '', 'auto'),
(1078557102, 'Trolly Wheel', 'Trolly Wheel', 'trolly_wheel.png', '', 'white'),
(1222910679, 'Car (2020s)', '2020s Car', '2020s_car.png', '', 'auto'),
(1227585861, 'McDonald\'s (Restaurant)', 'McDonald\'s', 'mcdonalds.png', '', 'auto'),
(1582687993, 'You', 'You', '', '', 'auto'),
(1850651900, 'Car (1990s)', '1990s Car', '1990s_car.png', '', 'auto'),
(2003571156, 'Microsoft (Company)', 'Microsoft', 'microsoft.png', '', 'white');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`) VALUES
(2875615, 'test@domain.com', 'test', '$2y$10$p7OfNtD9G4UQjS3DGOnfiuyrLqn9QbazAcvUB41aO//t3MiJAIKZu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `image_file` (`image_file`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
