-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : sam. 20 sep. 2025 à 15:54
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
-- Base de données : `naha`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE `activite` (
  `id_utilisateur` int(11) NOT NULL,
  `id_sport` int(11) NOT NULL,
  `date_sport` date NOT NULL,
  `duree_minutes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `consommation`
--

CREATE TABLE `consommation` (
  `id_utilisateur` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `date_conso` date NOT NULL,
  `quantite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id_produit` int(11) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `nom_produit` varchar(255) DEFAULT NULL,
  `energie_kcal` int(11) DEFAULT NULL,
  `proteines` float DEFAULT NULL,
  `glucides` float DEFAULT NULL,
  `sucres` float DEFAULT NULL,
  `lipides` float DEFAULT NULL,
  `acides_gras_satures` float DEFAULT NULL,
  `fibres` float DEFAULT NULL,
  `sel` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id_produit`, `brand`, `nom_produit`, `energie_kcal`, `proteines`, `glucides`, `sucres`, `lipides`, `acides_gras_satures`, `fibres`, `sel`) VALUES
(2, 'Danone', 'Activia Fruits Fraise', 72, 4.9, 10.2, 11.6, 3.6, 1.3, 0.8, 0.12),
(3, 'Danone', 'Activia Fruits Abricot', 105, 3, 13.3, 8.7, 3.9, 1.1, 0.9, 0.19),
(4, 'Danone', 'Activia 0% Nature', 62, 3.5, 10, 6.7, 0.7, 0.2, 0.5, 0.17),
(5, 'Danone', 'Activia 0% Fruits', 54, 4.2, 9.5, 9.1, 3.5, 1.7, 0.9, 0.2),
(6, 'Danone', 'Danette Chocolat', 90, 4.8, 10.4, 8.5, 1.3, 0, 0.8, 0.11),
(7, 'Danone', 'Danette Vanille', 93, 4.3, 6.2, 10.9, 0.6, 0.8, 0.5, 0.08),
(8, 'Danone', 'Danette Caramel', 91, 4.2, 14.6, 9.5, 1.3, 1.4, 0.4, 0.15),
(9, 'Danone', 'Danette Café', 76, 3.1, 13, 9.4, 1.7, 0.1, 0.8, 0.19),
(10, 'Danone', 'Danette Pistache', 105, 4, 7.7, 9.8, 2.7, 0.9, 0.9, 0.06),
(11, 'Danone', 'Actimel Nature', 96, 4.6, 6.1, 10.2, 0.3, 1.4, 0.9, 0.19),
(12, 'Danone', 'Actimel Fraise', 93, 4.5, 10.8, 6.1, 2.5, 1.9, 0.7, 0.12),
(13, 'Danone', 'Actimel Multifruits', 70, 3.3, 8.3, 8.1, 1.3, 0.5, 0.4, 0.16),
(14, 'Danone', 'Taillefine 0% Nature', 58, 4.4, 14.2, 9.3, 2.2, 0.6, 0, 0.12),
(15, 'Danone', 'Taillefine 0% Vanille', 67, 4.4, 13.5, 5.6, 2.1, 1, 0.2, 0.11),
(16, 'Danone', 'Danonino Fraise', 283, 9.7, 41.6, 18.3, 13.5, 3.2, 1.2, 0.61),
(17, 'Danone', 'Danonino Banane', 374, 7.5, 24.8, 7.6, 6.7, 3.9, 3.2, 0.12),
(18, 'Danone', 'Oikos Nature', 60, 4, 8.1, 6.4, 1.2, 1.7, 0.3, 0.1),
(19, 'Danone', 'Oikos Fruits Rouges', 78, 3.5, 9.7, 5.6, 1.2, 1.7, 1, 0.19),
(20, 'Danone', 'Danacol Nature', 120, 4.4, 14.4, 7.1, 2.7, 1.4, 0.1, 0.06),
(21, 'Nestlé', 'Purée Mousline', 333, 6.1, 35.8, 2.9, 8.7, 6.9, 0.4, 0.87),
(22, 'Nestlé', 'Nesquik Cacao', 351, 11.7, 66.8, 18.4, 4.4, 0.4, 7, 0.07),
(23, 'Nestlé', 'Céréales Chocapic', 340, 11.9, 70.6, 5.6, 3.1, 1.4, 2.2, 0.03),
(24, 'Nestlé', 'Céréales Lion', 343, 11.5, 72.2, 1.6, 6.6, 1.6, 8.1, 0.07),
(25, 'Nestlé', 'Crunch', 225, 6.3, 41.2, 3.9, 7.4, 2.1, 1.1, 0.24),
(26, 'Nestlé', 'Smarties', 493, 7.2, 52, 39.3, 34.3, 16.9, 4.9, 0.09),
(27, 'Nestlé', 'KitKat', 393, 13.7, 15.3, 20.7, 12.8, 2.8, 2.6, 0.11),
(28, 'Nestlé', 'After Eight', 343, 14.5, 34.9, 28.2, 12.3, 4.9, 2.4, 0.99),
(29, 'Nestlé', 'Quality Street', 271, 9.2, 46.1, 21, 5.1, 4.5, 4.3, 0.61),
(30, 'Nestlé', 'Nestlé Dessert Noir', 329, 10.5, 23.4, 27.6, 18.2, 4.9, 1.1, 0.87),
(31, 'Nestlé', 'Céréales Nesquik', 372, 12.7, 75.8, 5.4, 1.1, 0.5, 9.1, 0.07),
(32, 'Nestlé', 'Cookie Crisp', 433, 5.2, 50.2, 37.1, 34.7, 18.1, 1.1, 0.18),
(33, 'Nestlé', 'Golden Grahams', 214, 10.1, 49, 18.3, 15.9, 4.8, 0.3, 0.86),
(34, 'Nestlé', 'Ricoré', 273, 13.4, 26.7, 8.8, 8, 8, 1.9, 0.68),
(35, 'Nestlé', 'Nescafé Classic', 340, 11.4, 54.1, 11.6, 17.5, 6.1, 1.4, 0.35),
(36, 'Nestlé', 'Nespresso Capsules', 317, 7.8, 31.6, 6.1, 5.6, 2.4, 1, 1.01),
(37, 'Nestlé', 'Fitness Chocolat', 541, 7.3, 64.3, 43.9, 26.3, 15.1, 5.2, 0.5),
(38, 'Nestlé', 'Chocapic Bio', 375, 7.1, 70.8, 18.9, 6.9, 0.3, 2.8, 0.09),
(39, 'Nestlé', 'Nesquik Sans Sucres', 343, 11.7, 75.5, 20, 5.3, 0.2, 2.8, 0.03),
(40, 'Nestlé', 'Nestlé Dessert Lait', 387, 11.9, 19.6, 22.4, 17.7, 9.2, 2.7, 1.1),
(41, 'Président', 'Beurre Doux', 633, 6.9, 4.6, 2.3, 56.8, 35.4, 1.5, 1.11),
(42, 'Président', 'Beurre Demi-Sel', 383, 14.4, 1, 0.7, 31.9, 53.9, 1, 1.73),
(43, 'Président', 'Emmental Râpé', 297, 15.2, 0.2, 1.6, 62, 52.8, 2, 1.55),
(44, 'Président', 'Camembert', 514, 22.3, 1.9, 2.8, 20.5, 31.6, 0.1, 0.91),
(45, 'Président', 'Brie', 433, 16.5, 3, 0.5, 20.5, 46.4, 0.6, 1.47),
(46, 'Président', 'Mozzarella', 608, 27.8, 1.3, 0.1, 54.3, 25, 0.1, 1.87),
(47, 'Président', 'Crème Fraîche Epaisse', 262, 10.7, 2.7, 0.2, 28.8, 44.7, 0.8, 2.17),
(48, 'Président', 'Crème Fraîche Légère', 435, 8.3, 0.7, 1.9, 57, 32.7, 0.4, 1.12),
(49, 'Président', 'Lait UHT Demi-écrémé', 326, 9.5, 20.5, 19.9, 13.6, 9.3, 2.6, 0.68),
(50, 'Président', 'Chantilly', 223, 11.5, 12.5, 16, 12.2, 3.4, 1.6, 1),
(51, 'Président', 'Comté', 382, 3.5, 34.2, 28.5, 12.8, 2.2, 3, 0.9),
(52, 'Président', 'Cantal', 362, 9.7, 54.8, 15, 13.2, 3.7, 2.6, 0.39),
(53, 'Président', 'Raclette', 733, 24.7, 0.1, 0.5, 80.8, 24.7, 1.5, 2.19),
(54, 'Président', 'Fromage à Tartiner', 484, 10.3, 3.4, 1.7, 44.8, 39, 1.9, 1.2),
(55, 'Président', 'Beurre Fin', 359, 18.6, 3.1, 3, 53, 41.3, 1.9, 1.16),
(56, 'Président', 'Gouda', 591, 18.1, 3.5, 1.1, 60.3, 23.4, 1.6, 1.21),
(57, 'Président', 'Emmental Bloc', 292, 25.2, 1.5, 1.6, 80.4, 33.3, 0.3, 1.21),
(58, 'Président', 'Parmesan Râpé', 362, 14.7, 37.5, 9.9, 15.4, 6.9, 4, 0.7),
(59, 'Président', 'Crème Liquide', 642, 23.4, 0.5, 0.6, 51, 52.7, 1, 2.03),
(60, 'Président', 'Crème Dessert Vanille', 557, 23.6, 1.7, 2.5, 50.9, 27.9, 0.9, 1.32),
(61, 'Yoplait', 'Panier Fraise', 314, 7.6, 15.5, 11.2, 12.1, 7.3, 2.7, 0.6),
(62, 'Yoplait', 'Panier Abricot', 252, 7.7, 12.7, 28.1, 18.4, 10, 4.1, 0.66),
(63, 'Yoplait', 'Petits Filous Nature', 52, 5, 13.5, 6.9, 3.8, 1.9, 0.9, 0.17),
(64, 'Yoplait', 'Perle de Lait Nature', 58, 3.6, 11.5, 9.5, 0.9, 0.7, 0.2, 0.08),
(65, 'Yoplait', 'Yop Fraise', 49, 4.1, 6.6, 11.9, 3.8, 1.6, 0.2, 0.11),
(66, 'Yoplait', 'Yop Vanille', 68, 3.3, 10.7, 5.5, 3.8, 1.3, 0.2, 0.11),
(67, 'Yoplait', 'Yop Banane', 88, 3.8, 6.3, 8.7, 2.7, 0.7, 0, 0.17),
(68, 'Yoplait', 'Calin Nature', 224, 3.9, 51.1, 7, 5.3, 9.7, 4.7, 0.15),
(69, 'Yoplait', 'Calin Fruits', 391, 4.8, 35.6, 1.6, 5.1, 10, 2.7, 0.97),
(70, 'Yoplait', 'Perle de Lait Coco', 56, 3.1, 14.5, 8.2, 2.1, 1.8, 0.4, 0.07),
(71, 'Yoplait', 'Perle de Lait Citron', 67, 4.5, 13.4, 12, 2.6, 0.8, 0.4, 0.16),
(72, 'Yoplait', 'Frubes Fraise', 210, 3.9, 54.4, 1.6, 8, 8.5, 2.8, 0.39),
(73, 'Yoplait', 'Frubes Abricot', 224, 12.3, 21.5, 13.9, 11.2, 3.9, 1.5, 0.83),
(74, 'Yoplait', 'Yoplait Bio Nature', 116, 3.9, 14.4, 9.9, 3.5, 1.3, 0.6, 0.13),
(75, 'Yoplait', 'Yop Chocolat', 59, 4.9, 6.4, 6.1, 2.1, 1.9, 0.9, 0.13),
(76, 'Yoplait', 'Yop Framboise', 69, 3.3, 14.6, 11, 3.9, 1.1, 0.6, 0.19),
(77, 'Yoplait', 'Yoplait Panier Framboise', 69, 4.4, 9.4, 6.7, 1.1, 1.7, 0.6, 0.15),
(78, 'Yoplait', 'Panier Pêche', 357, 3.1, 46.7, 19.7, 13.9, 7.4, 3.4, 1.12),
(79, 'Yoplait', 'Perle de Lait Vanille', 77, 3.4, 6.1, 9, 1.5, 0.7, 0.6, 0.12),
(80, 'Yoplait', 'Petits Filous Fraise', 99, 4.5, 5.8, 8.8, 0.6, 0.2, 0.2, 0.17),
(81, 'Fleury Michon', 'Jambon Cuit', 196, 20.1, 4.4, 0.1, 12.8, 5.9, 0.6, 2.98),
(82, 'Fleury Michon', 'Jambon Sans Nitrite', 100, 13.7, 2.3, 0.2, 13.5, 7.1, 0.1, 1.17),
(83, 'Fleury Michon', 'Dés de Jambon', 199, 21.4, 0.1, 0.1, 8.7, 8.9, 0.4, 1.41),
(84, 'Fleury Michon', 'Bâtonnets de Surimi', 301, 3.1, 16.7, 23.4, 6.4, 3.4, 4, 0.63),
(85, 'Fleury Michon', 'Filets de Poulet', 237, 20.9, 3.3, 0.2, 13.4, 7.2, 0.1, 2.21),
(86, 'Fleury Michon', 'Dinde Rôtie', 166, 19.9, 3.1, 1, 9.4, 4.3, 0.7, 2.86),
(87, 'Fleury Michon', 'Saucisson à l\'Ail', 109, 24.5, 2.9, 1.2, 11.2, 8.6, 0.9, 1.4),
(88, 'Fleury Michon', 'Pâté de Campagne', 171, 21.4, 0.9, 0, 19.4, 4.5, 0.5, 2.7),
(89, 'Fleury Michon', 'Rillettes de Poulet', 206, 12.2, 4.3, 0.1, 15.9, 2.8, 0.6, 1.18),
(90, 'Fleury Michon', 'Rillettes de Thon', 268, 14.5, 0.1, 1.3, 15.2, 3.5, 0.5, 2.91),
(91, 'Fleury Michon', 'Salade Composée Thon', 58, 5.1, 6.8, 2.5, 1.3, 1, 6.5, 0.05),
(92, 'Fleury Michon', 'Salade Poulet Caesar', 159, 23.3, 5, 1.4, 20.1, 4.2, 0.5, 2.22),
(93, 'Fleury Michon', 'Couscous', 345, 8.6, 72.8, 13.1, 1.5, 1.4, 9.6, 0.05),
(94, 'Fleury Michon', 'Paella', 314, 14.8, 41.4, 22, 5.2, 9.2, 4.6, 0.25),
(95, 'Fleury Michon', 'Quiche Lorraine', 367, 5, 20.3, 27.3, 9.8, 6.8, 3.9, 0.36),
(96, 'Fleury Michon', 'Lasagnes Bolognaise', 402, 7.7, 69.6, 15.4, 1.4, 1.9, 2.3, 0.07),
(97, 'Fleury Michon', 'Hachis Parmentier', 272, 12.6, 30.3, 6.1, 17.5, 5.5, 2.1, 1.02),
(98, 'Fleury Michon', 'Gratin Dauphinois', 351, 6.1, 25.5, 2, 9.5, 3, 2, 0.3),
(99, 'Fleury Michon', 'Tagliatelles Bolognaise', 390, 8.4, 72.1, 9.3, 3.5, 0.9, 3.5, 0.03),
(100, 'Fleury Michon', 'Poulet Rôti Tranches', 153, 15, 2.8, 0.4, 15.6, 7.3, 0, 1.56),
(101, 'Herta', 'Jambon Le Bon Paris', 162, 22.1, 3, 1, 13.5, 2.3, 0.4, 1.31),
(102, 'Herta', 'Knacki Original', 245, 21.9, 4.3, 0.7, 10.8, 4.9, 0.2, 2.52),
(103, 'Herta', 'Pâte Brisée', 327, 6.3, 22.1, 21.3, 11.9, 2.4, 0.2, 0.89),
(104, 'Herta', 'Pâte Feuilletée', 351, 4.1, 50.7, 28.4, 16.4, 8.3, 3.8, 0.42),
(105, 'Herta', 'Pâte à Pizza', 334, 5.9, 29.1, 27.4, 7.4, 8, 2.8, 0.52),
(106, 'Herta', 'Lardons Allumettes', 266, 18.4, 3.6, 0.6, 21.9, 6.8, 0.4, 1.61),
(107, 'Herta', 'Bacon Fumé', 246, 21.4, 4.4, 0, 9.2, 4.6, 0.8, 1.61),
(108, 'Herta', 'Saucisse de Strasbourg', 217, 17.5, 0.3, 0.6, 19.7, 8.4, 0.2, 3.11),
(109, 'Herta', 'Chorizo Tranché', 364, 11.1, 75.8, 3, 1.5, 1.5, 8.9, 0.08),
(110, 'Herta', 'Saucisson Sec', 237, 18.9, 3.4, 0.6, 6.5, 4.4, 0.1, 2.05),
(111, 'Herta', 'Pâté en Croûte', 267, 23.6, 3.3, 0.6, 14.6, 7.1, 0.3, 2.63),
(112, 'Herta', 'Rillettes de Porc', 265, 15.8, 4.7, 0.8, 11.7, 8.5, 0.2, 1.47),
(113, 'Herta', 'Tartes Salées Quiche', 400, 5.3, 42.6, 19.7, 7.4, 8.5, 3.4, 0.53),
(114, 'Herta', 'Mini Pizza Base', 219, 4.8, 50.7, 26.9, 18.6, 4.1, 4.5, 1.16),
(115, 'Herta', 'Hot Dog Knacki', 199, 22.1, 2.9, 1, 15.7, 4.3, 0.6, 2.43),
(116, 'Herta', 'Knacki Ball', 245, 17.9, 2.3, 0.7, 12.6, 4.7, 0.6, 2.01),
(117, 'Herta', 'Saucisse Végétarienne', 235, 17.1, 1.5, 1.6, 15.3, 2.1, 0, 2.42),
(118, 'Herta', 'Haché Végétal', 215, 8.2, 27.3, 8.4, 15.3, 3.6, 3.1, 0.9),
(119, 'Herta', 'Jambon Bio', 242, 14.8, 4.5, 1.4, 10, 4.1, 0.5, 2.19),
(120, 'Herta', 'Lardons Fumés', 203, 12.4, 2.2, 0.5, 16.5, 5.8, 0.4, 1.66),
(121, 'Bonduelle', 'Maïs en Conserve', 40, 3.7, 7.1, 3.1, 0.7, 0.9, 6.4, 0.02),
(122, 'Bonduelle', 'Petits Pois Carottes', 95, 2.8, 3.9, 4.3, 0.6, 0.3, 4, 0.11),
(123, 'Bonduelle', 'Haricots Verts', 26, 4, 7.6, 1.4, 1, 0.7, 2.6, 0.08),
(124, 'Bonduelle', 'Pois Chiches', 39, 2.8, 6.1, 3.9, 0.3, 0.5, 5.9, 0.13),
(125, 'Bonduelle', 'Lentilles', 97, 4.5, 13.7, 5.4, 0.8, 0.9, 5.7, 0.07),
(126, 'Bonduelle', 'Flageolets', 322, 4.4, 54.6, 12.9, 14.8, 9, 1.8, 0.64),
(127, 'Bonduelle', 'Champignons émincés', 250, 9.5, 32.4, 9.4, 6.4, 7.5, 3.5, 0.18),
(128, 'Bonduelle', 'Macédoine de Légumes', 52, 2.4, 14.5, 3.8, 0.2, 0.3, 2.8, 0.13),
(129, 'Bonduelle', 'Mélange Mexicain', 295, 12.7, 42.7, 20.8, 14.2, 2.3, 1.6, 0.71),
(130, 'Bonduelle', 'Épinards en branches', 108, 1.9, 5.6, 1.1, 2, 0.3, 3.1, 0.02),
(131, 'Bonduelle', 'Brocolis', 103, 5.7, 11.4, 5.1, 1.6, 0.9, 4, 0.24),
(132, 'Bonduelle', 'Carottes Râpées', 23, 5.1, 12.4, 5.1, 0.5, 1, 2, 0.17),
(133, 'Bonduelle', 'Betteraves Cuites', 94, 2.8, 7.5, 5.5, 0.2, 0.2, 2.1, 0.11),
(134, 'Bonduelle', 'Courgettes', 392, 11.7, 20.4, 3.3, 12, 4, 3.2, 0.81),
(135, 'Bonduelle', 'Pois Gourmands', 67, 5, 14.4, 1.2, 0.5, 0.6, 3.2, 0.05),
(136, 'Bonduelle', 'Salade Iceberg', 96, 1.5, 8.9, 5.7, 1.4, 0.3, 1.8, 0.11),
(137, 'Bonduelle', 'Salade Roquette', 68, 5.7, 14.1, 3.9, 2.8, 0.8, 4.9, 0.07),
(138, 'Bonduelle', 'Salade Mâche', 94, 3.8, 10.7, 3.2, 1.1, 0.8, 3.1, 0.06),
(139, 'Bonduelle', 'Salade Mélange', 91, 1.2, 14.5, 2.9, 1.1, 0.2, 1.8, 0.15),
(140, 'Bonduelle', 'Maïs Bio', 44, 3.4, 14.8, 3.3, 1.1, 0.7, 6.1, 0.22),
(141, 'Lustucru', 'Coquillettes', 333, 11.8, 31.7, 10.1, 18.6, 8.5, 2.4, 0.81),
(142, 'Lustucru', 'Penne', 404, 11.1, 71.4, 12.7, 2.4, 0.4, 4.2, 0.09),
(143, 'Lustucru', 'Spaghetti', 336, 12, 79.1, 7.9, 4.2, 0.6, 4.5, 0.04),
(144, 'Lustucru', 'Tagliatelles', 341, 10.3, 77.4, 15.2, 7.1, 1.5, 4.2, 0.08),
(145, 'Lustucru', 'Farfalle', 351, 9.9, 76.8, 8.3, 2.4, 0.5, 5, 0.03),
(146, 'Lustucru', 'Riz Long', 383, 9.1, 73.9, 9.2, 7.9, 1.6, 6.9, 0.02),
(147, 'Lustucru', 'Riz Basmati', 344, 7.4, 74.1, 3.2, 3.5, 1.6, 8.3, 0.09),
(148, 'Lustucru', 'Riz Thaï', 351, 12.5, 74.3, 9.7, 2.6, 1.9, 9.7, 0.05),
(149, 'Lustucru', 'Riz Complet', 334, 7.6, 71.9, 18, 4.6, 1.9, 7.7, 0.08),
(150, 'Lustucru', 'Riz Parfumé', 371, 12.7, 68.6, 6.8, 4.1, 1.5, 3.5, 0.04),
(151, 'Lustucru', 'Riz Étuvé', 354, 10.1, 75.4, 2.1, 4.6, 1.2, 4.2, 0.05),
(152, 'Lustucru', 'Riz Rond', 392, 9.2, 67.4, 19.4, 4, 0.8, 8.9, 0.04),
(153, 'Lustucru', 'Riz à Risotto', 340, 9.6, 72.1, 15.1, 5.1, 0.5, 2.3, 0.08),
(154, 'Lustucru', 'Pâtes Fraîches Tortellini', 399, 12.8, 79.4, 1.3, 6.1, 0.9, 6.7, 0.02),
(155, 'Lustucru', 'Pâtes Fraîches Ravioli', 352, 9, 76.4, 16.5, 3.6, 1.7, 2.2, 0.09),
(156, 'Lustucru', 'Pâtes Fraîches Tagliatelles', 348, 9.9, 76.6, 13.4, 5.9, 1.6, 9, 0.1),
(157, 'Lustucru', 'Riz Sushi', 330, 7.6, 67.9, 11.1, 4.4, 1.5, 7.8, 0.04),
(158, 'Lustucru', 'Riz Bio', 335, 11.3, 65.5, 18.2, 6.7, 0.6, 2.4, 0.08),
(159, 'Lustucru', 'Pâtes Sans Gluten', 389, 7.9, 72, 19.7, 5.8, 1.2, 8.4, 0.05),
(160, 'Lustucru', 'Gnocchi à Poêler', 375, 10, 25, 5.6, 15.6, 9.1, 3.2, 0.69),
(161, 'Panzani', 'Spaghetti', 334, 9.2, 70.4, 12.1, 6.7, 1, 8, 0.05),
(162, 'Panzani', 'Coquillettes', 367, 12.6, 46.6, 22.3, 11.2, 6.8, 1.6, 0.55),
(163, 'Panzani', 'Tagliatelles', 330, 8.8, 72.1, 11.3, 7.7, 1.6, 6.4, 0.02),
(164, 'Panzani', 'Penne Rigate', 409, 7.8, 75.8, 7.3, 5.2, 1.5, 3.9, 0.05),
(165, 'Panzani', 'Fusilli', 368, 11.1, 79.2, 15.7, 4.1, 0.3, 7.7, 0.06),
(166, 'Panzani', 'Macaroni', 362, 9.3, 55, 13.4, 19.6, 6.1, 1.1, 0.46),
(167, 'Panzani', 'Lasagnes', 356, 12.1, 70.5, 9.8, 3.6, 1.4, 6.2, 0.06),
(168, 'Panzani', 'Cannelloni', 259, 11.9, 13.4, 14.5, 19.7, 8.5, 4.4, 0.8),
(169, 'Panzani', 'Capellini', 287, 4, 15.5, 12.9, 19.2, 6.5, 1.7, 0.9),
(170, 'Panzani', 'Pâtes Bio', 396, 8, 67.5, 13.7, 1.6, 1.3, 2.1, 0.01),
(171, 'Panzani', 'Sauce Bolognaise', 297, 0.2, 11.8, 9.3, 56.5, 12.4, 0.8, 0.84),
(172, 'Panzani', 'Sauce Tomate Basilic', 399, 1.7, 4.8, 7.9, 15.7, 17.9, 1.1, 1.97),
(173, 'Panzani', 'Sauce Carbonara', 273, 0.1, 9.2, 13.1, 21.3, 17.7, 1.2, 2.53),
(174, 'Panzani', 'Sauce Arrabbiata', 458, 0.7, 18.6, 11, 41.7, 13.6, 0.7, 0.85),
(175, 'Panzani', 'Sauce 4 Fromages', 514, 0, 14.3, 7.7, 37.2, 15.2, 1.3, 0.93),
(176, 'Panzani', 'Sauce Champignons', 664, 0.7, 18, 11.8, 20.8, 2.5, 1, 2.71),
(177, 'Panzani', 'Sauce Napolitaine', 456, 0.1, 2.1, 8.8, 33.6, 2.1, 1.2, 2.09),
(178, 'Panzani', 'Ravioli', 381, 12.8, 73.9, 13.8, 3, 1.2, 5.3, 0.05),
(179, 'Panzani', 'Tortellini', 292, 6, 27, 2.2, 5.7, 9.6, 4.8, 1.14),
(180, 'Panzani', 'Gnocchi', 391, 7.5, 39.3, 5.1, 14.6, 4.1, 1.8, 0.43),
(181, 'Barilla', 'Spaghetti', 336, 10.4, 77.8, 12, 4.3, 1.7, 9.2, 0.04),
(182, 'Barilla', 'Penne Rigate', 371, 9.3, 74.5, 15.2, 6.6, 0.3, 6.7, 0.09),
(183, 'Barilla', 'Fusilli', 336, 8, 67.1, 14.7, 1.9, 1, 8.6, 0.05),
(184, 'Barilla', 'Farfalle', 354, 12.5, 66.4, 5.7, 2, 1.4, 6.8, 0.1),
(185, 'Barilla', 'Linguine', 357, 11.3, 65.1, 11, 3.1, 0.9, 7.3, 0.05),
(186, 'Barilla', 'Tagliatelle', 343, 8.2, 74.2, 1.2, 2.7, 0.4, 8.1, 0.06),
(187, 'Barilla', 'Lasagne', 366, 8.8, 68.2, 18.7, 3.1, 1.8, 9.5, 0.06),
(188, 'Barilla', 'Maccheroni', 295, 9.4, 47.2, 29.1, 11.7, 8.5, 2.7, 0.97),
(189, 'Barilla', 'Tortiglioni', 382, 12.9, 32.8, 22.5, 11.5, 3.3, 1.6, 0.23),
(190, 'Barilla', 'Rigatoni', 294, 7.4, 19, 11.9, 18.1, 9.2, 1.8, 0.88),
(191, 'Barilla', 'Sauce Basilico', 315, 1.5, 8.1, 14.8, 78.8, 3.3, 0.8, 3.44),
(192, 'Barilla', 'Sauce Arrabbiata', 492, 1.9, 12, 13.2, 69.5, 6, 1.3, 3.23),
(193, 'Barilla', 'Sauce Napoletana', 440, 0.8, 19.7, 5.2, 40.7, 8.9, 0.5, 2.66),
(194, 'Barilla', 'Sauce Carbonara', 413, 1.2, 15, 2.3, 56.1, 10.3, 1, 2.85),
(195, 'Barilla', 'Pesto alla Genovese', 408, 0.6, 16, 12.1, 59.3, 13.9, 0.7, 1.73),
(196, 'Barilla', 'Pesto Rosso', 169, 1.7, 13.1, 4, 34.2, 17.2, 1.2, 1.07),
(197, 'Barilla', 'Sauce Ricotta', 537, 0.5, 8, 12.5, 62.7, 9.6, 0.1, 3),
(198, 'Barilla', 'Sauce 4 Formaggi', 199, 1.8, 18.4, 3.3, 76.9, 9, 0, 1.07),
(199, 'Barilla', 'Sauce Verdure', 185, 0.5, 6.5, 7.2, 59.4, 3.9, 0.6, 0.6),
(200, 'Barilla', 'Sauce Pomodoro', 432, 1.7, 1.6, 1.3, 36.3, 16.9, 1.3, 3.47),
(201, 'Tipiak', 'Taboulé', 350, 5.7, 10.7, 12.5, 14.7, 4.4, 1.2, 0.84),
(202, 'Tipiak', 'Couscous', 334, 9.5, 69.5, 6.1, 1.4, 1, 7.3, 0.07),
(203, 'Tipiak', 'Boulgour', 397, 6, 58.2, 6.9, 11.8, 4.6, 0.1, 0.29),
(204, 'Tipiak', 'Quinoa', 369, 10.8, 70.6, 12.5, 3, 0.4, 2.7, 0.07),
(205, 'Tipiak', 'Blé Gourmand', 338, 6.9, 59.6, 26.6, 16.9, 2, 3.4, 0.19),
(206, 'Tipiak', 'Croûtons', 295, 10, 34.5, 16.8, 12.4, 5.6, 3.6, 0.34),
(207, 'Tipiak', 'Perles de Blé', 204, 12.3, 38.4, 19.4, 11.9, 6.8, 1.4, 0.12),
(208, 'Tipiak', 'Polenta', 289, 11.5, 40.8, 9.3, 10.2, 6.3, 1.9, 1.11),
(209, 'Tipiak', 'Soupe Déshydratée', 321, 14.7, 37.2, 3.6, 6.1, 9.1, 4, 0.33),
(210, 'Tipiak', 'Chapelure', 312, 4, 43.4, 28.7, 11.2, 3.3, 4, 0.49),
(211, 'Tipiak', 'Graines Mélangées', 374, 14.4, 13.5, 2.6, 11.2, 5.5, 1.2, 0.87),
(212, 'Tipiak', 'Riz Pilaf', 377, 10.9, 69.2, 5.3, 4.3, 1.2, 3.7, 0.05),
(213, 'Tipiak', 'Riz Complet', 336, 7.7, 72.9, 16.6, 2.6, 1.2, 5.1, 0.05),
(214, 'Tipiak', 'Riz Basmati', 391, 9.2, 69, 13.2, 5.3, 0.6, 9.1, 0.07),
(215, 'Tipiak', 'Galettes de Maïs', 38, 4.4, 12.7, 1.5, 1.4, 0.3, 4.1, 0.22),
(216, 'Tipiak', 'Croutons Ail', 301, 8.3, 44.4, 9.3, 11.4, 6.6, 0.4, 0.52),
(217, 'Tipiak', 'Gnocchi à Poêler', 268, 11.2, 28.2, 17.8, 5.4, 6.3, 0.9, 0.22),
(218, 'Tipiak', 'Farine de Sarrasin', 348, 14.5, 54.9, 18.5, 18.6, 6.9, 0.9, 0.22),
(219, 'Tipiak', 'Pains Suédois', 265, 10.8, 17.6, 2.9, 19.6, 2, 3.9, 0.37),
(220, 'Tipiak', 'Soupe Instantanée', 343, 11.2, 30.9, 1.2, 9.8, 5.5, 4.2, 0.19),
(221, 'Madrange', 'Jambon Cuit', 275, 14.7, 4.2, 0.7, 12, 3.6, 0.3, 2.22),
(222, 'Madrange', 'Jambon Supérieur', 140, 19, 4.3, 1, 12.7, 5.5, 0.9, 1.85),
(223, 'Madrange', 'Jambon Bio', 118, 23.3, 3.1, 2, 12.3, 2.9, 0.6, 3.13),
(224, 'Madrange', 'Rillettes', 248, 18.2, 0.8, 1.1, 16.5, 3.4, 0.8, 2.23),
(225, 'Madrange', 'Saucisson', 177, 17.8, 1.2, 0.8, 7.8, 6.5, 0.7, 2.44),
(226, 'Madrange', 'Saucisses', 181, 23.6, 2.7, 0.6, 15.2, 4, 0.4, 2.28),
(227, 'Madrange', 'Pâté', 165, 23.2, 1, 1.6, 18.2, 3.5, 0.8, 2.66),
(228, 'Madrange', 'Lardons', 204, 24.9, 5, 1.8, 12.6, 3, 0.4, 1.88),
(229, 'Madrange', 'Fromage de Tête', 358, 21.8, 3.7, 0.6, 74.9, 35.3, 0.1, 0.61),
(230, 'Madrange', 'Andouille', 114, 14, 4, 0.2, 20.8, 2, 0.4, 2.32),
(231, 'Madrange', 'Terrine de Campagne', 342, 12.2, 34.9, 20.4, 7.1, 6.4, 3.2, 0.74),
(232, 'Madrange', 'Saucisse Cocktail', 104, 16.8, 4.1, 1.2, 10.6, 8.8, 0.5, 1.06),
(233, 'Madrange', 'Rôti de Porc Cuit', 344, 6.2, 24.5, 7.2, 6.8, 9.9, 0.1, 0.5),
(234, 'Madrange', 'Dinde Cuite', 191, 20.4, 0.7, 1.3, 13.6, 6.1, 0.1, 2.05),
(235, 'Madrange', 'Poulet Cuit', 135, 16.5, 5, 1.2, 10.8, 3, 0.1, 1.77),
(236, 'Madrange', 'Saucisse Fumée', 224, 13.8, 2.8, 1.6, 19.7, 2.9, 0.7, 3.04),
(237, 'Madrange', 'Merguez', 347, 7, 56.8, 9.4, 9.4, 6.8, 0.3, 1.04),
(238, 'Madrange', 'Chipolata', 352, 5.6, 42.9, 15.6, 9, 8.9, 3.8, 0.43),
(239, 'Madrange', 'Jambon Fumé', 149, 12.8, 2, 0.4, 5.8, 3.6, 0.6, 2.84),
(240, 'Madrange', 'Lardons Fumés', 191, 20.2, 4.2, 1.7, 13.3, 5.5, 0.8, 2.55),
(241, 'Harrys', 'Pain de Mie Nature', 358, 8.7, 46.8, 11.8, 16.3, 3.5, 3.6, 0.21),
(242, 'Harrys', 'Pain de Mie Complet', 356, 8.9, 38.4, 20.9, 18.1, 5.7, 2.2, 0.81),
(243, 'Harrys', 'Pain de Mie Sans Croûte', 277, 10.7, 47.9, 8.4, 9.5, 6.9, 1, 1.11),
(244, 'Harrys', 'Pain de Mie Brioché', 282, 3.1, 27.6, 1.1, 6.2, 3.9, 3.8, 0.16),
(245, 'Harrys', 'Pain de Mie Bio', 225, 4.8, 21.3, 9.7, 8.5, 4, 2.2, 0.45),
(246, 'Harrys', 'Brioche Tressée', 383, 13.5, 35.3, 8.3, 13.4, 4.1, 3.9, 0.66),
(247, 'Harrys', 'Brioche Tranchée', 328, 13.4, 16, 27.9, 5.3, 4.5, 4, 0.81),
(248, 'Harrys', 'Briochettes', 201, 12.9, 25.3, 25.8, 5.3, 4.7, 4.8, 0.99),
(249, 'Harrys', 'Pitch Chocolat', 459, 6.2, 66.1, 27.8, 28.8, 6.6, 1.7, 0.07),
(250, 'Harrys', 'Pitch Fraise', 237, 9.4, 32.1, 20.9, 16.2, 5.5, 3.3, 0.99),
(251, 'Harrys', 'Pain Burger', 537, 1, 12.4, 11.3, 55.2, 4.1, 0.2, 1.8),
(252, 'Harrys', 'Pain Hot Dog', 292, 13.4, 20.2, 26.4, 17.8, 9.7, 1.9, 1.2),
(253, 'Harrys', 'Pain Céréales', 330, 11.9, 79.7, 6.6, 1.9, 1, 3.8, 0.05),
(254, 'Harrys', 'Pain Graines', 235, 12.5, 21.4, 16.3, 12, 3.5, 3.8, 0.17),
(255, 'Harrys', 'Pain Viennois', 334, 9.6, 39.1, 26, 9.4, 4.4, 4.3, 0.17),
(256, 'Harrys', 'Pain Sandwich', 279, 4.3, 10.6, 24.9, 7.8, 5.4, 4.4, 0.75),
(257, 'Harrys', 'Pain Wrap', 231, 11.4, 42.3, 16.2, 10.8, 7.4, 3.9, 0.49),
(258, 'Harrys', 'Pain Multi-Céréales', 345, 8.1, 78.8, 19.3, 4.6, 1.5, 3.2, 0.04),
(259, 'Harrys', 'Brioche Chocolat', 466, 7.5, 52, 30.2, 16.7, 16.3, 4, 0.14),
(260, 'Harrys', 'Brioche Raisins', 363, 12.7, 33.3, 25.1, 7.7, 4.5, 4.1, 0.61),
(261, 'Brossard', 'Savane Chocolat', 535, 6.4, 61.5, 32.7, 19, 5.6, 4.1, 0.06),
(262, 'Brossard', 'Savane Marbré', 316, 7.6, 46.2, 21.3, 6.1, 2.2, 3.2, 0.47),
(263, 'Brossard', 'Brownie Chocolat', 271, 4.2, 25.1, 23.1, 16.8, 7.2, 1.1, 0.25),
(264, 'Brossard', 'Brownie Noisette', 200, 4.9, 27.8, 20.8, 15.8, 9.2, 0.4, 0.08),
(265, 'Brossard', 'Gâteau Roulé Fraise', 0, 0, 0, 0, 0, 0, 0, 0),
(266, 'Brossard', 'Gâteau Roulé Abricot', 0, 0, 0, 0, 0, 0, 0, 0),
(267, 'Brossard', 'Madeleines', 455, 7.1, 65.3, 26.2, 17.6, 18.5, 5.7, 0.24),
(268, 'Brossard', 'Muffins Chocolat', 516, 6, 55.1, 37.9, 30, 13.7, 3.9, 0.48),
(269, 'Brossard', 'Muffins Myrtilles', 285, 7.1, 33, 9.9, 7.7, 6.4, 3.6, 0.23),
(270, 'Brossard', 'Cookies Chocolat', 262, 4.6, 32.6, 25.9, 11.4, 11.5, 0.2, 0.29),
(271, 'Brossard', 'Cookies Noix', 228, 4.8, 29.1, 22.7, 10.3, 11.7, 0.3, 0.3),
(272, 'Brossard', 'Quatre-Quarts', 301, 8.4, 25.7, 9.5, 19.8, 8.2, 4.7, 0.66),
(273, 'Brossard', 'Gâteau Marbré', 0, 0, 0, 0, 0, 0, 0, 0),
(274, 'Brossard', 'Gâteau Chocolat', 504, 6.8, 66.6, 39.1, 34.5, 9.1, 2.7, 0.24),
(275, 'Brossard', 'Gâteau Moelleux', 0, 0, 0, 0, 0, 0, 0, 0),
(276, 'Brossard', 'Mini Brownies', 254, 4, 34.8, 26.4, 15, 9.9, 0.2, 0.12),
(277, 'Brossard', 'Mini Cakes', 257, 4.4, 43, 29.7, 10.3, 8.9, 1.9, 1.19),
(278, 'Brossard', 'Mini Savane', 254, 3.7, 49.8, 2.4, 13.9, 6.9, 3.2, 0.84),
(279, 'Brossard', 'Mini Madeleines', 428, 5.1, 63.2, 45.7, 31.7, 11.6, 3.6, 0.2),
(280, 'Brossard', 'Mini Roulés', 266, 13.7, 33.7, 24, 5.4, 3.8, 2, 0.75),
(281, 'LU', 'Petit Beurre', 446, 5.5, 2.4, 1.8, 26.4, 41.5, 0.3, 1.55),
(282, 'LU', 'Prince Chocolat', 491, 4.8, 62.5, 20.4, 26.5, 14.6, 3, 0.29),
(283, 'LU', 'Prince Vanille', 276, 3, 32.2, 18.6, 17.7, 7.5, 1.8, 0.09),
(284, 'LU', 'Petit Écolier', 239, 14.7, 40.4, 15.5, 15, 4.1, 0.6, 1.04),
(285, 'LU', 'Granola', 384, 11.1, 74.7, 19.4, 5.9, 0.9, 3, 0.05),
(286, 'LU', 'Pépito', 243, 3.1, 27, 2.9, 15.6, 6.9, 2, 0.95),
(287, 'LU', 'Barquettes Fraise', 249, 11.4, 20, 4.8, 7, 5.5, 3.5, 0.28),
(288, 'LU', 'Barquettes Abricot', 237, 4.9, 54, 8.1, 5.9, 5.5, 4.2, 1.09),
(289, 'LU', 'Barquettes Chocolat', 540, 5.9, 67.3, 45.6, 20.2, 18.5, 4.9, 0.23),
(290, 'LU', 'Dinosaurus', 208, 11.4, 54.1, 2.6, 12.3, 8, 2.5, 0.53),
(291, 'LU', 'TUC Original', 362, 14.2, 59.2, 17.6, 19.7, 3.4, 1.7, 0.6),
(292, 'LU', 'Belvita Miel', 399, 5.5, 52.3, 1.6, 7.2, 5.8, 2.2, 0.98),
(293, 'LU', 'Belvita Chocolat', 476, 6.7, 57.8, 30.8, 24.3, 9.9, 5.6, 0.46),
(294, 'LU', 'Mikado Chocolat', 538, 6.6, 56, 31.1, 19.5, 16.3, 4.1, 0.33),
(295, 'LU', 'Napolitain', 537, 6.4, 64.7, 38.6, 34.5, 7.7, 2.6, 0.34),
(296, 'LU', 'Pim\'s Orange', 391, 10.6, 15.9, 14.3, 17.3, 4, 1.4, 0.22),
(297, 'LU', 'Cracotte Nature', 305, 7.7, 44.5, 23.8, 5.5, 7.3, 3.6, 0.77),
(298, 'LU', 'Figolu', 287, 7.3, 39.6, 6.9, 18.5, 4.2, 4.1, 1.04),
(299, 'LU', 'Gaufrettes Vanille', 186, 2.2, 28.4, 19.6, 11.4, 8.6, 1.5, 0.28),
(300, 'LU', 'Cakes Fourrés', 384, 8.7, 24, 19.5, 13, 7.3, 2.1, 0.9),
(301, 'Milka', 'Tablette Lait', 491, 5, 52.3, 37.4, 31.1, 13.1, 3, 0.44),
(302, 'Milka', 'Tablette Noisette', 510, 4.5, 57.1, 38.4, 24.4, 11.5, 4.7, 0.41),
(303, 'Milka', 'Tablette Caramel', 527, 5.9, 62.9, 35.4, 25.2, 16.8, 4.8, 0.31),
(304, 'Milka', 'Tablette Biscuit', 439, 7.8, 58.2, 41.9, 26.2, 14.2, 3.5, 0.29),
(305, 'Milka', 'Tablette Oreo', 447, 5.6, 62.8, 40, 27.9, 12.4, 1.3, 0.02),
(306, 'Milka', 'Barres Lait', 534, 6.2, 52, 30.3, 17.2, 7.1, 1.4, 0.38),
(307, 'Milka', 'Barres Noisette', 437, 4.3, 65.5, 34.9, 19.8, 15.1, 3.4, 0.07),
(308, 'Milka', 'Barres Oreo', 491, 4.9, 66.9, 28.2, 20.8, 10.6, 3.1, 0.31),
(309, 'Milka', 'Barres Daim', 525, 5.6, 51.5, 25.6, 32.9, 9.3, 3, 0.06),
(310, 'Milka', 'Biscuits Choco', 465, 4.9, 50.7, 28.8, 30.8, 17, 5.6, 0.01),
(311, 'Milka', 'Biscuits Lait', 553, 5.9, 69.7, 29, 27.4, 5.2, 2, 0.07),
(312, 'Milka', 'Biscuits Oreo', 483, 6.2, 59.9, 21.6, 20.8, 19.3, 5.5, 0.11),
(313, 'Milka', 'Biscuits Noisette', 457, 5.1, 62.5, 21.6, 24.2, 17, 3.8, 0.1),
(314, 'Milka', 'Biscuits Daim', 496, 7.7, 58.3, 40.9, 29.5, 13.5, 3.4, 0.06),
(315, 'Milka', 'Cake Choco', 355, 14.3, 11.4, 1.8, 13.5, 4.6, 0.4, 0.46),
(316, 'Milka', 'Cake Lait', 283, 7.9, 47.2, 6.4, 13.1, 3.4, 4, 1.13),
(317, 'Milka', 'Chocolat à Pâtisser', 438, 6, 57.4, 48.4, 15.2, 7.2, 2.1, 0.21),
(318, 'Milka', 'Tablette Extra Cacao', 512, 7.9, 64.8, 28.7, 34.8, 15.3, 1.6, 0.46),
(319, 'Milka', 'Tablette Amande', 519, 6.9, 68, 31.9, 28.3, 17.3, 1.1, 0.17),
(320, 'Milka', 'Mini Milka', 468, 7.7, 64.9, 45, 22.1, 13.9, 3.3, 0.38),
(321, 'Lindt', 'Chocolat Noir 70%', 560, 7, 58.6, 20.2, 23.9, 14.7, 2.1, 0.51),
(322, 'Lindt', 'Chocolat Noir 85%', 483, 4.2, 59.4, 32.6, 20.7, 7.6, 3.9, 0.03),
(323, 'Lindt', 'Chocolat Noir 90%', 513, 4.2, 66.8, 47.5, 27.2, 7.3, 5.3, 0.14),
(324, 'Lindt', 'Chocolat Lait', 464, 4.3, 50.9, 36.9, 18.8, 17.4, 4.1, 0.31),
(325, 'Lindt', 'Chocolat Noisette', 557, 6, 58.4, 43.9, 19.2, 10, 3.4, 0.37),
(326, 'Lindt', 'Chocolat Blanc', 431, 6.2, 50.3, 41.9, 22.8, 11.1, 4.6, 0.43),
(327, 'Lindt', 'Praliné', 522, 6.5, 50.4, 50, 20.5, 7.5, 2.3, 0.23),
(328, 'Lindt', 'Truffes', 271, 13.3, 54.3, 24.8, 12.4, 8.7, 3.1, 0.88),
(329, 'Lindt', 'Lindor Lait', 391, 13.5, 35.6, 3.6, 8.8, 7.4, 0.3, 1.08),
(330, 'Lindt', 'Lindor Noir', 313, 3.5, 57.4, 10.7, 5.2, 4.1, 4.6, 1.02),
(331, 'Lindt', 'Lindor Blanc', 389, 8, 53.2, 29.6, 19.5, 6.6, 0.8, 0.5),
(332, 'Lindt', 'Lindor Caramel', 366, 8.6, 42, 13.5, 7.1, 7.7, 2.4, 0.33),
(333, 'Lindt', 'Lindor Noisette', 383, 4.2, 14.2, 10.1, 13.7, 9.5, 1.5, 0.72),
(334, 'Lindt', 'Chocolat Caramel', 512, 4.6, 53.7, 43.9, 21.7, 16.6, 5.3, 0.41),
(335, 'Lindt', 'Chocolat Menthe', 508, 4.7, 66.6, 23, 24.3, 10.1, 5.6, 0.23),
(336, 'Lindt', 'Chocolat Amande', 464, 6.3, 56.6, 40.7, 33, 9.8, 1.7, 0.33),
(337, 'Lindt', 'Chocolat Pistache', 280, 4.3, 24.8, 19.8, 13.5, 6.8, 1.9, 0.14),
(338, 'Lindt', 'Tablette Bio', 509, 4.3, 56.3, 30.5, 25.8, 13.6, 2.6, 0.16),
(339, 'Lindt', 'Tablette Dessert', 445, 6.1, 59.4, 46.2, 34.2, 7.9, 3.5, 0.25),
(340, 'Lindt', 'Mini Tablette', 452, 6.9, 51.9, 31.9, 26.8, 16, 5.5, 0.27),
(341, 'Côte dOr', 'Tablette Lait', 435, 5.6, 62.6, 29.3, 31.4, 8.6, 5.6, 0.15),
(342, 'Côte dOr', 'Tablette Noir', 465, 6.3, 67.1, 44.8, 20.8, 18.8, 2.2, 0.55),
(343, 'Côte dOr', 'Tablette Noisette', 436, 6.5, 63.1, 42.5, 34, 6.2, 5.1, 0.58),
(344, 'Côte dOr', 'Tablette Caramel', 538, 7.1, 57.5, 40.5, 20.7, 5.6, 5.2, 0.24),
(345, 'Côte dOr', 'Tablette Amande', 515, 4.4, 64.5, 21.2, 23.6, 12.6, 4, 0.06),
(346, 'Côte dOr', 'Tablette Pistache', 262, 4.7, 28.6, 21.5, 17.2, 5.6, 0, 0.1),
(347, 'Côte dOr', 'Tablette Blanc', 519, 5, 63.5, 31.7, 18.1, 12.1, 4.1, 0.53),
(348, 'Côte dOr', 'Praliné', 463, 4.7, 51.8, 49.5, 32.6, 5.4, 2.3, 0.34),
(349, 'Côte dOr', 'Truffes', 268, 4.6, 19.3, 11.4, 18, 4.6, 4.1, 0.39),
(350, 'Côte dOr', 'Mini Tablettes', 436, 6.7, 67, 31.9, 30.7, 11.6, 1.3, 0.24),
(351, 'Côte dOr', 'Tablette Bio', 457, 7.3, 57.3, 25, 19.7, 13.1, 4.9, 0.35),
(352, 'Côte dOr', 'Tablette Dessert', 539, 8, 52.2, 28.7, 23.7, 9.3, 2.1, 0.26),
(353, 'Côte dOr', 'Barres Lait', 546, 4.9, 58, 47.2, 17.5, 9.3, 1.2, 0.56),
(354, 'Côte dOr', 'Barres Noir', 485, 7.3, 51.9, 49.6, 27.1, 10.9, 4.2, 0.08),
(355, 'Côte dOr', 'Barres Noisette', 534, 6.3, 60, 49.2, 31.8, 11.8, 4.5, 0.23),
(356, 'Côte dOr', 'Biscuits Choco', 454, 4.2, 67.5, 28.2, 25.5, 19.8, 1, 0.32),
(357, 'Côte dOr', 'Biscuits Lait', 480, 6, 63.8, 32.4, 34.5, 17, 5.2, 0.46),
(358, 'Côte dOr', 'Biscuits Noir', 426, 4.5, 59.1, 43.6, 30.1, 18.2, 2.7, 0.36),
(359, 'Côte dOr', 'Biscuits Noisette', 494, 6.7, 56.4, 48.1, 16.4, 12.4, 3.4, 0.14),
(360, 'Côte dOr', 'Biscuits Bio', 531, 6.1, 65.5, 49.8, 33.8, 19.4, 4, 0.48),
(361, 'Carambar & Co', 'Carambar Classique', 552, 7.3, 52.3, 31.5, 20.2, 11.8, 4.4, 0.47),
(362, 'Carambar & Co', 'Carambar Caramel', 505, 4.4, 50.6, 31.6, 22.3, 18.4, 4.9, 0.05),
(363, 'Carambar & Co', 'Carambar Fruits', 524, 5.9, 64.9, 30.2, 20, 19.9, 1.7, 0.33),
(364, 'Carambar & Co', 'Krema Réglisse', 297, 6.2, 44, 12.4, 9.3, 4.3, 1.2, 0.48),
(365, 'Carambar & Co', 'Krema Fruits', 383, 3, 48.9, 2.2, 7.6, 3.9, 0.7, 0.95),
(366, 'Carambar & Co', 'Poulain Chocolat Lait', 529, 7.1, 65.6, 42.6, 22.5, 19.4, 3.1, 0.11),
(367, 'Carambar & Co', 'Poulain Chocolat Noir', 550, 6.7, 57.2, 36.2, 28.8, 7.7, 3.6, 0.06),
(368, 'Carambar & Co', 'Poulain Dessert', 242, 7.7, 41.5, 17.6, 7.4, 7.5, 3.1, 0.28),
(369, 'Carambar & Co', 'La Pie Qui Chante', 258, 5.7, 56.9, 12.1, 5.9, 8.5, 3.6, 1.03),
(370, 'Carambar & Co', 'Mi-cho-ko', 251, 4.2, 10.4, 3.4, 17.6, 5.3, 1.4, 0.8),
(371, 'Carambar & Co', 'Carambar Atomic', 459, 4.1, 55.1, 21, 30.8, 15.8, 2.5, 0.5),
(372, 'Carambar & Co', 'Carambar Maxi', 473, 6.5, 52.1, 43.2, 20.5, 9.4, 3.2, 0.11),
(373, 'Carambar & Co', 'Carambar Mini', 539, 5.9, 58.2, 31.2, 29, 11.1, 4.4, 0.16),
(374, 'Carambar & Co', 'Krema Maxi', 323, 9.3, 56.1, 20.5, 5.4, 9.8, 4.2, 1.12),
(375, 'Carambar & Co', 'Krema Mini', 397, 8.4, 23.7, 18.1, 15.9, 7.3, 2.7, 0.31),
(376, 'Carambar & Co', 'Carambar Bio', 549, 4, 68.4, 44.2, 16.6, 9, 1.2, 0.07),
(377, 'Carambar & Co', 'Carambar Sans Sucre', 522, 4.8, 64.9, 28.4, 22.3, 15.3, 4.6, 0.56),
(378, 'Carambar & Co', 'Poulain Praliné', 535, 7, 57.2, 22.1, 22, 5.5, 5.2, 0.39),
(379, 'Carambar & Co', 'Poulain Bio', 350, 12.6, 15.4, 25, 11.2, 8.4, 1.4, 0.15),
(380, 'Carambar & Co', 'Poulain Extra Noir', 335, 8.7, 55.2, 9.4, 8.9, 4.7, 1.4, 1.01),
(381, 'Findus', 'Poisson Pané', 100, 4.1, 11.5, 1.3, 1.7, 0.4, 6.3, 0.16),
(382, 'Findus', 'Filet de Colin', 316, 14.1, 50.3, 20.8, 10.9, 2.2, 4.8, 0.1),
(383, 'Findus', 'Saumon Surgelé', 363, 11.4, 30.8, 11.5, 19.5, 4.2, 0.5, 0.32),
(384, 'Findus', 'Poisson Croustillant', 27, 1.7, 10.7, 3.8, 2, 0.7, 6, 0.03),
(385, 'Findus', 'Croquettes de Poisson', 78, 1, 14.9, 4.6, 1.7, 0.4, 4.9, 0.19),
(386, 'Findus', 'Épinards Surgelés', 96, 3.5, 6.4, 2, 2.5, 0.1, 6.1, 0.03),
(387, 'Findus', 'Haricots Verts Surgelés', 91, 2.7, 10.8, 4.8, 0.3, 0.7, 4.4, 0.2),
(388, 'Findus', 'Brocolis Surgelés', 74, 3.6, 12.5, 3.7, 2.4, 0.3, 5.8, 0.07),
(389, 'Findus', 'Carottes Surgelées', 104, 1.8, 2.9, 1.3, 0.3, 0.9, 3.7, 0.19),
(390, 'Findus', 'Petits Pois Surgelés', 22, 5.4, 11.1, 2, 2.7, 0.6, 6.4, 0.24),
(391, 'Findus', 'Lasagnes', 399, 9.9, 71.7, 13.2, 7.8, 2, 8, 0.07),
(392, 'Findus', 'Hachis Parmentier', 244, 5, 31.7, 27.4, 7.5, 6.3, 2.2, 0.28),
(393, 'Findus', 'Gratin Dauphinois', 234, 3.5, 52, 22.3, 8.2, 5.3, 2.6, 0.19),
(394, 'Findus', 'Pizza 4 Fromages', 600, 15.5, 0.6, 1.5, 48.9, 27.2, 1, 1.84),
(395, 'Findus', 'Quiche Lorraine', 364, 7.8, 25.6, 11, 15.2, 8.2, 0.2, 0.79),
(396, 'Findus', 'Nuggets de Poulet', 250, 18.4, 4.5, 0.6, 5.6, 7.5, 0.6, 1.32),
(397, 'Findus', 'Cordon Bleu', 349, 5.3, 38.6, 5.7, 12.3, 5.3, 3.6, 0.17),
(398, 'Findus', 'Frites Surgelées', 307, 8.3, 34.3, 15.5, 17.8, 2, 2.8, 0.21),
(399, 'Findus', 'Pommes Rissolées', 246, 8.5, 54.2, 5.3, 12.2, 3.3, 1, 1.12),
(400, 'Findus', 'Ratatouille Surgelée', 317, 9.8, 42.8, 22.7, 17.7, 3.6, 0.6, 0.97),
(401, 'Bonne Maman', 'Confiture Fraise', 290, 3.9, 18.5, 11.9, 14.5, 7.1, 1.3, 0.94),
(402, 'Bonne Maman', 'Confiture Abricot', 304, 14.7, 58.8, 19, 11.2, 9.2, 4.4, 1.09),
(403, 'Bonne Maman', 'Confiture Framboise', 209, 9.2, 52.6, 25.9, 15.7, 8.5, 3.4, 0.81),
(404, 'Bonne Maman', 'Confiture Myrtille', 205, 9.6, 26.9, 6.5, 17.8, 9.8, 1.8, 0.49),
(405, 'Bonne Maman', 'Confiture Cerise', 346, 13.5, 48.7, 12.3, 9.4, 9.6, 3.4, 1.08),
(406, 'Bonne Maman', 'Confiture Orange', 364, 8, 46.7, 2.6, 8.6, 3.8, 0.6, 0.4),
(407, 'Bonne Maman', 'Confiture Pêche', 321, 3.5, 55.2, 16, 5.1, 4, 1.3, 0.15),
(408, 'Bonne Maman', 'Confiture Poire', 395, 10.9, 42, 17.2, 17.8, 8.9, 1.9, 0.71),
(409, 'Bonne Maman', 'Confiture Mûre', 316, 4.3, 39.8, 5.9, 5.5, 9.1, 2.5, 0.95),
(410, 'Bonne Maman', 'Confiture Mirabelle', 239, 9, 20.2, 21.1, 9.1, 2.4, 4.8, 0.62),
(411, 'Bonne Maman', 'Biscuits Sablés', 451, 5.8, 63.7, 28.4, 24.5, 9, 5.4, 0.52),
(412, 'Bonne Maman', 'Madeleines', 448, 5.7, 66.1, 28.6, 19.4, 6.1, 1.3, 0.25),
(413, 'Bonne Maman', 'Galettes', 422, 6.8, 66.2, 40.9, 22.8, 7.5, 5.7, 0.59),
(414, 'Bonne Maman', 'Financiers', 292, 6.8, 22.8, 21.8, 10.7, 4.2, 2.5, 0.59),
(415, 'Bonne Maman', 'Brownies', 272, 3.3, 32.8, 28.3, 14.5, 6.6, 1.2, 0.19),
(416, 'Bonne Maman', 'Cookies Chocolat', 193, 3.3, 29.1, 23.2, 9.3, 10.2, 1.7, 0.11),
(417, 'Bonne Maman', 'Tartelettes Fraise', 259, 6, 16.9, 26.9, 16.5, 6.3, 2.8, 0.54),
(418, 'Bonne Maman', 'Moelleux Chocolat', 448, 6.7, 67.9, 23.1, 17.7, 19.5, 2.2, 0.17),
(419, 'Bonne Maman', 'Cakes Natures', 328, 11.1, 57.2, 13.5, 12.9, 2.5, 2, 0.85),
(420, 'Bonne Maman', 'Gaufrettes Vanille', 213, 4.3, 34.8, 27.2, 12.2, 6.4, 0, 0.15),
(421, 'Nutella', 'Nutella Pot 200g', 391, 9.3, 39.1, 13.9, 16.8, 7.3, 4.4, 0.87),
(422, 'Nutella', 'Nutella Pot 400g', 277, 11.9, 54.6, 19.6, 10.5, 5.5, 4.8, 1.11),
(423, 'Nutella', 'Nutella Pot 750g', 279, 5.2, 17.3, 14.5, 11.9, 5, 0.4, 1.01),
(424, 'Nutella', 'Nutella Pot 1kg', 268, 7.6, 36.4, 9.3, 17.7, 7.7, 0.9, 0.16),
(425, 'Nutella', 'Nutella Biscuits', 532, 7.6, 57.9, 38.8, 16.5, 16.1, 4.1, 0.21),
(426, 'Nutella', 'Nutella B-ready', 262, 3.2, 28.4, 3.9, 20, 7.6, 4.9, 0.86),
(427, 'Nutella', 'Nutella & Go', 218, 14.4, 58.8, 13.4, 9.5, 4, 5, 0.21),
(428, 'Nutella', 'Nutella Sans Huile Palme', 325, 8.4, 56.3, 12.4, 16.5, 6.1, 4.9, 0.22),
(429, 'Nutella', 'Nutella Crunchy', 358, 9, 54.6, 18.7, 19.8, 6.9, 4.3, 0.52),
(430, 'Nutella', 'Nutella Bio', 326, 7.8, 43.1, 10.2, 13.3, 9.2, 2.1, 0.58),
(431, 'Nutella', 'Kinder Bueno', 314, 3.4, 22.8, 8.8, 14.6, 4.1, 4.9, 1.03),
(432, 'Nutella', 'Kinder Country', 332, 3.2, 17.3, 16.5, 13, 7.7, 4.1, 0.9),
(433, 'Nutella', 'Kinder Délice', 364, 11.8, 31.9, 10.2, 15.4, 5.1, 0.6, 0.62),
(434, 'Nutella', 'Kinder Pingui', 220, 3.4, 49.4, 18.4, 18.1, 6.6, 2.3, 0.17),
(435, 'Nutella', 'Kinder Maxi', 324, 9.7, 58.7, 14.6, 18.5, 5.1, 0.1, 0.34),
(436, 'Nutella', 'Kinder Surprise', 268, 13.2, 29.2, 13.6, 18.5, 7.4, 4.6, 0.76),
(437, 'Nutella', 'Schoko-bons', 337, 12, 56.3, 18.9, 10.2, 3.6, 4.3, 0.11),
(438, 'Nutella', 'Kinder Chocolat', 426, 6.3, 54.6, 26.9, 21.5, 6.9, 4, 0.05),
(439, 'Nutella', 'Kinder Mini', 248, 12.2, 22.5, 17.4, 5.6, 2.1, 1, 0.56),
(440, 'Nutella', 'Kinder Cards', 318, 8, 46.3, 13.5, 7.2, 6.3, 4.3, 1.14),
(441, 'Kinder', 'Kinder Bueno', 347, 14.2, 38, 19, 18.9, 8.4, 0.7, 0.77),
(442, 'Kinder', 'Kinder Country', 376, 11.9, 32, 16, 20, 9.6, 2, 0.17),
(443, 'Kinder', 'Kinder Délice', 209, 13.9, 54, 20.9, 14.7, 2.6, 4.5, 0.64),
(444, 'Kinder', 'Kinder Pingui', 263, 8.9, 40.5, 12.6, 8.7, 2.4, 1.5, 0.52),
(445, 'Kinder', 'Kinder Maxi', 211, 10.5, 50.1, 14.9, 18.5, 4.1, 2, 0.13),
(446, 'Kinder', 'Kinder Surprise', 320, 9, 21.6, 8.1, 11.1, 7, 4, 0.81),
(447, 'Kinder', 'Kinder Schoko-bons', 372, 5.5, 37.4, 3.7, 8.8, 6.1, 3.1, 0.73),
(448, 'Kinder', 'Kinder Chocolat', 452, 6.7, 57.1, 37.2, 29.9, 17.7, 2, 0.14),
(449, 'Kinder', 'Kinder Joy', 300, 6.8, 14.1, 29.9, 10.9, 7.4, 2.8, 1.18),
(450, 'Kinder', 'Kinder Happy Hippo', 326, 3.8, 55.6, 22.6, 18.7, 7.2, 0.1, 0.38),
(451, 'Kinder', 'Kinder Tranche Lait', 289, 3.7, 57.4, 8.1, 9.3, 5.1, 4.6, 0.22),
(452, 'Kinder', 'Kinder Cards', 361, 7.9, 16.4, 16.5, 18.6, 5.1, 4.7, 1.16),
(453, 'Kinder', 'Kinder Mini', 236, 14.1, 54.9, 15.6, 12.6, 9.3, 4.3, 0.38),
(454, 'Kinder', 'Kinder Brioss', 332, 3.6, 57.2, 26.3, 5.7, 4.3, 1.6, 0.86),
(455, 'Kinder', 'Kinder CereAlé', 362, 6.5, 53.2, 13.5, 13, 8.4, 1.2, 0.56),
(456, 'Kinder', 'Kinder Délice Coco', 392, 13.4, 14.8, 24.8, 7, 3.6, 2, 0.63),
(457, 'Kinder', 'Kinder Bueno White', 332, 7.9, 37.6, 5.3, 9.3, 6, 0.1, 0.33),
(458, 'Kinder', 'Kinder Choco Fresh', 321, 15, 26.2, 27.9, 19.1, 8.8, 0.8, 0.93),
(459, 'Kinder', 'Kinder Pingui Cacao', 375, 8.6, 42.2, 5.3, 16.3, 3.9, 1.7, 0.27),
(460, 'Kinder', 'Kinder Pingui Noisette', 302, 6.3, 58.9, 1.9, 8.7, 8.8, 1.5, 0.89),
(461, 'Ferrero Rocher', 'Ferrero Rocher', 284, 10.3, 39.2, 8.8, 15.8, 3.9, 3.7, 0.28),
(462, 'Ferrero Rocher', 'Ferrero Collection', 364, 3.1, 40.3, 21.7, 13.7, 2.7, 0.4, 0.95),
(463, 'Ferrero Rocher', 'Raffaello', 230, 12.2, 11.1, 25.8, 13, 3.2, 2.8, 0.52),
(464, 'Ferrero Rocher', 'Mon Chéri', 323, 8.3, 10, 19.6, 12.7, 8.6, 4, 0.46),
(465, 'Ferrero Rocher', 'Ferrero Rondnoir', 321, 3.5, 39.7, 22.4, 7.8, 6.9, 2.8, 0.58),
(466, 'Ferrero Rocher', 'Ferrero Rocher Noir', 316, 10, 35.9, 13.3, 6.3, 4.2, 4.1, 0.1),
(467, 'Ferrero Rocher', 'Rocher Lait', 375, 4.5, 49.8, 1.7, 5.3, 2.9, 0.8, 0.65),
(468, 'Ferrero Rocher', 'Rocher Blanc', 255, 8.8, 29.5, 10.2, 11.9, 4.1, 2.9, 0.21),
(469, 'Ferrero Rocher', 'Collection Assorti', 209, 14.9, 29.1, 6, 17.8, 6.2, 1.6, 0.9),
(470, 'Ferrero Rocher', 'Raffaello Noix de Coco', 211, 4.8, 26.9, 14.7, 15.4, 9.8, 3.7, 0.82),
(471, 'Ferrero Rocher', 'Mon Chéri Cerise', 356, 4.9, 27.8, 5.7, 10.1, 3.8, 2.3, 0.55),
(472, 'Ferrero Rocher', 'Rocher Dark', 230, 11.3, 22.5, 16.1, 17.5, 7.8, 0.1, 0.77),
(473, 'Ferrero Rocher', 'Rocher Caramel', 250, 3.4, 10.3, 23.7, 9.5, 4.2, 4.1, 1.15),
(474, 'Ferrero Rocher', 'Rocher Praliné', 478, 6.7, 62.3, 29.4, 24.9, 5.9, 4.8, 0.33),
(475, 'Ferrero Rocher', 'Rocher Noisette', 215, 9.9, 56.4, 14.1, 16.7, 6.7, 1.2, 0.48),
(476, 'Ferrero Rocher', 'Rocher Pistache', 192, 2.4, 34.1, 20.1, 8.8, 10, 0.8, 0.29),
(477, 'Ferrero Rocher', 'Rocher Amande', 247, 13.9, 47.7, 4.2, 7.4, 6.9, 2.4, 0.73),
(478, 'Ferrero Rocher', 'Ferrero Garden', 381, 4.7, 40, 26.3, 11, 3.8, 2.8, 0.41),
(479, 'Ferrero Rocher', 'Ferrero Eggs', 264, 11.2, 49.6, 24.1, 16.4, 7.9, 0.7, 1.1),
(480, 'Ferrero Rocher', 'Ferrero Golden Gallery', 261, 8.4, 21.1, 12.2, 9.9, 4.8, 1.4, 1.04),
(481, 'Coca-Cola', 'Coca-Cola Classique', 50, 0, 10.6, 11.8, 0, 0, 0, 0.02),
(482, 'Coca-Cola', 'Coca-Cola Zéro', 0, 0, 0, 0, 0, 0, 0, 0),
(483, 'Coca-Cola', 'Coca-Cola Light', 0, 0, 0, 0, 0, 0, 0, 0),
(484, 'Coca-Cola', 'Coca-Cola Cherry', 44, 0, 10.7, 9.8, 0, 0, 0, 0.02),
(485, 'Coca-Cola', 'Coca-Cola Vanilla', 48, 0, 8.7, 8.3, 0, 0, 0, 0.02),
(486, 'Coca-Cola', 'Coca-Cola Citron', 46, 0, 8.5, 10, 0, 0, 0, 0.02),
(487, 'Coca-Cola', 'Coca-Cola Sans Caféine', 48, 0, 10.8, 11.2, 0, 0, 0, 0.02),
(488, 'Coca-Cola', 'Coca-Cola Energy', 38, 0, 10.6, 8.7, 0, 0, 0, 0.02);

