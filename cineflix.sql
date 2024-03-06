-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 06 mars 2024 à 17:46
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
  `cinopsys` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `affiche` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `date_sortie` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `fiche`
--

INSERT INTO `fiche` (`id`, `nom`, `cinopsys`, `affiche`, `date_sortie`, `slug`) VALUES
(1, 'inception', 'Un voleur d\'élite est capable d\'entrer dans les rêves des gens pour voler leurs secrets les plus précieux. Mais lorsqu\'il reçoit une offre pour une tâche impossible, il doit faire face à son plus grand défi.', 'public/img/movies/inception.jpg', '2010-07-15 20:00:00', 'inception'),
(2, 'interstellar', 'Dans un futur où la Terre est devenue inhabitable, un groupe d\'explorateurs entreprend un voyage interstellaire pour trouver une nouvelle planète habitable pour l\'humanité.', 'public/img/movies/interstellar.jpg', '2014-11-06 22:00:00', 'interstellar'),
(3, 'les evadés', 'Un homme est condamné à tort pour le meurtre de sa femme et est envoyé dans une prison où il se lie d\'amitié avec un détenu plus âgé et commence à planifier son évasion.', 'public/img/movies/shawshank_redemption.jpg', '1994-10-13 20:00:00', 'les_evades'),
(4, 'le parrain', 'La saga de la famille Corleone, dirigée par le patriarche Vito Corleone, qui lutte pour maintenir son empire criminel tout en naviguant dans la politique et la violence.', 'public/img/movies/godfather.jpg', '1972-03-23 22:00:00', 'le_parrain'),
(5, 'pulp fiction', 'Ce film présente plusieurs histoires entrelacées impliquant des criminels, des boxeurs, des danseurs, des tueurs à gages et des propriétaires de restaurants.', 'public/img/movies/pulp_fiction.jpg', '1994-10-13 20:00:00', 'pulp_fiction'),
(6, 'forrest gump', 'L\'histoire d\'un homme simple d\'esprit nommé Forrest Gump, qui se retrouve impliqué dans certains des moments les plus mémorables de l\'histoire américaine.', 'public/img/movies/forrest_gump.jpg', '1994-07-05 20:00:00', 'forrest_gump'),
(7, 'the dark knight, le chevalier noir', 'Batman se bat contre le Joker, un criminel sadique qui cherche à semer le chaos à Gotham City.', 'public/img/movies/dark_knight.jpg', '2008-07-17 20:00:00', 'the_dark_knight'),
(8, 'fight club', 'Un homme sans nom rencontre un vendeur de savon charismatique et tous deux créent un club de combats clandestins qui prend rapidement une tournure sombre.', 'public/img/movies/fight_club.jpg', '1999-10-14 20:00:00', 'fight_club'),
(9, 'the matrix', 'Un programmeur informatique découvre que le monde dans lequel il vit est une simulation contrôlée par des machines, et il se joint à une rébellion pour combattre ces machines.', 'public/img/movies/matrix.jpg', '1999-03-30 20:00:00', 'the_matrix'),
(10, 'le seigneur des anneaux : la communauté de l\'anneau', 'Un jeune hobbit nommé Frodo Baggins se lance dans une quête périlleuse pour détruire un anneau magique maléfique et sauver la Terre du Milieu de la tyrannie du Seigneur des Ténèbres Sauron.', 'public/img/movies/lord_fellowship.jpg', '2001-12-18 22:00:00', 'le_seigneur_des_anneaux'),
(11, 'le silence des agneaux', 'Une jeune stagiaire du FBI est chargée de solliciter l\'aide du célèbre psychiatre cannibale Hannibal Lecter pour attraper un tueur en série surnommé \"Buffalo Bill\".', 'public/img/movies/silence_lambs.jpg', '1991-02-13 22:00:00', 'le_silence_des_agneaux'),
(12, 'inglourious basterds', 'Dans la France occupée par les nazis, un groupe de soldats américains juifs est chargé de terroriser l\'armée allemande en massacrant des soldats nazis et en planifiant un assassinat de masse des hauts responsables nazis.', 'public/img/movies/inglourious_basterds.jpg', '2009-08-20 20:00:00', 'inglourious_basterds'),
(13, 'les affranchis', 'L\'ascension et la chute de Henry Hill, un gangster italo-américain, alors qu\'il gravit les échelons de la mafia.', 'public/img/movies/goodfellas.jpg', '1990-09-18 20:00:00', 'les_affranchis'),
(14, 'les infiltrés', 'Un policier infiltré dans la mafia et un membre de la mafia infiltré dans la police tentent de découvrir l\'identité de l\'autre tout en naviguant dans les intrigues et les trahisons.', 'public/img/movies/departed.jpg', '2006-10-05 20:00:00', 'les_infiltres'),
(15, 'gladiator', 'Après avoir été trahi et laissé pour mort par l\'empereur corrompu de Rome, un ancien général romain se lance dans une quête de vengeance.', 'public/img/movies/gladiator.jpg', '2000-05-04 20:00:00', 'gladiator'),
(16, 'la ligne verte', 'Dans une prison de Louisiane pendant les années 1930, un gardien de prison bienveillant découvre que l\'un de ses prisonniers a des pouvoirs surnaturels.', 'public/img/movies/green_mile.jpg', '1999-12-09 22:00:00', 'la_ligne_verte'),
(17, 'la liste de schindler', 'L\'histoire vraie d\'Oskar Schindler, un homme d\'affaires allemand qui a sauvé plus de 1 000 juifs pendant l\'Holocauste en les employant dans ses usines.', 'public/img/movies/schindlers_list.jpg', '1993-12-14 22:00:00', 'la_liste_de_schindler'),
(18, 'le prestige', 'Deux magiciens rivaux se lancent dans une compétition pour créer le meilleur numéro de magie, mais leurs tentatives pour se surpasser les uns les autres les conduisent à des extrémités dangereuses.', 'public/img/movies/prestige.jpg', '2006-10-19 20:00:00', 'le_prestige'),
(19, 'seven', 'Deux détectives de police enquêtent sur une série de meurtres inspirés par les sept péchés capitaux, et ils se retrouvent entraînés dans un jeu mortel avec le tueur.', 'public/img/movies/seven.jpg', '1995-09-21 20:00:00', 'seven');

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

