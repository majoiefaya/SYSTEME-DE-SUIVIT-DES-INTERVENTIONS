-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 02 sep. 2022 à 09:38
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sdi`
--

-- --------------------------------------------------------

--
-- Structure de la table `action_infos`
--

CREATE TABLE `action_infos` (
  `id` int(11) NOT NULL,
  `creer_par` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creer_le` date NOT NULL,
  `modifier_par` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifier_le` date DEFAULT NULL,
  `enable` tinyint(1) NOT NULL,
  `supprimer_par` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supprimer_le` date DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `dtype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `action_infos`
--

INSERT INTO `action_infos` (`id`, `creer_par`, `creer_le`, `modifier_par`, `modifier_le`, `enable`, `supprimer_par`, `supprimer_le`, `active`, `dtype`) VALUES
(1, 'Le Client', '2022-09-02', 'Le Client', '2022-09-02', 1, NULL, NULL, 1, 'client'),
(2, 'Développeur', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'admin'),
(3, 'Développeur', '2022-09-02', 'Développeur', '2022-09-02', 1, NULL, NULL, 1, 'admin'),
(4, 'Développeur', '2022-09-02', 'Développeur', '2022-09-02', 1, NULL, NULL, 1, 'admin'),
(5, 'Personnel', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'personnel'),
(6, 'Technicien', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'technicien'),
(7, 'Technicien', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'technicien'),
(8, 'Technicien', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'technicien'),
(9, 'Technicien', '2022-09-02', 'Technicien', '2022-09-02', 1, NULL, NULL, 1, 'technicien'),
(10, 'Technicien', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'technicien'),
(11, 'Technicien', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'technicien'),
(12, 'Technicien', '2022-09-02', 'Technicien', '2022-09-02', 1, NULL, NULL, 1, 'technicien'),
(13, 'Personnel', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'personnel'),
(14, 'Admin', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'equipe'),
(15, 'Admin', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'equipe'),
(16, 'Admin', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'equipe'),
(17, 'Admin', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'equipe'),
(18, 'Développeur', '2022-09-02', NULL, NULL, 1, NULL, NULL, 0, 'intervention'),
(19, 'Développeur', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'typeequipement'),
(20, 'Développeur', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'typeequipement'),
(21, 'Développeur', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'typeequipement'),
(22, 'Développeur', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'equipement'),
(23, 'Développeur', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'equipement'),
(24, 'Développeur', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'equipement'),
(25, 'Développeur', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'equipement'),
(26, 'Développeur', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'equipement'),
(27, 'dhiki@gmail.com', '2022-09-02', NULL, NULL, 1, NULL, NULL, 1, 'rapport');

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fonction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `fonction`, `statut`) VALUES
(2, 'Developpeur', 'Administrateur de L\'Application'),
(3, 'Developpeur', 'Administrateur de L\'Application'),
(4, 'Developpeur', 'Administrateur de L\'Application');

-- --------------------------------------------------------

--
-- Structure de la table `assistant_auto`
--

CREATE TABLE `assistant_auto` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `nom_ass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL,
  `intervention_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `all_day` tinyint(1) NOT NULL,
  `background_color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `border_color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `intervention_id` int(11) DEFAULT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_envoi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220902041242', '2022-09-02 06:13:29', 2789);

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `id` int(11) NOT NULL,
  `fonction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id`, `fonction`, `statut`) VALUES
(5, 'Secretaire', 'SG'),
(6, 'Developpeur', 'Technicien Superieur'),
(7, 'Ingenieur Cybersecurité', 'Technicien'),
(8, 'Developpeur', 'Technicien'),
(9, 'Developpeur', 'Technicien'),
(10, 'Developpeur', 'chef,Responsable'),
(11, 'Developpeur', 'Technicien'),
(12, 'Ingenieur Reseau', 'Technicien'),
(13, 'Hotesse', 'Membre du personnel');

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE `equipe` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `nom_equipe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`id`, `admin_id`, `nom_equipe`, `type`) VALUES
(14, NULL, 'Specialiste D\'Installation', 'Ingenieur Reseau'),
(15, NULL, 'Equipe de Dev1', 'Developpeur'),
(16, NULL, 'Ingenieur Systeme 1', 'Ingenieur Systeme'),
(17, NULL, 'Ingenieur Securité 1', 'Specialiste Securité');

