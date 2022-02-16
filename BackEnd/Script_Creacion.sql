CREATE DATABASE IF NOT EXISTS GOOD_OLD_TIMES_DB;

USE GOOD_OLD_TIMES_DB;

CALL PROC_DROP_FOREIGN_KEY('COMMENTS', 'FK_COMMENT_USER');
CALL PROC_DROP_FOREIGN_KEY('NEWS_REPORTS', 'FK_REPORT_USER');
CALL PROC_DROP_FOREIGN_KEY('IMAGES', 'FK_IMAGE_REPORT');
CALL PROC_DROP_FOREIGN_KEY('VIDEOS', 'FK_VIDEO_REPORT');
CALL PROC_DROP_FOREIGN_KEY('COMMENTS', 'FK_COMMENT_REPORT');
CALL PROC_DROP_FOREIGN_KEY('NEWS_CATEGORIES', 'FK_N_CA_REPORT');
CALL PROC_DROP_FOREIGN_KEY('NEWS_CATEGORIES', 'FK_N_CA_CATEGORY');
CALL PROC_DROP_FOREIGN_KEY('NEWS_COMMENTS', 'FK_N_CO_REPORT');
CALL PROC_DROP_FOREIGN_KEY('NEWS_COMMENTS', 'FK_N_CO_COMMENT');
CALL PROC_DROP_FOREIGN_KEY('NEWS_TAGS', 'FK_N_T_REPORT');
CALL PROC_DROP_FOREIGN_KEY('NEWS_TAGS', 'FK_N_T_TAG');
CALL PROC_DROP_FOREIGN_KEY('REACTIONS', 'FK_REACTION_USER');
CALL PROC_DROP_FOREIGN_KEY('REACTIONS', 'FK_REACTION_REPORT');
  