DROP TABLE IF EXISTS `film`;
CREATE TABLE IF NOT EXISTS `film` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fiche_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_film_fiche1_idx` (`fiche_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `film`
--

INSERT INTO `film` (`id`, `fiche_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);

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
-- Structure de la table `metier`
--

DROP TABLE IF EXISTS `metier`;
CREATE TABLE IF NOT EXISTS `metier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `personnalite`
--

DROP TABLE IF EXISTS `personnalite`;
CREATE TABLE IF NOT EXISTS `personnalite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=305 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `personnalite`
--

INSERT INTO `personnalite` (`id`, `prenom`, `nom`) VALUES
(1, 'Brad', 'Pitt'),
(2, 'Morgan', 'Freeman'),
(3, 'Gwyneth', 'Paltrow'),
(4, 'Kevin', 'Spacey'),
(5, 'John C.', 'McGinley'),
(6, 'Endre', 'Hules'),
(7, 'Andrew Kevin', 'Walker'),
(8, 'Daniel', 'Zacapa'),
(9, 'John', 'Cassini'),
(10, 'Richard', 'Portnow'),
(11, 'Emily', 'Wagner'),
(12, 'Alfonso', 'Freeman'),
(13, 'R. Lee', 'Ermey'),
(14, 'Richard', 'Roundtree'),
(15, 'Richard', 'Schiff'),
(16, 'Mark', 'Boone Junior'),
(17, 'Peter', 'Crombie'),
(18, 'Dominique', 'Jennings'),
(19, 'Andy', 'Walker'),
(20, 'Bob', 'Mack'),
(21, 'Beverly', 'Burke'),
(22, 'Gene', 'Borkan'),
(23, 'Julie', 'Araskog'),
(24, 'Mario', 'Di Donato'),
(25, 'Bob', 'Stephenson'),
(26, 'Harrison', 'White'),
(27, 'Michael Reid', 'MacKay'),
(28, 'Michael', 'Massee'),
(29, 'Hugh', 'Jackman'),
(30, 'Christian', 'Bale'),
(31, 'Michael', 'Caine'),
(32, 'Scarlett', 'Johansson'),
(33, 'Piper', 'Perabo'),
(34, 'Rebecca', 'Hall'),
(35, 'Samantha', 'Mahurin'),
(36, 'David', 'Bowie'),
(37, 'Andy', 'Serkis'),
(38, 'Daniel', 'Davis'),
(39, 'Jim', 'Piddock'),
(40, 'Christopher', 'Neame'),
(41, 'Mark', 'Ryan'),
(42, 'Roger', 'Rees'),
(43, 'Jamie', 'Harris'),
(44, 'Monty', 'Stuart'),
(45, 'Ron', 'Perkins'),
(46, 'Ricky', 'Jay'),
(47, 'Chao Li', 'Chi'),
(48, 'William Morgan', 'Sheppard'),
(49, 'J. Paul', 'Moore'),
(50, 'Zoe', 'Merg'),
(51, 'Johnny', 'Liska'),
(52, 'Russ', 'Fega'),
(53, 'Kevin', 'Will'),
(54, 'Edward', 'Hibbert'),
(55, 'Nikki', 'Glick'),
(56, 'James', 'Otis'),
(57, 'Sam', 'Menning'),
(58, 'Christopher', 'Judges'),
(59, 'Brian', 'Tahash'),
(60, 'Scott', 'Davis'),
(61, 'Jodi Bianca', 'Wise'),
(62, 'Enn', 'Reitel'),
(63, 'Clive', 'Kennedy'),
(64, 'Rob', 'Arbogast'),
(65, 'John B.', 'Crye'),
(66, 'Chris', 'Cleveland'),
(67, 'Anthony', 'De Marco'),
(68, 'Gregory', 'Humphreys'),
(69, 'Sean', 'Howse'),
(70, 'James', 'Lancaster'),
(71, 'Julie', 'Sanfordla'),
(72, 'Ezra', 'Buzzington'),
(73, 'Olivia', 'Merg'),
(74, 'Liam', 'Neeson'),
(75, 'Ben', 'Kingsley'),
(76, 'Ralph', 'Fiennes'),
(77, 'Caroline', 'Goodall'),
(78, 'Jonathan', 'Sagall'),
(79, 'Embeth', 'Davidtz'),
(80, 'Malgoscha', 'Gebel'),
(81, 'Mark', 'Ivanir'),
(82, 'Béatrice', 'Macola'),
(83, 'Andrzej', 'Seweryn'),
(84, 'Norbert', 'Weisser'),
(85, 'Elina', 'Löwensohn'),
(86, 'Friedrich von', 'Thun'),
(87, 'Tadeusz', 'Huk'),
(88, 'Erwin', 'Leder'),
(89, 'Geno', 'Lechner'),
(90, 'Jerzy', 'Nowak'),
(91, 'Tadeusz', 'Bradecki'),
(92, 'Olaf', 'Lubaszenko'),
(93, 'Wojciech', 'Klata'),
(94, 'Henryk', 'Bista'),
(95, 'Götz', 'Otto'),
(96, 'Hans-Michael', 'Rehberg'),
(97, 'Agnieszka', 'Wagner'),
(98, 'Pawel', 'Delag'),
(99, 'Martin', 'Semmelrogge'),
(100, 'Vili', 'Matula'),
(101, 'Branko', 'Lustig'),
(102, 'Alexander', 'Strobele'),
(103, 'Jochen', 'Nickel'),
(104, 'Jeremy', 'Flynn'),
(105, 'Slawomir', 'Holland'),
(106, 'Joachim Paul', 'Assböck'),
(107, 'Ludger', 'Pistor'),
(108, 'Grzegorz', 'Damiecki'),
(109, 'Michael', 'Schneider'),
(110, 'Wilhelm', 'Manske'),
(111, 'Peter', 'Appiano'),
(112, 'Alexander', 'Held'),
(113, 'Artus', 'Matthiessen'),
(114, 'Miri', 'Fabian'),
(115, 'Rami', 'Heuberger'),
(116, 'Michael', 'Schiller'),
(117, 'Anna', 'Mucha'),
(118, 'Maja', 'Ostaszewska'),
(119, 'Haymon Maria', 'Buttinger'),
(120, 'August', 'Schmölzer'),
(121, 'Wolfgang', 'Seidenberg'),
(122, 'Georges', 'Kern'),
(123, 'Peter', 'Flechtner'),
(124, 'Jan', 'Jurewicz'),
(125, 'Maciej', 'Kozlowski'),
(126, 'Agnieszka', 'Krukówna'),
(127, 'Hans-Jörg', 'Assmann'),
(128, 'Thomas', 'Morris'),
(129, 'Maciej', 'Orlos'),
(130, 'Dorit', 'Seadia'),
(131, 'Lidia', 'Wyrobiec-Bank'),
(132, 'Jacek', 'Pulanecki'),
(133, 'Stanislaw', 'Brejdygant'),
(134, 'Beata', 'Rybotycka'),
(135, 'Ewa', 'Kolasinska'),
(136, 'Shabtai', 'Konorti'),
(137, 'Alicja', 'Kubaszewska'),
(138, 'Ryszard', 'Radwanski'),
(139, 'Wieslaw', 'Komasa'),
(140, 'Marcin', 'Grzymowicz'),
(141, 'Marek', 'Wrona'),
(142, 'Daniel', 'Del Ponte'),
(143, 'Eugeniusz', 'Priwieziencew'),
(144, 'Stanislaw', 'Koczanowicz'),
(145, 'Oliwia', 'Dabrowska'),
(146, 'Maciej', 'Winkler'),
(147, 'Adi', 'Nitzan'),
(148, 'Adam', 'Siemion'),
(149, 'Agnieszka', 'Korzeniowska'),
(150, 'Aldona', 'Grochal'),
(151, 'Alexander', 'Buczolich'),
(152, 'Andrzej', 'Welminski'),
(153, 'Anemona', 'KnutFille'),
(154, 'Tom', 'Hanks'),
(155, 'Michael Clarke', 'Duncan'),
(156, 'David', 'Morse'),
(157, 'Bonnie', 'Hunt'),
(158, 'Gary', 'Sinise'),
(159, 'James', 'Cromwell'),
(160, 'Michael', 'Jeter'),
(161, 'Doug', 'Hutchison'),
(162, 'Sam', 'Rockwell'),
(163, 'Harry Dean', 'Stanton'),
(164, 'Graham', 'Greene'),
(165, 'Barry', 'Pepper'),
(166, 'Jeffrey', 'DeMunn'),
(167, 'Patricia', 'Clarkson'),
(168, 'Eve', 'Brent'),
(169, 'William', 'Sadler'),
(170, 'Paula', 'Malcomson'),
(171, 'Rachel', 'Singer'),
(172, 'Dabbs', 'Gree'),
(173, 'Brent', 'Briscoe'),
(174, 'Bill', 'McKinney'),
(175, 'Brian', 'Libby'),
(176, 'Scotty', 'Leavenworth'),
(177, 'Bill', 'Gratton'),
(178, 'Van', 'Epperson'),
(179, 'Gary', 'Imhoff'),
(180, 'Mack', 'Miles'),
(181, 'Dee', 'Croxton'),
(182, 'Edrie', 'Warner'),
(183, 'Katelyn', 'Leavenworth'),
(184, 'Bailey', 'Drucker'),
(185, 'Evanne', 'Drucker'),
(186, 'David E.', 'Browning'),
(187, 'Rai', 'Tasco'),
(188, 'Rebecca', 'Klingler'),
(189, 'Russell', 'Crowe'),
(190, 'Joaquin', 'Phoenix'),
(191, 'Connie', 'Nielsen'),
(192, 'Oliver', 'Reed'),
(193, 'Richard', 'Harris'),
(194, 'Derek', 'Jacobi'),
(195, 'David', 'Hemmings'),
(196, 'David', 'Nicholls'),
(197, 'Djimon', 'Hounsou'),
(198, 'David', 'Schofield'),
(199, 'John', 'Shrapnel'),
(200, 'Tomas', 'Arana'),
(201, 'Ralf', 'Moeller'),
(202, 'Spencer Treat', 'Clark'),
(203, 'Tommy', 'Flanagan'),
(204, 'Giorgio', 'Cantarini'),
(205, 'Giannina', 'Scott'),
(206, 'Sven-Ole', 'Thorsen'),
(207, 'Nicholas', 'McGaughey'),
(208, 'Omid', 'Djalili'),
(209, 'Chris', 'Kelly'),
(210, 'John', 'Quinn'),
(211, 'Chick', 'Allen'),
(212, 'Billy', 'Dowd'),
(213, 'Allan', 'Corduner'),
(214, 'Mark', 'Lewis'),
(215, 'Al', 'Ashton'),
(216, 'Tony', 'Curran'),
(217, 'David', 'Bailie'),
(218, 'Gilly', 'Gilchrist'),
(219, 'Adam', 'Levy'),
(220, 'Alun', 'Raglan'),
(221, 'Said', 'Amel'),
(222, 'Michael', 'Mellinger'),
(223, 'Chris', 'Kell'),
(224, 'Ray', 'Calleja'),
(225, 'Leonardo', 'DiCaprio'),
(226, 'Matt', 'Damon'),
(227, 'Jack', 'Nicholson'),
(228, 'Ray', 'Winstone'),
(229, 'Mark', 'Wahlberg'),
(230, 'Martin', 'Sheen'),
(231, 'Anthony', 'Anderson'),
(232, 'Vera', 'Farmiga'),
(233, 'Alec', 'Baldwin'),
(234, 'Conor', 'Donovan'),
(235, 'Douglas J.', 'Aguirre'),
(236, 'Andrew', 'Aninsman'),
(237, 'Michael', 'Byron'),
(238, 'Elizabeth', 'Dings'),
(239, 'Steve', 'Flynn'),
(240, 'Steve', 'Lord'),
(241, 'Robert N.', 'Anderson'),
(242, 'Vincent', 'Bivona'),
(243, 'Kevin W.', 'Burns'),
(244, 'Robert Kar Yun', 'Chan'),
(245, 'David', 'Conley'),
(246, 'Greg', 'Connolly'),
(247, 'Derrick', 'Costa'),
(248, 'Peter', 'Crafts'),
(249, 'Zachary', 'Pauliks'),
(250, 'Robert', 'Wahlberg'),
(251, 'Lyman', 'Chen'),
(252, 'Kevin', 'Corrigan'),
(253, 'Kristen', 'Dalton'),
(254, 'Shay', 'Duffin'),
(255, 'Tom', 'Kemp'),
(256, 'Amanda', 'Lynch'),
(257, 'Tracey', 'Paleo'),
(258, 'James Badge', 'Dale'),
(259, 'David', 'O\'Hara'),
(260, 'Mark', 'Rolston'),
(261, 'Thomas B.', 'Duffy'),
(262, 'Dick', 'Hughes'),
(263, 'J.C.', 'MacKenzie'),
(264, 'Mary', 'Klug'),
(265, 'Peg', 'Saurman Holzemer'),
(266, 'Gurdeep', 'Singh'),
(267, 'William', 'Severs'),
(268, 'Douglas', 'Crosby'),
(269, 'Joseph P.', 'Reidy'),
(270, 'Terry', 'Serpico'),
(271, 'Mick', 'O\'Rourke'),
(272, 'Brian', 'Smyj'),
(273, 'Jill', 'Brown'),
(274, 'John', 'Cenatiempo'),
(275, 'Brian', 'Haley'),
(276, 'Audrie J.', 'Neenan'),
(277, 'Dorothy', 'Lyman'),
(278, 'David', 'Fischer'),
(279, 'Alex', 'Morris'),
(280, 'Chance', 'Kelly'),
(281, 'Larry', 'Mitchell'),
(282, 'Henry', 'Yuk'),
(283, 'John', 'Rue'),
(284, 'Nellie', 'Sciutto'),
(285, 'Victor', 'Chan'),
(286, 'Joseph', 'Riccobene'),
(287, 'John', 'McConnell'),
(288, 'Patrick', 'Coppola'),
(289, 'Jay', 'Giannone'),
(290, 'Ricky', 'Chan'),
(291, 'Emma Tillinger', 'Koskoff'),
(292, 'William', 'Lee'),
(293, 'John', 'Farrer'),
(294, 'Armen', 'Garo'),
(295, 'Walter', 'Wong'),
(296, 'John', 'Polce'),
(297, 'Billy', 'Smith'),
(298, 'Deborah', 'Carlson'),
(299, 'Denece', 'Ryland'),
(300, 'Dennis', 'Lynch'),
(301, 'Kenneth', 'Stoddard'),
(302, 'Daniel F.', 'Risteen Jr'),
(303, 'Andrew', 'Breving'),
(304, 'Anthony', 'Estrella');

-- --------------------------------------------------------

--
-- Structure de la table `personnalite_metier`
--

DROP TABLE IF EXISTS `personnalite_metier`;
CREATE TABLE IF NOT EXISTS `personnalite_metier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `personnalite_id` int NOT NULL,
  `metier_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `personnaliteMetier_metierId` (`metier_id`),
  KEY `personnaliteMetier_personnaliteId` (`personnalite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `personnalite_metier_fiche`
--

DROP TABLE IF EXISTS `personnalite_metier_fiche`;
CREATE TABLE IF NOT EXISTS `personnalite_metier_fiche` (
  `id` int NOT NULL AUTO_INCREMENT,
  `personnalite_metier_id` int NOT NULL,
  `fiche_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `personnaliteMetier_ficheId` (`fiche_id`),
  KEY `personnaliteMetier_metierId` (`personnalite_metier_id`)
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
-- Contraintes pour la table `personnalite_metier`
--
ALTER TABLE `personnalite_metier`
  ADD CONSTRAINT `personnaliteMetier_Metier` FOREIGN KEY (`metier_id`) REFERENCES `metier` (`id`),
  ADD CONSTRAINT `personnaliteMetier_personnalite` FOREIGN KEY (`personnalite_id`) REFERENCES `personnalite` (`id`);

--
-- Contraintes pour la table `personnalite_metier_fiche`
--
ALTER TABLE `personnalite_metier_fiche`
  ADD CONSTRAINT `personnaliteMetierFiche_FicheId` FOREIGN KEY (`fiche_id`) REFERENCES `fiche` (`id`),
  ADD CONSTRAINT `personnaliteMetierFiche_personnaliteMetierId` FOREIGN KEY (`personnalite_metier_id`) REFERENCES `personnalite_metier` (`id`);

--
-- Contraintes pour la table `streaming`
--
ALTER TABLE `streaming`
  ADD CONSTRAINT `fk_streaming_fiche1` FOREIGN KEY (`fiche_id`) REFERENCES `fiche` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
