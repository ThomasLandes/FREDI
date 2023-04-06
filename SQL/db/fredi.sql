-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 17 nov. 2022 à 15:41
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données : `fredi`
--
CREATE DATABASE IF NOT EXISTS `fredi` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `fredi`;

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
  `adresse3` varchar(50) NOT NULL,
  `idclub` int(11) NOT NULL,
  `idutil` int(11) NOT NULL
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
  `idligne` int(11) NOT NULL,
  `datedeplacement` date NOT NULL,
  `libDeplacement` varchar(50) NOT NULL,
  `kilometrage` int(11) NOT NULL,
  `fraisKilometre`  float NOT NULL,
  `fraisPeage` float NOT NULL,
  `fraisRepas` float NOT NULL,
  `fraisHeberge` float NOT NULL,
  `montantTot` float NOT NULL,
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

--
-- Déchargement des données de la table `ligues`
--

INSERT INTO `ligues` (`idligue`, `nomligue`) VALUES
(99, 'defaut');

-- --------------------------------------------------------

--
-- Structure de la table `motif`
--

CREATE TABLE `motif` (
  `id_motif` int(11) NOT NULL,
  `libmotif` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `notefrais`
--

CREATE TABLE `notefrais` (
  `id_note` int(11) NOT NULL,
  `validite` tinyint(1) NOT NULL,
  `montantTot` float NOT NULL,
  `dateNote` date NOT NULL,
  `numOrdre` int(11) NOT NULL,
  `idutil` int(11) NOT NULL,
  `idperiode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Structure de la table `periodef`
--

CREATE TABLE `periodef` (
  `idperiode` int(11) NOT NULL,
  `libelleperiode` int(11) NOT NULL,
  `montant` float NOT NULL,
  `is_actif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idutil` int(11) NOT NULL,
  `pseudoutil` varchar(50) NOT NULL,
  `mdputil` varchar(255) NOT NULL,
  `nomutil` varchar(50) NOT NULL,
  `prenomutil` varchar(50) NOT NULL,
  `mailutil` varchar(50) NOT NULL,
  `typeutil` varchar(50) NOT NULL,
  `idligue` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adherent`
--
ALTER TABLE `adherent`
  ADD PRIMARY KEY (`idadherent`),
  ADD KEY `adherent_club_FK` (`idclub`),
  ADD KEY `adherent_utilisateur0_FK` (`idutil`);

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
  ADD PRIMARY KEY (`idligne`),
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
  ADD KEY `NoteFrais_utilisateur_FK` (`idutil`),
  ADD KEY `NoteFrais_periodef` (`idperiode`);
--
-- Index pour la table `periodef`
--
ALTER TABLE `periodef`
  ADD PRIMARY KEY (`idperiode`);
  
--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idutil`),
  ADD KEY `utilisateur_Ligues_FK` (`idligue`);

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
  MODIFY `idligne` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idutil` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adherent`
--
ALTER TABLE `adherent`
  ADD CONSTRAINT `adherent_club_FK` FOREIGN KEY (`idclub`) REFERENCES `club` (`idclub`),
  ADD CONSTRAINT `adherent_utilisateur0_FK` FOREIGN KEY (`idutil`) REFERENCES `utilisateur` (`idutil`);

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
  ADD CONSTRAINT `NoteFrais_utilisateur_FK` FOREIGN KEY (`idutil`) REFERENCES `utilisateur` (`idutil`),
  ADD CONSTRAINT `NoteFrais_periodef_FK` FOREIGN KEY (`idperiode`) REFERENCES `periodef` (`idperiode`);


--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_Ligues_FK` FOREIGN KEY (`idligue`) REFERENCES `ligues` (`idligue`);
COMMIT;

--
-- Déclencheurs `notefrais`
--
DELIMITER $$
CREATE TRIGGER `before_update_notefrais` BEFORE UPDATE ON `notefrais` FOR EACH ROW BEGIN
if new.validite = 1 then 
SET NEW.dateNote = CURDATE();
end if;
 END
$$
DELIMITER ;


--
-- Déclencheurs `lignefrais`
--
DELIMITER $$
CREATE TRIGGER `before_delete_lignefrais` BEFORE DELETE ON `lignefrais` FOR EACH ROW BEGIN
  UPDATE notefrais
  SET montantTot = (
    SELECT SUM(FraisPeage + FraisRepas + FraisHeberge + FraisKilometre) - old.montantTot
    FROM lignefrais
    WHERE lignefrais.id_note = notefrais.id_note
  )
  WHERE notefrais.id_note = OLD.id_note;
END
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `before_update_lignefrais` BEFORE UPDATE ON `lignefrais` FOR EACH ROW BEGIN
declare v_montant int;
declare v_fraiskilo int ; 
select montant into v_montant from periodef where is_actif = 1;


SET v_fraiskilo = NEW.kilometrage * v_montant;

SET NEW.FraisKilometre = v_fraiskilo;


  SET NEW.MontantTot = NEW.FraisPeage + NEW.FraisRepas + NEW.FraisHeberge + NEW.FraisKilometre;



 UPDATE notefrais SET MontantTot = (
    SELECT SUM(montantTot) - new.MontantTot
    FROM lignefrais
    WHERE id_note = NEW.id_note
) WHERE id_note = NEW.id_note;

END
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `calcul_montant_total` BEFORE INSERT ON `lignefrais` FOR EACH ROW BEGIN

declare v_montantnote int ;
declare v_montant int;
declare v_fraiskilo int ; 
declare v_nbligne int ;

select montant into v_montant from periodef where is_actif = 1;

select count(*) into v_nbligne from lignefrais where id_note = new.id_note;

SET v_fraiskilo = NEW.kilometrage * v_montant;

SET NEW.FraisKilometre = v_fraiskilo;

 SET NEW.MontantTot = NEW.FraisPeage + NEW.FraisRepas + NEW.FraisHeberge + NEW.FraisKilometre;

 select sum(montantTot) into v_montantnote from lignefrais where id_note = new.id_note ;

set v_montantnote = v_montantnote + new.montantTot ;

if v_nbligne = 0 then
 UPDATE notefrais SET MontantTot = New.montantTot
WHERE id_note = NEW.id_note;
ELSE 
UPDATE notefrais SET MontantTot = v_montantnote  
WHERE id_note = NEW.id_note;
end if;

END
$$
DELIMITER ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
