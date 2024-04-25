-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 25 avr. 2024 à 03:25
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
  `ville_id` int NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cinema_ville1_idx` (`ville_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `cinema`
--

INSERT INTO `cinema` (`id`, `ville_id`, `nom`) VALUES
(12, 11, 'cinéville parc lann'),
(13, 1, 'ti hanok'),
(14, 2, 'rex'),
(15, 3, 'la rivière'),
(16, 4, 'le petit bal perdu'),
(17, 5, 'cgr lanester'),
(18, 6, 'cinéma le club'),
(19, 7, 'cinéville lorient'),
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
-- Structure de la table `jeu`
--

DROP TABLE IF EXISTS `jeu`;
CREATE TABLE IF NOT EXISTS `jeu` (
  `id_jeu` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `editeur` varchar(75) DEFAULT NULL,
  `annee` int DEFAULT NULL,
  `descriptif` text,
  `difficulte` float DEFAULT NULL,
  `age_min` int DEFAULT NULL,
  `joueur_min` int DEFAULT NULL,
  `joueur_max` int DEFAULT NULL,
  `duree_min` int DEFAULT NULL,
  `duree_max` int DEFAULT NULL,
  `disponible` int NOT NULL,
  `etat_int` int NOT NULL,
  `etat_actuel` int NOT NULL,
  `note` float DEFAULT NULL,
  PRIMARY KEY (`id_jeu`)
) ENGINE=MyISAM AUTO_INCREMENT=555 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `jeu`
--

