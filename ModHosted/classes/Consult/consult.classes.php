<?php
include "../classes/dbh.classes.php";

class Consults extends Dbh
{


    protected function getJournalists()
    {
        $stmt = $this->connect()->prepare('SELECT `ID_USER` AS ID_JOURNALIST, `FULL_NAME` AS JOURNALIST_NAME, `USER_ALIAS` AS JOURNALIST_ALIAS, `USER_STATUS` AS JOURNALIST_STATUS, `PROFILE_PICTURE` AS JOURNALIST_ICON
        FROM USERS
        WHERE `USER_TYPE` = \'R\';');

        if (!$stmt->execute()) {
            $stmt = null;
            header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            session_start();
            $journalists = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["journalists"] = $journalists;
        } else {
            return 0;
        }

        $stmt = null;
        return $journalists;
    }

    protected function getRUsers()
    {
        $stmt = $this->connect()->prepare('SELECT `ID_USER` AS ID_USER, `FULL_NAME` AS USER_NAME, `USER_ALIAS` AS USER_ALIAS, `USER_STATUS` AS USER_STATUS, `PROFILE_PICTURE` AS USER_ICON
        FROM USERS
        WHERE `USER_TYPE` = \'UR\';');

        if (!$stmt->execute()) {
            $stmt = null;
            header("location: ../Pages/Perfil_Usuario.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            session_start();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["r_users"] = $users;
        } else {
            return 0;
        }

        $stmt = null;
        return $users;
    }

    protected function getNewsFromJournalist($journalistId)
    {
        $stmt = $this->connect()->prepare('SELECT NR.`REPORT_ID` AS REPORT_NUMBER, NR.`SIGN` AS AUTOR_SIGN, 
        NR.`LOCATION_STREET` AS EVENT_STREET, NR.`LOCATION_NEIGHB` AS EVENT_NEIGHBOURHOOD, NR.`LOCATION_CITY` AS EVENT_CITY, NR.`LOCATION_COUNTRY` AS EVENT_COUNTRY, NR.`REPORT_HEADER` AS HEADER, NR.`REPORT_DESCRIPTION`, NR.`REPORT_CONTENT` AS CONTENT, NR.`LIKES`, NR.`THUMBNAIL`,
        NR.EVENT_DATE, NR.`PUBLICATION_DATE`, NR.`CREATION_DATE`, NR.`CREATED_BY` AS CREATED_BY_ID, UCR.`FULL_NAME` AS CREATED_BY_NAME, 
        NR.`LAST_UPDATE_DATE`, NR.`LAST_UPDATED_BY` AS UPDATED_BY_ID, UUP.`FULL_NAME` AS UPDATED_BY_NAME, `REPORT_STATUS` 
        FROM NEWS_REPORTS NR
        JOIN USERS UCR
        ON UCR.ID_USER = NR.CREATED_BY
        JOIN USERS UUP
        ON UUP.ID_USER = NR.LAST_UPDATED_BY
        WHERE NR.REPORT_STATUS IN (\'RA\', \'RR\', \'P\') AND NR.CREATED_BY = ? 
        ORDER BY NR.CREATION_DATE DESC, NR.REPORT_HEADER ASC;');

        if (!$stmt->execute(array($journalistId))) {
            $stmt = null;
            header("location: ../Pages/Perfil_Reportero.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["o_news"] = $news;
        } else {
            return 0;
        }

        $stmt = null;
        return $news;
    }

    protected function getNewsForEditor()
    {
        $stmt = $this->connect()->prepare('SELECT NR.`REPORT_ID` AS REPORT_NUMBER, NR.`SIGN` AS AUTOR_SIGN, 
        NR.`LOCATION_STREET` AS EVENT_STREET, NR.`LOCATION_NEIGHB` AS EVENT_NEIGHBOURHOOD, NR.`LOCATION_CITY` AS EVENT_CITY, NR.`LOCATION_COUNTRY` AS EVENT_COUNTRY, NR.`REPORT_HEADER` AS HEADER, NR.`REPORT_DESCRIPTION`, NR.`REPORT_CONTENT` AS CONTENT, NR.`LIKES`, NR.`THUMBNAIL`,
        NR.EVENT_DATE, NR.`PUBLICATION_DATE`, NR.`CREATION_DATE`, NR.`CREATED_BY` AS CREATED_BY_ID, UCR.`FULL_NAME` AS CREATED_BY_NAME, 
        NR.`LAST_UPDATE_DATE`, NR.`LAST_UPDATED_BY` AS UPDATED_BY_ID, UUP.`FULL_NAME` AS UPDATED_BY_NAME, `REPORT_STATUS` 
        FROM NEWS_REPORTS NR
        JOIN USERS UCR
        ON UCR.ID_USER = NR.CREATED_BY
        JOIN USERS UUP
        ON UUP.ID_USER = NR.LAST_UPDATED_BY
        WHERE NR.REPORT_STATUS IN (\'RA\')
		ORDER BY NR.CREATION_DATE DESC, NR.REPORT_HEADER ASC;');

        if (!$stmt->execute(array())) {
            $stmt = null;
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["o_r_news"] = $news;
        } else {
            return 0;
        }

        $stmt = null;
        return $news;
    }

    protected function getReport($reportId)
    {
        if ($reportId == 0) {
            session_start();
            if (isset($_SESSION['c_report']))
                return $_SESSION['c_report'];
            else
                return -1;
        }
        $stmt = $this->connect()->prepare('SELECT NR.`REPORT_ID` AS REPORT_NUMBER, NR.`SIGN` AS AUTOR_SIGN, 
        NR.`LOCATION_STREET` AS EVENT_STREET, NR.`LOCATION_NEIGHB` AS EVENT_NEIGHBOURHOOD, NR.`LOCATION_CITY` AS EVENT_CITY, NR.`LOCATION_COUNTRY` AS EVENT_COUNTRY, NR.`REPORT_HEADER` AS HEADER, NR.`REPORT_DESCRIPTION`, NR.`REPORT_CONTENT` AS CONTENT, NR.`LIKES`, NR.`THUMBNAIL`,
        NR.EVENT_DATE, NR.`PUBLICATION_DATE`, NR.`CREATION_DATE`, NR.`CREATED_BY` AS CREATED_BY_ID, UCR.`FULL_NAME` AS CREATED_BY_NAME, 
        NR.`LAST_UPDATE_DATE`, NR.`LAST_UPDATED_BY` AS UPDATED_BY_ID, UUP.`FULL_NAME` AS UPDATED_BY_NAME, `REPORT_STATUS` 
        FROM NEWS_REPORTS NR
        JOIN USERS UCR
        ON UCR.ID_USER = NR.CREATED_BY
        JOIN USERS UUP
        ON UUP.ID_USER = NR.LAST_UPDATED_BY      
        WHERE `REPORT_ID` = ?;');

        if (!$stmt->execute(array($reportId))) {
            $stmt = null;
            header("location: ../Pages/Perfil_Reportero.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $report = $stmt->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION["c_report"] = $report;
        } else {
            return 0;
        }

        $stmt = null;
        return $report;
    }

    protected function getLikesReport($oper, $fechamin, $fechamax, $categoryId)
    {
        $cmd = '';
        if($oper == 'N')
            $cmd = 'SELECT `CATEGORY_NAME`, `PUBLICATION_DATE`,`REPORT_HEADER`, 
            `LIKES`, `COMMENTS`
            FROM CATEGORIES CS
            JOIN NEWS_CATEGORIES NCTG
            ON NCTG.CATEGORY = CS.CATEGORY_ID
            JOIN NEWS_REPORTS NSR
            ON NCTG.REPORT_ID = NSR.REPORT_ID
            WHERE if(? IS NULL OR ? = 0, 1, CATEGORY_NAME = ?)
            AND if (? IS NULL, 1, `PUBLICATION_DATE` >=  ?)
            AND if (? IS NULL, 1, `PUBLICATION_DATE` <= ?)
            AND `REPORT_STATUS` = \'P\'
            GROUP BY REPORT_HEADER
            ORDER BY LIKES DESC;';
        else if($oper == 'S')
            $cmd = 'SELECT `CATEGORY_NAME`, MONTH(`PUBLICATION_DATE`) AS MES, YEAR(`PUBLICATION_DATE`) AS ANIO,   
            SUM(NSR.LIKES) AS LIKES_CTG, SUM(NSR.COMMENTS) AS COMMENTS_CTG
            FROM CATEGORIES CS
            JOIN NEWS_CATEGORIES NCTG
            ON NCTG.CATEGORY = CS.CATEGORY_ID
            JOIN NEWS_REPORTS NSR
            ON NCTG.REPORT_ID = NSR.REPORT_ID
            WHERE if(categoryT IS NULL OR categoryT = 0, 1, CATEGORY_NAME = categoryT)
            AND if (fechaMinT IS NULL, 1, `PUBLICATION_DATE` >=  fechaMinT)
            AND if (fechaMaxT IS NULL, 1, `PUBLICATION_DATE` <= fechaMaxT)
            AND `REPORT_STATUS` = \'P\'
            GROUP BY CATEGORY_NAME
            ORDER BY LIKES_CTG DESC;';

       
        $stmt = $this->connect()->prepare($cmd);
        if (!$stmt->execute(array($categoryId, $categoryId, $categoryId, $fechamin, $fechamin, $fechamax, $fechamax))) {
            $stmt = null;
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $report = $stmt->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION["o_likes_report"] = $report;
        } else {
            return 0;
        }

        $stmt = null;
        return $report;
    }

    protected function getAllNews()
    {
        $stmt = $this->connect()->prepare('SELECT NR.`REPORT_ID` AS REPORT_NUMBER, NR.`SIGN` AS AUTOR_SIGN, 
        NR.`LOCATION_STREET` AS EVENT_STREET, NR.`LOCATION_NEIGHB` AS EVENT_NEIGHBOURHOOD, NR.`LOCATION_CITY` AS EVENT_CITY, NR.`LOCATION_COUNTRY` AS EVENT_COUNTRY, NR.`REPORT_HEADER` AS HEADER, NR.`REPORT_DESCRIPTION`, NR.`REPORT_CONTENT` AS CONTENT, NR.`LIKES`, NR.`THUMBNAIL`,
        NR.EVENT_DATE, NR.`PUBLICATION_DATE`, NR.`CREATION_DATE`, NR.`CREATED_BY` AS CREATED_BY_ID, UCR.`FULL_NAME` AS CREATED_BY_NAME, 
        NR.`LAST_UPDATE_DATE`, NR.`LAST_UPDATED_BY` AS UPDATED_BY_ID, UUP.`FULL_NAME` AS UPDATED_BY_NAME, `REPORT_STATUS` 
        FROM NEWS_REPORTS NR
        JOIN USERS UCR
        ON UCR.ID_USER = NR.CREATED_BY
        JOIN USERS UUP
        ON UUP.ID_USER = NR.LAST_UPDATED_BY
        WHERE REPORT_STATUS = \'P\'
		ORDER BY EVENT_DATE DESC, REPORT_HEADER ASC;  ');

        if (!$stmt->execute()) {
            $stmt = null;
            header("location: ../Pages/Crear_noticia.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // $_SESSION["o_news"] = $news;
        } else {
            return 0;
        }

        $stmt = null;
        return $news;
    }

    protected function getSearchedNewsWithFilters($querySearch, $dateMin, $dateMax)
    {
        $stmt = $this->connect()->prepare('SELECT NR.`REPORT_ID` AS REPORT_NUMBER, NR.`SIGN` AS AUTOR_SIGN, 
        NR.`LOCATION_STREET` AS EVENT_STREET, NR.`LOCATION_NEIGHB` AS EVENT_NEIGHBOURHOOD, NR.`LOCATION_CITY` AS EVENT_CITY, NR.`LOCATION_COUNTRY` AS EVENT_COUNTRY, NR.`REPORT_HEADER` AS HEADER, NR.`REPORT_DESCRIPTION`, NR.`REPORT_CONTENT` AS CONTENT, NR.`LIKES`, NR.`THUMBNAIL`,
        NR.EVENT_DATE, NR.`PUBLICATION_DATE`, NR.`CREATION_DATE`, NR.`CREATED_BY` AS CREATED_BY_ID, UCR.`FULL_NAME` AS CREATED_BY_NAME, 
        NR.`LAST_UPDATE_DATE`, NR.`LAST_UPDATED_BY` AS UPDATED_BY_ID, UUP.`FULL_NAME` AS UPDATED_BY_NAME, `REPORT_STATUS` 
        FROM NEWS_REPORTS NR
        JOIN USERS UCR
        ON UCR.ID_USER = NR.CREATED_BY
        JOIN USERS UUP
        ON UUP.ID_USER = NR.LAST_UPDATED_BY
        WHERE if(? IS NULL OR ? = \'\', 1, (REPORT_HEADER LIKE concat(\'%\', ?,\'%\') OR REPORT_DESCRIPTION LIKE concat(\'%\', ?,\'%\') OR LOCATION_CITY LIKE concat(\'%\', ?,\'%\') OR LOCATION_COUNTRY LIKE concat(\'%\', ?,\'%\')))
        AND if (? IS NULL, 1, DATE(EVENT_DATE) >= ?)
        AND if (? IS NULL, 1, DATE(EVENT_DATE) <= ?)
        AND REPORT_STATUS = \'P\'
        ORDER BY EVENT_DATE, REPORT_HEADER ASC;');

        if (!$stmt->execute(array($querySearch, $querySearch, $querySearch, $querySearch, $querySearch, $dateMin, $dateMin, $dateMax, $dateMax))) {
            $stmt = null;
            header("location: ../Pages/Crear_noticia.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // $_SESSION["o_news"] = $news;
        } else {
            return 0;
        }

        $stmt = null;
        return $news;
    }

    protected function getAllActiveSections()
    {
        $sections = 'secciones';

        $stmt = $this->connect()->prepare('SELECT CTG.`CATEGORY_ID` AS SECTION_ID, CTG.`CATEGORY_NAME` AS SECTION_NAME, CTG.`COLOR` AS DISPLAY_COLOR, CTG.`ORDER` AS DISPLAY_ORDER, CTG.`CREATION_DATE`, CTG.`CREATED_BY` AS CREATED_BY_ID, UCR.`FULL_NAME` AS CREATED_BY_NAME, CTG.`LAST_UPDATE_DATE`, CTG.`LAST_UPDATED_BY` AS UPDATED_BY_ID, UUP.`FULL_NAME` AS UPDATED_BY_NAME, CTG.`SECTION_STATUS`
        FROM CATEGORIES CTG
        JOIN USERS UCR
        ON UCR.ID_USER = CTG.CREATED_BY
        JOIN USERS UUP
        ON UUP.ID_USER = CTG.LAST_UPDATED_BY
        WHERE CTG.`SECTION_STATUS` = \'A\'
        ORDER BY CTG.`ORDER`, CTG.CATEGORY_NAME ASC;');

        if (!$stmt->execute()) {
            $stmt = null;
            return 'no se ejecuto';
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            session_start();
            $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["a_sections"] = $sections;
        } else {
            return 0;
        }

        $stmt = null;
        return $sections;
    }

    protected function getAllEliminatedSections()
    {
        $stmt = $this->connect()->prepare('SELECT CTG.`CATEGORY_ID` AS SECTION_ID, CTG.`CATEGORY_NAME` AS SECTION_NAME, CTG.`COLOR` AS DISPLAY_COLOR, CTG.`ORDER` AS DISPLAY_ORDER, CTG.`CREATION_DATE`, CTG.`CREATED_BY` AS CREATED_BY_ID, UCR.`FULL_NAME` AS CREATED_BY_NAME, CTG.`LAST_UPDATE_DATE`, CTG.`LAST_UPDATED_BY` AS UPDATED_BY_ID, UUP.`FULL_NAME` AS UPDATED_BY_NAME, CTG.`SECTION_STATUS`
        FROM CATEGORIES CTG
        JOIN USERS UCR
        ON UCR.ID_USER = CTG.CREATED_BY
        JOIN USERS UUP
        ON UUP.ID_USER = CTG.LAST_UPDATED_BY
        WHERE CTG.`SECTION_STATUS` = \'E\'
        ORDER BY CTG.CATEGORY_NAME ASC;');

        if (!$stmt->execute()) {
            $stmt = null;
            return 'no se ejecuto';
            header("location: ../Pages/Perfil_Editor.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            session_start();
            $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["e_sections"] = $sections;
        } else {
            return 0;
        }

        $stmt = null;
        return $sections;
    }

    protected function retrieveAllCtgsFromReport($reportId)
    {
        $stmt = $this->connect()->prepare("SELECT CTG.`CATEGORY_ID`, CTG.`CATEGORY_NAME`, CTG.`COLOR`, NR.`REPORT_ID` AS REPORT_NUMBER, NR.`SIGN` AS AUTOR_SIGN, NR.`LOCATION_STREET` AS EVENT_STREET, NR.`LOCATION_NEIGHB` AS EVENT_NEIGHBOURHOOD, NR.`LOCATION_CITY` AS EVENT_CITY, NR.`LOCATION_COUNTRY` AS EVENT_COUNTRY, NR.`REPORT_HEADER` AS HEADER, NR.`REPORT_DESCRIPTION`, NR.`REPORT_CONTENT` AS CONTENT, NR.`LIKES`, NR.`THUMBNAIL`, NR.EVENT_DATE, NR.`PUBLICATION_DATE`, NR.`CREATION_DATE`, NR.`CREATED_BY` AS CREATED_BY_ID, UCR.`FULL_NAME` AS CREATED_BY_NAME, NR.`LAST_UPDATE_DATE`, NR.`LAST_UPDATED_BY` AS UPDATED_BY_ID, UUP.`FULL_NAME` AS UPDATED_BY_NAME, `REPORT_STATUS`
        FROM NEWS_CATEGORIES NCTG
        JOIN CATEGORIES CTG
        ON NCTG.CATEGORY = CTG.CATEGORY_ID
        JOIN NEWS_REPORTS NR
        ON NCTG.REPORT_ID = NR.REPORT_ID
        JOIN USERS UCR
        ON UCR.ID_USER = NR.CREATED_BY
        JOIN USERS UUP
        ON UUP.ID_USER = NR.LAST_UPDATED_BY
        WHERE NR.REPORT_ID = ?;");

        if ($reportId == 0) {
            session_start();
            if (isset($_SESSION['c_report'])) {
                $report = $_SESSION['c_report'];
                $reportId = $report[0]['REPORT_NUMBER'];
            }
        }

        if (!$stmt->execute(array($reportId))) {
            $stmt = null;
            header("location:../Pages/Inicio.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() > 0) {
            $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!isset($_SESSION['user']))
                session_start();

            $_SESSION["o_sections"] = $sections;
        } else {
            return 0;
        }

        $stmt = null;
        return $sections;
    }

    protected function getAllTags()
    {
        $stmt = $this->connect()->prepare('SELECT `TAG_NAME`, `TAG_STATUS` AS `STATUS`
        FROM TAGS
        WHERE `TAG_STATUS` = \'EU\'
        ORDER BY TAG_NAME ASC;');

        if (!$stmt->execute()) {
            $stmt = null;
            header("location: ../Pages/Crear_noticia.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            session_start();
            $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["a_tags"] = $tags;
        } else {
            return 0;
        }

        $stmt = null;
        return $tags;
    }

    protected function retrieveAllTagsFromReport($reportId)
    {
        $stmt = $this->connect()->prepare("SELECT T.`TAG_NAME`, T.`TAG_STATUS`, NR.`REPORT_ID` AS REPORT_NUMBER, NR.`SIGN` AS AUTOR_SIGN, NR.`LOCATION_STREET` AS EVENT_STREET, NR.`LOCATION_NEIGHB` AS EVENT_NEIGHBOURHOOD, NR.`LOCATION_CITY` AS EVENT_CITY, NR.`LOCATION_COUNTRY` AS EVENT_COUNTRY, NR.`REPORT_HEADER` AS HEADER, NR.`REPORT_DESCRIPTION`, NR.`REPORT_CONTENT` AS CONTENT, NR.`LIKES`, NR.`THUMBNAIL`, NR.EVENT_DATE, NR.`PUBLICATION_DATE`, NR.`CREATION_DATE`, NR.`CREATED_BY` AS CREATED_BY_ID, UCR.`FULL_NAME` AS CREATED_BY_NAME, NR.`LAST_UPDATE_DATE`, NR.`LAST_UPDATED_BY` AS UPDATED_BY_ID, UUP.`FULL_NAME` AS UPDATED_BY_NAME, `REPORT_STATUS`
        FROM NEWS_TAGS NTG
        JOIN TAGS T
        ON NTG.TAG = T.TAG_NAME
        JOIN NEWS_REPORTS NR
        ON NTG.REPORT_ID = NR.REPORT_ID
        JOIN USERS UCR
        ON UCR.ID_USER = NR.CREATED_BY
        JOIN USERS UUP
        ON UUP.ID_USER = NR.LAST_UPDATED_BY
        WHERE NTG.REPORT_ID = ?;");

        if ($reportId == 0) {
            session_start();
            if (isset($_SESSION['c_report'])) {
                $report = $_SESSION['c_report'];
                $reportId = $report[0]['REPORT_NUMBER'];
            }
        }

        if (!$stmt->execute(array($reportId))) {
            $stmt = null;
            header("location:../Pages/Inicio.php?error=stmtfailed");
            exit();
        }


        if ($stmt->rowCount() > 0) {
            $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!isset($_SESSION['user']))
                session_start();

            $_SESSION["o_tags"] = $tags;
        } else {
            return 0;
        }

        $stmt = null;
        return $tags;
    }

    protected function retrieveAllImagesFromReport($reportId)
    {
        $stmt = $this->connect()->prepare("SELECT `ID_IMAGE`, `CONTENT`, `REPORT_ID`
        FROM IMAGES
        WHERE REPORT_ID = ?;");

        if ($reportId == 0) {
            session_start();
            if (isset($_SESSION['c_report'])) {
                $report = $_SESSION['c_report'];
                $reportId = $report[0]['REPORT_NUMBER'];
            }
        }

        if (!$stmt->execute(array($reportId))) {
            $stmt = null;
            header("location:../Pages/Crear_noticia.php?error=stmtfailed");
            exit();
        }


        if ($stmt->rowCount() > 0) {
            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!isset($_SESSION['user']))
                session_start();
            $_SESSION["o_images"] = $images;
        } else {
            return 0;
        }

        $stmt = null;
        return $images;
    }

    protected function retrieveAllVideosFromReport($reportId)
    {
        $stmt = $this->connect()->prepare("SELECT `ID_VIDEO`, `CONTENT`, `REPORT_ID`
        FROM VIDEOS
        WHERE REPORT_ID = ?;");

        if ($reportId == 0) {
            session_start();
            if (isset($_SESSION['c_report'])) {
                $report = $_SESSION['c_report'];
                $reportId = $report[0]['REPORT_NUMBER'];
            }
        }

        if (!$stmt->execute(array($reportId))) {
            $stmt = null;
            header("location:../Pages/Crear_noticia.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() > 0) {
            if (!isset($_SESSION['user']))
                session_start();

            $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["o_videos"] = $videos;
        } else {
            return 0;
        }

        $stmt = null;
        return $videos;
    }

    protected  function getCommentsByReport($reportId){

        $stmt = $this->connect()->prepare('SELECT `COMMENTS`.`COMMENT_ID`,
        `COMMENTS`.`COMMENT_TEXT`,
        `COMMENTS`.`CREATION_DATE`,
        `COMMENTS`.`CREATED_BY`,
        `COMMENTS`.`LAST_UPDATE_DATE`,
        `COMMENTS`.`LAST_UPDATED_BY`,
        `COMMENTS`.`COMMENT_STATUS`,
        `COMMENTS`.`REPORT_ID`,
        `USERS`.`USER_ALIAS`,
        `USERS`.`PROFILE_PICTURE`,
        `USERS`.`USER_TYPE`
        FROM `COMMENTS`
        INNER JOIN `USERS` ON `USERS`.`ID_USER` = `COMMENTS`.`CREATED_BY`            
        WHERE `REPORT_ID`= ? AND `USER_TYPE` IN (\'UR\', \'R\')               
        AND `COMMENT_STATUS` = \'P\'
        ORDER BY CREATION_DATE DESC;');

        if (!$stmt->execute(array($reportId))) {
            $stmt = null;
            header("location: ../Pages/Crear_noticia.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            
        } else {
            return array();
        }

        $stmt = null;
        return $comments;
    }
}
