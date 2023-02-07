-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 26 jan. 2023 à 10:51
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `php_exam_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `Article_id` int NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Description` text CHARACTER SET utf8mb4,
  `Price` float NOT NULL,
  `Publication_date` date NOT NULL,
  `User_id` int NOT NULL,
  `Picture_link` text NOT NULL,
  PRIMARY KEY (`Article_id`),
  KEY `article_user` (`User_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `Cart_id` int NOT NULL AUTO_INCREMENT,
  `User_id` int NOT NULL,
  `Article_id` int NOT NULL,
  PRIMARY KEY (`Cart_id`),
  KEY `FOREIGN_User_id` (`User_id`),
  KEY `FOREIGN_Article_id` (`Article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `Invoice_id` int NOT NULL AUTO_INCREMENT,
  `User_id` int NOT NULL,
  `Transaction_date` date NOT NULL,
  `Amount` float NOT NULL,
  `Billing_address` text NOT NULL,
  `Billing_city` text NOT NULL,
  `Billing_postal` text NOT NULL,
  PRIMARY KEY (`Invoice_id`),
  KEY `Invoice_User_id` (`User_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `Stock_id` int NOT NULL AUTO_INCREMENT,
  `Article_id` int NOT NULL,
  `Stock_number` int NOT NULL,
  PRIMARY KEY (`Stock_id`),
  KEY `Stock_Article_id` (`Article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `User_id` int NOT NULL AUTO_INCREMENT,
  `Pseudo` text NOT NULL,
  `Password` text NOT NULL,
  `Mail` text NOT NULL,
  `Solde` float NOT NULL,
  `Profil_picture` text NOT NULL,
  `Role` text NOT NULL,
  PRIMARY KEY (`User_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_user` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FOREIGN_Article_id` FOREIGN KEY (`Article_id`) REFERENCES `article` (`Article_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FOREIGN_User_id` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `Invoice_User_id` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `Stock_Article_id` FOREIGN KEY (`Article_id`) REFERENCES `article` (`Article_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
