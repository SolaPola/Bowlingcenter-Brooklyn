-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Gegenereerd op: 11 apr 2025 om 08:40
-- Serverversie: 8.3.0
-- PHP-versie: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `examenbowlingd3`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `persoon`
--

DROP TABLE IF EXISTS `persoon`;
CREATE TABLE IF NOT EXISTS `persoon` (
  `Id` int NOT NULL,
  `TypePersoon` varchar(20) NOT NULL,
  `Voornaam` varchar(50) NOT NULL,
  `Tussenvoegsel` varchar(20) DEFAULT NULL,
  `Achternaam` varchar(50) NOT NULL,
  `Roepnaam` varchar(50) DEFAULT NULL,
  `IsVolwassen` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Testdata voor tabel `persoon`
INSERT INTO `persoon` (`Id`, `TypePersoon`, `Voornaam`, `Tussenvoegsel`, `Achternaam`, `Roepnaam`, `IsVolwassen`) VALUES
(1, 'Klant', 'Mazin', NULL, 'Jamil', 'Mazin', 1),
(2, 'Klant', 'Arjan', 'de', 'Ruijter', 'Arjan', 1),
(3, 'Klant', 'Hans', NULL, 'Odijk', 'Hans', 1),
(4, 'Klant', 'Dennis', 'van', 'Wakeren', 'Dennis', 1),
(5, 'Medewerker', 'Wilco', 'Van de', 'Grift', NULL, 1),
(6, 'Gast', 'Tom', NULL, 'Sanders', NULL, 0),
(7, 'Gast', 'Andrew', NULL, 'Sanders', NULL, 0),
(8, 'Gast', 'Julian', NULL, 'Kaldenheuvel', NULL, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reservering`
--

DROP TABLE IF EXISTS `reservering`;
CREATE TABLE IF NOT EXISTS `reservering` (
  `Id` int NOT NULL,
  `PersoonId` int NOT NULL,
  `OpeningstijdId` int NOT NULL,
  `BaanId` int NOT NULL,
  `PakketOptieId` int DEFAULT NULL,
  `ReserveringStatus` varchar(20) NOT NULL,
  `Reserveringsnummer` varchar(20) NOT NULL,
  `Datum` date NOT NULL,
  `AantalUren` int NOT NULL,
  `BeginTijd` time NOT NULL,
  `EindTijd` time NOT NULL,
  `AantalVolwassen` int NOT NULL,
  `AantalKinderen` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `PersoonId` (`PersoonId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Testdata voor tabel `reservering`
INSERT INTO `reservering` (`Id`, `PersoonId`, `OpeningstijdId`, `BaanId`, `PakketOptieId`, `ReserveringStatus`, `Reserveringsnummer`, `Datum`, `AantalUren`, `BeginTijd`, `EindTijd`, `AantalVolwassen`, `AantalKinderen`) VALUES
(1, 1, 2, 8, 1, 'Bevestigd', '2022122000001', '2022-12-20', 1, '15:00', '16:00', 4, 2),
(2, 2, 2, 8, 1, 'Bevestigd', '2022122000002', '2022-12-20', 1, '17:00', '18:00', 4, NULL),
(3, 3, 2, 8, 3, 'Bevestigd', '2022122400003', '2022-12-24', 2, '16:00', '18:00', 4, NULL),
(4, 4, 2, 8, NULL, 'Bevestigd', '2022122700004', '2022-12-27', 2, '17:00', '19:00', 2, NULL),
(5, 5, 2, 8, 1, 'Bevestigd', '2022122800005', '2022-12-28', 1, '14:00', '15:00', 3, NULL),
(6, 5, 2, 8, 1, 'Bevestigd', '2022122800006', '2022-12-28', 2, '19:00', '21:00', 2, NULL);

-- DELIMITER $$

-- CREATE PROCEDURE GetReserveringOverzicht()
-- BEGIN
--     SELECT 
--         p.Voornaam,
--         p.Tussenvoegsel,
--         p.Achternaam,
--         r.Datum,
--         r.AantalUren,
--         r.AantalVolwassen,
--         r.AantalKinderen,
--         r.ReserveringStatus
--     FROM 
--         persoon p
--     INNER JOIN 
--         reservering r
--     ON 
--         p.Id = r.PersoonId;
-- END$$

-- DELIMITER ;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
