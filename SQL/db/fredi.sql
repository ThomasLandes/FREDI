CREATE DATABASE FREDI DEFAULT CHARSET=utf8 COLLATE utf8_general_ci ;

USE FREDI ;

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

-------------------------------------------------------------
--       Script MySQL.
-------------------------------------------------------------
-
-
-------------------------------------------------------------
-- Table: Ligues 
-------------------------------------------------------------

CREATE TABLE Ligues(
        idligue  Int  Auto_increment  NOT NULL ,
        nomligue Varchar (50) NOT NULL
	,CONSTRAINT Ligues_PK PRIMARY KEY (idligue)
)ENGINE=InnoDB;


-------------------------------------------------------------
-- Table: club
-------------------------------------------------------------

CREATE TABLE club(
        idclub      Int  Auto_increment  NOT NULL ,
        nomclub     Varchar (50) NOT NULL ,
        adresseclub Varchar (50) NOT NULL ,
        cpClub      Int NOT NULL ,
        villeClub   Varchar (50) NOT NULL ,
        idligue     Int NOT NULL
	,CONSTRAINT club_PK PRIMARY KEY (idclub)

	,CONSTRAINT club_Ligues_FK FOREIGN KEY (idligue) REFERENCES Ligues(idligue)
)ENGINE=InnoDB;


-------------------------------------------------------------
-- Table: utilisateur
-------------------------------------------------------------

CREATE TABLE utilisateur(
        idutil     Int  Auto_increment  NOT NULL ,
        pseudoutil Varchar (50) NOT NULL ,
        mdputil    Varchar (50) NOT NULL ,
        nomutil    Varchar (50) NOT NULL ,
        prenomutil Varchar (50) NOT NULL ,
        mailutil   Varchar (50) NOT NULL ,
        typeutil   Varchar (50) NOT NULL ,
        idligue    Int NOT NULL
	,CONSTRAINT utilisateur_PK PRIMARY KEY (idutil)

	,CONSTRAINT utilisateur_Ligues_FK FOREIGN KEY (idligue) REFERENCES Ligues(idligue)
)ENGINE=InnoDB;


-------------------------------------------------------------
-- Table: adherent
-------------------------------------------------------------

CREATE TABLE adherent(
        idadherent   Int  Auto_increment  NOT NULL ,
        clubad       Varchar (50) NOT NULL ,
        numlicencead Float NOT NULL ,
        adresse1     Varchar (50) NOT NULL ,
        adresse2     Varchar (50) NOT NULL ,
        adresse3     Varchar (50) NOT NULL ,
        idclub       Int NOT NULL ,
        idutil       Int NOT NULL
	,CONSTRAINT adherent_PK PRIMARY KEY (idadherent)

	,CONSTRAINT adherent_club_FK FOREIGN KEY (idclub) REFERENCES club(idclub)
	,CONSTRAINT adherent_utilisateur0_FK FOREIGN KEY (idutil) REFERENCES utilisateur(idutil)
)ENGINE=InnoDB;


-------------------------------------------------------------
-- Table: NoteFrais
-------------------------------------------------------------

CREATE TABLE NoteFrais(
        id_note    Int  Auto_increment  NOT NULL ,
        validite   Bool NOT NULL ,
        montantTot Float NOT NULL ,
        dateNote   Date NOT NULL ,
        numOrdre   Int NOT NULL ,
        idutil     Int NOT NULL
	,CONSTRAINT NoteFrais_PK PRIMARY KEY (id_note)

	,CONSTRAINT NoteFrais_utilisateur_FK FOREIGN KEY (idutil) REFERENCES utilisateur(idutil)
)ENGINE=InnoDB;


------------------------------------------------------------
-- Table: PeriodeF
------------------------------------------------------------

CREATE TABLE PeriodeF(
        idperiode      Int  Auto_increment  NOT NULL ,
        libelleperiode Int NOT NULL ,
        montant        Float NOT NULL ,
        id_note        Int NOT NULL
	,CONSTRAINT PeriodeF_PK PRIMARY KEY (idperiode)

	,CONSTRAINT PeriodeF_NoteFrais_FK FOREIGN KEY (id_note) REFERENCES NoteFrais(id_note)
)ENGINE=InnoDB;


-------------------------------------------------------------
-- Table: Motif
-------------------------------------------------------------

CREATE TABLE Motif(
        id_motif Int  Auto_increment  NOT NULL ,
        libmotif Varchar (50) NOT NULL
	,CONSTRAINT Motif_PK PRIMARY KEY (id_motif)
)ENGINE=InnoDB;


-------------------------------------------------------------
-- Table: ligneFrais
-------------------------------------------------------------

CREATE TABLE ligneFrais(
        idligne         Int  Auto_increment  NOT NULL ,
        datedeplacement Date NOT NULL ,
        libDeplacement  Varchar (50) NOT NULL ,
        kilometrage     Int NOT NULL ,
        fraisPeage      Float NOT NULL ,
        fraisRepas      Float NOT NULL ,
        fraisHeberge    Float NOT NULL ,
        montantTot      Float NOT NULL ,
        id_note         Int NOT NULL ,
        id_motif        Int NOT NULL
	,CONSTRAINT ligneFrais_PK PRIMARY KEY (idligne)

	,CONSTRAINT ligneFrais_NoteFrais_FK FOREIGN KEY (id_note) REFERENCES NoteFrais(id_note)
	,CONSTRAINT ligneFrais_Motif0_FK FOREIGN KEY (id_motif) REFERENCES Motif(id_motif)
)ENGINE=InnoDB;

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
