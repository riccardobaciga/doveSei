-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mar 16, 2023 alle 08:26
-- Versione del server: 8.0.30
-- Versione PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_dovesei`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `gpsPosition`
--

DROP TABLE IF EXISTS `gpsPosition`;
CREATE TABLE `gpsPosition` (
  `idUser` mediumint UNSIGNED NOT NULL COMMENT 'User Identificativo',
  `x` float NOT NULL COMMENT 'Longitudine',
  `y` float NOT NULL COMMENT 'Latitudine',
  `z` float NOT NULL COMMENT 'Altezza',
  `v` float NOT NULL COMMENT 'Velocita',
  `t` mediumint NOT NULL COMMENT 'Timestamp',
  `d` smallint NOT NULL COMMENT 'Data AAAAMMGG',
  `l` float NOT NULL COMMENT 'Distanza da punto precedente'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
