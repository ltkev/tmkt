-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 15. Nov 2025 um 15:24
-- Server-Version: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- PHP-Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ltkev_db1`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tm_anmeldung`
--

CREATE TABLE `tm_anmeldung` (
  `AK` varchar(10) NOT NULL,
  `Disziplin` varchar(2) NOT NULL,
  `Startnummer` varchar(2) NOT NULL,
  `Einmarsch` varchar(1) NOT NULL,
  `Verein` varchar(40) NOT NULL,
  `Dateiname` varchar(40) NOT NULL,
  `Mail` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tm_anmeldung`
--
ALTER TABLE `tm_anmeldung`
  ADD PRIMARY KEY (`AK`,`Disziplin`,`Startnummer`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
