-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 23 mai 2024 à 06:36
-- Version du serveur : 8.2.0
-- Version de PHP : 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cineflix`
--

-- --------------------------------------------------------

--
-- Structure de la table `access_time`
--

DROP TABLE IF EXISTS `access_time`;
CREATE TABLE IF NOT EXISTS `access_time` (
  `date_achat` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(1, 'Action'),
(2, 'Animation'),
(3, 'Aventure'),
(4, 'Biopic'),
(5, 'Comédie'),
(6, 'Comédie Dramatique'),
(7, 'Divers'),
(8, 'Drame'),
(9, 'Epouvante-Horreur'),
(10, 'Famille'),
(11, 'Fantastique'),
(12, 'Guerre'),
(13, 'Historique'),
(14, 'Musical'),
(15, 'Policier'),
(16, 'Romance'),
(17, 'Science Fiction'),
(18, 'Thriller'),
(19, 'Western');

-- --------------------------------------------------------

--
-- Structure de la table `cinema`
--

DROP TABLE IF EXISTS `cinema`;
CREATE TABLE IF NOT EXISTS `cinema` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ville_id` int NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cinema_ville_idx` (`ville_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `cinema`
--

INSERT INTO `cinema` (`id`, `ville_id`, `nom`) VALUES
(12, 11, 'cinéville'),
(13, 1, 'ti hanok'),
(14, 2, 'rex'),
(15, 3, 'la rivière'),
(16, 4, 'le petit bal perdu'),
(17, 5, 'cgr'),
(18, 6, 'cinéma le club'),
(19, 7, 'cinéville'),
(20, 8, 'cinéma le paradis'),
(21, 9, 'rex'),
(22, 10, 'le richemont');

-- --------------------------------------------------------

--
-- Structure de la table `configuration`
--

