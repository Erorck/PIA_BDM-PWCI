/*DROP DATABASE IF EXISTS NOTIPAPA_DB;*/

CREATE DATABASE IF NOT EXISTS NOTIPAPA_DB;

USE NOTIPAPA_DB;

/* CREACION DE TABLAS PARA NOTIPAPA */

DROP TABLE IF EXISTS USERS;
CREATE TABLE `NOTIPAPA_DB`.`USERS` (
  `ID_USER` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla USERS',
  `CREDENTIAL` VARCHAR(45) NOT NULL COMMENT 'Contraseña del usuario',
  `NAME` VARCHAR(100) NOT NULL COMMENT 'Nombres del usuario',
  `USER_ALIAS` VARCHAR(100) NOT NULL COMMENT 'Apodo del usuario',
  `FIRST_LAST_NAME` CHAR(45) NOT NULL COMMENT 'Apellido paterno del usuario',
  `SECOND_LAST_NAME` CHAR(45) NOT NULL COMMENT 'Apellido materno del usuario',
  `EMAIL` VARCHAR(100) NOT NULL COMMENT 'Email del usuario',
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
  CREATE TABLE `NOTIPAPA_DB`.`CATEGORIES` (
  `CATEGORY_NAME` VARCHAR(40) NOT NULL COMMENT 'Llave primaria de la tabla, nombre de la CATEGORIES', 
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion de la nota',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo la nota',
  `LAST_UPDATE_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Última fecha de modificación de la sección',
  `LAST_UPDATED_BY` INT NOT NULL COMMENT 'Último usuario que modifico la sección',
  `SECTION_STATUS` CHAR(1) NOT NULL DEFAULT 'A' COMMENT 'Estado actual de la seccion [A - Activa  I - Inactiva]',
  `ORDER` TINYINT UNSIGNED NOT NULL COMMENT 'Posicion de la categoria en el orden de las categorias',
  `COLOR` char(6) NOT NULL DEFAULT '808080' COMMENT 'Color Hexadecimal de la Categoria',
  PRIMARY KEY (`CATEGORY_NAME`));
  
  DROP TABLE IF EXISTS ARTICLES;
  CREATE TABLE `NOTIPAPA_DB`.`ARTICLES` (
  `ARTICLE_ID` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla de ARTICLES',
  `SIGN` VARCHAR(100) NOT NULL COMMENT 'Firma del reportero',
  `LOCATION_STREET` VARCHAR(100) COMMENT 'Calle en la que ocurrio la nota',
  `LOCATION_NEIGHB` VARCHAR(70) COMMENT 'Colonia en la que ocurrio la nota',
  `LOCATION_CITY` VARCHAR(80) NOT NULL COMMENT 'Ciudad en la que ocurrio la nota',
  `LOCATION_COUNTRY` VARCHAR(50) NOT NULL COMMENT 'Pais en la que ocurrio la nota',
  `EVENT_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que ocurrio el suceso',
  `PUBLICATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que publico la nota en el portal',
  `ARTICLE_HEADER` VARCHAR(80) NOT NULL COMMENT 'Encabezado de la nota',
  `ARTICLE_DESCRIPTION` VARCHAR(100) COMMENT 'Descripción breve de la nota',
  `ARTICLE_CONTENT` TEXT NOT NULL COMMENT 'Contenido de la nota',
  `LIKES` INT NOT NULL DEFAULT 0 COMMENT 'Numero de likes que ha recibido la nota',
  `THUMBNAIL` MEDIUMBLOB NOT NULL COMMENT 'Miniatura con la que la nota se muestra',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion de la nota',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo la nota',
  `LAST_UPDATE_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Última fecha de modificación de la nota',
  `LAST_UPDATED_BY` INT NOT NULL COMMENT 'Ultimo usuario que modifico la nota',
  `ARTICLE_STATUS` CHAR(2) NOT NULL DEFAULT 'RR' COMMENT 'Estado actual de la noticia [P-Publicada  E-Eliminada  RA-En revision por administrador  RR-En revision por reportero]',
  PRIMARY KEY (`ARTICLE_ID`));
  
  DROP TABLE IF EXISTS COMMENTS;
  CREATE TABLE `NOTIPAPA_DB`.`COMMENTS` (
  `COMMENT_ID` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla de COMMENTS',
  `COMMENT_TEXT` VARCHAR(1000) NOT NULL COMMENT 'Contenido del comentario',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del comentario',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo el comentario',
  `LAST_UPDATE_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Última fecha de modificación del comentario',
  `LAST_UPDATED_BY` INT NOT NULL COMMENT 'Ultimo usuario que modifico el comentario',
  `COMMENT_STATUS` CHAR(2) NOT NULL DEFAULT 'P' COMMENT 'Estado actual del comentario [P-Publico  E-Eliminado]',
  `ARTICLE_ID` INT NOT NULL COMMENT 'Id de la noticia a la que pertence el comentario',
  PRIMARY KEY (`COMMENT_ID`));
  
    CREATE TABLE IF NOT EXISTS NEWS_COMMENTS(
    `COMMENT_ID` INT NOT NULL AUTO_INCREMENT COMMENT "Llave primaria de la tabla NEWS_COMMENTS",
    `ARTICLE_ID` INT NOT NULL COMMENT "Llave primaria de la tabla NEWS",
    `PARENT_ID` INT COMMENT "Nos indica si otro ID de la tabla de NEWS_COMMENT se respondio con este mensaje",
    `CREATION_DATE` DATETIME NOT NULL COMMENT "Fecha de creacion del registro",
    `ACTIVE` BOOLEAN DEFAULT TRUE NOT NULL COMMENT "Indica si el registro esta activo en la base de datos",
    PRIMARY KEY (`COMMENT_ID`,`ARTICLE_ID`),
    INDEX (`PARENT_ID`)
);
  
  DROP TABLE IF EXISTS FEEDBACKS;
  CREATE TABLE `NOTIPAPA_DB`.`FEEDBACKS` (
  `FEEDBACK_ID` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla de FEEDBACKS',
  `FEEDBACK_TEXT` VARCHAR(1000) NOT NULL COMMENT 'Contenido del feedback',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del Feedback',
  `FEEDBACK_BY` INT NOT NULL COMMENT 'Usuario Editor que creo el Feedback',
  `FEEDBACK_FOR` INT NOT NULL COMMENT 'Usuario Reportero que recibe el Feedback',
  `LAST_UPDATE_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Última fecha de modificación del Feedback',
  `LAST_UPDATED_BY` INT NOT NULL COMMENT 'Ultimo usuario que modifico el Feedback',
  `FEEDBACK_STATUS` CHAR(2) NOT NULL DEFAULT 'P' COMMENT 'Estado actual del comentario [A-Aprobado P-Pendiente de aprobacion  E-Eliminado]',
  `ARTICLE_ID` INT NOT NULL COMMENT 'Id de la noticia a la que pertence el FeedBack',
  PRIMARY KEY (`FEEDBACK_ID`));

CREATE TABLE IF NOT EXISTS NEWS_FEEDBACKS(
    `FEEDBACK_ID` INT NOT NULL AUTO_INCREMENT COMMENT "Llave primaria de la tabla NEWS_FEEDBACKS",
    `ARTICLE_ID` INT NOT NULL COMMENT "Llave primaria de la tabla NEWS",
    `PARENT_ID` INT COMMENT "Nos indica si otro ID de la tabla de NEWS_FEEDBACKS se respondio con este mensaje",
    `CREATION_DATE` DATETIME NOT NULL COMMENT "Fecha de creacion del registro",
    `ACTIVE` BOOLEAN DEFAULT TRUE NOT NULL COMMENT "Indica si el registro esta activo en la base de datos",
    PRIMARY KEY (`FEEDBACK_ID`,`ARTICLE_ID`),
    INDEX (`PARENT_ID`)
);

DROP TABLE IF EXISTS IMAGES;
  CREATE TABLE `NOTIPAPA_DB`.`IMAGES` (
  `ID_IMAGE` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla IMAGES',
  `DESCRIPTION` VARCHAR(200) NOT NULL COMMENT 'Breve descripcion del contenido del archivo',
  `CONTENT` MEDIUMBLOB NOT NULL COMMENT 'Datos de la imagen',
  `ROUTE` VARCHAR(1000) NOT NULL COMMENT 'Ruta del archivo',
  `UPLOAD_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de subida del material',
  `IMAGE_STATUS` CHAR(2) NOT NULL DEFAULT 'P' COMMENT 'Estado actual del material [P-Publico  E-Eliminado]',
  `ARTICLE_ID` INT NOT NULL COMMENT 'Id de la noticia a la que pertence el material',
  PRIMARY KEY (`ID_IMAGE`));
  
  DROP TABLE IF EXISTS VIDEOS;
  CREATE TABLE `NOTIPAPA_DB`.`VIDEOS` (
  `ID_VIDEO` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla VIDEOS',
  `DESCRIPTION` VARCHAR(200) NOT NULL COMMENT 'Breve descripcion del contenido del archivo',
  `CONTENT` MEDIUMBLOB NOT NULL COMMENT 'Datos deL video',
  `ROUTE` VARCHAR(1000) NOT NULL COMMENT 'Ruta del archivo',
  `UPLOAD_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de subida del material',
  `VIDEO_STATUS` CHAR(2) NOT NULL DEFAULT 'P' COMMENT 'Estado actual del material [P-Publico  E-Eliminado]',
  `ARTICLE_ID` INT NOT NULL COMMENT 'Id de la noticia a la que pertence el material',
  PRIMARY KEY (`ID_VIDEO`));
  
  DROP TABLE IF EXISTS TAGS;
  CREATE TABLE `NOTIPAPA_DB`.`TAGS` (
  `TAG_NAME` VARCHAR(50) NOT NULL COMMENT 'Llave primaria de la tabla etiqueta/ Nombre de la TAGS',
  `TAG_STATUS` CHAR(2) NOT NULL DEFAULT 'EU' COMMENT 'Estado actual de la etiqueta [EU-En uso  SU-Sin usar]',
  PRIMARY KEY (`TAG_NAME`));
  
  DROP TABLE IF EXISTS NEWS_CATEGORIES;
  CREATE TABLE `NOTIPAPA_DB`.`NEWS_CATEGORIES` (
  `ARTICLE_ID` INT NOT NULL COMMENT 'Identificador de la noticia involucrada en la relación', 
  `CATEGORY` VARCHAR(40) NOT NULL COMMENT 'Identificador de la sección involucrada en la relación',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del registro',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo el registro',
  PRIMARY KEY (`ARTICLE_ID`, `CATEGORY`));
  
  DROP TABLE IF EXISTS NEWS_TAGS;
  CREATE TABLE `NOTIPAPA_DB`.`NEWS_TAGS` (
  `TAG` VARCHAR(50) NOT NULL COMMENT 'Identificador de la etiqueta involucrada en la relación',
  `ARTICLE_ID` INT NOT NULL COMMENT 'Identificador de la noticia involucrada en la relación',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del registro',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo el registro',
  PRIMARY KEY (`TAG`, `ARTICLE_ID`));
  
  DROP TABLE IF EXISTS REACTIONS;
  CREATE TABLE `NOTIPAPA_DB`.`REACTIONS` (
  `USER` INT NOT NULL COMMENT 'Identificador del usuario involucrado en la relación',
  `ARTICLE_ID` INT NOT NULL COMMENT 'Identificador de la noticia involucrada en la relación',
  `LIKED` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Bandera que indica la reaccion del usuario a la nota',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del registro',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo el registro',
  PRIMARY KEY (`USER`, `ARTICLE_ID`));
  
  /* LLAVES FORANEAS */
  
  /*----------------------------------
  --------LLAVES FORANEAS-------------
  ------------------------------------*/

  
ALTER TABLE `NOTIPAPA_DB`.`COMMENTS` 
ADD CONSTRAINT `FK_COMMENT_USER`
  FOREIGN KEY (`CREATED_BY`)
  REFERENCES `NOTIPAPA_DB`.`USERS` (`ID_USER`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `NOTIPAPA_DB`.`FEEDBACKS` 
ADD CONSTRAINT `FK_FEEDBACK_EDITOR`
  FOREIGN KEY (`FEEDBACK_BY`)
  REFERENCES `NOTIPAPA_DB`.`USERS` (`ID_USER`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `NOTIPAPA_DB`.`FEEDBACKS` 
ADD CONSTRAINT `FK_FEEDBACK_REPORTER`
  FOREIGN KEY (`FEEDBACK_FOR`)
  REFERENCES `NOTIPAPA_DB`.`USERS` (`ID_USER`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `NOTIPAPA_DB`.`ARTICLES` 
ADD CONSTRAINT `FK_ARTICLE_USER`
  FOREIGN KEY (`CREATED_BY`)
  REFERENCES `NOTIPAPA_DB`.`USERS` (`ID_USER`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  ALTER TABLE `NOTIPAPA_DB`.`IMAGES` 
ADD CONSTRAINT `FK_IMAGE_ARTICLE`
  FOREIGN KEY (`ARTICLE_ID`)
  REFERENCES `NOTIPAPA_DB`.`ARTICLES` (`ARTICLE_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION; 
  
  ALTER TABLE `NOTIPAPA_DB`.`VIDEOS` 
ADD CONSTRAINT `FK_VIDEO_ARTICLE`
  FOREIGN KEY (`ARTICLE_ID`)
  REFERENCES `NOTIPAPA_DB`.`ARTICLES` (`ARTICLE_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
/*  ALTER TABLE `GOOD_OLD_TIMES_DB`.`COMMENTS` 
ADD CONSTRAINT `FK_COMMENT_REPORT`
  FOREIGN KEY (`REPORT`)
  REFERENCES `GOOD_OLD_TIMES_DB`.`NEWS_REPORTS` (`ID_NEWS`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  /*NEWS SECTIONS*/

  ALTER TABLE `NOTIPAPA_DB`.`NEWS_CATEGORIES` 
ADD CONSTRAINT `FK_N_CA_ARTICLE`
  FOREIGN KEY (`ARTICLE_ID`)
  REFERENCES `NOTIPAPA_DB`.`ARTICLES` (`ARTICLE_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION; 
  
  ALTER TABLE `NOTIPAPA_DB`.`NEWS_CATEGORIES` 
ADD CONSTRAINT `FK_N_CA_CATEGORY`
  FOREIGN KEY (`CATEGORY`)
  REFERENCES `NOTIPAPA_DB`.`CATEGORIES` (`CATEGORY_NAME`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION; 
  
  /*NEWS_COMMENTS*/
   ALTER TABLE `NOTIPAPA_DB`.`NEWS_COMMENTS` 
ADD CONSTRAINT `FK_N_CO_ARTICLE`
  FOREIGN KEY (`ARTICLE_ID`)
  REFERENCES `NOTIPAPA_DB`.`ARTICLES` (`ARTICLE_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  ALTER TABLE `NOTIPAPA_DB`.`NEWS_COMMENTS` 
ADD CONSTRAINT `FK_N_CO_COMMENT`
  FOREIGN KEY (`COMMENT_ID`)
  REFERENCES `NOTIPAPA_DB`.`COMMENTS` (`COMMENT_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
   /*NEWS_FEEDBACKS*/
   ALTER TABLE `NOTIPAPA_DB`.`NEWS_FEEDBACKS` 
ADD CONSTRAINT `FK_N_FB_ARTICLE`
  FOREIGN KEY (`ARTICLE_ID`)
  REFERENCES `NOTIPAPA_DB`.`ARTICLES` (`ARTICLE_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  ALTER TABLE `NOTIPAPA_DB`.`NEWS_FEEDBACKS` 
ADD CONSTRAINT `FK_N_FB_FEEDBACK`
  FOREIGN KEY (`FEEDBACK_ID`)
  REFERENCES `NOTIPAPA_DB`.`FEEDBACKS` (`FEEDBACK_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  /*NEWS TAGS*/
  ALTER TABLE `NOTIPAPA_DB`.`NEWS_TAGS` 
ADD CONSTRAINT `FK_N_T_ARTICLE`
  FOREIGN KEY (`ARTICLE_ID`)
  REFERENCES `NOTIPAPA_DB`.`ARTICLES` (`ARTICLE_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION; 
  
  ALTER TABLE `NOTIPAPA_DB`.`NEWS_TAGS` 
ADD CONSTRAINT `FK_N_T_TAG`
  FOREIGN KEY (`TAG`)
  REFERENCES `NOTIPAPA_DB`.`TAGS` (`TAG_NAME`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  
  /*REACTIONS*/
  ALTER TABLE `NOTIPAPA_DB`.`REACTIONS` 
ADD CONSTRAINT `FK_REACTION_USER`
  FOREIGN KEY (`USER`)
  REFERENCES `NOTIPAPA_DB`.`USERS` (`ID_USER`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
    ALTER TABLE `NOTIPAPA_DB`.`REACTIONS` 
ADD CONSTRAINT `FK_REACTION_ARTICLE`
  FOREIGN KEY (`ARTICLE_ID`)
  REFERENCES `NOTIPAPA_DB`.`ARTICLES` (`ARTICLE_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;