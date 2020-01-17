-- MySQL Script generated by MySQL Workbench
-- Thu Jan  9 19:14:26 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema unilibre_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema unilibre_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `unilibre_db` DEFAULT CHARACTER SET utf8 ;
USE `unilibre_db` ;

-- -----------------------------------------------------
-- Table `unilibre_db`.`departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unilibre_db`.`departamento` (
  `id_departamento` INT NOT NULL AUTO_INCREMENT,
  `nombre_departamento` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_departamento`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unilibre_db`.`ciudad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unilibre_db`.`ciudad` (
  `id_ciudad` INT NOT NULL AUTO_INCREMENT,
  `nombre_ciudad` VARCHAR(45) NOT NULL,
  `id_departamento_ciudad` INT NOT NULL,
  PRIMARY KEY (`id_ciudad`),
  INDEX `idDepartamentoCiudad_idx` (`id_departamento_ciudad` ASC) ,
  CONSTRAINT `idDepartamentoCiudad`
    FOREIGN KEY (`id_departamento_ciudad`)
    REFERENCES `unilibre_db`.`departamento` (`id_departamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unilibre_db`.`funcionalidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unilibre_db`.`funcionalidad` (
  `id_funcionalidad` INT NOT NULL AUTO_INCREMENT,
  `nombre_funcionalidad` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_funcionalidad`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unilibre_db`.`facultad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unilibre_db`.`facultad` (
  `id_facultad` INT NOT NULL AUTO_INCREMENT,
  `nombre_facultad` VARCHAR(150) NOT NULL,
  `siglas_facultad` VARCHAR(15) NOT NULL,
  `fecha_registro_facultad` DATE NOT NULL,
  `id_ciudad_facultad` INT NOT NULL,
  `id_funcionalidad_facultad` INT NOT NULL,
  PRIMARY KEY (`id_facultad`),
  INDEX `idCiudadFacultad_idx` (`id_ciudad_facultad` ASC) ,
  INDEX `idFuncionalidadFacultad_idx` (`id_funcionalidad_facultad` ASC) ,
  CONSTRAINT `idCiudadFacultad`
    FOREIGN KEY (`id_ciudad_facultad`)
    REFERENCES `unilibre_db`.`ciudad` (`id_ciudad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idFuncionalidadFacultad`
    FOREIGN KEY (`id_funcionalidad_facultad`)
    REFERENCES `unilibre_db`.`funcionalidad` (`id_funcionalidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unilibre_db`.`tipo_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unilibre_db`.`tipo_usuario` (
  `id_tipo_usuario` INT NOT NULL AUTO_INCREMENT,
  `nombre_tipo_usuario` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unilibre_db`.`estado_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unilibre_db`.`estado_usuario` (
  `id_estado_usuario` INT NOT NULL AUTO_INCREMENT,
  `nombre_estado_usuario` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_estado_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unilibre_db`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unilibre_db`.`usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `nombre_usuario` VARCHAR(45) NOT NULL,
  `apellido_usuario` VARCHAR(45) NOT NULL,
  `correo_usuario` VARCHAR(70) NOT NULL,
  `contrasena_hash_usuario` VARCHAR(256) NOT NULL,
  `salt_usuario` VARCHAR(256) NOT NULL,
  `fecha_registro_usuario` DATE NOT NULL,
  `id_facultad_usuario` INT NOT NULL,
  `id_tipo_usuario` INT NOT NULL,
  `id_estado_usuario` INT NOT NULL,
  `id_funcionalidad_usuario` INT NOT NULL,
  PRIMARY KEY (`id_usuario`),
  INDEX `idFacultadUsuario_idx` (`id_facultad_usuario` ASC) ,
  INDEX `idTipoUsuario_idx` (`id_tipo_usuario` ASC) ,
  INDEX `idEstadoUsuario_idx` (`id_estado_usuario` ASC) ,
  INDEX `idFuncionalidadUsuario_idx` (`id_funcionalidad_usuario` ASC) ,
  CONSTRAINT `idFacultadUsuario`
    FOREIGN KEY (`id_facultad_usuario`)
    REFERENCES `unilibre_db`.`facultad` (`id_facultad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idTipoUsuario`
    FOREIGN KEY (`id_tipo_usuario`)
    REFERENCES `unilibre_db`.`tipo_usuario` (`id_tipo_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idEstadoUsuario`
    FOREIGN KEY (`id_estado_usuario`)
    REFERENCES `unilibre_db`.`estado_usuario` (`id_estado_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idFuncionalidadUsuario`
    FOREIGN KEY (`id_funcionalidad_usuario`)
    REFERENCES `unilibre_db`.`funcionalidad` (`id_funcionalidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unilibre_db`.`tipo_integrante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unilibre_db`.`tipo_integrante` (
  `id_tipo_integrante` INT NOT NULL AUTO_INCREMENT,
  `nombre_tipo_integrante` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_tipo_integrante`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unilibre_db`.`integrante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unilibre_db`.`integrante` (
  `id_integrante` INT NOT NULL AUTO_INCREMENT,
  `nombre_integrante` VARCHAR(45) NOT NULL,
  `apellido_integrante` VARCHAR(45) NOT NULL,
  `correo_integrante` VARCHAR(70) NULL,
  `cedula_integrante` VARCHAR(12) NULL,
  `fecha_registro_integrante` DATE NOT NULL,
  `id_tipo_integrante` INT NOT NULL,
  `id_facultad_integrante` INT NOT NULL,
  `id_funcionalidad_integrante` INT NOT NULL,
  PRIMARY KEY (`id_integrante`),
  INDEX `idTipoIntegrante_idx` (`id_tipo_integrante` ASC) ,
  INDEX `idFacultadIntegrante_idx` (`id_facultad_integrante` ASC) ,
  INDEX `idFuncionalidadIntegrante_idx` (`id_funcionalidad_integrante` ASC) ,
  CONSTRAINT `idTipoIntegrante`
    FOREIGN KEY (`id_tipo_integrante`)
    REFERENCES `unilibre_db`.`tipo_integrante` (`id_tipo_integrante`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idFacultadIntegrante`
    FOREIGN KEY (`id_facultad_integrante`)
    REFERENCES `unilibre_db`.`facultad` (`id_facultad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idFuncionalidadIntegrante`
    FOREIGN KEY (`id_funcionalidad_integrante`)
    REFERENCES `unilibre_db`.`funcionalidad` (`id_funcionalidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unilibre_db`.`programa_facultad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unilibre_db`.`programa_facultad` (
  `id_programa_facultad` INT NOT NULL AUTO_INCREMENT,
  `nombre_programa_facultad` VARCHAR(45) NOT NULL,
  `fecha_registro_programa_facultad` DATE NOT NULL,
  `id_facultad_programa_facultad` INT NOT NULL,
  PRIMARY KEY (`id_programa_facultad`),
  INDEX `idFacultadProgramaFacultad_idx` (`id_facultad_programa_facultad` ASC) ,
  CONSTRAINT `idFacultadProgramaFacultad`
    FOREIGN KEY (`id_facultad_programa_facultad`)
    REFERENCES `unilibre_db`.`facultad` (`id_facultad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;