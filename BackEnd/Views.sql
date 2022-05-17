USE NOTIPAPA_DB;

drop view if exists ArticleThumbnails;
Create View ArticleThumbnails
as
select Article_ID,
THUMBNAIL,
THUMBNAIL_MIME
from articles order by ARTICLE_ID asc;

select * from ArticleThumbnails;

drop view if exists AllArticulos;

CREATE VIEW AllArticulos
AS 
SELECT 
		ARTICLE_ID,
	EVENT_DATE,
	LOCATION_STREET,
	LOCATION_NEIGHB, 
    LOCATION_CITY, 
    LOCATION_STATE, 
    LOCATION_COUNTRY,
    ARTICLE_HEADER,
    ARTICLE_DESCRIPTION,
    ARTICLE_CONTENT,
    SIGN,
    CREATED_BY,
    LAST_UPDATED_BY,
    ARTICLE_STATUS
FROM
    articles order by EVENT_DATE ASC;

drop view if exists AllRRArticulos;    
    
    CREATE VIEW AllRRArticulos
AS 
SELECT 
		ARTICLE_ID,
	EVENT_DATE,
	LOCATION_STREET,
	LOCATION_NEIGHB, 
    LOCATION_CITY, 
    LOCATION_STATE, 
    LOCATION_COUNTRY,
    ARTICLE_HEADER,
    ARTICLE_DESCRIPTION,
    ARTICLE_CONTENT,
    SIGN,
    CREATED_BY,
    LAST_UPDATED_BY
FROM
    articles where ARTICLE_STATUS = "RR"
    order by EVENT_DATE ASC;
    
    drop view if exists AllRAArticulos;    
    
      CREATE VIEW AllRAArticulos
AS 
SELECT 
		ARTICLE_ID,
	EVENT_DATE,
	LOCATION_STREET,
	LOCATION_NEIGHB, 
    LOCATION_CITY, 
    LOCATION_STATE, 
    LOCATION_COUNTRY,
    ARTICLE_HEADER,
    ARTICLE_DESCRIPTION,
    ARTICLE_CONTENT,
    SIGN,
    CREATED_BY,
    LAST_UPDATED_BY
FROM
    articles where ARTICLE_STATUS = "RA"
    order by EVENT_DATE ASC;
    
      drop view if exists AllPUArticulos;   
    
CREATE VIEW AllPUArticulos
AS 
SELECT 
		ARTICLE_ID,
	EVENT_DATE,
	LOCATION_STREET,
	LOCATION_NEIGHB, 
    LOCATION_CITY, 
    LOCATION_STATE, 
    LOCATION_COUNTRY,
    ARTICLE_HEADER,
    ARTICLE_DESCRIPTION,
    ARTICLE_CONTENT,
    SIGN,
    CREATED_BY,
    LAST_UPDATED_BY
FROM
    articles where ARTICLE_STATUS = "PU"
    order by PUBLICATION_DATE ASC;
    
    drop view if exists AllELArticulos;   
    
    CREATE VIEW AllELArticulos
AS 
SELECT 
	ARTICLE_ID,
	EVENT_DATE,
	LOCATION_STREET,
	LOCATION_NEIGHB, 
    LOCATION_CITY, 
    LOCATION_STATE, 
    LOCATION_COUNTRY,
    ARTICLE_HEADER,
    ARTICLE_DESCRIPTION,
    ARTICLE_CONTENT,
    SIGN,
    CREATED_BY,
    LAST_UPDATED_BY
FROM
    articles where ARTICLE_STATUS = "EL"
    order by ARTICLE_ID ASC;

CREATE VIEW DatosUsuarios
AS 
SELECT 
	USER_ALIAS,
	`NAME`, 
    FIRST_LAST_NAME, 
    SECOND_LAST_NAME, 
    EMAIL,
    PHONE_NUMBER,
    BIRTHDAY,
    USER_TYPE,
    PROFILE_PICTURE
FROM
    users;
    
    select * from DatosUsuarios;
    
Create View passwordsRE -- view para cuando se requiera la contraseña para hacer un cambio en el perfil de los Reporteros.
AS
SELECT
ID_USER,
USER_ALIAS,
CREDENTIAL
from users
where USER_TYPE = "RE";

Create View passwordsAD-- view para cuando se requiera la contraseña para hacer un cambio en el perfil de los Administradores.
AS
SELECT
ID_USER,
USER_ALIAS,
CREDENTIAL
from users
where USER_TYPE = "AD";

Create View passwordsUR -- view para cuando se requiera la contraseña para hacer un cambio en el perfil de los Usuarios.
AS
SELECT
ID_USER,
USER_ALIAS,
CREDENTIAL
from users
where USER_TYPE = "UR";

Create View CategONC -- view para cuando se requiera la contraseña para hacer un cambio en el perfil de los Usuarios.
AS
SELECT
`ORDER`,
CATEGORY_NAME,
COLOR
from categories
order by `ORDER` ASC;

Create View LastCategInQ
As
select * from CategONC ORDER BY `ORDER` DESC LIMIT 1;

Create View ActiveUsers
As
select ID_USER,
		USER_ALIAS,
        USER_STATUS
 from users ORDER BY ID_USER asc;
 
 Create view NumberOfArticles
 as
 select COUNT(*) as num from AllArticulos;
 
 Create view NumberOfArticlesRR
 as
 select COUNT(*) as num from allrrarticulos;
 
 Create view NumberOfArticlesRA
 as
 select COUNT(*) as num from allraarticulos;
 
 Create view NumberOfArticlesPU
 as
 select COUNT(*) as num from allpuarticulos;
 
 Create view NumberOfArticlesEL
 as
 select COUNT(*) as num from allelarticulos;

select * from CategONC;
select * from passwordsUR;
select * from passwordsRE;
select* from passwordsAD;
select * from LastCategInQ;
select* from ActiveUsers;
select* from NumberOfArticles;
select * from AllArticulos;


    