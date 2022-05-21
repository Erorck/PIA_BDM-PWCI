use notipapa_db;

drop view if exists RepArticlesSimple;
CREATE VIEW RepArticlesSimple
AS 
SELECT 
	LIKES,
	ARTICLE_ID,
    ARTICLE_HEADER,
	EVENT_DATE,
    SIGN,
    CREATED_BY,
    ARTICLE_STATUS
FROM
    ARTICLES order by EVENT_DATE ASC;
drop view if exists RepArticlesData;
CREATE VIEW RepArticlesData
AS 
SELECT 
	LIKES,
	ARTICLE_ID,
    ARTICLE_HEADER,
	EVENT_DATE,
	LOCATION_STREET,
	LOCATION_NEIGHB, 
    LOCATION_CITY, 
    LOCATION_STATE, 
    LOCATION_COUNTRY,
    ARTICLE_DESCRIPTION,
    ARTICLE_CONTENT,
    SIGN,
    CREATED_BY,
    ARTICLE_STATUS
FROM
    ARTICLES order by EVENT_DATE ASC;

delimiter //
DROP PROCEDURE IF EXISTS sp_Rep_GetArticles//
CREATE PROCEDURE sp_Rep_GetArticles(
)
BEGIN
	select * from RepArticlesData ;
END //
DELIMITER ;
delimiter //
DROP PROCEDURE IF EXISTS sp_Rep_GetArticles_Simple//
CREATE PROCEDURE sp_Rep_GetArticles_Simple(
)
BEGIN
	select * from RepArticlesSimple ;
END //
DELIMITER ;