-- --------------------------------------------------------

--
-- Structure de la table `sports`
--

CREATE TABLE `sports` (
  `id_sport` int(11) NOT NULL,
  `nom_sport` varchar(100) DEFAULT NULL,
  `MET` float DEFAULT NULL,
  `kcal_h_60kg` int(11) DEFAULT NULL,
  `kcal_h_70kg` int(11) DEFAULT NULL,
  `kcal_h_80kg` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sports`
--

INSERT INTO `sports` (`id_sport`, `nom_sport`, `MET`, `kcal_h_60kg`, `kcal_h_70kg`, `kcal_h_80kg`) VALUES
(1, 'Marche lente (3 km/h)', 2.5, 150, 175, 200),
(2, 'Marche normale (5 km/h)', 3.5, 210, 245, 280),
(3, 'Marche rapide (6.5 km/h)', 4.5, 270, 315, 360),
(4, 'Course à pied (8 km/h)', 8, 480, 560, 640),
(5, 'Course rapide (10 km/h)', 10, 600, 700, 800),
(6, 'Course très rapide (12 km/h)', 12.5, 750, 875, 1000),
(7, 'Course sprint (>16 km/h)', 15, 900, 1050, 1200),
(8, 'Vélo loisir (10-12 km/h)', 4, 240, 280, 320),
(9, 'Vélo modéré (16-19 km/h)', 6.8, 408, 476, 544),
(10, 'Vélo rapide (20-22 km/h)', 8, 480, 560, 640),
(11, 'Vélo intense (>25 km/h)', 12, 720, 840, 960),
(12, 'Natation lente', 6, 360, 420, 480),
(13, 'Natation modérée (crawl)', 8, 480, 560, 640),
(14, 'Natation intense (papillon)', 10, 600, 700, 800),
(15, 'Aviron loisir', 3.5, 210, 245, 280),
(16, 'Aviron intense', 7, 420, 490, 560),
(17, 'Basketball (jeu)', 8, 480, 560, 640),
(18, 'Basketball (tir au panier)', 4.5, 270, 315, 360),
(19, 'Football / Soccer (match)', 8, 480, 560, 640),
(20, 'Football (loisir)', 6, 360, 420, 480),
(21, 'Tennis simple', 7.3, 438, 511, 584),
(22, 'Tennis double', 6, 360, 420, 480),
(23, 'Badminton', 7, 420, 490, 560),
(24, 'Rugby', 8.3, 498, 581, 664),
(25, 'Boxe (combat)', 12, 720, 840, 960),
(26, 'Boxe (sac d\'entraînement)', 7, 420, 490, 560),
(27, 'Musculation (modérée)', 4, 240, 280, 320),
(28, 'Musculation (intense)', 6, 360, 420, 480),
(29, 'CrossFit / circuit training', 8, 480, 560, 640),
(30, 'Yoga doux', 2.5, 150, 175, 200),
(31, 'Yoga dynamique', 4, 240, 280, 320),
(32, 'Pilates', 3, 180, 210, 240),
(33, 'Danse lente', 3, 180, 210, 240),
(34, 'Danse modérée', 5.5, 330, 385, 440),
(35, 'Danse intense (hip hop, cardio)', 7.3, 438, 511, 584),
(36, 'Escalade indoor', 8, 480, 560, 640),
(37, 'Randonnée facile', 6, 360, 420, 480),
(38, 'Randonnée en montagne', 7, 420, 490, 560),
(39, 'Ski alpin', 7, 420, 490, 560),
(40, 'Ski de fond modéré', 9, 540, 630, 720),
(41, 'Snowboard', 5, 300, 350, 400),
(42, 'Patinage sur glace', 7, 420, 490, 560),
(43, 'Corde à sauter modérée', 10, 600, 700, 800),
(44, 'Corde à sauter intense', 12, 720, 840, 960),
(45, 'Arts martiaux (karaté, judo)', 10, 600, 700, 800),
(46, 'Boxe thaï / kickboxing', 12, 720, 840, 960),
(47, 'Golf (marche, port sac)', 4.8, 288, 336, 384),
(48, 'Golf (voiturette)', 2.5, 150, 175, 200),
(49, 'Volleyball (loisir)', 3, 180, 210, 240),
(50, 'Volleyball (compétition)', 6, 360, 420, 480);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `poids` float DEFAULT NULL,
  `taille` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activite`
--
ALTER TABLE `activite`
  ADD PRIMARY KEY (`id_utilisateur`,`id_sport`,`date_sport`),
  ADD KEY `id_sport` (`id_sport`);

--
-- Index pour la table `consommation`
--
ALTER TABLE `consommation`
  ADD PRIMARY KEY (`id_utilisateur`,`id_produit`,`date_conso`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id_produit`);

--
-- Index pour la table `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`id_sport`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activite`
--
ALTER TABLE `activite`
  ADD CONSTRAINT `activite_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`),
  ADD CONSTRAINT `activite_ibfk_2` FOREIGN KEY (`id_sport`) REFERENCES `sports` (`id_sport`);

--
-- Contraintes pour la table `consommation`
--
ALTER TABLE `consommation`
  ADD CONSTRAINT `consommation_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`),
  ADD CONSTRAINT `consommation_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
