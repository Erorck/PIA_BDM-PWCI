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

select * from CategONC;
select * from passwordsUR;
select * from passwordsRE;
select* from passwordsAD;
select * from LastCategInQ;
select* from ActiveUsers;


    