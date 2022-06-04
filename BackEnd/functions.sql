USE GOOD_OLD_TIMES_DB;
DELIMITER //
DROP FUNCTION IF EXISTS beautifyDatetimeLarge//
CREATE FUNCTION beautifyDatetimeLarge (d DATETIME)
RETURNS CHAR(70) DETERMINISTIC
BEGIN	
       RETURN DATE_FORMAT( d, '%a %e %M %Y, %H:%i');	
END;

DROP FUNCTION IF EXISTS beautifyDatetimeSmall//
CREATE FUNCTION beautifyDatetimeSmall (d DATETIME)
RETURNS CHAR(40) DETERMINISTIC
BEGIN
       RETURN DATE_FORMAT( d, '%M %e %Y');
END;

DROP FUNCTION IF EXISTS plceholderName//
CREATE FUNCTION plceholderName (n VARCHAR(100))
RETURNS CHAR(100) DETERMINISTIC
BEGIN
       SELECT REPLACE(n, ' ', '_') INTO @temp;
       RETURN CONCAT('¿Buscamos_algo_', @temp,'_?');
END;
