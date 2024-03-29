-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 29 mars 2024 à 22:54
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

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
-- Structure de la table `categorie_fiche`
--

DROP TABLE IF EXISTS `categorie_fiche`;
CREATE TABLE IF NOT EXISTS `categorie_fiche` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fiche_id` int NOT NULL,
  `categories_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categorie_fiche_fiche1_idx` (`fiche_id`),
  KEY `fk_categorie_fiche_categories1_idx` (`categories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categorie_fiche`
--

INSERT INTO `categorie_fiche` (`id`, `fiche_id`, `categories_id`) VALUES
(1, 1, 17),
(2, 1, 18),
(3, 2, 8),
(4, 2, 17),
(5, 3, 8),
(6, 4, 15),
(7, 4, 8),
(8, 5, 8),
(9, 5, 15),
(10, 6, 5),
(11, 6, 8),
(12, 6, 16),
(13, 7, 1),
(14, 7, 18),
(15, 8, 8),
(16, 8, 18),
(17, 9, 1),
(18, 9, 17),
(19, 10, 3),
(20, 10, 11),
(21, 11, 8),
(22, 11, 15),
(23, 11, 18),
(24, 12, 1),
(25, 12, 12),
(26, 13, 8),
(27, 13, 15),
(28, 14, 8),
(29, 14, 15),
(30, 14, 18),
(31, 15, 1),
(32, 15, 3),
(33, 15, 13),
(34, 16, 8),
(35, 16, 11),
(36, 16, 15),
(37, 17, 4),
(38, 17, 8),
(39, 17, 13),
(40, 18, 8),
(41, 18, 18),
(42, 19, 8),
(43, 19, 15),
(44, 19, 18);

-- --------------------------------------------------------

--
-- Structure de la table `cinema`
--

DROP TABLE IF EXISTS `cinema`;
CREATE TABLE IF NOT EXISTS `cinema` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `ville_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cinema_ville1_idx` (`ville_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `cinema`
--

INSERT INTO `cinema` (`id`, `nom`, `ville_id`) VALUES
(12, 'cinéville parc lann', 11),
(13, 'ti hanok', 1),
(14, 'rex', 2),
(15, 'la rivière', 3),
(16, 'le petit bal perdu', 4),
(17, 'cgr lanester', 5),
(18, 'cinéma le club', 6),
(19, 'cinéville lorient', 7),
(20, 'cinéma le paradis', 8),
(21, 'rex', 9),
(22, 'le richemont', 10);

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
  `id` int NOT NULL AUTO_INCREMENT,
  `debut` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `fiche`
--

DROP TABLE IF EXISTS `fiche`;
CREATE TABLE IF NOT EXISTS `fiche` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `synopsis` longtext,
  `affiche` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `date_sortie` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `fiche`
--