DROP TABLE IF EXISTS USERS;
CREATE TABLE `GOOD_OLD_TIMES_DB`.`USERS` (
  `ID_USER` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla USERS',
  `CREDENTIAL` VARCHAR(45) NOT NULL COMMENT 'Contraseña del usuario',
  `NAME` VARCHAR(100) NOT NULL COMMENT 'Nombres del usuario',
  `USER_ALIAS` VARCHAR(100) NOT NULL COMMENT 'Apodo del usuario',
  `FIRST_LAST_NAME` CHAR(45) NOT NULL COMMENT 'Apellido paterno del usuario',
  `SECOND_LAST_NAME` CHAR(45) NOT NULL COMMENT 'Apellido materno del usuario',
  `EMAIL` VARCHAR(100) NOT NULL COMMENT 'Nombres del usuario',
  `PHONE_NUMBER` VARCHAR(12) COMMENT 'Numero telefonico de contacto',
  `BIRTHDAY` DATE NULL COMMENT 'Fecha de nacimiento del usuario',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del usuario',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo la entrada',
  `LAST_UPDATE_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Última fecha de modificación del usuario',
  `LAST_UPDATED_BY` INT NOT NULL COMMENT 'Último usuario que modifico la entrada',
  `PROFILE_PICTURE` MEDIUMBLOB NULL COMMENT 'Imagen de perfil',
  `USER_TYPE` CHAR(2) NOT NULL COMMENT 'Tipo de usuario [AD - Administrador RE - Reportero  UR - Usuario registrado]',
  `USER_STATUS` CHAR(1) NOT NULL DEFAULT 'A' COMMENT 'Estado actual del usuario [A - Activo  I - Inactivo  B - Bloqueado]',
  PRIMARY KEY (`ID_USER`));
  
  DROP TABLE IF EXISTS CATEGORIES;
  CREATE TABLE `GOOD_OLD_TIMES_DB`.`CATEGORIES` (
  `CATEGORY_NAME` VARCHAR(40) NOT NULL COMMENT 'Llave primaria de la tabla, nombre de la CATEGORIES',
  `COLOR` CHAR(7) NOT NULL COMMENT 'Color en hexadecimal con el que se resalta la sección',
  `ORDER` TINYINT NOT NULL COMMENT 'Orden en el que se encontrara la sección en relacion a las otras',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion de la nota',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo la nota',
  `LAST_UPDATE_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Última fecha de modificación de la sección',
  `LAST_UPDATED_BY` INT NOT NULL COMMENT 'Último usuario que modifico la sección',
  `SECTION_STATUS` CHAR(1) NOT NULL DEFAULT 'A' COMMENT 'Estado actual de la seccion [A - Activa  I - Inactiva]',
  PRIMARY KEY (`CATEGORY_NAME`));
  
  
  DROP TABLE IF EXISTS NEWS_REPORTS;
  CREATE TABLE `GOOD_OLD_TIMES_DB`.`NEWS_REPORTS` (
  `REPORT_ID` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla de NEWS_REPORTS',
  `SIGN` VARCHAR(100) NOT NULL COMMENT 'Firma del reportero',
  `LOCATION_STREET` VARCHAR(100) COMMENT 'Calle en la que ocurrio la nota',
  `LOCATION_NEIGHB` VARCHAR(70) COMMENT 'Colonia en la que ocurrio la nota',
  `LOCATION_CITY` VARCHAR(80) NOT NULL COMMENT 'Ciudad en la que ocurrio la nota',
  `LOCATION_COUNTRY` VARCHAR(50) NOT NULL COMMENT 'Pais en la que ocurrio la nota',
  `EVENT_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que ocurrio el suceso',
  `PUBLICATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que publico la nota en el portal',
  `REPORT_HEADER` VARCHAR(80) NOT NULL COMMENT 'Encabezado de la nota',
  `REPORT_DESCRIPTION` VARCHAR(100) COMMENT 'Descripción breve de la nota',
  `REPORT_CONTENT` VARCHAR(1000) NOT NULL COMMENT 'Contenido de la nota',
  `LIKES` INT NOT NULL DEFAULT 0 COMMENT 'Numero de likes que ha recibido la nota',
  `THUMBNAIL` MEDIUMBLOB NOT NULL COMMENT 'Miniatura con la que la nota se muestra',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion de la nota',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo la nota',
  `LAST_UPDATE_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Última fecha de modificación de la nota',
  `LAST_UPDATED_BY` INT NOT NULL COMMENT 'Ultimo usuario que modifico la nota',
  `REPORT_STATUS` CHAR(2) NOT NULL DEFAULT 'RR' COMMENT 'Estado actual de la noticia [P-Publicada  E-Eliminada  RA-En revision por administrador  RR-En revision por reportero]',
  PRIMARY KEY (`REPORT_ID`));
  
  DROP TABLE IF EXISTS COMMENTS;
  CREATE TABLE `GOOD_OLD_TIMES_DB`.`COMMENTS` (
  `COMMENT_ID` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla de COMMENTS',
  `COMMENT_TEXT` VARCHAR(1000) NOT NULL COMMENT 'Contenido del comentario',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del comentario',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo el comentario',
  `LAST_UPDATE_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Última fecha de modificación del comentario',
  `LAST_UPDATED_BY` INT NOT NULL COMMENT 'Ultimo usuario que modifico el comentario',
  `COMMENT_STATUS` CHAR(2) NOT NULL DEFAULT 'P' COMMENT 'Estado actual del comentario [P-Publico  E-Eliminado]',
  `REPORT_ID` INT NOT NULL COMMENT 'Id de la noticia a la que pertence el comentario',
  PRIMARY KEY (`COMMENT_ID`));
  
  CREATE TABLE IF NOT EXISTS NEWS_COMMENTS(
    `COMMENT_ID` INT NOT NULL AUTO_INCREMENT COMMENT "Llave primaria de la tabla NEWS_COMMENTS",
    `REPORT_ID` INT NOT NULL COMMENT "Llave primaria de la tabla NEWS",
    `PARENT_ID` INT COMMENT "Nos indica si otro ID de la tabla de NEWS_COMMENT se respondio con este mensaje",
    `CREATION_DATE` DATETIME NOT NULL COMMENT "Fecha de creacion del registro",
    `ACTIVE` BOOLEAN DEFAULT TRUE NOT NULL COMMENT "Indica si el registro esta activo en la base de datos",
    PRIMARY KEY (COMMENT_ID,REPORT_ID),
    INDEX (PARENT_ID)
);
  
   DROP TABLE IF EXISTS IMAGES;
  CREATE TABLE `GOOD_OLD_TIMES_DB`.`IMAGES` (
  `ID_IMAGE` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla IMAGES',
  `DESCRIPTION` VARCHAR(200) NOT NULL COMMENT 'Breve descripcion del contenido del archivo',
  `CONTENT` MEDIUMBLOB NOT NULL COMMENT 'Datos de la imagen',
  `ROUTE` VARCHAR(1000) NOT NULL COMMENT 'Ruta del archivo',
  `UPLOAD_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de subida del material',
  `IMAGE_STATUS` CHAR(2) NOT NULL DEFAULT 'P' COMMENT 'Estado actual del material [P-Publico  E-Eliminado]',
  `REPORT_ID` INT NOT NULL COMMENT 'Id de la noticia a la que pertence el material',
  PRIMARY KEY (`ID_IMAGE`));
  
  DROP TABLE IF EXISTS VIDEOS;
  CREATE TABLE `GOOD_OLD_TIMES_DB`.`VIDEOS` (
  `ID_VIDEO` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla VIDEOS',
  `DESCRIPTION` VARCHAR(200) NOT NULL COMMENT 'Breve descripcion del contenido del archivo',
  `CONTENT` MEDIUMBLOB NOT NULL COMMENT 'Datos deL video',
  `ROUTE` VARCHAR(1000) NOT NULL COMMENT 'Ruta del archivo',
  `UPLOAD_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de subida del material',
  `VIDEO_STATUS` CHAR(2) NOT NULL DEFAULT 'P' COMMENT 'Estado actual del material [P-Publico  E-Eliminado]',
  `REPORT_ID` INT NOT NULL COMMENT 'Id de la noticia a la que pertence el material',
  PRIMARY KEY (`ID_VIDEO`));
  
  DROP TABLE IF EXISTS TAGS;
  CREATE TABLE `GOOD_OLD_TIMES_DB`.`TAGS` (
  `TAG_NAME` VARCHAR(50) NOT NULL COMMENT 'Llave primaria de la tabla etiqueta/ Nombre de la TAGS',
  `TAG_STATUS` CHAR(2) NOT NULL DEFAULT 'EU' COMMENT 'Estado actual de la etiqueta [EU-En uso  SU-Sin usar]',
  PRIMARY KEY (`TAG_NAME`));
  
  
  DROP TABLE IF EXISTS NEWS_CATEGORIES;
  CREATE TABLE `GOOD_OLD_TIMES_DB`.`NEWS_CATEGORIES` (
  `REPORT_ID` INT NOT NULL COMMENT 'Identificador de la noticia involucrada en la relación', 
  `CATEGORY` VARCHAR(40) NOT NULL COMMENT 'Identificador de la sección involucrada en la relación',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del registro',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo el registro',
  PRIMARY KEY (`REPORT_ID`, `CATEGORY`));
  
  DROP TABLE IF EXISTS NEWS_TAGS;
  CREATE TABLE `GOOD_OLD_TIMES_DB`.`NEWS_TAGS` (
  `TAG` VARCHAR(50) NOT NULL COMMENT 'Identificador de la etiqueta involucrada en la relación',
  `REPORT_ID` INT NOT NULL COMMENT 'Identificador de la noticia involucrada en la relación',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del registro',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo el registro',
  PRIMARY KEY (`TAG`, `REPORT_ID`));
  
  DROP TABLE IF EXISTS REACTIONS;
  CREATE TABLE `GOOD_OLD_TIMES_DB`.`REACTIONS` (
  `USER` INT NOT NULL COMMENT 'Identificador del usuario involucrado en la relación',
  `REPORT_ID` INT NOT NULL COMMENT 'Identificador de la noticia involucrada en la relación',
  `LIKED` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Bandera que indica la reaccion del usuario a la nota',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del registro',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo el registro',
  PRIMARY KEY (`USER`, `REPORT_ID`));
  
  
  /*----------------------------------
  --------LLAVES FORANEAS-------------
  ------------------------------------*/

  
