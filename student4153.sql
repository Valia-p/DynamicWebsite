-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 09 Δεκ 2024 στις 14:02:00
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `student4153`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `theme` varchar(100) NOT NULL,
  `mainText` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `announcement`
--

INSERT INTO `announcement` (`id`, `date`, `theme`, `mainText`) VALUES
(26, '2024-12-09', 'Υποβλήθηκε η εργασία 15', 'Η ημερομηνία παράδοσης της εργασίας είναι 2025-01-09'),
(27, '2024-12-09', 'ΕΗΜΕΡΩΣΗ ΓΙΑ ΤΟ ΝΕΟ ΕΞΑΜΗΝΟ', 'Καλησπέρα, λόγω των πρόσφατων καταλήψεων το εαρινό εξάμηνο ενδέχεται να ξεκινήσει μετά το Πάσχα. Να περιμένετε για νεότερη ανακοίνωση. Φιλικά Χ.Α.!\r\n'),
(28, '2024-12-09', 'Υποβλήθηκε η εργασία 16', 'Η ημερομηνία παράδοσης της εργασίας είναι 2025-02-21'),
(29, '2024-12-09', 'Μετακίνηση εαρινού εξαμήνου', 'Με λύπη σας ενημερώνουμε ότι το εαρινό εξάμηνο δεν θα πραγματοποιηθεί φέτος! Συγνώμη.');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `document`
--

CREATE TABLE `document` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` longblob NOT NULL,
  `location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `document`
--

INSERT INTO `document` (`id`, `title`, `description`, `location`) VALUES
(11, 'Βαθμοί Εξέτασης στο μάθημα Εκπαιδευτικά Περιβάλλοντα', 0xcea3cf84cebf20cf80ceb1cf81ceb1cebaceaccf84cf8920ceb1cf81cf87ceb5ceafcebf20cf86ceb1ceafcebdcebfcebdcf84ceb1ceb920cf84ceb120ceb1cf80cebfcf84ceb5cebbceadcf83cebcceb1cf84ceb120cf84ceb7cf8220ceb5cebeceadcf84ceb1cf83ceb7cf822e, 'docFiles/Βαθμοί_ΕΠ.docx'),
(15, 'Βαθμοί Προόδου', 0xcea3cf84cebf20ceadceb3ceb3cf81ceb1cf86cebf20ceb2cf81ceafcf83cebacebfcebdcf84ceb1ceb920cebfceb920ceb2ceb1ceb8cebccebfceaf20cf84ceb9cf8220cf80cf81cebfcf8cceb4cebfcf85, 'docFiles/Βαθμοί_Προόδου.docx');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `homework`
--

CREATE TABLE `homework` (
  `id` int(11) NOT NULL,
  `goals` varchar(300) NOT NULL,
  `location` varchar(200) NOT NULL,
  `deliverable` varchar(300) NOT NULL,
  `deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `homework`
--

INSERT INTO `homework` (`id`, `goals`, `location`, `deliverable`, `deadline`) VALUES
(15, 'Ανάπτυξη Νευρωνικού Δικτύου,  Γραπτή Αναφορά σε word,  Παρουσίαση Εργασίας με PowerPoint', 'homeworkFiles/Νευρωνικά Δικτυα.docx', 'Πηγαίος Κώδικας,  Αναφορά,  Dataset', '2025-01-09'),
(16, 'Δημιουργία στατικού Ιστοχώρου,  Δημιουργία δυναμικού Ιστοχώρου', 'homeworkFiles/2023-24-ERGASIA_partB-HTML-PHP-MySQL1.doc', 'Πηγαίος Κώδικας,  Αναφορά', '2025-02-21');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `user`
--

CREATE TABLE `user` (
  `Όνομα` varchar(30) NOT NULL,
  `Επώνυμο` varchar(30) NOT NULL,
  `Loginame` varchar(50) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Ρόλος` enum('Tutor','Student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `user`
--

INSERT INTO `user` (`Όνομα`, `Επώνυμο`, `Loginame`, `Password`, `Ρόλος`) VALUES
('Fionaa', 'Mauridi', 'fiona@gmail.com', '456', 'Student'),
('Matteo', 'Berattini', 'matteo@gmail.com', '111', 'Tutor'),
('Panoss', 'Makris', 'panos@gmail.com', '789', 'Tutor'),
('Valia', 'Pantelopoulou', 'valia@gmail.com', '123', 'Student');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Loginame`(30));

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT για πίνακα `document`
--
ALTER TABLE `document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT για πίνακα `homework`
--
ALTER TABLE `homework`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
