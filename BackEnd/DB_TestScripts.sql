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
USE NOTIPAPA_DB;

SET SQL_SAFE_UPDATES = 0;
DELETE FROM users;
SET SQL_SAFE_UPDATES = 1;
ALTER TABLE users AUTO_INCREMENT = 1;

call sp_User_Insert('I','AD','LaCreaTura','Qwertyuiop1!','Jorge','Clarin','Nitales','jorge.nitales@gmail.com','818181818181',CURDATE(),0,null);
call sp_User_Insert('I','RE','ElGoblino','Asdfghjkl1!','Ramon','Valdez','Figeroa','itachiuchiha6@gmail.com','121212121212','2002-03-20',1,null);
call sp_User_Insert('I','UR','UsuarioXD','Aaaaa1234!','usuario','registrado','deejemplo','emailfalso@gmail.com','8112345678','2000-01-19',0,null);
/*Hace un insert En el programa wacho pa testear*/
call sp_User_Insert('I','UR','Prueba','Prueba!','Prueba','xdasff','12qsdqd','prueba@gmail.com','12312341234','1999-01-19',0,null);
select* from users;

select * from categories;


call sp_Insert_Categories('VIDEOJUEGOS','bd9e7b',1);
delete from categories where CATEGORY_NAME = 'negocios';
select * from categonc;
call sp_UpdateCategOrder();
call sp_swapCategOrder(0,2);


SET FOREIGN_KEY_CHECKS = 0; 
TRUNCATE table articles; 
SET FOREIGN_KEY_CHECKS = 1;

select*from categories;
select * from Articles;

call sp_Get_DatosUsuario('ElGoblino');
call sp_GetUserId('LaCreaTura');
call sp_SetCategOrder('CIENCIAS',13);