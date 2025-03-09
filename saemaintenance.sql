-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 09 mars 2025 à 22:14
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `saemaintenance`
--

-- --------------------------------------------------------

--
-- Structure de la table `parent_child`
--

CREATE TABLE `parent_child` (
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `parent_child`
--

INSERT INTO `parent_child` (`parent_id`, `child_id`) VALUES
(6, 5);

-- --------------------------------------------------------

--
-- Structure de la table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exercise` varchar(50) NOT NULL,
  `correct` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `history_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `results`
--

INSERT INTO `results` (`id`, `user_id`, `exercise`, `correct`, `total`, `created_at`, `history_link`) VALUES
(15, 5, 'addition', 0, 10, '2025-03-04 08:56:02', './resultats/malou-addition-20250304-085602.txt'),
(16, 5, 'addition', 0, 10, '2025-03-04 09:02:14', './resultats/malou-addition-20250304-090214.txt'),
(17, 5, 'addition', 0, 10, '2025-03-04 09:06:14', './resultats/malou-addition-20250304-090614.txt'),
(19, 5, 'addition', 0, 10, '2025-03-04 09:26:16', '../addition/resultats/malou-addition-20250304-092616.txt'),
(20, 5, 'addition', 1, 10, '2025-03-04 10:14:58', '../addition/resultats/malou-addition-20250304-101458.txt'),
(21, 5, 'addition', 1, 10, '2025-03-04 10:21:28', '../addition/resultats/malou-addition-20250304-102128.txt'),
(22, 5, 'multiplication', 1, 10, '2025-03-05 10:06:39', '../multiplication/resultats/malou-multiplication-20250305-100639.txt'),
(23, 5, 'soustraction', 1, 10, '2025-03-05 10:21:23', '../soustraction/resultats/malou-soustraction-20250305-102123.txt'),
(24, 5, 'conjugaison_verbe', 12, 2, '2025-03-07 07:51:35', '../conjugaison_verbe/resultats/malou-conjugaison_verbe-20250307-075135.txt'),
(25, 5, 'conjugaison_verbe', 6, 2, '2025-03-07 07:55:03', '../conjugaison_verbe/resultats/malou-conjugaison_verbe-20250307-075503.txt'),
(26, 5, 'conjugaison_phrase', 0, 10, '2025-03-07 08:06:34', '../conjugaison_phrase/resultats/malou-conjugaison_phrase-20250307-080634.txt'),
(27, 5, 'conjugaison_phrase', 1, 10, '2025-03-07 08:07:06', '../conjugaison_phrase/resultats/malou-conjugaison_phrase-20250307-080706.txt'),
(28, 5, 'dictee', 1, 10, '2025-03-07 08:23:09', './resultats/malou-dictee-20250307-082309.txt'),
(29, 5, 'multiplication', 1, 10, '2025-03-07 08:44:52', '../multiplication/resultats/-multiplication-20250307-084452.txt'),
(30, 10, 'conjugaison_verbe', 12, 2, '2025-03-07 14:17:46', '../conjugaison_verbe/resultats/-conjugaison_verbe-20250307-141746.txt'),
(31, 11, 'conjugaison_verbe', 11, 2, '2025-03-07 14:25:18', '../conjugaison_verbe/resultats/-conjugaison_verbe-20250307-142518.txt');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('enfant','enseignant','parent') NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `classe` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `parent_id`, `created_at`, `classe`) VALUES
(5, 'Malou', '$2y$10$sXBLjaK/lKcsE9xc39X6WOCCyDLWAwWRql4E4FgD9CgFoldJtflTu', 'enfant', NULL, '2025-03-03 13:56:16', 'CP'),
(6, 'Mal', '$2y$10$.9SHqSgBy8OheLrUa1yPN./s.jwgl3vc3O2CabGbngQl9HGCznuZq', 'parent', NULL, '2025-03-03 13:56:41', ''),
(8, 'lec', '$2y$10$8FqltAYr6lzVy.TJa29P8ut8goNBKNZiNIRNdD7Y1T8XGCApGhQqi', 'enfant', NULL, '2025-03-05 09:39:57', 'CP'),
(9, 'prof', '$2y$10$MnwvVWWwn4F5cOzOi6hlIeiObFWJkFZzWH7pcyxmR43/c6AFYotz.', 'enseignant', NULL, '2025-03-05 09:48:45', 'CP'),
(10, 'test', '$2y$10$ruDjmymOlkKokQ2Hiwaj6.WX3e02LH0OHxST5ApZhX8qFVNbjqTNa', 'enfant', NULL, '2025-03-07 14:17:15', 'CP'),
(11, 'Malcom', '$2y$10$psAjiBWFUJOpZXboNtjem.QIZyaePrNcNa6VxMpmKITVkILD9U.IK', 'enfant', NULL, '2025-03-07 14:24:23', 'CP');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `parent_child`
--
ALTER TABLE `parent_child`
  ADD PRIMARY KEY (`parent_id`,`child_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Index pour la table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `parent_id` (`parent_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `parent_child`
--
ALTER TABLE `parent_child`
  ADD CONSTRAINT `parent_child_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `parent_child_ibfk_2` FOREIGN KEY (`child_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