INSERT INTO `jeu` (`id_jeu`, `nom`, `editeur`, `annee`, `descriptif`, `difficulte`, `age_min`, `joueur_min`, `joueur_max`, `duree_min`, `duree_max`, `disponible`, `etat_int`, `etat_actuel`, `note`) VALUES
(1, 'Domino 4', '', 2005, '', 0, 7, 2, 4, 20, 20, 0, 0, 0, 4.5),
(2, 'L\'ile aux pierres précieuses', '', 2011, '', 1, 6, 2, 4, 15, 15, 0, 0, 0, 6.75),
(3, 'Privacy', '', 2004, '', 1.12, 16, 5, 12, 45, 45, 0, 0, 0, 6.41),
(4, 'Margot l\'escargot', '', 1989, '', 0, 4, 2, 4, 15, 15, 0, 0, 0, 5.3),
(5, 'Wer War\'S Das 2 Abenteuer', '', 2010, '', 1.5, 7, 2, 4, 45, 45, 0, 0, 0, 6.3),
(6, 'Reve de trésor', '', 2013, '', 0, 5, 2, 5, 15, 15, 0, 0, 0, 6),
(7, 'Contrario 2', '', 2006, '', 1, 14, 2, 12, 0, 0, 0, 0, 0, 6.29),
(8, 'Scotland yard', '', 1975, '', 1.82, 10, 2, 6, 90, 90, 0, 0, 0, 5.97),
(9, 'Scrabble', '', 1948, '', 2.1, 10, 2, 4, 90, 90, 0, 0, 0, 6.28),
(10, 'Canon noir', '', 1986, '', 1.6, 8, 2, 4, 30, 30, 0, 0, 0, 5.32),
(11, 'Risk star wars', '', 2005, '', 2.22, 10, 2, 4, 120, 120, 0, 0, 0, 6),
(12, 'Clans', '', 2002, '', 2.03, 10, 2, 4, 30, 30, 0, 0, 0, 6.56),
(13, 'Wokabi et ses amis', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'Dames chinoises', '', 1893, '', 1.59, 7, 2, 6, 30, 30, 0, 0, 0, 5.12),
(15, 'Les animaux en maillot', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 'Cartecassonne', '', 2009, '', 1.76, 8, 2, 5, 30, 45, 0, 0, 0, 6.27),
(17, 'Les mélis molos', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 'Dominos (diset)', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 'Stratego legends', '', 1999, '', 2.26, 8, 2, 8, 60, 60, 0, 0, 0, 5.79),
(20, 'Scrabble junior', '', 1958, '', 1.43, 5, 2, 4, 30, 30, 0, 0, 0, 4.67),
(21, 'Graff city', '', 2015, '', 0, 10, 3, 5, 20, 20, 0, 0, 0, 6),
(22, 'Carcassonne la cité', '', 2004, '', 2.26, 10, 2, 4, 30, 45, 0, 0, 0, 7.2),
(23, 'Hermagor', '', 2006, '', 3.18, 12, 2, 5, 90, 120, 0, 0, 0, 6.92),
(24, 'Défis nature des petits', '', 2009, '', 0, 6, 2, 6, 20, 20, 0, 0, 0, 4.7),
(25, 'Indix', '', 1988, '', 1.33, 8, 2, 7, 30, 30, 0, 0, 0, 5.61),
(26, 'Caraibes', '', 2004, '', 1.75, 8, 2, 4, 30, 30, 0, 0, 0, 6.21),
(27, 'Halli galli junior', '', 1998, '', 1, 4, 2, 4, 15, 15, 0, 0, 0, 5.45),
(28, 'Le loto', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(29, 'Le jeu du potager', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(30, 'No panic', '', 1987, '', 1.23, 8, 1, 8, 20, 20, 0, 0, 0, 5.4),
(31, 'Estimeo', '', 2014, '', 0, 10, 3, 6, 30, 30, 0, 0, 0, 5.25),
(32, 'Jungolino', '', 2014, '', 0, 4, 2, 5, 0, 20, 0, 0, 0, 5),
(33, 'Défis nature  animaux marins', '', 2009, '', 0, 6, 2, 6, 20, 20, 0, 0, 0, 4.7),
(34, 'Libertalia', '', 2012, '', 2.23, 14, 2, 6, 40, 60, 0, 0, 0, 7.19),
(35, 'Catane', '', 1995, '', 2.33, 10, 3, 4, 60, 120, 0, 0, 0, 7.17),
(36, 'Set', '', 1988, '', 1.69, 6, 1, 20, 30, 30, 0, 0, 0, 6.49),
(37, 'The blue lion', '', 2011, '', 1.26, 8, 2, 2, 15, 15, 0, 0, 0, 5.96),
(38, 'Melimelo', '', 2005, '', 0, 3, 1, 4, 20, 20, 0, 0, 0, 0),
(39, 'Timeline inventions', '', 2010, '', 1.11, 8, 2, 8, 15, 15, 0, 0, 0, 6.7),
(40, 'Wanted', '', 1989, '', 1, 10, 2, 12, 20, 20, 0, 0, 0, 5.79),
(41, 'La guerre des moutons', '', 2002, '', 1.67, 7, 2, 4, 30, 30, 0, 0, 0, 6.11),
(42, 'Service compris', '', 1982, '', 1.32, 8, 2, 6, 30, 30, 0, 0, 0, 6.08),
(43, 'Citadelles', '', 2016, '', 1.99, 10, 2, 8, 30, 60, 0, 0, 0, 7.35),
(44, 'Mito', '', 2011, '', 1.15, 7, 3, 5, 30, 30, 0, 0, 0, 6.47),
(45, 'Solitaire', '', 1687, '', 1.51, 6, 1, 1, 15, 15, 0, 0, 0, 4.33),
(46, 'SOS ouistiti', '', 1999, '', 1, 3, 2, 4, 15, 15, 0, 0, 0, 5.4),
(47, 'Memo mime', '', 1987, '', 0, 4, 2, 4, 20, 20, 0, 0, 0, 6),
(48, 'Asterix le jeu de cartes', '', 1990, '', 1.14, 8, 2, 5, 30, 30, 0, 0, 0, 6),
(49, 'La boite d\'énigmes (édition de luxe)', '', 2009, '', 1, 0, 3, 13, 45, 45, 0, 0, 0, 4.4),
(50, 'Le pays de rennes', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(51, 'Mastermind', '', 1971, '', 1.81, 8, 2, 2, 20, 20, 0, 0, 0, 5.52),
(52, 'Dominos bois', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(53, 'Dominos yakari', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(54, 'Le jeu de lecture', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(55, 'Domino voyages', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(56, 'Rythme and boulet', '', 2008, '', 1.06, 8, 4, 12, 30, 30, 0, 0, 0, 6.32),
(57, 'Heads and Tails', '', 1986, '', 1.5, 8, 2, 4, 30, 30, 0, 0, 0, 6.17),
(58, 'Boggle electronic', '', 1979, '', 1.53, 8, 2, 8, 10, 10, 0, 0, 0, 6.8),
(59, 'Scrabble junior voyage', '', 1958, '', 1.43, 5, 2, 4, 30, 30, 0, 0, 0, 4.67),
(60, 'Trivial pursuit', '', 1981, '', 1.65, 12, 2, 24, 90, 90, 0, 0, 0, 5.2),
(61, 'L\'oeuf a dit', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(62, '7 familles ecolo', '', 1851, '', 1.06, 4, 2, 4, 10, 30, 0, 0, 0, 4.69),
(63, '7 familles sécurité', '', 1851, '', 1.06, 4, 2, 4, 10, 30, 0, 0, 0, 4.69),
(64, 'Mikados', '', 1850, '', 1.05, 5, 2, 6, 10, 30, 0, 0, 0, 4.2),
(65, 'Initiation aux échecs', '', 1475, '', 3.72, 6, 2, 2, 60, 60, 0, 0, 0, 7.1),
(66, 'Cache cache', '', 1959, '', 0, 8, 2, 2, 20, 20, 0, 0, 0, 7.5),
(67, 'Loto sonore', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(68, 'Zimbanimo', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(69, 'Enigmes sciences', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(70, 'Mamba', '', 2001, '', 2.4, 9, 2, 4, 30, 30, 0, 0, 0, 6.29),
(71, 'Funkenschlag', '', 2004, '', 3.28, 12, 2, 6, 120, 120, 0, 0, 0, 7.88),
(72, 'Abalone hexagone', '', 1987, '', 2.19, 8, 2, 2, 30, 30, 0, 0, 0, 6.4),
(73, 'Abalone triangle', '', 1987, '', 2.19, 8, 2, 2, 30, 30, 0, 0, 0, 6.4),
(74, 'Dominion', '', 2008, '', 2.36, 10, 2, 2, 30, 30, 0, 0, 0, 7.6),
(75, 'Boite à énigme junior', '', 2009, '', 0, 6, 2, 12, 45, 45, 0, 0, 0, 5.7),
(76, 'Wobble', '', 2010, '', 1, 6, 1, 4, 30, 30, 0, 0, 0, 5.21),
(77, 'Sambesi', '', 1985, '', 1, 0, 2, 6, 40, 40, 0, 0, 0, 5.33),
(78, 'Les couleurs et les formes avec petit ourson', '', 2014, '', 1, 2, 1, 4, 5, 5, 0, 0, 0, 5.62),
(79, 'La course aux miams', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(80, 'Le monde est fou', '', 2012, '', 1.14, 12, 4, 12, 45, 45, 0, 0, 0, 6.43),
(81, 'Sugi', '', 2016, '', 1.33, 10, 2, 5, 10, 30, 0, 0, 0, 5.67),
(82, 'Mange moi si tu peux', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(83, 'Défis nature carnivores', '', 2009, '', 0, 6, 2, 6, 20, 20, 0, 0, 0, 4.7),
(84, 'Le jeu de l\'oie pardon', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(85, 'Garçon en délire', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(86, 'Compte avec les animaux', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(87, 'Poupée Lilli à  habiller', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(88, 'Loto des vacances', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(89, 'La boite à  énigmes', '', 2008, '', 1, 0, 3, 13, 45, 45, 0, 0, 0, 4.4),
(90, 'Ta bouche', '', 2015, '', 0, 7, 3, 8, 20, 30, 0, 0, 0, 7.29),
(91, 'Taggle d\'amour', '', 2013, '', 1, 16, 2, 4, 20, 20, 0, 0, 0, 6.7),
(92, 'Le jardin magique', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(93, 'Melimelo les émotions', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(94, 'Shabadabada', '', 2002, '', 1, 8, 4, 16, 45, 45, 0, 0, 0, 5.8),
(95, 'Foutrak', '', 2011, '', 1, 8, 3, 8, 15, 15, 0, 0, 0, 6.17),
(96, 'Casse toi pauv\'con', '', 2011, '', 1.14, 8, 2, 6, 15, 15, 0, 0, 0, 5.3),
(97, 'Illico', '', 2012, '', 1, 14, 2, 8, 15, 15, 0, 0, 0, 5.27),
(98, 'Crimebox paranormal', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(99, 'Alien menace', '', 2011, '', 1.8, 12, 2, 2, 30, 30, 0, 0, 0, 6.56),
(100, 'Tikal 2', '', 2010, '', 2.63, 10, 2, 4, 60, 120, 0, 0, 0, 6.9),
(101, 'Marvel heroes', '', 2006, '', 3.07, 12, 2, 4, 120, 120, 0, 0, 0, 6.4),
(102, 'Dungeon twister prison', '', 2009, '', 3.25, 12, 1, 2, 60, 60, 0, 0, 0, 7.3),
(103, 'Mundus novus', '', 2011, '', 2.19, 14, 2, 6, 45, 60, 0, 0, 0, 6.7),
(104, 'Mystery party  meurtre sur le Nil', '', 2012, '', 0, 14, 8, 8, 120, 120, 0, 0, 0, 6.9),
(105, 'L\'ile interdite', '', 2010, '', 1.74, 8, 2, 4, 30, 30, 0, 0, 0, 6.81),
(106, 'Timeline musique et cinéma', '', 2013, '', 1.1, 10, 2, 8, 15, 15, 0, 0, 0, 6.8),
(107, 'Timeline évà¨nements', '', 2011, '', 1.11, 10, 2, 8, 15, 15, 0, 0, 0, 6.8),
(108, 'Timeline inventions', '', 2010, '', 1.11, 8, 2, 8, 15, 15, 0, 0, 0, 6.7),
(109, '7 familles circus', '', 1851, '', 1.06, 4, 2, 4, 10, 30, 0, 0, 0, 4.69),
(110, 'Mon atelier heure et temps', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(111, 'P\'tit génies', '', 2008, '', 1, 2, 2, 5, 20, 20, 0, 0, 0, 6.6),
(112, 'Le quizz Larousse des juniors', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(113, 'Scrabble junior', '', 1958, '', 1.43, 5, 2, 4, 30, 30, 0, 0, 0, 4.67),
(114, 'Choson', '', 2014, '', 2.16, 14, 2, 4, 15, 15, 0, 0, 0, 6.67),
(115, 'Can\'t stop', '', 1980, '', 1.16, 9, 2, 4, 30, 30, 0, 0, 0, 6.86),
(116, 'La boite a culture générale', '', 2010, '', 0, 8, 2, 8, 30, 30, 0, 0, 0, 5),
(117, 'Dungeon twister  card game', '', 2013, '', 2.96, 12, 2, 2, 15, 60, 0, 0, 0, 6.3),
(118, 'Room 25', '', 2013, '', 1.92, 13, 1, 6, 30, 30, 0, 0, 0, 6.78),
(119, 'Skull & Roses', '', 2011, '', 1.14, 14, 3, 6, 45, 45, 0, 0, 0, 7.2),
(120, 'Bonne question', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(121, 'Comedia', '', 1990, '', 1, 12, 4, 10, 90, 90, 0, 0, 0, 6.93),
(122, 'Cyrano', '', 2010, '', 1.4, 8, 4, 9, 45, 45, 0, 0, 0, 6.66),
(123, 'Jumpy jack', '', 2000, '', 1, 8, 2, 16, 15, 15, 0, 0, 0, 7.07),
(124, 'Gosu kamakor', '', 2011, '', 2.8, 10, 2, 4, 20, 20, 0, 0, 0, 7.2),
(125, 'Der palast von Alhambra', '', 2003, '', 2.11, 8, 2, 6, 45, 60, 0, 0, 0, 7.03),
(126, 'Monopoly ubuild', '', 2010, '', 1.83, 8, 2, 6, 30, 30, 0, 0, 0, 5.32),
(127, 'Marvel heroclix', '', 2002, '', 2, 8, 2, 5, 40, 60, 0, 0, 0, 6.61),
(128, 'Kardinal', '', 2000, '', 2.18, 10, 2, 4, 20, 20, 0, 0, 0, 6.61),
(129, 'Race for the galaxy', '', 2007, '', 2.98, 12, 2, 4, 30, 60, 0, 0, 0, 7.76),
(130, 'Les aventuriers du rail', '', 2004, '', 1.86, 8, 2, 5, 30, 60, 0, 0, 0, 7.44),
(131, 'Winner\'s circle', '', 1984, '', 1.67, 13, 2, 8, 0, 0, 0, 0, 0, 6.53),
(132, 'Puzzle the big five', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(133, 'Prinzessin Pimpernell', '', 2003, '', 2, 0, 2, 4, 30, 30, 0, 0, 0, 5.5),
(134, 'Fief', '', 2011, '', 3.64, 12, 3, 6, 120, 120, 0, 0, 0, 7.28),
(135, 'Les colons de catane', '', 1995, '', 2.33, 10, 3, 4, 60, 120, 0, 0, 0, 7.17),
(136, 'Hocus Pocus', '', 2004, '', 1, 6, 2, 4, 0, 0, 0, 0, 0, 6),
(137, 'Quitte ou double', '', 2012, '', 1.14, 8, 4, 18, 25, 25, 0, 0, 0, 6.93),
(138, 'Rush n\' crush', '', 2009, '', 2.21, 12, 3, 6, 60, 60, 0, 0, 0, 6.32),
(139, 'Armada', '', 1975, '', 0, 7, 2, 4, 0, 0, 0, 0, 0, 7.17),
(140, 'Bruges', '', 2013, '', 2.76, 10, 2, 4, 60, 60, 0, 0, 0, 7.45),
(141, 'Dream factory', '', 2000, '', 2.11, 10, 2, 5, 60, 60, 0, 0, 0, 7.06),
(142, 'Rise of empires', '', 2009, '', 3.55, 12, 2, 5, 180, 180, 0, 0, 0, 7.06),
(143, 'Artificium', '', 2014, '', 2.05, 8, 2, 6, 20, 50, 0, 0, 0, 6.08),
(144, 'Alhambra', '', 2003, '', 2.11, 8, 2, 6, 45, 60, 0, 0, 0, 7.03),
(145, 'Yggdrasil', '', 2011, '', 2.59, 13, 1, 6, 90, 90, 0, 0, 0, 7.07),
(146, 'Escape, la malédiction du temple', '', 2012, '', 1.48, 8, 1, 5, 10, 10, 0, 0, 0, 7.02),
(147, 'Atlantic star', '', 2001, '', 2.14, 10, 2, 6, 60, 60, 0, 0, 0, 6.87),
(148, 'Loony quest', '', 2015, '', 1.2, 8, 2, 5, 20, 30, 0, 0, 0, 6.98),
(149, 'Cartagena', '', 2017, '', 1.5, 8, 2, 5, 30, 45, 0, 0, 0, 6.73),
(150, 'Splendor', '', 2014, '', 1.81, 10, 2, 4, 30, 30, 0, 0, 0, 7.46),
(151, 'Zooloretto', '', 2007, '', 1.86, 8, 2, 5, 45, 45, 0, 0, 0, 6.85),
(152, 'Cardline globe trotters', '', 2013, '', 1.44, 12, 2, 7, 15, 15, 0, 0, 0, 6.4),
(153, 'Gang of four', '', 1990, '', 1.87, 8, 3, 4, 40, 40, 0, 0, 0, 6.62),
(154, 'pylos travel', '', 1993, '', 1.99, 8, 2, 2, 10, 10, 0, 0, 0, 6.35),
(155, 'Dobble', '', 2009, '', 1.03, 7, 2, 8, 15, 15, 0, 0, 0, 6.66),
(156, 'Dobble', '', 2009, '', 1.03, 7, 2, 8, 15, 15, 0, 0, 0, 6.66),
(157, 'What\'s Missing', '', 2009, '', 1.11, 6, 2, 6, 20, 20, 0, 0, 0, 5.4),
(158, 'Pit', '', 1903, '', 1.16, 7, 3, 8, 30, 90, 0, 0, 0, 6.39),
(159, 'Level Up', '', 2008, '', 1.4, 10, 2, 6, 60, 60, 0, 0, 0, 5.66),
(160, 'Time\'s up', '', 1990, '', 1.14, 12, 3, 16, 45, 45, 0, 0, 0, 5.97),
(161, 'Arkham ritual', '', 2017, '', 1.5, 8, 3, 7, 20, 30, 0, 0, 0, 5.55),
(162, 'Smallworld', '', 2009, '', 2.36, 8, 2, 5, 40, 80, 0, 0, 0, 7.3),
(163, 'A l\'heure du crime, oà¹ étiez vous ?', '', 2008, '', 1, 8, 5, 20, 15, 15, 0, 0, 0, 5.8),
(164, 'Smallworld même pas peur', '', 2010, '', 2.3, 8, 2, 5, 40, 80, 0, 0, 0, 7.6),
(165, 'Pat le pirate', '', 2000, '', 1.22, 6, 2, 4, 30, 30, 0, 0, 0, 5.9),
(166, 'Mémoire 44', '', 2004, '', 2.28, 8, 2, 8, 30, 60, 0, 0, 0, 7.56),
(167, 'A vos carottes', '', 1991, '', 1.25, 4, 2, 4, 30, 30, 0, 0, 0, 5.9),
(168, 'Seasons', '', 2012, '', 2.77, 14, 2, 4, 60, 60, 0, 0, 0, 7.43),
(169, 'Petits magiciens', '', 2009, '', 1.5, 4, 2, 4, 15, 15, 0, 0, 0, 6.22),
(170, 'Concept', '', 2013, '', 1.41, 10, 4, 12, 40, 40, 0, 0, 0, 6.86),
(171, 'et toqueÂ !', '', 2011, '', 1.5, 12, 3, 6, 30, 30, 0, 0, 0, 6.8),
(172, 'Quadropolis', '', 2016, '', 2.21, 8, 2, 4, 30, 60, 0, 0, 0, 7.32),
(173, 'carolus magnus', '', 2000, '', 2.59, 12, 2, 4, 60, 60, 0, 0, 0, 6.83),
(174, 'the republic of rome', '', 1990, '', 4.32, 14, 1, 6, 300, 300, 0, 0, 0, 7.54),
(175, 'saint petersbourg', '', 2004, '', 2.47, 10, 2, 4, 45, 60, 0, 0, 0, 7.3),
(176, 'Ora & labora', '', 2011, '', 3.9, 13, 1, 4, 60, 180, 0, 0, 0, 7.71),
(177, 'Prinzessin Pimpernell', '', 2003, '', 2, 0, 2, 4, 30, 30, 0, 0, 0, 5.5),
(178, 'Cannes', '', 2002, '', 2.48, 10, 2, 4, 90, 90, 0, 0, 0, 6.2),
(179, 'Bombay', '', 2009, '', 2.05, 10, 2, 5, 30, 60, 0, 0, 0, 6.35),
(180, 'Lord of the rings', '', 2003, '', 1.24, 6, 2, 5, 20, 20, 0, 0, 0, 5.95),
(181, 'Rampage', '', 2013, '', 1.48, 8, 2, 4, 45, 45, 0, 0, 0, 6.88),
(182, 'Lewis & Clark', '', 2013, '', 3.35, 14, 1, 5, 120, 120, 0, 0, 0, 7.51),
(183, 'Formula D', '', 2019, '', 0, 6, 2, 5, 10, 15, 0, 0, 0, 0),
(184, '7 wonders', '', 2010, '', 2.34, 10, 2, 7, 30, 30, 0, 0, 0, 7.77),
(185, 'Trivial pursuit, recharge genus', '', 1995, '', 2, 0, 2, 36, 60, 60, 0, 0, 0, 5.82),
(186, 'Le voleur de carottes', '', 2004, '', 1, 4, 1, 6, 5, 5, 0, 0, 0, 5.72),
(187, 'trivial pursuit, recharge football', '', 2005, '', 0, 12, 2, 6, 60, 60, 0, 0, 0, 0),
(188, 'Trivial pursuit', '', 2007, '', 2.27, 14, 2, 36, 120, 120, 0, 0, 0, 5.9),
(189, 'Triominos de luxe', '', 1965, '', 1.43, 6, 2, 6, 30, 30, 0, 0, 0, 5.3),
(190, 'Mikado', '', 1967, '', 1.03, 5, 2, 4, 20, 20, 0, 0, 0, 4.78),
(191, 'Corner', '', 2013, '', 1, 7, 2, 5, 10, 10, 0, 0, 0, 5.43),
(192, 'Le petit bac', '', 1985, '', 1, 8, 2, 6, 15, 15, 0, 0, 0, 5.82),
(193, 'Speed', '', 1995, '', 1.07, 7, 2, 3, 10, 10, 0, 0, 0, 5.94),
(194, '15 jeux de voyage ado', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(195, 'Fort Comme un Lion', '', 2007, '', 1, 5, 2, 4, 10, 10, 0, 0, 0, 5.3),
(196, 'Mindtrap', '', 1991, '', 1.96, 12, 2, 16, 60, 60, 0, 0, 0, 4.75),
(197, 'Time\'s up', '', 1999, '', 1.21, 12, 4, 18, 90, 90, 0, 0, 0, 7.3),
(198, 'Unanimo', '', 1990, '', 1.24, 10, 3, 8, 30, 30, 0, 0, 0, 6.89),
(199, 'Robin des bois', '', 2005, '', 2.27, 9, 2, 4, 45, 45, 0, 0, 0, 6.28),
(200, 'Memoire 44', '', 2004, '', 2.28, 8, 2, 8, 30, 60, 0, 0, 0, 7.56),
(201, 'Comedia Junior', '', 1991, '', 0, 7, 4, 7, 60, 60, 0, 0, 0, 0),
(202, 'Boggle', '', 1972, '', 1.51, 8, 1, 8, 10, 10, 0, 0, 0, 6.2),
(203, 'Twister', '', 1966, '', 1.08, 6, 2, 4, 10, 10, 0, 0, 0, 4.54),
(204, 'Mastermind', '', 1971, '', 1.81, 8, 2, 2, 20, 20, 0, 0, 0, 5.52),
(205, 'Diamino', '', 1935, '', 1, 0, 2, 8, 0, 0, 0, 0, 0, 4),
(206, 'Augustus', '', 2013, '', 1.63, 8, 2, 6, 30, 30, 0, 0, 0, 6.8),
(207, 'Locomotive Werks', '', 2002, '', 2.91, 12, 3, 5, 120, 120, 0, 0, 0, 6.8),
(208, 'Fortunes de mer', '', 2010, '', 3.23, 13, 2, 4, 180, 180, 0, 0, 0, 7.43),
(209, 'Fantà´mes contre Fantà´mes', '', 1980, '', 1.31, 6, 2, 2, 15, 15, 0, 0, 0, 6.37),
(210, 'Dr Shark', '', 2011, '', 1.6, 8, 2, 6, 45, 45, 0, 0, 0, 6.2),
(211, 'Maharaja', '', 1994, '', 2.8, 8, 3, 5, 240, 240, 0, 0, 0, 6.14),
(212, 'The great fire of London 1666', '', 2010, '', 2.53, 12, 3, 6, 80, 120, 0, 0, 0, 6.51),
(213, 'Deckscape Braquage à  Venise', '', 2018, '', 1.67, 12, 1, 6, 30, 90, 0, 0, 0, 6.9),
(214, 'Such bello', '', 1989, '', 0, 4, 2, 5, 10, 10, 0, 0, 0, 6.3),
(215, 'The hobbit', '', 2010, '', 1.75, 8, 2, 5, 30, 45, 0, 0, 0, 5.99),
(216, 'Millions of dollars', '', 2016, '', 1.88, 14, 2, 8, 25, 25, 0, 0, 0, 6.5),
(217, 'Intrigue', '', 1952, '', 1.36, 6, 2, 4, 30, 30, 0, 0, 0, 5.61),
(218, 'Bizzzz', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(219, 'Petits Musiciens', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(220, 'Cardline globe trotters', '', 2013, '', 1.44, 12, 2, 7, 15, 15, 0, 0, 0, 6.4),
(221, 'Final touch', '', 2016, '', 1.11, 8, 2, 4, 15, 15, 0, 0, 0, 6.1),
(222, 'Top dance !', '', 2016, '', 0, 7, 3, 8, 15, 15, 0, 0, 0, 6.7),
(223, 'Deckscape à  l\'épreuve du temps', '', 2017, '', 1.52, 10, 1, 6, 30, 90, 0, 0, 0, 6.8),
(224, 'Rhino hero', '', 2011, '', 1.03, 5, 2, 5, 5, 15, 0, 0, 0, 6.96),
(225, 'La maman dans la crotte', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(226, 'Mucca pazza', '', 2013, '', 1, 4, 2, 4, 15, 15, 0, 0, 0, 5.46),
(227, 'La forêt enchantée', '', 2009, '', 1, 4, 2, 6, 20, 20, 0, 0, 0, 5.06),
(228, 'Reconnaissance tactile', '', 2009, '', 1, 2, 1, 2, 10, 10, 0, 0, 0, 5.04),
(229, 'Corda doudou', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(230, 'Les petits chevaux', '', 400, '', 1.2, 5, 2, 6, 30, 30, 0, 0, 0, 4.49),
(231, 'Trivial pursuit filles', '', 2007, '', 1.4, 0, 2, 6, 0, 0, 0, 0, 0, 4.2),
(232, 'Trivial pursuit garçons', '', 2007, '', 1.4, 0, 2, 6, 0, 0, 0, 0, 0, 4.2),
(233, 'Disney quizz', '', 1997, '', 1.53, 6, 2, 6, 45, 45, 0, 0, 0, 5.37),
(234, 'La roue de la fortune', '', 1975, '', 1.26, 10, 2, 4, 60, 60, 0, 0, 0, 4.57),
(235, 'Monopoly junior à  la fête forraine', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(236, 'Memory petits animaux', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(237, 'Le mémo des images', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(238, 'Mastermind junior zoom street', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(239, 'Boule & Bill', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(240, 'Tout sur le chien', '', 2004, '', 0, 6, 2, 6, 45, 45, 0, 0, 0, 0),
(241, 'Mon premier scrabble Dora l\'exploratrice', '', 2005, '', 0, 4, 1, 4, 0, 0, 0, 0, 0, 4.3),
(242, 'Saute petit poney', '', 2012, '', 1.04, 4, 2, 4, 10, 10, 0, 0, 0, 5.3),
(243, 'Le verger', '', 1986, '', 1.04, 3, 2, 8, 10, 10, 0, 0, 0, 6.36),
(244, 'Solenia', '', 2018, '', 2.3, 10, 1, 4, 30, 45, 0, 0, 0, 7.23),
(245, 'Magic Maze', '', 2017, '', 1.72, 8, 1, 8, 15, 15, 0, 0, 0, 7.13),
(246, 'Codenames', '', 2015, '', 1.31, 14, 2, 8, 15, 15, 0, 0, 0, 7.67),
(247, 'King of Tokyo', '', 2011, '', 1.5, 8, 2, 6, 30, 30, 0, 0, 0, 7.21),
(248, 'Wordz', '', 1974, '', 0, 10, 2, 10, 0, 0, 0, 0, 0, 5.53),
(249, 'Color Addict', '', 2009, '', 1, 7, 2, 6, 15, 15, 0, 0, 0, 5.72),
(250, 'Sardines', '', 2008, '', 1, 5, 2, 4, 15, 15, 0, 0, 0, 5.96),
(251, 'Petits Musiciens', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(252, 'Schmackofatz', '', 2003, '', 0, 5, 2, 6, 15, 15, 0, 0, 0, 4.88),
(253, 'Hasch Mich', '', 1927, '', 1.11, 6, 2, 6, 30, 30, 0, 0, 0, 4.79),
(254, 'Felix flosse', '', 1997, '', 1, 4, 2, 6, 5, 5, 0, 0, 0, 4.82),
(255, 'Pyramide d\'animaux', '', 2005, '', 1.05, 3, 2, 4, 15, 15, 0, 0, 0, 6.8),
(256, 'Gaia', '', 2014, '', 1.98, 8, 2, 5, 30, 30, 0, 0, 0, 6.3),
(257, 'Piratoons', '', 2015, '', 1.82, 8, 2, 4, 30, 30, 0, 0, 0, 6.43),
(258, 'Cacao', '', 2015, '', 1.82, 8, 2, 4, 45, 45, 0, 0, 0, 7.12),
(259, 'Formula D', '', 1996, '', 2, 9, 1, 10, 90, 90, 0, 0, 0, 7.29),
(260, 'Atlas & Zeus', '', 2004, '', 2.02, 10, 2, 2, 30, 30, 0, 0, 0, 6.36),
(261, 'Dracomundis', '', 2006, '', 2.19, 14, 2, 4, 45, 45, 0, 0, 0, 5.9),
(262, 'Sylla', '', 2008, '', 3.12, 12, 3, 4, 60, 90, 0, 0, 0, 6.76),
(263, 'Gipsy King', '', 2007, '', 1.83, 8, 2, 5, 30, 30, 0, 0, 0, 6.56),
(264, 'Mythotopia', '', 2014, '', 3.1, 13, 2, 4, 60, 120, 0, 0, 0, 6.88),
(265, 'Bootleggers', '', 2004, '', 2.62, 14, 3, 6, 90, 90, 0, 0, 0, 6.68),
(266, 'Utopia', '', 2002, '', 1.7, 8, 2, 4, 10, 10, 0, 0, 0, 6.23),
(267, 'Sapiens', '', 2015, '', 2.63, 10, 2, 4, 45, 45, 0, 0, 0, 6.56),
(268, 'Beep Beep', '', 2016, '', 1, 8, 2, 4, 30, 60, 0, 0, 0, 6),
(269, 'Défis des savants', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(270, 'Alcatraz The scapegoat', '', 2011, '', 2.35, 12, 3, 4, 45, 60, 0, 0, 0, 6.4),
(271, 'Draco & Co', '', 2001, '', 1.47, 12, 3, 6, 60, 60, 0, 0, 0, 5.48),
(272, 'Black Fleet', '', 2014, '', 1.95, 14, 3, 4, 60, 60, 0, 0, 0, 7.03),
(273, 'Goa', '', 2015, '', 3.33, 0, 2, 6, 90, 180, 0, 0, 0, 7.46),
(274, 'Amyitis', '', 2007, '', 3.23, 12, 2, 4, 60, 120, 0, 0, 0, 6.97),
(275, 'Les loups garous de Thiercelieux', '', 2001, '', 1.32, 10, 8, 18, 30, 60, 0, 0, 0, 6.8),
(276, 'Bazar Bizarre', '', 2010, '', 1.14, 6, 2, 8, 20, 30, 0, 0, 0, 6.7),
(277, 'Identik', '', 2005, '', 1.22, 8, 3, 10, 45, 45, 0, 0, 0, 7),
(278, 'Lotus', '', 2016, '', 1.48, 8, 2, 4, 30, 30, 0, 0, 0, 6.8),
(279, 'Noria', '', 2017, '', 3.63, 12, 2, 4, 70, 120, 0, 0, 0, 6.6),
(280, 'Bang walking dead', '', 2015, '', 1.33, 8, 3, 8, 15, 30, 0, 0, 0, 6.7),
(281, 'Otys', '', 2017, '', 2.96, 12, 2, 4, 60, 60, 0, 0, 0, 7),
(282, 'Unlock Exotic Adventures + démo Cabrakan', '', 2018, '', 2.6, 10, 1, 6, 60, 60, 0, 0, 0, 7.5),
(283, 'Unlock Secret Adventures', '', 2018, '', 2.2, 10, 1, 6, 60, 60, 0, 0, 0, 7.7),
(284, 'Colt Express', '', 2014, '', 1.8, 10, 2, 6, 30, 40, 0, 0, 0, 7.1),
(285, 'Senet Mancala', '', 3500, '', 1.5, 6, 2, 2, 10, 30, 0, 0, 0, 5.8),
(286, 'Time\'s up Family 2, Orange', '', 2012, '', 0, 8, 4, 12, 30, 30, 0, 0, 0, 7.1),
(287, 'Unlock Heroic Adventures', '', 2018, '', 2.4, 10, 1, 6, 60, 60, 0, 0, 0, 7.9),
(288, 'Unlock Squeek and Sausage', '', 2017, '', 2.2, 10, 1, 6, 45, 75, 0, 0, 0, 7.2),
(289, 'Cardline Dinosaures', '', 2014, '', 1.2, 7, 2, 7, 15, 15, 0, 0, 0, 6.1),
(290, 'Dobble Lapins Crétins', '', 2011, '', 0, 6, 2, 4, 20, 20, 0, 0, 0, 6.5),
(291, 'Safari Malin', '', 2000, '', 1.3, 3, 2, 4, 15, 15, 0, 0, 0, 4.9),
(292, 'Escape game livre', '', 0, '', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0),
(293, 'Elixir', '', 1997, '', 1.5, 10, 3, 8, 60, 60, 0, 0, 0, 5.6),
(294, 'Lanceur de Discussion', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(295, 'Puzzle Animaux Djeco', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(296, 'Le Quizz des filles', '', 2017, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(297, 'Monopoly Junior fête foraine', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(298, 'Princici et Princesslà ', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(299, 'SOS Ouistiti', '', 1999, '', 1, 5, 2, 4, 15, 15, 0, 0, 0, 5.4),
(300, 'Mémo Mime', '', 1987, '', 0, 4, 2, 4, 20, 20, 0, 0, 0, 5.8),
(301, 'Trivial Pursuit Poitou Charentes', '', 2007, '', 0, 8, 2, 36, 90, 90, 0, 0, 0, 0),
(302, 'Miss Kipik', '', 2010, '', 0, 4, 2, 4, 10, 10, 0, 0, 0, 4),
(303, 'Yam\'s naval', '', 2016, '', 1, 6, 2, 4, 5, 20, 0, 0, 0, 5.3),
(304, 'Escape box Minecraft Earth', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(305, 'Enigmes nouvelles technologies', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(306, 'Tea time', '', 2012, '', 1.1, 8, 2, 4, 1, 30, 0, 0, 0, 6),
(307, '6 qui prend', '', 1994, '', 1.2, 8, 2, 10, 45, 45, 0, 0, 0, 6.9),
(308, 'Au feu les pompiers', '', 2015, '', 0, 3, 2, 2, 10, 10, 0, 0, 0, 6),
(309, 'Story cubes', '', 2005, '', 1.1, 6, 1, 12, 20, 20, 0, 0, 0, 6.3),
(310, 'Dix de chute', '', 1970, '', 1.2, 7, 2, 2, 30, 30, 0, 0, 0, 5.5),
(311, 'Cluedo', '', 1949, '', 1.7, 8, 2, 6, 45, 45, 0, 0, 0, 5.7),
(312, 'Diamoniak', '', 2009, '', 1, 5, 2, 4, 15, 15, 0, 0, 0, 5.2),
(313, 'Docteur Maboul', '', 2005, '', 1, 4, 2, 4, 15, 15, 0, 0, 0, 4.4),
(314, 'Forêt envoà»tée', '', 2012, '', 1, 5, 2, 4, 15, 15, 0, 0, 0, 6.5),
(315, 'Jungle speed pocket', '', 1997, '', 1.1, 7, 2, 8, 10, 10, 0, 0, 0, 6.5),
(316, 'L\'or de Paco', '', 2010, '', 1, 5, 2, 4, 15, 15, 0, 0, 0, 5.4),
(317, 'Méchanlou', '', 0, '', 1, 4, 2, 4, 15, 15, 0, 0, 0, 6.1),
(318, 'Mini family', '', 0, '', 0, 4, 2, 4, 10, 10, 0, 0, 0, 0),
(319, 'Mon premier mémorébus', '', 0, '', 0, 4, 2, 6, 0, 0, 0, 0, 0, 0),
(320, 'Piou piou', '', 2009, '', 1.1, 5, 2, 5, 10, 10, 0, 0, 0, 6.6),
(321, 'Timeline Star Wars', '', 2015, '', 1.2, 8, 2, 8, 15, 15, 0, 0, 0, 6.2),
(322, 'Les loups garous de Thiercelieux', '', 2001, '', 1.32, 10, 8, 18, 30, 60, 0, 0, 0, 6.8),
(323, 'Dindons et Dragons', '', 2003, '', 0, 10, 3, 6, 30, 30, 0, 0, 0, 0),
(324, 'Et ça tu le savais ?', '', 0, '', 0, 16, 2, 20, 10, 60, 0, 0, 0, 0),
(325, 'Les rondins des bois', '', 2005, '', 1, 5, 2, 5, 35, 35, 0, 0, 0, 6.11),
(326, 'Hop hop Galopons', '', 2011, '', 0, 3, 2, 4, 10, 10, 0, 0, 0, 0),
(327, 'Mille et un trésors', '', 2010, '', 0, 5, 2, 4, 15, 15, 0, 0, 0, 0),
(328, 'Jungle Speed', '', 1997, '', 1.14, 7, 2, 8, 10, 10, 0, 0, 0, 6.51),
(329, 'Imagine', '', 2015, '', 1.04, 12, 3, 8, 15, 30, 0, 0, 0, 6.95),
(330, 'Jeu des saisons petit ours brun', '', 2017, '', 0, 3, 2, 4, 15, 15, 0, 0, 0, 0),
(331, 'Bourricot', '', 2003, '', 0, 4, 2, 4, 0, 0, 0, 0, 0, 0),
(332, 'Devine ce que je mime', '', 0, '', 0, 5, 2, 4, 0, 0, 0, 0, 0, 0),
(333, 'Premiers mots', '', 2012, '', 0, 4, 1, 5, 0, 0, 0, 0, 0, 0),
(334, 'Le manoir des sorcià¨res', '', 2011, '', 0, 4, 2, 4, 15, 20, 0, 0, 0, 0),
(335, 'Fort Boyard', '', 2002, '', 0, 7, 2, 0, 60, 60, 0, 0, 0, 0),
(336, 'Risk Star Wars', '', 2015, '', 0, 10, 2, 4, 60, 60, 0, 0, 0, 0),
(337, '1 contre 100', '', 0, '', 0, 8, 1, 4, 45, 45, 0, 0, 0, 0),
(338, 'A prendre ou à  laisser', '', 0, '', 0, 8, 2, 4, 45, 45, 0, 0, 0, 0),
(339, 'Tic tac boum', '', 0, '', 0, 10, 2, 12, 25, 25, 0, 0, 0, 0),
(340, 'Wataà¯', '', 0, '', 0, 7, 2, 4, 30, 30, 0, 0, 0, 0),
(341, 'Orléans', '', 2014, '', 0, 12, 2, 4, 90, 90, 0, 0, 0, 0),
(342, 'Cérébrale Académie', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(343, 'C\'est pas sorcier', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(344, 'End of Atlantis', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(345, 'Le Petit Verger', '', 0, '', 0, 3, 1, 4, 10, 10, 0, 0, 0, 0),
(346, 'Gambit 7', '', 2008, '', 0, 7, 3, 21, 15, 15, 0, 0, 0, 0),
(347, 'Déclic', '', 2010, '', 0, 8, 3, 8, 20, 20, 0, 0, 0, 0),
(348, 'Life, Destin, le jeu de la vie', '', 2011, '', 0, 9, 2, 6, 30, 45, 0, 0, 0, 0),
(349, 'Folix', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(350, 'Bayon', '', 2002, '', 0, 10, 2, 4, 30, 45, 0, 0, 0, 0),
(351, 'Alibi', '', 2001, '', 0, 8, 2, 5, 30, 45, 0, 0, 0, 0),
(352, 'Kaiser, wieviel schritte', '', 2005, '', 0, 6, 2, 8, 10, 20, 0, 0, 0, 0),
(353, 'Winhard', '', 2001, '', 0, 10, 2, 4, 10, 20, 0, 0, 0, 0),
(354, 'Teamwork', '', 2004, '', 0, 10, 4, 0, 10, 30, 0, 0, 0, 0),
(355, 'Big shot', '', 0, '', 0, 10, 2, 4, 0, 0, 0, 0, 0, 0),
(356, 'Ab die post', '', 1996, '', 0, 8, 3, 6, 30, 45, 0, 0, 0, 0),
(357, 'Conquistador', '', 0, '', 0, 8, 2, 4, 0, 0, 0, 0, 0, 0),
(358, 'Das riff', '', 2000, '', 0, 10, 2, 2, 45, 45, 0, 0, 0, 0),
(359, 'Aquadukt', '', 0, '', 0, 8, 2, 4, 30, 30, 0, 0, 0, 0),
(360, 'Kraut & Ruben', '', 1998, '', 0, 8, 3, 5, 20, 30, 0, 0, 0, 0),
(361, 'Carcassonne die burg', '', 2003, '', 0, 8, 2, 2, 30, 45, 0, 0, 0, 0),
(362, 'Le tour du monde en 80 jours', '', 0, '', 0, 10, 2, 6, 45, 45, 0, 0, 0, 0),
(363, 'Tamsk', '', 1998, '', 0, 0, 2, 2, 0, 0, 0, 0, 0, 0),
(364, 'Bioviva', '', 1996, '', 0, 8, 2, 6, 60, 60, 0, 0, 0, 0),
(365, 'Pow wow', '', 1996, '', 0, 10, 3, 6, 45, 45, 0, 0, 0, 0),
(366, 'Portobello market', '', 0, '', 0, 8, 2, 4, 35, 35, 0, 0, 0, 0),
(367, 'Isis et Osiris', '', 2001, '', 0, 7, 2, 4, 10, 20, 0, 0, 0, 0),
(368, 'Die kurbiskopf bande', '', 0, '', 0, 6, 2, 7, 20, 20, 0, 0, 0, 0),
(369, 'Temptation', '', 2004, '', 0, 8, 2, 6, 30, 30, 0, 0, 0, 0),
(370, 'T\'chang', '', 0, '', 0, 8, 1, 4, 20, 20, 0, 0, 0, 0),
(371, 'Dschamal', '', 2005, '', 0, 8, 3, 8, 20, 30, 0, 0, 0, 0),
(372, 'Heimlich & Co', '', 1986, '', 0, 8, 2, 7, 45, 45, 0, 0, 0, 0),
(373, 'Ou estce ?', '', 2009, '', 0, 7, 1, 5, 20, 40, 0, 0, 0, 0),
(374, 'Kippit', '', 1999, '', 0, 5, 2, 2, 10, 10, 0, 0, 0, 0),
(375, 'Topword', '', 1995, '', 0, 9, 2, 4, 0, 0, 0, 0, 0, 0),
(376, 'Razzo raketo', '', 0, '', 0, 5, 3, 6, 20, 30, 0, 0, 0, 0),
(377, 'Rubenratz', '', 0, '', 0, 5, 2, 4, 10, 10, 0, 0, 0, 0),
(378, 'Card caper', '', 1997, '', 0, 8, 2, 4, 0, 0, 0, 0, 0, 0),
(379, 'Kaleidos junior', '', 0, '', 0, 5, 2, 0, 0, 0, 0, 0, 0, 0),
(380, 'La France et ses 101 Départements', '', 2012, '', 0, 7, 2, 6, 0, 0, 0, 0, 0, 0),
(381, 'Mysterium', '', 2018, '', 0, 10, 2, 7, 42, 42, 0, 0, 0, 0),
(382, 'Can\'t stop', '', 1980, '', 1.16, 9, 2, 4, 30, 30, 0, 0, 0, 6.86),
(383, 'The Crew', '', 2020, '', 0, 10, 3, 5, 20, 20, 0, 0, 0, 0),
(384, 'Unlock Star Wars', '', 0, '', 0, 10, 1, 6, 60, 60, 0, 0, 0, 0),
(385, 'Unlock Legendary Adventures', '', 0, '', 0, 10, 1, 6, 60, 60, 0, 0, 0, 0),
(386, 'Taluva', '', 2006, '', 0, 10, 2, 4, 45, 45, 0, 0, 0, 0),
(387, 'Terra Ventura', '', 2009, '', 0, 8, 3, 6, 45, 60, 0, 0, 0, 0),
(388, 'Unlock Epic Adventures', '', 0, '', 0, 10, 1, 6, 60, 60, 0, 0, 0, 0),
(389, 'Unlock Mythic Adventures', '', 0, '', 0, 10, 1, 6, 60, 60, 0, 0, 0, 0),
(390, 'Unlock Mystery Adventures', '', 2018, '', 0, 10, 1, 6, 60, 60, 0, 0, 0, 0),
(391, 'Unlock Timeless Adventures', '', 2019, '', 0, 10, 1, 6, 60, 60, 0, 0, 0, 0),
(392, 'Mospido', '', 2015, '', 0, 6, 2, 10, 20, 30, 0, 0, 0, 0),
(393, 'Kuna Yala', '', 0, '', 0, 8, 2, 4, 20, 20, 0, 0, 0, 0),
(394, 'Poulkiri', '', 0, '', 0, 3, 2, 4, 10, 10, 0, 0, 0, 0),
(395, 'Space Planets', '', 0, '', 0, 6, 2, 4, 15, 15, 0, 0, 0, 0),
(396, 'Convoi', '', 0, '', 0, 10, 2, 2, 30, 40, 0, 0, 0, 0),
(397, 'Moby Pick', '', 2004, '', 0, 7, 3, 8, 15, 20, 0, 0, 0, 0),
(398, 'Tutti Frutti', '', 2014, '', 0, 4, 2, 6, 10, 10, 0, 0, 0, 0),
(399, 'Les chatons gourmands', '', 0, '', 0, 4, 2, 4, 15, 15, 0, 0, 0, 0),
(400, 'L\'ours Benny aide ses amis', '', 2010, '', 0, 3, 2, 4, 10, 10, 0, 0, 0, 0),
(401, 'Sommeil des Ours', '', 1998, '', 0, 4, 2, 6, 5, 15, 0, 0, 0, 0),
(402, 'Temple Inca', '', 0, '', 0, 5, 2, 6, 10, 15, 0, 0, 0, 0),
(403, 'Tournoi de Poneys', '', 0, '', 0, 4, 2, 4, 15, 15, 0, 0, 0, 0),
(404, 'Le Verger', '', 2009, '', 0, 3, 1, 6, 10, 15, 0, 0, 0, 0),
(405, 'Uno', '', 1971, '', 1.11, 6, 2, 10, 30, 30, 0, 0, 0, 5.4),
(406, 'Master mind couleurs et formes', '', 1977, '', 1.81, 8, 2, 2, 20, 20, 0, 0, 0, 5.6),
(407, '4 et c\'est gagné', '', 1974, '', 1.2, 4, 2, 2, 10, 10, 0, 0, 0, 4.9),
(408, 'Badaboum !', '', 1952, '', 1.05, 4, 1, 6, 10, 10, 0, 0, 0, 5.4),
(409, 'Mosaà co animo', '', 0, '', 0, 3, 0, 0, 0, 0, 0, 0, 0, 0),
(410, 'Geoforme', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(411, 'Cartes jetons dés', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(412, 'Coyote', '', 2004, '', 0, 10, 3, 6, 20, 30, 0, 0, 0, 0),
(413, 'La petite sorcià¨re du tonnerre', '', 2006, '', 0, 5, 2, 4, 15, 15, 0, 0, 0, 0),
(414, 'Micro Macro crime city', '', 2021, '', 0, 10, 1, 4, 15, 45, 0, 0, 0, 0),
(415, 'Welcome to the dungeon', '', 2019, '', 0, 10, 2, 4, 30, 30, 0, 0, 0, 0),
(416, 'L\'ascenseur Infernal', '', 2018, '', 0, 0, 2, 6, 0, 0, 0, 0, 0, 0),
(417, 'Sherlock Holmes Détective Conseil + extension', '', 2011, '', 0, 12, 1, 8, 60, 120, 0, 0, 0, 0),
(418, 'Tropico', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(419, 'Chabyrinthe', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(420, 'Bermudes', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(421, 'One Piece', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(422, 'Jeu apéro breton', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(423, 'Mafia de Cuba', '', 0, '', 0, 10, 6, 12, 10, 20, 0, 0, 0, 0),
(424, 'Unlock Kids', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(425, 'Attrape Rêves', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(426, 'La Chasse aux Monstres', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(427, 'Le Monstre des Couleurs', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(428, 'Unlock Escape Adventures', '', 2019, '', 2.2, 10, 1, 6, 60, 60, 0, 0, 0, 7.7),
(429, 'The Crew', '', 2020, '', 0, 10, 3, 5, 20, 20, 0, 0, 0, 0),
(430, 'Pandemic', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(431, 'Pandemic etension Brink', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(432, 'Merlin Zinzin', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(433, 'Takenoko', '', 2011, '', 1.98, 8, 2, 4, 45, 45, 0, 0, 0, 7.3),
(434, 'LADR Europe', '', 2005, '', 1.93, 8, 2, 5, 30, 60, 0, 0, 0, 7.5),
(435, 'Azul', '', 2017, '', 1.76, 8, 2, 4, 30, 45, 0, 0, 0, 7.8),
(436, 'Mon Premier Carcassonne', '', 2009, '', 1.13, 4, 2, 4, 10, 20, 0, 0, 0, 6.7),
(437, 'LADR 1er voyage', '', 2017, '', 1.6, 6, 2, 4, 15, 30, 0, 0, 0, 7),
(438, 'Cortex Challenge', '', 2018, '', 1.33, 8, 2, 6, 10, 15, 0, 0, 0, 6.6),
(439, 'Love Letter', '', 2012, '', 1.19, 10, 2, 4, 20, 20, 0, 0, 0, 7.2),
(440, 'Concept Kids animaux', '', 2018, '', 1.27, 4, 2, 12, 20, 20, 0, 0, 0, 7.1),
(441, 'Blanc manger coco', '', 2015, '', 1, 16, 3, 12, 30, 30, 0, 0, 0, 5.6),
(442, 'Blanc manger coco, la petite gâterie', '', 2015, '', 1, 16, 3, 12, 30, 30, 0, 0, 0, 6.5),
(443, 'Taggle', '', 2011, '', 1, 14, 3, 6, 20, 20, 0, 0, 0, 5.4),
(444, 'Pickomino', '', 2005, '', 1.15, 8, 2, 7, 20, 20, 0, 0, 0, 6.6),
(445, 'Ligretto', '', 1988, '', 1.18, 8, 2, 4, 10, 10, 0, 0, 0, 6.2),
(446, 'Zik', '', 2014, '', 1, 10, 3, 16, 30, 30, 0, 0, 0, 6.4),
(447, 'Pouss\' poussins', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(448, 'Barbecue Party', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(449, 'La Course aux fromages', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(450, 'Villainous Disney', '', 2019, '', 0, 10, 2, 6, 60, 60, 0, 0, 0, 0),
(451, 'The Loop', '', 2020, '', 2.75, 12, 1, 4, 60, 60, 0, 0, 0, 7.8),
(452, 'Tic tac cats', '', 2015, '', 0, 6, 2, 2, 10, 10, 0, 0, 0, 7.2),
(453, 'Little balancing', '', 0, '', 1, 2, 2, 4, 10, 10, 0, 0, 0, 5.8),
(454, 'Set junior', '', 2012, '', 1, 3, 2, 4, 15, 15, 0, 0, 0, 5.5),
(455, 'Pipolo', '', 2005, '', 1, 5, 2, 4, 10, 10, 0, 0, 0, 5.5),
(456, '1, 2, 3, comptez', '', 2012, '', 0, 5, 1, 4, 10, 10, 0, 0, 0, 5.1),
(457, 'Saute lapin', '', 2016, '', 1.33, 4, 2, 4, 10, 10, 0, 0, 0, 6.3),
(458, 'Pyramide d\'animaux', '', 2005, '', 1.05, 3, 2, 4, 15, 15, 0, 0, 0, 6.8),
(459, 'A dos de chameaux', '', 2008, '', 1, 6, 2, 4, 15, 20, 0, 0, 0, 6.5),
(460, 'Folix', '', 2008, '', 0, 6, 1, 8, 30, 30, 0, 0, 0, 4.4),
(461, 'Gare à  la toile', '', 2015, '', 1.19, 6, 2, 4, 20, 20, 0, 0, 0, 6.5),
(462, 'Kernouille', '', 2010, '', 0, 7, 2, 4, 45, 45, 0, 0, 0, 5.5),
(463, 'Khitan', '', 2012, '', 1, 8, 2, 2, 30, 30, 0, 0, 0, 4.7),
(464, 'Pique plume', '', 1997, '', 1.12, 4, 2, 4, 15, 20, 0, 0, 0, 6.6),
(465, 'Sauvons les animaux', '', 2008, '', 1, 4, 2, 4, 10, 10, 0, 0, 0, 4),
(466, 'Frutopia', '', 2021, '', 2, 8, 1, 4, 20, 50, 0, 0, 0, 7.1),
(467, 'Phantom society', '', 2013, '', 1.5, 8, 2, 4, 20, 20, 0, 0, 0, 5.8),
(468, 'Pagode', '', 2014, '', 1.87, 8, 2, 2, 30, 45, 0, 0, 0, 6.6),
(469, 'Cartes sur table', '', 2012, '', 1, 14, 3, 7, 30, 30, 0, 0, 0, 5.3),
(470, 'Saute lapin', '', 2016, '', 1.33, 4, 2, 4, 15, 15, 0, 0, 0, 6.3),
(471, 'Premier verger', '', 2009, '', 1, 2, 1, 4, 10, 10, 0, 0, 0, 6.7),
(472, 'Galérapagos', '', 2017, '', 1.27, 8, 3, 12, 20, 20, 0, 0, 0, 6.6),
(473, 'Quarto', '', 1991, '', 1.93, 8, 2, 2, 20, 20, 0, 0, 0, 6.9),
(474, 'Mémo des sons', '', 0, '', 0, 3, 2, 4, 0, 0, 0, 0, 0, 0),
(475, 'Bourricot', '', 0, '', 0, 5, 1, 3, 0, 0, 0, 0, 0, 0),
(476, 'Loto des odeurs', '', 1988, '', 1, 5, 1, 5, 15, 15, 0, 0, 0, 5.6),
(477, 'Unlock Game Adventures', '', 2019, '', 0, 10, 1, 6, 60, 60, 0, 0, 0, 0),
(478, '7 wonders architectes', '', 2022, '', 1.35, 8, 2, 7, 25, 25, 0, 0, 0, 7.1),
(479, 'Deckscape le mystà¨re de l\'Eldorado', '', 2018, '', 1.71, 12, 1, 6, 30, 90, 0, 0, 0, 6.5),
(480, 'Undo le savoir interdit', '', 2019, '', 1, 10, 2, 6, 45, 90, 0, 0, 0, 6.1),
(481, 'Le triangle des Bermudes', '', 0, '', 0, 0, 2, 6, 0, 0, 0, 0, 0, 0),
(482, 'Escape box Minecraft', '', 0, '', 0, 7, 2, 5, 45, 45, 0, 0, 0, 0),
(483, 'Trézors', '', 2018, '', 1, 7, 2, 4, 15, 15, 0, 0, 0, 6.1),
(484, '100% copains', '', 0, '', 0, 7, 2, 7, 20, 60, 0, 0, 0, 0),
(485, 'Sardines', '', 2008, '', 1, 5, 2, 4, 15, 15, 0, 0, 0, 6.1),
(486, 'Batameuh', '', 2008, '', 1, 4, 2, 4, 15, 15, 0, 0, 0, 5),
(487, 'Chrono', '', 0, '', 0, 5, 2, 4, 15, 15, 0, 0, 0, 0),
(488, 'Toc ! Toc ! Toc !', '', 2019, '', 1, 4, 2, 4, 5, 15, 0, 0, 0, 5),
(489, 'Escape game mythologie', '', 0, '', 0, 8, 0, 0, 60, 60, 0, 0, 0, 0),
(490, 'Kroki', '', 2014, '', 0, 8, 3, 8, 20, 20, 0, 0, 0, 0),
(491, 'Scary party', '', 0, '', 0, 0, 2, 6, 0, 0, 0, 0, 0, 0),
(492, '50 jeux pour s\'amuser en voiture', '', 2011, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(493, 'Knot tying game', '', 1989, '', 0, 8, 1, 2, 30, 30, 0, 0, 0, 5),
(494, 'Pià¨ge fantà´me', '', 2004, '', 1.09, 4, 5, 6, 15, 15, 0, 0, 0, 6.5),
(495, 'Monster propre', '', 2014, '', 1, 7, 2, 5, 15, 15, 0, 0, 0, 5.6),
(496, 'Saboteur', '', 2004, '', 1.32, 8, 3, 10, 30, 30, 0, 0, 0, 6.6),
(497, 'Mysterium park', '', 2020, '', 1.48, 10, 2, 6, 30, 45, 0, 0, 0, 7.1),
(498, 'Camel up', '', 2014, '', 1.47, 8, 2, 8, 20, 30, 0, 0, 0, 7),
(499, 'Sbires', '', 2016, '', 2.09, 12, 2, 5, 45, 60, 0, 0, 0, 6.9),
(500, 'T.I.M.E. stories', '', 2015, '', 2.59, 12, 2, 4, 90, 90, 0, 0, 0, 7.4),
(501, 'Monopoly Rennes', '', 2002, '', 0, 8, 2, 6, 90, 90, 0, 0, 0, 5.6),
(502, 'Woolfy', '', 2009, '', 1, 4, 1, 4, 20, 20, 0, 0, 0, 6.6),
(503, 'Le jeu du prince de Motordu', '', 2014, '', 0, 6, 2, 4, 0, 0, 0, 0, 0, 0),
(504, 'Monopoly junior', '', 1990, '', 1.2, 5, 2, 4, 45, 45, 0, 0, 0, 4.3),
(505, 'Les aventures de Tintin', '', 2011, '', 2, 8, 2, 4, 60, 60, 0, 0, 0, 5),
(506, 'La France d\'OutreMer', '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(507, 'Slam', '', 2019, '', 0, 14, 2, 6, 0, 0, 0, 0, 0, 0),
(508, 'Dixit', '', 2008, '', 1.2, 8, 3, 8, 30, 30, 0, 0, 0, 7.2),
(509, 'Carcassonne', '', 2000, '', 1.9, 7, 2, 5, 30, 45, 0, 0, 0, 7.4),
(510, 'Multi\'symo', '', 0, '', 0, 8, 2, 2, 5, 5, 0, 0, 0, 0),
(511, 'Les tribus du vent', '', 2022, '', 2.56, 14, 2, 5, 40, 200, 0, 0, 0, 7.5),
(512, 'Caverna : caverne contre caverne', '', 2017, '', 2.55, 10, 1, 2, 20, 40, 0, 0, 0, 7.1),
(513, 'Agricola terres d\'élevage', '', 2012, '', 2.35, 13, 2, 2, 30, 30, 0, 0, 0, 7.3),
(514, 'Destin de voleur', '', 2018, '', 2.8, 12, 1, 4, 45, 90, 0, 0, 0, 6.7),
(515, 'It\'s a wonderful world', '', 2019, '', 2.3, 14, 1, 5, 30, 60, 0, 0, 0, 7.7),
(516, 'cubosaurs', '', 2022, '', 31, 8, 2, 5, 20, 20, 0, 0, 0, 5),
(517, 'kingdomino', '', 2016, '', 31, 8, 2, 4, 15, 25, 0, 0, 0, 6),
(518, 'Port royal', '', 2014, '', 31, 8, 2, 5, 20, 50, 0, 0, 0, 6),
(519, 'Res arcana', '', 2019, '', 1, 12, 2, 4, 30, 60, 0, 0, 0, 6),
(520, 'Yuzu', '', 2018, '', 0, 8, 2, 10, 20, 20, 0, 0, 0, 0),
(521, 'Cubird', '', 2018, '', 31, 8, 2, 5, 20, 20, 0, 0, 0, 5),
(522, 'Skyjo', '', 2015, '', 31, 8, 2, 8, 15, 45, 0, 0, 0, 5),
(523, 'Unlock extraordinary adventure', '', 2022, '', 0, 10, 1, 6, 60, 60, 0, 0, 0, 0),
(524, 'Gosu 2:tatics', '', 2012, '', 1, 13, 2, 4, 45, 45, 0, 0, 0, 5),
(525, 'Les chateaux de bourgogne', '', 2011, '', 1, 12, 2, 4, 30, 90, 0, 0, 0, 7),
(526, 'Les pilier de la terre', '', 2006, '', 1, 12, 2, 4, 90, 120, 0, 0, 0, 6),
(527, 'Carta Impera Victoria', '', 2018, '', 1, 8, 2, 4, 20, 60, 0, 0, 0, 5),
(528, 'Five tribes', '', 2014, '', 1, 13, 2, 4, 40, 80, 0, 0, 0, 6),
(529, 'Andor', '', 2012, '', 1, 10, 2, 4, 60, 90, 0, 0, 0, 6),
(530, 'L\'age de pierre', '', 2008, '', 1, 10, 2, 4, 60, 90, 0, 0, 0, 6),
(531, 'My first triominos', '', 2002, '', 1, 4, 2, 4, 20, 30, 0, 0, 0, 4),
(532, 'Scotland Yard (édition 2014)', '', 2014, '', 31, 8, 1, 6, 45, 45, 0, 0, 0, 4),
(533, 'Les aventuriers du rail express', '', 2018, '', 1.5, 6, 2, 4, 15, 30, 0, 0, 0, 7.3),
(534, 'Chabyrinthe (édition 2007)', '', 2007, '', 1.26, 6, 2, 4, 15, 15, 0, 0, 0, 6.1),
(535, 'The Island', '', 2012, '', 1.7, 8, 2, 4, 45, 60, 0, 0, 0, 7.3),
(536, 'Parks', '', 2019, '', 2.14, 10, 1, 5, 30, 60, 0, 0, 0, 7.7),
(537, 'Mind Bug', '', 2022, '', 0, 8, 2, 2, 20, 20, 0, 0, 0, 0),
(538, 'Burger Quizz', '', 2018, '', 0, 10, 2, 7, 30, 60, 0, 0, 0, 0),
(539, 'Cash and guns', '', 0, '', 0, 10, 4, 6, 30, 30, 0, 0, 0, 0),
(540, 'Sharur evolutions', '', 0, '', 0, 12, 3, 6, 90, 90, 0, 0, 0, 0),
(541, 'Cartaventura Oklahoma', '', 2021, '', 0, 10, 1, 6, 60, 60, 0, 0, 0, 0),
(542, 'L\'âge de pierre', '', 2016, '', 0, 10, 2, 4, 60, 90, 0, 0, 0, 0),
(543, 'Le jeu du prince de motordu', '', 0, '', 0, 6, 2, 4, 0, 0, 0, 0, 0, 0),
(544, 'Petit ver luisant', '', 0, '', 0, 2, 1, 3, 0, 0, 0, 0, 0, 0),
(545, 'Escape the room  mystà¨re au manoir ', '', 0, '', 0, 10, 3, 8, 90, 0, 0, 0, 0, 0),
(546, 'Abyss', '', 2014, '', 2.32, 14, 2, 4, 30, 60, 0, 0, 0, 7.3),
(547, 'Mr Jack pocket', '', 0, '', 0, 14, 2, 2, 15, 15, 0, 0, 0, 0),
(548, 'Seuls dans l\'espace', '', 0, '', 0, 0, 2, 6, 0, 0, 0, 0, 0, 0),
(549, 'Bluff party', '', 0, '', 0, 12, 4, 50, 0, 0, 0, 0, 0, 0),
(550, 'Lincoln se met au vert', '', 0, '', 0, 8, 3, 6, 10, 0, 0, 0, 0, 0),
(551, 'Uno pocket', '', 0, '', 0, 7, 2, 10, 0, 0, 0, 0, 0, 0),
(552, 'Aficionado', '', 0, '', 0, 16, 3, 12, 0, 0, 0, 0, 0, 0),
(553, 'Katana', '', 0, '', 0, 8, 3, 7, 0, 0, 0, 0, 0, 0),
(554, 'Adventure party', '', 0, '', 0, 10, 2, 6, 120, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `movie`
--

DROP TABLE IF EXISTS `movie`;
CREATE TABLE IF NOT EXISTS `movie` (
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
  KEY `fk_movie_cinema1_idx` (`cinema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `movie`
--

INSERT INTO `movie` (`id`, `cinema_id`, `nom`, `synopsis`, `affiche`, `date_sortie`, `status`, `slug`, `created`, `modified`) VALUES
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

INSERT INTO `profil` (`user_id`, `nom`, `prenom`, `date_naissance`, `numero_voie`, `type_voie`, `nom_voie`, `code_postale`, `ville`, `point`, `created`, `modified`) VALUES
(28, 'Le Mélinaidre', 'Frédéric', '1977-04-29', 39, 'rue', 'Aimé Césaire', 56400, 'Auray', 0, '2024-04-23 20:04:44', '2024-04-24 07:09:42');

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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3;

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
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `admin` tinyint NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `connect` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_connect` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `token`, `admin`, `created`, `modified`, `connect`, `last_connect`) VALUES
(28, 'lemelinaidre@gmail.com', '$2y$10$hjjri5SVFufHWzICGTyIm.9PFx1uhR8GJsiuBtjaQwT2Vgvm02yN2', '0fa7c8f65ca378714d18579326f45ebd', 0, '2024-04-23 20:04:44', '2024-04-23 20:04:44', '2024-04-24 06:02:54', '2024-04-23 20:04:44');

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
-- Contraintes pour la table `movie`
--
ALTER TABLE `movie`
  ADD CONSTRAINT `fk_movie_cinema1` FOREIGN KEY (`cinema_id`) REFERENCES `cinema` (`id`);

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