DROP TABLE IF EXISTS `configuration`;
CREATE TABLE IF NOT EXISTS `configuration` (
  `streaming_deadline` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `exploitation`
--

DROP TABLE IF EXISTS `exploitation`;
CREATE TABLE IF NOT EXISTS `exploitation` (
  `film_id` int NOT NULL,
  `debut` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  PRIMARY KEY (`film_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `exploitation`
--

INSERT INTO `exploitation` (`film_id`, `debut`, `fin`) VALUES
(1, '2024-04-17', '2024-05-22'),
(2, '2024-06-03', '2024-07-25'),
(3, '2024-05-20', '2024-07-10'),
(4, '2024-06-01', '2024-07-20'),
(5, '2024-05-08', '2024-06-30'),
(6, '2024-06-15', '2024-07-02'),
(7, '2024-05-12', '2024-07-19'),
(8, '2024-05-28', '2024-07-05'),
(9, '2024-06-07', '2024-07-18'),
(10, '2024-05-23', '2024-07-15');

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

DROP TABLE IF EXISTS `film`;
CREATE TABLE IF NOT EXISTS `film` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cinema_id` int NOT NULL DEFAULT '0',
  `nom` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `synopsis` longtext,
  `affiche` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `date_sortie` timestamp NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `slug` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_film_cinema_idx` (`cinema_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `film`
--

INSERT INTO `film` (`id`, `cinema_id`, `nom`, `synopsis`, `affiche`, `date_sortie`, `status`, `slug`, `created`, `modified`) VALUES
(1, 15, 'inception', 'Un voleur d\'élite est capable d\'entrer dans les rêves des gens pour voler leurs secrets les plus précieux. Mais lorsqu\'il reçoit une offre pour une tâche impossible, il doit faire face à son plus grand défi.', 'public/img/movies/inception.jpg', '2010-07-15 16:00:00', 1, 'inception', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(2, 14, 'interstellar', 'Dans un futur où la Terre est devenue inhabitable, un groupe d\'explorateurs entreprend un voyage interstellaire pour trouver une nouvelle planète habitable pour l\'humanité.', 'public/img/movies/interstellar.jpg', '2014-11-06 20:00:00', 1, 'interstellar', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(3, 22, 'les evadés', 'Un homme est condamné à tort pour le meurtre de sa femme et est envoyé dans une prison où il se lie d\'amitié avec un détenu plus âgé et commence à planifier son évasion.', 'public/img/movies/shawshank_redemption.jpg', '1994-10-13 16:00:00', 1, 'les_evades', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(4, 17, 'le parrain', 'La saga de la famille Corleone, dirigée par le patriarche Vito Corleone, qui lutte pour maintenir son empire criminel tout en naviguant dans la politique et la violence.', 'public/img/movies/godfather.jpg', '1972-03-23 20:00:00', 1, 'le_parrain', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(5, 19, 'pulp fiction', 'Ce film présente plusieurs histoires entrelacées impliquant des criminels, des boxeurs, des danseurs, des tueurs à gages et des propriétaires de restaurants.', 'public/img/movies/pulp_fiction.jpg', '1994-10-13 16:00:00', 1, 'pulp_fiction', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(6, 21, 'forrest gump', 'L\'histoire d\'un homme simple d\'esprit nommé Forrest Gump, qui se retrouve impliqué dans certains des moments les plus mémorables de l\'histoire américaine.', 'public/img/movies/forrest_gump.jpg', '1994-07-05 16:00:00', 1, 'forrest_gump', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(7, 13, 'the dark knight, le chevalier noir', 'Batman se bat contre le Joker, un criminel sadique qui cherche à semer le chaos à Gotham City.', 'public/img/movies/dark_knight.jpg', '2008-07-17 16:00:00', 1, 'the_dark_knight', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(8, 16, 'fight club', 'Un homme sans nom rencontre un vendeur de savon charismatique et tous deux créent un club de combats clandestins qui prend rapidement une tournure sombre.', 'public/img/movies/fight_club.jpg', '1999-10-14 16:00:00', 1, 'fight_club', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(9, 18, 'the matrix', 'Un programmeur informatique découvre que le monde dans lequel il vit est une simulation contrôlée par des machines, et il se joint à une rébellion pour combattre ces machines.', 'public/img/movies/matrix.jpg', '1999-03-30 16:00:00', 1, 'the_matrix', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(10, 20, 'le seigneur des anneaux : la communauté de l\'anneau', 'Un jeune hobbit nommé Frodo Baggins se lance dans une quête périlleuse pour détruire un anneau magique maléfique et sauver la Terre du Milieu de la tyrannie du Seigneur des Ténèbres Sauron.', 'public/img/movies/lord_fellowship.jpg', '2001-12-18 20:00:00', 1, 'le_seigneur_des_anneaux', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(11, 0, 'le silence des agneaux', 'Une jeune stagiaire du FBI est chargée de solliciter l\'aide du célèbre psychiatre cannibale Hannibal Lecter pour attraper un tueur en série surnommé \"Buffalo Bill\".', 'public/img/movies/silence_lambs.jpg', '1991-02-13 20:00:00', 2, 'le_silence_des_agneaux', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(12, 0, 'inglourious basterds', 'Dans la France occupée par les nazis, un groupe de soldats américains juifs est chargé de terroriser l\'armée allemande en massacrant des soldats nazis et en planifiant un assassinat de masse des hauts responsables nazis.', 'public/img/movies/inglourious_basterds.jpg', '2009-08-20 16:00:00', 0, 'inglourious_basterds', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(13, 0, 'les affranchis', 'L\'ascension et la chute de Henry Hill, un gangster italo-américain, alors qu\'il gravit les échelons de la mafia.', 'public/img/movies/goodfellas.jpg', '1990-09-18 16:00:00', 2, 'les_affranchis', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(14, 0, 'les infiltrés', 'Un policier infiltré dans la mafia et un membre de la mafia infiltré dans la police tentent de découvrir l\'identité de l\'autre tout en naviguant dans les intrigues et les trahisons.', 'public/img/movies/departed.jpg', '2006-10-05 16:00:00', 2, 'les_infiltres', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(15, 0, 'gladiator', 'Après avoir été trahi et laissé pour mort par l\'empereur corrompu de Rome, un ancien général romain se lance dans une quête de vengeance.', 'public/img/movies/gladiator.jpg', '2000-05-04 16:00:00', 2, 'gladiator', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(16, 0, 'la ligne verte', 'Dans une prison de Louisiane pendant les années 1930, un gardien de prison bienveillant découvre que l\'un de ses prisonniers a des pouvoirs surnaturels.', 'public/img/movies/green_mile.jpg', '1999-12-09 20:00:00', 2, 'la_ligne_verte', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(17, 0, 'la liste de schindler', 'L\'histoire vraie d\'Oskar Schindler, un homme d\'affaires allemand qui a sauvé plus de 1 000 juifs pendant l\'Holocauste en les employant dans ses usines.', 'public/img/movies/schindlers_list.jpg', '1993-12-14 20:00:00', 2, 'la_liste_de_schindler', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(18, 0, 'le prestige', 'Deux magiciens rivaux se lancent dans une compétition pour créer le meilleur numéro de magie, mais leurs tentatives pour se surpasser les uns les autres les conduisent à des extrémités dangereuses.', 'public/img/movies/prestige.jpg', '2006-10-19 16:00:00', 2, 'le_prestige', '2024-04-24 10:12:08', '2024-04-24 10:12:08'),
(19, 0, 'seven', 'Deux détectives de police enquêtent sur une série de meurtres inspirés par les sept péchés capitaux, et ils se retrouvent entraînés dans un jeu mortel avec le tueur.', 'public/img/movies/seven.jpg', '1995-09-21 16:00:00', 0, 'seven', '2024-04-24 10:12:08', '2024-04-24 10:12:08');

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
  `user_id` int NOT NULL,
  `adherent_id` varchar(25) NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `numero_voie` int DEFAULT NULL,
  `type_voie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nom_voie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `code_postale` int DEFAULT NULL,
  `ville` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `point` int NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`user_id`, `adherent_id`, `nom`, `prenom`, `date_naissance`, `numero_voie`, `type_voie`, `nom_voie`, `code_postale`, `ville`, `point`, `created`, `modified`) VALUES
(65, '', 'Le Mélinaidre', 'Frédéric', '2024-04-29', 39, 'rue', 'Aimé Césaire', 56400, 'Vannes', 5, '2024-05-03 10:51:23', '2024-05-19 09:55:36'),
(72, '', 'Monzouf', 'Frédéric', NULL, 0, 'qsd', 'qsd', 46545, 'qsd', 0, '2024-05-21 04:39:26', '2024-05-21 04:42:57'),
(73, '', 'Dano', 'Mano', NULL, 40, 'rue', 'Aimé Césaire', 56400, 'vannes', 0, '2024-05-21 18:02:28', '2024-05-21 18:05:05'),
(74, 'CFL_MIJE_5656b9e295', 'Minouz', 'Jean', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2024-05-22 21:37:41', '2024-05-22 21:37:41');

-- --------------------------------------------------------

--
-- Structure de la table `seance`
--

DROP TABLE IF EXISTS `seance`;
CREATE TABLE IF NOT EXISTS `seance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `film_id` int NOT NULL,
  `horaire` time NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_seance_film_idx` (`film_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `seance`
--

INSERT INTO `seance` (`id`, `film_id`, `horaire`, `date`) VALUES
(1, 1, '18:35:00', '2024-07-08'),
(2, 5, '23:30:00', '2024-07-06'),
(3, 3, '19:55:00', '2024-07-13'),
(4, 6, '21:35:00', '2024-07-08'),
(5, 8, '21:40:00', '2024-07-12'),
(6, 4, '17:20:00', '2024-07-02'),
(7, 6, '21:35:00', '2024-07-03'),
(8, 7, '12:55:00', '2024-07-10'),
(9, 4, '22:15:00', '2024-07-06'),
(10, 1, '11:30:00', '2024-07-01'),
(11, 2, '14:05:00', '2024-07-03'),
(12, 8, '14:55:00', '2024-07-08'),
(13, 4, '16:35:00', '2024-07-13'),
(14, 1, '18:50:00', '2024-07-11'),
(15, 6, '12:35:00', '2024-07-12'),
(16, 9, '18:25:00', '2024-07-08'),
(17, 3, '21:10:00', '2024-07-10'),
(18, 2, '18:50:00', '2024-07-07'),
(19, 7, '23:45:00', '2024-07-05'),
(20, 5, '21:15:00', '2024-07-04'),
(21, 10, '20:00:00', '2024-07-14'),
(22, 10, '15:10:00', '2024-07-14'),
(23, 9, '17:10:00', '2024-07-13'),
(24, 9, '22:45:00', '2024-07-08'),
(25, 9, '16:15:00', '2024-07-06'),
(26, 8, '21:25:00', '2024-07-15'),
(27, 8, '12:50:00', '2024-07-11'),
(28, 3, '19:45:00', '2024-07-14'),
(29, 7, '16:25:00', '2024-07-15'),
(30, 6, '15:40:00', '2024-07-12'),
(31, 4, '18:55:00', '2024-07-06'),
(32, 2, '11:30:00', '2024-07-15'),
(33, 7, '16:00:00', '2024-07-07'),
(34, 1, '16:35:00', '2024-07-15'),
(35, 10, '17:35:00', '2024-07-11'),
(36, 5, '14:20:00', '2024-07-07'),
(37, 10, '10:40:00', '2024-07-13'),
(38, 3, '11:10:00', '2024-07-07'),
(39, 2, '16:20:00', '2024-07-09'),
(40, 5, '19:45:00', '2024-07-09');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` int DEFAULT '0',
  `email` varchar(45) DEFAULT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `connect` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_connect` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `role`, `email`, `password_hash`, `token`, `created`, `modified`, `connect`, `last_connect`) VALUES
(65, 2, 'f.lemelinaidre@free.fr', '$2y$10$2a/OuFdJsDLK6rsYU1NZC.UV20R9ffWeLD8PNAZRjENYuVZE5QygK', 'bb0fbe65f45dfb1c2b6fd0a32471e307', '2024-05-03 10:51:23', '2024-05-19 10:28:52', '2024-05-23 03:11:18', '2024-05-03 10:51:23'),
(72, 0, 'max.major.englishbull@gmail.com', '$2y$10$Q3yKxJaR.BZpWYi6hUg3WOCixdsOjvX0OMga4wGIw41jWl1C7VQaG', 'd356758a5a08bcb6c22e175864c18bf0', '2024-05-21 04:39:26', '2024-05-21 04:39:26', '2024-05-21 04:39:26', '2024-05-21 04:39:26'),
(73, 0, 'mano.lalio@monmail.com', '$2y$10$KyYcS1DTCmFXmcFhHn9V2.pekqxiDqsbg808oENTMMxVWMSZ89FSi', '291c591f340d0140cfa72502f8af7de6', '2024-05-21 18:02:28', '2024-05-21 18:02:28', '2024-05-21 18:02:28', '2024-05-21 18:02:28'),
(74, 0, 'minouz_jean@gmail.com', '$2y$10$WuRbc9PQ9nK3phCyahxxCecIMjTwLR6HE5l.HE3XDPI9jYO3V5gKO', '611a5dd654aa8ffa1dd512ca2dd03f93', '2024-05-22 21:37:41', '2024-05-22 21:37:41', '2024-05-22 21:37:41', '2024-05-22 21:37:41');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `nom`) VALUES
(1, 'Auray'),
(2, 'Carnac'),
(3, 'Etel'),
(4, 'Le Palais'),
(5, 'Lanester'),
(6, 'Locminé'),
(7, 'Lorient'),
(8, 'Quiberon'),
(9, 'Pontivy'),
(10, 'Sarzeau'),
(11, 'Vannes');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cinema`
--
ALTER TABLE `cinema`
  ADD CONSTRAINT `fk_cinema_ville` FOREIGN KEY (`ville_id`) REFERENCES `ville` (`id`);

--
-- Contraintes pour la table `exploitation`
--
ALTER TABLE `exploitation`
  ADD CONSTRAINT `fk_exploitation_movie1` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`);

--
-- Contraintes pour la table `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `fk_film_cinema` FOREIGN KEY (`cinema_id`) REFERENCES `cinema` (`id`);

--
-- Contraintes pour la table `seance`
--
ALTER TABLE `seance`
  ADD CONSTRAINT `fk_seance_movie` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`);

DELIMITER $$
--
-- Évènements
--
DROP EVENT IF EXISTS `update_film_status_event`$$
CREATE DEFINER=`root`@`localhost` EVENT `update_film_status_event` ON SCHEDULE EVERY 1 DAY STARTS '2024-05-23 03:21:48' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE film f
INNER JOIN exploitation e ON f.id = e.film_id
SET f.status = 0
WHERE e.fin < CURDATE()
AND f.status = 1$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
