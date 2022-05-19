
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

-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- //////////////////////////////////////////////////// USERS /////////////////////////////////////////////////////////////////////////////////////////////////
-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
drop procedure if exists sp_Get_Uname$$
CREATE PROCEDURE sp_Get_Uname( IN par_uid int)
    BEGIN
        SELECT USER_ALIAS FROM users WHERE ID_USER = par_uid Limit 1;
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

-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- //////////////////////////////////////////////////// CATEGORIES ////////////////////////////////////////////////////////////////////////////////////////////
-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
DELIMITER $$
drop procedure if exists sp_Insert_Categories$$
CREATE PROCEDURE sp_Insert_Categories(in par_name varchar(200),in par_color char(6),in par_creator int)
    BEGIN
		SET @lastorder := (SELECT `ORDER` FROM LastCategInQ );
        -- set @ordertoinsert = @lastorder+1;
        set @ordertoinsert = `notipapa_db`.`GetLastOrderFromCateg`(@lastorder);
        insert into categories(`ORDER`, CATEGORY_NAME,COLOR,CREATED_BY,LAST_UPDATED_BY)
        values(@ordertoinsert,par_name,par_color,par_creator,par_creator);
    END
$$
DELIMITER ;
DELIMITER $$
drop procedure if exists sp_Delete_Categories$$
CREATE PROCEDURE sp_Delete_Categories(in param_nombre varchar(200))
    BEGIN
		DELETE FROM categories where CATEGORY_NAME = param_nombre;
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
		call sp_UpdateCategOrder();
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
drop procedure if exists sp_UpdateCategNameColor$$
CREATE PROCEDURE sp_UpdateCategNameColor(in param_Categ varchar(200), in param_newname varchar(200),in param_Color char(6) )
    BEGIN
		UPDATE categories 
        SET
        CATEGORY_NAME = param_newname,
        COLOR = param_Color
        where CATEGORY_NAME = param_Categ;
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
-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- //////////////////////////////////////////////////// Articles //////////////////////////////////////////////////////////////////////////////////////////////
-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
DELIMITER //
DROP PROCEDURE IF EXISTS sp_Insert_Article//
CREATE PROCEDURE sp_Insert_Article(
	IN par_Sign VARCHAR(100),
	IN par_locstrt CHAR(100),
    IN par_locnghb VARCHAR(70),
    IN par_loccity varchar(80),
    IN par_locstate VARCHAR(50),
    IN par_locntry VARCHAR(50),
	IN par_eventdate datetime,
	IN par_header VARCHAR(80),
	IN par_descr VARCHAR(100),
	IN par_content text,
	IN par_thumbnail MEDIUMBLOB,
    in par_thumbnail_mime varchar(200),
    IN par_author INT,
    IN par_categ varchar (200)
)
BEGIN
		INSERT INTO articles(`SIGN`,`LOCATION_STREET`, `LOCATION_NEIGHB`,`LOCATION_CITY`,`LOCATION_STATE`,`LOCATION_COUNTRY`, `EVENT_DATE`, `ARTICLE_HEADER`, `ARTICLE_DESCRIPTION`, `ARTICLE_CONTENT`, `THUMBNAIL`,THUMBNAIL_MIME,CREATED_BY,LAST_UPDATED_BY) 
			VALUES (par_Sign,par_locstrt,par_locnghb,par_loccity, par_locstate ,par_locntry, par_eventdate, par_header, par_descr, par_content, par_thumbnail,par_thumbnail_mime ,par_author,par_author);
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_Update_Article//
CREATE PROCEDURE sp_Update_Article(
	in par_aid int,
    IN par_updater INT,
	IN par_Sign VARCHAR(100),
	IN par_locstrt CHAR(100),
    IN par_locnghb VARCHAR(70),
    IN par_loccity varchar(80),
    IN par_locstate VARCHAR(50),
    IN par_locntry VARCHAR(50),
	IN par_eventdate datetime,
	IN par_header VARCHAR(80),
	IN par_descr VARCHAR(100),
	IN par_content text,
	IN par_thumbnail MEDIUMBLOB,
    in par_thumbnail_mime varchar(200),
    IN par_categ varchar (200)
)
BEGIN
		update articles
        set 
        `SIGN` = par_Sign,
        `LAST_UPDATED_BY`=par_updater,
        `LOCATION_STREET`=par_locstrt,
        `LOCATION_NEIGHB`=par_locnghb,
        `LOCATION_CITY`=par_loccity,
        `LOCATION_STATE`=par_locstate,
        `LOCATION_COUNTRY`=par_locntry,
        `EVENT_DATE`=par_eventdate,
        `ARTICLE_HEADER`=par_header,
        `ARTICLE_DESCRIPTION`=par_descr,
        `ARTICLE_CONTENT`=par_content,
        `THUMBNAIL`=par_thumbnail,
		 THUMBNAIL_MIME=par_thumbnail_mime
		where ARTICLE_ID=par_aid;
        update news_categories
        set CATEGORY=par_categ
        where ARTICLE_ID=par_aid;
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetArticleImg//
CREATE PROCEDURE sp_GetArticleImg(
	IN par_id int
)
BEGIN
	select THUMBNAIL, THUMBNAIL_MIME from ArticleThumbnails where ARTICLE_ID = par_id;
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetCountArticles//
CREATE PROCEDURE sp_GetCountArticles(
)
BEGIN
	select * from numberofarticles ;
