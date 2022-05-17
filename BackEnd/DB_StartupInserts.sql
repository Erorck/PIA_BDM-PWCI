use NOTIPAPA_DB;
-- VACIAMOS TABLA DE USUARIO Y RESETEAMOS IDENTIDAD, LUEGO PONEMOS EL ADMINISTRADOR (y un reportero, aunque el administrador puede dar de alta mas reporteros)
SET SQL_SAFE_UPDATES = 0;
DELETE FROM users ;
SET SQL_SAFE_UPDATES = 1;
ALTER TABLE users AUTO_INCREMENT = 1;
CALL sp_User_Insert('I','AD','LaCreaTura','Qwertyuiop1!','Jorge','Clarin','Guerra','jorge.guerra@gmail.com','818181818181','2022-05-05',0,null); -- Administrador
CALL sp_User_Insert('I','RE','ElGoblino','Asdfghjkl1!','Ramon','Valdez','Figeroa','jitachiuchiha6@gmail.com','810000000000','2022-05-05',1,null); -- Reportero

SET SQL_SAFE_UPDATES = 0;
DELETE FROM categories ;
SET SQL_SAFE_UPDATES = 1;

SET SQL_SAFE_UPDATES = 0;
DELETE FROM videos ;
DELETE FROM images ;
DELETE FROM articles ;
SET SQL_SAFE_UPDATES = 1;
ALTER TABLE videos AUTO_INCREMENT = 1;
ALTER TABLE images AUTO_INCREMENT = 1;
ALTER TABLE articles AUTO_INCREMENT = 1;

-- selects De todas las tablas para comprobar la info 
select *from articles; 
select *from categories; 
select *from comments; 
select *from feedbacks; 
select *from images; 
select *from news_categories; 
select *from news_comments; 
select *from news_feedbacks; 
select *from news_tags; 
select *from tags; 
select *from reactions; 
select *from users; 
select *from videos; 



