CREATE DATABESE FREDI DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;

USE FREDI
-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 29 sep. 2022 à 17:02
-- Version du serveur : 10.4.20-MariaDB
-- Version de PHP : 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fredi`
--

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

CREATE TABLE `adherent` (
  `idadherent` int(11) NOT NULL,
  `clubad` varchar(50) NOT NULL,
  `numlicencead` float NOT NULL,
  `adresse1` varchar(50) NOT NULL,
  `adresse2` varchar(50) NOT NULL,
  `adresse3` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `club`
--

CREATE TABLE `club` (
  `idclub` int(11) NOT NULL,
  `nomclub` varchar(50) NOT NULL,
  `adresseclub` varchar(50) NOT NULL,
  `cpClub` int(11) NOT NULL,
  `villeClub` varchar(50) NOT NULL,
  `idligue` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `lignefrais`
--

CREATE TABLE `lignefrais` (
  `idlgine` int(11) NOT NULL,
  `datedeplacement` date NOT NULL,
  `libDeplacement` varchar(50) NOT NULL,
  `motifDeplacemt` varchar(50) NOT NULL,
  `kilometrage` int(11) NOT NULL,
  `fraisPeage` decimal(10,0) NOT NULL,
  `fraisRepas` decimal(50,0) NOT NULL,
  `fraisHeberge` decimal(10,0) NOT NULL,
  `montantTot` decimal(10,0) NOT NULL,
  `id_note` int(11) NOT NULL,
  `id_motif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ligues`
--

CREATE TABLE `ligues` (
  `idligue` int(11) NOT NULL,
  `nomligue` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `motif`
--

CREATE TABLE `motif` (
  `id_motif` int(11) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `notefrais`
--

CREATE TABLE `notefrais` (
  `id_note` int(11) NOT NULL,
  `validite` tinyint(1) NOT NULL,
  `montantTot` decimal(10,0) NOT NULL,
  `dateNote` date NOT NULL,
  `numOrdre` int(11) NOT NULL,
  `idadherent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `periodef`
--

CREATE TABLE `periodef` (
  `idperiode` int(11) NOT NULL,
  `libelleperiode` int(11) NOT NULL,
  `montant` decimal(10,0) NOT NULL,
  `id_note` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idadherent` int(11) NOT NULL,
  `idutil` int(11) NOT NULL,
  `pseudoutil` varchar(50) NOT NULL,
  `mdputil` varchar(50) NOT NULL,
  `nomutil` varchar(50) NOT NULL,
  `prenomutil` varchar(50) NOT NULL,
  `mailutil` varchar(50) NOT NULL,
  `typeutil` varchar(50) NOT NULL,
  `numLicence` int(11) NOT NULL,
  `adresse1` varchar(50) NOT NULL,
  `adresse2` varchar(50) NOT NULL,
  `adresse3` varchar(50) NOT NULL,
  `clubad` varchar(50) NOT NULL,
  `numlicencead` float NOT NULL,
  `adresse1_adherent` varchar(50) NOT NULL,
  `adresse2_adherent` varchar(50) NOT NULL,
  `adresse3_adherent` varchar(50) NOT NULL,
  `idligue` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adherent`
--
ALTER TABLE `adherent`
  ADD PRIMARY KEY (`idadherent`);

--
-- Index pour la table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`idclub`),
  ADD KEY `club_Ligues_FK` (`idligue`);

--
-- Index pour la table `lignefrais`
--
ALTER TABLE `lignefrais`
  ADD PRIMARY KEY (`idlgine`),
  ADD KEY `ligneFrais_NoteFrais_FK` (`id_note`),
  ADD KEY `ligneFrais_Motif0_FK` (`id_motif`);

--
-- Index pour la table `ligues`
--
ALTER TABLE `ligues`
  ADD PRIMARY KEY (`idligue`);

--
-- Index pour la table `motif`
--
ALTER TABLE `motif`
  ADD PRIMARY KEY (`id_motif`);

--
-- Index pour la table `notefrais`
--
ALTER TABLE `notefrais`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `NoteFrais_adherent_FK` (`idadherent`);

--
-- Index pour la table `periodef`
--
ALTER TABLE `periodef`
  ADD PRIMARY KEY (`idperiode`),
  ADD KEY `PeriodeF_NoteFrais_FK` (`id_note`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idadherent`,`idutil`),
  ADD KEY `utilisateur_Ligues0_FK` (`idligue`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adherent`
--
ALTER TABLE `adherent`
  MODIFY `idadherent` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `club`
--
ALTER TABLE `club`
  MODIFY `idclub` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lignefrais`
--
ALTER TABLE `lignefrais`
  MODIFY `idlgine` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligues`
--
ALTER TABLE `ligues`
  MODIFY `idligue` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `motif`
--
ALTER TABLE `motif`
  MODIFY `id_motif` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notefrais`
--
ALTER TABLE `notefrais`
  MODIFY `id_note` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `periodef`
--
ALTER TABLE `periodef`
  MODIFY `idperiode` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `club`
--
ALTER TABLE `club`
  ADD CONSTRAINT `club_Ligues_FK` FOREIGN KEY (`idligue`) REFERENCES `ligues` (`idligue`);

--
-- Contraintes pour la table `lignefrais`
--
ALTER TABLE `lignefrais`
  ADD CONSTRAINT `ligneFrais_Motif0_FK` FOREIGN KEY (`id_motif`) REFERENCES `motif` (`id_motif`),
  ADD CONSTRAINT `ligneFrais_NoteFrais_FK` FOREIGN KEY (`id_note`) REFERENCES `notefrais` (`id_note`);

--
-- Contraintes pour la table `notefrais`
--
ALTER TABLE `notefrais`
  ADD CONSTRAINT `NoteFrais_adherent_FK` FOREIGN KEY (`idadherent`) REFERENCES `adherent` (`idadherent`);

--
-- Contraintes pour la table `periodef`
--
ALTER TABLE `periodef`
  ADD CONSTRAINT `PeriodeF_NoteFrais_FK` FOREIGN KEY (`id_note`) REFERENCES `notefrais` (`id_note`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_Ligues0_FK` FOREIGN KEY (`idligue`) REFERENCES `ligues` (`idligue`),
  ADD CONSTRAINT `utilisateur_adherent_FK` FOREIGN KEY (`idadherent`) REFERENCES `adherent` (`idadherent`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
