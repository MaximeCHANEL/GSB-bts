-- Création de la base de données
CREATE DATABASE IF NOT EXISTS `bdd_gsb_` DEFAULT CHARACTER SET utf8mb3;
USE `bdd_gsb_`;

-- Table `datecloture`
CREATE TABLE IF NOT EXISTS `datecloture` (
  `date_cloture_id` int NOT NULL AUTO_INCREMENT,
  `libelle_dates` date DEFAULT NULL,
  PRIMARY KEY (`date_cloture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Table `etatfrais`
CREATE TABLE IF NOT EXISTS `etatfrais` (
  `id_Etat_frais` int NOT NULL AUTO_INCREMENT,
  `Etat` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_Etat_frais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Table `fiche_frais`
CREATE TABLE IF NOT EXISTS `fiche_frais` (
  `id_FicheFrais` int NOT NULL AUTO_INCREMENT,
  `nbJustificatifs` int DEFAULT '0',
  `montantValide` decimal(10,2) DEFAULT NULL,
  `dateModif` datetime DEFAULT CURRENT_TIMESTAMP,
  `idVisiteur` int DEFAULT NULL,
  PRIMARY KEY (`id_FicheFrais`),
  KEY `fk_utilisateur` (`idVisiteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Table `ligne_frais`
CREATE TABLE IF NOT EXISTS `ligne_frais` (
  `IdFrais` int NOT NULL AUTO_INCREMENT,
  `TypeFrais` int NOT NULL,
  `Montant` int NOT NULL,
  `Date` date NOT NULL,
  `Justificatif` varchar(50) DEFAULT NULL,
  `utilisateur_id` int NOT NULL,
  `Etat_Frais_id` int NOT NULL,
  `commentaire` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`IdFrais`),
  KEY `fk_forfait_type_frais` (`TypeFrais`),
  KEY `fk_utilisateur_id` (`utilisateur_id`),
  KEY `fk_etat_frais` (`Etat_Frais_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Table `ligne_frais_forfait`
CREATE TABLE IF NOT EXISTS `ligne_frais_forfait` (
  `id_LigneFraisForfait` int NOT NULL AUTO_INCREMENT,
  `quantite` int DEFAULT NULL,
  `id_FicheFrais` int DEFAULT NULL,
  `id_LigneFrais` int DEFAULT NULL,
  PRIMARY KEY (`id_LigneFraisForfait`),
  KEY `fk_ligne_frais_forfait` (`id_FicheFrais`),
  KEY `ligne_frais_forfait_ibfk_2` (`id_LigneFrais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Table `roles`
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Table `typefrais`
CREATE TABLE IF NOT EXISTS `typefrais` (
  `Libelle_id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Libelle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Table `utilisateurs`
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `IdVisiteur` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  `Matricule` varchar(10) DEFAULT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Ville` varchar(30) NOT NULL,
  `Mail` varchar(100) NOT NULL,
  `Mot_de_passe` varchar(255) NOT NULL,
  `role_id` int NOT NULL,
  PRIMARY KEY (`IdVisiteur`),
  KEY `fk_role_utilisateurs` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Contraintes
ALTER TABLE `fiche_frais`
  ADD CONSTRAINT `fk_utilisateur` FOREIGN KEY (`idVisiteur`) REFERENCES `utilisateurs` (`IdVisiteur`);

ALTER TABLE `ligne_frais`
  ADD CONSTRAINT `fk_etat_frais` FOREIGN KEY (`Etat_Frais_id`) REFERENCES `etatfrais` (`id_Etat_frais`),
  ADD CONSTRAINT `fk_forfait_type_frais` FOREIGN KEY (`TypeFrais`) REFERENCES `typefrais` (`Libelle_id`),
  ADD CONSTRAINT `fk_utilisateur_id` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`IdVisiteur`);

ALTER TABLE `ligne_frais_forfait`
  ADD CONSTRAINT `fk_ligne_frais_forfait` FOREIGN KEY (`id_FicheFrais`) REFERENCES `ligne_frais` (`IdFrais`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ligne_frais_forfait_ibfk_1` FOREIGN KEY (`id_FicheFrais`) REFERENCES `fiche_frais` (`idVisiteur`),
  ADD CONSTRAINT `ligne_frais_forfait_ibfk_2` FOREIGN KEY (`id_LigneFrais`) REFERENCES `ligne_frais` (`IdFrais`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `fk_role_utilisateurs` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