END //
DROP PROCEDURE IF EXISTS sp_GetCountArticlesRR//
CREATE PROCEDURE sp_GetCountArticlesRR(
)
BEGIN
	select * from numberofarticlesrr ;
END //
DROP PROCEDURE IF EXISTS sp_GetCountArticlesRA//
CREATE PROCEDURE sp_GetCountArticlesRA(
)
BEGIN
	select * from numberofarticlesra ;
END //
DROP PROCEDURE IF EXISTS sp_GetCountArticlesPU//
CREATE PROCEDURE sp_GetCountArticlesPU(
)
BEGIN
	select * from numberofarticlespu ;
END //
DROP PROCEDURE IF EXISTS sp_GetCountArticlesEL//
CREATE PROCEDURE sp_GetCountArticlesEL(
)
BEGIN
	select * from numberofarticlesel ;
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetArticles//
CREATE PROCEDURE sp_GetArticles(
)
BEGIN
	select * from allarticulos ;
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetArticleId_DHCby//
CREATE PROCEDURE sp_GetArticleId_DHCby(
	IN par_EventDate datetime,
    IN par_Header varchar(200),
    IN par_CreatedBy int
)
BEGIN
	select ARTICLE_ID  from AllArticulos where EVENT_DATE = par_EventDate and ARTICLE_HEADER=par_Header and CREATED_BY =par_CreatedBy limit 1;
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_ChangeArticleStatus//
CREATE PROCEDURE sp_ChangeArticleStatus(
in par_id int,
in par_status char(2)
)
BEGIN
	update articles 
    set ARTICLE_STATUS = par_status
    where ARTICLE_ID = par_id;
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_ChangeArticlePubDate//
CREATE PROCEDURE sp_ChangeArticlePubDate(
in par_id int,
in par_pubDate datetime
)
BEGIN
	update articles 
    set PUBLICATION_DATE = par_pubDate
    where ARTICLE_ID = par_id;
END //
DELIMITER ;
-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- //////////////////////////////////////////////////// VIDEOS AND IMAGES /////////////////////////////////////////////////////////////////////////////////////
-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
DELIMITER //
DROP PROCEDURE IF EXISTS sp_Insert_Image//
CREATE PROCEDURE sp_Insert_Image(
	IN par_ArticleId INT,
	IN par_Desc VARCHAR(200),
    IN par_Content MEDIUMBLOB,
    IN par_MIME varchar(200),
    IN par_Route text
)
BEGIN
		Insert into IMAGES(`DESCRIPTION`,`CONTENT`,MIME,`ROUTE`,ARTICLE_ID)
        values(par_Desc,par_Content,par_MIME,par_Route,par_ArticleId);
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_Insert_Video//
CREATE PROCEDURE sp_Insert_Video(
	IN par_ArticleId INT,
	IN par_Desc VARCHAR(200),
    IN par_Content MEDIUMBLOB,
    IN par_MIME varchar(200),
    IN par_Route text
)
BEGIN
		Insert into VIDEOS(`DESCRIPTION`,`CONTENT`,MIME,`ROUTE`,ARTICLE_ID)
        values(par_Desc,par_Content,par_MIME,par_Route,par_ArticleId);
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetImage//
CREATE PROCEDURE sp_GetImage(
	IN par_id int
)
BEGIN
	select `DESCRIPTION`,CONTENT,MIME from images where ARTICLE_ID = par_id;
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetVideo//
CREATE PROCEDURE sp_GetVideo(
	IN par_id int
)
BEGIN
	select `DESCRIPTION`,CONTENT,MIME from videos where ARTICLE_ID = par_id;
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_Delete_MediaFromArticle//
CREATE PROCEDURE sp_Delete_MediaFromArticle(
	IN par_aid int
)
BEGIN
	SET SQL_SAFE_UPDATES = 0;
		DELETE FROM videos where ARTICLE_ID = par_aid;
		DELETE FROM images where ARTICLE_ID = par_aid;
	SET SQL_SAFE_UPDATES = 1;
