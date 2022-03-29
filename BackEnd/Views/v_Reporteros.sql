
USE GOOD_OLD_TIMES_DB;

DROP VIEW IF EXISTS v_Journalists_Small;
CREATE VIEW v_Journalists_Small 
AS SELECT `ID_USER` AS ID_JOURNALIST, `FULL_NAME` AS JOURNALIST_NAME, `USER_ALIAS` AS JOURNALIST_ALIAS, `USER_STATUS` AS JOURNALIST_STATUS, `PROFILE_PICTURE` AS JOURNALIST_ICON
FROM USERS
WHERE `USER_TYPE` = 'R';

DROP VIEW IF EXISTS v_Registered_Users_Small;
CREATE VIEW v_Registered_Users_Small 
AS SELECT `ID_USER` AS ID_USER, `FULL_NAME` AS USER_NAME, `USER_ALIAS` AS USER_ALIAS, `USER_STATUS` AS USER_STATUS, `PROFILE_PICTURE` AS USER_ICON
FROM USERS
WHERE `USER_TYPE` = 'UR';