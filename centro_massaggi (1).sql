-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2024 at 11:18 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `centro_massaggi`
--

-- --------------------------------------------------------

--
-- Table structure for table `massaggiatrici`
--

CREATE TABLE `massaggiatrici` (
  `id` int(11) NOT NULL,
  `nome` varchar(10) NOT NULL,
  `eta` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `massaggiatrici`
--

INSERT INTO `massaggiatrici` (`id`, `nome`, `eta`) VALUES
(4, 'pin', 22),
(5, 'kim', 19),
(6, 'zaya', 25);

-- --------------------------------------------------------

--
-- Table structure for table `prestazione`
--

CREATE TABLE `prestazione` (
  `id` int(11) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `costo` varchar(15) NOT NULL,
  `id_massaggiatrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prestazione`
--

INSERT INTO `prestazione` (`id`, `tipo`, `costo`, `id_massaggiatrice`) VALUES
(4, 'massaggio', '20', 5),
(5, 'happyhanding', '50', 4),
(11, 'rinfresco', '15', 6),
(15, 'pompaggio', '33', 5);

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`id`, `nome`, `password`) VALUES
(1, 'messi', '12345'),
(3, 'dome', '789');

-- --------------------------------------------------------

--
-- Table structure for table `utenti_massaggiatrici`
--

CREATE TABLE `utenti_massaggiatrici` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_massaggiatrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `massaggiatrici`
--
ALTER TABLE `massaggiatrici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prestazione`
--
ALTER TABLE `prestazione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ref_massaggiatrice` (`id_massaggiatrice`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utenti_massaggiatrici`
--
ALTER TABLE `utenti_massaggiatrici`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rif_utente` (`id_utente`),
  ADD KEY `rif_massaggiatrice` (`id_massaggiatrice`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `massaggiatrici`
--
ALTER TABLE `massaggiatrici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;

--
-- AUTO_INCREMENT for table `prestazione`
--
ALTER TABLE `prestazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `utenti_massaggiatrici`
--
ALTER TABLE `utenti_massaggiatrici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `prestazione`
--
ALTER TABLE `prestazione`
  ADD CONSTRAINT `ref_massaggiatrice` FOREIGN KEY (`id_massaggiatrice`) REFERENCES `massaggiatrici` (`id`);

--
-- Constraints for table `utenti_massaggiatrici`
--
ALTER TABLE `utenti_massaggiatrici`
  ADD CONSTRAINT `rif_massaggiatrice` FOREIGN KEY (`id_massaggiatrice`) REFERENCES `massaggiatrici` (`id`),
  ADD CONSTRAINT `rif_utente` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
