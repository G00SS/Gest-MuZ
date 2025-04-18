-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 03 mars 2025 à 13:00
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1
-- Version de PHP : 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bmus`
--

-- --------------------------------------------------------

--  
-- Table structure for table `tconf_users`  
--  
CREATE TABLE IF NOT EXISTS `tconf_users` (  
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `username` varchar(250) NOT NULL UNIQUE,  
  `password` varchar(250) NOT NULL,  
  `role` int(11) NOT NULL DEFAULT 3, 
PRIMARY KEY (`id`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci AUTO_INCREMENT=4 ;  
--  
-- Dumping data for table `tconf_users`  
--  
INSERT INTO `tconf_users` (`id`, `username`, `password`, `role`) VALUES  
(1, 'admin', '$2y$10$tSypk612TJcaNvqJQDfZaOaxalAP1zdCjCaKOSlIxLbTf9ZpwnXOi', 1),
(2, 'superviseur', '$2y$10$joSEuCu1IY43jZIdpYvqXuthGbw7k9UqhL9w10ciqLNoYhghoXiNq', 2),
(3, 'user', '$2y$10$rQ01.N9jDXfek2nFEDiSZeng8dz.xgiRMwMmtJDqwYNrRYsg5BUva', 3);

--
-- Structure de la table `tconf_atel`
--

CREATE TABLE `tconf_atel` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `sect_id` int(11) NOT NULL DEFAULT 1,
  `expo_id` int(10) DEFAULT NULL,
  `public_id` int(11) NOT NULL DEFAULT 1,
  `seance` int(11) DEFAULT 1,
  `deb` date NOT NULL,
  `fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tconf_atel`
--

INSERT INTO `tconf_atel` (`id`, `name`, `sect_id`, `expo_id`, `public_id`, `seance`, `deb`, `fin`) VALUES
(1, 'Non Renseigné', 1, NULL, 1, 1, '2000-01-01', '3000-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `tconf_days`
--

CREATE TABLE `tconf_days` (
  `id` tinyint(15) NOT NULL,
  `FR` tinytext NOT NULL,
  `EN` tinytext NOT NULL,
  `work` tinyint(4) NOT NULL DEFAULT 0,
  `open` time NOT NULL DEFAULT '08:00:00',
  `close` time NOT NULL DEFAULT '18:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tconf_days`
--

