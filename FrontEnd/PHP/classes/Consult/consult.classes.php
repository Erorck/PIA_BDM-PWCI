<?php
include "../classes/dbh.classes.php";

class Consults extends Dbh
{


    protected function getJournalists()
    {
        $stmt = $this->connect()->prepare('CALL sp_User("SJS", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
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
        $stmt = $this->connect()->prepare('CALL sp_User("SURS", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
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
        $stmt = $this->connect()->prepare('CALL sp_News_Reports("SAFR", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?);');
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

    protected function getReport($reportId)
    {
        if ($reportId == 0) {
            session_start();
            if (isset($_SESSION['c_report']))
                return $_SESSION['c_report'];
            else
                return -1;
        }
        $stmt = $this->connect()->prepare('CALL sp_News_Reports("SOI", ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
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

    protected function getAllNews() {
        $stmt = $this->connect()->prepare('CALL sp_News_Reports("SAP", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
        
        if(!$stmt->execute()){
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

    protected function getSearchedNewsWithFilters($querySearch, $dateMin, $dateMax){
        $stmt = $this->connect()->prepare('CALL sp_Search_News(NULL, ?, ?, ?, NULL, NULL);');
        
        if(!$stmt->execute(array($querySearch, $dateMin, $dateMax))){
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
        $stmt = $this->connect()->prepare('CALL sp_Section("SAA", NULL, NULL, NULL, NULL, NULL);');
        if (!$stmt->execute()) {
            $stmt = null;
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
        $stmt = $this->connect()->prepare('CALL sp_Section("SAE", NULL, NULL, NULL, NULL, NULL);');
        if (!$stmt->execute()) {
            $stmt = null;
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
        $stmt = $this->connect()->prepare("CALL sp_News_Categories('SSR', NULL, ?, NULL)");

        session_start();
        if ($reportId == 0) {
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

            $_SESSION["o_sections"] = $sections;
        } else {
            return 0;
        }

        $stmt = null;
        return $sections;
    }

    protected function getAllTags()
    {
        $stmt = $this->connect()->prepare('CALL sp_Tags("SAA", NULL);');
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
        $stmt = $this->connect()->prepare("CALL sp_News_Tags('STR', NULL, ?, NULL)");
        session_start();

        if ($reportId == 0) {
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

            $_SESSION["o_tags"] = $tags;
        } else {
            return 0;
        }

        $stmt = null;
        return $tags;
    }

    protected function retrieveAllImagesFromReport($reportId)
    {
        $stmt = $this->connect()->prepare("CALL sp_Images('SIR', NULL, NULL, ?)");
        session_start();
        if ($reportId == 0) {
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

            $_SESSION["o_images"] = $images;
        } else {
            return 0;
        }

        $stmt = null;
        return $images;
    }

    protected function retrieveAllVideosFromReport($reportId)
    {
        $stmt = $this->connect()->prepare("CALL sp_Videos('SVR', NULL, NULL, ?)");

        session_start();
        if ($reportId == 0) {
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
            $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION["o_videos"] = $videos;
        } else {
            return 0;
        }

        $stmt = null;
        return $videos;
    }
}
