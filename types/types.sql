-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 24 Wrz 2018, 08:43
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

--
-- Zrzut danych tabeli `types_types`
--

INSERT INTO `types_types` (`id`, `user`, `matchId`, `matchDate`, `homeTeamName`, `awayTeamName`, `homeTeamType`, `awayTeamType`, `homeTeamResult`, `awayTeamResult`, `status`, `points`) VALUES
(24, 'Lucyna', 250718, '2018-09-19', 'Sport Lisboa e Benfica', 'FC Bayern München', 1, 2, 0, 2, 'CLOSED', 1),
(26, 'Lucyna', 250730, '2018-09-19', 'Manchester City FC', 'Olympique Lyonnais', 2, 2, 1, 2, 'CLOSED', 0),
(27, 'Lucyna', 250741, '2018-09-19', 'Real Madrid CF', 'AS Roma', 3, 0, 3, 0, 'CLOSED', 3),
(31, 'Lucyna', 250753, '2018-09-19', 'Valencia CF', 'Juventus FC', 0, 3, 0, 2, 'CLOSED', 1),
(33, 'Lucyna', 250754, '2018-09-19', 'BSC Young Boys', 'Manchester United FC', 0, 3, 0, 3, 'CLOSED', 3),
(36, 'ToNieJa', 250718, '2018-09-19', 'Sport Lisboa e Benfica', 'FC Bayern München', 1, 3, 0, 2, 'CLOSED', 1),
(37, 'ToNieJa', 250730, '2018-09-19', 'Manchester City FC', 'Olympique Lyonnais', 3, 0, 1, 2, 'CLOSED', 0),
(38, 'ToNieJa', 250741, '2018-09-19', 'Real Madrid CF', 'AS Roma', 2, 1, 3, 0, 'CLOSED', 1),
(40, 'ToNieJa', 250753, '2018-09-19', 'Valencia CF', 'Juventus FC', 0, 3, 0, 2, 'CLOSED', 1),
(41, 'ToNieJa', 250754, '2018-09-19', 'BSC Young Boys', 'Manchester United FC', 0, 2, 0, 3, 'CLOSED', 1),
(44, 'VIPantonio', 250717, '2018-09-19', 'AFC Ajax', 'PAE AEK', 2, 1, 3, 0, 'CLOSED', 1),
(45, 'VIPantonio', 250729, '2018-09-19', 'FK Shakhtar Donetsk', 'TSG 1899 Hoffenheim', 2, 1, 2, 2, 'CLOSED', 0),
(46, 'VIPantonio', 250718, '2018-09-19', 'Sport Lisboa e Benfica', 'FC Bayern München', 0, 2, 0, 2, 'CLOSED', 3),
(47, 'VIPantonio', 250730, '2018-09-19', 'Manchester City FC', 'Olympique Lyonnais', 4, 0, 1, 2, 'CLOSED', 0),
(48, 'VIPantonio', 250741, '2018-09-19', 'Real Madrid CF', 'AS Roma', 2, 1, 3, 0, 'CLOSED', 1),
(50, 'VIPantonio', 250753, '2018-09-19', 'Valencia CF', 'Juventus FC', 0, 2, 0, 2, 'CLOSED', 3),
(51, 'VIPantonio', 250754, '2018-09-19', 'BSC Young Boys', 'Manchester United FC', 0, 3, 0, 3, 'CLOSED', 3),
(52, 'Andrzej', 250717, '2018-09-19', 'AFC Ajax', 'PAE AEK', 3, 2, 3, 0, 'CLOSED', 1),
(53, 'Andrzej', 250729, '2018-09-19', 'FK Shakhtar Donetsk', 'TSG 1899 Hoffenheim', 2, 0, 2, 2, 'CLOSED', 0),
(54, 'Andrzej', 250718, '2018-09-19', 'Sport Lisboa e Benfica', 'FC Bayern München', 0, 3, 0, 2, 'CLOSED', 1),
(55, 'Andrzej', 250730, '2018-09-19', 'Manchester City FC', 'Olympique Lyonnais', 2, 1, 1, 2, 'CLOSED', 0),
(56, 'Andrzej', 250741, '2018-09-19', 'Real Madrid CF', 'AS Roma', 2, 1, 3, 0, 'CLOSED', 1),
(58, 'Andrzej', 250753, '2018-09-19', 'Valencia CF', 'Juventus FC', 0, 2, 0, 2, 'CLOSED', 3),
(59, 'Andrzej', 250754, '2018-09-19', 'BSC Young Boys', 'Manchester United FC', 1, 3, 0, 3, 'CLOSED', 1),
(60, 'Lucyna', 250717, '2018-09-19', 'AFC Ajax', 'PAE AEK', 4, 0, 3, 0, 'CLOSED', 1),
(61, 'Lucyna', 250729, '2018-09-19', 'FK Shakhtar Donetsk', 'TSG 1899 Hoffenheim', 2, 0, 2, 2, 'CLOSED', 0),
(62, 'Lucyna', 250742, '2018-09-19', 'FC Viktoria Plzeň', 'PFC CSKA Moskva', 0, 2, 2, 2, 'CLOSED', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `types_users`
--

CREATE TABLE `types_users` (
  `login` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `types_users`
--

INSERT INTO `types_users` (`login`, `password`, `email`) VALUES
('Andrzej', '$2y$10$eAX3itOIcPLOtPiJe9y7seMft3eEYCBsqJE.UaP3eS931wJtnqXxK', 'arudzki@onet.pl'),
('Lucyna', '$2y$10$celuxyL4PCCWkSstVtJc/uhi3uHlVUBUhbQP4EQ4g6a9PNzR.3bfC', 'lrudzka@onet.eu'),
('ToNieJa', '$2y$10$xXTMs8.MRh1vL8XZsIWzXOif0.wBS3qawbGfH.VkzuLrlHyGjPgzy', 'rudzki.maciek@gmail.com'),
('VIPantonio', '$2y$10$O3y.AVnLWwGqPWRt0Lqd8.zTAAvUEcf2K2/iFMjkXsBCbloaEPlnW', 'antek.rudzki@gmail.com');

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
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