INSERT INTO `fiche` (`id`, `nom`, `synopsis`, `affiche`, `date_sortie`, `slug`) VALUES
(1, 'inception', 'Un voleur d\'élite est capable d\'entrer dans les rêves des gens pour voler leurs secrets les plus précieux. Mais lorsqu\'il reçoit une offre pour une tâche impossible, il doit faire face à son plus grand défi.', 'public/img/movies/inception.jpg', '2010-07-15 18:00:00', 'inception'),
(2, 'interstellar', 'Dans un futur où la Terre est devenue inhabitable, un groupe d\'explorateurs entreprend un voyage interstellaire pour trouver une nouvelle planète habitable pour l\'humanité.', 'public/img/movies/interstellar.jpg', '2014-11-06 21:00:00', 'interstellar'),
(3, 'les evadés', 'Un homme est condamné à tort pour le meurtre de sa femme et est envoyé dans une prison où il se lie d\'amitié avec un détenu plus âgé et commence à planifier son évasion.', 'public/img/movies/shawshank_redemption.jpg', '1994-10-13 18:00:00', 'les_evades'),
(4, 'le parrain', 'La saga de la famille Corleone, dirigée par le patriarche Vito Corleone, qui lutte pour maintenir son empire criminel tout en naviguant dans la politique et la violence.', 'public/img/movies/godfather.jpg', '1972-03-23 21:00:00', 'le_parrain'),
(5, 'pulp fiction', 'Ce film présente plusieurs histoires entrelacées impliquant des criminels, des boxeurs, des danseurs, des tueurs à gages et des propriétaires de restaurants.', 'public/img/movies/pulp_fiction.jpg', '1994-10-13 18:00:00', 'pulp_fiction'),
(6, 'forrest gump', 'L\'histoire d\'un homme simple d\'esprit nommé Forrest Gump, qui se retrouve impliqué dans certains des moments les plus mémorables de l\'histoire américaine.', 'public/img/movies/forrest_gump.jpg', '1994-07-05 18:00:00', 'forrest_gump'),
(7, 'the dark knight, le chevalier noir', 'Batman se bat contre le Joker, un criminel sadique qui cherche à semer le chaos à Gotham City.', 'public/img/movies/dark_knight.jpg', '2008-07-17 18:00:00', 'the_dark_knight'),
(8, 'fight club', 'Un homme sans nom rencontre un vendeur de savon charismatique et tous deux créent un club de combats clandestins qui prend rapidement une tournure sombre.', 'public/img/movies/fight_club.jpg', '1999-10-14 18:00:00', 'fight_club'),
(9, 'the matrix', 'Un programmeur informatique découvre que le monde dans lequel il vit est une simulation contrôlée par des machines, et il se joint à une rébellion pour combattre ces machines.', 'public/img/movies/matrix.jpg', '1999-03-30 18:00:00', 'the_matrix'),
(10, 'le seigneur des anneaux : la communauté de l\'anneau', 'Un jeune hobbit nommé Frodo Baggins se lance dans une quête périlleuse pour détruire un anneau magique maléfique et sauver la Terre du Milieu de la tyrannie du Seigneur des Ténèbres Sauron.', 'public/img/movies/lord_fellowship.jpg', '2001-12-18 21:00:00', 'le_seigneur_des_anneaux'),
(11, 'le silence des agneaux', 'Une jeune stagiaire du FBI est chargée de solliciter l\'aide du célèbre psychiatre cannibale Hannibal Lecter pour attraper un tueur en série surnommé \"Buffalo Bill\".', 'public/img/movies/silence_lambs.jpg', '1991-02-13 21:00:00', 'le_silence_des_agneaux'),
(12, 'inglourious basterds', 'Dans la France occupée par les nazis, un groupe de soldats américains juifs est chargé de terroriser l\'armée allemande en massacrant des soldats nazis et en planifiant un assassinat de masse des hauts responsables nazis.', 'public/img/movies/inglourious_basterds.jpg', '2009-08-20 18:00:00', 'inglourious_basterds'),
(13, 'les affranchis', 'L\'ascension et la chute de Henry Hill, un gangster italo-américain, alors qu\'il gravit les échelons de la mafia.', 'public/img/movies/goodfellas.jpg', '1990-09-18 18:00:00', 'les_affranchis'),
(14, 'les infiltrés', 'Un policier infiltré dans la mafia et un membre de la mafia infiltré dans la police tentent de découvrir l\'identité de l\'autre tout en naviguant dans les intrigues et les trahisons.', 'public/img/movies/departed.jpg', '2006-10-05 18:00:00', 'les_infiltres'),
(15, 'gladiator', 'Après avoir été trahi et laissé pour mort par l\'empereur corrompu de Rome, un ancien général romain se lance dans une quête de vengeance.', 'public/img/movies/gladiator.jpg', '2000-05-04 18:00:00', 'gladiator'),
(16, 'la ligne verte', 'Dans une prison de Louisiane pendant les années 1930, un gardien de prison bienveillant découvre que l\'un de ses prisonniers a des pouvoirs surnaturels.', 'public/img/movies/green_mile.jpg', '1999-12-09 21:00:00', 'la_ligne_verte'),
(17, 'la liste de schindler', 'L\'histoire vraie d\'Oskar Schindler, un homme d\'affaires allemand qui a sauvé plus de 1 000 juifs pendant l\'Holocauste en les employant dans ses usines.', 'public/img/movies/schindlers_list.jpg', '1993-12-14 21:00:00', 'la_liste_de_schindler'),
(18, 'le prestige', 'Deux magiciens rivaux se lancent dans une compétition pour créer le meilleur numéro de magie, mais leurs tentatives pour se surpasser les uns les autres les conduisent à des extrémités dangereuses.', 'public/img/movies/prestige.jpg', '2006-10-19 18:00:00', 'le_prestige'),
(19, 'seven', 'Deux détectives de police enquêtent sur une série de meurtres inspirés par les sept péchés capitaux, et ils se retrouvent entraînés dans un jeu mortel avec le tueur.', 'public/img/movies/seven.jpg', '1995-09-21 18:00:00', 'seven');

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

