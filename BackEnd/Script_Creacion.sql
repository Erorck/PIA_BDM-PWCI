CREATE DATABASE IF NOT EXISTS GOOD_OLD_TIMES_DB;

USE GOOD_OLD_TIMES_DB;

CALL PROC_DROP_FOREIGN_KEY('etiqueta', 'FK_Tag_Usuario');
CALL PROC_DROP_FOREIGN_KEY('nota', 'FK_Nota_Usuario');
CALL PROC_DROP_FOREIGN_KEY('nota_tag', 'FK_NT_Nota');
CALL PROC_DROP_FOREIGN_KEY('nota_tag', 'FK_NT_Etiqueta');
  
DROP TABLE IF EXISTS USERS;
CREATE TABLE `GOOD_OLD_TIMES_DB`.`USERS` (
  `ID_USER` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla usuario',
  `CREDENTIAL` VARCHAR(45) NOT NULL COMMENT 'Contraseña del usuario',
  `NAME` VARCHAR(100) NOT NULL COMMENT 'Nombres del usuario',
  `USER_ALIAS` VARCHAR(100) NOT NULL COMMENT 'Apodo del usuario',
  `FIRST_LAST_NAME` CHAR(45) NOT NULL COMMENT 'Apellido paterno del usuario',
  `SECOND_LAST_NAME` CHAR(45) NOT NULL COMMENT 'Apellido materno del usuario',
  `EMAIL` VARCHAR(100) NOT NULL COMMENT 'Nombres del usuario',
  `PHONE_NUMBER` VARCHAR(12) COMMENT 'Numero telefonico de contacto',
  `BIRTHDAY` DATE NULL COMMENT 'Fecha de nacimiento del usuario',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion de la entrada',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo la entrada',
  `LAST_UPDATE_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de modificación de la entrada',
  `LAST_UPDATED_BY` INT NOT NULL COMMENT 'Usuario que modifico la entrada',
  `PROFILE_PICTURE` MEDIUMBLOB NULL COMMENT 'Imagen de perfil',
  `USER_TYPE` CHAR(2) NOT NULL COMMENT 'Tipo de usuario [AD - Administrador RE - Reportero  UR - Usuario registrado]',
  `USER_STATUS` CHAR(1) NOT NULL DEFAULT 'A' COMMENT 'Estado actual del usuario [A - Activo  I - Inactivo  B - Bloqueado]',
  PRIMARY KEY (`ID_USER`));
  
  DROP TABLE IF EXISTS SECTIONS;
  CREATE TABLE `GOOD_OLD_TIMES_DB`.`SECTIONS` (
  `SECTION_NAME` VARCHAR(40) NOT NULL COMMENT 'Llave primaria de la tabla, nombre de la sección',
  `COLOR` CHAR(7) NOT NULL COMMENT 'Color en hexadecimal con el que se resalta la sección',
  `ORDER` TINYINT UNIQUE NOT NULL COMMENT 'Orden en el que se encontrara la sección en relacion a las otras',
  `LAST_UPDATE_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de modificación de la entrada',
  `LAST_UPDATED_BY` INT NOT NULL COMMENT 'Usuario que modifico la entrada',
  `SECTION_STATUS` CHAR(1) NOT NULL DEFAULT 'A' COMMENT 'Estado actual de la seccion [A - Activa  I - Inactiva]',
  PRIMARY KEY (`SECTION_NAME`));
  
  
  DROP TABLE IF EXISTS NEWS_REPORTS;
  CREATE TABLE `GOOD_OLD_TIMES_DB`.`NEWS_REPORTS` (
  `ID_NEWS` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla de noticias',
  `LOCATION_STREET` VARCHAR(100) COMMENT 'Calle en la que ocurrio la nota',
  `LOCATION_NEIGHB` VARCHAR(70) COMMENT 'Colonia en la que ocurrio la nota',
  `LOCATION_CITY` VARCHAR(80) COMMENT 'Ciudad en la que ocurrio la nota',
  `LOCATION_COUNTRY` VARCHAR(50) COMMENT 'Pais en la que ocurrio la nota',
  `EVENT_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que ocurrio el suceso',
  `PUBLICATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que publico la nota en el portal',
  
  `LAST_UPDATE_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de modificación de la entrada',
  `LAST_UPDATED_BY` INT NOT NULL COMMENT 'Usuario que modifico la entrada',
  `estatus` CHAR(2) NOT NULL DEFAULT 'SU',
  `usuario` INT NOT NULL,
  PRIMARY KEY (`nombre`, `usuario`));
  
  
  DROP TABLE IF EXISTS nota_Tag;
  CREATE TABLE `ScdChnc`.`nota_Tag` (
  `id_Nota_Tag` INT NOT NULL AUTO_INCREMENT,
  `etiqueta` INT NOT NULL,
  `nota` INT NOT NULL,
  PRIMARY KEY (`id_Nota_Tag`));
  
  
  /*----------------------------------
  --------LLAVES FORANEAS-------------
  ------------------------------------*/
  
ALTER TABLE `scdchnc`.`etiqueta` 
ADD CONSTRAINT `FK_Tag_Usuario`
  FOREIGN KEY (`usuario`)
  REFERENCES `scdchnc`.`usuario` (`id_Usuario`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `scdchnc`.`nota` 
ADD CONSTRAINT `FK_Nota_Usuario`
  FOREIGN KEY (`usuario`)
  REFERENCES `scdchnc`.`usuario` (`id_Usuario`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  ALTER TABLE `scdchnc`.`nota_tag` 
ADD CONSTRAINT `FK_NT_Etiqueta`
  FOREIGN KEY (`etiqueta`)
  REFERENCES `scdchnc`.`etiqueta` (`id_Etiqueta`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
   ALTER TABLE `scdchnc`.`nota_tag` 
ADD CONSTRAINT `FK_NT_Nota`
  FOREIGN KEY (`nota`)
  REFERENCES `scdchnc`.`nota` (`id_Nota`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  
  
