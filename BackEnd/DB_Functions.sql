use notipapa_db;
SET GLOBAL log_bin_trust_function_creators = 1;
DELIMITER //
drop function if exists GetLastOrderFromCateg//
CREATE FUNCTION GetLastOrderFromCateg ( lastorder int)
RETURNS INT
BEGIN
	if lastorder is null then
	set @ordertoinsert = 0;
	else 
	set @ordertoinsert = lastorder + 1;
	end if;
	RETURN @ordertoinsert;
END//
DELIMITER ;