DROP TABLE IF EXISTS `film`;
CREATE TABLE IF NOT EXISTS `film` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fiche_id` int NOT NULL,
  `cinema_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_film_fiche1_idx` (`fiche_id`),
  KEY `fk_film_cinema1_idx` (`cinema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `film`
--

INSERT INTO `film` (`id`, `fiche_id`, `cinema_id`) VALUES
(1, 1, 15),
(2, 2, 14),
(3, 3, 22),
(4, 4, 17),
(5, 5, 19),
(6, 6, 21),
(7, 7, 13),
(8, 8, 16),
(9, 9, 18),
(10, 10, 20);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `point` int DEFAULT NULL,
  `admin` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id`, `nom`, `prenom`, `email`, `password`, `point`, `admin`) VALUES
(9, 'Le Mélinaidre', 'Frédéric', 'lemelinaidre@gmail.com', '$2y$10$09UioC.iQjBi/bKHoTkOK.w9KaYhAKPrP3YIfaYNQ/OGRLp/fjN9C', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `seance`
--

DROP TABLE IF EXISTS `seance`;
CREATE TABLE IF NOT EXISTS `seance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `horaire` time NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `seance`
--

INSERT INTO `seance` (`id`, `horaire`, `date`) VALUES
(1, '18:35:00', '2024-07-08'),
(2, '23:30:00', '2024-07-06'),
(3, '19:55:00', '2024-07-13'),
(4, '21:35:00', '2024-07-08'),
(5, '21:40:00', '2024-07-12'),
(6, '17:20:00', '2024-07-02'),
(7, '21:35:00', '2024-07-03'),
(8, '12:55:00', '2024-07-10'),
(9, '22:15:00', '2024-07-06'),
(10, '11:30:00', '2024-07-01'),
(11, '14:05:00', '2024-07-03'),
(12, '14:55:00', '2024-07-08'),
(13, '16:35:00', '2024-07-13'),
(14, '18:50:00', '2024-07-11'),
(15, '12:35:00', '2024-07-12'),
(16, '18:25:00', '2024-07-08'),
(17, '21:10:00', '2024-07-10'),
(18, '18:50:00', '2024-07-07'),
(19, '23:45:00', '2024-07-05'),
(20, '21:15:00', '2024-07-04'),
(21, '20:00:00', '2024-07-14'),
(22, '15:10:00', '2024-07-14'),
(23, '17:10:00', '2024-07-13'),
(24, '22:45:00', '2024-07-08'),
(25, '16:15:00', '2024-07-06'),
(26, '21:25:00', '2024-07-15'),
(27, '12:50:00', '2024-07-11'),
(28, '19:45:00', '2024-07-14'),
(29, '16:25:00', '2024-07-15'),
(30, '15:40:00', '2024-07-12'),
(31, '18:55:00', '2024-07-06'),
(32, '11:30:00', '2024-07-15'),
(33, '16:00:00', '2024-07-07'),
(34, '16:35:00', '2024-07-15'),
(35, '17:35:00', '2024-07-11'),
(36, '14:20:00', '2024-07-07'),
(37, '10:40:00', '2024-07-13'),
(38, '11:10:00', '2024-07-07'),
(39, '16:20:00', '2024-07-09'),
(40, '19:45:00', '2024-07-09');

