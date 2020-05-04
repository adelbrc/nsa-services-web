-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 04 mai 2020 à 01:27
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `nsaservices_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `contract`
--

DROP TABLE IF EXISTS `contract`;
CREATE TABLE IF NOT EXISTS `contract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beginning` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `clauses` longtext,
  `file_path` varchar(250) NOT NULL,
  `partner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contract_partner1_idx` (`partner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contract`
--

INSERT INTO `contract` (`id`, `beginning`, `end_date`, `clauses`, `file_path`, `partner_id`) VALUES
(1, '2020-04-10 00:00:00', '2020-04-11 00:00:00', 'BOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateurBOnjour je suis un ordinateur', './', 2),
(2, '2020-04-10 00:00:00', '2020-04-19 00:00:00', 'Jadore la musique', '../../../collaborateur/contracts/contract-2-2020-04-10-14-14-39.pdf', 2);

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

DROP TABLE IF EXISTS `devis`;
CREATE TABLE IF NOT EXISTS `devis` (
  `devis_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `ordered_date` datetime NOT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'En attente',
  `devis_cost` int(11) DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `answer_date` datetime DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`devis_id`),
  KEY `service_id_fk` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `devis`
--

INSERT INTO `devis` (`devis_id`, `title`, `customer_id`, `service_id`, `ordered_date`, `description`, `status`, `devis_cost`, `answer`, `answer_date`, `address`) VALUES
(1, 'Devis pour : Cours d\'anglais', 4, 3, '2020-05-01 01:09:12', 'yessir', 'Confirme', 156, 'Ok c bon', '2020-05-01 03:40:25', '2 Bis rue, Issy'),
(2, 'J\'ai froid', 4, NULL, '2020-05-04 03:04:32', 'Une couverture', 'Confirme', 200, 'ok on arrive', '2020-05-04 03:04:56', '2 Bis rue, Issy');

-- --------------------------------------------------------

--
-- Structure de la table `devis_session`
--

