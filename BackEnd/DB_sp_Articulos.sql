
/*
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
  `ARTICLE_CONTENT` text  NOT NULL COMMENT 'Contenido de la nota',
  `LIKES` INT NOT NULL DEFAULT 0 COMMENT 'Numero de likes que ha recibido la nota',
  `THUMBNAIL` MEDIUMBLOB NOT NULL COMMENT 'Miniatura con la que la nota se muestra',
  `CREATION_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion de la nota',
  `CREATED_BY` INT NOT NULL COMMENT 'Usuario que creo la nota',
  `LAST_UPDATE_DATE` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Última fecha de modificación de la nota',
  `LAST_UPDATED_BY` INT NOT NULL COMMENT 'Ultimo usuario que modifico la nota',
  `ARTICLE_STATUS` CHAR(2) NOT NULL DEFAULT 'RR' COMMENT 'Estado actual de la noticia [P-Publicada  E-Eliminada  RA-En revision por administrador  RR-En revision por reportero]',
  PRIMARY KEY (`ARTICLE_ID`));
*/

USE NOTIPAPA_DB;

DELIMITER //
DROP PROCEDURE IF EXISTS sp_Article//
CREATE PROCEDURE sp_Article(
	in command VARCHAR(4),
	IN repsign VARCHAR(100),
	IN locstrt VARCHAR(100),
    IN locneigh VARCHAR(100),
    IN loccity varchar(100),
    IN loccountry VARCHAR(100),
    IN eventdate DATETIME,
	IN pubdate DATETIME,
    IN artheader VARCHAR(100),
	IN artdesc VARCHAR(100),
	IN artcontent text,
	IN thumbnail MEDIUMBLOB,
	IN creator INT,
	IN artstatus CHAR(2)
)
CONTAINS SQL
`sp_Article`:
BEGIN

	DECLARE EXIT HANDLER FOR 1452
		BEGIN
			SELECT 'Error al insertar en la tabla Articulos' MSG;
		END;
        
/*#######################################
				INSERT 
                Article
########################################*/
IF command = 'I'
THEN
	START TRANSACTION;
		INSERT INTO ARTICLES(`SIGN` ,
						  `LOCATION_STREET`,
						  `LOCATION_NEIGHB`,
						  `LOCATION_CITY`,
						  `LOCATION_COUNTRY`,
						  `EVENT_DATE`,
						  `PUBLICATION_DATE`,
						  `ARTICLE_HEADER`,
						  `ARTICLE_DESCRIPTION`,
						  `ARTICLE_CONTENT`,
						  `THUMBNAIL`,
						  `CREATED_BY`,
						  `LAST_UPDATED_BY`,
						  `ARTICLE_STATUS`) 
			VALUES ( repsign,locstrt,locneigh,loccity ,loccountry ,eventdate ,pubdate ,artheader ,artdesc ,artcontent ,thumbnail ,creator,creator ,artstatus );
		
	LEAVE `sp_Article`;
END IF;

END //
DELIMITER ;