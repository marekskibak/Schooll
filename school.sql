-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 31 Mar 2016, 07:33
-- Wersja serwera: 5.5.47-0ubuntu0.14.04.1
-- Wersja PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `school`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Classes`
--

CREATE TABLE IF NOT EXISTS `Classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teacher_id` (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Marks`
--

CREATE TABLE IF NOT EXISTS `Marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `mark` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Students`
--

CREATE TABLE IF NOT EXISTS `Students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `Students`
--

INSERT INTO `Students` (`id`, `name`, `surname`, `birth_date`) VALUES
(1, 'Olek', 'BaÅ‚dyga', '1980-01-23');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `students_classes`
--

CREATE TABLE IF NOT EXISTS `students_classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Teachers`
--

CREATE TABLE IF NOT EXISTS `Teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `wage_per_hour` float(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci AUTO_INCREMENT=1 ;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Classes`
--
ALTER TABLE `Classes`
  ADD CONSTRAINT `Classes_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teachers` (`id`);

--
-- Ograniczenia dla tabeli `Marks`
--
ALTER TABLE `Marks`
  ADD CONSTRAINT `Marks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `Students` (`id`),
  ADD CONSTRAINT `Marks_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `Classes` (`id`);

--
-- Ograniczenia dla tabeli `students_classes`
--
ALTER TABLE `students_classes`
  ADD CONSTRAINT `students_classes_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `Classes` (`id`),
  ADD CONSTRAINT `students_classes_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `Students` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
