-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Serveur: Localhost
-- Généré le : Mer 02 Mars 2011 à 17:33
-- Version du serveur: 5.5.9
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-

-- --------------------------------------------------------

--
-- Structure de la table `abs_categorie`
--

CREATE TABLE IF NOT EXISTS `abs_categorie` (
  `cat_id` int(2) NOT NULL AUTO_INCREMENT,
  `cat_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `abs_categorie2`
--

CREATE TABLE IF NOT EXISTS `abs_categorie2` (
  `cat2_id` int(2) NOT NULL AUTO_INCREMENT,
  `cat2_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cat2_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `abs_conges`
--

CREATE TABLE IF NOT EXISTS `abs_conges` (
  `conges_id` int(5) NOT NULL AUTO_INCREMENT,
  `conges_employe` int(3) NOT NULL,
  `conges_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `conges_type` int(2) NOT NULL,
  `conges_demijournee` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `conges_debut` int(5) NOT NULL,
  `conges_periodicite` int(2) NOT NULL,
  `conges_periodicite_debut` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `conges_periodicite_fin` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `conges_commentaire` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `conges_login_saisie` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `conges_date_saisie` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`conges_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `abs_droits_ent`
--

CREATE TABLE IF NOT EXISTS `abs_droits_ent` (
  `droits_ent_util` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `droits_ent_id` int(2) NOT NULL,
  PRIMARY KEY (`droits_ent_util`,`droits_ent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `abs_droits_sect`
--

CREATE TABLE IF NOT EXISTS `abs_droits_sect` (
  `droits_sect_util` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `droits_sect_id` int(2) NOT NULL,
  PRIMARY KEY (`droits_sect_util`,`droits_sect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `abs_employe`
--

CREATE TABLE IF NOT EXISTS `abs_employe` (
  `emp_id` int(3) NOT NULL AUTO_INCREMENT,
  `emp_nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `emp_prenom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `emp_actif` int(1) NOT NULL,
  `emp_arrivee` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `emp_statut` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `emp_samedi` int(1) NOT NULL,
  `emp_date_naissance` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `emp_categorie1` int(2) NOT NULL,
  `emp_categorie2` int(2) NOT NULL,
  `emp_fonction` int(2) NOT NULL,
  `emp_secteur` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `emp_depart` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `emp_ent` int(2) NOT NULL,
  `emp_nb_conges_cours` float NOT NULL,
  `emp_nb_conges_report` float NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `abs_entreprise`
--

CREATE TABLE IF NOT EXISTS `abs_entreprise` (
  `ent_id` int(2) NOT NULL AUTO_INCREMENT,
  `ent_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ent_addr1` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ent_addr2` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ent_cp` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `ent_ville` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ent_tel` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ent_fax` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ent_comm` text COLLATE utf8_unicode_ci NOT NULL,
  `ent_parent` int(2) NOT NULL,
  PRIMARY KEY (`ent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `abs_feries`
--

CREATE TABLE IF NOT EXISTS `abs_feries` (
  `feries_id` int(3) NOT NULL AUTO_INCREMENT,
  `feries_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `feries_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `feries_fixe` int(1) NOT NULL,
  PRIMARY KEY (`feries_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `abs_feries` (jours reguliers)
--

INSERT INTO `abs_feries` (`feries_id`, `feries_nom`, `feries_date`, `feries_fixe`) VALUES
(1, '1er de l''An', '01-01-1900', 1),
(2, 'Fête du travail', '01-05-1947', 1),
(3, 'Victoire 1945', '08-05-1946', 1),
(4, '14 Juillet', '14-07-1880', 1),
(5, 'Assomption', '15-08-1900', 1),
(6, 'Toussaint', '01-11-1900', 1),
(7, 'Armistice 1918', '11-11-1919', 1),
(8, 'Noël', '25-12-1900', 1);
-- --------------------------------------------------------

--
-- Structure de la table `abs_fonction`
--

CREATE TABLE IF NOT EXISTS `abs_fonction` (
  `fonct_id` int(2) NOT NULL AUTO_INCREMENT,
  `fonct_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`fonct_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `abs_periodicite`
--

CREATE TABLE IF NOT EXISTS `abs_periodicite` (
  `periodicite_id` int(2) NOT NULL,
  `periodicite_libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `periodicite_jours` int(3) NOT NULL,
  PRIMARY KEY (`periodicite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `abs_periodicite`
--

INSERT INTO `abs_periodicite` (`periodicite_id`, `periodicite_libelle`, `periodicite_jours`) VALUES
(0, 'Aucune', 0),
(1, 'Chaque semaine', 7),
(2, 'Une semaine sur deux', 15),
(3, 'Une semaine sur trois', 21);

-- --------------------------------------------------------

--
-- Structure de la table `abs_secteur`
--

CREATE TABLE IF NOT EXISTS `abs_secteur` (
  `sect_id` int(2) NOT NULL AUTO_INCREMENT,
  `sect_nom` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `sect_intitule` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`sect_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `abs_type`
--

CREATE TABLE IF NOT EXISTS `abs_type` (
  `type_id` int(2) NOT NULL AUTO_INCREMENT,
  `type_nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type_couleur` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `type_commentaire` int(1) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Contenu de la table `abs_type`
--

INSERT INTO `abs_type` (`type_id`, `type_nom`, `type_couleur`) VALUES
(1, 'Congés Payés', '#E67E30'),
(2, 'Congés Sans Solde', '#463F32'),
(3, 'RTT', '#FEC3AC'),
(4, 'Formation', '#A10684'),
(5, 'Cours', '#A10684'),
(6, 'Maternité / Paternité', '#463F32'),
(7, 'Maladie', '#C60800'),
(8, 'Décès', '#463F32'),
(9, 'Autres', '#463F32');

-- --------------------------------------------------------

--
-- Structure de la table `abs_utilisateur`
--

CREATE TABLE IF NOT EXISTS `abs_utilisateur` (
  `util_login` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `util_password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `util_nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `util_prenom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `util_admin_secteur` int(1) NOT NULL,
  `util_admin_general` int(1) NOT NULL,
  `util_actif` int(1) NOT NULL,
  PRIMARY KEY (`util_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- INSERT administrateur avec password: admin
-- INSERT INTO `abs_utilisateur` (`util_login`, `util_password`, `util_nom`, `util_prenom`, `util_admin_secteur`, `util_admin_general`, `util_actif`) VALUES
-- ('administrateur', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrateur', 'Conges', 0, 1, 1);

