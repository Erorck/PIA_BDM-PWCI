

DELIMITER //
DROP PROCEDURE IF EXISTS sp_Search_News;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Search_News`(
IN Oper char(4),
IN textoT VARCHAR(180),
IN fechaMinT DATE,
IN fechaMaxT DATE,
IN categoryT INT,
IN tagT varchar(50)
)
`sp_Search_News`:
BEGIN



SELECT `REPORT_NUMBER`, `AUTOR_SIGN`,
`EVENT_STREET`, `EVENT_NEIGHBOURHOOD`, `EVENT_CITY`, `EVENT_COUNTRY`,
`HEADER`, `REPORT_DESCRIPTION`, `CONTENT`, `LIKES`, `THUMBNAIL`, `EVENT_DATE`, `PUBLICATION_DATE`,
ND.CREATION_DATE, `CREATED_BY_ID`, `CREATED_BY_NAME`,
ND.LAST_UPDATE_DATE, `UPDATED_BY_ID`, `UPDATED_BY_NAME`, `REPORT_STATUS`
FROM v_news_detailed ND
WHERE if(textoT IS NULL OR textoT = '', 1, (HEADER LIKE concat('%', textoT,'%') OR REPORT_DESCRIPTION LIKE concat('%', textoT,'%') OR EVENT_CITY LIKE concat('%', textoT,'%') OR EVENT_COUNTRY LIKE concat('%', textoT,'%')))
AND if (fechaMinT IS NULL, 1, DATE(EVENT_DATE) >= fechaMinT)
AND if (fechaMaxT IS NULL, 1, DATE(EVENT_DATE) <= fechaMaxT)
AND REPORT_STATUS = 'P'
ORDER BY EVENT_DATE, HEADER ASC;
LEAVE `sp_Search_News`;


END