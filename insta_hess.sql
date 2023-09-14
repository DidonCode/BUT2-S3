-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 13 sep. 2023 à 12:03
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
-- Base de données : `insta_hess`
--

CREATE DATABASE IF NOT EXISTS insta_hess;
USE insta_hess;

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `grade` int NOT NULL DEFAULT '0',
  `profil` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `follow`
--

DROP TABLE IF EXISTS `follow`;
CREATE TABLE IF NOT EXISTS `follow` (
  `id` int NOT NULL,
  `follower` int NOT NULL,
  `followed` int NOT NULL
) ;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender` int NOT NULL,
  `receiver` int NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `view` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publisher` int NOT NULL,
  `spot` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `contentType` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `like` int NOT NULL,
  `enableComment` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `post_comment`
--

DROP TABLE IF EXISTS `post_comment`;
CREATE TABLE IF NOT EXISTS `post_comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post` int NOT NULL,
  `publisher` int NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `post_like`
--

DROP TABLE IF EXISTS `post_like`;
CREATE TABLE IF NOT EXISTS `post_like` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post` int NOT NULL,
  `account` int NOT NULL,
  `love` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
