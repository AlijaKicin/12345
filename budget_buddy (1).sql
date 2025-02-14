-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2025 at 08:16 PM
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
-- Database: `budget_buddy`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategorije`
--

CREATE TABLE `kategorije` (
  `id` int(11) NOT NULL,
  `naziv` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategorije`
--

INSERT INTO `kategorije` (`id`, `naziv`) VALUES
(1, 'Hrana'),
(5, 'Ostalo'),
(3, 'Plaća'),
(2, 'Stanarina'),
(4, 'Transport');

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `korisnicko_ime` varchar(50) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `tip_korisnika_id` int(11) NOT NULL,
  `datum_registracije` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `korisnicko_ime`, `lozinka`, `tip_korisnika_id`, `datum_registracije`) VALUES
(1, 'alija', '$2y$10$RRLdhrNjt8s8SMzhDrmIbe3KkTOYISVkahS0/.4fjva00PX7j8bl6', 2, '2025-01-16 12:53:10'),
(2, 'alija1', '$2y$10$tslWMey/UijOj0d542TlSeGXMGAkv107o1slOLHzw9Qg7GtH1g4aK', 2, '2025-01-16 12:54:45'),
(3, 'alija123', '$2y$10$KbBQmW2gnyIAQVR3DgRpdeAD4gw4sE2JPJxDnD40oocCQZ4JOqWLa', 2, '2025-01-16 13:06:55'),
(4, 'h', '$2y$10$Jwioi3ZXq7f/cw3JS4GXCuWGPD7L2kKklKGiQJBCdfInC4L/CXFwe', 2, '2025-01-16 13:30:00'),
(5, 'proba', '$2y$10$SduPfVHbBhhckBXuX1I1K.60Sof/c6FxOmBRjPQ/KW5I32YFyAZ62', 2, '2025-01-16 13:34:09'),
(6, 'aaa', '$2y$10$cNwjqXeQcCcaFTU/LJ/Uzu155ggSH3wuJt8nUH0hRQpeFRkrGd/Ia', 2, '2025-01-16 13:35:19'),
(7, 'aaaa', '$2y$10$NvzSdGer9h4BcsfgUw/5i.tdmYGPUcqhIfyjXhyia.6CXvTAjuT.6', 2, '2025-02-04 13:44:24'),
(8, 'Adrian', '$2y$10$88T6fclnCuoTHm/S/lVgGu3POmbBSwnVR2MrWGmQW6bM3qyelU3vS', 2, '2025-02-04 19:48:09');

-- --------------------------------------------------------

--
-- Table structure for table `postavke`
--

CREATE TABLE `postavke` (
  `id` int(11) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  `postavka_key` varchar(50) NOT NULL,
  `postavka_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tip_korisnika`
--

CREATE TABLE `tip_korisnika` (
  `id` int(11) NOT NULL,
  `naziv` enum('Administrator','Korisnik') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tip_korisnika`
--

INSERT INTO `tip_korisnika` (`id`, `naziv`) VALUES
(1, 'Administrator'),
(2, 'Korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `transakcije`
--

CREATE TABLE `transakcije` (
  `id` int(11) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  `kategorija_id` int(11) NOT NULL,
  `iznos` decimal(10,2) NOT NULL,
  `tip` enum('prihod','rashod') NOT NULL,
  `opis` text DEFAULT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategorije`
--
ALTER TABLE `kategorije`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `naziv` (`naziv`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`),
  ADD KEY `tip_korisnika_id` (`tip_korisnika_id`);

--
-- Indexes for table `postavke`
--
ALTER TABLE `postavke`
  ADD PRIMARY KEY (`id`),
  ADD KEY `korisnik_id` (`korisnik_id`);

--
-- Indexes for table `tip_korisnika`
--
ALTER TABLE `tip_korisnika`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transakcije`
--
ALTER TABLE `transakcije`
  ADD PRIMARY KEY (`id`),
  ADD KEY `korisnik_id` (`korisnik_id`),
  ADD KEY `kategorija_id` (`kategorija_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorije`
--
ALTER TABLE `kategorije`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `postavke`
--
ALTER TABLE `postavke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tip_korisnika`
--
ALTER TABLE `tip_korisnika`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transakcije`
--
ALTER TABLE `transakcije`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD CONSTRAINT `korisnici_ibfk_1` FOREIGN KEY (`tip_korisnika_id`) REFERENCES `tip_korisnika` (`id`);

--
-- Constraints for table `postavke`
--
ALTER TABLE `postavke`
  ADD CONSTRAINT `postavke_ibfk_1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnici` (`id`);

--
-- Constraints for table `transakcije`
--
ALTER TABLE `transakcije`
  ADD CONSTRAINT `transakcije_ibfk_1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnici` (`id`),
  ADD CONSTRAINT `transakcije_ibfk_2` FOREIGN KEY (`kategorija_id`) REFERENCES `kategorije` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
