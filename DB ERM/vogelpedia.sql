SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`order` (
  `idorder` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idorder`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`family`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`family` (
  `idfamily` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `order_idorder` INT NOT NULL,
  PRIMARY KEY (`idfamily`),
  INDEX `fk_family_order1_idx` (`order_idorder` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  CONSTRAINT `fk_family_order1`
    FOREIGN KEY (`order_idorder`)
    REFERENCES `mydb`.`order` (`idorder`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`breeding_place`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`breeding_place` (
  `idbreeding_place` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  PRIMARY KEY (`idbreeding_place`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`bird`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`bird` (
  `idbird` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(75) NOT NULL,
  `name_latin` VARCHAR(75) NOT NULL,
  `description` MEDIUMTEXT NULL,
  `min_livestock` INT NULL,
  `max_livestock` INT NULL,
  `min_length` INT NULL,
  `max_length` INT NULL,
  `min_wingspread` INT NULL,
  `max_wingspread` INT NULL,
  `min_weight` INT NULL,
  `max_weight` INT NULL,
  `life_expectancy` INT NULL,
  `breeding_duration` INT NULL,
  `image_path` VARCHAR(100) NULL,
  `red_list` TINYINT(1) NULL,
  `family_idfamily` INT NOT NULL,
  `breeding_place_idbreeding_place` INT NOT NULL,
  PRIMARY KEY (`idbird`),
  INDEX `fk_bird_family_idx` (`family_idfamily` ASC),
  INDEX `fk_bird_breeding_place1_idx` (`breeding_place_idbreeding_place` ASC),
  UNIQUE INDEX `idbird_UNIQUE` (`idbird` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  UNIQUE INDEX `name_latin_UNIQUE` (`name_latin` ASC),
  CONSTRAINT `fk_bird_family`
    FOREIGN KEY (`family_idfamily`)
    REFERENCES `mydb`.`family` (`idfamily`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bird_breeding_place1`
    FOREIGN KEY (`breeding_place_idbreeding_place`)
    REFERENCES `mydb`.`breeding_place` (`idbreeding_place`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`user` (
  `iduser` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `iduser_UNIQUE` (`iduser` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`user_has_bird`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`user_has_bird` (
  `user_iduser` INT NOT NULL,
  `bird_idbird` INT NOT NULL,
  PRIMARY KEY (`user_iduser`, `bird_idbird`),
  INDEX `fk_user_has_bird_bird1_idx` (`bird_idbird` ASC),
  INDEX `fk_user_has_bird_user1_idx` (`user_iduser` ASC),
  CONSTRAINT `fk_user_has_bird_user1`
    FOREIGN KEY (`user_iduser`)
    REFERENCES `mydb`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_bird_bird1`
    FOREIGN KEY (`bird_idbird`)
    REFERENCES `mydb`.`bird` (`idbird`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`color`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`color` (
  `idcolor` INT NOT NULL AUTO_INCREMENT,
  `color_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idcolor`),
  UNIQUE INDEX `color_name_UNIQUE` (`color_name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`bird_has_color`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`bird_has_color` (
  `bird_idbird` INT NOT NULL,
  `color_idcolor` INT NOT NULL,
  PRIMARY KEY (`bird_idbird`, `color_idcolor`),
  INDEX `fk_bird_has_color_color1_idx` (`color_idcolor` ASC),
  INDEX `fk_bird_has_color_bird1_idx` (`bird_idbird` ASC),
  CONSTRAINT `fk_bird_has_color_bird1`
    FOREIGN KEY (`bird_idbird`)
    REFERENCES `mydb`.`bird` (`idbird`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bird_has_color_color1`
    FOREIGN KEY (`color_idcolor`)
    REFERENCES `mydb`.`color` (`idcolor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`food`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`food` (
  `idfood` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idfood`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`bird_has_food`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`bird_has_food` (
  `bird_idbird` INT NOT NULL,
  `food_idfood` INT NOT NULL,
  PRIMARY KEY (`bird_idbird`, `food_idfood`),
  INDEX `fk_bird_has_food_food1_idx` (`food_idfood` ASC),
  INDEX `fk_bird_has_food_bird1_idx` (`bird_idbird` ASC),
  CONSTRAINT `fk_bird_has_food_bird1`
    FOREIGN KEY (`bird_idbird`)
    REFERENCES `mydb`.`bird` (`idbird`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bird_has_food_food1`
    FOREIGN KEY (`food_idfood`)
    REFERENCES `mydb`.`food` (`idfood`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`habitat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`habitat` (
  `idhabitat` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idhabitat`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`bird_has_habitat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`bird_has_habitat` (
  `bird_idbird` INT NOT NULL,
  `habitat_idhabitat` INT NOT NULL,
  PRIMARY KEY (`bird_idbird`, `habitat_idhabitat`),
  INDEX `fk_bird_has_habitat_habitat1_idx` (`habitat_idhabitat` ASC),
  INDEX `fk_bird_has_habitat_bird1_idx` (`bird_idbird` ASC),
  CONSTRAINT `fk_bird_has_habitat_bird1`
    FOREIGN KEY (`bird_idbird`)
    REFERENCES `mydb`.`bird` (`idbird`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bird_has_habitat_habitat1`
    FOREIGN KEY (`habitat_idhabitat`)
    REFERENCES `mydb`.`habitat` (`idhabitat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
