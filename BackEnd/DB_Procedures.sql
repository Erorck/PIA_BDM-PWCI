
USE NOTIPAPA_DB;

/*
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
*/



select * from users;

DELIMITER $$
CREATE PROCEDURE sp_ValidUser(	
IN param_usuario varchar(30),
IN param_pass varchar(30))
    BEGIN
        SELECT ID_USER FROM users WHERE USER_ALIAS = param_usuario and CREDENTIAL = param_pass Limit 1;
    END
$$
DELIMITER ;

DELIMITER $$
drop procedure sp_Get_DatosUsuario$$
CREATE PROCEDURE sp_Get_DatosUsuario( IN param_uname varchar(100))
    BEGIN
        SELECT * FROM DatosUsuarios WHERE USER_ALIAS = param_uname Limit 1;
    END
$$
DELIMITER ;

DELIMITER $$
drop procedure if exists sp_Insert_Categories$$
CREATE PROCEDURE sp_Insert_Categories(in par_name varchar(200),in par_color char(6),in par_creator int)
    BEGIN
		SET @lastorder := (SELECT `ORDER` FROM LastCategInQ);
        set @ordertoinsert = @lastorder+1;
        insert into categories(`ORDER`, CATEGORY_NAME,COLOR,CREATED_BY,LAST_UPDATED_BY)
        values(@ordertoinsert,par_name,par_color,par_creator,par_creator);
    END
$$
DELIMITER ;
DELIMITER $$
drop procedure if exists sp_Delete_Categories_Order$$
CREATE PROCEDURE sp_Delete_Categories_Order(in par_Order int)
    BEGIN
		SET SQL_SAFE_UPDATES = 0;
		DELETE FROM categories where `ORDER` = par_Order;
		SET SQL_SAFE_UPDATES = 1;
    END
$$
DELIMITER ;
DELIMITER $$
drop procedure if exists sp_Get_Categories$$
CREATE PROCEDURE sp_Get_Categories( )
    BEGIN
        SELECT * FROM CategONC;
    END
$$
DELIMITER ;
DELIMITER $$
drop procedure if exists sp_SwapCategOrder$$
CREATE PROCEDURE sp_SwapCategOrder(in param_a int, in param_b int )
    BEGIN
    SET SQL_SAFE_UPDATES = 0;
       SET @auxcateg=(select CATEGORY_NAME from categories where `ORDER`= param_b limit 1);
		UPDATE categories SET `ORDER`= param_b where `ORDER`= param_a ;
        UPDATE categories SET `ORDER`= param_a where CATEGORY_NAME = @auxcateg ;
    SET SQL_SAFE_UPDATES = 1;
    END
$$
DELIMITER ;
DELIMITER $$
drop procedure if exists sp_SetCategOrder$$
CREATE PROCEDURE sp_SetCategOrder(in param_Categ varchar(200), in param_Order int )
    BEGIN
		UPDATE categories SET `ORDER`= param_Order where CATEGORY_NAME = param_Categ;
    END
$$
DELIMITER ;
DELIMITER $$
drop procedure if exists sp_UpdateCategOrder$$
CREATE PROCEDURE sp_UpdateCategOrder( )
    BEGIN
    SET SQL_SAFE_UPDATES = 0;
       SET @neworder=-1;
		UPDATE categories SET `ORDER`=(@neworder:=@neworder+1) ORDER BY `ORDER` ASC;
      SET SQL_SAFE_UPDATES = 1;
    END
$$
DELIMITER ;
DELIMITER $$
drop procedure if exists sp_Get_LastCateg$$
CREATE PROCEDURE sp_Get_LastCateg( )
    BEGIN
        SELECT * FROM LastCategInQ;
    END
$$
DELIMITER ;
DELIMITER $$
drop procedure if exists sp_GetUserId$$
CREATE PROCEDURE sp_GetUserId(in param_alias varchar(200) )
    BEGIN
        SELECT ID_USER FROM activeusers where USER_ALIAS = param_alias and USER_STATUS = 'A' limit 1;
    END
$$
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_User_Insert//
CREATE PROCEDURE sp_User_Insert(
	IN command VARCHAR(4),
	IN usertype CHAR(2),
    IN useralias VARCHAR(100),
    IN credential varchar(100),
    IN ufrstname VARCHAR(100),
	IN uflname VARCHAR(100),
    IN uslname VARCHAR(100),
	IN email VARCHAR(100),
	IN phone char(12),
	IN bday DATE,
	IN creator INT,
	IN pfpic MEDIUMBLOB
)
BEGIN
		INSERT INTO USERS(`NAME`,`FIRST_LAST_NAME`, `SECOND_LAST_NAME`,`USER_ALIAS`,  `CREDENTIAL`, `EMAIL`, `PHONE_NUMBER`, `BIRTHDAY`, `PROFILE_PICTURE`, `USER_TYPE`, `CREATED_BY`, `LAST_UPDATED_BY`) 
			VALUES (ufrstname,uflname,uslname, useralias, credential, email, phone, bday, pfpic, usertype, creator, creator);
END //
DELIMITER ;