END //
DELIMITER ;
-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- //////////////////////////////////////////////////// Feedbacks//////////////////////////////////////////////////////////////////////////////////////////////
-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
DELIMITER //
DROP PROCEDURE IF EXISTS sp_Insert_Feedbacks//
CREATE PROCEDURE sp_Insert_Feedbacks(
	IN par_FEEDBACK_TEXT varchar(1000),
	IN par_FEEDBACK_BY int,
    IN par_FEEDBACK_FOR int,
    IN par_ARTICLE_ID int
)
BEGIN
		Insert into feedbacks(FEEDBACK_TEXT,FEEDBACK_BY,FEEDBACK_FOR,ARTICLE_ID,LAST_UPDATED_BY)
        values(par_FEEDBACK_TEXT,par_FEEDBACK_BY,par_FEEDBACK_FOR,par_ARTICLE_ID,par_FEEDBACK_BY);
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_Insert_Feedbacks_Children//
CREATE PROCEDURE sp_Insert_Feedbacks_Children(
	IN par_FEEDBACK_TEXT varchar(1000),
	IN par_FEEDBACK_BY int,
    IN par_FEEDBACK_FOR int,
    IN par_ARTICLE_ID int,
    iN par_PARENTID int
)
BEGIN
		call sp_Insert_Feedbacks(par_FEEDBACK_TEXT,par_FEEDBACK_BY,par_FEEDBACK_FOR,par_ARTICLE_ID);
        SET @Fid = LAST_INSERT_ID();
        insert into news_feedbacks(FEEDBACK_ID,ARTICLE_ID,PARENT_ID,`ACTIVE`)
        values(@Fid,par_ARTICLE_ID,par_PARENTID,true);
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetFeedbackId//
CREATE PROCEDURE sp_GetFeedbackId(
	IN par_by int,
    IN par_for int,
    IN par_Date int
)
BEGIN
	select * from feedbacks where
    FEEDBACK_BY = par_by and FEEDBACK_FOR = par_for and CREATION_DATE = par_Date;
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetFeedbacks//
CREATE PROCEDURE sp_GetFeedbacks(
	IN par_id int
)
BEGIN
	select * from feedbacks where FEEDBACK_ID = par_id;
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetFeedbacksFor//
CREATE PROCEDURE sp_GetFeedbacksFor(
	IN par_for int
)
BEGIN
	select * from feedbacks where FEEDBACK_FOR = par_for;
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetFeedbacksBy//
CREATE PROCEDURE sp_GetFeedbacksBy(
	IN par_for int
)
BEGIN
	select * from feedbacks where FEEDBACK_BY = par_for;
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetFeedbacksArticle//
CREATE PROCEDURE sp_GetFeedbacksArticle(
	IN par_aid int
)
BEGIN
	select * from feedbacks where ARTICLE_ID = par_aid;
END //
DELIMITER ;
-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- //////////////////////////////////////////////////// comments//////////////////////////////////////////////////////////////////////////////////////////////
-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
DELIMITER //
DROP PROCEDURE IF EXISTS sp_Insert_Comment//
CREATE PROCEDURE sp_Insert_Comment(
	IN par_COMMENT_TEXT varchar(1000),
	IN par_CREATED_BY int,
    IN par_ARTICLE_ID int
)
BEGIN
		Insert into comments(COMMENT_TEXT,CREATED_BY,LAST_UPDATED_BY,ARTICLE_ID)
        values(par_COMMENT_TEXT,par_CREATED_BY,par_CREATED_BY,par_ARTICLE_ID);
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetCommentsArticle//
CREATE PROCEDURE sp_GetCommentsArticle(
	IN par_aid int
)
BEGIN
	select * from comments where ARTICLE_ID = par_aid;
END //
DELIMITER ;
-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- //////////////////////////////////////////////////// Asosiativas////////////////////////////////////////////////////////////////////////////////////////////
-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
DELIMITER //
DROP PROCEDURE IF EXISTS sp_Insert_asoc_news_categories//
CREATE PROCEDURE sp_Insert_asoc_news_categories(
	IN par_aid int,
    IN par_categ varchar(200),
    IN par_creator int
)
BEGIN
		Insert into news_categories(ARTICLE_ID,CATEGORY,CREATED_BY)
        values(par_aid,par_categ,par_creator);
END //
DELIMITER ;
DELIMITER //
DROP PROCEDURE IF EXISTS sp_GetCategOfArticle//
CREATE PROCEDURE sp_GetCategOfArticle(
	IN par_aid int
)
BEGIN
	select CATEGORY from news_categories where ARTICLE_ID = par_aid;
END //
DELIMITER ;