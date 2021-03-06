-- MySQL Script generated by MySQL Workbench
-- Tue Oct 31 00:18:37 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema conushop
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `conushop` ;

-- -----------------------------------------------------
-- Schema conushop
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `conushop` DEFAULT CHARACTER SET utf8 ;
USE `conushop` ;
GRANT ALL ON conushop.* TO conushop@localhost IDENTIFIED BY 'isY2metT';

-- -----------------------------------------------------
-- Table `conushop`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `conushop`.`User` ;

CREATE TABLE IF NOT EXISTS `conushop`.`User` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(45) NULL,
  `lastName` VARCHAR(45) NULL,
  `email` VARCHAR(255) NULL,
  `phone` VARCHAR(25) NULL,
  `admin` TINYINT NULL,
  `physicalAddress` VARCHAR(255) NULL,
  `password` VARCHAR(255) NULL,
  `remember_token` VARCHAR(100) NULL,
  `last_forklift_or_change_check` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `conushop`.`Transaction`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `conushop`.`Transaction` ;

CREATE TABLE IF NOT EXISTS `conushop`.`Transaction` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ElectronicSpec_id` INT NULL,
  `item_id` INT NULL,
  `serialNumber` VARCHAR(45) NULL,
  `timestamp` VARCHAR(45) NULL, 
  `customer_id` INT NULL,
  `last_forklift_or_change_check` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_Electronic_Spec2_idx` (`ElectronicSpec_id` ASC),
  INDEX `fk_ElectronicItem_User2_idx` (`customer_id` ASC),
  CONSTRAINT `fk_Electronic_Spec2`
    FOREIGN KEY (`ElectronicSpec_id`)
    REFERENCES `conushop`.`ElectronicSpecification` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ElectronicItem_User2`
    FOREIGN KEY (`customer_id`)
    REFERENCES `conushop`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)

ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `conushop`.`ElectronicType`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `conushop`.`ElectronicType` ;

CREATE TABLE IF NOT EXISTS `conushop`.`ElectronicType` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `dimensionUnit` VARCHAR(45) NULL,
  `screenSizeUnit` VARCHAR(45) NULL,
  `last_forklift_or_change_check` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `conushop`.`ElectronicSpecification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `conushop`.`ElectronicSpecification` ;

CREATE TABLE IF NOT EXISTS `conushop`.`ElectronicSpecification` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dimension` VARCHAR(45) NULL,
  `weight` FLOAT NULL,
  `modelNumber` VARCHAR(45) NULL,
  `brandName` VARCHAR(45) NULL,
  `hdSize` VARCHAR(25) NULL,
  `price` VARCHAR(45) NULL,
  `processorType` VARCHAR(45) NULL,
  `ramSize` VARCHAR(45) NULL,
  `cpuCores` INT NULL,
  `batteryInfo` VARCHAR(45) NULL,
  `os` VARCHAR(45) NULL,
  `camera` TINYINT NULL,
  `touchScreen` TINYINT NULL,
  `ElectronicType_id` INT NULL,
  `displaySize` DOUBLE(5,1) NULL,
  `image` VARCHAR(45) NULL,
  `last_forklift_or_change_check` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_Electronic_ElectronicType_idx` (`ElectronicType_id` ASC),
  CONSTRAINT `fk_Electronic_ElectronicType`
    FOREIGN KEY (`ElectronicType_id`)
    REFERENCES `conushop`.`ElectronicType` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `conushop`.`ElectronicItem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `conushop`.`ElectronicItem` ;

CREATE TABLE IF NOT EXISTS `conushop`.`ElectronicItem` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ElectronicSpecification_id` INT NULL,
  `serialNumber` VARCHAR(45) NULL,
  `User_id` INT NULL,
  `expiryForUser` DATETIME NULL,
  `last_forklift_or_change_check` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_Item_Electronic1_idx` (`ElectronicSpecification_id` ASC),
  INDEX `fk_ElectronicItem_User1_idx` (`User_id` ASC),
  CONSTRAINT `fk_Item_Electronic1`
    FOREIGN KEY (`ElectronicSpecification_id`)
    REFERENCES `conushop`.`ElectronicSpecification` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ElectronicItem_User1`
    FOREIGN KEY (`User_id`)
    REFERENCES `conushop`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `conushop`.`LoginLog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `conushop`.`LoginLog` ;

CREATE TABLE IF NOT EXISTS `conushop`.`LoginLog` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `timestamp` DATETIME NULL,
  `User_id` INT NOT NULL,
  `last_forklift_or_change_check` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_LoginLog_User1_idx` (`User_id` ASC),
  CONSTRAINT `fk_LoginLog_User1`
    FOREIGN KEY (`User_id`)
    REFERENCES `conushop`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- INSERT
-- -----------------------------------------------------
REPLACE INTO ElectronicType (id, name) values (1, "Desktop");
REPLACE INTO ElectronicType (id, name) values (2, "Laptop");
REPLACE INTO ElectronicType (id, name) values (3, "Monitor");
REPLACE INTO ElectronicType (id, name) values (4, "Tablet");
/**REPLACE INTO ElectronicType (id, name) values (5, "Television");**/

REPLACE INTO User (id, email, password, admin) values (1, 'admin1@conushop.com', '$2y$10$CCdVyhydRyjluMY7/39VL.A1atziI7EAdRHhWyFkZyMKOfMlFl3GW', 1);
REPLACE INTO User (id, email, password, admin) values (2, 'admin2@conushop.com', '$2y$10$CCdVyhydRyjluMY7/39VL.A1atziI7EAdRHhWyFkZyMKOfMlFl3GW', 1);
REPLACE INTO User (id, email, password, admin) values (3, 'admin3@conushop.com', '$2y$10$CCdVyhydRyjluMY7/39VL.A1atziI7EAdRHhWyFkZyMKOfMlFl3GW', 1);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