INSERT INTO `tconf_days` (`id`, `FR`, `EN`, `work`, `open`, `close`) VALUES
(1, 'Lundi', 'Monday', 1, '08:00:00', '18:00:00'),
(2, 'Mardi', 'Tuesday', 1, '08:00:00', '18:00:00'),
(3, 'Mercredi', 'Wednesday', 1, '08:00:00', '18:00:00'),
(4, 'Jeudi', 'Thursday', 1, '08:00:00', '18:00:00'),
(5, 'Vendredi', 'Friday', 1, '08:00:00', '18:00:00'),
(6, 'Samedi', 'Saturday', 1, '08:00:00', '18:00:00'),
(7, 'Dimanche', 'Sunday', 0, '08:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `tconf_evts`
--

CREATE TABLE `tconf_evts` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `deb` date NOT NULL,
  `fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tconf_expo`
--

CREATE TABLE `tconf_expo` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `sect_id` int(11) NOT NULL,
  `deb` date NOT NULL,
  `fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tconf_grp_typ`
--

CREATE TABLE `tconf_grp_typ` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `scol` tinyint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tconf_grp_typ`
--

INSERT INTO `tconf_grp_typ` (`id`, `type`, `scol`) VALUES
(1, 'Groupe divers', 0),
(2, 'Association diverse', 0),
(3, 'Scolaires', 1);

-- --------------------------------------------------------

--
-- Structure de la table `tconf_param`
--

CREATE TABLE `tconf_param` (
  `id` int(2) NOT NULL,
  `structure` varchar(50) NOT NULL,
  `resident` varchar(50) NOT NULL,
  `collectivite` varchar(50) NOT NULL,
  `d_dept` int(10) DEFAULT NULL,
  `d_pays` int(10) DEFAULT NULL,
  `ouverture` time DEFAULT NULL,
  `fermeture` time DEFAULT NULL,
  `infos` text DEFAULT NULL,
  `indivpay` tinyint(10) NOT NULL DEFAULT 0,
  `indivgui` tinyint(10) NOT NULL DEFAULT 0,
  `grppay` tinyint(10) NOT NULL DEFAULT 0,
  `grpgui` tinyint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tconf_param`
--

INSERT INTO `tconf_param` (`id`, `structure`, `resident`, `collectivite`, `d_dept`, `d_pays`, `ouverture`, `fermeture`, `infos`) VALUES
(1, 'Etablissement', 'Gentilé', 'Com-Com', 38, 62, '08:00:00', '18:00:00', '<div class=\"col-auto\">\r\n  <span>\r\n  <b>36260</b> Diou, Migny, Paudy, Reuilly & Ste Lizaigne<br>\r\n  <b>36100</b> Les Bordes, St Georges/Arnon & Segry\r\n  </span>\r\n</div>\r\n<div class=\"col-auto\">\r\n  <span>\r\n  <b>18160</b> Chezal-Benoit<br>\r\n  <b>18290</b> Chârost & St Ambroix\r\n  </span>\r\n</div>');

-- --------------------------------------------------------

--
-- Structure de la table `tconf_publics`
--

CREATE TABLE `tconf_publics` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `scol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tconf_publics`
--

INSERT INTO `tconf_publics` (`id`, `name`, `age`, `scol`) VALUES
(1, 'Non Renseigné', 1, NULL),
(2, 'Enfants / Ados', 2, NULL),
(3, 'Jeunes-Adultes', 3, NULL),
(4, 'Adultes', 4, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tconf_secteurs`
--

CREATE TABLE `tconf_secteurs` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `class` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tconf_secteurs`
--

INSERT INTO `tconf_secteurs` (`id`, `name`, `class`) VALUES
(1, 'Non Renseigné', 'nosect'),
(2, 'Expo Permanentes', 'expop'),
(3, 'Expo Temporaires', 'expot');

-- --------------------------------------------------------

--
-- Structure de la table `tgrp`
--

CREATE TABLE `tgrp` (
  `id` int(11) NOT NULL,
  `nb` int(11) NOT NULL,
  `primo` tinyint(10) DEFAULT 0,
  `pays_id` int(11) DEFAULT NULL,
  `depts_id` int(11) DEFAULT NULL,
  `col` tinyint(10) DEFAULT 0,
  `resi` tinyint(10) DEFAULT 0,
  `public_id` int(11) DEFAULT NULL,
  `visite` varchar(10) DEFAULT NULL,
  `payant` varchar(10) DEFAULT NULL,
  `typ_id` int(11) NOT NULL DEFAULT 1,
  `atel_id` int(11) NOT NULL DEFAULT 1,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `create_time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tgrp_evts`
--

CREATE TABLE `tgrp_evts` (
  `grp_id` int(11) NOT NULL,
  `evt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tgrp_expo`
--

CREATE TABLE `tgrp_expo` (
  `grp_id` int(11) NOT NULL,
  `expo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tgrp_sect`
--

CREATE TABLE `tgrp_sect` (
  `grp_id` int(11) NOT NULL,
  `sect_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tindiv`
--

CREATE TABLE `tindiv` (
  `id` int(11) NOT NULL,
  `nb` int(11) NOT NULL,
  `primo` tinyint(10) DEFAULT 0,
  `pays_id` int(11) DEFAULT NULL,
  `depts_id` int(11) DEFAULT NULL,
  `col` tinyint(10) DEFAULT 0,
  `resi` tinyint(10) DEFAULT 0,
  `grpage_id` int(11) DEFAULT NULL,
  `famille` tinyint(10) DEFAULT 0,
  `guide` tinyint(10) DEFAULT 0,
  `payant` tinyint(10) DEFAULT 0,
  `motiv_id` int(11) DEFAULT 1,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `create_time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tindiv_evts`
--

CREATE TABLE `tindiv_evts` (
  `indiv_id` int(11) NOT NULL,
  `evt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tindiv_expo`
--

CREATE TABLE `tindiv_expo` (
  `indiv_id` int(11) NOT NULL,
  `expo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tindiv_sect`
--

CREATE TABLE `tindiv_sect` (
  `indiv_id` int(11) NOT NULL,
  `sect_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tloc_continents`
--

CREATE TABLE `tloc_continents` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tloc_continents`
--

INSERT INTO `tloc_continents` (`id`, `name`) VALUES
(1, 'Afrique'),
(2, 'Amérique du Nord'),
(3, 'Amérique du Sud'),
(4, 'Asie'),
(5, 'Europe'),
(6, 'Océanie'),
(7, 'Non Renseigné');

-- --------------------------------------------------------

--
-- Structure de la table `tloc_depts`
--

CREATE TABLE `tloc_depts` (
  `id` int(11) NOT NULL,
  `nb` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `reg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tloc_depts`
--

INSERT INTO `tloc_depts` (`id`, `nb`, `name`, `reg_id`) VALUES
(1, '00', 'Etranger', 20),
(2, '01', 'Ain', 1),
(3, '02', 'Aisne', 9),
(4, '03', 'Allier', 1),
(5, '04', 'Alpes-de-Haute-Provence', 18),
(6, '05', 'Hautes-Alpes', 18),
(7, '06', 'Alpes-Maritimes', 18),
(8, '07', 'Ardèche', 1),
(9, '08', 'Ardennes', 6),
(10, '09', 'Ariège', 16),
(11, '10', 'Aube', 6),
(12, '11', 'Aude', 16),
(13, '12', 'Aveyron', 16),
(14, '13', 'Bouches-du-Rhône', 18),
(15, '14', 'Calvados', 14),
(16, '15', 'Cantal', 1),
(17, '16', 'Charente', 15),
(18, '17', 'Charente-Maritime', 15),
(19, '18', 'Cher', 4),
(20, '19', 'Corrèze', 15),
(21, '2A', 'Corse-du-Sud', 5),
(22, '2B', 'Haute-Corse', 5),
(23, '21', 'Côte-d\'Or', 2),
(24, '22', 'Côtes-d\'Armor', 3),
(25, '23', 'Creuse', 15),
(26, '24', 'Dordogne', 15),
(27, '25', 'Doubs', 2),
(28, '26', 'Drôme', 1),
(29, '27', 'Eure', 14),
(30, '28', 'Eure-et-Loir', 4),
(31, '29', 'Finistère', 3),
(32, '30', 'Gard', 16),
(33, '31', 'Haute-Garonne', 16),
(34, '32', 'Gers', 16),
(35, '33', 'Gironde', 15),
(36, '34', 'Hèrault', 16),
(37, '35', 'Ille-et-Vilaine', 3),
(38, '36', 'Indre', 4),
(39, '37', 'Indre-et-Loire', 4),
(40, '38', 'Isère', 1),
(41, '39', 'Jura', 2),
(42, '40', 'Landes', 15),
(43, '41', 'Loir-et-Cher', 4),
(44, '42', 'Loire', 1),
(45, '43', 'Haute-Loire', 1),
(46, '44', 'Loire-Atlantique', 17),
(47, '45', 'Loiret', 4),
(48, '46', 'Lot', 16),
(49, '47', 'Lot-et-Garonne', 15),
(50, '48', 'Lozère', 16),
(51, '49', 'Maine-et-Loire', 17),
(52, '50', 'Manche', 14),
(53, '51', 'Marne', 6),
(54, '52', 'Haute-Marne', 6),
(55, '53', 'Mayenne', 17),
(56, '54', 'Meurthe-et-Moselle', 6),
(57, '55', 'Meuse', 6),
(58, '56', 'Morbihan', 3),
(59, '57', 'Moselle', 6),
(60, '58', 'Nièvre', 2),
(61, '59', 'Nord', 9),
(62, '60', 'Oise', 9),
(63, '61', 'Orne', 14),
(64, '62', 'Pas-de-Calais', 9),
(65, '63', 'Puy-de-Dôme', 1),
(66, '64', 'Pyrénées-Atlantiques', 15),
(67, '65', 'Hautes-Pyrénées', 16),
(68, '66', 'Pyrénées-Orientales', 16),
(69, '67', 'Bas-Rhin', 6),
(70, '68', 'Haut-Rhin', 6),
(71, '69', 'Rhône', 1),
(72, '70', 'Haute-Saône', 2),
(73, '71', 'Saône-et-Loire', 2),
(74, '72', 'Sarthe', 17),
(75, '73', 'Savoie', 1),
(76, '74', 'Haute-Savoie', 1),
(77, '75', 'Paris', 10),
(78, '76', 'Seine-Maritime', 14),
(79, '77', 'Seine-et-Marne', 10),
(80, '78', 'Yvelines', 10),
(81, '79', 'Deux-Sèvres', 15),
(82, '80', 'Somme', 9),
(83, '81', 'Tarn', 16),
(84, '82', 'Tarn-et-Garonne', 16),
(85, '83', 'Var', 18),
(86, '84', 'Vaucluse', 18),
(87, '85', 'Vendée', 17),
(88, '86', 'Vienne', 15),
(89, '87', 'Haute-Vienne', 15),
(90, '88', 'Vosges', 6),
(91, '89', 'Yonne', 2),
(92, '90', 'Territoire de Belfort', 2),
(93, '91', 'Essonne', 10),
(94, '92', 'Hauts-de-Seine', 10),
(95, '93', 'Seine-Saint-Denis', 10),
(96, '94', 'Val-de-Marne', 10),
(97, '95', 'Val-d\'Oise', 10),
(98, '971', 'Guadeloupe', 7),
(99, '972', 'Martinique', 12),
(100, '973', 'Guyane', 8),
(101, '974', 'La Réunion', 11),
(102, '976', 'Mayotte', 13),
(103, '98', 'TOM', 19);

-- --------------------------------------------------------

--
-- Structure de la table `tloc_globreg`
--

CREATE TABLE `tloc_globreg` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `cont_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tloc_globreg`
--

INSERT INTO `tloc_globreg` (`id`, `name`, `cont_id`) VALUES
(1, 'Afrique du Nord', 1),
(2, 'Afrique Centrale', 1),
(3, 'Afrique de l\'Est', 1),
(4, 'Afrique de l\'Ouest', 1),
(5, 'Afrique Australe', 1),
(6, 'Amérique du Nord', 2),
(7, 'Amérique Centrale', 2),
(8, 'Amérique du Sud', 3),
(9, 'Caraibes', 3),
(10, 'Moyen Orient', 4),
(11, 'Asie centrale', 4),
(12, 'Asie de l\'Est', 4),
(13, 'Asie du Sud', 4),
(14, 'Asie du Sud-Est', 4),
(15, 'Europe', 5),
(16, 'Union Européenne', 5),
(17, 'Océanie', 6),
(18, 'Non Renseigné', 7);

-- --------------------------------------------------------

--
-- Structure de la table `tloc_pays`
--

CREATE TABLE `tloc_pays` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `globreg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tloc_pays`
--

INSERT INTO `tloc_pays` (`id`, `name`, `globreg_id`) VALUES
(1, 'Afghanistan', 11),
(2, 'Afrique du Sud', 5),
(3, 'Albanie', 15),
(4, 'Algérie', 1),
(5, 'Allemagne', 16),
(6, 'Andorre', 15),
(7, 'Angola', 5),
(8, 'Antigua-et-Barbuda', 9),
(9, 'Arabie Saoudite', 10),
(10, 'Argentine', 8),
(11, 'Arménie', 10),
(12, 'Australie', 17),
(13, 'Autriche', 16),
(14, 'Azerbaïdjan', 15),
(15, 'Bahamas', 9),
(16, 'Bahreïn', 10),
(17, 'Bangladesh', 13),
(18, 'Barbade', 9),
(19, 'Belgique', 16),
(20, 'Belize', 7),
(21, 'Bénin', 4),
(22, 'Bhoutan', 13),
(23, 'Biélorussie', 15),
(24, 'Birmanie', 14),
(25, 'Bolivie', 8),
(26, 'Bosnie-Herzégovine', 15),
(27, 'Botswana', 5),
(28, 'Brésil', 8),
(29, 'Brunei', 14),
(30, 'Bulgarie', 16),
(31, 'Burkina Faso', 4),
(32, 'Burundi', 3),
(33, 'Cambodge', 14),
(34, 'Cameroun', 2),
(35, 'Canada', 6),
(36, 'Cap-Vert', 4),
(37, 'Chili', 8),
(38, 'Chine', 12),
(39, 'Chypre', 16),
(40, 'Colombie', 8),
(41, 'Comores', 5),
(42, 'Corée du Nord', 12),
(43, 'Corée du Sud', 12),
(44, 'Costa Rica', 7),
(45, 'Côte d\'Ivoire', 4),
(46, 'Croatie', 16),
(47, 'Cuba', 9),
(48, 'Danemark', 16),
(49, 'Djibouti', 3),
(50, 'Dominique', 9),
(51, 'Egypte', 1),
(52, 'Emirats arabes unis', 10),
(53, 'Equateur', 8),
(54, 'Erythrée', 3),
(55, 'Espagne', 16),
(56, 'Estonie', 16),
(57, 'Eswatini', 2),
(58, 'Etats-Unis', 6),
(59, 'Ethiopie', 3),
(60, 'Fidji', 17),
(61, 'Finlande', 16),
(62, 'France', 16),
(63, 'Gabon', 2),
(64, 'Gambie', 4),
(65, 'Géorgie', 15),
(66, 'Ghana', 4),
(67, 'Grèce', 16),
(68, 'Grenade', 9),
(69, 'Guatemala', 7),
(70, 'Guinée', 4),
(71, 'Guinée équatoriale', 2),
(72, 'Guinée-Bissau', 4),
(73, 'Guyana', 8),
(74, 'Haïti', 9),
(75, 'Honduras', 7),
(76, 'Hongrie', 16),
(77, 'Iles Cook', 17),
(78, 'Iles Marshall', 17),
(79, 'Inde', 13),
(80, 'Indonésie', 14),
(81, 'Irak', 10),
(82, 'Iran', 10),
(83, 'Irlande', 16),
(84, 'Islande', 15),
(85, 'Israël', 10),
(86, 'Italie', 16),
(87, 'Jamaïque', 9),
(88, 'Japon', 12),
(89, 'Jordanie', 10),
(90, 'Kazakhstan', 11),
(91, 'Kenya', 3),
(92, 'Kirghizistan', 11),
(93, 'Kiribati', 17),
(94, 'Kosovo', 15),
(95, 'Koweït', 10),
(96, 'Laos', 14),
(97, 'Lesotho', 5),
(98, 'Lettonie', 16),
(99, 'Liban', 10),
(100, 'Liberia', 4),
(101, 'Libye', 1),
(102, 'Liechtenstein', 15),
(103, 'Lituanie', 16),
(104, 'Luxembourg', 16),
(105, 'Macédoine', 15),
(106, 'Madagascar', 5),
(107, 'Malaisie', 14),
(108, 'Malawi', 5),
(109, 'Maldives', 13),
(110, 'Mali', 4),
(111, 'Malte', 16),
(112, 'Maroc', 1),
(113, 'Maurice', 5),
(114, 'Mauritanie', 1),
(115, 'Mexique', 4),
(116, 'Micronésie', 17),
(117, 'Moldavie', 15),
(118, 'Monaco', 15),
(119, 'Mongolie', 12),
(120, 'Monténégro', 15),
(121, 'Mozambique', 5),
(122, 'Namibie', 5),
(123, 'Nauru', 17),
(124, 'Népal', 13),
(125, 'Nicaragua', 7),
(126, 'Niger', 4),
(127, 'Nigeria', 4),
(128, 'Niue', 17),
(129, 'Norvège', 15),
(130, 'Nouvelle-Zélande', 17),
(131, 'Oman', 10),
(132, 'Ouganda', 3),
(133, 'Ouzbékistan', 11),
(134, 'Pakistan', 13),
(135, 'Palaos', 17),
(136, 'Palestine', 10),
(137, 'Panama', 7),
(138, 'Papouasie-Nouvelle-Guinée', 17),
(139, 'Paraguay', 8),
(140, 'Pays-Bas', 16),
(141, 'Pérou', 8),
(142, 'Philippines', 14),
(143, 'Pologne', 16),
(144, 'Portugal', 16),
(145, 'Qatar', 10),
(146, 'République centrafricaine', 2),
(147, 'Répub démo du Congo', 2),
(148, 'République Dominicaine', 9),
(149, 'République du Congo', 2),
(150, 'République tchèque', 16),
(151, 'Roumanie', 16),
(152, 'Royaume-Uni', 15),
(153, 'Russie', 11),
(154, 'Rwanda', 3),
(155, 'Saint-Marin', 15),
(156, 'Saint-Vincent-&-les-Gre.', 9),
(157, 'Salomon', 17),
(158, 'Salvador', 7),
(159, 'Samoa', 17),
(160, 'São Tomé-et-Principe', 2),
(161, 'Sénégal', 4),
(162, 'Serbie', 15),
(163, 'Seychelles', 3),
(164, 'Sierra Leone', 4),
(165, 'Singapour', 14),
(166, 'Slovaquie', 16),
(167, 'Slovénie', 16),
(168, 'Somalie', 3),
(169, 'Soudan', 1),
(170, 'Soudan du Sud', 3),
(171, 'Sri Lanka', 13),
(172, 'Suède', 16),
(173, 'Suisse', 15),
(174, 'Suriname', 8),
(175, 'Syrie', 10),
(176, 'Tadjikistan', 11),
(177, 'Tanzanie', 3),
(178, 'Tchad', 2),
(179, 'Thaïlande', 14),
(180, 'Timor oriental', 14),
(181, 'Togo', 4),
(182, 'Tonga', 17),
(183, 'Trinité-et-Tobago', 9),
(184, 'Tunisie', 1),
(185, 'Turkménistan', 11),
(186, 'Turquie', 10),
(187, 'Tuvalu', 17),
(188, 'Ukraine', 15),
(189, 'Uruguay', 8),
(190, 'Vanuatu', 17),
(191, 'Vatican', 15),
(192, 'Venezuela', 8),
(193, 'Viêt Nam', 14),
(194, 'Yémen', 10),
(195, 'Zambie', 5),
(196, 'Zimbabwe', 5),
(199, 'Non Renseigné', 18);

-- --------------------------------------------------------

--
-- Structure de la table `tloc_regions`
--

CREATE TABLE `tloc_regions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tloc_regions`
--

INSERT INTO `tloc_regions` (`id`, `name`) VALUES
(1, 'Auvergne-Rhône-Alpes'),
(2, 'Bourgogne-Franche-Comté'),
(3, 'Bretagne'),
(4, 'Centre-Val de Loire'),
(5, 'Corse'),
(6, 'Grand Est'),
(7, 'Guadeloupe'),
(8, 'Guyane'),
(9, 'Hauts-de-France'),
(10, 'Ile-de-France'),
(11, 'La Réunion'),
(12, 'Martinique'),
(13, 'Mayotte'),
(14, 'Normandie'),
(15, 'Nouvelle-Aquitaine'),
(16, 'Occitanie'),
(17, 'Pays de la Loire'),
(18, 'Provence-Alpes-Côte d\'Azur'),
(19, 'TOM'),
(20, 'Etranger');

-- --------------------------------------------------------

--
-- Structure de la table `tsoci_ages`
--

CREATE TABLE `tsoci_ages` (
  `id` int(11) NOT NULL,
  `age` varchar(25) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tsoci_ages`
--

INSERT INTO `tsoci_ages` (`id`, `age`, `name`) VALUES
(1, 'Non Renseigné', 'Non Renseigné'),
(2, '0 - 17 ans', 'Jeunes'),
(3, '18 - 30 ans', 'Jeunes-Adultes'),
(4, '31 - 63 ans', 'Adultes'),
(5, '64 ans et +', 'Séniors');

-- --------------------------------------------------------

--
-- Structure de la table `tsoci_motiv`
--

CREATE TABLE `tsoci_motiv` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tsoci_motiv`
--

INSERT INTO `tsoci_motiv` (`id`, `name`) VALUES
(1, 'Non Renseigné'),
(2, 'Hasard'),
(3, 'Bouche à Oreille'),
(4, 'Flyers'),
(5, 'Affiche/Panneau'),
(6, 'Article de Presse'),
(7, 'Web/Appli');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tconf_atel`
--
ALTER TABLE `tconf_atel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tconf_atel_sect1` (`sect_id`),
  ADD KEY `fk_tconf_atel_public1` (`public_id`),
  ADD KEY `fk_tconf_atel_expo1` (`expo_id`);

--
-- Index pour la table `tconf_days`
--
ALTER TABLE `tconf_days`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tconf_evts`
--
ALTER TABLE `tconf_evts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tconf_expo`
--
ALTER TABLE `tconf_expo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_expo_sect1` (`sect_id`);

--
-- Index pour la table `tconf_grp_typ`
--
ALTER TABLE `tconf_grp_typ`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tconf_param`
--
ALTER TABLE `tconf_param`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tconf_publics`
--
ALTER TABLE `tconf_publics`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tconf_secteurs`
--
ALTER TABLE `tconf_secteurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tgrp`
--
ALTER TABLE `tgrp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_individuels_nationalite10` (`pays_id`),
  ADD KEY `fk_individuels_dept10` (`depts_id`),
  ADD KEY `fk_groupes_types1` (`typ_id`),
  ADD KEY `fk_tgrp_atel1` (`atel_id`);

--
-- Index pour la table `tgrp_evts`
--
ALTER TABLE `tgrp_evts`
  ADD PRIMARY KEY (`grp_id`,`evt_id`),
  ADD KEY `evt_id` (`evt_id`);

--
-- Index pour la table `tgrp_expo`
--
ALTER TABLE `tgrp_expo`
  ADD PRIMARY KEY (`expo_id`,`grp_id`),
  ADD KEY `fk_groupes_expo_groupes1` (`grp_id`);

--
-- Index pour la table `tgrp_sect`
--
ALTER TABLE `tgrp_sect`
  ADD PRIMARY KEY (`grp_id`,`sect_id`),
  ADD KEY `fk_groupes_has_sect_sect1` (`sect_id`);

--
-- Index pour la table `tindiv`
--
ALTER TABLE `tindiv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_individuels_nationalite1` (`pays_id`),
  ADD KEY `fk_individuels_dept1` (`depts_id`),
  ADD KEY `fk_individuels_grpage1` (`grpage_id`),
  ADD KEY `fk_individuels_motiv1` (`motiv_id`);

--
-- Index pour la table `tindiv_evts`
--
ALTER TABLE `tindiv_evts`
  ADD PRIMARY KEY (`indiv_id`,`evt_id`),
  ADD KEY `evt_id` (`evt_id`) USING BTREE;

--
-- Index pour la table `tindiv_expo`
--
ALTER TABLE `tindiv_expo`
  ADD PRIMARY KEY (`indiv_id`,`expo_id`),
  ADD KEY `fk_individuels_has_expo_expo1` (`expo_id`);

--
-- Index pour la table `tindiv_sect`
--
ALTER TABLE `tindiv_sect`
  ADD PRIMARY KEY (`indiv_id`,`sect_id`),
  ADD KEY `fk_individuels_has_sect_sect1` (`sect_id`);

--
-- Index pour la table `tloc_continents`
--
ALTER TABLE `tloc_continents`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tloc_depts`
--
ALTER TABLE `tloc_depts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dept_regions1` (`reg_id`);

--
-- Index pour la table `tloc_globreg`
--
ALTER TABLE `tloc_globreg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_globreg_continents1` (`cont_id`);

--
-- Index pour la table `tloc_pays`
--
ALTER TABLE `tloc_pays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nationalite_globreg1` (`globreg_id`);

--
-- Index pour la table `tloc_regions`
--
ALTER TABLE `tloc_regions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tsoci_ages`
--
ALTER TABLE `tsoci_ages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tsoci_motiv`
--
ALTER TABLE `tsoci_motiv`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tconf_atel`
--
ALTER TABLE `tconf_atel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tconf_days`
--
ALTER TABLE `tconf_days`
  MODIFY `id` tinyint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `tconf_evts`
--
ALTER TABLE `tconf_evts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tconf_expo`
--
ALTER TABLE `tconf_expo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tconf_grp_typ`
--
ALTER TABLE `tconf_grp_typ`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tconf_param`
--
ALTER TABLE `tconf_param`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tconf_publics`
--
ALTER TABLE `tconf_publics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `tconf_secteurs`
--
ALTER TABLE `tconf_secteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tgrp`
--
ALTER TABLE `tgrp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tindiv`
--
ALTER TABLE `tindiv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tloc_continents`
--
ALTER TABLE `tloc_continents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `tloc_depts`
--
ALTER TABLE `tloc_depts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT pour la table `tloc_globreg`
--
ALTER TABLE `tloc_globreg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `tloc_pays`
--
ALTER TABLE `tloc_pays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT pour la table `tloc_regions`
--
ALTER TABLE `tloc_regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `tsoci_ages`
--
ALTER TABLE `tsoci_ages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `tsoci_motiv`
--
ALTER TABLE `tsoci_motiv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tconf_atel`
--
ALTER TABLE `tconf_atel`
  ADD CONSTRAINT `fk_tconf_atel_expo1` FOREIGN KEY (`expo_id`) REFERENCES `tconf_expo` (`id`) ON DELETE SET DEFAULT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tconf_atel_sect1` FOREIGN KEY (`sect_id`) REFERENCES `tconf_secteurs` (`id`) ON DELETE SET DEFAULT ON UPDATE CASCADE;

--
-- Contraintes pour la table `tconf_expo`
--
ALTER TABLE `tconf_expo`
  ADD CONSTRAINT `fk_expo_sect1` FOREIGN KEY (`sect_id`) REFERENCES `tconf_secteurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tgrp`
--
ALTER TABLE `tgrp`
  ADD CONSTRAINT `fk_groupes_types1` FOREIGN KEY (`typ_id`) REFERENCES `tconf_grp_typ` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_individuels_dept10` FOREIGN KEY (`depts_id`) REFERENCES `tloc_depts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_individuels_nationalite10` FOREIGN KEY (`pays_id`) REFERENCES `tloc_pays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tgrp_atel1` FOREIGN KEY (`atel_id`) REFERENCES `tconf_atel` (`id`) ON DELETE SET DEFAULT ON UPDATE CASCADE;

--
-- Contraintes pour la table `tgrp_evts`
--
ALTER TABLE `tgrp_evts`
  ADD CONSTRAINT `tgrp_evts_ibfk_1` FOREIGN KEY (`grp_id`) REFERENCES `tgrp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tgrp_evts_ibfk_2` FOREIGN KEY (`evt_id`) REFERENCES `tconf_evts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tgrp_expo`
--
ALTER TABLE `tgrp_expo`
  ADD CONSTRAINT `fk_expo_has_groupes_expo1` FOREIGN KEY (`expo_id`) REFERENCES `tconf_expo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_groupes_expo_groupes1` FOREIGN KEY (`grp_id`) REFERENCES `tgrp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tgrp_sect`
--
ALTER TABLE `tgrp_sect`
  ADD CONSTRAINT `fk_groupes_has_sect_groupes1` FOREIGN KEY (`grp_id`) REFERENCES `tgrp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_groupes_has_sect_sect1` FOREIGN KEY (`sect_id`) REFERENCES `tconf_secteurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tindiv`
--
ALTER TABLE `tindiv`
  ADD CONSTRAINT `fk_individuels_dept1` FOREIGN KEY (`depts_id`) REFERENCES `tloc_depts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_individuels_grpage1` FOREIGN KEY (`grpage_id`) REFERENCES `tsoci_ages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_individuels_motiv1` FOREIGN KEY (`motiv_id`) REFERENCES `tsoci_motiv` (`id`) ON DELETE SET DEFAULT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_individuels_nationalite1` FOREIGN KEY (`pays_id`) REFERENCES `tloc_pays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tindiv_evts`
--
ALTER TABLE `tindiv_evts`
  ADD CONSTRAINT `tindiv_evts_ibfk_1` FOREIGN KEY (`indiv_id`) REFERENCES `tindiv` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tindiv_evts_ibfk_2` FOREIGN KEY (`evt_id`) REFERENCES `tconf_evts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tindiv_expo`
--
ALTER TABLE `tindiv_expo`
  ADD CONSTRAINT `fk_individuels_has_expo_expo1` FOREIGN KEY (`expo_id`) REFERENCES `tconf_expo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_individuels_has_expo_individuels1` FOREIGN KEY (`indiv_id`) REFERENCES `tindiv` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tindiv_sect`
--
ALTER TABLE `tindiv_sect`
  ADD CONSTRAINT `fk_individuels_has_sect_individuels1` FOREIGN KEY (`indiv_id`) REFERENCES `tindiv` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_individuels_has_sect_sect1` FOREIGN KEY (`sect_id`) REFERENCES `tconf_secteurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tloc_depts`
--
ALTER TABLE `tloc_depts`
  ADD CONSTRAINT `fk_dept_regions1` FOREIGN KEY (`reg_id`) REFERENCES `tloc_regions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tloc_globreg`
--
ALTER TABLE `tloc_globreg`
  ADD CONSTRAINT `fk_globreg_continents1` FOREIGN KEY (`cont_id`) REFERENCES `tloc_continents` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tloc_pays`
--
ALTER TABLE `tloc_pays`
  ADD CONSTRAINT `fk_nationalite_globreg1` FOREIGN KEY (`globreg_id`) REFERENCES `tloc_globreg` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