DROP TABLE IF EXISTS `devis_session`;
CREATE TABLE IF NOT EXISTS `devis_session` (
  `devis_session_id` int(11) NOT NULL AUTO_INCREMENT,
  `devis_id_fk` int(11) NOT NULL,
  `devis_day` date DEFAULT NULL,
  `devis_begin_time` time DEFAULT NULL,
  `devis_end_time` time DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`devis_session_id`),
  KEY `devis_id_fk` (`devis_id_fk`),
  KEY `devis_partner_fk` (`partner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `devis_session`
--

INSERT INTO `devis_session` (`devis_session_id`, `devis_id_fk`, `devis_day`, `devis_begin_time`, `devis_end_time`, `partner_id`) VALUES
(1, 1, '2020-04-30', '09:00:00', '10:00:00', NULL),
(2, 2, '2020-05-05', '09:00:00', '13:00:00', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

DROP TABLE IF EXISTS `intervention`;
CREATE TABLE IF NOT EXISTS `intervention` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partner_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `intervention_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_intervention_partner1_idx` (`partner_id`),
  KEY `fk_intervention_order1_idx` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `stripe_id` varchar(120) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `amount_paid` float NOT NULL,
  `date_issue` datetime NOT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `file_path` varchar(250) NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `stripe_id`, `customer_id`, `currency`, `amount_paid`, `date_issue`, `membership_id`, `service_id`, `file_path`) VALUES
(45, NULL, 7, NULL, 2400, '2020-05-01 14:43:20', 1, NULL, 'admin/docs/invoices/invoice-7-plan_GvuVUliaJuscn9-2020-05-01-14-43-19.pdf'),
(46, 'cus_HCOsmndfvqiMse', 7, NULL, 15, '2020-05-08 00:00:00', NULL, 5, ''),
(47, 'cus_HCOsmndfvqiMse', 7, NULL, 15, '2020-05-08 00:00:00', NULL, 5, ''),
(48, 'cus_HCOsmndfvqiMse', 7, NULL, 30, '2020-05-08 00:00:00', NULL, 4, ''),
(49, 'cus_HCOsmndfvqiMse', 7, NULL, 20, '2020-05-08 00:00:00', NULL, 3, ''),
(50, 'cus_HCOsmndfvqiMse', 7, NULL, 0, '2020-05-08 00:00:00', NULL, 4, ''),
(51, NULL, 8, NULL, 3600, '2020-05-01 16:23:35', 2, NULL, 'admin/docs/invoices/invoice-8-plan_GvuVlxuPefCUQF-2020-05-01-16-23-35.pdf'),
(52, NULL, 8, NULL, 6000, '2020-05-01 16:24:57', 3, NULL, 'admin/docs/invoices/invoice-8-plan_GvuXPHM5yj1R4K-2020-05-01-16-24-57.pdf'),
(53, NULL, 8, NULL, 2400, '2020-05-01 16:30:07', 1, NULL, 'admin/docs/invoices/invoice-8-plan_GvuVUliaJuscn9-2020-05-01-16-30-07.pdf'),
(54, NULL, 8, NULL, 2400, '2020-05-01 16:31:29', 1, NULL, 'admin/docs/invoices/invoice-8-plan_GvuVUliaJuscn9-2020-05-01-16-31-29.pdf'),
(55, 'cus_HCQUbQEowPCrjS', 8, NULL, 15, '2020-05-08 00:00:00', NULL, 5, ''),
(56, 'cus_HCQUbQEowPCrjS', 8, NULL, 30, '2020-05-08 00:00:00', NULL, 5, ''),
(57, NULL, 4, NULL, 2400, '2020-05-03 01:26:05', 1, NULL, 'admin/docs/invoices/invoice-4-plan_GvuVUliaJuscn9-2020-05-03-01-26-05.pdf'),
(58, 'cus_HAFAOdaTgPy3k4', 4, NULL, 20, '2020-05-10 00:00:00', NULL, 3, ''),
(59, 'cus_HAFAOdaTgPy3k4', 4, NULL, 400, '2020-05-10 00:00:00', NULL, 3, ''),
(60, 'cus_HAFAOdaTgPy3k4', 4, NULL, 15, '2020-05-10 00:00:00', NULL, 5, ''),
(61, 'cus_HAFAOdaTgPy3k4', 4, NULL, 15, '2020-05-10 00:00:00', NULL, 5, ''),
(62, 'cus_HAFAOdaTgPy3k4', 4, NULL, 10, '2020-05-10 00:00:00', NULL, 4, ''),
(63, 'cus_HAFAOdaTgPy3k4', 4, NULL, 10, '2020-05-10 00:00:00', NULL, 4, ''),
(64, 'cus_HAFAOdaTgPy3k4', 4, NULL, 15, '2020-05-10 00:00:00', NULL, 5, ''),
(65, 'cus_HAFAOdaTgPy3k4', 4, NULL, 10, '2020-05-10 00:00:00', NULL, 4, ''),
(66, 'cus_HAFAOdaTgPy3k4', 4, NULL, 15, '2020-05-10 00:00:00', NULL, 5, ''),
(67, 'cus_HD8JdOojODkQNi', 10, NULL, 10, '2020-05-10 00:00:00', NULL, 4, ''),
(68, 'cus_HD8JdOojODkQNi', 10, NULL, 20, '2020-05-10 00:00:00', NULL, 3, '');

-- --------------------------------------------------------

--
-- Structure de la table `membership`
--

DROP TABLE IF EXISTS `membership`;
CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_plan` varchar(255) NOT NULL,
  `name` varchar(45) NOT NULL,
  `price` varchar(45) NOT NULL,
  `timeQuota` int(11) NOT NULL,
  `openDays` varchar(45) NOT NULL,
  `openHours` varchar(45) NOT NULL,
  `closeHours` varchar(45) NOT NULL,
  `description` longtext NOT NULL,
  `duration` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membership`
--

INSERT INTO `membership` (`id`, `id_plan`, `name`, `price`, `timeQuota`, `openDays`, `openHours`, `closeHours`, `description`, `duration`) VALUES
(1, 'plan_GvuVUliaJuscn9', 'Basique', '2400', 12, '5', '9', '20', 'Abonnement basique', '12'),
(2, 'plan_GvuVlxuPefCUQF', 'Familial', '3600', 25, '6', '9', '20', 'Abonnement familial', '12'),
(3, 'plan_GvuXPHM5yj1R4K', 'Premium', '6000', 50, '7', '1', '24', 'Abonnement complet', '12');

-- --------------------------------------------------------

--
-- Structure de la table `memberships_history`
--

DROP TABLE IF EXISTS `memberships_history`;
CREATE TABLE IF NOT EXISTS `memberships_history` (
  `user_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `customer_id` varchar(500) NOT NULL,
  `plan_id` varchar(500) NOT NULL,
  `sub_id` varchar(500) NOT NULL,
  `session_id` varchar(500) NOT NULL,
  `beginning` date DEFAULT NULL,
  `ending` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `serviceHoursRemaining` int(11) NOT NULL,
  PRIMARY KEY (`sub_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `memberships_history`
--

INSERT INTO `memberships_history` (`user_id`, `membership_id`, `customer_id`, `plan_id`, `sub_id`, `session_id`, `beginning`, `ending`, `status`, `serviceHoursRemaining`) VALUES
(7, 1, 'cus_HCOsLXiefRbQWx', 'plan_GvuVUliaJuscn9', 'sub_HCOsAOiILpjdU7', 'cs_test_SOTfPc4PNxSYxDKf6dxMiljDRSg0e1DywZAgMvvqSDF5lE6tDZmLmpez', '2020-05-01', '2021-05-01', 'active', 0),
(8, 1, 'cus_HCQbn075tcoOnr', 'plan_GvuVUliaJuscn9', 'sub_HCQbazAxP5yxFU', 'cs_test_1xBnZj6fEEGUrT4NjfJ0bf1Sf4X6CY6mbxbKw9oCIzpChTnsNSqyJJ52', '2020-05-01', '2021-05-01', 'active', 0),
(4, 1, 'cus_HCwTy98K1HWaWf', 'plan_GvuVUliaJuscn9', 'sub_HCwTcQs4Uaga7z', 'cs_test_nbfVszRXXAWox0IQehueM6jThxS4RxD8DyuhGSAMrQ1YbWfhOJgfKQH9', '2020-05-03', '2021-05-03', 'canceled', -16);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `payment_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_order_user1_idx` (`customer_id`),
  KEY `fk_order_service1_idx` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`, `service_id`, `address`, `payment_status`) VALUES
(127, 10, '2020-05-03 22:56:03', 3, 'free, free', 'Paid'),
(128, 4, '2020-05-04 03:05:18', NULL, '2 Bis rue, Issy', 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `order_session`
--

DROP TABLE IF EXISTS `order_session`;
CREATE TABLE IF NOT EXISTS `order_session` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `day` date NOT NULL,
  `beginning` time NOT NULL,
  `end` time NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `orderStatus` varchar(200) NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `fk_reservation_id` (`order_id`),
  KEY `partner_id` (`partner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `order_session`
--

INSERT INTO `order_session` (`session_id`, `order_id`, `day`, `beginning`, `end`, `partner_id`, `orderStatus`) VALUES
(139, 127, '2020-05-03', '09:00:00', '10:00:00', NULL, 'Prevu'),
(140, 128, '2020-05-05', '09:00:00', '13:00:00', NULL, 'Paid');

-- --------------------------------------------------------

--
-- Structure de la table `partner`
--

DROP TABLE IF EXISTS `partner`;
CREATE TABLE IF NOT EXISTS `partner` (
  `partner_id` int(11) NOT NULL AUTO_INCREMENT,
  `add_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `corporation_name` varchar(80) DEFAULT NULL,
  `corporation_id` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(45) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `qrcode` varchar(10000) NOT NULL,
  `pricing` double DEFAULT NULL,
  `disponibility_begin` datetime DEFAULT NULL,
  `disponibility_end` datetime DEFAULT NULL,
  PRIMARY KEY (`partner_id`),
  KEY `phone_UNIQUE` (`phone`) USING BTREE,
  KEY `email_UNIQUE` (`email`) USING BTREE,
  KEY `fk_partner_role1_idx` (`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `partner`
--

INSERT INTO `partner` (`partner_id`, `add_date`, `corporation_name`, `corporation_id`, `lastname`, `firstname`, `role_id`, `address`, `city`, `email`, `password`, `phone`, `qrcode`, `pricing`, `disponibility_begin`, `disponibility_end`) VALUES
(2, '2020-04-20 17:18:57', 'reknacorp', NULL, 'abc', 'def', 1, '4 rue des roses', 'armenia', 'partner@ok.com', '7f3fa48ca885678134842fa7456f3ece53a97f843b610185d900ac4e467c7490', '', 'data:image/png;base64,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', NULL, '2020-04-01 00:00:00', '2020-04-30 00:00:00'),
(10, '2020-04-20 12:00:57', 'bottom', NULL, 'rock', 'john', 2, '1 rue kayou', 'NY', 'johnrock@ok.com', 'ok', '0488551405', 'data:image/png;base64,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', NULL, '2020-04-09 03:00:04', '2020-04-09 00:00:00'),
(11, '2020-04-20 12:00:57', 'bottom', NULL, 'rock', 'john', 1, '1 rue kayou', 'NY', 'johnrock@ok.com', 'ok', '0488551405', '', NULL, '2020-04-09 03:00:04', '2020-04-09 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `nbForDiscount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `name`, `nbForDiscount`) VALUES
(1, 'plomberie', 4),
(2, 'babysitting', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_service` varchar(255) NOT NULL,
  `name` varchar(120) NOT NULL,
  `price` double NOT NULL,
  `discountPrice` double DEFAULT NULL,
  `description` longtext NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Service_Category1_idx` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id`, `id_service`, `name`, `price`, `discountPrice`, `description`, `category_id`) VALUES
(3, 'plan_H3RcKDN3MIT23E', 'Cours d\'anglais', 20, 15, '', 1),
(4, 'plan_H3gDiUCmHpTw4V', 'Babysitting', 10, 5, '', 1),
(5, 'plan_H98tsXU57J2Z0U', 'Cours de maths', 15, 10, '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `traduction`
--

DROP TABLE IF EXISTS `traduction`;
CREATE TABLE IF NOT EXISTS `traduction` (
  `id_traduction` int(11) NOT NULL AUTO_INCREMENT,
  `name_traduction` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_traduction` varchar(20) NOT NULL DEFAULT 'En cours',
  PRIMARY KEY (`id_traduction`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `traduction`
--

INSERT INTO `traduction` (`id_traduction`, `name_traduction`, `date`, `status_traduction`) VALUES
(2, 'Turc', '2020-05-03 13:08:21', 'termine'),
(4, 'Arabe', '2020-05-03 13:12:51', 'termine'),
(5, 'Armenien', '2020-05-03 13:39:40', 'termine');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cus_id` varchar(20) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(65) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT '0',
  `profile_picture` varchar(255) DEFAULT NULL,
  `signup_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `signup_token` varchar(80) DEFAULT NULL,
  `confirm_date` datetime DEFAULT NULL,
  `pass_reset_token` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `phone_number_UNIQUE` (`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `cus_id`, `firstname`, `lastname`, `email`, `password`, `phone_number`, `address`, `city`, `rank`, `profile_picture`, `signup_date`, `signup_token`, `confirm_date`, `pass_reset_token`) VALUES
(4, 'cus_HAFAOdaTgPy3k4', 'narek', 'narek', 'narek@ok.com', '1b434e67624c72746a3dd0bbb19e4fe5b8421d9173e4918f9ab43a9298576b77', '0481547150', '2 Bis rue', 'Issy', 3, '../../../ressources/img/profile_pics/4-2020-04-25-20-33-29-ECMbm1xyZBjxfq1fwbrq.jpg', '2020-04-25 22:32:27', NULL, NULL, NULL),
(6, 'cus_HAsAbBbu8hX7f1', 'bro', 'bro', 'bro@ok.com', 'ff3727276784ada3f6d609a19ed541d9e888759559d81a4045e3c790aa40f276', '0514751020', 'bro', 'bro', 0, NULL, '2020-04-27 14:50:54', NULL, NULL, NULL),
(7, 'cus_HCOsmndfvqiMse', 'misterv@ok.com', 'misterv@ok.com', 'misterv@ok.com', '7d145634b4567aa195a7a1593a6d6eefa6565e1912ed577d93bdb7e23f4eaa48', '0784152410', 'misterv@ok.com', 'misterv@ok.com', 0, NULL, '2020-05-01 16:42:34', NULL, NULL, NULL),
(8, 'cus_HCQUbQEowPCrjS', 'bruh', 'bruh', 'bruh@ok.com', '408f31d86c6bf4a8aff4ea682ad002278f8cb39dc5f37b53d343e63a61f3cc4f', '0145147141', 'bruh', 'bruh', 0, NULL, '2020-05-01 18:22:49', NULL, NULL, NULL),
(9, 'cus_HCpbXucHLs97Sq', 'stylo@ok.com', 'stylo@ok.com', 'stylo@ok.com', 'c9c24ee44dc60c14fd63b99075aee3abd4f5f8bff2c3a06ab7efe9d40d02d3f4', '0514748121', 'stylo@ok.com', 'stylo@ok.com', 0, NULL, '2020-05-02 20:19:47', NULL, NULL, NULL),
(10, 'cus_HD8JdOojODkQNi', 'free', 'free', 'free@ok.com', 'ad95d5fa651ba86d8923fe1238d24a4f1988a752acfe426ac72ac7c04471bc17', '0514741805', 'free', 'free', 0, NULL, '2020-05-03 15:39:53', NULL, NULL, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contract`
--
ALTER TABLE `contract`
  ADD CONSTRAINT `fk_contract_partner1` FOREIGN KEY (`partner_id`) REFERENCES `partner` (`partner_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `service_id_fk` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`);

--
-- Contraintes pour la table `devis_session`
--
ALTER TABLE `devis_session`
  ADD CONSTRAINT `devis_id_fk` FOREIGN KEY (`devis_id_fk`) REFERENCES `devis` (`devis_id`),
  ADD CONSTRAINT `devis_partner_fk` FOREIGN KEY (`partner_id`) REFERENCES `partner` (`partner_id`);

--
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `fk_intervention_order1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_intervention_partner1` FOREIGN KEY (`partner_id`) REFERENCES `partner` (`partner_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_service1` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_user1` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `order_session`
--
ALTER TABLE `order_session`
  ADD CONSTRAINT `fk_reservation_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_session_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partner` (`partner_id`);

--
-- Contraintes pour la table `partner`
--
ALTER TABLE `partner`
  ADD CONSTRAINT `fk_partner_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `fk_Service_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
