-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 03 Gru 2018, 13:26
-- Wersja serwera: 10.1.34-MariaDB
-- Wersja PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `types`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `types_types`
--

CREATE TABLE `types_types` (
  `id` int(20) NOT NULL,
  `user` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `matchId` int(30) NOT NULL,
  `matchDate` date NOT NULL,
  `homeTeamName` varchar(200) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `awayTeamName` varchar(200) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `homeTeamType` int(10) NOT NULL,
  `awayTeamType` int(10) NOT NULL,
  `homeTeamResult` int(10) NOT NULL,
  `awayTeamResult` int(10) NOT NULL,
  `status` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `points` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `types_users`
--

CREATE TABLE `types_users` (
  `login` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mailing` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Zastąpiona struktura widoku `types_view_points`
-- (Zobacz poniżej rzeczywisty widok)
--
CREATE TABLE `types_view_points` (
`user` varchar(30)
,`points` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Struktura widoku `types_view_points`
--
DROP TABLE IF EXISTS `types_view_points`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `types_view_points`  AS  select `types_types`.`user` AS `user`,sum(`types_types`.`points`) AS `points` from `types_types` group by `types_types`.`user` ;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `types_types`
--
ALTER TABLE `types_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `types_users`
--
ALTER TABLE `types_users`
  ADD PRIMARY KEY (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `types_types`
--
ALTER TABLE `types_types`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
