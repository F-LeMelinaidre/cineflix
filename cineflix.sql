-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 12 fév. 2024 à 20:45
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
  KEY `fiche_id` (`fiche_id`),
  KEY `categories_id` (`categories_id`)
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
  `ville` varchar(45) DEFAULT NULL,
  `region` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
  `cinopsys` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `affiche` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `date_sortie` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `fiche`
--

INSERT INTO `fiche` (`id`, `nom`, `cinopsys`, `affiche`, `date_sortie`) VALUES
(1, 'Inception', 'Un voleur d\'élite est capable d\'entrer dans les rêves des gens pour voler leurs secrets les plus précieux. Mais lorsqu\'il reçoit une offre pour une tâche impossible, il doit faire face à son plus grand défi.', 'inception.jpg', '2010-07-15 20:00:00'),
(2, 'Interstellar', 'Dans un futur où la Terre est devenue inhabitable, un groupe d\'explorateurs entreprend un voyage interstellaire pour trouver une nouvelle planète habitable pour l\'humanité.', 'interstellar.jpg', '2014-11-06 22:00:00'),
(3, 'Les Evadés', 'Un homme est condamné à tort pour le meurtre de sa femme et est envoyé dans une prison où il se lie d\'amitié avec un détenu plus âgé et commence à planifier son évasion.', 'shawshank_redemption.jpg', '1994-10-13 20:00:00'),
(4, 'Le Parrain', 'La saga de la famille Corleone, dirigée par le patriarche Vito Corleone, qui lutte pour maintenir son empire criminel tout en naviguant dans la politique et la violence.', 'godfather.jpg', '1972-03-23 22:00:00'),
(5, 'Pulp Fiction', 'Ce film présente plusieurs histoires entrelacées impliquant des criminels, des boxeurs, des danseurs, des tueurs à gages et des propriétaires de restaurants.', 'pulp_fiction.jpg', '1994-10-13 20:00:00'),
(6, 'Forrest Gump', 'L\'histoire d\'un homme simple d\'esprit nommé Forrest Gump, qui se retrouve impliqué dans certains des moments les plus mémorables de l\'histoire américaine.', 'forrest_gump.jpg', '1994-07-05 20:00:00'),
(7, 'The Dark Knight, Le Chevalier Noir', 'Batman se bat contre le Joker, un criminel sadique qui cherche à semer le chaos à Gotham City.', 'dark_knight.jpg', '2008-07-17 20:00:00'),
(8, 'Fight Club', 'Un homme sans nom rencontre un vendeur de savon charismatique et tous deux créent un club de combats clandestins qui prend rapidement une tournure sombre.', 'fight_club.jpg', '1999-10-14 20:00:00'),
(9, 'The Matrix', 'Un programmeur informatique découvre que le monde dans lequel il vit est une simulation contrôlée par des machines, et il se joint à une rébellion pour combattre ces machines.', 'matrix.jpg', '1999-03-30 20:00:00'),
(10, 'Le Seigneur des anneaux : la communauté de l\'anneau', 'Un jeune hobbit nommé Frodo Baggins se lance dans une quête périlleuse pour détruire un anneau magique maléfique et sauver la Terre du Milieu de la tyrannie du Seigneur des Ténèbres Sauron.', 'lotr_fellowship.jpg', '2001-12-18 22:00:00'),
(11, 'Le Silence des agneaux', 'Une jeune stagiaire du FBI est chargée de solliciter l\'aide du célèbre psychiatre cannibale Hannibal Lecter pour attraper un tueur en série surnommé \"Buffalo Bill\".', 'silence_lambs.jpg', '1991-02-13 22:00:00'),
(12, 'Inglourious Basterds', 'Dans la France occupée par les nazis, un groupe de soldats américains juifs est chargé de terroriser l\'armée allemande en massacrant des soldats nazis et en planifiant un assassinat de masse des hauts responsables nazis.', 'inglourious_basterds.jpg', '2009-08-20 20:00:00'),
(13, 'Les Affranchis', 'L\'ascension et la chute de Henry Hill, un gangster italo-américain, alors qu\'il gravit les échelons de la mafia.', 'goodfellas.jpg', '1990-09-18 20:00:00'),
(14, 'Les Infiltrés', 'Un policier infiltré dans la mafia et un membre de la mafia infiltré dans la police tentent de découvrir l\'identité de l\'autre tout en naviguant dans les intrigues et les trahisons.', 'departed.jpg', '2006-10-05 20:00:00'),
(15, 'Gladiator', 'Après avoir été trahi et laissé pour mort par l\'empereur corrompu de Rome, un ancien général romain se lance dans une quête de vengeance.', 'gladiator.jpg', '2000-05-04 20:00:00'),
(16, 'La Ligne verte', 'Dans une prison de Louisiane pendant les années 1930, un gardien de prison bienveillant découvre que l\'un de ses prisonniers a des pouvoirs surnaturels.', 'green_mile.jpg', '1999-12-09 22:00:00'),
(17, 'La Liste de Schindler', 'L\'histoire vraie d\'Oskar Schindler, un homme d\'affaires allemand qui a sauvé plus de 1 000 juifs pendant l\'Holocauste en les employant dans ses usines.', 'schindlers_list.jpg', '1993-12-14 22:00:00'),
(18, 'Le Prestige', 'Deux magiciens rivaux se lancent dans une compétition pour créer le meilleur numéro de magie, mais leurs tentatives pour se surpasser les uns les autres les conduisent à des extrémités dangereuses.', 'prestige.jpg', '2006-10-19 20:00:00'),
(19, 'Seven', 'Deux détectives de police enquêtent sur une série de meurtres inspirés par les sept péchés capitaux, et ils se retrouvent entraînés dans un jeu mortel avec le tueur.', 'seven.jpg', '1995-09-21 20:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

DROP TABLE IF EXISTS `film`;
CREATE TABLE IF NOT EXISTS `film` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fiche_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fiche_id` (`fiche_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `horaire`
--

DROP TABLE IF EXISTS `horaire`;
CREATE TABLE IF NOT EXISTS `horaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `horaire` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `point` int DEFAULT NULL,
  `admin` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `streaming`
--

DROP TABLE IF EXISTS `streaming`;
CREATE TABLE IF NOT EXISTS `streaming` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fiche_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fiche_id` (`fiche_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `categorie_fiche`
--
ALTER TABLE `categorie_fiche`
  ADD CONSTRAINT `categorieFiche_categoriesId` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categorieFiche_ficheId` FOREIGN KEY (`fiche_id`) REFERENCES `fiche` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `film_ficheId` FOREIGN KEY (`fiche_id`) REFERENCES `fiche` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `streaming`
--
ALTER TABLE `streaming`
  ADD CONSTRAINT `streaming_ficheId` FOREIGN KEY (`fiche_id`) REFERENCES `fiche` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
