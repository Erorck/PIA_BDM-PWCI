<?php 

include "news_comts.classes.php";

class News_CommentsContr extends News_Comments {
    private $commentId;
    private $commentText;
    private $reportId;
    private $updated_by;

    public function __construct(){}

    public static function withId($commentId, $reportId, $updated_by){
        $instance = new self();
        $instance->fillWithId($commentId, $reportId, $updated_by);
        return $instance;
    }

    public static function withInfo($commentText, $reportId, $updated_by){
        $instance = new self();
        $instance->fillWithInfo($commentText, $reportId, $updated_by);
        return $instance;
    }

    protected function fillWithId($commentId, $reportId, $updated_by){
        $this->commentId = $commentId;
        $this->reportId = $reportId;
        $this->updated_by = $updated_by;
    }

    protected function fillWithInfo($commentText, $reportId, $updated_by){
        $this->commentText = $commentText;
        $this->reportId = $reportId;
        $this->updated_by = $updated_by;
    }

    public function getCommentsByReportId($reportId){    
        return $this->getCommentsByReport($reportId);
    }

    public function getEditorCommentByReportId($reportId){    
        return $this->getEditorComment($reportId);
    }

    public function insert(){
        $this->insertComment($this->commentText, $this->reportId, $this->updated_by);
    }


}