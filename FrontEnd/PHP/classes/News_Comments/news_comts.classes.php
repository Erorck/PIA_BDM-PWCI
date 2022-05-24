<?php 

class News_Comments extends Dbh {


    protected  function getCommentsByReport($reportId){
        $stmt = $this->connect()->prepare('call sp_News_Comments("SPC", NULL, NULL, ?, NULL);');
        if (!$stmt->execute(array($reportId))) {
            $stmt = null;
            header("location: ../Pages/Crear_noticia.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // foreach($comments as &$comment){
            //     if(isset($comment["PROFILE_PICTURE"])){
            //         $comment["PROFILE_PICTURE"] = $comment["PROFILE_PICTURE"] != NULL ? "data:image/png;base64,".base64_encode($comment["PROFILE_PICTURE"]) : "";
            //     } else {
            //         $comment["PROFILE_PICTURE"] = "";
            //     }
            // }
            
        } else {
            return array();
        }

        $stmt = null;
        return $comments;
    }

    protected function getEditorComment($reportId){
        $stmt = $this->connect()->prepare('call sp_News_Comments("SCFE", NULL, NULL, ?, NULL);');

        $comment = 0;

        if ($reportId == 0) {
            session_start();
            if (isset($_SESSION['c_report'])) {
                $report = $_SESSION['c_report'];
                $reportId = $report[0]['REPORT_NUMBER'];
            }
        }

        if (!$stmt->execute(array($reportId))) {
            $stmt = null;
            header("location: ../Pages/Revision_noticia.php?error=stmtFailed");
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $comment = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            
        } else {
            return 0;
        }

        $stmt = null;
        return $comment;
    }

    protected function insertComment($commentText, $reportId, $createdBy) {
        $stmt = $this->connect()->prepare('call sp_News_Comments("I", ?, NULL, ?, ?);');

        if(!$stmt->execute(array($commentText, $reportId, $createdBy))){
            $stmt = null;
            header("location: ../Pages/Inicio.php?error=stmtFailed");
            exit();
        }

        $stmt = null;

    }
}