ALTER TABLE `GOOD_OLD_TIMES_DB`.`COMMENTS` 
ADD CONSTRAINT `FK_COMMENT_USER`
  FOREIGN KEY (`CREATED_BY`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`USERS` (`ID_USER`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `GOOD_OLD_TIMES_DB`.`NEWS_REPORTS` 
ADD CONSTRAINT `FK_REPORT_USER`
  FOREIGN KEY (`CREATED_BY`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`USERS` (`ID_USER`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  ALTER TABLE `GOOD_OLD_TIMES_DB`.`IMAGES` 
ADD CONSTRAINT `FK_IMAGE_REPORT`
  FOREIGN KEY (`REPORT_ID`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`NEWS_REPORTS` (`REPORT_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION; 
  
  ALTER TABLE `GOOD_OLD_TIMES_DB`.`VIDEOS` 
ADD CONSTRAINT `FK_VIDEO_REPORT`
  FOREIGN KEY (`REPORT_ID`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`NEWS_REPORTS` (`REPORT_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
/*  ALTER TABLE `GOOD_OLD_TIMES_DB`.`COMMENTS` 
ADD CONSTRAINT `FK_COMMENT_REPORT`
  FOREIGN KEY (`REPORT`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`NEWS_REPORTS` (`ID_NEWS`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  /*NEWS SECTIONS*/

  ALTER TABLE `GOOD_OLD_TIMES_DB`.`NEWS_CATEGORIES` 
ADD CONSTRAINT `FK_N_CA_REPORT`
  FOREIGN KEY (`REPORT_ID`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`NEWS_REPORTS` (`REPORT_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION; 
  
  ALTER TABLE `GOOD_OLD_TIMES_DB`.`NEWS_CATEGORIES` 
ADD CONSTRAINT `FK_N_CA_CATEGORY`
  FOREIGN KEY (`CATEGORY`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`CATEGORIES` (`CATEGORY_NAME`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION; 
  
  /*NEWS_COMMENTS*/
   ALTER TABLE `GOOD_OLD_TIMES_DB`.`NEWS_COMMENTS` 
ADD CONSTRAINT `FK_N_CO_REPORT`
  FOREIGN KEY (`REPORT_ID`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`NEWS_REPORTS` (`REPORT_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  ALTER TABLE `GOOD_OLD_TIMES_DB`.`NEWS_COMMENTS` 
ADD CONSTRAINT `FK_N_CO_COMMENT`
  FOREIGN KEY (`COMMENT_ID`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`COMMENTS` (`COMMENT_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  /*NEWS TAGS*/
  ALTER TABLE `GOOD_OLD_TIMES_DB`.`NEWS_TAGS` 
ADD CONSTRAINT `FK_N_T_REPORT`
  FOREIGN KEY (`REPORT_ID`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`NEWS_REPORTS` (`REPORT_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION; 
  
  ALTER TABLE `GOOD_OLD_TIMES_DB`.`NEWS_TAGS` 
ADD CONSTRAINT `FK_N_T_TAG`
  FOREIGN KEY (`TAG`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`TAGS` (`TAG_NAME`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  
  /*REACTIONS*/
  ALTER TABLE `GOOD_OLD_TIMES_DB`.`REACTIONS` 
ADD CONSTRAINT `FK_REACTION_USER`
  FOREIGN KEY (`USER`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`USERS` (`ID_USER`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
    ALTER TABLE `GOOD_OLD_TIMES_DB`.`REACTIONS` 
ADD CONSTRAINT `FK_REACTION_REPORT`
  FOREIGN KEY (`REPORT_ID`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`NEWS_REPORTS` (`REPORT_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  
  