-- --------------------------------------------------------

--
-- Structure de la table `seance_film`
--

DROP TABLE IF EXISTS `seance_film`;
CREATE TABLE IF NOT EXISTS `seance_film` (
  `id` int NOT NULL AUTO_INCREMENT,
  `seance_id` int NOT NULL,
  `film_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_film_has_cinema_seance1_idx` (`seance_id`),
  KEY `fk_film_has_cinema_film1_idx` (`film_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `seance_film`
--

INSERT INTO `seance_film` (`id`, `seance_id`, `film_id`) VALUES
(1, 1, 7),
(2, 2, 5),
(3, 3, 2),
(4, 4, 8),
(5, 5, 3),
(6, 6, 1),
(7, 7, 6),
(8, 8, 2),
(9, 9, 9),
(10, 10, 4),
(11, 11, 10),
(12, 12, 7),
(13, 13, 8),
(14, 14, 5),
(15, 15, 9),
(16, 16, 4),
(17, 17, 1),
(18, 18, 3),
(19, 19, 10),
(20, 20, 6),
(21, 21, 9),
(22, 22, 2),
(23, 23, 8),
(24, 24, 4),
(25, 25, 5),
(26, 26, 6),
(27, 27, 3),
(28, 28, 10),
(29, 29, 7),
(30, 30, 1),
(31, 31, 9),
(32, 32, 8),
(33, 33, 2),
(34, 34, 10),
(35, 35, 5),
(36, 36, 1),
(37, 37, 6),
(38, 38, 3),
(39, 39, 7),
(40, 40, 4);

-- --------------------------------------------------------

--
-- Structure de la table `streaming`
--

DROP TABLE IF EXISTS `streaming`;
CREATE TABLE IF NOT EXISTS `streaming` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fiche_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_streaming_fiche1_idx` (`fiche_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `streaming`
--

INSERT INTO `streaming` (`id`, `fiche_id`) VALUES
(1, 11),
(2, 12),
(3, 13),
(4, 14),
(5, 15),
(6, 16),
(7, 17),
(8, 18),
(9, 19);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
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
-- Contraintes pour la table `categorie_fiche`
--
ALTER TABLE `categorie_fiche`
  ADD CONSTRAINT `fk_categorie_fiche_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_categorie_fiche_fiche1` FOREIGN KEY (`fiche_id`) REFERENCES `fiche` (`id`);

--
-- Contraintes pour la table `cinema`
--
ALTER TABLE `cinema`
  ADD CONSTRAINT `fk_cinema_ville1` FOREIGN KEY (`ville_id`) REFERENCES `ville` (`id`);

--
-- Contraintes pour la table `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `fk_film_fiche1` FOREIGN KEY (`fiche_id`) REFERENCES `fiche` (`id`);

--
-- Contraintes pour la table `seance_film`
--
ALTER TABLE `seance_film`
  ADD CONSTRAINT `fk_film_has_cinema_film1` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`),
  ADD CONSTRAINT `fk_film_has_cinema_seance1` FOREIGN KEY (`seance_id`) REFERENCES `seance` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `streaming`
--
ALTER TABLE `streaming`
  ADD CONSTRAINT `fk_streaming_fiche1` FOREIGN KEY (`fiche_id`) REFERENCES `fiche` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
