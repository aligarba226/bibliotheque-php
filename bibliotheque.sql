SET SESSION sql_require_primary_key = 0;
-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 07, 2026 at 04:18 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bibliotheque`
--

-- --------------------------------------------------------

--
-- Table structure for table `lecteurs`
--

CREATE TABLE `lecteurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci, AUTO_INCREMENT=2;

--
-- Dumping data for table `lecteurs`
--

INSERT INTO `lecteurs` (`id`, `nom`, `prenom`, `email`) VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@email.com');

-- --------------------------------------------------------

--
-- Table structure for table `livres`
--

CREATE TABLE `livres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `auteur` varchar(100) NOT NULL,
  `description` text,
  `maison_edition` varchar(100) DEFAULT NULL,
  `nombre_exemplaire` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci, AUTO_INCREMENT=5;

--
-- Dumping data for table `livres`
--

INSERT INTO `livres` (`id`, `titre`, `auteur`, `description`, `maison_edition`, `nombre_exemplaire`) VALUES
(1, 'Le Grand Robert', 'Robert Denis', 'Un dictionnaire complet de la langue française.', 'Éditions Alpha', 5),
(2, 'Le Petit Prince', 'Antoine de Saint-Exupéry', 'Un conte poétique et philosophique.', 'Gallimard', 3),
(3, '1984', 'George Orwell', 'Un roman de science-fiction dystopique.', 'Seuil', 2);

-- --------------------------------------------------------

--
-- Table structure for table `liste_lecture`
--

CREATE TABLE `liste_lecture` (
  `id_livre` int NOT NULL,
  `id_lecteur` int NOT NULL,
  `date_emprunt` date DEFAULT NULL,
  `date_retour` date DEFAULT NULL,
  PRIMARY KEY (`id_livre`,`id_lecteur`),
  KEY `id_lecteur` (`id_lecteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `liste_lecture`
--
ALTER TABLE `liste_lecture`
  ADD CONSTRAINT `liste_lecture_ibfk_1` FOREIGN KEY (`id_livre`) REFERENCES `livres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `liste_lecture_ibfk_2` FOREIGN KEY (`id_lecteur`) REFERENCES `lecteurs` (`id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;