-- --------------------------------------------------------

--
-- Structure de la table `equipement`
--

CREATE TABLE `equipement` (
  `id` int(11) NOT NULL,
  `type_equipement_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disponibilite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_utilisation` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantite_equipement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `equipement`
--

INSERT INTO `equipement` (`id`, `type_equipement_id`, `libelle`, `disponibilite`, `nombre_utilisation`, `image`, `quantite_equipement`) VALUES
(22, 20, 'Fibre Optique', 'Disponible', 1, 'st.png', 9),
(23, 19, 'Routeur', 'Disponible', 0, 'routeur.jpg', 10),
(24, 20, 'cable Ethernet', 'Disponible', 1, 'cable ethernet.webp', 18),
(25, 19, 'Routeur az3', 'Disponible', 1, 'routeur-industriel-5g-ur75-de-milesight-iot.jpg', 9),
(26, 21, 'Mikrotik Switch', 'Disponible', 1, 'switches-small.webp', 9);

-- --------------------------------------------------------

--
-- Structure de la table `equipe_intervention`
--

CREATE TABLE `equipe_intervention` (
  `equipe_id` int(11) NOT NULL,
  `intervention_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `equipe_intervention`
--

INSERT INTO `equipe_intervention` (`equipe_id`, `intervention_id`) VALUES
(15, 18);

-- --------------------------------------------------------

--
-- Structure de la table `equipe_technicien`
--

CREATE TABLE `equipe_technicien` (
  `equipe_id` int(11) NOT NULL,
  `technicien_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `equipe_technicien`
--

INSERT INTO `equipe_technicien` (`equipe_id`, `technicien_id`) VALUES
(14, 6),
(14, 7),
(14, 10),
(15, 8),
(15, 9),
(15, 10),
(16, 9),
(16, 10),
(16, 11),
(17, 7),
(17, 8),
(17, 9),
(17, 12);

-- --------------------------------------------------------

--
-- Structure de la table `fonction`
--

CREATE TABLE `fonction` (
  `id` int(11) NOT NULL,
  `assistant_auto_id` int(11) DEFAULT NULL,
  `nom_fonction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

CREATE TABLE `intervention` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `date_intervention` date DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duree_intervention` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `date_debut_intervention` datetime DEFAULT NULL,
  `date_fin_intervention` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `intervention`
--

INSERT INTO `intervention` (`id`, `client_id`, `admin_id`, `zone_id`, `date_intervention`, `titre`, `description`, `duree_intervention`, `latitude`, `longitude`, `date_debut_intervention`, `date_fin_intervention`) VALUES
(18, 1, NULL, NULL, NULL, 'Traitement de L\'Installation de Wifi pour MajoieFaya', 'Je voudrai qu\'on me fasse une Installation de Wifi chez moi a la maison', '101', 6.2348878009768, 1.1763954162598, '2022-09-02 09:00:00', '2022-09-06 14:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `intervention_ass`
--

CREATE TABLE `intervention_ass` (
  `id` int(11) NOT NULL,
  `technicien_id` int(11) DEFAULT NULL,
  `intervention_id` int(11) DEFAULT NULL,
  `raisons` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `intervention_equipement`
--

CREATE TABLE `intervention_equipement` (
  `intervention_id` int(11) NOT NULL,
  `equipement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `intervention_equipement`
--

INSERT INTO `intervention_equipement` (`intervention_id`, `equipement_id`) VALUES
(18, 22),
(18, 24),
(18, 25),
(18, 26);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `message_sender_id` int(11) DEFAULT NULL,
  `message_receiver_id` int(11) DEFAULT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_envoi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `employe_id` int(11) DEFAULT NULL,
  `raisons` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_demande` date NOT NULL,
  `heure` datetime NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE `personnel` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personnel`
--

INSERT INTO `personnel` (`id`) VALUES
(5),
(13);

-- --------------------------------------------------------

--
-- Structure de la table `points_geo`
--

CREATE TABLE `points_geo` (
  `id` int(11) NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rapport`
--

CREATE TABLE `rapport` (
  `id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `intervention_id` int(11) DEFAULT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_envoi` date DEFAULT NULL,
  `fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sujet_rapport` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_rapport` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heure_envoi` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `rapport`
--

INSERT INTO `rapport` (`id`, `employe_id`, `admin_id`, `intervention_id`, `contenu`, `date_envoi`, `fichier`, `sujet_rapport`, `statut_rapport`, `heure_envoi`) VALUES
(27, 9, 3, 18, '          Nous Irons a la date Prevue', '2022-09-02', 'SDI.pdf', 'D accord Intervention Recue ', 'NonLu', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

CREATE TABLE `tache` (
  `id` int(11) NOT NULL,
  `destinataire_tache_id` int(11) NOT NULL,
  `titre_tache` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `technicien`
--

CREATE TABLE `technicien` (
  `id` int(11) NOT NULL,
  `chef_id` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `technicien`
--

INSERT INTO `technicien` (`id`, `chef_id`, `type`) VALUES
(6, 14, 'Analyste Reseau'),
(7, NULL, 'Analyste Securité'),
(8, 15, 'Developpeur Web'),
(9, 17, 'Ingenieur Systeme'),
(10, 16, 'Ingenieur Systeme'),
(11, NULL, 'Developpeur Mobile'),
(12, NULL, 'Analyste de flux');

-- --------------------------------------------------------

--
-- Structure de la table `type_equipement`
--

CREATE TABLE `type_equipement` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantite_type_equipement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_equipement`
--

INSERT INTO `type_equipement` (`id`, `libelle`, `description`, `quantite_type_equipement`) VALUES
(19, 'Routeur', 'Equipement Utilisé pour des Installations Reseau', 2),
(20, 'Cables', 'Cables Utilises pour des Insatllations d\'Equipement', 2),
(21, 'Switch', 'Equipement Reseau pour l interconnection des Machines', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `sexe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` int(11) NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `newsletter` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `age`, `sexe`, `telephone`, `adresse`, `email`, `mot_de_passe`, `roles`, `image`, `code`, `newsletter`) VALUES
(1, 'Faya', 'Lidao Majoie', 19, 'Homme', 96329943, 'Lome-Togo', 'majoiefaya96@gmail.com', '$2y$13$TQBLTFEEl9jxWSVBi7CHFOmODirIHjJpOKFvMYxdYN62GjFW27aki', '[\"ROLE_CLIENT\"]', 'majoie.jpeg', 'c783', NULL),
(2, 'Faya', 'Lidao Majoie', 19, 'M', 96329943, 'Lome-Togo', 'majoiefaya@gmail.com', '$2y$13$/NY4dM2uaydlFwA5Uxk/SOMLbQoSGyfEM1W0oY5CDsbQw3Ylvo3Sa', '[\"ROLE_ADMIN\"]', 'majoie.jpeg', 'ad9c', NULL),
(3, 'Bagna', 'Ewe Prince', 20, 'M', 96329943, 'Lome-Togo', 'bagnaprince@gmail.com', '$2y$13$umZw.tKNzrGqyGvk0l9ot.hHSqgiPQyYPApllGji5b15owNNFpKla', '[\"ROLE_ADMIN\"]', '', '5bd7', NULL),
(4, 'Gbati', 'Ninkabou badji', 29, 'Masculin', 96329943, 'Lome-Togo', 'gbati@gmail.com', '$2y$13$Bk85wbRgR4Uqpolxe75Ca.gQNiarP1jJuMPTcA0A05v7j4yUhtP2y', '[\"ROLE_ADMIN\"]', 'Mr gbati.jpeg', '3299', NULL),
(5, 'Koudaya', 'Nadege', 22, 'Feminin', 79441644, 'Lome-Togo', 'koudaya@gmail.com', '$2y$13$F3RYiRSpjTTMhVjBv.0jyONmEb.RhLUGy7AxSgSh6w1AMLH1l7pOK', '[\"ROLE_PERSONNEL\"]', '', '9e42', NULL),
(6, 'GoGo', 'Kossi Daniel', 20, 'Masculin', 93856735, 'Lome-Togo', 'gogoKossi@gmail.com', '$2y$13$v2vI9.6oknmIT4S9tnWrY.Uf56vWQzKoBztcchF5yLQ79W.6uIpFy', '[\"ROLE_TECHNICIEN\"]', 'gogo.jpeg', 'acb1', NULL),
(7, 'Ahlidja', 'Emmanuel', 20, 'Masculin', 98169084, 'Lome-Togo', 'emmanuel@gmail.com', '$2y$13$HomX23ANaSWr2zAjlxaVkuHOC8ahiPQxxy7u74hvY3wuSeVn9pzZu', '[\"ROLE_TECHNICIEN\"]', 'Emmanuel.jpeg', '2ac9', NULL),
(8, 'Akarim', 'Gerbo', 18, 'Masculin', 91420502, 'Lome-Togo', 'akarimgerbo11@gmail.com', '$2y$13$6frcCou3EeRMzQkSQ1liPusOyTtAMs6GyUvspaktnuVMQHtenw7KK', '[\"ROLE_TECHNICIEN\"]', 'gerbo.jpeg', '23ee', NULL),
(9, 'Kafechinois', 'Estelle', 20, 'Masculin', 96329943, 'Lome-Togo', 'dhiki@gmail.com', '$2y$13$Av1.abfQRgiWAhv8M9AdiOl50jU8bAnEx9Z0yoPMRGm4m4fiK4kCG', '[\"ROLE_TECHNICIEN\"]', 'Estelle2.jpeg', '2c96', NULL),
(10, 'Dave', 'David', 20, 'Masculin', 91494900, 'Lome-Togo', 'david@gmail.com', '$2y$13$MudtcDdWG/sUyOObExwjHO66d/GfF/91jxRj2KZeEVwnFw7onBt46', '[\"ROLE_TECHNICIEN\"]', 'david.jpeg', '23c8', NULL),
(11, 'Docteur', 'Vladimir', 18, 'Masculin', 93547586, 'Lome-Togo', 'vlad@gmail.com', '$2y$13$W1HWoFY/quHh91ZnLj.2/OMOdwbvhgj1Prx.2IVcinyuukQlxxTUW', '[\"ROLE_TECHNICIEN\"]', 'Davidvlad.jpeg', '44f6', NULL),
(12, 'Botre', 'Bill', 18, 'Masculin', 96329943, 'Lome-Togo', 'bill@gmail.com', '$2y$13$oZXydtFYGKc96voZkyA7B.eUeFpZ4EWROA7LnMcs1oW.e0QJDwP.u', '[\"ROLE_TECHNICIEN\"]', 'bill.jpeg', '9e60', NULL),
(13, 'Estelle', 'Estelle', 20, 'Feminin', 99624517, 'Lome-Togo', 'estelle@gmail.com', '$2y$13$jlQD7/yWVpPyNQ9sTQYIE.M48NJ0dXgmB5YhBA5WdmWAEwA9hdRtS', '[\"ROLE_PERSONNEL\"]', 'Estelle.jpeg', '6169', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `zone`
--

CREATE TABLE `zone` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `zone_points_geo`
--

CREATE TABLE `zone_points_geo` (
  `zone_id` int(11) NOT NULL,
  `points_geo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `action_infos`
--
ALTER TABLE `action_infos`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `assistant_auto`
--
ALTER TABLE `assistant_auto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A5ED2A9F642B8210` (`admin_id`);

--
-- Index pour la table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6EA9A1468EAE3863` (`intervention_id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_67F068BC19EB6921` (`client_id`),
  ADD KEY `IDX_67F068BC8EAE3863` (`intervention_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2449BA15642B8210` (`admin_id`);

--
-- Index pour la table `equipement`
--
ALTER TABLE `equipement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B8B4C6F3F082B869` (`type_equipement_id`);

--
-- Index pour la table `equipe_intervention`
--
ALTER TABLE `equipe_intervention`
  ADD PRIMARY KEY (`equipe_id`,`intervention_id`),
  ADD KEY `IDX_5701568E6D861B89` (`equipe_id`),
  ADD KEY `IDX_5701568E8EAE3863` (`intervention_id`);

--
-- Index pour la table `equipe_technicien`
--
ALTER TABLE `equipe_technicien`
  ADD PRIMARY KEY (`equipe_id`,`technicien_id`),
  ADD KEY `IDX_BC1B76BD6D861B89` (`equipe_id`),
  ADD KEY `IDX_BC1B76BD13457256` (`technicien_id`);

--
-- Index pour la table `fonction`
--
ALTER TABLE `fonction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_900D5BD21DE68B5` (`assistant_auto_id`);

--
-- Index pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D11814AB19EB6921` (`client_id`),
  ADD KEY `IDX_D11814AB642B8210` (`admin_id`),
  ADD KEY `IDX_D11814AB9F2C3FAB` (`zone_id`);

--
-- Index pour la table `intervention_ass`
--
ALTER TABLE `intervention_ass`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C4AB84FF13457256` (`technicien_id`),
  ADD KEY `IDX_C4AB84FF8EAE3863` (`intervention_id`);

--
-- Index pour la table `intervention_equipement`
--
ALTER TABLE `intervention_equipement`
  ADD PRIMARY KEY (`intervention_id`,`equipement_id`),
  ADD KEY `IDX_FA49BCFE8EAE3863` (`intervention_id`),
  ADD KEY `IDX_FA49BCFE806F0F5C` (`equipement_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6BD307F9C9DB5AB` (`message_sender_id`),
  ADD KEY `IDX_B6BD307FAD2CB34F` (`message_receiver_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E04992AA1B65292` (`employe_id`);

--
-- Index pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `points_geo`
--
ALTER TABLE `points_geo`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rapport`
--
ALTER TABLE `rapport`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BE34A09C1B65292` (`employe_id`),
  ADD KEY `IDX_BE34A09C642B8210` (`admin_id`),
  ADD KEY `IDX_BE34A09C8EAE3863` (`intervention_id`);

--
-- Index pour la table `tache`
--
ALTER TABLE `tache`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_93872075C3609AD3` (`destinataire_tache_id`);

--
-- Index pour la table `technicien`
--
ALTER TABLE `technicien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_96282C4C150A48F1` (`chef_id`);

--
-- Index pour la table `type_equipement`
--
ALTER TABLE `type_equipement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `zone_points_geo`
--
ALTER TABLE `zone_points_geo`
  ADD PRIMARY KEY (`zone_id`,`points_geo_id`),
  ADD KEY `IDX_9765C8E19F2C3FAB` (`zone_id`),
  ADD KEY `IDX_9765C8E1EF9AF45D` (`points_geo_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `action_infos`
--
ALTER TABLE `action_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `assistant_auto`
--
ALTER TABLE `assistant_auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fonction`
--
ALTER TABLE `fonction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `intervention_ass`
--
ALTER TABLE `intervention_ass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `points_geo`
--
ALTER TABLE `points_geo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `zone`
--
ALTER TABLE `zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `FK_880E0D76BF396750` FOREIGN KEY (`id`) REFERENCES `action_infos` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `assistant_auto`
--
ALTER TABLE `assistant_auto`
  ADD CONSTRAINT `FK_A5ED2A9F642B8210` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`);

--
-- Contraintes pour la table `calendar`
--
ALTER TABLE `calendar`
  ADD CONSTRAINT `FK_6EA9A1468EAE3863` FOREIGN KEY (`intervention_id`) REFERENCES `intervention` (`id`);

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FK_C7440455BF396750` FOREIGN KEY (`id`) REFERENCES `action_infos` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BC19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_67F068BC8EAE3863` FOREIGN KEY (`intervention_id`) REFERENCES `intervention` (`id`);

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `FK_F804D3B9BF396750` FOREIGN KEY (`id`) REFERENCES `action_infos` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD CONSTRAINT `FK_2449BA15642B8210` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `FK_2449BA15BF396750` FOREIGN KEY (`id`) REFERENCES `action_infos` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `equipement`
--
ALTER TABLE `equipement`
  ADD CONSTRAINT `FK_B8B4C6F3BF396750` FOREIGN KEY (`id`) REFERENCES `action_infos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B8B4C6F3F082B869` FOREIGN KEY (`type_equipement_id`) REFERENCES `type_equipement` (`id`);

--
-- Contraintes pour la table `equipe_intervention`
--
ALTER TABLE `equipe_intervention`
  ADD CONSTRAINT `FK_5701568E6D861B89` FOREIGN KEY (`equipe_id`) REFERENCES `equipe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5701568E8EAE3863` FOREIGN KEY (`intervention_id`) REFERENCES `intervention` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `equipe_technicien`
--
ALTER TABLE `equipe_technicien`
  ADD CONSTRAINT `FK_BC1B76BD13457256` FOREIGN KEY (`technicien_id`) REFERENCES `technicien` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_BC1B76BD6D861B89` FOREIGN KEY (`equipe_id`) REFERENCES `equipe` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `fonction`
--
ALTER TABLE `fonction`
  ADD CONSTRAINT `FK_900D5BD21DE68B5` FOREIGN KEY (`assistant_auto_id`) REFERENCES `assistant_auto` (`id`);

--
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `FK_D11814AB19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_D11814AB642B8210` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `FK_D11814AB9F2C3FAB` FOREIGN KEY (`zone_id`) REFERENCES `zone` (`id`),
  ADD CONSTRAINT `FK_D11814ABBF396750` FOREIGN KEY (`id`) REFERENCES `action_infos` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `intervention_ass`
--
ALTER TABLE `intervention_ass`
  ADD CONSTRAINT `FK_C4AB84FF13457256` FOREIGN KEY (`technicien_id`) REFERENCES `technicien` (`id`),
  ADD CONSTRAINT `FK_C4AB84FF8EAE3863` FOREIGN KEY (`intervention_id`) REFERENCES `intervention` (`id`);

--
-- Contraintes pour la table `intervention_equipement`
--
ALTER TABLE `intervention_equipement`
  ADD CONSTRAINT `FK_FA49BCFE806F0F5C` FOREIGN KEY (`equipement_id`) REFERENCES `equipement` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_FA49BCFE8EAE3863` FOREIGN KEY (`intervention_id`) REFERENCES `intervention` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307F9C9DB5AB` FOREIGN KEY (`message_sender_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_B6BD307FAD2CB34F` FOREIGN KEY (`message_receiver_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `FK_E04992AA1B65292` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`id`);

--
-- Contraintes pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `FK_A6BCF3DEBF396750` FOREIGN KEY (`id`) REFERENCES `action_infos` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `rapport`
--
ALTER TABLE `rapport`
  ADD CONSTRAINT `FK_BE34A09C1B65292` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`id`),
  ADD CONSTRAINT `FK_BE34A09C642B8210` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `FK_BE34A09C8EAE3863` FOREIGN KEY (`intervention_id`) REFERENCES `intervention` (`id`),
  ADD CONSTRAINT `FK_BE34A09CBF396750` FOREIGN KEY (`id`) REFERENCES `action_infos` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tache`
--
ALTER TABLE `tache`
  ADD CONSTRAINT `FK_93872075BF396750` FOREIGN KEY (`id`) REFERENCES `action_infos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_93872075C3609AD3` FOREIGN KEY (`destinataire_tache_id`) REFERENCES `employe` (`id`);

--
-- Contraintes pour la table `technicien`
--
ALTER TABLE `technicien`
  ADD CONSTRAINT `FK_96282C4C150A48F1` FOREIGN KEY (`chef_id`) REFERENCES `equipe` (`id`),
  ADD CONSTRAINT `FK_96282C4CBF396750` FOREIGN KEY (`id`) REFERENCES `action_infos` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `type_equipement`
--
ALTER TABLE `type_equipement`
  ADD CONSTRAINT `FK_A5B710D6BF396750` FOREIGN KEY (`id`) REFERENCES `action_infos` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_1D1C63B3BF396750` FOREIGN KEY (`id`) REFERENCES `action_infos` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `zone_points_geo`
--
ALTER TABLE `zone_points_geo`
  ADD CONSTRAINT `FK_9765C8E19F2C3FAB` FOREIGN KEY (`zone_id`) REFERENCES `zone` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9765C8E1EF9AF45D` FOREIGN KEY (`points_geo_id`) REFERENCES `points_geo` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
