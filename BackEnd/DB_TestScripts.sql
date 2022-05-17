/*
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
*/
jnkjbnujbasi -- este texto es para evitar un Arranque accidental de todos los scripts
USE NOTIPAPA_DB;
SET SQL_SAFE_UPDATES = 0;
DELETE FROM images ;
DELETE FROM videos ;
DELETE FROM articles ;
SET SQL_SAFE_UPDATES = 1;
ALTER TABLE images AUTO_INCREMENT = 1;
ALTER TABLE videos AUTO_INCREMENT = 1;
ALTER TABLE articles AUTO_INCREMENT = 1;
select * from articles;

select * from images;
select * from videos;
 