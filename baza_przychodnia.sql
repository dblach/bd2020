-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 11 Cze 2020, 23:26
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `przychodnia`
--

DELIMITER $$
--
-- Funkcje
--
CREATE DEFINER=`root`@`localhost` FUNCTION `sprawdz_kolizje` (`wizyta_p` TIME, `wizyta_k` TIME, `test_p` TIME, `test_k` TIME) RETURNS TINYINT(1) NO SQL
BEGIN
declare w boolean;
set w=false;
if((test_k>=wizyta_p) or (test_p<=wizyta_k)) then
set w=true;
end if;
return w;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lekarze`
--

CREATE TABLE `lekarze` (
  `id_lekarza` int(11) NOT NULL,
  `imie` varchar(20) NOT NULL,
  `nazwisko` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lekarze`
--

INSERT INTO `lekarze` (`id_lekarza`, `imie`, `nazwisko`) VALUES
(4, 'Adam', 'Nowak'),
(5, 'Jan', 'Krawczyk'),
(6, 'Grzegorz', 'Wojciechowski'),
(7, 'Edyta', 'Michalak'),
(8, 'Maciej', 'Jabłoński');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pacjenci`
--

CREATE TABLE `pacjenci` (
  `id_pacjenta` int(11) NOT NULL,
  `imie` varchar(20) NOT NULL,
  `nazwisko` varchar(20) NOT NULL,
  `adres_ulica` varchar(50) DEFAULT NULL,
  `adres_miasto` varchar(20) DEFAULT NULL,
  `adres_kodpocztowy` varchar(5) DEFAULT NULL,
  `pesel` varchar(11) DEFAULT NULL,
  `telefon` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `pacjenci`
--

INSERT INTO `pacjenci` (`id_pacjenta`, `imie`, `nazwisko`, `adres_ulica`, `adres_miasto`, `adres_kodpocztowy`, `pesel`, `telefon`) VALUES
(1, 'Bronisław', 'Adamski', 'Kaczeńcowa 120', 'Poznań', '60175', '01272369525', '549209453'),
(2, 'Judyta', 'Wieczorek', 'Ciekocka 50', 'Kielce', '25422', '77091521293', '272650323'),
(3, 'Kazimiera', 'Rutkowska', 'Grochowska 115', 'Warszawa', '04368', '94092814436', '936804126'),
(4, 'Barbara', 'Wysocka', 'Sukiennicza 149', 'Kraków', '31069', '86021718401', '93765202'),
(5, 'Marcelina', 'Zawadzka', 'Wyzwolenia 14', 'Poznań', '61204', '61071058888', '10857654'),
(6, 'Miłogost', 'Michalski', 'Falenicka 79', 'Warszawa', '04965', '68040765334', '792893663'),
(7, 'Ziemowit', 'Piotrowski', 'Kościańska 87', 'Wrocław', '54027', '61071503517', '665096104'),
(8, 'Gabriela', 'Olszewska', 'Połczyńska 137', 'Warszawa', '01302', '72101814545', '538410111');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `terminy_przyjec`
--

CREATE TABLE `terminy_przyjec` (
  `id_terminu` int(11) NOT NULL,
  `id_lekarza` int(11) NOT NULL,
  `nazwa_poradni` varchar(20) NOT NULL,
  `dzien_tygodnia` tinyint(4) NOT NULL,
  `godzina_otwarcia` time NOT NULL,
  `godzina_zamkniecia` time NOT NULL,
  `pomieszczenie` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `terminy_przyjec`
--

INSERT INTO `terminy_przyjec` (`id_terminu`, `id_lekarza`, `nazwa_poradni`, `dzien_tygodnia`, `godzina_otwarcia`, `godzina_zamkniecia`, `pomieszczenie`) VALUES
(2, 6, 'pediatryczna', 3, '10:00:00', '12:00:00', '5'),
(3, 6, 'pediatryczna', 5, '09:00:00', '11:30:00', '5'),
(4, 6, 'internistyczna', 2, '08:00:00', '10:00:00', '3'),
(5, 4, 'internistyczna', 1, '13:00:00', '15:00:00', '2'),
(6, 4, 'internistyczna', 2, '09:00:00', '12:00:00', '2'),
(7, 4, 'internistyczna', 5, '14:00:00', '16:00:00', '2'),
(8, 7, 'laryngologiczna', 2, '09:00:00', '10:30:00', '2'),
(9, 5, 'medycyny pracy', 5, '14:00:00', '16:30:00', '1'),
(10, 6, 'medycyny pracy', 2, '11:00:00', '13:00:00', '6'),
(11, 6, 'pediatryczna', 1, '12:00:00', '14:00:00', '5');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `urlopy`
--

CREATE TABLE `urlopy` (
  `id_urlopu` int(11) NOT NULL,
  `id_lekarza` int(11) NOT NULL,
  `data_rozpoczecia` date NOT NULL,
  `data_zakonczenia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wizyty`
--

CREATE TABLE `wizyty` (
  `id_wizyty` int(11) NOT NULL,
  `id_lekarza` int(11) NOT NULL,
  `id_pacjenta` int(11) NOT NULL,
  `data` date NOT NULL,
  `godzina_rozpoczecia` time NOT NULL,
  `godzina_zakonczenia` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `wizyty`
--

INSERT INTO `wizyty` (`id_wizyty`, `id_lekarza`, `id_pacjenta`, `data`, `godzina_rozpoczecia`, `godzina_zakonczenia`) VALUES
(1, 6, 2, '2020-06-02', '11:30:00', '12:00:00'),
(2, 7, 6, '2020-06-02', '09:30:00', '10:00:00'),
(3, 5, 1, '2020-06-05', '14:00:00', '14:30:00'),
(4, 4, 3, '2020-06-05', '15:30:00', '16:00:00'),
(5, 5, 2, '2020-06-02', '11:00:00', '11:30:00'),
(7, 6, 7, '2020-06-02', '12:30:00', '13:00:00'),
(11, 6, 5, '2020-06-09', '12:00:00', '12:30:00'),
(12, 6, 3, '2020-06-09', '08:00:00', '08:30:00'),
(14, 4, 1, '1001-01-01', '00:00:00', '00:30:00'),
(15, 6, 1, '2020-06-09', '00:00:00', '00:30:00'),
(16, 4, 1, '0000-00-00', '00:00:00', '00:30:00'),
(17, 4, 1, '1001-01-01', '00:00:00', '00:30:00'),
(18, 4, 1, '1000-01-01', '00:00:00', '00:30:00'),
(19, 4, 1, '2020-06-11', '00:00:00', '00:30:00'),
(21, 7, 1, '2020-06-11', '00:00:00', '00:30:00'),
(22, 5, 1, '2020-06-12', '14:30:00', '15:00:00'),
(23, 5, 2, '2020-06-12', '16:00:00', '16:30:00'),
(24, 7, 7, '2020-06-09', '09:00:00', '09:30:00');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `lekarze`
--
ALTER TABLE `lekarze`
  ADD PRIMARY KEY (`id_lekarza`);

--
-- Indeksy dla tabeli `pacjenci`
--
ALTER TABLE `pacjenci`
  ADD PRIMARY KEY (`id_pacjenta`);

--
-- Indeksy dla tabeli `terminy_przyjec`
--
ALTER TABLE `terminy_przyjec`
  ADD PRIMARY KEY (`id_terminu`),
  ADD KEY `id_lekarza` (`id_lekarza`);

--
-- Indeksy dla tabeli `urlopy`
--
ALTER TABLE `urlopy`
  ADD PRIMARY KEY (`id_urlopu`),
  ADD KEY `id_lekarza` (`id_lekarza`);

--
-- Indeksy dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  ADD PRIMARY KEY (`id_wizyty`),
  ADD KEY `id_lekarza` (`id_lekarza`),
  ADD KEY `id_pacjenta` (`id_pacjenta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `lekarze`
--
ALTER TABLE `lekarze`
  MODIFY `id_lekarza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `pacjenci`
--
ALTER TABLE `pacjenci`
  MODIFY `id_pacjenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `terminy_przyjec`
--
ALTER TABLE `terminy_przyjec`
  MODIFY `id_terminu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `urlopy`
--
ALTER TABLE `urlopy`
  MODIFY `id_urlopu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  MODIFY `id_wizyty` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `terminy_przyjec`
--
ALTER TABLE `terminy_przyjec`
  ADD CONSTRAINT `terminy_przyjec_ibfk_1` FOREIGN KEY (`id_lekarza`) REFERENCES `lekarze` (`id_lekarza`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `urlopy`
--
ALTER TABLE `urlopy`
  ADD CONSTRAINT `urlopy_ibfk_1` FOREIGN KEY (`id_lekarza`) REFERENCES `lekarze` (`id_lekarza`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  ADD CONSTRAINT `wizyty_ibfk_1` FOREIGN KEY (`id_lekarza`) REFERENCES `lekarze` (`id_lekarza`) ON UPDATE CASCADE,
  ADD CONSTRAINT `wizyty_ibfk_2` FOREIGN KEY (`id_pacjenta`) REFERENCES `pacjenci` (`id_pacjenta`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
