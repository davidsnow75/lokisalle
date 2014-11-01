SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `lokisalle` ;
CREATE SCHEMA IF NOT EXISTS `lokisalle` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `lokisalle` ;

-- -----------------------------------------------------
-- Table `lokisalle`.`salles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lokisalle`.`salles` ;

CREATE TABLE IF NOT EXISTS `lokisalle`.`salles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pays` VARCHAR(20) NULL,
  `ville` VARCHAR(20) NULL,
  `adresse` VARCHAR(20) NULL,
  `cp` VARCHAR(5) NULL,
  `titre` VARCHAR(200) NULL,
  `description` TEXT NULL,
  `photo` VARCHAR(200) NULL,
  `capacite` INT(3) NULL,
  `categorie` VARCHAR(20) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lokisalle`.`promotions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lokisalle`.`promotions` ;

CREATE TABLE IF NOT EXISTS `lokisalle`.`promotions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_promo` VARCHAR(6) NULL,
  `reduction` INT(5) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lokisalle`.`produits`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lokisalle`.`produits` ;

CREATE TABLE IF NOT EXISTS `lokisalle`.`produits` (
  `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_arrivee` BIGINT NULL,
  `date_depart` BIGINT NULL,
  `prix` INT(5) NULL,
  `etat` INT(1) NULL,
  `salles_id` INT UNSIGNED NULL,
  `promotions_id` INT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_produits_salles1_idx` (`salles_id` ASC),
  INDEX `fk_produits_promotions1_idx` (`promotions_id` ASC),
  CONSTRAINT `fk_produits_salles1`
    FOREIGN KEY (`salles_id`)
    REFERENCES `lokisalle`.`salles` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_produits_promotions1`
    FOREIGN KEY (`promotions_id`)
    REFERENCES `lokisalle`.`promotions` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lokisalle`.`membres`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lokisalle`.`membres` ;

CREATE TABLE IF NOT EXISTS `lokisalle`.`membres` (
  `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pseudo` VARCHAR(15) NULL,
  `mdp` VARCHAR(255) NULL,
  `nom` VARCHAR(20) NULL,
  `email` VARCHAR(30) NULL,
  `sexe` ENUM('m','f') NULL,
  `ville` VARCHAR(20) NULL,
  `cp` VARCHAR(5) NULL,
  `adresse` VARCHAR(30) NULL,
  `statut` INT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lokisalle`.`avis`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lokisalle`.`avis` ;

CREATE TABLE IF NOT EXISTS `lokisalle`.`avis` (
  `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `commentaire` TEXT NULL,
  `note` INT(2) NULL,
  `date` BIGINT NULL,
  `salles_id` INT UNSIGNED NOT NULL,
  `membres_id` INT(5) UNSIGNED NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_avis_salles1_idx` (`salles_id` ASC),
  INDEX `fk_avis_membres1_idx` (`membres_id` ASC),
  CONSTRAINT `fk_avis_salles1`
    FOREIGN KEY (`salles_id`)
    REFERENCES `lokisalle`.`salles` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_avis_membres1`
    FOREIGN KEY (`membres_id`)
    REFERENCES `lokisalle`.`membres` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lokisalle`.`commandes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lokisalle`.`commandes` ;

CREATE TABLE IF NOT EXISTS `lokisalle`.`commandes` (
  `id` INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `montant` INT NULL,
  `date` BIGINT NULL,
  `membres_id` INT(5) UNSIGNED NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_commandes_membres1_idx` (`membres_id` ASC),
  CONSTRAINT `fk_commandes_membres1`
    FOREIGN KEY (`membres_id`)
    REFERENCES `lokisalle`.`membres` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lokisalle`.`newsletters`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lokisalle`.`newsletters` ;

CREATE TABLE IF NOT EXISTS `lokisalle`.`newsletters` (
  `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `membres_id` INT(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_newsletters_membres1_idx` (`membres_id` ASC),
  CONSTRAINT `fk_newsletters_membres1`
    FOREIGN KEY (`membres_id`)
    REFERENCES `lokisalle`.`membres` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lokisalle`.`details_commandes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lokisalle`.`details_commandes` ;

CREATE TABLE IF NOT EXISTS `lokisalle`.`details_commandes` (
  `id` INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `commandes_id` INT(6) UNSIGNED NOT NULL,
  `produits_id` INT(5) UNSIGNED NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_details_commandes_commandes1_idx` (`commandes_id` ASC),
  INDEX `fk_details_commandes_produits1_idx` (`produits_id` ASC),
  CONSTRAINT `fk_details_commandes_commandes1`
    FOREIGN KEY (`commandes_id`)
    REFERENCES `lokisalle`.`commandes` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_details_commandes_produits1`
    FOREIGN KEY (`produits_id`)
    REFERENCES `lokisalle`.`produits` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lokisalle`.`pseudomails`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lokisalle`.`pseudomails` ;

CREATE TABLE IF NOT EXISTS `lokisalle`.`pseudomails` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `expediteur` VARCHAR(255) NULL,
  `sujet` VARCHAR(255) NULL,
  `message` TEXT NULL,
  `date` BIGINT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
