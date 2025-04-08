-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 06:38 PM
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
-- Database: `skladiste`
--

-- --------------------------------------------------------

--
-- Table structure for table `imerobe`
--

CREATE TABLE `imerobe` (
  `IdImeRobe` int(11) NOT NULL,
  `ImeRobe` varchar(25) NOT NULL,
  `VrstaRobeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `imerobe`
--

INSERT INTO `imerobe` (`IdImeRobe`, `ImeRobe`, `VrstaRobeId`) VALUES
(1, 'Nema', 1),
(2, 'Cigle', 2),
(3, 'lampe', 4),
(4, 'Mlijeko', 3);

-- --------------------------------------------------------

--
-- Table structure for table `polica`
--

CREATE TABLE `polica` (
  `IdPolica` int(11) NOT NULL,
  `Oznaka` varchar(10) NOT NULL,
  `Zauzetost` tinyint(1) NOT NULL,
  `ZakupacId` int(11) DEFAULT NULL,
  `RobaId` int(11) DEFAULT NULL,
  `VelicinaPoliceId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `polica`
--

INSERT INTO `polica` (`IdPolica`, `Oznaka`, `Zauzetost`, `ZakupacId`, `RobaId`, `VelicinaPoliceId`) VALUES
(1, 'A1', 1, 2, 3, 2),
(2, 'A2', 1, 2, 2, 3),
(3, 'A3', 1, 3, 2, 2),
(4, 'A4', 0, 1, 1, 1),
(6, 'A17', 1, 2, 7, 5);

--
-- Triggers `polica`
--
DELIMITER $$
CREATE TRIGGER `PovecajBrojIznajmljenihPolica` AFTER INSERT ON `polica` FOR EACH ROW BEGIN
    IF NEW.ZakupacId IS NOT NULL THEN
        UPDATE Zakupac
        SET BrojIznajmljenihPolica = BrojIznajmljenihPolica + 1
        WHERE IdZakupac = NEW.ZakupacId;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `roba`
--

CREATE TABLE `roba` (
  `IdRoba` int(11) NOT NULL,
  `RokUpotrebe` datetime DEFAULT NULL,
  `DatumDolaska` datetime DEFAULT NULL,
  `ImeRobeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roba`
--

INSERT INTO `roba` (`IdRoba`, `RokUpotrebe`, `DatumDolaska`, `ImeRobeId`) VALUES
(1, '0000-00-00 00:00:00', '2024-12-01 21:23:12', 1),
(2, '0000-00-00 00:00:00', '2024-12-02 21:23:12', 2),
(3, '0000-00-00 00:00:00', '2024-12-02 21:23:12', 3),
(4, '2024-12-04 21:23:12', '2024-12-01 21:23:12', 4),
(6, NULL, '2024-12-09 12:38:00', 3),
(7, NULL, '2024-12-11 12:39:00', 3),
(8, '2025-01-15 13:02:00', '2025-01-01 13:02:00', 4),
(9, '2024-12-18 13:03:00', '2024-12-18 13:03:00', 4);

-- --------------------------------------------------------

--
-- Table structure for table `velicinapolice`
--

CREATE TABLE `velicinapolice` (
  `IdVelicinaPolice` int(11) NOT NULL,
  `ImeVelicinaPolice` varchar(25) NOT NULL,
  `Cijena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `velicinapolice`
--

INSERT INTO `velicinapolice` (`IdVelicinaPolice`, `ImeVelicinaPolice`, `Cijena`) VALUES
(1, 'Prazno', 0),
(2, 'mala', 3),
(3, 'srednja', 5),
(4, 'velika', 7),
(5, 'jumbo', 10);

-- --------------------------------------------------------

--
-- Table structure for table `vrstarobe`
--

CREATE TABLE `vrstarobe` (
  `IdVrstaRobe` int(11) NOT NULL,
  `ImeVrsteRobe` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vrstarobe`
--

INSERT INTO `vrstarobe` (`IdVrstaRobe`, `ImeVrsteRobe`) VALUES
(1, 'Prazno'),
(2, 'Građa'),
(3, 'Prehrambeni Proizvodi'),
(4, 'Pokućni elementi');

-- --------------------------------------------------------

--
-- Table structure for table `zakupac`
--

CREATE TABLE `zakupac` (
  `IdZakupac` int(11) NOT NULL,
  `Ime` varchar(25) NOT NULL,
  `Prezime` varchar(25) NOT NULL,
  `Kontakt` int(11) NOT NULL,
  `Adresa` varchar(25) NOT NULL,
  `BrojIznajmljenihPolica` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zakupac`
--

INSERT INTO `zakupac` (`IdZakupac`, `Ime`, `Prezime`, `Kontakt`, `Adresa`, `BrojIznajmljenihPolica`) VALUES
(1, 'Prazno', 'Prazno', 0, 'Prazno', 1),
(2, 'Pero', 'Perić', 989723107, 'Lipička 21', 3),
(3, 'Ivan', 'Ivanković', 981112222, 'Pakračka 22', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `imerobe`
--
ALTER TABLE `imerobe`
  ADD PRIMARY KEY (`IdImeRobe`),
  ADD KEY `VrstaRobeId` (`VrstaRobeId`);

--
-- Indexes for table `polica`
--
ALTER TABLE `polica`
  ADD PRIMARY KEY (`IdPolica`),
  ADD KEY `ZakupacId` (`ZakupacId`),
  ADD KEY `VelicinaPoliceId` (`VelicinaPoliceId`),
  ADD KEY `RobaId` (`RobaId`);

--
-- Indexes for table `roba`
--
ALTER TABLE `roba`
  ADD PRIMARY KEY (`IdRoba`),
  ADD KEY `ImeRobeId` (`ImeRobeId`);

--
-- Indexes for table `velicinapolice`
--
ALTER TABLE `velicinapolice`
  ADD PRIMARY KEY (`IdVelicinaPolice`);

--
-- Indexes for table `vrstarobe`
--
ALTER TABLE `vrstarobe`
  ADD PRIMARY KEY (`IdVrstaRobe`);

--
-- Indexes for table `zakupac`
--
ALTER TABLE `zakupac`
  ADD PRIMARY KEY (`IdZakupac`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `imerobe`
--
ALTER TABLE `imerobe`
  MODIFY `IdImeRobe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `polica`
--
ALTER TABLE `polica`
  MODIFY `IdPolica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roba`
--
ALTER TABLE `roba`
  MODIFY `IdRoba` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `velicinapolice`
--
ALTER TABLE `velicinapolice`
  MODIFY `IdVelicinaPolice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vrstarobe`
--
ALTER TABLE `vrstarobe`
  MODIFY `IdVrstaRobe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `zakupac`
--
ALTER TABLE `zakupac`
  MODIFY `IdZakupac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `imerobe`
--
ALTER TABLE `imerobe`
  ADD CONSTRAINT `imerobe_ibfk_1` FOREIGN KEY (`VrstaRobeId`) REFERENCES `vrstarobe` (`IdVrstaRobe`);

--
-- Constraints for table `polica`
--
ALTER TABLE `polica`
  ADD CONSTRAINT `polica_ibfk_1` FOREIGN KEY (`ZakupacId`) REFERENCES `zakupac` (`IdZakupac`),
  ADD CONSTRAINT `polica_ibfk_2` FOREIGN KEY (`VelicinaPoliceId`) REFERENCES `velicinapolice` (`IdVelicinaPolice`),
  ADD CONSTRAINT `polica_ibfk_3` FOREIGN KEY (`RobaId`) REFERENCES `roba` (`IdRoba`);

--
-- Constraints for table `roba`
--
ALTER TABLE `roba`
  ADD CONSTRAINT `roba_ibfk_1` FOREIGN KEY (`ImeRobeId`) REFERENCES `imerobe` (`IdImeRobe`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
